<?php
session_start();
if (!(isset($_SESSION['user_id']))){
    header("location: ../index.php");
}
if ($_SESSION['role']!='admin'){
    header("location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Return Book - InDus Library</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: linear-gradient(to right, #f3f4f6, #e8f0fe);
      min-height: 100vh;
      margin: 0;
      padding: 30px 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    nav {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 15px;
      margin-bottom: 40px;
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

    h1 {
      color: #102c57;
      margin-bottom: 20px;
    }

    .return_book_box {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 500px;
    }

    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 15px;
    }

    td {
      padding: 5px 0;
    }

    #label {
      text-align: right;
      font-weight: 600;
      color: #333;
      padding-right: 15px;
      width: 120px;
    }

    input[type="number"],
    input[type="date"] {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      outline: none;
      transition: border-color 0.3s;
    }

    input[type="number"]:focus,
    input[type="date"]:focus {
      border-color: #102c57;
    }

    input[type="submit"] {
      margin-top: 20px;
      width: 100%;
      padding: 12px;
      background-color: #102c57;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: #1d3557;
    }

    .message {
      margin-top: 25px;
      font-size: 18px;
      font-weight: bold;
      color: #102c57;
      text-align: center;
    }

    @media (max-width: 500px) {
      #label {
        width: auto;
        text-align: left;
        display: block;
        margin-bottom: 5px;
      }

      table, tr, td {
        display: block;
        width: 100%;
      }

      td input {
        margin-bottom: 15px;
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

  <div class="return_book_box">
    <h1>Enter Return Details</h1>
    <form action="" method='post'>
      <table>
        <tr>
          <td id='label'>User ID</td>
          <td><input id='user_id' name='user_id' type="number" placeholder='User ID' required></td>
        </tr>
        <tr>
          <td id='label'>Book ID</td>
          <td><input id='book_id' name='book_id' type="number" placeholder='Book ID' required></td>
        </tr>
        <tr>
          <td id='label'>Return Date</td>
          <td><input id='return_date' name='return_date' type="date" required></td>
        </tr>
      </table>
      <input type="submit" value="Submit Return">
    </form>
  </div>

  <div class="message"></div>

  <script>
    document.querySelector("form").addEventListener("submit", function (e) {
      e.preventDefault();
      const form_Data = new FormData(this);

      fetch("../backend/return.php", {
        method: 'POST',
        body: form_Data
      })
      .then(res => res.text())
      .then(data => {
        console.log(data);
        const messageBox = document.querySelector(".message");
        if (data == "no_Issue") {
          messageBox.innerHTML = `<h2>No such issued book found.</h2>`;
        } else if (data == "on_Time") {
          messageBox.innerHTML = `<h2>Return Confirmed.</h2>`;
        } else if (data == "late_Submission") {
          messageBox.innerHTML = `<h2>Late Return.</h2>`;
        }
      });
    });
  </script>
</body>
</html>
