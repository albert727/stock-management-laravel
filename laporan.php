<?php
require 'function.php';
require 'cek.php';
$tampil = $_GET['tampil'] ?? 'semua'; // nilai default = semua

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Laporan stok</title>
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
                    <?php
                    $judulLaporan = 'Laporan Stok';

                    if ($tampil == 'masuk') {
                        $judulLaporan = 'Laporan Stok Masuk';
                    } elseif ($tampil == 'keluar') {
                        $judulLaporan = 'Laporan Stok Keluar';
                    }
                    ?>

                    <h1 class="mt-4"><?php echo $judulLaporan; ?></h1>
                    <?php if (isset($_SESSION['error'])) : ?>
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <?= $_SESSION['error']; ?>
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>


                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Laporan stok keluar dan masuk</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-filter mr-1"></i>
                            Filter Laporan Berdasarkan Waktu
                        </div>
                        <div class="card-body">
                            <form method="GET" action="laporan.php" class="row">
                                <div class="col-md-3 mb-2">
                                    <label>Dari Tanggal:</label>
                                    <input type="date" name="dari" class="form-control" required value="<?php echo $_SESSION['dari'] ?? ''; ?>">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label>Sampai Tanggal:</label>
                                    <input type="date" name="sampai" class="form-control" required value="<?php echo $_SESSION['sampai'] ?? ''; ?>">
                                </div>
                                <div class="col-md-2 mb-2">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary form-control">
                                        Tampilkan
                                    </button>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <label>&nbsp;</label>
                                    <div class="dropdown">
                                        <button class="btn btn-danger dropdown-toggle form-control" type="button" id="dropdownCetak" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-print"></i> Cetak PDF
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownCetak">
                                            <a class="dropdown-item"
                                            href="cetak_laporan.php?dari=<?= $_GET['dari'] ?? '' ?>&sampai=<?= $_GET['sampai'] ?? '' ?>&tampil=semua">
                                                <i class="fas fa-print"></i> Cetak Gabungan
                                            </a>
                                            <a class="dropdown-item" href="cetak_masuk.php?dari=<?php echo $_GET['dari'] ?? ''; ?>&sampai=<?php echo $_GET['sampai'] ?? ''; ?>" >
                                                <i class="fas fa-download"></i> Cetak Masuk
                                            </a>
                                            <a class="dropdown-item" href="cetak_keluar.php?dari=<?php echo $_GET['dari'] ?? ''; ?>&sampai=<?php echo $_GET['sampai'] ?? ''; ?>">
                                                <i class="fas fa-download"></i> Cetak Keluar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <label>&nbsp;</label>   
                                    <a href="laporan.php?reset=1" class="btn btn-secondary form-control">
                                        <i class="fas fa-times-circle"></i> Reset Laporan
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Tabel hasil laporan -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                            <h5 class="mb-0"><i class="fas fa-clipboard-list mr-2"></i>Data Laporan Stok</h5>
                            <div class="col-md-3 mb-2">
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle form-control" type="button" id="dropdownTampil" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-eye"></i> Tampilkan
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownTampil">
                                        <a class="dropdown-item" href="laporan.php?tampil=semua&dari=<?php echo $_SESSION['dari'] ?? ''; ?>&sampai=<?php echo $_SESSION['sampai'] ?? ''; ?>">
                                            <i class="fas fa-list mr-2"></i> Laporan Gabungan
                                        </a>
                                        <a class="dropdown-item" href="laporan.php?tampil=masuk&dari=<?php echo $_SESSION['dari'] ?? ''; ?>&sampai=<?php echo $_SESSION['sampai'] ?? ''; ?>">
                                            <i class="fas fa-arrow-down mr-2 text-success"></i> Stok Masuk
                                        </a>
                                        <a class="dropdown-item" href="laporan.php?tampil=keluar&dari=<?php echo $_SESSION['dari'] ?? ''; ?>&sampai=<?php echo $_SESSION['sampai'] ?? ''; ?>">
                                            <i class="fas fa-arrow-up mr-2 text-warning"></i> Stok Keluar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark text-center">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jenis</th>
                                            <th>Nama Produk</th>
                                            <th>Perubahan Stok</th>
                                            <th>Stok Setelah Transaksi</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data laporan akan ditampilkan di sini melalui PHP -->
                                        <?php
                                        if (isset($_SESSION['dari']) && isset($_SESSION['sampai'])) {
                                            $dari = $_SESSION['dari'];
                                            $sampai = $_SESSION['sampai'];
                                            $sampai_akhir = $sampai . ' 23:59:59';
                                            $tampil = $_GET['tampil'] ?? 'semua';
                                            if ($tampil == 'masuk') {
                                                $query = "SELECT m.tanggalmasuk AS tanggal,'Masuk' AS jenis, s.nama_produk, m.stok AS jumlah, s.stok AS stok_tersedia, m.keterangan 
                                                          FROM tb_masuk m 
                                                          JOIN tb_stok s ON m.idproduk = s.idproduk 
                                                          WHERE tanggalmasuk BETWEEN '$dari' AND '$sampai_akhir'
                                                          ORDER BY tanggalmasuk DESC";
                                            } elseif ($tampil == 'keluar') {
                                                $query = "SELECT k.tanggalkeluar AS tanggal, 'Keluar' AS jenis, s.nama_produk, k.stok AS jumlah, s.stok AS stok_tersedia, k.penerima AS keterangan 
                                                          FROM tb_keluar k 
                                                          JOIN tb_stok s ON k.idproduk = s.idproduk 
                                                          WHERE k.tanggalkeluar BETWEEN '$dari' AND '$sampai_akhir'
                                                          ORDER BY k.tanggalkeluar DESC";
                                            } else {
                                                $query = "SELECT m.tanggalmasuk AS tanggal,'Masuk' AS jenis,s.nama_produk,m.stok AS jumlah,s.stok AS stok_tersedia,m.keterangan 
                                                          FROM tb_masuk m 
                                                          JOIN tb_stok s ON m.idproduk = s.idproduk 
                                                          WHERE tanggalmasuk BETWEEN '$dari' AND '$sampai_akhir'
                                                          UNION ALL
                                                          SELECT k.tanggalkeluar AS tanggal,'Keluar' AS jenis,s.nama_produk,k.stok AS jumlah,s.stok AS stok_tersedia,k.penerima AS keterangan 
                                                          FROM tb_keluar k 
                                                          JOIN tb_stok s ON k.idproduk = s.idproduk 
                                                          WHERE k.tanggalkeluar BETWEEN '$dari' AND '$sampai_akhir'
                                                          ORDER BY tanggal ASC";
                                            }
                                            $result = mysqli_query($conn, $query);
                                            
                                            if (mysqli_num_rows($result) > 0) {
                                                $stok_berjalan = [];
                                                while ($data = mysqli_fetch_array($result)) {
                                                    $badge = $data['jenis'] === 'Masuk' ? 'success' : 'danger';
                                                    echo "<tr>";
                                                    echo "<td class=\"text-center\">" . date('d-m-Y H:i', strtotime($data['tanggal'])) . "</td>";
                                                    echo "<td class=\"text-center\"><span class='badge badge-$badge'>" . $data['jenis'] . "</span></td>";
                                                    echo "<td>" . $data['nama_produk'] . "</td>";
                                                    // Tentukan tanda + atau -
                                                    $produk = $data['nama_produk'];

if (!isset($stok_berjalan[$produk])) {
    $stok_berjalan[$produk] = 0;
}

if ($data['jenis'] === 'Masuk') {
    $stok_berjalan[$produk] += $data['jumlah'];
    $sign  = '+';
    $color = 'text-success';
} else {
    $stok_berjalan[$produk] -= $data['jumlah'];
    $sign  = '-';
    $color = 'text-danger';
}

echo "<td class='text-center {$color}'><strong>{$sign}{$data['jumlah']}</strong></td>";
echo "<td class='text-center'><strong>{$stok_berjalan[$produk]}</strong></td>";


                                                    echo "<td>" . $data['keterangan'] . "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo '<tr><td colspan="5" class="text-center text-muted">Tidak ada data pada rentang tanggal tersebut.</td></tr>';
                                            }
                                        } else {
                                            echo '<tr><td colspan="5" class="text-center">Silakan pilih rentang tanggal terlebih dahulu.</td></tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
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