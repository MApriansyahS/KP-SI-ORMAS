<?php
require_once '../db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nama_kegiatan = trim($_POST['nama_kegiatan']);
    $ormas_penyelenggara = trim($_POST['ormas_penyelenggara']);
    $tanggal_kegiatan = $_POST['tanggal_kegiatan'];
    $deskripsi_singkat = trim($_POST['deskripsi_singkat']);
    $deskripsi_lengkap = trim($_POST['deskripsi_lengkap']);
    $link_foto_kegiatan = trim($_POST['link_foto_kegiatan']); // Ambil dari input teks/link

    $stmt = $conn->prepare("UPDATE kegiatan_ormas 
        SET nama_kegiatan=?, ormas_penyelenggara=?, tanggal_kegiatan=?, link_foto_kegiatan=?, deskripsi_singkat=?, deskripsi_lengkap=? 
        WHERE id=?");
    $stmt->bind_param("ssssssi", $nama_kegiatan, $ormas_penyelenggara, $tanggal_kegiatan, $link_foto_kegiatan, $deskripsi_singkat, $deskripsi_lengkap, $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header("Location: ../blog.php");
    exit;
}
?>