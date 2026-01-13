# 📦 Sistem Pengelolaan Stok Produk

Aplikasi manajemen stok barang berbasis web yang dikembangkan untuk mempermudah pemantauan inventaris secara real-time dan pembuatan laporan otomatis.

## 🚀 Fitur Utama
* **Sistem Autentikasi**: Keamanan akses halaman menggunakan session check (`cek.php`).
* **Manajemen Stok (CRUD)**: Kelola data barang (Tambah, Lihat, Edit, Hapus) dengan efisien.
* **Laporan PDF Otomatis**: Fitur cetak laporan stok dan transaksi menggunakan library **FPDF**.
* **Monitoring Real-time**: Dashboard informatif untuk melihat status stok barang saat ini.

## 🛠️ Tech Stack
* **Language**: PHP Native.
* **Database**: MySQL.
* **Library**: FPDF (untuk integrasi cetak laporan).
* **Frontend**: Bootstrap / CSS.

## ⚙️ Panduan Instalasi (Lokal)

### 1. Persiapan
* Pastikan sudah menginstal Web Server (Laragon / XAMPP).
* PHP versi 7.4 ke atas.

### 2. Setup Database
1. Buka `phpmyadmin`.
2. Buat database baru.
3. Import file `.sql`

### 3. Konfigurasi Koneksi
* Cek file `function.php` dan sesuaikan konfigurasi `host`, `user`, `password`, dan `database_name`.

### 4. Menjalankan Aplikasi
* Taruh folder di `C:\laragon\www` atau `htdocs`.
* Akses melalui browser: `http://localhost/pengelolaan_stok/login.php`.
