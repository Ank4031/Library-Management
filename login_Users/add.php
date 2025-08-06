<?php
session_start();
if (!(isset($_SESSION['user_id']))) {
    header("location: ../index.php");
}
if ($_SESSION['role'] != 'admin') {
    header("location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin - Add Options</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: #f4f6f8;
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

    .option_box {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      width: 100%;
    }

    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 20px;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #102c57;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #1d3557;
    }

    @media (max-width: 480px) {
      .option_box {
        padding: 20px;
      }

      button {
        font-size: 15px;
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

  <div class="option_box">
    <table>
      <tr>
        <td><button id="issue_book">📕 Issue Book</button></td>
      </tr>
      <tr>
        <td><button id="add_book">📘 Add Book</button></td>
      </tr>
      <tr>
        <td><button id="add_book_category">📚 Add Book Category</button></td>
      </tr>
      <tr>
        <td><button id="add_user">👤 Add User</button></td>
      </tr>
    </table>
  </div>

  <script>
    document.querySelector("#issue_book").addEventListener("click", () => {
      window.location.href = "add_Data/issue_book.php";
    });

    document.querySelector("#add_user").addEventListener("click", () => {
      window.location.href = "add_Data/add_user.php";
    });

    document.querySelector("#add_book_category").addEventListener("click", () => {
      window.location.href = "add_Data/add_book_category.php";
    });

    document.querySelector("#add_book").addEventListener("click", () => {
      window.location.href = "add_Data/add_book.php";
    });
  </script>
</body>
</html>
