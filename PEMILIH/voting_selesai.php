<?php
session_start();

// Proteksi akses tanpa login
if (!isset($_SESSION['id_pemilih'])) {
    header("Location: auth.php");
    exit();
}

$host = "localhost";
$user = "root";
$pass = "";
$db   = "sistem_voting";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data voting pemilih
$id_pemilih = $_SESSION['id_pemilih'];
$query = $conn->prepare("SELECT kandidat.* FROM vote 
                        JOIN kandidat ON vote.id_kandidat = kandidat.id
                        WHERE vote.id_pemilih = ?");
$query->bind_param("s", $id_pemilih);
$query->execute();
$result = $query->get_result();
$kandidat_terpilih = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Voting Selesai</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      margin: 0;
    }

    .navbar {
      background-color: #007bff;
      color: white;
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
    }

    .container {
      padding: 30px;
      text-align: center;
    }

    .alert-success {
      background: #28a745;
      color: white;
      padding: 15px;
      border-radius: 5px;
      width: 60%;
      margin: 0 auto 30px;
    }

    .btn {
      padding: 10px 20px;
      background: #007bff;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      display: inline-block;
      margin-top: 20px;
    }

    .btn:hover {
      background: #0056b3;
    }

    .kandidat-box {
      margin-top: 20px;
      padding: 20px;
      background: #fff;
      display: inline-block;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .kandidat-box img {
      width: 100px;
      height: 100px;
      border-radius: 8px;
      object-fit: cover;
      margin-bottom: 10px;
    }

    .kandidat-box h4 {
      margin: 10px 0 5px;
    }

    .kandidat-box p {
      color: #555;
      margin: 0;
    }
  </style>
</head>
<body>

<div class="navbar">
  <div>SISTEM-VOTING</div>
  <div>
    <?= $_SESSION['nama'] ?> |
    <a href="logout.php" style="color:white; text-decoration: none;">KELUAR</a>
  </div>
</div>

<div class="container">
  <div class="alert-success">
    ✅ Success! Vote berhasil dikirim
  </div>

  <h3>TERIMA KASIH ANDA TELAH MELAKUKAN PEMILIHAN</h3>
  <p>Klik tombol lihat jika ingin melihat kandidat yang anda pilih</p>

  <a href="#kandidat" class="btn">Lihat</a>

  <?php if ($kandidat_terpilih): ?>
  <div id="kandidat" class="kandidat-box">
    <img src="img/default.jpg" alt="Foto Kandidat">
    <h4><?= $kandidat_terpilih['nama_depan'] . " " . $kandidat_terpilih['nama_belakang'] ?></h4>
    <p><?= $kandidat_terpilih['posisi'] ?></p>
  </div>
  <?php endif; ?>
</div>

</body>
</html>
