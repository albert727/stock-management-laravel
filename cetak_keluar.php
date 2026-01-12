<?php
date_default_timezone_set('Asia/Jakarta');

define('FPDF_FONTPATH', __DIR__ . '/web_inventaris/font/');
require('fpdf.php');
require('function.php');

$dari = $_GET['dari'] ?? '';
$sampai = $_GET['sampai'] ?? '';
if (empty($dari) || empty($sampai)) {
    die("Tanggal belum ditentukan!");
}

$sampai_akhir = $sampai . ' 23:59:59';

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

/* ===== JUDUL ===== */
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'herbalpremium.id', 0, 1, 'C');
$pdf->Cell(190, 7, 'Laporan Stok Keluar', 0, 1, 'C');

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(
    190,
    6,
    "Periode: " . format_tanggal($dari) . " s/d " . format_tanggal($sampai),
    0,
    1,
    'C'
);
$pdf->Ln(8);

/* ===== HEADER TABEL ===== */
$pdf->SetFillColor(230,230,230);
$pdf->SetFont('Arial','B',10);

$pdf->Cell(35,8,'Tanggal',1,0,'C',true);
$pdf->Cell(20,8,'Jenis',1,0,'C',true);
$pdf->Cell(45,8,'Nama Produk',1,0,'C',true);
$pdf->Cell(30,8,'Perubahan Stok',1,0,'C',true);
$pdf->Cell(25,8,'Stok Terkini',1,0,'C',true);
$pdf->Cell(35,8,'Keterangan',1,1,'C',true);

/* ===== DATA ===== */
$query = "
    SELECT 
        k.tanggalkeluar AS tanggal,
        'Keluar' AS jenis,
        s.nama_produk,
        k.stok AS jumlah,
        s.stok AS stok_tersedia,
        k.penerima AS keterangan
    FROM tb_keluar k
    JOIN tb_stok s ON k.idproduk = s.idproduk
    WHERE k.tanggalkeluar BETWEEN '$dari' AND '$sampai 23:59:59'
    ORDER BY k.tanggalkeluar ASC
";

$result = mysqli_query($conn, $query);

$pdf->SetFont('Arial','',10);

while ($row = mysqli_fetch_array($result)) {
    $pdf->Cell(35,8, format_tanggal_jam($row['tanggal']),1,0,'C');
    $pdf->Cell(20,8, $row['jenis'],1,0,'C');
    $pdf->Cell(45,8, $row['nama_produk'],1,0,'L');
    $pdf->Cell(30,8, '-'.$row['jumlah'],1,0,'C');
    $pdf->Cell(25,8, $row['stok_tersedia'],1,0,'C');
    $pdf->Cell(35,8, $row['keterangan'] ?: '-',1,1,'L');
}

/* ===== FOOTER ===== */
$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 9);
$pdf->Cell(0, 5, 'Dicetak pada: ' . date('d-m-Y H:i:s'), 0, 1, 'R');

$pdf->Output('I', 'Laporan_Stok_Masuk.pdf');
exit;