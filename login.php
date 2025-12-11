<?php
session_start();
include "../config.php";

if (isset($_SESSION['admin_logged'])) {
  header("Location: index.php");
  exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $query = $conn->prepare("SELECT * FROM admin WHERE username=?");
  $query->bind_param("s", $username);
  $query->execute();
  $result = $query->get_result();

  if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();

    // Verifikasi password terenkripsi
    if (password_verify($password, $admin['password'])) {
      $_SESSION['admin_logged'] = true;
      header("Location: index.php");
      exit;
    } else {
      $error = "Password salah!";
    }
  } else {
    $error = "Username tidak ditemukan!";
  }
}
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login Admin</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    body.admin-login {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: #111;
      color: white;
      font-family: Arial, sans-serif;
    }

    .login-box {
      background: #1c1c1c;
      padding: 30px;
      border-radius: 15px;
      width: 320px;
      text-align: center;
      box-shadow: 0 0 15px rgba(255,255,255,0.1);
    }

    .login-box h2 {
      margin-bottom: 20px;
      color: #f5f5f5;
    }

    input[type="text"], input[type="password"] {
      width: 90%;
      padding: 10px;
      margin: 8px 0;
      border: none;
      border-radius: 8px;
      background: #2c2c2c;
      color: white;
    }

    button {
      width: 95%;
      padding: 10px;
      border: none;
      border-radius: 8px;
      background: #007bff;
      color: white;
      cursor: pointer;
      margin-top: 10px;
      transition: 0.2s;
    }

    button:hover {
      background: #0056b3;
    }

    .error {
      color: #ff4d4d;
      font-size: 14px;
      margin-bottom: 10px;
    }

    .register-link {
      margin-top: 15px;
      font-size: 14px;
    }

    .register-link a {
      color: #00bfff;
      text-decoration: none;
      font-weight: bold;
    }

    .register-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body class="admin-login">
  <main class="login-box">
    <h2>Login Admin</h2>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
      <input type="text" name="username" placeholder="Username" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit">Login</button>
    </form>
    <div class="register-link">
      <p>Belum punya akun? <a href="register.php">Register dulu</a></p>
    </div>
  </main>
</body>
</html>
