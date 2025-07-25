<?php
session_start();

if (!isset($_SESSION['id_pemilih'])) {
    header("Location: auth.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pemilih = $_SESSION['id_pemilih'];
    $id_kandidat = $_POST['kandidat'];

    $conn = new mysqli("localhost", "root", "", "sistem_voting");
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Cek apakah pemilih sudah voting
    $cek = $conn->prepare("SELECT * FROM vote WHERE id_pemilih = ?");
    $cek->bind_param("s", $id_pemilih);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows > 0) {
        echo "Anda sudah voting!";
    } else {
        $stmt = $conn->prepare("INSERT INTO vote (id_pemilih, id_kandidat) VALUES (?, ?)");
        $stmt->bind_param("si", $id_pemilih, $id_kandidat);

        if ($stmt->execute()) {
            echo "<script>alert('Terima kasih, suara Anda tercatat.'); window.location='voting.php';</script>";
        } else {
            echo "Gagal menyimpan suara.";
        }

        $stmt->close();
    }

    $conn->close();
}
?>
