<?php
header('Content-Type: application/json');
require_once '../db.php';

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if ($id <= 0) { echo json_encode(['error'=>'ID tidak valid']); exit; }

$fields = [
  'nama_ormas', 'singkatan', 'jenis', 'bidang', 'alamat_kesekretariatan', 'kecamatan', 'desa', 'telepon', 'email',
  'legalitas', 'nomor_surat', 'tanggal_terbit', 'npwp', 'nama_ketua', 'alamat_ketua', 'telepon_ketua',
  'nama_sekretaris', 'alamat_sekretaris', 'telepon_sekretaris', 'nama_bendahara', 'alamat_bendahara', 'telepon_bendahara'
];
$data = [];
foreach ($fields as $f) {
  $data[$f] = isset($_POST[$f]) ? trim($_POST[$f]) : '';
  if ($data[$f]==='' && $f!=='legalitas') { // legalitas boleh kosong
    echo json_encode(['error'=>"Field $f wajib diisi"]); exit;
  }
}

$stmt = $conn->prepare("UPDATE ormas SET 
  nama_ormas=?, singkatan=?, jenis=?, bidang=?, alamat_kesekretariatan=?, kecamatan=?, desa=?, telepon=?, email=?,
  legalitas=?, nomor_surat=?, tanggal_terbit=?, npwp=?, nama_ketua=?, alamat_ketua=?, telepon_ketua=?,
  nama_sekretaris=?, alamat_sekretaris=?, telepon_sekretaris=?, nama_bendahara=?, alamat_bendahara=?, telepon_bendahara=?
  WHERE id=?");
$stmt->bind_param(
  "ssssssssssssssssssssssi",
  $data['nama_ormas'], $data['singkatan'], $data['jenis'], $data['bidang'], $data['alamat_kesekretariatan'],
  $data['kecamatan'], $data['desa'], $data['telepon'], $data['email'], $data['legalitas'], $data['nomor_surat'],
  $data['tanggal_terbit'], $data['npwp'], $data['nama_ketua'], $data['alamat_ketua'], $data['telepon_ketua'],
  $data['nama_sekretaris'], $data['alamat_sekretaris'], $data['telepon_sekretaris'],
  $data['nama_bendahara'], $data['alamat_bendahara'], $data['telepon_bendahara'], $id
);
if ($stmt->execute()) {
  echo json_encode(['success' => 'Data berhasil diperbarui!']);
} else {
  echo json_encode(['error' => 'Gagal update data!']);
}
$stmt->close();
$conn->close();
?>