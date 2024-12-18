<?php
include 'koneksi.php';
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login_user.php");
    exit;
}

// Ambil nama instansi dari sesi
$namainstansi = isset($_SESSION['namainstansi']) ? htmlspecialchars($_SESSION['namainstansi']) : "Instansi tidak ditemukan";

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Perhitungan Formasi</title>
</head>
<body>

<!-- Tombol untuk membuka navbar -->
<nav class="navbar navbar-light bg-white">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="assets/img/logoo.png" alt="Logo" width="300" height="auto" class="d-inline-block align-top">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>

<!-- Off-canvas Navbar -->
<div class="offcanvas offcanvas-start bg-success" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title text-white" id="offcanvasNavbarLabel">Menu</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
      <li class="nav-item">
        <a class="nav-link text-white" href="dashboard_user.php">Home</a>
      </li>
      <?php if (isset($_SESSION['username'])): ?>
        <li class="nav-item">
          <a class="nav-link text-white" href="logout_user.php">Logout</a>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a class="nav-link text-white" href="login_user.php">Login</a>
        </li>
      <?php endif; ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Hasil Perhitungan</a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="hasil_analis.php?jabatan=analis_perdagangan">Analis Perdagangan</a></li>
            <li><a class="dropdown-item" href="hasil_perhitungan.php?jabatan=negosiator_perdagangan">Negosiator Perdagangan</a></li>
            <li><a class="dropdown-item" href="hasil_pengawas.php?jabatan=pengawas_perdagangan">Pengawas Perdagangan</a></li>
            <li><a class="dropdown-item" href="hasil_penera.php?jabatan=penera">Penera</a></li>
            <li><a class="dropdown-item" href="hasil_penguji.php?jabatan=penguji_MB">Penguji Mutu Barang</a></li>
            <li><a class="dropdown-item" href="hasil_pengamat.php?jabatan=pengamat_tera">Pengamat Tera</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>

<!-- Konten Utama -->
<div class="container mt-5">
  <h1 class="text-center">PERHITUNGAN REKOMENDASI FORMASI</h1>
  <h3>Selamat datang, <?php echo $namainstansi; ?></h3>
  <table class="table table-striped table-hover mt-5">
    <thead class="table-success">
      <tr>
        <th>Nama Jabatan</th>
        <th>Tombol Mulai</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Analis Perdagangan</td>
        <td><a href="analisisperdagangan.php" class="btn btn-success">Mulai</a></td>
      </tr>
      <tr>
        <td>Negosiator Perdagangan</td>
        <td><a href="negosiatorperdagangan.php" class="btn btn-success">Mulai</a></td>
      </tr>
      <tr>
        <td>Pengawas Perdagangan</td>
        <td><a href="pengawasperdagangan.php" class="btn btn-success">Mulai</a></td>
      </tr>
      <tr>
        <td>Penera</td>
        <td><a href="penera.php" class="btn btn-success">Mulai</a></td>
      </tr>
      <tr>
        <td>Penguji Mutu Barang</td>
        <td><a href="pengujiMB.php" class="btn btn-success">Mulai</a></td>
      </tr>
      <tr>
        <td>Pengamat Tera</td>
        <td><a href="pengamattera.php" class="btn btn-success">Mulai</a></td>
      </tr>
    </tbody>
  </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
