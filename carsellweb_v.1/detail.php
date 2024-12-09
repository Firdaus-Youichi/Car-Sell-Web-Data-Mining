<?php
include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id_produk = $_GET['id'];
$query = "SELECT * FROM produk WHERE id_produk = $id_produk";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: dashboard.php");
    exit;
}

$produk = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>
<div class="container mt-5">
    <h2>Detail Produk</h2>
    <div class="card">
        <img src="data:image/jpeg;base64,<?= base64_encode($produk['gambar']) ?>" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title"><?= $produk['nama_mobil'] ?></h5>
            <p class="card-text">Kategori: <?= $produk['kategori'] ?></p>
            <p class="card-text"><?= $produk['deskripsi'] ?></p>
            <p class="card-text">Alamat: <?= $produk['alamat'] ?></p>
            <p class="card-text">Harga: Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>
            <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
