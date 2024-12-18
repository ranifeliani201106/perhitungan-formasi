<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Halaman Utama</title>
  <style>
    body {
      margin: 0;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      background: 
        linear-gradient(rgba(46, 125, 50, 0.3), rgba(46, 125, 50, 0.7)),
        url('img/pusbin.jpg') center/cover no-repeat;
    }
    .main-content {
      display: flex;
      flex-grow: 1;
      justify-content: center;
      align-items: center;
      margin-top: 90px; /* Menambahkan jarak atas */
    }
    .login-container {
      position: relative;
      background-color: rgba(46, 125, 50, 0.9);
      color: white;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
      max-width: 400px;
      width: 100%;
      text-align: center;
    }
    .logo-container {
      position: absolute;
      top: -70px;
      left: 50%;
      transform: translateX(-50%);
    }
    .logo-container img {
      max-width: 100px;
      border-radius: 50%;
      background-color: white;
      padding: 20px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .btn-primary {
      background-color: #388e3c;
      border-color: #388e3c;
    }
    .btn-primary:hover {
      background-color: #2c6b2f;
      border-color: #2c6b2f;
    }
    .footer {
      background-color: rgba(240, 240, 240, 0.9);
      color: #333;
      text-align: center;
      font-size: 14px;
      padding: 10px;
      border-top: 2px solid rgba(46, 125, 50, 0.5);
    }
    .footer p {
      margin: 0;
      line-height: 1.5;
    }
    .footer strong {
      color: #2e7d32;
    }
    /* Styling untuk info di luar kotak */
    .info-container {
      margin-top: 20px;
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
      padding: 20px;
      width: 100%;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
      text-align: left;
    }
    .info-container h5 {
      color: #ffffff;
      margin-bottom: 10px;
    }
    .info-container p, .info-container ul {
      color: #f0f0f0;
    }
  </style>
</head>
<body>

<!-- Konten Utama -->
<div class="main-content">
  <div class="login-container">
    <!-- Logo di luar kotak -->
    <div class="logo-container">
      <img src="img/pusbin_logo.jpg" alt="Logo">
    </div>

    <h2>Selamat Datang</h2>
    <p>Aplikasi Perhitungan Formasi</p>

    <div>
      <a href="user/login_user.php" class="btn btn-primary w-100 mb-2">Login sebagai User</a>
      <a href="admin/login_admin.php" class="btn btn-primary w-100">Login sebagai Admin</a>
    </div>
  </div>
</div>

<!-- Informasi tentang aplikasi di luar kotak -->
<div class="info-container">
  <h5>Tentang Aplikasi</h5>
  <p>Aplikasi ini membantu menghitung formasi kerja secara cepat, akurat, dan efisien.</p>
  <p>Fitur utama meliputi:</p>
  <ul>
    <li>Perhitungan formasi berdasarkan ruang lingkup kerja.</li>
    <li>Pengelolaan data formasi untuk admin.</li>
    <li>Hasil perhitungan detail dan terorganisasi.</li>
  </ul>
  <p>Aplikasi dirancang untuk mempermudah instansi dalam pengelolaan kebutuhan formasi pekerjaan.</p>
</div>

<!-- Footer -->
<div class="footer">
  <p><strong>Informasi Pusat Pembinaan Jabatan Fungsional Perdagangan</strong></p>
  <p>Alamat: Jl. Daeng, M.Ardiwinata KM 3.4</p>
  <p>Telepon: (022) 6611054</p>
  <p>Website: <a href="https://pusbinjfdag.kemendag.go.id/" target="_blank">https://pusbinjfdag.kemendag.go.id/</a></p>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
