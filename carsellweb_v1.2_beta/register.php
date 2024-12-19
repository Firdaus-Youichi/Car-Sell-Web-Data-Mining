<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "INSERT INTO user (email, password) VALUES ('$email', '$password')";
    if (mysqli_query($conn, $query)) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Gagal mendaftar. Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="text-center mb-4">
        <img src="assets/logomobilwhite.png" alt="Logo" style="width: 350px; height: auto;">
    </div>
    <h5 class="text-center">R E G I S T E R</h5>
    <form method="POST">
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
            <label>Password:</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
