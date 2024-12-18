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
    <h2 class="text-center">Negosiator Perdagangan</h2>
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
        <tbody>
            <?php
            $query = "SELECT * FROM hasil_perhitungan";
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
                echo "<td><a href='hapus_negosiator.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Apakah Anda yakin ingin menghapus?')\">Hapus</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="download_negosiator.php" class="btn btn-success">Download </a>
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
                <form id="formTambahData" method="post" action="negosiatorperdagangan.php">
                    <div class="form-group">
                        <label for="ruangLingkupModal">Ruang Lingkup:</label>
                        <select id="ruangLingkupModal" name="ruangLingkup" class="form-control" onchange="updateDeskripsiModal()">
                            <option value="">--Pilih--</option>
                            <option value="Hasil Kerja sama">Hasil Kerja sama</option>
                            <option value="Hasil Perundingan">Hasil Perundingan</option>
                            <option value="Tindaklanjut hasil perundingan">Tindaklanjut hasil perundingan</option>
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
        "Hasil Kerja sama": "jumlah kerjasama Perdagangan Internasional yang telah diselesaikan dalam waktu 1 tahun , dokumen pendukung dapat berbentuk dokumen MoU dan/atau Summary Of Discussion",
        "Hasil Perundingan": "jumlah perundingan yang telah diselesaikan dalam waktu 1 tahun dan dituangkan dalam dokumen laporan hasil perundingan",
        "Tindaklanjut hasil perundingan": "Jumlah kegiatan penyelesaian pelimpahan dokumen ratifikasi perjanjian perdagangan internasional termasuk namun tidak terbatas pada naskah penjelasan, naskah terjemahan, atau naskah akademik"
    };

    function updateDeskripsiModal(){
        const ruangLingkup = document.getElementById("ruangLingkupModal").value;
        document.getElementById("deskripsiModal").value = deskripsiMap[ruangLingkup] || '';
    }
</script>

</body>
</html>
