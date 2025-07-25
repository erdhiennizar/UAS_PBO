<?php
// Koneksi DB
$host = "localhost";
$user = "root";
$pass = "";
$db   = "sistem_voting";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil total data
$total_posisi = $conn->query("SELECT COUNT(DISTINCT posisi) AS total FROM kandidat")->fetch_assoc()['total'];
$total_kandidat = $conn->query("SELECT COUNT(*) AS total FROM kandidat")->fetch_assoc()['total'];
$total_pemilih = $conn->query("SELECT COUNT(*) AS total FROM pemilih")->fetch_assoc()['total'];
$total_suara = $conn->query("SELECT COUNT(*) AS total FROM vote")->fetch_assoc()['total'];

// Ambil data untuk chart suara per kandidat
$chart_query = "
  SELECT 
    CONCAT(k.nama_depan, ' ', k.nama_belakang) AS nama_kandidat,
    COUNT(v.id_kandidat) AS total_suara
  FROM kandidat k
  LEFT JOIN vote v ON k.id = v.id_kandidat
  GROUP BY k.id
  ORDER BY nama_kandidat
";

$chart_labels = [];
$chart_data = [];

$result = $conn->query($chart_query);
while ($row = $result->fetch_assoc()) {
    $chart_labels[] = $row['nama_kandidat'];
    $chart_data[] = $row['total_suara'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Admin</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
 <style>
  * { box-sizing: border-box; }
  body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: #f0f2f5;
    color: #333;
  }
  .sidebar {
    width: 230px;
    height: 100vh;
    background: #111827;
    color: white;
    position: fixed;
    padding: 20px;
  }
  .sidebar h2 {
    font-size: 20px;
    margin-bottom: 10px;
    text-align: center;
  }
  .sidebar h3 {
    font-size: 14px;
    margin-bottom: 5px;
    text-align: center;
  }
  .sidebar p {
    text-align: center;
    font-size: 12px;
    margin-bottom: 20px;
  }
  .sidebar ul {
    list-style: none;
    padding: 0;
  }
  .sidebar ul li {
    margin: 10px 0;
  }
  .sidebar ul li a {
    color: #d1d5db;
    text-decoration: none;
    padding: 8px 12px;
    display: block;
    border-radius: 4px;
    transition: all 0.3s;
  }
  .sidebar ul li a:hover,
  .sidebar ul li a.active {
    background: #2563eb;
    color: white;
    font-weight: bold;
  }
  .main {
    margin-left: 230px;
    padding: 20px;
  }
  .navbar {
    background: #2563eb;
    color: white;
    padding: 12px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 6px;
    margin-bottom: 20px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }
  .dashboard-cards {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
  }
  .card {
    background: white;
    color: #111827;
    padding: 20px;
    flex: 1;
    min-width: 200px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
  }
  .card:hover {
    transform: translateY(-5px);
  }
  .card span {
    font-size: 28px;
    font-weight: bold;
    display: block;
    margin-bottom: 10px;
  }
  .card small {
    color: #6b7280;
  }
  h2 {
    margin-top: 30px;
    margin-bottom: 10px;
    font-weight: bold;
  }
  .chart-box {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    margin-top: 20px;
  }
  .btn-print {
    background: #2563eb;
    color: white;
    padding: 10px 16px;
    border: none;
    cursor: pointer;
    border-radius: 25px;
    margin-top: 20px;
    transition: all 0.3s;
  }
  .btn-print:hover {
    background: #1e40af;
  }
  .btn-print a {
    color: white;
    text-decoration: none;
  }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h2>SISTEM-VOTING</h2>
  <h3>ADMIN</h3>
  <p><i class="fas fa-circle" style="color:limegreen;"></i> Online</p>
  <ul>
    <li><strong>LAPORAN</strong></li>
    <li><a href="dashboard_admin.php" class="active">Dashboard</a></li>
    <li><a href="suara.php">Suara</a></li>
    <li><strong>KELOLA</strong></li>
    <li><a href="pemilih.php">Pemilih</a></li>
    <li><strong>KANDIDAT</strong></li>
    <li><a href="kandidat.php">Kandidat</a></li>
  </ul>
</div>

<!-- Main Content -->
<div class="main">
  <div class="navbar">
    <div>Dashboard</div>
    <div><i class="fas fa-user-circle"></i> ADMIN </div>
  </div>

  <div class="dashboard-cards">
    <div class="card">
      <span><?= $total_posisi ?></span><br>Total Posisi
      <small>Selengkapnya..</small>
    </div>
    <div class="card">
      <span><?= $total_kandidat ?></span><br>Total Kandidat
      <small>Selengkapnya..</small>
    </div>
    <div class="card">
      <span><?= $total_pemilih ?></span><br>Total Para Pemilih
      <small>Selengkapnya..</small>
    </div>
    <div class="card">
      <span><?= $total_suara ?></span><br>Total Suara Voting
      <small>Selengkapnya..</small>
    </div>
  </div>

  <h2>DIAGRAM INFORMASI SUARA</h2>

  <div class="chart-box">
    <strong>CALON KETUA PEMUDA (2024–2029)</strong>
    <canvas id="chartPemuda"></canvas>
    <button class="btn-print"><a href="cetak.php">Cetak</a></button>
  </div>
</div>

<!-- Chart.js Script -->
<script>
const ctx1 = document.getElementById('chartPemuda').getContext('2d');
const chartPemuda = new Chart(ctx1, {
  type: 'bar',
  data: {
    labels: <?= json_encode($chart_labels) ?>,
    datasets: [{
      label: 'Jumlah Suara',
      data: <?= json_encode($chart_data) ?>,
      backgroundColor: '#3c8dbc'
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: true }
    },
    scales: {
      y: { beginAtZero: true }
    }
  }
});
</script>

</body>
</html>
