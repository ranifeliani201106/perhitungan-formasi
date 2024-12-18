<?php
include 'koneksi.php';

// Set header untuk mendownload file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=perhitungan_formasi_negosiator_perdagangan.xls");
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
echo "<h2>Negosiator Perdagangan</h2>"; // Tambahkan judul
echo "<h5>" . $_SESSION['namainstansi'] . "</h5>";
// Tabel
echo "<table>";
echo "<thead>";
echo "<tr>";
echo "<th>Ruang Lingkup</th>";
echo "<th>Deskripsi</th>";
echo "<th>Volume</th>";
echo "<th>Pertama</th>";
echo "<th>Muda</th>";
echo "<th>Madya</th>";
echo "<th>Utama</th>";
echo "<th>Keterangan</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

// Ambil data dari database
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
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";

echo "</body>";
echo "</html>";
?>
