<?php
include 'config.php';

if (isset($_POST['submit'])) {
  $nama_depan    = $_POST['nama_depan'];
  $nama_belakang = $_POST['nama_belakang'];
  $id_pemilih    = $_POST['id_pemilih'];
  $email         = $_POST['email'];

  $query = "INSERT INTO pemilih (nama_depan, nama_belakang, id_pemilih, email)
            VALUES ('$nama_depan', '$nama_belakang', '$id_pemilih', '$email')";

  if (mysqli_query($conn, $query)) {
    echo "<script>alert('Data pemilih berhasil disimpan'); window.location.href='pemilih.php';</script>";
  } else {
    echo "<script>alert('Gagal menyimpan data!');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Pemilih</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6f9;
      padding: 20px;
    }
    .form-container {
      background-color: white;
      width: 400px;
      margin: 40px auto;
      padding: 20px;
      border-radius: 6px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-top: 10px;
    }
    input[type="text"], input[type="email"] {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    button {
      margin-top: 20px;
      width: 100%;
      background-color: #0073b7;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
    }
    button:hover {
      background-color: #005d96;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2>Tambah Pemilih</h2>
    <form method="post" action="">
      <label for="nama_depan">Nama Depan</label>
      <input type="text" name="nama_depan" id="nama_depan" required>

      <label for="nama_belakang">Nama Belakang</label>
      <input type="text" name="nama_belakang" id="nama_belakang" required>

      <label for="id_pemilih">ID Pemilih</label>
      <input type="text" name="id_pemilih" id="id_pemilih" required>

      <label for="email">Email</label>
      <input type="email" name="email" id="email" required>

      <button type="submit" name="submit">Simpan</button>
    </form>
  </div>

</body>
</html>
