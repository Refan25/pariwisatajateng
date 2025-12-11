<?php
session_start();
if (!isset($_SESSION['admin_logged'])) {
  header("Location: login.php");
  exit;
}
include "../config.php";

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM wisata WHERE id_wisata=$id")->fetch_assoc();
$kategori = $conn->query("SELECT * FROM kategori");
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Wisata</title>
</head>
<body>
  <h2>Edit Wisata</h2>

  <form action="wisata_update.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_wisata" value="<?= $data['id_wisata'] ?>">

    <p>
      <label>Nama Wisata:</label><br>
      <input type="text" name="nama" value="<?= $data['nama'] ?>">
    </p>

    <p>
      <label>Lokasi:</label><br>
      <input type="text" name="lokasi" value="<?= $data['lokasi'] ?>">
    </p>

    <p>
      <label>Harga Tiket:</label><br>
      <input type="number" name="harga_tiket" value="<?= $data['harga_tiket'] ?>">
    </p>

    <p>
      <label>Kategori:</label><br>
      <select name="id_kategori">
        <?php while ($k = $kategori->fetch_assoc()) { ?>
          <option value="<?= $k['id_kategori'] ?>" <?= $k['id_kategori'] == $data['id_kategori'] ? 'selected' : '' ?>>
            <?= $k['nama_kategori'] ?>
          </option>
        <?php } ?>
      </select>
    </p>

    <p>
      <label>Deskripsi:</label><br>
      <textarea name="deskripsi" rows="3" cols="40"><?= $data['deskripsi'] ?></textarea>
    </p>

    <p>
      <label>Gambar Saat Ini:</label><br>
      <img src="../uploads/<?= $data['gambar'] ?>" width="200" alt="Gambar Wisata"><br>
      <label>Ganti Gambar (opsional):</label><br>
      <input type="file" name="gambar">
    </p>

    <p>
      <input type="submit" value="Update">
    </p>
  </form>

  <a href="wisata.php">Kembali</a>
</body>
</html>
