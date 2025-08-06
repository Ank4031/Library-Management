<?php
session_start();
if (!(isset($_SESSION['user_id']))){
    header("location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Issue Details - InDus Library</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: linear-gradient(to right, #f0f4f8, #d9e4f5);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 40px 20px;
    }

    h1 {
      font-size: 32px;
      margin-bottom: 20px;
      color: #102c57;
    }

    nav {
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
      margin-bottom: 30px;
    }

    nav a {
      text-decoration: none;
      color: white;
      background-color: #102c57;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    nav a:hover {
      background-color: #1d3557;
    }

    .data_box {
      width: 100%;
      max-width: 1100px;
      overflow-x: auto;
      background-color: white;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      text-align: center;
      font-size: 15px;
    }

    thead {
      background-color: #102c57;
      color: white;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 12px 15px;
    }

    tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    tbody tr:hover {
      background-color: #e4e9f0;
    }

    .message {
      margin-top: 20px;
      color: green;
      font-size: 18px;
    }

    @media (max-width: 600px) {
      table {
        font-size: 13px;
      }

      th, td {
        padding: 8px 10px;
      }
    }
  </style>
</head>
<body>
  <nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="profile.php">Profile</a>
    <?php if ($_SESSION['role'] == 'admin'): ?>
      <a href="add.php">ADD</a>
      <a href="book_return.php">Book Return</a>
      <a href="fine.php">Fine</a>
      <a href="show_tables.php">Data</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == 'user'): ?>
    <a href="issue_details.php">Issue Details</a>
    <?php endif; ?>
    <a href="logout.php">Logout</a>
  </nav>

  <h1>Issued Books Details</h1>

  <div class="data_box">
    <table>
      <thead>
        <tr>
          <th>Issue ID</th>
          <th>User ID</th>
          <th>Book ID</th>
          <th>Issue Date</th>
          <th>Return Date</th>
          <th>Actual Return Date</th>
          <th>Fine</th>
        </tr>
      </thead>
      <tbody id="data"></tbody>
    </table>
  </div>

  <div class="message"></div>

  <script>
    fetch("../backend/issue_data.php")
      .then(res => res.json())
      .then(data => {
        console.log(data);
        const body = document.querySelector("#data");
        data.forEach(e => {
          body.innerHTML += `
            <tr>
              <td>${e.issue_id}</td>
              <td>${e.user_id}</td>
              <td>${e.book_id}</td>
              <td>${e.issue_date}</td>
              <td>${e.return_date}</td>
              <td>${e.actual_return_date}</td>
              <td>${e.fine}</td>
            </tr>`;
        });
      });
  </script>
</body>
</html>
