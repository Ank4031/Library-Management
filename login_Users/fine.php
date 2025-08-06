<?php
session_start();
if (!(isset($_SESSION['user_id']))){
    header("location: ../index.php");
}
if ($_SESSION['role'] != 'admin'){
    header("location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Fine - InDus Library</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: linear-gradient(to right, #e3f2fd, #f5f7fa);
      min-height: 100vh;
      padding: 40px 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    nav {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 15px;
      margin-bottom: 30px;
    }

    nav a {
      text-decoration: none;
      background-color: #102c57;
      color: white;
      padding: 10px 18px;
      border-radius: 8px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    nav a:hover {
      background-color: #1d3557;
    }

    h2 {
      margin: 20px 0;
      color: #102c57;
      text-align: center;
    }

    form {
      text-align: center;
      margin-bottom: 30px;
      background-color: white;
      padding: 20px 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    table {
      margin: 20px auto;
      border-collapse: collapse;
      width: 100%;
      max-width: 700px;
    }

    th, td {
      padding: 12px 15px;
      border: 1px solid #ccc;
      text-align: center;
    }

    thead {
      background-color: #102c57;
      color: white;
    }

    tbody tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    input[type="number"], input[type="submit"] {
      padding: 8px 10px;
      border: 1px solid #999;
      border-radius: 6px;
      width: 200px;
      font-size: 15px;
      margin-top: 8px;
    }

    input[type="submit"] {
      background-color: #102c57;
      color: white;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: #1c3a73;
    }

    .data_box, .fine_box {
      display: none;
      width: 100%;
      max-width: 800px;
    }

    .message {
      font-size: 18px;
      color: #1b5e20;
      margin-top: 10px;
    }

    @media (max-width: 600px) {
      table, th, td {
        font-size: 14px;
      }

      input[type="number"], input[type="submit"] {
        width: 100%;
      }

      form {
        width: 90%;
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

  <form id="fine_data" method="post">
    <h2>Check Fine by User ID</h2>
    <input id="user_id" name="id" type="number" placeholder="Enter User ID" required />
    <br><br>
    <input type="submit" value="Check Fine" />
  </form>

  <div class="data_box">
    <table>
      <thead>
        <tr>
          <th>User ID</th>
          <th>Issue ID</th>
          <th>Fine Amount</th>
        </tr>
      </thead>
      <tbody id="data"></tbody>
    </table>
  </div>

  <div class="message"></div>

  <div class="fine_box">
    <form id="pay_fine" method="post">
      <h2>Pay Fine</h2>
      <input name="id" type="number" placeholder="User ID" required />
      <br><br>
      <input name="fine" type="number" placeholder="Enter Amount to Pay" required />
      <br><br>
      <input type="submit" value="Pay Fine" />
    </form>
  </div>

  <script>
    document.querySelector("#fine_data").addEventListener("submit", function (e) {
      e.preventDefault();
      const form_Data = new FormData(this);
      fetch("../backend/get_fine.php", {
        method: 'POST',
        body: form_Data
      })
        .then(res => res.json())
        .then(data => {
          console.log(data);
          const messageDiv = document.querySelector(".message");
          const tableBody = document.querySelector("#data");
          if (data[0].error === 'no_Fine') {
            messageDiv.innerHTML = `<h2>No fine on the User.</h2>`;
          } else if (data[0].error === 'fine') {
            document.querySelector(".data_box").style.display = 'block';
            tableBody.innerHTML = '';
            let total = 0;
            data.slice(1).forEach(e => {
              total += e.fine;
              tableBody.innerHTML += `
                <tr>
                  <td>${e.user_id}</td>
                  <td>${e.issue_id}</td>
                  <td>${e.fine}</td>
                </tr>`;
            });
            messageDiv.innerHTML = `<h2>Total fine of the User = ₹${total}</h2>`;
            document.querySelector(".fine_box").style.display = 'block';
          }
        });
    });

    document.querySelector("#pay_fine").addEventListener("submit", function (e) {
      e.preventDefault();
      const form_Data = new FormData(this);
      fetch("../backend/pay_fine.php", {
        method: 'POST',
        body: form_Data
      })
        .then(res => res.text())
        .then(data => {
          console.log(data);
          const messageDiv = document.querySelector(".message");
          if (data === 'fine_Updated') {
            messageDiv.innerHTML = `<h2>Fine is updated successfully.</h2>`;
            document.querySelector(".fine_box").style.display = 'none';
            document.querySelector(".data_box").style.display = 'none';
          }
        });
    });
  </script>
</body>
</html>
