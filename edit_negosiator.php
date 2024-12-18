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
    header('Location: hasil_perhitungan.php'); // Redirect jika tidak ada id
    exit;
}

$id = (int)$_GET['id'];

// Ambil data berdasarkan id
$query = "SELECT * FROM hasil_perhitungan WHERE id = :id";
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
        case "Hasil Kerja sama":
            $skr = 220.00;
            $persentase = [0.38, 0.34, 0.25, 0.03];
            break;
        case "Hasil Perundingan":
            $skr = 495.00;
            $persentase = [0.36, 0.32, 0.30, 0.02];
            break;
        case "Tindaklanjut hasil perundingan":
            $skr = 205.00;
            $persentase = [0.40, 0.36, 0.20, 0.04];
            break;
        default:
            echo "Ruang lingkup tidak valid!";
            exit;
    }    

    $pertama = round(($skr * $volume * $persentase[0]) / 1250, 2);
    $muda = round(($skr * $volume * $persentase[1]) / 1250, 2);
    $madya = round(($skr * $volume * $persentase[2]) / 1250, 2);
    $utama = round(($skr * $volume * $persentase[3]) / 1250, 2);

    // Update data ke database
    $insertQuery = "INSERT INTO verifikasi_negosiator
                    (ruang_lingkup, deskripsi, volume, pertama, muda, madya, utama, keterangan, id_asal) 
                    VALUES (:ruang_lingkup, :deskripsi, :volume, :pertama, :muda, :madya, :utama, :keterangan, :id_asal)";

$insertStmt = $pdo->prepare($insertQuery);
$insertStmt->bindParam(':ruang_lingkup', $ruang_lingkup, PDO::PARAM_STR);
$insertStmt->bindParam(':deskripsi', $deskripsi, PDO::PARAM_STR);
$insertStmt->bindParam(':volume', $volume, PDO::PARAM_INT);
$insertStmt->bindParam(':pertama', $pertama, PDO::PARAM_STR);
$insertStmt->bindParam(':muda', $muda, PDO::PARAM_STR);
$insertStmt->bindParam(':madya', $madya, PDO::PARAM_STR);
$insertStmt->bindParam(':utama', $utama, PDO::PARAM_STR);
$insertStmt->bindParam(':keterangan', $keterangan, PDO::PARAM_STR);
$insertStmt->bindParam(':id_asal', $id, PDO::PARAM_INT);

    if ($insertStmt->execute()) {
        header('Location: admin_negosiator.php?success=edit'); // Redirect ke halaman utama
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
    <title>Edit Hasil Negosiator Perdagangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Data Hasil Negosiator Perdagangan</h2>
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
            <label for="pertama" class="form-label">Pertama</label>
            <input type="number" id="pertama" name="pertama" class="form-control" value="<?php echo htmlspecialchars($data['pertama']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="muda" class="form-label">Muda</label>
            <input type="number" id="muda" name="muda" class="form-control" value="<?php echo htmlspecialchars($data['muda']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="madya" class="form-label">Madya</label>
            <input type="number" id="madya" name="madya" class="form-control" value="<?php echo htmlspecialchars($data['madya']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="utama" class="form-label">Utama</label>
            <input type="number" id="utama" name="utama" class="form-control" value="<?php echo htmlspecialchars($data['utama']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea id="keterangan" name="keterangan" class="form-control"><?php echo htmlspecialchars($data['keterangan']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="admin_negosiator.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
