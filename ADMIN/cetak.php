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

// Ambil data chart
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
  <title>Halaman Cetak Admin</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #fff;
      padding: 20px;
    }
    h2 {
      margin-top: 0;
      font-size: 20px;
      text-align: center;
    }
    .desc {
      font-size: 14px;
      line-height: 1.6;
      margin-bottom: 20px;
      text-align: justify;
    }
    .chart-box {
      max-width: 700px;
      margin: 0 auto;
    }
    .print-btn {
      display: block;
      margin: 30px auto;
      background-color: #3c8dbc;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }

    @media print {
      .print-btn {
        display: none;
      }
    }
  </style>
</head>
<body>

  <h2>Diagram Informasi Suara</h2>
  <p class="desc">
    Halaman ini menampilkan hasil suara dalam bentuk diagram. Diagram dapat dicetak atau disimpan dalam bentuk PDF menggunakan fitur cetak browser. Gunakan tombol di bawah untuk mencetak.
  </p>

  <div class="chart-box">
    <canvas id="chartVoting"></canvas>
  </div>

  <button class="print-btn" onclick="window.print()">🖨️ Cetak Sekarang</button>

  <script>
    const ctx = document.getElementById('chartVoting').getContext('2d');
    new Chart(ctx, {
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
          legend: { display: false },
          title: {
            display: true,
            text: 'Perolehan Suara Kandidat'
          }
        },
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  </script>

</body>
</html>
