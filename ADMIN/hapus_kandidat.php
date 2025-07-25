<?php
include 'config.php';

if (isset($_POST['id'])) {
  $id = $_POST['id'];

  $query = "DELETE FROM kandidat WHERE id = $id";
  if (mysqli_query($conn, $query)) {
    echo "<script>alert('Kandidat berhasil dihapus'); window.location.href='kandidat.php';</script>";
  } else {
    echo "<script>alert('Gagal menghapus kandidat!'); window.location.href='kandidat.php';</script>";
  }
} else {
  echo "<script>alert('ID tidak ditemukan!'); window.location.href='kandidat.php';</script>";
}
?>
