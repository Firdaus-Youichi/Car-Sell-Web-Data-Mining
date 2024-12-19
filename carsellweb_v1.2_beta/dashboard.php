<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

$query = "SELECT * FROM produk";
if (isset($_GET['kategori'])) {
    $kategori = $_GET['kategori'];
    $query .= " WHERE kategori = '$kategori'";
}
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $query .= " WHERE nama_mobil LIKE '%$search%'";
}
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            height: 400px; /* Tinggi tetap untuk card */
        }

        .card-img-top {
            height: 200px; /* Tinggi tetap untuk gambar */
            object-fit: cover; /* Menyesuaikan gambar tanpa distorsi */
        }

        .card-body {
            overflow: hidden; /* Membatasi konten agar tidak keluar dari card */
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<div class="container mt-5">
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="data:image/jpeg;base64,<?= base64_encode($row['gambar']) ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['nama_mobil'] ?></h5>
                        <p class="card-text"><?= substr($row['deskripsi'], 0, 100) ?>...</p>
                        <p class="card-text">Harga: Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
                        <a href="detail.php?id=<?= $row['id_produk'] ?>" class="btn btn-primary">Detail</a>
                        <!-- Tombol Beli -->
                        <form action="keranjang.php" method="POST" class="d-inline">
                            <input type="hidden" name="id_produk" value="<?= $row['id_produk'] ?>">
                            <input type="hidden" name="nama_mobil" value="<?= $row['nama_mobil'] ?>">
                            <input type="hidden" name="harga" value="<?= $row['harga'] ?>">
                            <button type="submit" class="btn btn-success">Beli</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
