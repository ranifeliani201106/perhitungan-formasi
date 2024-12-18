<?php
$host = 'localhost'; // Ganti dengan host database kamu
$username = 'root'; // Ganti dengan username database
$password = ''; // Ganti dengan password database
$dbname = 'perhitungan_formasi'; // Ganti dengan nama database kamu

// Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $dbname);

// Mengecek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
