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
        case "pengawasan  kegiatan perdagangan":
            $kebutuhanPertama = (66.00 * $volume * 0.42) / 1250;
            $kebutuhanMuda = (66.00 * $volume * 0.36) / 1250;
            $kebutuhanMadya = (66.00 * $volume * 0.19) / 1250;
            $kebutuhanUtama = (66.00 * $volume * 0.03) / 1250;
            break;
        case "pengawasan Barang Beredar dan/atau Jasa":
            $kebutuhanPertama = (175.00 * $volume * 0.40) / 1250;
            $kebutuhanMuda = (175.00 * $volume * 0.37) / 1250;
            $kebutuhanMadya = (175.00 * $volume * 0.20) / 1250;
            $kebutuhanUtama = (175.00 * $volume * 0.03) / 1250;
            break;
        case "pengawasan Alat Ukur, Alat Takar, Alat Timbang, dan Alat Perlengkapan":
            $kebutuhanPertama = (2.00 * $volume * 0.41) / 1250;
            $kebutuhanMuda = (2.00 * $volume * 0.39) / 1250;
            $kebutuhanMadya = (2.00 * $volume * 0.15) / 1250;
            $kebutuhanUtama = (2.00 * $volume * 0.05) / 1250;
            break;
        case "pengawasan BDKT":
            $kebutuhanPertama = (1.00 * $volume * 0.42) / 1250;
            $kebutuhanMuda = (1.00 * $volume * 0.38) / 1250;
            $kebutuhanMadya = (1.00 * $volume * 0.17) / 1250;
            $kebutuhanUtama = (1.00 * $volume * 0.03) / 1250;
            break;   
        case "pengawasan penggunaan satuan ukuran":
            $kebutuhanPertama = (3.00 * $volume * 0.45) / 1250;
            $kebutuhanMuda = (3.00 * $volume * 0.33) / 1250;
            $kebutuhanMadya = (3.00 * $volume * 0.18) / 1250;
            $kebutuhanUtama = (3.00 * $volume * 0.04) / 1250;
            break;
        case "Pengawasan Perdagangan Berjangka Komoditi, Sistem Resi Gudang dan Pasar Lelang Komoditas":
            $kebutuhanPertama = (170.00 * $volume * 0.38) / 1250;
            $kebutuhanMuda = (170.00 * $volume * 0.32) / 1250;
            $kebutuhanMadya = (170.00 * $volume * 0.26) / 1250;
            $kebutuhanUtama = (170.00 * $volume * 0.04) / 1250;
            break;      
        case "Penanganan Pengaduan":
            $kebutuhanPertama = (105.00 * $volume * 0.38) / 1250;
            $kebutuhanMuda = (105.00 * $volume * 0.34) / 1250;
            $kebutuhanMadya = (105.00 * $volume * 0.25) / 1250;
            $kebutuhanUtama = (105.00 * $volume * 0.03) / 1250;
            break;    
        case "Tindak lanjut hasil pengawasan":
            $kebutuhanPertama = (33.00 * $volume * 0.36) / 1250;
            $kebutuhanMuda = (33.00 * $volume * 0.32) / 1250;
            $kebutuhanMadya = (33.00 * $volume * 0.30) / 1250;
            $kebutuhanUtama = (33.00 * $volume * 0.02) / 1250;
            break;      
        case "Penyidikan":
            $kebutuhanPertama = (880.00 * $volume * 0.20) / 1250;
            $kebutuhanMuda = (880.00 * $volume * 0.35) / 1250;
            $kebutuhanMadya = (880.00 * $volume * 0.41) / 1250;
            $kebutuhanUtama = (880.00 * $volume * 0.04) / 1250;
            break;
        case "Penindakan":
            $kebutuhanPertama = (66.00 * $volume * 0.20) / 1250;
            $kebutuhanMuda = (66.00 * $volume * 0.35) / 1250;
            $kebutuhanMadya = (66.00 * $volume * 0.40) / 1250;
            $kebutuhanUtama = (66.00 * $volume * 0.05) / 1250;
            break;           
    }

    // Simpan hasil ke database
    $query = "INSERT INTO hasil_pengawas (ruang_lingkup, deskripsi, volume, pertama, muda, madya, utama, keterangan) 
              VALUES ('$ruangLingkup', '$deskripsi', '$volume', '$kebutuhanPertama', '$kebutuhanMuda', '$kebutuhanMadya', '$kebutuhanUtama', '$keterangan')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Perhitungan berhasil disimpan.'); window.location.href='hasil_pengawas.php';</script>";
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

<!-- Navbar -->
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
    <h2>Form Perhitungan Pengawasan Perdagangan</h2>
    <form method="post" action="">
        <div class="mb-3">
            <label for="ruangLingkup" class="form-label">Ruang Lingkup</label>
            <select id="ruangLingkup" name="ruangLingkup" class="form-select" onchange="updateDeskripsi()" required>
                <option value="" disabled selected>Pilih Ruang Lingkup</option>
                <option value="pengawasan  kegiatan perdagangan">Pengawasan Kegiatan Perdagangan</option>
                <option value="pengawasan Barang Beredar dan/atau Jasa">Pengawasan Barang Beredar dan/atau Jasa</option>
                <option value="pengawasan Alat Ukur, Alat Takar, Alat Timbang, dan Alat Perlengkapan">Pengawasan Alat Ukur, Alat Takar, Alat Timbang, dan Alat Perlengkapan</option>
                <option value="pengawasan BDKT">Pengawasan BDKT</option>
                <option value="pengawasan penggunaan satuan ukuran">Pengawasan Penggunaan Satuan Ukuran</option>
                <option value="Pengawasan Perdagangan Berjangka Komoditi, Sistem Resi Gudang dan Pasar Lelang Komoditas">Pengawasan Perdagangan Berjangka Komoditi, Sistem Resi Gudang dan Pasar Lelang Komoditas</option>
                <option value="Penanganan Pengaduan">Penanganan Pengaduan</option>
                <option value="Tindak lanjut hasil pengawasan">Tindak Lanjut Hasil Pengawasan</option>
                <option value="Penyidikan">Penyidikan</option>
                <option value="Penindakan">Penindakan</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <input type="text" id="deskripsi" name="deskripsi" class="form-control" readonly>
        </div>
        <div class="mb-3">
            <label for="volume" class="form-label">Volume</label>
            <input type="number" id="volume" name="volume" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea id="keterangan" name="keterangan" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Hitung dan Simpan</button>
    </form>
</div>

<script>
    const deskripsiMap = {
        "pengawasan  kegiatan perdagangan": "Jumlah kegiatan pengawasan perdagangan yang dilakukan dalam waktu 1 tahun yang dituangkan dalam laporan Hasil Pengawasan.",
        "pengawasan Barang Beredar dan/atau Jasa": "Jumlah pengawasan barang yang beredar dan/atau jasa yang dilakukan dalam waktu 1 tahun yang dituangkan dalam laporan Hasil Pengawasan.",
        "pengawasan Alat Ukur, Alat Takar, Alat Timbang, dan Alat Perlengkapan": "Jumlah pengawasan alat ukur, alat takar, alat timbang, dan alat perlengkapan yang dilakukan dalam waktu 1 tahun yang dituangkan dalam laporan Hasil Pengawasan.",
        "pengawasan BDKT": "Jumlah pengawasan barang yang dilakukan dalam waktu 1 tahun yang dituangkan dalam laporan Hasil Pengawasan.",
        "pengawasan penggunaan satuan ukuran": "Jumlah pengawasan penggunaan satuan ukuran yang dilakukan dalam waktu 1 tahun yang dituangkan dalam laporan Hasil Pengawasan.",
        "Pengawasan Perdagangan Berjangka Komoditi, Sistem Resi Gudang dan Pasar Lelang Komoditas": "Jumlah pengawasan perdagangan berjangka komoditi yang dilakukan dalam waktu 1 tahun yang dituangkan dalam laporan Hasil Pengawasan.",
        "Penanganan Pengaduan": "Jumlah pengaduan yang ditangani dalam waktu 1 tahun yang dituangkan dalam laporan Penanganan Pengaduan.",
        "Tindak lanjut hasil pengawasan": "Jumlah tindak lanjut hasil pengawasan yang dilakukan dalam waktu 1 tahun yang dituangkan dalam laporan Tindak Lanjut Hasil Pengawasan.",
        "Penyidikan": "Jumlah penyidikan yang dilakukan dalam waktu 1 tahun yang dituangkan dalam laporan Penyidikan.",
        "Penindakan": "Jumlah penindakan yang dilakukan dalam waktu 1 tahun yang dituangkan dalam laporan Penindakan."
    };

    function updateDeskripsi() {
        const ruangLingkup = document.getElementById('ruangLingkup').value;
        document.getElementById('deskripsi').value = deskripsiMap[ruangLingkup] || '';
    }
</script>

<!-- Tambahkan Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
