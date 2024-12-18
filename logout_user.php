<?php
// Memulai sesi
session_start();

// Menghapus semua sesi
session_unset(); 

// Menghancurkan sesi
session_destroy(); 

// Mengarahkan pengguna kembali ke halaman login atau halaman utama
header("Location: login_user.php");
exit;
?>
