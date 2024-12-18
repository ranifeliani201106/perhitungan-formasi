<?php
// Menghubungkan ke file koneksi.php
include('koneksi_admin.php');
session_start(); // Memulai session untuk logout

// Cek apakah tombol logout diklik
if (isset($_GET['logout'])) {
    // Hapus session dan arahkan ke halaman login
    session_destroy();
    header("Location: login_admin.php"); // halaman login
    exit();
}

// Query untuk mengambil data dari tabel 'user' dengan role 'peserta' saja
$query = "SELECT * FROM user WHERE role = 'peserta'";
$stmt = $pdo->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Peserta</title>
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
                    <a class="nav-link active" href="#"><i class="bi bi-house-fill"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <!-- Tombol logout -->
                    <a class="nav-link" href="logout_admin.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center mb-4">Daftar Peserta</h2>

    <!-- Menampilkan data peserta -->
    <div class="card p-4">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Nama PIC</th>
                    <th>Nama Instansi</th>
                    <th>Daerah</th>
                    <th>No Telepon</th>
                    <th>Role</th>
                    <th>Halaman Jabatan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menampilkan data dari tabel 'user' dengan role 'peserta'
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['iduser'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['namapic'] . "</td>";
                    echo "<td>" . $row['namainstansi'] . "</td>";
                    echo "<td>" . $row['daerah'] . "</td>";
                    echo "<td>" . $row['no_telp'] . "</td>";
                    echo "<td>" . $row['role'] . "</td>";
                    
                    // Tombol Lihat untuk halaman jabatan
                    echo "<td><a href='jabatan.php?iduser=" . $row['iduser'] . "' class='btn btn-info btn-sm'>Lihat</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>
