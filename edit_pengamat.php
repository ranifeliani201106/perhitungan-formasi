<?php
session_start();
include('koneksi_admin.php');

// Pastikan admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: login_admin.php');
    exit;
}

// Pastikan ada parameter id
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: hasil_pengamat.php'); // Redirect jika tidak ada id
    exit;
}

$id = (int)$_GET['id'];

// Ambil data berdasarkan id
$query = "SELECT * FROM hasil_pengamat WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    echo "Data tidak ditemukan!";
    exit;
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ruang_lingkup = $_POST['ruang_lingkup'];
    $deskripsi = $_POST['deskripsi'];
    $volume = $_POST['volume'];
    $keterangan = $_POST['keterangan'];

    // Hitung ulang kebutuhan berdasarkan ruang lingkup
    switch ($ruang_lingkup) {
        case "Hasil pemetaan potensi Alat Ukur, Alat Takar, Alat Timbang, dan Alat Perlengkapan serta Barang Dalam Keadaan Terbungkus":
            $skr = 12.00;
            $persentase = [0.09, 0.41, 0.30, 0.20];
            break;
        case "Hasil Pemeriksaan dokumen Alat Ukur, Alat Takar, Alat Timbang, dan Alat Perlengkapan serta Barang Dalam Keadaan Terbungkus":
            $skr = 9.00;
            $persentase = [0.10, 0.40, 0.34, 0.16];
            break;
        case " hasil pengamatan kasat mata terhadap penggunaan Alat Ukur, Alat Takar, Alat Timbang, dan  Alat Perlengkapan, Barang Dalam Keadaan Terbungkus dan satuan ukuran":
            $skr = 17.00;
            $persentase = [0.10, 0.38, 0.30, 0.22];
            break;
        default:
            echo "Ruang lingkup tidak valid!";
            exit;
    }
    $pemula = round(($skr * $volume * $persentase[0]) / 1250, 2);
    $terampil = round(($skr * $volume * $persentase[1]) / 1250, 2);
    $mahir = round(($skr * $volume * $persentase[2]) / 1250, 2);
    $penyila = round(($skr * $volume * $persentase[3]) / 1250, 2);


    // Update data ke database
    $insertQuery = "INSERT INTO verifikasi_pengamat 
                    (ruang_lingkup, deskripsi, volume, pemula, terampil, mahir, penyila, keterangan, id_asal) 
                    VALUES (:ruang_lingkup, :deskripsi, :volume, :pemula, :terampil, :mahir, :penyila, :keterangan, :id_asal)";

$insertStmt = $pdo->prepare($insertQuery);
$insertStmt->bindParam(':ruang_lingkup', $ruang_lingkup, PDO::PARAM_STR);
$insertStmt->bindParam(':deskripsi', $deskripsi, PDO::PARAM_STR);
$insertStmt->bindParam(':volume', $volume, PDO::PARAM_INT);
$insertStmt->bindParam(':pemula', $pemula, PDO::PARAM_STR);
$insertStmt->bindParam(':terampil', $terampil, PDO::PARAM_STR);
$insertStmt->bindParam(':mahir', $mahir, PDO::PARAM_STR);
$insertStmt->bindParam(':penyila', $penyila, PDO::PARAM_STR);
$insertStmt->bindParam(':keterangan', $keterangan, PDO::PARAM_STR);
$insertStmt->bindParam(':id_asal', $id, PDO::PARAM_INT);

    if ($insertStmt->execute()) {
        header('Location: admin_pengamat.php?success=edit'); // Redirect ke halaman utama
        exit;
    } else {
        echo "Terjadi kesalahan saat menyimpan data ke verifikasi!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Hasil Pengamat Tera</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Data Hasil Pengamat Tera</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="ruang_lingkup" class="form-label">Ruang Lingkup</label>
            <input type="text" id="ruang_lingkup" name="ruang_lingkup" class="form-control" value="<?php echo htmlspecialchars($data['ruang_lingkup']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" class="form-control" required><?php echo htmlspecialchars($data['deskripsi']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="volume" class="form-label">Volume</label>
            <input type="number" id="volume" name="volume" class="form-control" value="<?php echo htmlspecialchars($data['volume']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="pemula" class="form-label">Pemula</label>
            <input type="number" id="pemula" name="pemula" class="form-control" value="<?php echo htmlspecialchars($data['pemula']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="terampil" class="form-label">Terampil</label>
            <input type="number" id="terampil" name="terampil" class="form-control" value="<?php echo htmlspecialchars($data['terampil']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="mahir" class="form-label">Mahir</label>
            <input type="number" id="mahir" name="mahir" class="form-control" value="<?php echo htmlspecialchars($data['mahir']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="penyila" class="form-label">Penyila</label>
            <input type="number" id="penyila" name="penyila" class="form-control" value="<?php echo htmlspecialchars($data['penyila']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea id="keterangan" name="keterangan" class="form-control"><?php echo htmlspecialchars($data['keterangan']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="admin_pengamat.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
