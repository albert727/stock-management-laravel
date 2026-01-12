<?php
require 'function.php';
require 'cek.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>produk keluar</title>
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
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4 text-danger">PRODUK KELUAR</h1>
                    <?php if (isset($_SESSION['error'])) : ?>
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <?= $_SESSION['error']; ?>
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

                    <?php if (isset($_SESSION['success'])) : ?>
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <?= $_SESSION['success']; ?>
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

                    <div class="card mb-4">
                        <div clas="card-header">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Daftar Produk</h5>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">
                                        <i class="fas fa-arrow-up"></i> Keluar Stok Produk
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark text-center">
                                        <tr>
                                            <th>Tanggal Keluar</th>
                                            <th class="no-sort">Nama Produk</th>
                                            <th class="no-sort">Penerima</th>
                                            <th>Jumlah Stok Keluar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ambil = mysqli_query($conn, "SELECT k.*, s.nama_produk 
                                            FROM tb_keluar k 
                                            JOIN tb_stok s ON k.idproduk = s.idproduk 
                                            ORDER BY k.tanggalkeluar DESC");
                                        $no = 1;

                                        while ($data = mysqli_fetch_array($ambil)) {
                                            $idkeluar = $data['idkeluar'];
                                            $nama_produk = $data['nama_produk'];
                                            $penerima = $data['penerima'];
                                            $tanggal = $data['tanggalkeluar'];
                                            $stokkeluar = $data['stok'];
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= date('d-m-Y H:i', strtotime($tanggal)); ?></td>
                                                <td><?= $nama_produk; ?></td>
                                                <td><?= $penerima; ?></td>
                                                <td class="text-center"><?= $stokkeluar; ?></td>
                                            </tr>
                                        <?php
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

<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Stok Keluar Produk</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <select name="produknya" class="form-control">
                            <?php
                            $ambildata = mysqli_query($conn, "SELECT * FROM tb_stok");
                            while ($fetcharray = mysqli_fetch_array($ambildata)) {
                                $namaproduknya = $fetcharray['nama_produk'];
                                $idproduknya = $fetcharray['idproduk'];

                            ?>
                                <option value="<?= $idproduknya; ?>"><?= $namaproduknya; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Penerima Produk -->
                    <div class="form-group mb-3">
                        <label for="penerima">penerima</label>
                        <input type="text" name="penerima" id="penerima" placeholder="Masukan Nama Penerima" class="form-control" required>
                    </div>

                    <!-- Tanggal Masuk Produk -->
                    <div class="mb-3">
                        <label for="tanggalkeluar" class="form-label">Tanggal keluar</label>
                        <input type="datetime-local" class="form-control" id="tanggalkeluar" name="tanggalkeluar" required>
                    </div>

                    <div>

                        <div class="form-group mb-3">
                            <label for="stok">Stok keluar</label>
                            <input type="number" name="stok" id="stok" placeholder="Jumlah stok" class="form-control" min="0" required>
                        </div>

                    </div>

                    <!-- Tombol Submit -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" name="stokkeluar">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</html>