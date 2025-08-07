<?php
header('Content-Type: application/json');
require_once('../db.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

$fields = [
    'nama_kegiatan', 'tanggal_kegiatan', 'ormas_penyelenggara', 'deskripsi_singkat', 'deskripsi_lengkap'
];
$data = [];
foreach ($fields as $field) {
    $data[$field] = isset($_POST[$field]) ? trim($_POST[$field]) : '';
    if (!$data[$field]) {
        echo json_encode(['error' => "Field $field wajib diisi."]);
        exit;
    }
}

// Penanganan upload foto
$foto_path = '';
if (isset($_FILES['foto_kegiatan']) && $_FILES['foto_kegiatan']['error'] == UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $filename = uniqid() . '_' . basename($_FILES['foto_kegiatan']['name']);
    $targetFile = $uploadDir . $filename;
    if (move_uploaded_file($_FILES['foto_kegiatan']['tmp_name'], $targetFile)) {
        $foto_path = 'forms/uploads/' . $filename;
    } else {
        echo json_encode(['error' => 'Gagal upload foto kegiatan.']);
        exit;
    }
} else {
    echo json_encode(['error' => 'Foto kegiatan wajib diupload.']);
    exit;
}

// Tambahkan pengecekan duplikat berdasarkan nama_kegiatan & tanggal_kegiatan
$cek = $conn->prepare("SELECT id FROM kegiatan_ormas WHERE nama_kegiatan = ? AND tanggal_kegiatan = ?");
$cek->bind_param("ss", $data['nama_kegiatan'], $data['tanggal_kegiatan']);
$cek->execute();
$cek->store_result();
if ($cek->num_rows > 0) {
    echo json_encode(['error' => 'Kegiatan dengan nama dan tanggal tersebut sudah terdaftar!']);
    $cek->close();
    $conn->close();
    exit;
}
$cek->close();

$stmt = $conn->prepare("INSERT INTO kegiatan_ormas (
    nama_kegiatan, tanggal_kegiatan, ormas_penyelenggara, foto_kegiatan, deskripsi_singkat, deskripsi_lengkap
) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param(
    "ssssss",
    $data['nama_kegiatan'], $data['tanggal_kegiatan'], $data['ormas_penyelenggara'], $foto_path, $data['deskripsi_singkat'], $data['deskripsi_lengkap']
);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Data kegiatan berhasil disimpan!']);
} else {
    echo json_encode(['error' => 'Gagal menyimpan data!']);
}
$stmt->close();
$conn->close();
?>