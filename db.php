<?php
// Parameter koneksi MySQL lokal
$host = 'localhost';
$user = 'root';
$pass = ''; 
$dbname = 'si_ormas';

// Koneksi awal (tanpa database)
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die('Koneksi ke MySQL gagal: ' . $conn->connect_error);
}

// Cek dan buat database jika belum ada
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

// Koneksi ke database si_ormas
$conn->select_db($dbname);

// Buat tabel `ormas` jika belum ada
$conn->query("CREATE TABLE IF NOT EXISTS ormas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_ormas VARCHAR(200) NOT NULL,
    singkatan VARCHAR(50) NOT NULL,
    jenis VARCHAR(50) NOT NULL,
    bidang VARCHAR(100) NOT NULL,
    alamat_kesekretariatan VARCHAR(255) NOT NULL,
    kecamatan VARCHAR(100) NOT NULL,
    desa VARCHAR(100) NOT NULL,
    telepon VARCHAR(30) NOT NULL,
    email VARCHAR(100) NOT NULL,
    legalitas VARCHAR(100) NOT NULL,
    nomor_surat VARCHAR(100) NOT NULL,
    tanggal_terbit DATE NOT NULL,
    npwp VARCHAR(50) NOT NULL,
    nama_ketua VARCHAR(100) NOT NULL,
    alamat_ketua VARCHAR(255) NOT NULL,
    telepon_ketua VARCHAR(30) NOT NULL,
    nama_sekretaris VARCHAR(100) NOT NULL,
    alamat_sekretaris VARCHAR(255) NOT NULL,
    telepon_sekretaris VARCHAR(30) NOT NULL,
    nama_bendahara VARCHAR(100) NOT NULL,
    alamat_bendahara VARCHAR(255) NOT NULL,
    telepon_bendahara VARCHAR(30) NOT NULL,
    periode_mulai DATE NOT NULL,
    periode_selesai DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Buat tabel `kegiatan_ormas` jika belum ada
$conn->query("CREATE TABLE IF NOT EXISTS kegiatan_ormas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kegiatan VARCHAR(200) NOT NULL,
    tanggal_kegiatan DATE NOT NULL,
    ormas_penyelenggara VARCHAR(100) NOT NULL,
    link_foto_kegiatan VARCHAR(255),
    deskripsi_singkat VARCHAR(255) NOT NULL,
    deskripsi_lengkap TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Fungsi koneksi siap digunakan
?>