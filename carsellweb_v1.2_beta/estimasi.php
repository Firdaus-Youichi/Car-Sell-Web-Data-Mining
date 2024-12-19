<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $jenis_mobil = $_POST['jenis_mobil'];
    $tahun = $_POST['tahun'];
    $kilometer = $_POST['kilometer'];

    // Perintah untuk menjalankan script Python
    $command = escapeshellcmd("python3 estimasi_hargamobil.py $jenis_mobil $tahun $kilometer");
    $output = shell_exec($command);

    // Hasil dari Python
    $hasil_estimasi = trim($output);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estimasi Harga Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>
<div class="container mt-5">
    <h2 class="text-center">Estimasi Harga Mobil</h2>
    <form method="POST" class="mt-4">
        <div class="mb-3">
            <label for="jenis_mobil" class="form-label">Jenis Mobil</label>
            <input type="text" id="jenis_mobil" name="jenis_mobil" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="tahun" class="form-label">Tahun</label>
            <input type="number" id="tahun" name="tahun" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="kilometer" class="form-label">Kilometer</label>
            <input type="number" id="kilometer" name="kilometer" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Estimasi</button>
    </form>

    <?php if (isset($hasil_estimasi)): ?>
        <div class="alert alert-success mt-4">
            <h4>Hasil Estimasi:</h4>
            <p><?= $hasil_estimasi ?></p>
        </div>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
