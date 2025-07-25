<?php
include 'config.php'; // koneksi database
$result = mysqli_query($conn, "SELECT * FROM pemilih ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Para Pemilih</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <style>
   * { box-sizing: border-box; }
body {
  margin: 0;
  font-family: 'Poppins', sans-serif;
  background-color: #f0f2f5;
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
  padding: 10px;
  display: block;
  border-radius: 4px;
  transition: all 0.2s;
  font-size: 16px;
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
  font-size: 18px;
}
.container {
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.table-controls {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}
select, input[type="search"] {
  padding: 6px;
  border: 1px solid #ddd;
  border-radius: 4px;
}
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}
table, th, td {
  border: 1px solid #ddd;
}
th {
  background: #2563eb;
  color: white;
  padding: 10px;
}
td {
  padding: 10px;
}
tr:hover {
  background: #f9fafb;
}
.btn {
  padding: 6px 12px;
  border: none;
  border-radius: 4px;
  color: white;
  cursor: pointer;
  transition: all 0.2s;
}
.btn-add {
  background: #2563eb;
  margin-bottom: 10px;
}
.btn-add:hover {
  background: #1e40af;
}
.btn-delete {
  background: #dc2626;
}
.btn-delete:hover {
  background: #b91c1c;
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
      <li><a href="pemilih.php" class="active">Pemilih</a></li>
      <li><strong>KANDIDAT</strong></li>
      <li><a href="kandidat.php">Kandidat</a></li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="main">
    <div class="navbar">
      <div>Daftar Para Pemilih</div>
      <div><i class="fas fa-user-circle"></i> ADMIN </div>
    </div>

    <div class="container">
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
            <th>No</th>
            <th>Nama Depan</th>
            <th>Nama Belakang</th>
            <th>ID Pemilih</th>
            <th>Email</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['nama_depan']}</td>
                    <td>{$row['nama_belakang']}</td>
                    <td>{$row['id_pemilih']}</td>
                    <td>{$row['email']}</td>
                    <td>
                      <form action='hapus_pemilih.php' method='post' style='display:inline;'>
                        <input type='hidden' name='id_pemilih' value='{$row['id_pemilih']}'>
                        <button type='submit' class='btn btn-delete'>
                          <i class='fas fa-trash'></i> Hapus
                        </button>
                      </form>
                    </td>
                  </tr>";
            $no++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Highlight active sidebar -->
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
