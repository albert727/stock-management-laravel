<?php
require 'function.php';
require 'cek.php';

// Mengambil total jumlah produk
$result_produk = mysqli_query($conn, "SELECT COUNT(*) AS total_produk FROM tb_stok");
$data_produk = mysqli_fetch_assoc($result_produk);
$total_produk = $data_produk['total_produk'];

// Mengambil total stok masuk
$result_masuk = mysqli_query($conn, "SELECT SUM(stok) AS total_masuk FROM tb_masuk");
$data_masuk = mysqli_fetch_assoc($result_masuk);
$total_masuk = $data_masuk['total_masuk'] ?? 0;

// Mengambil total stok keluar
$result_keluar = mysqli_query($conn, "SELECT SUM(stok) AS total_keluar FROM tb_keluar");
$data_keluar = mysqli_fetch_assoc($result_keluar);
$total_keluar = $data_keluar['total_keluar'] ?? 0;

// QUERY DASHBOARD PRODUK (HARUS DI DALAM PHP)
$produk_dashboard = mysqli_query($conn, "
    SELECT nama_produk, stok
    FROM tb_stok
    ORDER BY stok ASC
");

// Batas stok menipis
$batas_stok = 10;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        .sb-sidenav-menu .nav-link {
            transition: all 0.3s ease;
        }
        .sb-sidenav-menu .nav-link:hover {
            transform: translateX(10px);
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="LogoHerbalPremium.png" alt="Logo" style="height: 30px; margin-right: 10px;">
            <span class="d-none d-sm-inline">herbalpremium.id</span>
        </a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 ml-auto" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link text-primary" href="stok_produk.php">
                            <div class="sb-nav-link-icon text-primary"><i class="fas fa-box"></i></div>
                            Stok Produk
                        </a>
                        <a class="nav-link text-success" href="stok_masuk.php">
                            <div class="sb-nav-link-icon text-success"><i class="fas fa-arrow-down"></i></div>
                            Stok Masuk
                        </a>
                        <a class="nav-link text-danger" href="stok_keluar.php">
                            <div class="sb-nav-link-icon text-danger"><i class="fas fa-arrow-up"></i></div>
                            Stok Keluar
                        </a>
                        <a class="nav-link text-warning" href="laporan.php">
                            <div class="sb-nav-link-icon text-warning"><i class="fas fa-file-alt"></i></div>
                            Laporan
                        </a>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="text-center my-2">
                    <a class="btn btn-danger btn-sm" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Dashboard Utama</h1>
                    <div class="card mb-4">
                        <p>Selamat datang di aplikasi pengelolaan stok produk herbalpremium.id. Gunakan menu di samping untuk mengelola data Anda.</p>
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">


    <!-- Total Produk -->
    <div class="col-xl-3 col-md-4 mb-3">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                Total Produk
                <h2><?= $total_produk; ?></h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="stok_produk.php">Lihat Detail</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <!-- CARD PRODUK (DINAMIS) -->
    <?php while ($row = mysqli_fetch_assoc($produk_dashboard)) :

        $stok = $row['stok'];

        if ($stok <= 49) {
            $bg = 'bg-danger';
            $status = 'Stok Kritis';
            $icon = 'fas fa-exclamation-triangle';
        } elseif ($stok <= 99) {
            $bg = 'bg-warning';
            $status = 'Stok Menipis';
            $icon = 'fas fa-exclamation-circle';
        } else {
            $bg = 'bg-success';
            $status = 'Stok Aman';
            $icon = 'fas fa-check-circle';
        }

    ?>
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-3">
        <div class="card text-white <?= $bg ?> h-100">
            <div class="card-body">
                <h6><?= htmlspecialchars($row['nama_produk']); ?></h6>
                <p class="mb-1"><strong>Stok:</strong> <?= $stok; ?></p>
                <small><i class="<?= $icon ?>"></i> <?= $status; ?></small>
            </div>
        </div>
    </div>
<?php endwhile; ?>

</div>


</div>

                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>
</body>

</html>