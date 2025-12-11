<?php
session_start();
if (!isset($_SESSION['admin_logged'])) {
  header("Location: login.php");
  exit;
}
include "../config.php";

// Tambah alasan
if (isset($_POST['tambah'])) {
  $judul = $_POST['judul'];
  $deskripsi = $_POST['deskripsi'];

  $stmt = $conn->prepare("INSERT INTO alasan_pilih (judul, deskripsi) VALUES (?,?)");
  $stmt->bind_param("ss", $judul, $deskripsi);
  $stmt->execute();
  header("Location: alasan_pilih.php");
  exit;
}

// Hapus alasan
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  $conn->query("DELETE FROM alasan_pilih WHERE id=$id");
  header("Location: alasan_pilih.php");
  exit;
}

$result = $conn->query("SELECT * FROM alasan_pilih ORDER BY id DESC");
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Kelola Alasan Pilihan</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <h2>Kelola Alasan Kenapa Memilih</h2>

  <form method="POST">
    <input type="text" name="judul" placeholder="Judul Alasan" required>
    <textarea name="deskripsi" placeholder="Deskripsi" required></textarea>
    <button type="submit" name="tambah">Tambah Alasan</button>
  </form>

  <hr>

  <table border="1" cellpadding="10" cellspacing="0">
    <tr>
      <th>No</th>
      <th>Judul</th>
      <th>Deskripsi</th>
      <th>Aksi</th>
    </tr>
    <?php $no=1; while($row=$result->fetch_assoc()): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= $row['judul'] ?></td>
      <td><?= $row['deskripsi'] ?></td>
      <td><a href="alasan_pilih.php?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus data ini?')">Hapus</a></td>
    </tr>
    <?php endwhile; ?>
  </table>

  <br>
  <a href="index.php">Kembali ke Dashboard</a>
</body>
</html>
