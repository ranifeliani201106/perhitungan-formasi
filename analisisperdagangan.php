<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
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
        case "Pengelolaan Ekspor Dan Impor":
            $kebutuhanPertama = (270.00 * $volume * 0.43) / 1250;
            $kebutuhanMuda = (270.00 * $volume * 0.32) / 1250;
            $kebutuhanMadya = (270.00 * $volume * 0.20) / 1250;
            $kebutuhanUtama = (270.00 * $volume * 0.05) / 1250;
            break;
        case "Pengendalian Harga Dan Pengelolaan Distribusi":
            $kebutuhanPertama = (235.00 * $volume * 0.37) / 1250;
            $kebutuhanMuda = (235.00 * $volume * 0.33) / 1250;
            $kebutuhanMadya = (235.00 * $volume * 0.27) / 1250;
            $kebutuhanUtama = (235.00 * $volume * 0.03) / 1250;
            break;
        case "Pemrosesan Persetujuan Perizinan":
            $kebutuhanPertama = (16.50 * $volume * 0.47) / 1250;
            $kebutuhanMuda = (16.50 * $volume * 0.39) / 1250;
            $kebutuhanMadya = (16.50 * $volume * 0.14) / 1250;
            $kebutuhanUtama = (16.50 * $volume * 0.00) / 1250;
            break;
        case "Penjaminan Mutu":
            $kebutuhanPertama = (205.00 * $volume * 0.40) / 1250;
            $kebutuhanMuda = (205.00 * $volume * 0.35) / 1250;
            $kebutuhanMadya = (205.00 * $volume * 0.20) / 1250;
            $kebutuhanUtama = (205.00 * $volume * 0.05) / 1250;
            break;
        case "Pengembangan Ekspor":
            $kebutuhanPertama = (255.00 * $volume * 0.43) / 1250;
            $kebutuhanMuda = (255.00 * $volume * 0.33) / 1250;
            $kebutuhanMadya = (255.00 * $volume * 0.20) / 1250;
            $kebutuhanUtama = (255.00 * $volume * 0.04) / 1250;
            break;
        case "Penyuluhan Dan Edukasi Bidang Perdagangan":
            $kebutuhanPertama = (55.00 * $volume * 0.45) / 1250;
            $kebutuhanMuda = (55.00 * $volume * 0.38) / 1250;
            $kebutuhanMadya = (55.00 * $volume * 0.17) / 1250;
            $kebutuhanUtama = (55.00 * $volume * 0.00) / 1250;
            break;      
        case "Pelindungan Dan Pengamanan Perdagangan":
            $kebutuhanPertama = (353.00 * $volume * 0.40) / 1250;
            $kebutuhanMuda = (353.00 * $volume * 0.30) / 1250;
            $kebutuhanMadya = (353.00 * $volume * 0.25) / 1250;
            $kebutuhanUtama = (353.00 * $volume * 0.05) / 1250;
            break;
        case "Pengaturan PBK/SRG/PLK":
            $kebutuhanPertama = (208.00 * $volume * 0.41) / 1250;
            $kebutuhanMuda = (208.00 * $volume * 0.34) / 1250;
            $kebutuhanMadya = (208.00 * $volume * 0.20) / 1250;
            $kebutuhanUtama = (208.00 * $volume * 0.05) / 1250;
            break;       
        case "Pengembangan Metrologi Legal":
            $kebutuhanPertama = (55.00 * $volume * 0.43) / 1250;
            $kebutuhanMuda = (55.00 * $volume * 0.33) / 1250;
            $kebutuhanMadya = (55.00 * $volume * 0.20) / 1250;
            $kebutuhanUtama = (55.00 * $volume * 0.04) / 1250;
            break;
        case "Penanganan Pengaduan Konsumen":
            $kebutuhanPertama = (22.00 * $volume * 0.40) / 1250;
            $kebutuhanMuda = (22.00 * $volume * 0.32) / 1250;
            $kebutuhanMadya = (22.00 * $volume * 0.25) / 1250;
            $kebutuhanUtama = (22.00 * $volume * 0.03) / 1250;
            break;
        case "Pembinaan Dan Pengembangan Bidang Perdagangan":
            $kebutuhanPertama = (110.00 * $volume * 0.48) / 1250;
            $kebutuhanMuda = (110.00 * $volume * 0.37) / 1250;
            $kebutuhanMadya = (110.00 * $volume * 0.20) / 1250;
            $kebutuhanUtama = (110.00 * $volume * 0.05) / 1250;
            break;
        case "Analisis Isu Perdagangan":
            $kebutuhanPertama = (55.00 * $volume * 0.41) / 1250;
            $kebutuhanMuda = (55.00 * $volume * 0.38) / 1250;
            $kebutuhanMadya = (55.00 * $volume * 0.17) / 1250;
            $kebutuhanUtama = (55.00 * $volume * 0.04) / 1250;
            break;
        case "Kebijakan Bidang Perdagangan":
            $kebutuhanPertama = (546.00 * $volume * 0.40) / 1250;
            $kebutuhanMuda = (546.00 * $volume * 0.35) / 1250;
            $kebutuhanMadya = (546.00 * $volume * 0.18) / 1250;
            $kebutuhanUtama = (546.00 * $volume * 0.07) / 1250;
            break;
            
    }

    // Simpan hasil ke database
    $query = "INSERT INTO hasil_analis (ruang_lingkup, deskripsi, volume, pertama, muda, madya, utama, keterangan) 
              VALUES ('$ruangLingkup', '$deskripsi', '$volume', '$kebutuhanPertama', '$kebutuhanMuda', '$kebutuhanMadya', '$kebutuhanUtama', '$keterangan')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Perhitungan berhasil disimpan.'); window.location.href='hasil_analis.php';</script>";
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
          <a class="nav-link text-white" href="logout_user.php">Logout</a>
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
    <h2 class="text-center">Analis Perdagangan</h2>

    <form action="analisisperdagangan.php" method="post">
        <div class="form-group">
            <label for="ruangLingkup">Ruang Lingkup:</label>
            <select id="ruangLingkup" name="ruangLingkup" class="form-control" onchange="updateDeskripsi()" required>
                <option value="">--Pilih--</option>
                <option value="Pengelolaan Ekspor Dan Impor">Pengelolaan Ekspor Dan Impor</option>
                <option value="Pengendalian Harga Dan Pengelolaan Distribusi">Pengendalian Harga Dan Pengelolaan Distribusi</option>
                <option value="Pemrosesan Persetujuan Perizinan">Pemrosesan Persetujuan Perizinan</option>
                <option value="Penjaminan Mutu">Penjaminan Mutu </option>
                <option value="Pengembangan Ekspor">Pengembangan Ekspor</option>
                <option value="Penyuluhan Dan Edukasi Bidang Perdagangan">Penyuluhan Dan Edukasi Bidang Perdagangan</option>
                <option value="Pelindungan Dan Pengamanan Perdagangan">Pelindungan Dan Pengamanan Perdagangan</option>
                <option value="Pengaturan PBK/SRG/PLK">Pengaturan PBK/SRG/PLK</option>
                <option value="Pengembangan Metrologi Legal">Pengembangan Metrologi Legal</option>
                <option value="Penanganan Pengaduan Konsumen">Penanganan Pengaduan Konsumen</option>
                <option value="Pembinaan Dan Pengembangan Bidang Perdagangan">Pembinaan Dan Pengembangan Bidang Perdagangan </option>
                <option value="Analisis Isu Perdagangan">Analisis Isu Perdagangan</option>
                <option value="Kebijakan Bidang Perdagangan">Kebijakan Bidang Perdagangan</option>
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
        </div><br>

        <button type="submit" class="btn btn-success">Hitung & Simpan</button>
    </form>
</div>

<script>
    const deskripsiMap = {
        "Pengelolaan Ekspor Dan Impor": "Jumlah kebijakan tata kelola ekspor dan impor serta fasilitasi perdagangan luar negeri yang dikeluarkan dalam waktu 1 Tahun paling rendah dalam bentuk Peraturan Menteri/ Keputusan Menteri",
        "Pengendalian Harga Dan Pengelolaan Distribusi": "1.Jumlah Kebijakan Pengendalian Harga Yang Dikeluarkan Dalam Waktu 1 Tahun Paling Rendah Dalam Bentuk Peraturan Menteri/Keputusan Menteri Dan/Atau Kegiatan Pemantauan Harga, Distribusi, Dan Ketersediaan Barang Pokok Dan Penting Yang Dilaksanakan Dalam Waktu 1 Tahun. 2.Jumlah Kebijakan Mekanisme Perdagangan Seperti PMSE, Sarana Perdagangan, Distribusi, Logistik Yang Dikeluarkan Paling Rendah Dalam Bentuk Peraturan Menteri/Keputusan Menteri/Peraturan Daerah.",
        "Pemrosesan Persetujuan Perizinan": "Jumlah dokumen perizinan dan non perizinan yang diterbitkan di bidang perdagangan luar negeri, perdagangan dalam negeri, Perdagangan Berjangka Komoditi/Sistem Resi Gudang/Pasar Lelang Komoditas, Mutu, dan Metrologi Legal",
        "Penjaminan Mutu": "Jumlah kegiatan penilaian Mutu terhadap personel, kelembagaan, layanan terkait mutu dan produk berupa laporan hasil penilaian mutu serta Jumlah perumusan dan/atau pengembangan standar mutu yang dikeluarkan termasuk namun tidak terbatas pada Rancangan SNI",
        "Pengembangan Ekspor": "1. Jumlah kegiatan Pengembangan ekspor melalui kegiatan pameran dagang dan/atau misi dagang berdasarkan hasil market intelligence untuk Instansi Pusat 2. Jumlah kegiatan penyelenggaraan/partisipasi pameran dagang internasional, pameran dagang nasional, pameran dagang lokal, dan misi dagang bagi produk ekspor asal 1 (satu) daerah Provinsi/Kabupaten/Kota",
        "Penyuluhan Dan Edukasi Bidang Perdagangan": "Jumlah kegiatan pelaksanaan penyuluhan, edukasi, bimbingan teknis, diseminasi, dan/atau sosialisasi yang dilaksanakan dalam waktu 1 tahun dan dihitung per kegiatan berupa laporan hasil kegiatan",
        "Pelindungan Dan Pengamanan Perdagangan": "Jumlah kegiatan pembelaan atas tuduhan dumping dan/atau subsidi terhadap ekspor Barang Nasional dan Pembelaan terhadap eksportir yang barang ekspornya dinilai oleh negara mitra dagang menimbulkan lonjakan impor di negara tersebut berbentuk Dokumen Submisi yang diterbitkan dan disampaikan dalam waktu 1 Tahun serta kegiatan penanganan sengketa perdagangan internasional berbentuk dokumen litigasi maupun non-litigasi yang diterbitkan dan dimanfaatkan dalam rangka penanganan sengketa dalam waktu 1 tahun ",
        "Pengaturan PBK/SRG/PLK": "Jumlah kebijakan Perdagangan Berjangka Komoditi, Sistem Resi Gudang dan/atau Pasar Lelang Komoditas yang dikeluarkan dalam waktu 1 Tahun paling rendah berbentuk Peraturan Kepala Badan/ Keputusan Kepala Badan",
        "Pengembangan Metrologi Legal": "Jumlah kegiatan penilaian persyaratan manajemen  Unit Metrologi Legal yang dilaksanakan  dan dibuktikan melalui  Surat Keterangan Kemampuan Pelayanan Tera dan Tera Ulang yang diterbitkan dalam waktu 1 (satu) tahun ",
        "Penanganan Pengaduan Konsumen": "Jumlah penanganan pengaduan yang ditindaklanjuti melalui proses klarifikasi hingga mediasi/rekomendasi tindaklanjut pengawasan yang dibuktikan dengan laporan hasil penanganan pengaduan ",
        "Pembinaan Dan Pengembangan Bidang Perdagangan": "Jumlah kegiatan Pembinaan dan Pengembangan termasuk program pendampingan hingga memberikan dampak peningkatan kapasitas, efisiensi dan keberlanjutan di bidang Perdagangan ",
        "Analisis Isu Perdagangan": "Jumlah analisis isu perdagangan yang paling sedikit memuat identifikasi masalah utama, analisa data dan/atau tren, dan Alternatif Solusi dan Rekomendasi yang diterbitkan dan dipergunakan/dimanfaatkan oleh pemangku perdagangan",
        "Kebijakan Bidang Perdagangan": "Jumlah rekomendasi kebijakan yang dimanfaatkan pemangku kepentingan dan/atau digunakan sebagai dasar pembentukan suatu Peraturan",
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
