<?php
include 'koneksi_admin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Menggunakan htmlspecialchars untuk melindungi dari XSS
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);
    $role = 'admin'; // Role otomatis admin

    // Validasi password dan konfirmasi password
    if ($password !== $confirm_password) {
        echo "<script>alert('Password dan konfirmasi password tidak cocok!');</script>";
    } else {
        // Hash password sebelum menyimpannya ke database
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Menggunakan prepared statement untuk mencegah SQL Injection
        $query = "INSERT INTO user (username, email, password, role) VALUES (:username, :email, :password, :role)";
        $stmt = $pdo->prepare($query);

        // Binding parameter
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':role', $role);

        // Eksekusi query
        if ($stmt->execute()) {
            echo "<script>alert('Registrasi berhasil sebagai Admin! Silakan login.');</script>";
        } else {
            echo "<script>alert('Registrasi gagal.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Registrasi Admin</title>
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
    .register-container {
      background-color: #ffffff;
      color: #388e3c;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    h2 {
      color: #388e3c;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <div class="register-container">
    <h2 class="text-center">Registrasi Admin</h2>

    <!-- Form Registrasi -->
    <form method="POST" action="">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <div class="mb-3">
        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
      </div>

      <button type="submit" class="btn btn-green w-100">Registrasi sebagai Admin</button>
    </form>

    <p class="mt-3 text-center">Sudah punya akun? <a href="login_admin.php" class="text-decoration-none" style="color: #388e3c;">Login disini</a></p>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
