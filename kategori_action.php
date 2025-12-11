<?php
session_start();
if (!isset($_SESSION['admin_logged'])) {
  header("Location: login.php");
  exit;
}
include "../config.php";

// Tambah kategori
if (isset($_POST['tambah'])) {
  $nama = $_POST['nama_kategori'];
  $stmt = $conn->prepare("INSERT INTO kategori (nama_kategori) VALUES (?)");
  $stmt->bind_param("s", $nama);
  $stmt->execute();
  header("Location: kategori.php");
  exit;
}

// Hapus kategori
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  $conn->query("DELETE FROM kategori WHERE id_kategori=$id");
  header("Location: kategori.php");
  exit;
}
?>
