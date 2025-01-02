<?php
session_start();
include 'config.php'; // Koneksi database

// Pastikan pengguna sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['user']['id_user']; // ID pengguna yang login

// Tambahkan produk ke keranjang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produk'])) {
    $id_produk = $_POST['id_produk'];

    // Cek apakah produk sudah ada di keranjang
    $query = "SELECT * FROM keranjang WHERE id_user = $id_user AND id_produk = $id_produk";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Jika produk sudah ada, update jumlah
        $query = "UPDATE keranjang SET jumlah = jumlah + 1 WHERE id_user = $id_user AND id_produk = $id_produk";
    } else {
        // Jika produk belum ada, tambahkan ke keranjang
        $query = "INSERT INTO keranjang (id_user, id_produk) VALUES ($id_user, $id_produk)";
    }
    mysqli_query($conn, $query);

    // Redirect kembali ke halaman keranjang
    header("Location: keranjang.php");
    exit;
}

// Hapus item tertentu dari keranjang
if (isset($_GET['hapus'])) {
    $id_keranjang = $_GET['hapus'];
    $query = "DELETE FROM keranjang WHERE id_keranjang = $id_keranjang AND id_user = $id_user";
    mysqli_query($conn, $query);
    header("Location: keranjang.php");
    exit;
}

// Kosongkan keranjang (tombol Batal)
if (isset($_POST['batal'])) {
    $query = "DELETE FROM keranjang WHERE id_user = $id_user";
    mysqli_query($conn, $query);
    header("Location: dashboard.php");
    exit;
}

// Checkout dan tampilkan notifikasi pembayaran sukses
$notifikasi = '';
if (isset($_POST['checkout'])) {
    if (isset($_POST['metode_pembayaran'])) {
        $metode_pembayaran = $_POST['metode_pembayaran'];

        // Hapus semua item dari keranjang setelah checkout
        $query = "DELETE FROM keranjang WHERE id_user = $id_user";
        mysqli_query($conn, $query);

        $notifikasi = "Pembayaran berhasil menggunakan metode: $metode_pembayaran.";
    } else {
        $notifikasi = "Silakan pilih metode pembayaran terlebih dahulu!";
    }
}

// Ambil data keranjang dari database
$query = "
    SELECT k.id_keranjang, p.nama_mobil, p.harga, k.jumlah 
    FROM keranjang k
    JOIN produk p ON k.id_produk = p.id_produk
    WHERE k.id_user = $id_user
";
$result = mysqli_query($conn, $query);
$keranjang = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>
<div class="container mt-5">
    <h2 class="text-center">Keranjang</h2>
    <?php if (!empty($keranjang)): ?>
        <form method="POST">
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Mobil</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($keranjang as $index => $item): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $item['nama_mobil'] ?></td>
                            <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                            <td><?= $item['jumlah'] ?></td>
                            <td>Rp <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.') ?></td>
                            <td>
                                <!-- Tombol Hapus untuk item tertentu -->
                                <a href="keranjang.php?hapus=<?= $item['id_keranjang'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pilih Metode Pembayaran -->
            <div class="mb-4">
                <h5>Pilih Metode Pembayaran</h5>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="metode_pembayaran" id="tunai" value="Tunai">
                    <label class="form-check-label" for="tunai">Tunai</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="metode_pembayaran" id="bri" value="Bank BRI">
                    <label class="form-check-label" for="bri">Bank BRI</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="metode_pembayaran" id="bca" value="Bank BCA">
                    <label class="form-check-label" for="bca">Bank BCA</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="metode_pembayaran" id="bni" value="Bank BNI">
                    <label class="form-check-label" for="bni">Bank BNI</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="metode_pembayaran" id="mandiri" value="Bank Mandiri">
                    <label class="form-check-label" for="mandiri">Bank Mandiri</label>
                </div>
            </div>

            <!-- Tombol Batal dan Checkout -->
            <div class="d-flex justify-content-between">
                <button type="submit" name="batal" class="btn btn-secondary">Batal</button>
                <button type="submit" name="checkout" class="btn btn-success">Checkout</button>
            </div>
        </form>
    <?php else: ?>
        <div class="alert alert-info text-center">Keranjang kosong!</div>
        <div class="text-center mt-3">
            <a href="dashboard.php" class="btn btn-primary">Kembali ke Dashboard</a>
        </div>
    <?php endif; ?>

    <!-- Notifikasi Pembayaran -->
    <?php if ($notifikasi): ?>
        <div class="alert alert-success mt-4 text-center">
            <?= $notifikasi ?>
        </div>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
