<?php
date_default_timezone_set('Asia/Jakarta');
define('FPDF_FONTPATH', __DIR__ . '/web_inventaris/font/');

require 'function.php';
require 'cek.php';
require 'fpdf.php';

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// Judul
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'LAPORAN STOK PRODUK',0,1,'C');
$pdf->Ln(5);

// Header tabel
$pdf->SetFillColor(230,230,230); // warna abu-abu
$pdf->SetFont('Arial','B',10);

$pdf->Cell(15,8,'ID',1,0,'C',true);
$pdf->Cell(55,8,'Nama Produk',1,0,'C',true);
$pdf->Cell(70,8,'Deskripsi',1,0,'C',true);
$pdf->Cell(30,8,'Stok',1,1,'C',true);


// Data
$pdf->SetFont('Arial','',10);
$data = mysqli_query($conn, "SELECT * FROM tb_stok ORDER BY nama_produk ASC");

while ($row = mysqli_fetch_assoc($data)) {
    $pdf->Cell(15,8,$row['idproduk'],1,0,'C');
    $pdf->Cell(55,8,$row['nama_produk'],1,0,'L');
    $pdf->Cell(70,8,$row['deskripsi'] ?: '-',1,0,'L');
    $pdf->Cell(30,8,$row['stok'],1,1,'C');
}

// Footer tanggal cetak
$pdf->Ln(5);
$pdf->SetFont('Arial','I',9);
$pdf->Cell(0,8,'Dicetak pada: '.date('d-m-Y H:i'),0,1,'R');

$pdf->Output('I', 'stok_produk.pdf');
exit;