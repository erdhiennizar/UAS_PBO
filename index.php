<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistem Informasi Voting</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #010ce7, #000066);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: white;
    }
    .content {
      text-align: center;
      animation: fadeIn 1s ease forwards;
    }
    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(-20px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    h1 {
      font-size: 32px;
      margin-bottom: 10px;
      letter-spacing: 1px;
    }
    p {
      font-size: 16px;
      font-style: italic;
      margin-bottom: 30px;
    }
    .box {
      background: rgba(255, 255, 255, 0.1);
      padding: 25px 40px;
      border-radius: 10px;
      backdrop-filter: blur(5px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
      display: inline-block;
      transition: transform 0.3s ease;
    }
    .box:hover {
      transform: translateY(-5px);
    }
    .btn {
      background: linear-gradient(45deg, #00ff99, #00ccff);
      border: none;
      color: white;
      padding: 12px 20px;
      margin: 10px;
      font-size: 16px;
      border-radius: 25px;
      text-decoration: none;
      display: inline-block;
      transition: all 0.3s ease;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .btn:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 14px rgba(0,0,0,0.3);
    }
  </style>
</head>
<body>

  <div class="content">
    <h1>SISTEM VOTING</h1>
    <p>Karang Taruna Desa Kelurahan</p>

    <div class="box">
      <a href="ADMIN/login_admin.php" class="btn">LOGIN ADMIN</a>
      <a href="PEMILIH/auth.php" class="btn">LOGIN PEMILIH</a>
    </div>
  </div>

</body>
</html>
