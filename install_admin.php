<?php
include "config.php";

$username = 'admin';
$password = 'admin123';

$cek = $conn->query("SELECT * FROM admin WHERE username='$username'");
if ($cek->num_rows == 0) {
  $stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?,?)");
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();
  echo "✅ Admin default berhasil dibuat!<br>Username: admin | Password: admin123";
} else {
  echo "ℹ️ Admin sudah ada.";
}
?>
