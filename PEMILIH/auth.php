<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$db   = "sistem_voting";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$success = "";
$error = "";

// Proses Daftar
if (isset($_POST['daftar'])) {
    $nama_depan = $_POST['firstname'];
    $nama_belakang = $_POST['lastname'];
    $email = $_POST['email'];
    $password_raw = $_POST['password'];
    $password_hash = password_hash($password_raw, PASSWORD_DEFAULT);
    $id_pemilih = uniqid($nama_depan . "-");

    $cek = $conn->prepare("SELECT * FROM pemilih WHERE email = ?");
    $cek->bind_param("s", $email);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows > 0) {
        $error = "Email sudah digunakan!";
    } else {
        $stmt = $conn->prepare("INSERT INTO pemilih (nama_depan, nama_belakang, id_pemilih, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nama_depan, $nama_belakang, $id_pemilih, $email, $password_hash);
        if ($stmt->execute()) {
            $success = "Pendaftaran berhasil! ID Anda: <strong>$id_pemilih</strong>";
        } else {
            $error = "Gagal mendaftar: " . $stmt->error;
        }
        $stmt->close();
    }
    $cek->close();
}

// Proses Login
if (isset($_POST['login'])) {
    $id_pemilih = $_POST['id_pemilih'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM pemilih WHERE id_pemilih = ?");
    $stmt->bind_param("s", $id_pemilih);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $data = $result->fetch_assoc();
        if (password_verify($password, $data['password'])) {
            $_SESSION['id_pemilih'] = $data['id_pemilih'];
            $_SESSION['nama'] = $data['nama_depan'] . " " . $data['nama_belakang'];
            header("Location: voting.php");
            exit();
        } else {
            $error = "Kata sandi salah!";
        }
    } else {
        $error = "ID Pemilih tidak ditemukan!";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login / Daftar Pemilih</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #0000ff, #000080);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: white;
    }
    .form-box {
      background: rgba(255, 255, 255, 0.1);
      padding: 30px;
      border-radius: 16px;
      backdrop-filter: blur(10px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
      width: 350px;
      text-align: center;
      animation: fadeIn 1s ease forwards;
    }
    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(-20px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    h2 {
      font-size: 24px;
      margin-bottom: 5px;
    }
    p.subtitle {
      font-size: 14px;
      color: #ddd;
      margin-bottom: 20px;
    }
    .input-group {
      position: relative;
      margin-bottom: 15px;
    }
    .input-group input {
      width: 100%;
      padding: 12px 45px 12px 15px;
      border: none;
      border-radius: 25px;
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
    .btn {
      background: #00f2fe;
      border: none;
      color: black;
      font-weight: bold;
      padding: 12px;
      width: 100%;
      border-radius: 25px;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
    }
    .btn:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 14px rgba(0,0,0,0.3);
    }
    .message {
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 15px;
      font-size: 14px;
    }
    .success { background: #d4edda; color: #155724; }
    .error { background: #f8d7da; color: #721c24; }
    .switch-link {
      margin-top: 15px;
      font-size: 14px;
    }
    .switch-link a {
      color: #00f2fe;
      text-decoration: none;
      cursor: pointer;
    }
    .switch-link a:hover {
      text-decoration: underline;
    }
    .back-home {
      display: block;
      margin-top: 15px;
      color: #00f2fe;
      text-decoration: none;
      font-size: 14px;
    }
    .back-home:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="form-box">
  <h2 id="form-title"><i class="fas fa-user"></i> Daftar Pemilih</h2>
  <p class="subtitle" id="form-subtitle">Silakan isi data Anda untuk mendaftar</p>

  <?php if (!empty($success)): ?>
    <div class="message success"><?= $success ?></div>
  <?php endif; ?>
  <?php if (!empty($error)): ?>
    <div class="message error"><?= $error ?></div>
  <?php endif; ?>

  <!-- FORM DAFTAR -->
  <form id="form-daftar" method="POST" style="display: block;">
    <div class="input-group">
      <input type="text" name="firstname" placeholder="Nama Depan" required>
      <i class="fa fa-user"></i>
    </div>
    <div class="input-group">
      <input type="text" name="lastname" placeholder="Nama Belakang" required>
      <i class="fa fa-user"></i>
    </div>
    <div class="input-group">
      <input type="email" name="email" placeholder="Email" required>
      <i class="fa fa-envelope"></i>
    </div>
    <div class="input-group">
      <input type="password" name="password" placeholder="Kata Sandi" required>
      <i class="fa fa-lock"></i>
    </div>
    <button type="submit" name="daftar" class="btn"><i class="fa fa-user-plus"></i> Daftar</button>
    <div class="switch-link">Sudah punya akun? <a onclick="showLogin()">Login di sini</a></div>
  </form>

  <!-- FORM LOGIN -->
  <form id="form-login" method="POST" style="display: none;">
    <div class="input-group">
      <input type="text" name="id_pemilih" placeholder="ID Pemilih" required>
      <i class="fa fa-id-badge"></i>
    </div>
    <div class="input-group">
      <input type="password" name="password" placeholder="Kata Sandi" required>
      <i class="fa fa-lock"></i>
    </div>
    <button type="submit" name="login" class="btn"><i class="fa fa-sign-in-alt"></i> Login</button>
    <div class="switch-link">Belum punya akun? <a onclick="showRegister()">Daftar di sini</a></div>
  </form>

  <a href="../index.php" class="back-home"><i class="fa fa-arrow-left"></i> Kembali ke Beranda</a>

</div>

<script>
  function showLogin() {
    document.getElementById('form-daftar').style.display = 'none';
    document.getElementById('form-login').style.display = 'block';
    document.getElementById('form-title').innerHTML = '<i class="fas fa-sign-in-alt"></i> Login Pemilih';
    document.getElementById('form-subtitle').innerText = 'Silakan masukkan ID dan Password Anda';
  }

  function showRegister() {
    document.getElementById('form-daftar').style.display = 'block';
    document.getElementById('form-login').style.display = 'none';
    document.getElementById('form-title').innerHTML = '<i class="fas fa-user"></i> Daftar Pemilih';
    document.getElementById('form-subtitle').innerText = 'Silakan isi data Anda untuk mendaftar';
  }

  <?php if (!empty($success)): ?>
    showLogin();
  <?php endif; ?>
</script>

</body>
</html>
