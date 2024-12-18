<?php
session_start();
include('koneksi_admin.php');

// Pastikan admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: login_admin.php');
    exit;
}

// Ambil ID hasil dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
if (!$id) {
    header('Location: verifikasi_analis.php');
    exit;
}

// Hapus data dari database
$query = "DELETE FROM verifikasi_analis WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

// Redirect setelah berhasil menghapus
header('Location: admin_analis.php');
exit;
?>
