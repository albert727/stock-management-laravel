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
    <title>Stok produk</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
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
                    <h1 class="mt-4">STOK PRODUK</h1>

                    <!-- Notifikasi sukses -->
                    <?php if (isset($_SESSION['success'])) : ?>
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            <?= $_SESSION['success']; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?> 

                    <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Daftar Produk</h5>

    <div>
        <a href="cetak_stok_produk.php" class="btn btn-danger btn-sm mr-2">
            <i class="fas fa-file-pdf"></i> Cetak PDF
        </a>

        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
            <i class="fas fa-plus"></i> Tambah Data Produk
        </button>
    </div>
</div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark text-center">
                                        <tr>
                                            <th>ID Produk</th>
                                            <th class="no-sort">Nama Produk</th>
                                            <th class="no-sort">Deskripsi</th>
                                            <th>Stok</th>
                                            <th class="no-sort">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ambil = mysqli_query($conn, "SELECT * FROM tb_stok ORDER BY idproduk ASC");
                                        while ($data = mysqli_fetch_array($ambil)) {
                                            $idproduk = $data['idproduk'];
                                            $nama = $data['nama_produk'];
                                            $deskripsi = $data['deskripsi'];
                                            $stok = $data['stok'];
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $idproduk; ?></td>
                                                <td><?= $nama; ?></td>
                                                <td><?= $deskripsi; ?></td>
                                                <td class="text-center"><?= $stok; ?></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= $idproduk; ?>">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?= $idproduk; ?>">
                                                        <i class="fas fa-trash-alt"></i> Hapus
                                                    </button>
                                                </td>
                                            </tr>


                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="editModal<?= $idproduk; ?>" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form method="post">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Produk</h5>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="idproduk" value="<?= $idproduk; ?>">
                                                                <div class="form-group">
                                                                    <label>Nama Produk</label>
                                                                    <input type="text" name="nama_produk" class="form-control" value="<?= $nama; ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Deskripsi</label>
                                                                    <input type="text" name="deskripsi" class="form-control" value="<?= $deskripsi; ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Jumlah Stok</label>
                                                                    <input type="number" name="stok" class="form-control" value="<?= $stok; ?>" min="0" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary" name="editproduk">Simpan Perubahan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Hapus -->
                                            <div class="modal fade" id="deleteModal<?= $idproduk; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form method="post">
                                                            <div class="modal-header"><h5 class="modal-title" id="deleteModalLabel">Hapus Produk</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="idproduk" value="<?= $idproduk; ?>">
                                                                <p>Yakin ingin menghapus <strong><?= $nama; ?></strong>?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-danger" name="hapusproduk">Hapus</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/demo/datatables-demo.js"></script>
</body>

<!-- Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Produk</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <h5 class="mb-3">Input Data Produk</h5>
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Produk</label>
                        <input type="text" name="deskripsi" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control" min="0" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" name="addnewproduk">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</html>