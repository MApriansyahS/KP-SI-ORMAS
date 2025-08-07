<?php
require_once 'db.php'; // Pastikan path benar

$sql = "SELECT nama_ormas, jenis, alamat_kesekretariatan, nama_ketua, 
        CASE WHEN legalitas IS NOT NULL AND legalitas <> '' THEN 'Aktif' ELSE 'Proses' END AS status
        FROM ormas ORDER BY id DESC";
$result = $conn->query($sql);

$no = 1;
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama_ormas']}</td>
                <td>{$row['jenis']}</td>
                <td>{$row['alamat_kesekretariatan']}</td>
                <td>{$row['nama_ketua']}</td>
                <td><span class='badge bg-".($row['status']=='Aktif'?'success':'warning text-dark')."'>{$row['status']}</span></td>
              </tr>";
        $no++;
    }
} else {
    echo "<tr><td colspan='6'>Belum ada data ORMAS.</td></tr>";
}
$conn->close();
?>