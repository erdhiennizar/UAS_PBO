<?php
include 'config.php';

if (isset($_POST['id_pemilih'])) {
  $id_pemilih = $_POST['id_pemilih'];

  // Eksekusi query hapus
  $query = "DELETE FROM pemilih WHERE id_pemilih = '$id_pemilih'";
  if (mysqli_query($conn, $query)) {
    echo "<script>alert('Data pemilih berhasil dihapus'); window.location.href='pemilih.php';</script>";
  } else {
    echo "<script>alert('Gagal menghapus data!'); window.location.href='pemilih.php';</script>";
  }
} else {
  echo "<script>alert('ID pemilih tidak ditemukan!'); window.location.href='pemilih.php';</script>";
}
?>
