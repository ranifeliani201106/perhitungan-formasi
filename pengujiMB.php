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
    $kebutuhanPemula = $kebutuhanTerampil = $kebutuhanMahir = $kebutuhanPenyila = $kebutuhanPertama = $kebutuhanMuda = $kebutuhanMadya = $kebutuhanUtama = 0;

    switch ($ruangLingkup) {
        case "Pengambilan Contoh Sederhana":
            $kebutuhanPemula = (5 * $volume * 0.07) / 1250;
            $kebutuhanTerampil = (5 * $volume * 0.21) / 1250;
            $kebutuhanMahir = (5 * $volume * 0.47) / 1250;
            $kebutuhanPenyila = (5 * $volume * 0.25) / 1250;
            break;
        case "Pengujian/Kalibrasi Sederhana":
            $kebutuhanPemula = (1 * $volume * 0.04) / 1250;
            $kebutuhanTerampil = (1 * $volume * 0.27) / 1250;
            $kebutuhanMahir = (1 * $volume * 0.22) / 1250;
            $kebutuhanPenyila = (1 * $volume * 0.47) / 1250;
            break;
        case "Pengelolaan Laboratorium/Kelembagaan/Organisasi/sistem mutu":
            $kebutuhanPemula = (30 * $volume * 0.46) / 1250;
            $kebutuhanTerampil = (30 * $volume * 0.15) / 1250;
            $kebutuhanMahir = (30 * $volume * 0.12) / 1250;
            $kebutuhanPenyila = (30 * $volume * 0.27) / 1250;
            break; 
        case "Pengambilan Contoh Kompleks":
            $kebutuhanPemuda = (5.5 * $volume * 0.45) / 1250;
            $kebutuhanMuda = (5.5 * $volume * 0.35) / 1250;
            $kebutuhanMadya = (5.5 * $volume * 0.30) / 1250;
            $kebutuhanUtama = (5.5 * $volume * 0.00) / 1250;
            break; 
        case "Pengujian/Kalibrasi Kompleks":
            $kebutuhanPemuda = (2.5 * $volume * 0.41) / 1250;
            $kebutuhanMuda = (2.5 * $volume * 0.30) / 1250;
            $kebutuhanMadya = (2.5 * $volume * 0.24) / 1250;
            $kebutuhanUtama = (2.5 * $volume * 0.05) / 1250;
            break; 
        case "Pengembangan Metode Pengujian / Kalibrasi":
            $kebutuhanPemuda = (292 * $volume * 0.30) / 1250;
            $kebutuhanMuda = (292 * $volume * 0.35) / 1250;
            $kebutuhanMadya = (292 * $volume * 0.27) / 1250;
            $kebutuhanUtama = (292 * $volume * 0.08) / 1250;
            break;
    }

    // Simpan hasil ke database
    $query = "INSERT INTO hasil_penguji (ruang_lingkup, deskripsi, volume, pemula, terampil, mahir, penyila, pertama, muda, madya, utama, keterangan) 
              VALUES ('$ruangLingkup', '$deskripsi', '$volume', '$kebutuhanPemula', '$kebutuhanTerampil', '$kebutuhanMahir', '$kebutuhanPenyila', '$kebutuhanPertama', '$kebutuhanMuda', '$kebutuhanMadya', '$kebutuhanUtama', '$keterangan')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Perhitungan berhasil disimpan.'); window.location.href='hasil_penguji.php';</script>";
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
    <h2 class="text-center">Penguji Mutu Barang</h2>

    <form action="pengujiMB.php" method="post">
        <div class="form-group">
            <label for="ruangLingkup">Ruang Lingkup:</label>
            <select id="ruangLingkup" name="ruangLingkup" class="form-control" onchange="updateDeskripsi()" required>
                <option value="">--Pilih--</option>
                <option value="Pengambilan Contoh Sederhana">Pengambilan Contoh Sederhana</option>
                <option value="Pengujian/Kalibrasi Sederhana">Pengujian/Kalibrasi Sederhana</option>
                <option value="Pengelolaan Laboratorium/Kelembagaan/Organisasi/sistem mutu">Pengelolaan Laboratorium/Kelembagaan/Organisasi/sistem mutu</option>
                <option value="Pengambilan Contoh Kompleks">Pengambilan Contoh Kompleks</option>
                <option value="Pengujian/Kalibrasi Kompleks">Pengujian/Kalibrasi Kompleks</option>
                <option value="Pengembangan Metode Pengujian / Kalibrasi">Pengembangan Metode Pengujian / Kalibrasi</option>
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
        "Pengambilan Contoh Sederhana": "jumlah pengambilan contoh tingkat kesulitan I, II, dan III dalam waktu 1 tahun, volume dapat mengacu pada berita acara pengambilan contoh yang diterbitkan",
        "Pengujian/Kalibrasi Sederhana": "jumlah pengujian dan kalibrasi tingkat kesulitan I yang dilakukan dalam waktu 1 tahun , volume dapat mengacu pada rekapitulasi hasil pengujian/kalibrasi",
        "Pengelolaan Laboratorium/Kelembagaan/Organisasi/sistem mutu": "Jumlah Rekaman Pengelolaan Laboratorium/Instalasi Uji, Laporan Pengelolaan Laboratorium/Instalasi Uji, penanganan peralatan",
        "Pengambilan Contoh Kompleks": "jumlah pengambilan contoh tingkat kesulitan IV dan V dalam waktu 1 tahun, volume dapat mengacu pada berita acara pengambilan contoh yang diterbitkan",
        "Pengujian/Kalibrasi Kompleks": "jumlah pengujian dan kalibrasi tingkat kesulitan IV yang dilakukan dalam waktu 1 tahun , volume dapat mengacu pada rekapitulasi hasil pengujian/kalibrasi",
        "Pengembangan Metode Pengujian / Kalibrasi": "jumlah kebijakan dalam rangka pengembangan metode  pengujian mutu barang/kalibrasi yang telah dikeluarkan dalam waktu satu tahun, kebijakan dapat berupa Petunjuk Teknis, Petunjuk Pelaksanaan, Surat Edaran, Peraturan Menteri dan/atau Keputusan Menteri",
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
