<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login_user.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ruangLingkup = $_POST['ruangLingkup'];
    $deskripsi = $_POST['deskripsi'];
    $volume = $_POST['volume'];
    $keterangan = $_POST['keterangan'];

    // Perhitungan formasi
    $kebutuhanPertama = $kebutuhanMuda = $kebutuhanMadya = $kebutuhanUtama = 0;

    switch ($ruangLingkup) {
        case "Hasil Kerja sama":
            $kebutuhanPertama = (220.00 * $volume * 0.38) / 1250;
            $kebutuhanMuda = (220.00 * $volume * 0.34) / 1250;
            $kebutuhanMadya = (220.00 * $volume * 0.25) / 1250;
            $kebutuhanUtama = (220.00 * $volume * 0.03) / 1250;
            break;
        case "Hasil Perundingan":
            $kebutuhanPertama = (495.00 * $volume * 0.36) / 1250;
            $kebutuhanMuda = (495.00 * $volume * 0.32) / 1250;
            $kebutuhanMadya = (495.00 * $volume * 0.30) / 1250;
            $kebutuhanUtama = (495.00 * $volume * 0.02) / 1250;
            break;
        case "Tindaklanjut hasil perundingan":
            $kebutuhanPertama = (205.00 * $volume * 0.40) / 1250;
            $kebutuhanMuda = (205.00 * $volume * 0.36) / 1250;
            $kebutuhanMadya = (205.00 * $volume * 0.20) / 1250;
            $kebutuhanUtama = (205.00 * $volume * 0.04) / 1250;
            break;
    }

    // Simpan hasil ke database
    $query = "INSERT INTO hasil_perhitungan (ruang_lingkup, deskripsi, volume, pertama, muda, madya, utama, keterangan) 
              VALUES ('$ruangLingkup', '$deskripsi', '$volume', '$kebutuhanPertama', '$kebutuhanMuda', '$kebutuhanMadya', '$kebutuhanUtama', '$keterangan')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Perhitungan berhasil disimpan.'); window.location.href='hasil_perhitungan.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Perhitungan</title>
    <!-- Gunakan Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Tombol untuk membuka navbar -->
<nav class="navbar navbar-dark bg-success">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Perhitungan Formasi</a>
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
      <?php if (!isset($_SESSION['username'])): ?>
        <li class="nav-item">
          <a class="nav-link text-white" href="login_user.php">Login</a>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a class="nav-link text-white" href="logout.php">Logout</a>
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

<div class="container mt-5">
    <h2 class="text-center">Negosiator Perdagangan</h2>

    <form action="negosiatorperdagangan.php" method="post">
        <div class="form-group">
            <label for="ruangLingkup">Ruang Lingkup:</label>
            <select id="ruangLingkup" name="ruangLingkup" class="form-control" onchange="updateDeskripsi()" required>
                <option value="">--Pilih--</option>
                <option value="Hasil Kerja sama">Hasil Kerja sama</option>
                <option value="Hasil Perundingan">Hasil Perundingan</option>
                <option value="Tindaklanjut hasil perundingan">Tindaklanjut hasil perundingan</option>
            </select>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi:</label>
            <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4" readonly></textarea>
        </div>

        <div class="form-group">
            <label for="volume">Volume:</label>
            <input type="number" id="volume" name="volume" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan:</label>
            <textarea id="keterangan" name="keterangan" class="form-control" rows="2"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Hitung & Simpan</button>
    </form>
</div>

<script>
    const deskripsiMap = {
        "Hasil Kerja sama": "jumlah kerjasama Perdagangan Internasional yang telah diselesaikan dalam waktu 1 tahun , dokumen pendukung dapat berbentuk dokumen MoU dan/atau Summary Of Discussion",
        "Hasil Perundingan": "jumlah perundingan yang telah diselesaikan dalam waktu 1 tahun dan dituangkan dalam dokumen laporan hasil perundingan",
        "Tindaklanjut hasil perundingan": "Jumlah kegiatan penyelesaian pelimpahan dokumen ratifikasi perjanjian perdagangan internasional termasuk namun tidak terbatas pada naskah penjelasan, naskah terjemahan, atau naskah akademik"
    };

    function updateDeskripsi() {
        const ruangLingkup = document.getElementById("ruangLingkup").value;
        document.getElementById("deskripsi").value = deskripsiMap[ruangLingkup] || '';
    }
</script>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
