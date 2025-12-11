<?php
session_start();
include "../config.php";

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['admin_logged'])) {
  header("Location: index.php");
  exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $confirm = trim($_POST['confirm']);

  if ($password !== $confirm) {
    $message = "Password dan konfirmasi tidak cocok!";
  } else {
    // Cek apakah username sudah ada
    $check = $conn->prepare("SELECT * FROM admin WHERE username=?");
    $check->bind_param("s", $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
      $message = "Username sudah digunakan!";
    } else {
      // Simpan admin baru
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $query = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
      $query->bind_param("ss", $username, $hashedPassword);

      if ($query->execute()) {
        $message = "Registrasi berhasil! Silakan login.";
      } else {
        $message = "Terjadi kesalahan saat menyimpan data.";
      }
    }
  }
}
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register Admin</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    body.admin-login {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: linear-gradient(135deg, #000000, #1a1a1a, #222222);
      color: white;
      font-family: 'Poppins', sans-serif;
    }

    .login-box {
      background: rgba(30, 30, 30, 0.95);
      padding: 40px;
      border-radius: 20px;
      width: 340px;
      text-align: center;
      box-shadow: 0 0 25px rgba(255, 255, 255, 0.08);
      animation: fadeIn 0.7s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h2 {
      margin-bottom: 20px;
      color: #f5f5f5;
      letter-spacing: 1px;
    }

    input[type="text"], input[type="password"] {
      width: 90%;
      padding: 10px;
      margin: 8px 0;
      border: none;
      border-radius: 10px;
      background: #2a2a2a;
      color: white;
      font-size: 14px;
      outline: none;
      transition: 0.2s;
    }

    input[type="text"]:focus, input[type="password"]:focus {
      background: #333;
      box-shadow: 0 0 5px #007bff;
    }

    button {
      width: 95%;
      padding: 10px;
      border: none;
      border-radius: 10px;
      background: #007bff;
      color: white;
      font-size: 15px;
      cursor: pointer;
      margin-top: 15px;
      transition: 0.3s;
    }

    button:hover {
      background: #0056b3;
      transform: scale(1.03);
    }

    .error {
      color: #ff4d4d;
      font-size: 14px;
      margin-bottom: 10px;
    }

    p {
      margin-top: 15px;
      font-size: 14px;
      color: #ddd;
    }

    a {
      color: #00bfff;
      text-decoration: none;
      font-weight: bold;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body class="admin-login">
  <main class="login-box">
    <h2>Register Admin</h2>
    <?php if (!empty($message)) echo "<p class='error'>$message</p>"; ?>
    <form method="POST">
      <input type="text" name="username" placeholder="Username" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <input type="password" name="confirm" placeholder="Konfirmasi Password" required><br>
      <button type="submit">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
  </main>
</body>
</html>
