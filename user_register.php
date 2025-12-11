<?php
include "../pariwisata/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $nama = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO user (username, password, nama_lengkap, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $nama, $email);

    if ($stmt->execute()) {
        $success = "Registrasi berhasil! <a href='user_login.php'>Login sekarang</a>";
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register User</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>

<div class="auth-container">
    <h2>Register</h2>

    <?php
    if (!empty($success)) echo "<p class='success'>$success</p>";
    if (!empty($error)) echo "<p class='error'>$error</p>";
    ?>

    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Nama Lengkap</label>
        <input type="text" name="nama_lengkap" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Register</button>
    </form>

    <p class="redirect-text">
        Sudah punya akun? <a href="user_login.php">Login di sini</a>
    </p>
</div>

</body>
</html>
