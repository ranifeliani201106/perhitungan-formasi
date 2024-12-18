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
    header('Location: hasil_analis.php'); // Redirect jika tidak ada id
    exit;
}

$id = (int)$_GET['id'];

// Ambil data berdasarkan id
$query = "SELECT * FROM hasil_analis WHERE id = :id";
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
        case "Pengelolaan Ekspor Dan Impor":
            $skr = 270.00;
            $persentase = [0.43, 0.32, 0.20, 0.05];
            break;
        case "Pengendalian Harga Dan Pengelolaan Distribusi":
            $skr = 235.00;
            $persentase = [0.37, 0.33, 0.27, 0.03];
            break;
        case "Pemrosesan Persetujuan Perizinan":
            $skr = 16.50;
            $persentase = [0.47, 0.39, 0.14, 0.00];
            break;
        case "Penjamin Mutu":
            $skr = 205.00;
            $persentase = [0.40, 0.35, 0.20, 0.05];
            break;
        case "Pengembangan Ekspor":
            $skr = 255.00;
            $persentase = [0.43, 0.33, 0.20, 0.04];
            break;
        case "Penyuluhan Dan Edukasi Bidang Perdagangan":
            $skr = 55.00;
            $persentase = [0.45, 0.38, 0.17, 0.00];
            break;
        case "Pelindungan Dan Pengamanan Perdagangan":
            $skr = 353.00;
            $persentase = [0.40, 0.30, 0.25, 0.05];
            break;
        case "Pengaturan PBK/SRG/PLK":
            $skr = 208.00;
            $persentase = [0.41, 0.34, 0.20, 0.05];
            break;
        case "Pengembangan Metrologi Legal":
            $skr = 55.00;
            $persentase = [0.43, 0.33, 0.20, 0.04];
            break;
        case "Penanganan Pengaduan Konsumen":
            $skr = 22.00;
            $persentase = [0.40, 0.32, 0.25, 0.03];
            break;
        case "Pembinaan Dan Pengembangan Bidang Perdagangan":
            $skr = 110.00;
            $persentase = [0.48, 0.37, 0.20, 0.05];
            break;
        case "Analisis Isu Perdagangan":
            $skr = 55.00;
            $persentase = [0.41, 0.38, 0.17, 0.04];
            break;
        case "Kebijakan Bidang Perdagangan":
            $skr = 546.00;
            $persentase = [0.40, 0.35, 0.18, 0.07];
            break;
        default:
            echo "Ruang lingkup tidak valid!";
            exit;
    }

    $pertama = ($skr * $volume * $persentase[0]) / 1250;
    $muda = ($skr * $volume * $persentase[1]) / 1250;
    $madya = ($skr * $volume * $persentase[2]) / 1250;
    $utama = ($skr * $volume * $persentase[3]) / 1250;

    // Update data ke database
    $insertQuery = "INSERT INTO verifikasi_analis 
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
        header('Location: admin_analis.php?success=edit'); // Redirect ke halaman utama
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
    <title>Edit Hasil Analis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Data Hasil Analis</h2>
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
        <a href="admin_analis.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
