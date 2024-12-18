<?php
// Menghubungkan ke file koneksi.php
include 'koneksi.php';
session_start();

// Memastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: unauthorized.php');
    exit;
}

// Menangkap id dari URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Jika id tidak ada, alihkan ke halaman utama
if (!$id) {
    header('Location: hasil_analis.php');
    exit;
}

// Query untuk menghapus data berdasarkan ID
$query = "DELETE FROM hasil_analis WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    header('Location: hasil_analis.php');
    exit;
} else {
    echo "Gagal menghapus data.";
}
?>
