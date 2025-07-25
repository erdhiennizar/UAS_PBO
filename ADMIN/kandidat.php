<?php
include 'config.php';

// Ambil data dari tabel kandidat
$query = "SELECT id, nama_depan, nama_belakang, posisi FROM kandidat";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Kandidat</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f0f2f5;
    }
    .sidebar {
      width: 230px;
      height: 100vh;
      background-color: #111827;
      color: white;
      position: fixed;
      padding: 20px;
    }
    .sidebar h2, .sidebar h3 {
      font-size: 18px;
      text-align: center;
      margin: 0 0 10px 0;
    }
    .sidebar p {
      text-align: center;
      font-size: 13px;
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
      padding: 10px;
      display: block;
      border-radius: 4px;
      transition: all 0.2s;
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
      background-color: #2563eb;
      color: white;
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-radius: 6px;
      margin-bottom: 20px;
    }
    .container {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .btn {
      padding: 8px 16px;
      border: none;
      border-radius: 6px;
      color: white;
      cursor: pointer;
      margin: 5px 5px 5px 0;
      font-size: 14px;
      transition: all 0.3s;
    }
    .btn:hover {
      opacity: 0.9;
      transform: scale(1.03);
    }
    .btn-add { background-color: #10b981; margin-bottom: 15px; }
    .btn-edit { background-color: #3b82f6; }
    .btn-delete { background-color: #ef4444; }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: left;
    }
    th {
      background-color: #f9fafb;
      color: #111827;
    }
    tr:hover { background-color: #f1f5f9; }
    @media (max-width: 768px) {
      .main {
        margin-left: 0;
        padding: 10px;
      }
      .sidebar {
        position: relative;
        width: 100%;
        height: auto;
      }
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
      <li><a href="suara.php">Suara</a></li>
      <li><strong>KELOLA</strong></li>
      <li><a href="pemilih.php">Pemilih</a></li>
      <li><strong>KANDIDAT</strong></li>
      <li><a href="kandidat.php" class="active">Kandidat</a></li>
    </ul>
  </div>

  <!-- Main -->
  <div class="main">
    <div class="navbar">
      <div>Daftar Kandidat</div>
      <div><i class="fas fa-user-circle"></i> ADMIN</div>
    </div>

    <div class="container">
      <button class="btn btn-add" onclick="window.location.href='tambah_kandidat.php'">
        <i class="fas fa-plus"></i> Tambah Kandidat
      </button>

      <table>
        <thead>
          <tr>
            <th>Nama Depan</th>
            <th>Nama Belakang</th>
            <th>Posisi</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)) : ?>
          <tr>
            <td><?= htmlspecialchars($row['nama_depan']) ?></td>
            <td><?= htmlspecialchars($row['nama_belakang']) ?></td>
            <td><?= htmlspecialchars($row['posisi']) ?></td>
            <td>
              <a href="edit_kandidat.php?id=<?= $row['id'] ?>" class="btn btn-edit">
                <i class="fas fa-pen"></i> Edit
              </a>
              <form action="hapus_kandidat.php" method="post" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus kandidat ini?');">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <button type="submit" class="btn btn-delete">
                  <i class="fas fa-trash"></i> Hapus
                </button>
              </form>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Sidebar highlight -->
  <script>
    const sidebarLinks = document.querySelectorAll(".sidebar ul li a");
    const currentPage = window.location.pathname.split("/").pop();
    sidebarLinks.forEach(link => {
      if (link.getAttribute("href") === currentPage) {
        link.classList.add("active");
      }
    });
  </script>

</body>
</html>
