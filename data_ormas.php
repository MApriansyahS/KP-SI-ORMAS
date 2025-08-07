<?php
require_once 'db.php';

$sql = "SELECT * FROM ormas ORDER BY id DESC";
$result = $conn->query($sql);

$no = 1;
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data_json = htmlspecialchars(json_encode($row));
        echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama_ormas']}</td>
                <td>{$row['jenis']}</td>
                <td>{$row['alamat_kesekretariatan']}</td>
                <td>{$row['nama_ketua']}</td>
                <td><span class='badge bg-".($row['legalitas'] ? 'success' : 'warning text-dark')."'>".($row['legalitas'] ? 'Aktif':'Proses')."</span></td>
                <td>
                    <button class='btn btn-info btn-sm btn-lihat-ormas' data-ormas='{$data_json}' title='Lihat'>
                      <i class='bi bi-eye'></i>
                    </button>
                    <button class='btn btn-warning btn-sm btn-edit-ormas' data-ormas='{$data_json}' title='Edit'>
                      <i class='bi bi-pencil'></i>
                    </button>
                    <a href='forms/delete_ormas.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Yakin ingin menghapus data ini?');\" title='Hapus'>
                      <i class='bi bi-trash'></i>
                    </a>
                </td>
              </tr>";
        $no++;
    }
} else {
    echo "<tr><td colspan='7'>Belum ada data ORMAS.</td></tr>";
}
$conn->close();
?>