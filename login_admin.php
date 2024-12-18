<?php
include 'koneksi_admin.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Query untuk mengambil data user admin menggunakan PDO
    $query = "SELECT * FROM user WHERE username = :username AND role = 'admin'";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    
    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Set sesi untuk admin
            $_SESSION['admin'] = $user['iduser'];
            $_SESSION['namainstansi'] = $user['namainstansi']; // Menyimpan nama instansi
            $_SESSION['username'] = $user['username']; // Menyimpan username
            $_SESSION['role'] = $user['role']; // Menyimpan role
            header("Location: dashboard_admin.php"); // Redirect ke dashboard admin
            exit;
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username tidak ditemukan atau bukan admin.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Login Admin</title>
  <style>
    body {
        background-color: #e8f5e9; /* Background hijau muda */
    }
    .container {
        max-width: 600px;
        margin-top: 50px;
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
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
  <h2 class="text-center mb-4">Login Admin</h2>

  <?php if (isset($error)): ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $error; ?>
    </div>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" id="username" name="username" required>
    </div>
    
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" id="password" name="password" required>
    </div>

    <button type="submit" class="btn btn-green w-100">Login</button>
  </form>

  <p class="mt-3 text-center">Belum punya akun? <a href="register_admin.php" class="text-success">Registrasi disini</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
