<?php
session_start();
if (!isset($_SESSION['admin_logged'])) {
  header("Location: login.php");
  exit;
}
include "../config.php";

$id = $_GET['id'];
$data = $conn->query("SELECT w.*, k.nama_kategori FROM wisata w JOIN kategori k ON w.id_kategori=k.id_kategori WHERE id_wisata=$id")->fetch_assoc();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Detail Wisata</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <h2>Detail Tempat Wisata</h2>
  <p><strong>Nama:</strong> <?= $data['nama'] ?></p>
  <p><strong>Lokasi:</strong> <?= $data['lokasi'] ?></p>
  <p><strong>Kategori:</strong> <?= $data['nama_kategori'] ?></p>
  <p><strong>Deskripsi:</strong> <?= nl2br($data['deskripsi']) ?></p>
  <img src="../uploads/<?= $data['gambar'] ?>" width="300"><br><br>
  <a href="wisata.php">Kembali</a>
</body>
</html>
