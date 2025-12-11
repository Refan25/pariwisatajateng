<?php
session_start();
if (!isset($_SESSION['admin_logged'])) {
  header("Location: login.php");
  exit;
}
include "../config.php";

$result = $conn->query("SELECT w.*, k.nama_kategori 
                        FROM wisata w
                        JOIN kategori k ON w.id_kategori = k.id_kategori");
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Kelola Wisata</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <h2>Daftar Tempat Wisata</h2>
  <a href="wisata_add.php">+ Tambah Wisata Baru</a> |
  <a href="index.php">Kembali ke Dashboard</a>
  <table border="1" cellpadding="10" cellspacing="0">
    <tr>
      <th>No</th>
      <th>Gambar</th>
      <th>Nama Wisata</th>
      <th>Lokasi</th>
      <th>Kategori</th>
      <th>Harga</th>
      <th>Aksi</th>
    </tr>
    <?php $no=1; while($row=$result->fetch_assoc()): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><img src="../uploads/<?= $row['gambar'] ?>" width="100"></td>
      <td><?= $row['nama'] ?></td>
      <td><?= $row['lokasi'] ?></td>
      <td><?= $row['nama_kategori'] ?></td>
      <td>Rp <?= number_format($row['harga_tiket'],0,',','.') ?></td>
      <td>
        <a href="wisata_detail.php?id=<?= $row['id_wisata'] ?>">Detail</a> |
        <a href="wisata_edit.php?id=<?= $row['id_wisata'] ?>">Edit</a> |
        <a href="wisata_delete.php?id=<?= $row['id_wisata'] ?>" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
