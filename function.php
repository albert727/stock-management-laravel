<?php

// Koneksi ke Database dan Session
$host = "localhost";
$username = "root";
$password = "albertmimi";
$database = "stockbarang";

session_start();
$conn = mysqli_connect($host, $username, $password, $database);

// Menambahkan Produk Baru
if (isset($_POST['addnewproduk'])) {
    $nama = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];

    // 1. Simpan produk
    $add = mysqli_query($conn, "
        INSERT INTO tb_stok (nama_produk, deskripsi, stok)
        VALUES ('$nama', '$deskripsi', '$stok')
    ");

    if ($add) {
        // 2. Ambil ID produk terakhir
        $idproduk = mysqli_insert_id($conn);

        // 3. Catat stok awal ke tb_masuk
        mysqli_query($conn, "
            INSERT INTO tb_masuk (idproduk, keterangan, tanggalmasuk, stok)
            VALUES ('$idproduk', 'Stok Awal', NOW(), '$stok')
        ");

        $_SESSION['success'] = "Produk berhasil ditambahkan";
        header("Location: stok_produk.php");
        exit;
    }
}


// Menambahkan Stok Produk Masuk
if (isset($_POST['stokmasuk'])) {
    $idproduk   = $_POST['produknya'];
    $keterangan = $_POST['keterangan'];
    $tanggal    = $_POST['tanggalmasuk'];
    $qty        = $_POST['stok'];

    $addtomasuk = mysqli_query($conn, "INSERT INTO tb_masuk (idproduk, keterangan, tanggalmasuk, stok) VALUES ('$idproduk', '$keterangan', '$tanggal', '$qty')");

    if ($addtomasuk) {
    mysqli_query($conn, "UPDATE tb_stok SET stok = stok + $qty WHERE idproduk = '$idproduk'");

    $_SESSION['success'] = "Stok masuk berhasil ditambahkan";
    header("Location: stok_masuk.php");
    exit;
}

}

// Mengurangi Stok Produk (Stok Keluar)
if (isset($_POST['stokkeluar'])) {
    $produknya = $_POST['produknya'];
    $penerima = $_POST['penerima'];
    $tanggal = $_POST['tanggalkeluar'];
    $stok = $_POST['stok'];

    $cekstok = mysqli_query($conn, "SELECT stok FROM tb_stok WHERE idproduk='$produknya'");
    $ambildatanya = mysqli_fetch_array($cekstok);
    $stoksekarang = $ambildatanya['stok'];

    if ($stoksekarang >= $stok) {
        $kurangistok = $stoksekarang - $stok;
        $updatestok = mysqli_query($conn, "UPDATE tb_stok SET stok='$kurangistok' WHERE idproduk='$produknya'");
        $addtokeluar = mysqli_query($conn, "INSERT INTO tb_keluar (idproduk, penerima, tanggalkeluar, stok) VALUES ('$produknya','$penerima','$tanggal','$stok')");

        if ($updatestok && $addtokeluar) {
    $_SESSION['success'] = "Stok keluar berhasil dicatat";
    header("Location: stok_keluar.php");
    exit;
}
 else {
            echo '<script>alert("Gagal mengeluarkan barang.");window.location.href="stok_keluar.php";</script>';
        }
    } else {
    $_SESSION['error'] = "Stok tidak cukup. Stok tersedia: $stoksekarang";
    header("Location: stok_keluar.php");
    exit;
}
}

// Menyimpan Filter Laporan ke Session
if (isset($_GET['dari']) && isset($_GET['sampai'])) {
    $_SESSION['dari'] = $_GET['dari'];
    $_SESSION['sampai'] = $_GET['sampai'];
}

// Reset Filter Laporan
if (isset($_GET['reset'])) {
    unset($_SESSION['dari']);
    unset($_SESSION['sampai']);
    header("Location: laporan.php");
    exit;
}

// Edit Data Produk
// Edit Data Produk + Penyesuaian Stok
if (isset($_POST['editproduk'])) {
    $idproduk     = $_POST['idproduk'];
    $nama_produk  = $_POST['nama_produk'];
    $deskripsi    = $_POST['deskripsi'];
    $stok_baru    = (int) $_POST['stok'];

    // 1. Ambil stok lama
    $cek = mysqli_query($conn, "SELECT stok FROM tb_stok WHERE idproduk='$idproduk'");
    $data = mysqli_fetch_assoc($cek);
    $stok_lama = (int) $data['stok'];

    // 2. Hitung selisih
    $selisih = $stok_baru - $stok_lama;

    // 3. Jika ada perubahan stok → catat ke histori
    if ($selisih > 0) {
        // Stok bertambah → catat sebagai stok masuk
        mysqli_query($conn, "
            INSERT INTO tb_masuk (idproduk, keterangan, tanggalmasuk, stok)
            VALUES ('$idproduk', 'Penyesuaian Stok', NOW(), '$selisih')
        ");
    } elseif ($selisih < 0) {
        // Stok berkurang → catat sebagai stok keluar
        mysqli_query($conn, "
            INSERT INTO tb_keluar (idproduk, penerima, tanggalkeluar, stok)
            VALUES ('$idproduk', 'Penyesuaian Stok', NOW(), '" . abs($selisih) . "')
        ");
    }

    // 4. Update data produk
    $update = mysqli_query($conn, "
        UPDATE tb_stok 
        SET nama_produk='$nama_produk', deskripsi='$deskripsi', stok='$stok_baru'
        WHERE idproduk='$idproduk'
    ");

    if ($update) {
        echo '<script>alert("Produk berhasil diperbarui & penyesuaian stok tercatat"); window.location.href="stok_produk.php";</script>';
    } else {
        echo '<script>alert("Gagal memperbarui produk"); window.location.href="stok_produk.php";</script>';
    }
}


// Hapus Produk
if (isset($_POST['hapusproduk'])) {
    $idproduk = $_POST['idproduk'];

    // Hapus dulu dari tb_keluar
    mysqli_query($conn, "DELETE FROM tb_keluar WHERE idproduk='$idproduk'");
    
    // Hapus juga dari tb_masuk (kalau ada)
    mysqli_query($conn, "DELETE FROM tb_masuk WHERE idproduk='$idproduk'");

    // Baru hapus dari tb_stok
    $hapus = mysqli_query($conn, "DELETE FROM tb_stok WHERE idproduk='$idproduk'");
    
    if ($hapus) {
        echo '<script>alert("Produk berhasil dihapus!"); window.location.href="stok_produk.php";</script>';
    } else {
        echo '<script>alert("Gagal menghapus produk!"); window.location.href="stok_produk.php";</script>';
    }
}

function format_tanggal($tgl)
{
    return date('d F Y', strtotime($tgl));
}

function format_tanggal_jam($datetime)
{
    $bulan = [
        '01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr',
        '05'=>'Mei','06'=>'Jun','07'=>'Jul','08'=>'Agu',
        '09'=>'Sep','10'=>'Okt','11'=>'Nov','12'=>'Des'
    ];

    $dt = date_create($datetime);

    return date_format($dt, 'd') . ' ' .
           $bulan[date_format($dt, 'm')] . ' ' .
           date_format($dt, 'Y H:i');
}

