<header class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container-fluid">
        <!-- Logo -->
        <a href="dashboard.php" class="navbar-brand">
            <img src="assets/logomobilight.png" alt="Logo" height="40">
        </a>
        
        <!-- Toggle Button for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                 <!-- Link Dashboard -->
                 <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
                <!-- Dropdown Kategori -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownKategori" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Kategori
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownKategori">
                        <li><a class="dropdown-item" href="dashboard.php">Semua Kategori</a></li>
                        <li><a class="dropdown-item" href="dashboard.php?kategori=mpv">MPV</a></li>
                        <li><a class="dropdown-item" href="dashboard.php?kategori=suv">SUV</a></li>
                        <li><a class="dropdown-item" href="dashboard.php?kategori=sedan">Sedan</a></li>
                        <li><a class="dropdown-item" href="dashboard.php?kategori=hatchback">Hatchback</a></li>
                    </ul>
                </li>

                <!-- Link Estimasi Harga -->
                <li class="nav-item">
                    <a class="nav-link" href="estimasi.php">Estimasi Harga</a>
                </li>
            </ul>

            <!-- Kolom Pencarian -->
            <form class="d-flex me-3 align-items-center" action="dashboard.php" method="GET">
                <input class="form-control me-2" type="search" name="search" placeholder="Cari produk..." aria-label="Search" style="max-width: 300px;">
                <button class="btn btn-outline-success" type="submit">Cari</button>
            </form>

            <!-- Menu Keranjang -->
            <a href="keranjang.php" class="btn btn-primary position-relative me-3">
                <i class="bi bi-cart"></i> <!-- Ikon Keranjang -->
                <?php if (!empty($_SESSION['keranjang'])): ?>
                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                        <?= count($_SESSION['keranjang']); ?>
                    </span>
                <?php endif; ?>
            </a>

            <!-- Tombol Jual -->
            <a href="jual.php" class="btn btn-primary me-2">Jual</a>

            <!-- Tombol Logout -->
            <form action="logout.php" method="POST" class="d-inline">
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</header>
