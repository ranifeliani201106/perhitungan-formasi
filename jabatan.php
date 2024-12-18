<?php
// Menghubungkan ke file koneksi.php
include('koneksi_admin.php');

// Menangkap parameter iduser dari URL
$iduser = isset($_GET['iduser']) ? $_GET['iduser'] : null;

// Daftar jabatan
$jabatanList = [
    1 => 'Analis Perdagangan',
    2 => 'Negosiator Perdagangan',
    3 => 'Pengawas Perdagagan',
    4 => 'Penera',
    5 => 'Penguji Mutu Barang',
    6 => 'Pengamat Tera'
];

// Mapping halaman untuk setiap jabatan
$halamanReview = [
    1 => 'admin_analis.php',
    2 => 'admin_negosiator.php',
    3 => 'admin_pengawas.php',
    4 => 'admin_penera.php',
    5 => 'admin_penguji.php',
    6 => 'admin_pengamat.php'
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Jabatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            border: none;
            border-radius: 15px;
            background: #f8f9fa;
        }
        h2, p {
            color: #ffffff;
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
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Halaman Jabatan</h2>

    <!-- Informasi User -->
    <?php if ($iduser): ?>
        <p class="text-center">Hasil untuk User dengan ID: <strong><?php echo $iduser; ?></strong></p>
    <?php else: ?>
        <p class="text-center text-danger">ID User tidak ditemukan.</p>
    <?php endif; ?>

    <!-- Daftar Jabatan -->
    <div class="card p-4">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jabatanList as $key => $jabatan): ?>
                    <tr>
                        <td><?php echo $key; ?></td>
                        <td><?php echo $jabatan; ?></td>
                        <td>
                            <?php
                            // Tentukan halaman berdasarkan jabatan
                            $halaman = isset($halamanReview[$key]) ? $halamanReview[$key] : '#';
                            ?>
                            <a href="<?php echo $halaman; ?>?iduser=<?php echo $iduser; ?>" class="btn btn-info btn-sm">Review</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
