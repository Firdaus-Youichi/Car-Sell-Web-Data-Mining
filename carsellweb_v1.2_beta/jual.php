<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_mobil = $_POST['nama_mobil'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];
    $alamat = $_POST['alamat'];
    $harga = $_POST['harga'];

    $gambar = addslashes(file_get_contents($_FILES['gambar']['tmp_name']));

    $query = "INSERT INTO produk (nama_mobil, kategori, deskripsi, alamat, harga, gambar) 
              VALUES ('$nama_mobil', '$kategori', '$deskripsi', '$alamat', $harga, '$gambar')";
    if (mysqli_query($conn, $query)) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Gagal menambahkan produk. Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jual Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>
<div class="container mt-5">
    <h2>Jual Produk</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nama Mobil:</label>
            <input type="text" class="form-control" name="nama_mobil" required>
        </div>
        <div class="mb-3">
            <label>Kategori:</label>
            <select name="kategori" class="form-select" required>
                <option value="mpv">MPV</option>
                <option value="suv">SUV</option>
                <option value="sedan">Sedan</option>
                <option value="hatchback">Hatchback</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Deskripsi:</label>
            <textarea class="form-control" name="deskripsi" required></textarea>
        </div>
        <div class="mb-3">
            <label>Alamat:</label>
            <input type="text" class="form-control" name="alamat" required>
        </div>
        <div class="mb-3">
            <label>Harga:</label>
            <input type="number" class="form-control" name="harga" required>
        </div>
        <div class="mb-3">
            <label>Gambar:</label>
            <input type="file" class="form-control" name="gambar" accept="image/*" required>
        </div>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary">Jual</button>
        <a href="dashboard.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
