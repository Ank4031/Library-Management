<?php
session_start();
if (!(isset($_SESSION['user_id']))){
    header("location: ../../index.php");
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
  <title>Add User - InDus Library</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: linear-gradient(to right, #f5f7fa, #e3f2fd);
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

    h1 {
      color: #102c57;
      margin-bottom: 20px;
    }

    .form-container {
      text-align:center;
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 550px;
    }

    table {
      width: 100%;
      margin-bottom: 20px;
    }

    td {
      padding: 10px;
      font-size: 16px;
    }

    input[type="text"],
    input[type="password"],
    select {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    input[type="submit"] {
      background-color: #102c57;
      color: white;
      padding: 10px 20px;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: #1d3557;
    }

    #label{
        text-align:left;
    }

    .message {
      margin-top: 20px;
      text-align: center;
      font-size: 18px;
      font-weight: bold;
      color: #155724;
    }

    .message.error {
      color: #c0392b;
    }

    @media (max-width: 600px) {
      nav a {
        padding: 8px 14px;
        font-size: 14px;
      }

      .form-container {
        width: 90%;
        padding: 20px;
      }
    }
  </style>
</head>
<body>

  <nav>
    <a href="../dashboard.php">Dashboard</a>
    <a href="issue_book.php">Issue Book</a>
    <a href="add_book_category.php">Add Book Category</a>
    <a href="add_book.php">Add Book</a>
    <a href="add_user.php">Add User</a>
  </nav>

  <h1>Add New User</h1>

  <div class="form-container">
    <form action="" method="post">
      <table>
        <tr>
          <td id='label'><label for="username">Username</label></td>
          <td><input id="username" type="text" name="username" placeholder="Username" required></td>
        </tr>
        <tr>
          <td id='label'><label for="name">Name</label></td>
          <td><input id="name" type="text" name="name" placeholder="Full Name" required></td>
        </tr>
        <tr>
          <td id='label'><label for="email">Email</label></td>
          <td><input id="email" type="text" name="email" placeholder="Email" required></td>
        </tr>
        <tr>
          <td id='label'><label for="passwd">Password</label></td>
          <td><input id="passwd" type="password" name="password" placeholder="Password" required></td>
        </tr>
        <tr>
          <td id='label'><label for="role">Role</label></td>
          <td>
            <select id="role" name="role" required>
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>
          </td>
        </tr>
      </table>
      <input type="submit" value="Add User">
    </form>
    <div class="message" id="msgBox"></div>
  </div>

  <script>
    let message = document.querySelector("#msgBox");

    document.querySelector('form').addEventListener("submit", function(e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch("../../backend/register.php", {
        method: 'POST',
        body: formData
      })
      .then(res => res.text())
      .then(data => {
        console.log(data);
        message.classList.remove("error");

        if (data === "registered") {
          message.innerHTML = `<span>✅ New User Added.</span>`;
        } else {
          message.classList.add("error");
          if (data === "invalid_Username") {
            message.innerHTML = `<span>❌ Username should only contain alphabets and numbers.</span>`;
          } else if (data === "invalid_Name") {
            message.innerHTML = `<span>❌ Name should only contain alphabets and spaces.</span>`;
          } else if (data === "used_Username") {
            message.innerHTML = `<span>❌ Username already in use!</span>`;
          } else if (data === "used_Email") {
            message.innerHTML = `<span>❌ Email already in use!</span>`;
          } else if (data === "passwd_MissMatched") {
            message.innerHTML = `<span>❌ Passwords didn't match!</span>`;
          } else if (data === "empty_Feild") {
            message.innerHTML = `<span>❌ All fields are required!</span>`;
          } else {
            message.innerHTML = `<span>❌ Unknown error occurred.</span>`;
          }
        }
      });
    });
  </script>
</body>
</html>
