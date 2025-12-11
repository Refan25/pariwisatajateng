<?php
session_start();
if (!isset($_SESSION['admin_logged'])) {
  header("Location: login.php");
  exit;
}
include "../config.php";

$jumlah_wisata = $conn->query("SELECT COUNT(*) AS total FROM wisata")->fetch_assoc()['total'];
$jumlah_kategori = $conn->query("SELECT COUNT(*) AS total FROM kategori")->fetch_assoc()['total'];
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <h1>Dashboard Admin</h1>
  <p>Jumlah Wisata: <?= $jumlah_wisata ?></p>
  <p>Jumlah Kategori: <?= $jumlah_kategori ?></p>
  <a href="kategori.php">Kelola Kategori</a> |
  <a href="wisata.php">Kelola Wisata</a> |
  <a href="logout.php">Logout</a>
</body>
</html>
