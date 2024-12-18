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
    $kebutuhanTerampil = $kebutuhanMahir = $kebutuhanPenyila = $kebutuhanPertama = $kebutuhanMuda = $kebutuhanMadya = $kebutuhanUtama = 0;

    switch ($ruangLingkup) {
        case "Tera/Tera Ulang Sederhana":
            $kebutuhanTerampil = (15.00 * $volume * 0.35) / 1250;
            $kebutuhanMahir = (15.00 * $volume * 0.33) / 1250;
            $kebutuhanPenyila = (15.00 * $volume * 0.32) / 1250;
            break;
        case "Pengelolaan Cap Tanda Tera":
            $kebutuhanTerampil = (16 * $volume * 0.36) / 1250;
            $kebutuhanMahir = (16 * $volume * 0.34) / 1250;
            $kebutuhanPenyila = (16 * $volume * 0.30) / 1250;
            break;
        case "Pengkondisian, Pengelolaan dan Pengembangan Laboratorium Kemetrologian/Instalasi Uji":
            $kebutuhanTerampil = (228 * $volume * 0.35) / 1250;
            $kebutuhanMahir = (228 * $volume * 0.31) / 1250;
            $kebutuhanPenyila = (228 * $volume * 0.34) / 1250;
            $kebutuhanPertama = (228 * $volume * 0.35) / 1250;
            $kebutuhanMuda = (228 * $volume * 0.28) / 1250;
            $kebutuhanMadya = (228 * $volume * 0.34) / 1250;
            $kebutuhanUtama = (228 * $volume * 0.03) / 1250;
            break;
        case "Tera/Tera Ulang Kompleks":
            $kebutuhanPertama = (4 * $volume * 0.38) / 1250;
            $kebutuhanMuda = (4 * $volume * 0.32) / 1250;
            $kebutuhanMadya = (4 * $volume * 0.27) / 1250;
            $kebutuhanUtama = (4 * $volume * 0.03) / 1250;
            break;
        case "Pengujian dalam rangka evaluasi tipe dan Persetujuan Tipe":
            $kebutuhanPertama = (37 * $volume * 0.28) / 1250;
            $kebutuhanMuda = (37 * $volume * 0.35) / 1250;
            $kebutuhanMadya = (37 * $volume * 0.32) / 1250;
            $kebutuhanUtama = (37 * $volume * 0.05) / 1250;
            break;
        case "Pengelolaan Standar Satuan Ukuran":
            $kebutuhanPertama = (11 * $volume * 0.40) / 1250;
            $kebutuhanMuda = (11 * $volume * 0.30) / 1250;
            $kebutuhanMadya = (11 * $volume * 0.25) / 1250;
            $kebutuhanUtama = (11 * $volume * 0.05) / 1250;
            break;
        case "Pengendalian Mutu Laboratorium Kemetrologian":
            $kebutuhanPertama = (134 * $volume * 0.35) / 1250;
            $kebutuhanMuda = (134 * $volume * 0.31) / 1250;
            $kebutuhanMadya = (134 * $volume * 0.27) / 1250;
            $kebutuhanUtama = (134 * $volume * 0.07) / 1250;
            break;
        case "Pengembangan Metode dan Perumusan Kebijakan di bidang metrologi legal":
            $kebutuhanPertama = (292 * $volume * 0.26) / 1250;
            $kebutuhanMuda = (292 * $volume * 0.35) / 1250;
            $kebutuhanMadya = (292 * $volume * 0.31) / 1250;
            $kebutuhanUtama = (292 * $volume * 0.08) / 1250;
            break;          
    }

    // Simpan hasil ke database
    $query = "INSERT INTO hasil_penera (ruang_lingkup, deskripsi, volume, terampil, mahir, penyila, pertama, muda, madya, utama, keterangan) 
              VALUES ('$ruangLingkup', '$deskripsi', '$volume', '$kebutuhanTerampil', '$kebutuhanMahir', '$kebutuhanPenyila', '$kebutuhanPertama', '$kebutuhanMuda', '$kebutuhanMadya', '$kebutuhanUtama', '$keterangan')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Perhitungan berhasil disimpan.'); window.location.href='hasil_penera.php';</script>";
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
    <h2 class="text-center">Penera</h2>

    <form action="penera.php" method="post">
        <div class="form-group">
            <label for="ruangLingkup">Ruang Lingkup:</label>
            <select id="ruangLingkup" name="ruangLingkup" class="form-control" onchange="updateDeskripsi()" required>
                <option value="">--Pilih--</option>
                <option value="Tera/Tera Ulang Sederhana">Tera/Tera Ulang Sederhana</option>
                <option value="Pengelolaan Cap Tanda Tera">Pengelolaan Cap Tanda Tera</option>
                <option value="Pengkondisian, Pengelolaan dan Pengembangan Laboratorium Kemetrologian/Instalasi Uji">Pengkondisian, Pengelolaan dan Pengembangan Laboratorium Kemetrologian/Instalasi Uji</option>
                <option value="Tera/Tera Ulang Kompleks">Tera/Tera Ulang Kompleks</option>
                <option value="Pengujian dalam rangka evaluasi tipe dan Persetujuan Tipe">Pengujian dalam rangka evaluasi tipe dan Persetujuan Tipe</option>
                <option value="Pengelolaan Standar Satuan Ukuran">Pengelolaan Standar Satuan Ukuran</option>
                <option value="Pengendalian Mutu Laboratorium Kemetrologian">Pengendalian Mutu Laboratorium Kemetrologian</option>
                <option value="Pengembangan Metode dan Perumusan Kebijakan di bidang metrologi legal">Pengembangan Metode dan Perumusan Kebijakan di bidang metrologi legal</option>
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
        "Tera/Tera Ulang Sederhana": "jumlah pelaksanaan pemeriksaan dan pengujian Alat Ukur, alat takar, alat timbang, dan alat perlengkapan Tingkat Kesulitan I dan II hingga menandai tanda tera sah atau tera batal yang berlaku volume mengacu pada Jumlah Surat Keterangan Hasil Pengujian (SKHP)/Berita Acara/Cerapan/Laporan yang diterbitkan dalam waktu 1 tahun",
        "Pengelolaan Cap Tanda Tera": "jumlah Cap Tanda Tera yang dikelola",
        "Pengkondisian, Pengelolaan dan Pengembangan Laboratorium Kemetrologian/Instalasi Uji": "jumlah laboratorium dan instalasi uji",
        "Tera/Tera Ulang Kompleks": "jumlah pelaksanaan pemeriksaan dan pengujian Alat Ukur, alat takar, alat timbang, dan alat perlengkapan Tingkat Kesulitan IV hingga menandai tanda tera sah atau tera batal yang berlaku volume mengacu pada Jumlah Surat Keterangan Hasil Pengujian (SKHP)/Berita Acara/Cerapan/Laporan yang diterbitkan dalam waktu 1 tahun",
        "Pengujian dalam rangka evaluasi tipe dan Persetujuan Tipe": "jumlah pelaksanaan pemeriksaan dan/atau pengujian tipe Alat Ukur, alat takar, alat timbang, dan alat perlengkapan termasuk namun tidak terbatas pada alat timbangan hingga diterbitkan sertifikat evaluasi tipe, Volume mengacu pada Jumlah Sertifikat Evaluasi Tipe yang diterbitkan dalam waktu 1 tahun",
        "Pengelolaan Standar Satuan Ukuran": "jumlah standar satuan ukuran yang dikelola",
        "Pengendalian Mutu Laboratorium Kemetrologian": "jumlah kegiatan Audit dan/atau asesmen yang dilaksanakan dalam rangka akreditasi dan pengendalian mutu laboratorium dalam waktu satu tahun  volume dapat mengacu jumlah laporan tinjauan manajemen (kaji ulang manajemen/rapat evaluasi tahunan), Laporan hasil audit/laporan hasil akreditasi",
        "Pengembangan Metode dan Perumusan Kebijakan di bidang metrologi legal": "jumlah kebijakan dalam rangka pengembangan di bidang metrology legal yang telah dikeluarkan dalam waktu satu tahun, kebijakan dapat berupa syarat teknis alat ukur, alat takar, alat timbang dan alat perlengkapan serta syarat teknis standar ukuran, pembaruan metode dan prosedur Tera dan Tera Ulang dan pengujian teknis alat ukur, alat takar, alat timbang dan alat perlengkapan, pengelolaan Standar Ukuran dan laboratorium kemetrologian/instalasi uji yang berupa  Petunjuk Teknis, Petunjuk Pelaksanaan, Surat Edarab, Peraturan Menteri dan/atau Keputusan Menteri",
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
