<?php
// Koneksi ke database menggunakan PDO
$host = 'localhost';  // Host database Anda
$dbname = 'perhitungan_formasi';  // Nama database Anda
$dbusername = 'root';  // Username untuk database
$dbpassword = '';  // Password untuk database

try {
    // Membuat koneksi PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    // Set mode error handling PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Jika koneksi gagal, tampilkan pesan error
    die("Koneksi gagal: " . $e->getMessage());
}
?>
