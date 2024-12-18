<?php
session_start();
include('koneksi_admin.php');

// Pastikan admin sudah login
if (!isset($_SESSION['admin'])){
    header('Location: login_admin.php');
    exit;
}

// Ambil id_user dari URL atau pilih semua user jika id_user tidak diberikan
$id_user = isset($_GET['id_user']) ? (int)$_GET['id_user'] : null;
$filter_ruang_lingkup = isset($_GET['filter_ruang_lingkup']) ? $_GET['filter_ruang_lingkup'] : null;
$limit = 10; // Batas data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query utama
$query = "SELECT * FROM hasil_penera";
if ($id_user || $filter_ruang_lingkup) {
    $query .= " WHERE";
    if ($id_user) {
        $query .= " iduser = :id_user";
        if ($filter_ruang_lingkup) $query .= " AND";
    }
    if ($filter_ruang_lingkup) {
        $query .= " ruang_lingkup = :ruang_lingkup";
    }
}
$query .= " ORDER BY id DESC LIMIT :offset, :limit";

$stmt = $pdo->prepare($query);
if ($id_user) $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
if ($filter_ruang_lingkup) $stmt->bindParam(':ruang_lingkup', $filter_ruang_lingkup, PDO::PARAM_STR);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

$stmt->execute();
$hasil = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil data user jika id_user diberikan
$userData = null;
if ($id_user) {
    $userQuery = "SELECT * FROM user WHERE iduser = :id_user";
    $userStmt = $pdo->prepare($userQuery);
    $userStmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $userStmt->execute();
    $userData = $userStmt->fetch(PDO::FETCH_ASSOC);
}

// Query untuk mengambil data dari tabel verifikasi_penera
$queryVerifikasi = "SELECT * FROM verifikasi_penera";
$stmtVerifikasi = $pdo->prepare($queryVerifikasi);
$stmtVerifikasi->execute();
$verifikasi = $stmtVerifikasi->fetchAll(PDO::FETCH_ASSOC);

// Hitung total data untuk pagination
$totalQuery = "SELECT COUNT(*) FROM hasil_penera";
if ($id_user || $filter_ruang_lingkup) {
    $totalQuery .= " WHERE";
    if ($id_user) {
        $totalQuery .= " id_user = :id_user";
        if ($filter_ruang_lingkup) $totalQuery .= " AND";
    }
    if ($filter_ruang_lingkup) {
        $totalQuery .= " ruang_lingkup = :ruang_lingkup";
    }
}

$totalStmt = $pdo->prepare($totalQuery);
if ($id_user) $totalStmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
if ($filter_ruang_lingkup) $totalStmt->bindParam(':ruang_lingkup', $filter_ruang_lingkup, PDO::PARAM_STR);
$totalStmt->execute();
$totalData = $totalStmt->fetchColumn();
$totalPages = ceil($totalData / $limit);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Hasil Negosiator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            background: rgba(33, 37, 41, 0.9);
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #00d084;
        }
        .navbar .nav-link {
            color: #e0e0e0;
            transition: color 0.3s ease;
        }
        .navbar .nav-link:hover {
            color: #ffffff;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            border: none;
            border-radius: 15px;
            background: #f8f9fa;
        }
        h2 {
            color: #ffffff;
            font-weight: bold;
        }
        .btn-info {
            background: #00d084;
            border: none;
            color: #ffffff;
            transition: all 0.3s ease;
        }
        .btn-info:hover {
            background: #00b37a;
        }
        .table th {
            background: #343a40;
            color: #ffffff;
            text-align: center;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background: #e3f2fd;
        }
        .table-striped tbody tr:nth-of-type(even) {
            background: #ffffff;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="bi bi-bar-chart-fill"></i> Admin Panel
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard_admin.php"><i class="bi bi-house-fill"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#"><i class="bi bi-people-fill"></i> Ruang Lingkup</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout_admin.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center mb-4">Hasil Perhitungan Penera</h2>

    <?php if ($id_user && $userData): ?>
        <h4 class="text-white text-center">Hasil untuk: <?php echo htmlspecialchars($userData['namainstansi']); ?> - <?php echo htmlspecialchars($userData['namainstansi']); ?></h4>
    <?php endif; ?>

    <!-- Tabel -->
    <div class="card p-4">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Ruang Lingkup</th>
                    <th>Deskripsi</th>
                    <th>Volume</th>
                    <th>Terampil</th>
                    <th>Mahir</th>
                    <th>Penyila</th>
                    <th>Pertama</th>
                    <th>Muda</th>
                    <th>Madya</th>
                    <th>Utama</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
    <?php if (count($hasil) > 0): ?>
        <?php foreach ($hasil as $index => $row): ?>
            <tr>
                <td><?php echo $offset + $index + 1; ?></td>
                <td><?php echo htmlspecialchars($row['ruang_lingkup']); ?></td>
                <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                <td><?php echo htmlspecialchars($row['volume']); ?></td>
                <td><?php echo number_format((float)$row['terampil'], 2); ?></td>
                <td><?php echo number_format((float)$row['mahir'], 2); ?></td>
                <td><?php echo number_format((float)$row['penyila'], 2); ?></td>
                <td><?php echo number_format((float)$row['pertama'], 2); ?></td>
                <td><?php echo number_format((float)$row['muda'], 2); ?></td>
                <td><?php echo number_format((float)$row['madya'], 2); ?></td>
                <td><?php echo number_format((float)$row['utama'], 2); ?></td>
                <td><?php echo htmlspecialchars($row['keterangan']); ?></td>
                <td class="d-flex">
                    <a href="edit_penera.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning me-2">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="13" class="text-center">Tidak ada data</td>
        </tr>
    <?php endif; ?>
</tbody>
        </table>

        <!-- Pagination -->
        <nav aria-label="Pagination">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($i === $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>

    <h2 class="text-center mt-5 text-white">Verifikasi Data</h2>
<div class="card p-4">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Ruang Lingkup</th>
                <th>Deskripsi</th>
                <th>Volume</th>
                <th>Terampil</th>
                <th>Mahir</th>
                <th>Penyila</th>
                <th>Pertama</th>
                <th>Muda</th>
                <th>Madya</th>
                <th>Utama</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
    <?php if (count($verifikasi) > 0): ?>
        <?php foreach ($verifikasi as $index => $row): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo htmlspecialchars($row['ruang_lingkup']); ?></td>
                <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                <td><?php echo htmlspecialchars($row['volume']); ?></td>
                <td><?php echo number_format((float)$row['terampil'], 2); ?></td>
                <td><?php echo number_format((float)$row['mahir'], 2); ?></td>
                <td><?php echo number_format((float)$row['penyila'], 2); ?></td>
                <td><?php echo number_format((float)$row['pertama'], 2); ?></td>
                <td><?php echo number_format((float)$row['muda'], 2); ?></td>
                <td><?php echo number_format((float)$row['madya'], 2); ?></td>
                <td><?php echo number_format((float)$row['utama'], 2); ?></td>
                <td><?php echo htmlspecialchars($row['keterangan']); ?></td>
                <td class="d-flex">
                    <a href="hapus_penera.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="13" class="text-center">Tidak ada data verifikasi</td>
        </tr>
    <?php endif; ?>
</tbody>
    </table>
</div>
</div>
<!-- Footer -->
<footer class="mt-auto bg-dark text-white text-center py-3">
    <p class="mb-0">© 2024 Admin Panel - Hasil Penera</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
