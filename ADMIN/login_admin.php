<?php
session_start();
include 'config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM admin WHERE username = '$username'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    if ($password === $row['password']) {
      $_SESSION['username'] = $username;
      header("Location: dashboard_admin.php");
      exit();
    }
  }

  $error = "Username atau password salah!";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #00008B, #0000CD);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: white;
    }
    .login-box {
      background: rgba(255, 255, 255, 0.1);
      padding: 40px 30px;
      border-radius: 15px;
      backdrop-filter: blur(10px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.3);
      width: 350px;
      text-align: center;
    }
    .login-box h2 {
      margin-bottom: 10px;
      font-weight: bold;
      font-size: 24px;
    }
    .login-box p {
      margin-bottom: 25px;
      font-size: 14px;
    }
    .input-group {
      position: relative;
      margin-bottom: 20px;
    }
    .input-group input {
      width: 100%;
      padding: 12px 45px 12px 15px;
      border: none;
      border-radius: 30px;
      background: rgba(255, 255, 255, 0.2);
      color: white;
      font-size: 14px;
      outline: none;
      box-sizing: border-box;
    }
    .input-group i {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: white;
    }
    .btn-login {
      background: aqua;
      color: black;
      border: none;
      padding: 12px;
      width: 100%;
      border-radius: 30px;
      cursor: pointer;
      font-weight: bold;
      font-size: 14px;
      transition: all 0.3s ease;
    }
    .btn-login:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 14px rgba(0,0,0,0.3);
    }
    .back-link {
      margin-top: 15px;
      display: inline-block;
      color: aqua;
      font-size: 14px;
      text-decoration: none;
    }
    .error {
      color: #ff4d4d;
      margin-bottom: 15px;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2><i class="fas fa-user-shield"></i> Login Admin</h2>
    <p>Silakan masukkan Username dan Password</p>
    <?php if (!empty($error)): ?>
      <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="input-group">
        <input type="text" name="username" placeholder="Nama Pengguna" required>
        <i class="fas fa-user"></i>
      </div>
      <div class="input-group">
        <input type="password" name="password" placeholder="Kata Sandi" required>
        <i class="fas fa-lock"></i>
      </div>
      <button type="submit" class="btn-login">
        <i class="fas fa-sign-in-alt"></i> LOGIN
      </button>
    </form>
    <a href="../index.php" class="back-link">
      <i class="fas fa-arrow-left"></i> Kembali ke Beranda
    </a>
  </div>
</body>
</html>
