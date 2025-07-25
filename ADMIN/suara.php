<?php
// Koneksi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "sistem_voting";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data suara dari vote + pemilih + kandidat
$sql = "SELECT 
          k.posisi, 
          CONCAT(k.nama_depan, ' ', k.nama_belakang) AS nama_kandidat,
          CONCAT(p.nama_depan, ' ', p.nama_belakang) AS nama_pemilih
        FROM vote v
        JOIN kandidat k ON v.id_kandidat = k.id
        JOIN pemilih p ON v.id_pemilih = p.id_pemilih
        ORDER BY k.posisi, nama_kandidat";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rekapan Suara</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    * {
      box-sizing: border-box;
    }
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
    .sidebar h2, .sidebar h3 {
    text-align: center;
    margin-bottom: 5px;
    }
    .sidebar p {
    text-align: center;
    font-size: 12px;
    margin-bottom: 15px;
    }
    .sidebar ul {
    list-style: none;
    padding: 0;
    }
    .sidebar ul li {
    margin: 8px 0;
    }
    .sidebar ul li a {
    color: #d1d5db;
    text-decoration: none;
    display: block;
    padding: 8px 12px;
    border-radius: 4px;
    transition: 0.3s;
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
    border-radius: 6px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    }
    .container {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .btn-reset {
    background: #10b981;
    border: none;
    color: white;
    padding: 8px 16px;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s;
    }
    .btn-reset:hover {
    background: #059669;
    }
    .table-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
    }
    .table-controls select,
    .table-controls input[type="search"] {
    padding: 6px 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    }
    table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    }
    table thead {
    background: #2563eb;
    color: white;
    }
    th, td {
    padding: 10px;
    border: 1px solid #ccc;
    }
    tbody tr:hover {
    background: #f1f5f9;
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
      <li><a href="dashboard_admin.php">Dashboard</a></li>
      <li><a href="suara.php" class="active">Suara</a></li>
      <li><strong>KELOLA</strong></li>
      <li><a href="pemilih.php">Pemilih</a></li>
      <li><strong>KANDIDAT</strong></li>
      <li><a href="kandidat.php">Kandidat</a></li>
    </ul>
  </div>

  <!-- Main -->
  <div class="main">
    <div class="navbar">
      <div>Rekapan Suara</div>
      <div><i class="fas fa-user-circle"></i> ADMIN </div>
    </div>

    <button class="btn-reset" onclick="if(confirm('Yakin refresh semua suara?')) { location.reload(); }">
  <i class="fas fa-rotate-left"></i> Refresh
    </button>

      <div class="table-controls">
        <div>
          Show
          <select>
            <option>10</option>
            <option>25</option>
            <option>50</option>
          </select> entries
        </div>
        <div>
          Search: <input type="search" />
        </div>
      </div>

      <table>
        <thead>
          <tr>
            <th>Posisi</th>
            <th>Kandidat</th>
            <th>Nama Pemilih</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['posisi'] ?></td>
            <td><?= $row['nama_kandidat'] ?></td>
            <td><?= $row['nama_pemilih'] ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Highlight menu aktif -->
  <script>
    const sidebarLinks = document.querySelectorAll(".sidebar ul li a");
    const currentPage = window.location.pathname.split("/").pop();
    sidebarLinks.forEach(link => {
      const hrefPage = link.getAttribute("href");
      if (hrefPage === currentPage) {
        link.classList.add("active");
      }
    });
  </script>

</body>
</html>
