<?php
// Sertakan koneksi.php
include 'koneksi.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Persiapkan query untuk memeriksa user
    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql); // Menyiapkan query untuk MySQLi
    mysqli_stmt_bind_param($stmt, 's', $username); // Mengikat parameter (username)
    mysqli_stmt_execute($stmt); // Menjalankan query
    $result = mysqli_stmt_get_result($stmt); // Mendapatkan hasil query

    // Ambil data user yang ditemukan
    $user = mysqli_fetch_assoc($result);

    // Cek apakah user ditemukan
    if ($user && password_verify($password, $user['password'])) {
        // Jika username dan password cocok, lakukan login
        $_SESSION['iduser'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['namainstansi'] = $user['namainstansi'];
        header("Location: dashboard_user.php");
        exit;
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User</title>
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
        <h2>Login User</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-green">Login</button>
        </form>
        <p class="mt-3">Belum punya akun? <a href="register_user.php">Daftar di sini</a></p>
    </div>
</body>
</html>
