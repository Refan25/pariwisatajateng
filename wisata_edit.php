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

if (isset($_POST['update'])) {
  $nama = $_POST['nama'];
  $lokasi = $_POST['lokasi'];
  $harga_tiket = $_POST['harga_tiket'];
  $id_kategori = $_POST['id_kategori'];
  $deskripsi = $_POST['deskripsi'];

  $gambar = $data['gambar'];
  if (!empty($_FILES['gambar']['name'])) {
    $target_dir = "../uploads/";
    $file_name = time() . "_" . basename($_FILES["gambar"]["name"]);
    $target_file = $target_dir . $file_name;
    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
      $gambar = $file_name;
    }
  }

  $stmt = $conn->prepare("UPDATE wisata SET nama=?, lokasi=?, harga_tiket=?, id_kategori=?, deskripsi=?, gambar=? WHERE id_wisata=?");
  $stmt->bind_param("ssdissi", $nama, $lokasi, $harga_tiket, $id_kategori, $deskripsi, $gambar, $id);
  $stmt->execute();

  header("Location: index.php");
  exit;
}
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Edit Wisata</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
  <h2>Edit Wisata</h2>

  <form method="POST" enctype="multipart/form-data">
    <p>
      <label>Nama Wisata:</label><br>
      <input type="text" name="nama" value="<?= $data['nama'] ?>" required>
    </p>

    <p>
      <label>Lokasi:</label><br>
      <input type="text" name="lokasi" value="<?= $data['lokasi'] ?>" required>
    </p>

    <p>
      <label>Harga Tiket:</label><br>
      <input type="number" name="harga_tiket" value="<?= $data['harga_tiket'] ?>" required>
    </p>

    <p>
      <label>Kategori:</label><br>
      <select name="id_kategori" required>
        <?php while ($row = $kategori->fetch_assoc()): ?>
          <option value="<?= $row['id_kategori'] ?>" <?= $row['id_kategori'] == $data['id_kategori'] ? 'selected' : '' ?>>
            <?= $row['nama_kategori'] ?>
          </option>
        <?php endwhile; ?>
      </select>
    </p>

    <p>
      <label>Deskripsi:</label><br>
      <textarea name="deskripsi" rows="4" cols="40" required><?= $data['deskripsi'] ?></textarea>
    </p>

    <p>
      <label>Gambar Saat Ini:</label><br>
      <img src="../uploads/<?= $data['gambar'] ?>" width="150" alt="Gambar Wisata"><br><br>
      <label>Ganti Gambar (opsional):</label><br>
      <input type="file" name="gambar" accept="image/*">
    </p>

    <p>
      <button type="submit" name="update">Update</button>
    </p>
  </form>

  <a href="index.php">Kembali</a>

</body>
</html>
