<?php
session_start();
if (!isset($_SESSION['admin_logged'])) {
  header("Location: login.php");
  exit;
}
include "../config.php";

$result = $conn->query("SELECT * FROM kategori");
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Kelola Kategori</title>
</head>
<body>
  <h2>Kelola Kategori</h2>

  <form method="POST" action="kategori_action.php" enctype="multipart/form-data">
    <input type="text" name="nama_kategori" placeholder="Nama Kategori" required>
    <input type="file" name="gambar" accept="image/*" required>
    <button type="submit" name="tambah">Tambah</button>
  </form>

  <table border="1" cellpadding="10" cellspacing="0">
    <tr>
      <th>No</th>
      <th>Nama Kategori</th>
      <th>Gambar</th>
      <th>Aksi</th>
    </tr>
    <?php 
    $no = 1; 
    while($row = $result->fetch_assoc()): 
      $gambarPath = "../uploads/" . $row['gambar'];
      $gambarURL = "http://localhost/PARIWISATAJATENG/pariwisata/uploads/" . $row['gambar'];

      if (empty($row['gambar']) || !file_exists($gambarPath)) {
        $gambarURL = "http://localhost/PARIWISATAJATENG/pariwisata/assets/img/default_kategori.jpg";
      }
    ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
      <td>
        <img src="<?= $gambarURL ?>" alt="<?= htmlspecialchars($row['nama_kategori']) ?>" width="100" height="80">
      </td>
      <td>
        <a href="kategori_action.php?hapus=<?= $row['id_kategori'] ?>" onclick="return confirm('Hapus kategori ini?')">Hapus</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>

  <br>
  <a href="index.php">Kembali ke Dashboard</a>
</body>
</html>