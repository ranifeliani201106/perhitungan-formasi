<?php
// Menghubungkan ke file koneksi.php
include('koneksi.php');

// Tangkap data dari form
$iduser = $_POST['iduser'];
$ruangLingkup = $_POST['ruangLingkup'];
$deskripsi = $_POST['deskripsi'];
$volume = $_POST['volume'];

// Lakukan perhitungan hasil
$skr = 4.63; // Contoh nilai skr
$persentase = 43; // Contoh persentase
$hasil = ($skr * $persentase * $volume) / 1250;

// Simpan data ke database
$query = "INSERT INTO hasil_analis (iduser, ruang_lingkup, deskripsi, volume, hasil) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('isssd', $iduser, $ruangLingkup, $deskripsi, $volume, $hasil);

if ($stmt->execute()) {
    header("Location: admin_analis.php?iduser=$iduser");
} else {
    echo "Gagal menyimpan data.";
}
?>
