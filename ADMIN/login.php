<?php
session_start();
include 'config.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM admin WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) === 1) {
  $row = mysqli_fetch_assoc($result);

  // Cocokkan langsung tanpa password_verify
  if ($password === $row['password']) {
    $_SESSION['username'] = $username;
    header("Location: dashboard_admin.php");
    exit();
  }
}

echo "<script>alert('Username atau password salah!'); window.location.href='login_admin.html';</script>";
?>
