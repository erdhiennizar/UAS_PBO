<?php
session_start();          // Memulai sesi
session_unset();          // Menghapus semua variabel sesi
session_destroy();        // Mengakhiri sesi sepenuhnya
header("Location: auth.php");  // Redirect ke halaman login/daftar
exit();
