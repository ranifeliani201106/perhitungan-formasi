<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Perhitungan</title>
    <!-- Ganti link Bootstrap ke versi 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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

<!-- Konten Hasil Perhitungan -->
<div class="container mt-5">
    <h2 class="text-center">Analis Perdagangan</h2>
    <h5 class="text-center"><?php echo $_SESSION['namainstansi'];?></h5>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Ruang Lingkup</th>
                <th>Deskripsi</th>
                <th>Volume</th>
                <th>Pertama</th>
                <th>Muda</th>
                <th>Madya</th>
                <th>Utama</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
            <?php
            $query = "SELECT * FROM hasil_analis";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['ruang_lingkup']}</td>";
                echo "<td>{$row['deskripsi']}</td>";
                echo "<td>{$row['volume']}</td>";
                echo "<td>" . number_format($row['pertama'], 2) . "</td>";
                echo "<td>" . number_format($row['muda'], 2) . "</td>";
                echo "<td>" . number_format($row['madya'], 2) . "</td>";
                echo "<td>" . number_format($row['utama'], 2) . "</td>";
                echo "<td>{$row['keterangan']}</td>";
                echo "<td><a href='hapus_analis.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Apakah Anda yakin ingin menghapus?')\">Hapus</a></td>";
            }
            ?>

    </table>
    <a href="download_analis.php" class="btn btn-success">Download </a>
    <!-- Tombol Modal -->
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahDataModal">Tambah Data Perhitungan</button>
</div>
<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Perhitungan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> 
            <div class="modal-body">
                <form id="formTambahData" method="post" action="analisisperdagangan.php">
                    <div class="form-group">
                        <label for="ruangLingkupModal">Ruang Lingkup:</label>
                        <select id="ruangLingkupModal" name="ruangLingkup" class="form-control" onchange="updateDeskripsiModal()">
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
                        <label for="deskripsiModal">Deskripsi:</label>
                        <textarea id="deskripsiModal" name="deskripsi" class="form-control" rows="4" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label for="volumeModal">Volume:</label>
                        <input type="number" id="volumeModal" name="volume" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="keteranganModal">Keterangan:</label>
                        <textarea id="keteranganModal" name="keterangan" class="form-control" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Hitung & Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

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

    function updateDeskripsiModal(){
        const ruangLingkup = document.getElementById("ruangLingkupModal").value;
        document.getElementById("deskripsiModal").value = deskripsiMap[ruangLingkup] || '';
    }
</script>

</body>
</html>
