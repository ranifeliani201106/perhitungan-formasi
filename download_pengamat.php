<?php
include 'koneksi.php';

// Set header untuk mendownload file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=perhitungan_formasi_pengamat_tera.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Mulai output
echo "<html xmlns:x=\"urn:schemas-microsoft-com:office:excel\">";
echo "<head>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
echo "<style>
    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 50px; /* Menambahkan jarak antara judul dan tabel */
    }
    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
    }
    th {
        background-color: #f2f2f2;
    }
    h2 {
        text-align: center;
        margin: 40px 0; /* Tambahkan margin untuk judul */
    }
</style>";
echo "</head>";
echo "<body>";
echo "<h2>Pengamat Tera</h2>"; // Tambahkan judul
echo "<h5>" . $_SESSION['namainstansi'] . "</h5>";

// Tabel
echo "<table>";
echo "<thead>";
echo "<tr>";
echo "<th>Ruang Lingkup</th>";
echo "<th>Deskripsi</th>";
echo "<th>Volume</th>";
echo "<th>Pemula</th>";
echo "<th>Terampil</th>";
echo "<th>Mahir</th>";
echo "<th>Penyila</th>";
echo "<th>Keterangan</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

// Ambil data dari database
$query = "SELECT * FROM hasil_pengamat";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>{$row['ruang_lingkup']}</td>";
    echo "<td>{$row['deskripsi']}</td>";
    echo "<td>{$row['volume']}</td>";
    echo "<td>" . number_format($row['Pemula'], 2) . "</td>";
    echo "<td>" . number_format($row['Terampil'], 2) . "</td>";
    echo "<td>" . number_format($row['Mahir'], 2) . "</td>";
    echo "<td>" . number_format($row['Penyila'], 2) . "</td>";
    echo "<td>{$row['keterangan']}</td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";

echo "</body>";
echo "</html>";
?>
