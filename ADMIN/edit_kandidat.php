<?php
include 'config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
  echo "<script>alert('ID tidak ditemukan!'); window.location.href='kandidat.php';</script>";
  exit;
}

if (isset($_POST['submit'])) {
  $nama_depan = $_POST['nama_depan'];
  $nama_belakang = $_POST['nama_belakang'];
  $posisi = $_POST['posisi'];

  $update = "UPDATE kandidat 
             SET nama_depan = '$nama_depan', nama_belakang = '$nama_belakang', posisi = '$posisi' 
             WHERE id = $id";

  if (mysqli_query($conn, $update)) {
    echo "<script>alert('Data berhasil diperbarui'); window.location.href='kandidat.php';</script>";
  } else {
    echo "<script>alert('Gagal memperbarui data!');</script>";
  }
}

// Ambil data lama
$result = mysqli_query($conn, "SELECT * FROM kandidat WHERE id = $id");
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Kandidat</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .form-container {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(8px);
      width: 400px;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #111827;
    }

    label {
      display: block;
      margin-top: 15px;
      color: #374151;
      font-weight: 500;
    }

    input[type="text"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      transition: border 0.3s;
    }

    input[type="text"]:focus {
      border-color: #0f0fe0ff;
      outline: none;
    }

    button {
      width: 100%;
      margin-top: 25px;
      background: #0f0fe0ff;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      transition: background 0.3s;
    }

    button:hover {
      background: #15803d;
    }

    .back-link {
      display: block;
      text-align: center;
      margin-top: 15px;
      text-decoration: none;
      color: #0f0fe0ff;
      font-size: 14px;
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2><i class="fas fa-user-edit"></i> Edit Kandidat</h2>
    <form method="post">
      <label for="nama_depan">Nama Depan</label>
      <input type="text" name="nama_depan" id="nama_depan" value="<?= htmlspecialchars($data['nama_depan']) ?>" required>

      <label for="nama_belakang">Nama Belakang</label>
      <input type="text" name="nama_belakang" id="nama_belakang" value="<?= htmlspecialchars($data['nama_belakang']) ?>" required>

      <label for="posisi">Posisi</label>
      <input type="text" name="posisi" id="posisi" value="<?= htmlspecialchars($data['posisi']) ?>" required>

      <button type="submit" name="submit"><i class="fas fa-save"></i> Simpan Perubahan</button>
    </form>
    <a href="kandidat.php" class="back-link"><i class="fas fa-arrow-left"></i> Kembali ke Kandidat</a>
  </div>

</body>
</html>
