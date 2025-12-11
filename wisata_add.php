<?php
session_start();
if (!isset($_SESSION['admin_logged'])) {
  header("Location: login.php");
  exit;
}
include "../config.php";

// ambil kategori
$kategori = $conn->query("SELECT * FROM kategori");

if (isset($_POST['tambah'])) {
  $nama = $_POST['nama'];
  $lokasi = $_POST['lokasi'];
  $harga_tiket = $_POST['harga_tiket'];
  $id_kategori = $_POST['id_kategori'];
  $deskripsi = $_POST['deskripsi'];

  // upload gambar
  $target_dir = "../uploads/";
  $file_name = time() . "_" . basename($_FILES["gambar"]["name"]);
  $target_file = $target_dir . $file_name;

  if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
    $stmt = $conn->prepare("INSERT INTO wisata (nama, lokasi, harga_tiket, id_kategori, deskripsi, gambar) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdiss", $nama, $lokasi, $harga_tiket, $id_kategori, $deskripsi, $file_name);
    $stmt->execute();

    header("Location: index.php");
    exit;
  } else {
    echo "❌ Gagal upload gambar!";
  }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Tambah Wisata</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <h2>Tambah Wisata Baru</h2>

  <form method="POST" enctype="multipart/form-data">
    <p>
      <label>Nama Wisata:</label><br>
      <input type="text" name="nama" placeholder="Masukkan nama wisata" required>
    </p>

    <p>
      <label>Lokasi:</label><br>
      <input type="text" name="lokasi" placeholder="Masukkan lokasi wisata" required>
    </p>

    <p>
      <label>Harga Tiket (Rp):</label><br>
      <input type="number" step="0.01" name="harga_tiket" placeholder="Contoh: 25000" required>
    </p>

    <p>
      <label>Kategori:</label><br>
      <select name="id_kategori" required>
        <option value="">-- Pilih Kategori --</option>
        <?php while ($row = $kategori->fetch_assoc()): ?>
          <option value="<?= $row['id_kategori'] ?>"><?= $row['nama_kategori'] ?></option>
        <?php endwhile; ?>
      </select>
    </p>

    <p>
      <label>Deskripsi:</label><br>
      <textarea name="deskripsi" rows="4" cols="40" placeholder="Tulis deskripsi wisata..." required></textarea>
    </p>

    <p>
      <label>Upload Gambar:</label><br>
      <input type="file" name="gambar" accept="image/*" required>
    </p>

    <p>
      <button type="submit" name="tambah">Simpan</button>
    </p>
  </form>

  <a href="wisata.php">Kembali</a>
</body>
</html>
