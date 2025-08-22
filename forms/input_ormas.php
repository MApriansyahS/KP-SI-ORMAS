<?php
header('Content-Type: application/json');
require_once('../db.php');

function respond($type, $msg) {
    echo json_encode([$type => $msg]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond('error', 'Permintaan tidak valid.');
}

$fields = [
    'nama_ormas', 'singkatan', 'jenis', 'bidang', 'alamat_kesekretariatan', 'kecamatan', 'desa', 'telepon', 'email',
    'legalitas', 'nomor_surat', 'tanggal_terbit', 'npwp',
    'nama_ketua', 'alamat_ketua', 'telepon_ketua',
    'nama_sekretaris', 'alamat_sekretaris', 'telepon_sekretaris',
    'nama_bendahara', 'alamat_bendahara', 'telepon_bendahara',
    'periode_mulai', 'periode_selesai'
];
$data = [];
foreach ($fields as $field) {
    $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
    if (!$value) {
        respond('error', "Field $field wajib diisi.");
    }
    $data[$field] = $value;
}

// Validasi email
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    respond('error', 'Format email tidak valid.');
}

// Validasi panjang teks
if (strlen($data['nama_ormas']) > 200) {
    respond('error', 'Nama ormas terlalu panjang (maksimal 200 karakter).');
}

$check = $conn->prepare("SELECT id FROM ormas WHERE nama_ormas = ?");
$check->bind_param("s", $data['nama_ormas']);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    echo json_encode(['error' => 'Nama ORMAS sudah terdaftar!']);
    $check->close();
    $conn->close();
    exit;
}
$check->close();

$stmt = $conn->prepare("INSERT INTO ormas (
    nama_ormas, singkatan, jenis, bidang, alamat_kesekretariatan, kecamatan, desa, telepon, email,
    legalitas, nomor_surat, tanggal_terbit, npwp,
    nama_ketua, alamat_ketua, telepon_ketua,
    nama_sekretaris, alamat_sekretaris, telepon_sekretaris,
    nama_bendahara, alamat_bendahara, telepon_bendahara,
    periode_mulai, periode_selesai
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    respond('error', 'Gagal menyiapkan query database.');
}

$stmt->bind_param(
    "ssssssssssssssssssssssss",
    $data['nama_ormas'], $data['singkatan'], $data['jenis'], $data['bidang'], $data['alamat_kesekretariatan'],
    $data['kecamatan'], $data['desa'], $data['telepon'], $data['email'], $data['legalitas'], $data['nomor_surat'],
    $data['tanggal_terbit'], $data['npwp'],
    $data['nama_ketua'], $data['alamat_ketua'], $data['telepon_ketua'],
    $data['nama_sekretaris'], $data['alamat_sekretaris'], $data['telepon_sekretaris'],
    $data['nama_bendahara'], $data['alamat_bendahara'], $data['telepon_bendahara'],
    $data['periode_mulai'], $data['periode_selesai']
);

if ($stmt->execute()) {
    respond('success', 'Data ORMAS berhasil disimpan!');
} else {
    respond('error', 'Gagal menyimpan data! Silakan coba ulang atau hubungi admin.');
}
$stmt->close();
$conn->close();
?>