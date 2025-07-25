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

// Ambil semua kandidat
$query = "SELECT * FROM kandidat";
$result = $conn->query($query);

// Cek apakah pemilih sudah voting
$vote_query = $conn->prepare("SELECT * FROM vote WHERE id_pemilih = ?");
$vote_query->bind_param("s", $_SESSION['id_pemilih']);
$vote_query->execute();
$vote_result = $vote_query->get_result();
$sudah_voting = $vote_result->num_rows > 0;

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Halaman Voting</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #0000ff, #000080);
      color: white;
      min-height: 100vh;
    }

    .navbar {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: bold;
    }

    a.logout {
      color: #00f2fe;
      text-decoration: none;
      font-weight: bold;
    }
    a.logout:hover {
      text-decoration: underline;
    }

    .container {
      max-width: 600px;
      margin: 50px auto;
      background: rgba(255, 255, 255, 0.1);
      padding: 30px;
      border-radius: 16px;
      backdrop-filter: blur(10px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
      text-align: center;
      animation: fadeIn 1s ease forwards;
    }

    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(-20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    h2 {
      margin-bottom: 10px;
    }

    small {
      color: #ddd;
    }

    .kandidat-list {
      margin-top: 20px;
      text-align: left;
    }

    .kandidat-item {
      background: rgba(255, 255, 255, 0.2);
      border-radius: 12px;
      padding: 10px 15px;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      transition: transform 0.2s ease;
    }

    .kandidat-item:hover {
      transform: scale(1.02);
      background: rgba(255, 255, 255, 0.3);
    }

    .kandidat-item input[type="radio"] {
      margin-right: 10px;
      transform: scale(1.2);
      accent-color: #00f2fe;
    }

    .btn-submit, .reset-btn {
      background: #00f2fe;
      border: none;
      color: black;
      padding: 12px 20px;
      border-radius: 25px;
      cursor: pointer;
      font-weight: bold;
      margin-top: 20px;
      transition: all 0.3s ease;
    }

    .btn-submit:hover, .reset-btn:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 14px rgba(0,0,0,0.3);
    }

    .message {
      background: rgba(255, 255, 255, 0.2);
      color: white;
      padding: 15px;
      border-radius: 10px;
      font-weight: bold;
      margin-top: 20px;
      backdrop-filter: blur(10px);
    }
  </style>
</head>
<body>

<div class="navbar">
  <div>SISTEM VOTING</div>
  <div><?= $_SESSION['nama'] ?> | <a href="logout.php" class="logout">KELUAR</a></div>
</div>

<div class="container">
  <h2>PEMILIHAN KETUA PEMUDA & PEMUDI</h2>
  <small>Pilih salah satu kandidat terbaik pilihan Anda</small>

  <?php if ($sudah_voting): ?>
    <div class="message">
      Anda sudah melakukan voting. Terima kasih atas partisipasi Anda.
    </div>
  <?php else: ?>
    <form action="proses_voting.php" method="POST">
      <div class="kandidat-list">
        <?php while($row = $result->fetch_assoc()): ?>
        <label class="kandidat-item">
          <input type="radio" name="kandidat" value="<?= $row['id'] ?>" required>
          <?= $row['nama_depan'] . " " . $row['nama_belakang'] ?> (<?= $row['posisi'] ?>)
        </label>
        <?php endwhile; ?>
      </div>

      <button type="submit" class="btn-submit">Kirim Pilihan</button>
      <button type="button" class="reset-btn" onclick="resetVote()">Reset Pilihan</button>
    </form>
  <?php endif; ?>
</div>

<script>
  function resetVote() {
    document.querySelectorAll('input[name="kandidat"]').forEach(radio => radio.checked = false);
  }
</script>

</body>
</html>
