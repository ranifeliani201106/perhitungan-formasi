<?php
// Koneksi database
include 'koneksi.php';

$error = ''; // Inisialisasi variabel error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = $_POST['username'];
    $namapic = $_POST['namapic'];
    $namainstansi = $_POST['namainstansi'];
    $daerah = $_POST['daerah'];
    $no_telp = $_POST['no_telp'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];
    $role = $_POST['role']; // Role, misal 'admin' atau 'peserta'

    // Validasi input
    if ($password !== $password_confirmation) {
        $error = "Password dan konfirmasi password tidak cocok.";
    } else {
        // Cek apakah username sudah terdaftar
        $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->execute([$username]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            $error = "Username sudah terdaftar.";
        } else {
            // Hash password sebelum disimpan
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Simpan pengguna baru ke database
            $stmt = $pdo->prepare("INSERT INTO user (username, namapic, namainstansi, daerah, no_telp, password, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$username, $namapic, $namainstansi, $daerah, $no_telp, $hashedPassword, $role])) {
                header("Location: login_user.php");
                exit;
            } else {
                $error = "Pendaftaran gagal, coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #e8f5e9; /* Background hijau muda */
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .form-control, .btn {
            border-radius: 10px;
        }
        .btn-green {
            background-color: #388e3c; /* Warna hijau */
            color: white;
        }
        .btn-green:hover {
            background-color: #2e7d32;
        }
        .alert-danger {
            background-color: #f44336;
            color: white;
        }
        h2 {
            color: #388e3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Akun</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="namapic">Nama PIC</label>
                <input type="text" name="namapic" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="namainstansi">Nama Instansi</label>
                <input type="text" name="namainstansi" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="daerah">Daerah</label>
                <input type="text" name="daerah" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="no_telp">Nomor Telepon</label>
                <input type="text" name="no_telp" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" class="form-control">
                    <option value="admin">Admin</option>
                    <option value="peserta">Peserta</option>
                </select>
            </div>
            <button type="submit" class="btn btn-green">Daftar</button>
        </form>
        <p class="mt-3">Sudah punya akun? <a href="login_user.php">Login di sini</a></p>
    </div>
</body>
</html>
