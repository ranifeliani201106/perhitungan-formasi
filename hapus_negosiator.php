<?php
include 'koneksi.php';
session_start();

// Memeriksa apakah parameter `id` tersedia di URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Mengambil id dari URL dan mengonversi menjadi integer untuk keamanan

    // Query untuk menghapus data berdasarkan id
    $query = "DELETE FROM hasil_perhitungan WHERE id = $id";
    $result = mysqli_query($conn, $query);

    // Menyimpan pesan status penghapusan
    if ($result) {
        $_SESSION['message'] = "Data berhasil dihapus.";
    } else {
        $_SESSION['message'] = "Gagal menghapus data.";
    }
}

// Redirect kembali ke halaman hasil_analis.php
header("Location: hasil_perhitungan.php");
exit();
?>
