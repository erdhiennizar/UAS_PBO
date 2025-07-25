<?php
$host = "localhost";
$user = "root";     // sesuaikan jika pakai password
$pass = "";
$db   = "sistem_voting";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}
?>
