<?php
session_start();
if (!(isset($_SESSION['user_id']))) {
    header("location: ../../index.php");
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
  <title>Add Book - InDus Library</title>
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

    #label{
        text-align:left;
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

  <h1>Add New Book</h1>

  <div class="form-container">
    <form action="" method="post">
      <table>
        <tr>
          <td id='label'><label for="title">Title</label></td>
          <td><input id="title" type="text" name="title" placeholder="Book Title" required></td>
        </tr>
        <tr>
          <td id='label'><label for="author">Author</label></td>
          <td><input id="author" type="text" name="author" placeholder="Author Name" required></td>
        </tr>
        <tr>
          <td id='label'><label for="categories">Category</label></td>
          <td>
            <select id="categories" name="category" required>
              <option value="">Loading...</option>
            </select>
          </td>
        </tr>
        <tr>
          <td id='label'><label for="quantity">Quantity</label></td>
          <td><input id="quantity" type="text" name="quantity" placeholder="Quantity" required></td>
        </tr>
        <tr>
          <td id='label'><label for="availability">Availability</label></td>
          <td><input id="availability" type="text" name="availability" placeholder="Availability" required></td>
        </tr>
      </table>
      <input type="submit" value="Add Book">
    </form>
    <div class="message" id="msgBox"></div>
  </div>

  <script>
    // Form submission
    document.querySelector('form').addEventListener("submit", function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      fetch("../../backend/book_add.php", {
        method: 'POST',
        body: formData
      })
      .then(res => res.text())
      .then(data => {
        const msg = document.getElementById("msgBox");
        if (data === "added") {
          msg.textContent = "✅ New Book Added Successfully!";
          msg.classList.remove("error");
        } else {
          msg.textContent = "❌ Failed to add book!";
          msg.classList.add("error");
        }
      });
    });

    // Load category options
    fetch("../../backend/category_data.php")
    .then(res => res.json())
    .then(data => {
      const select = document.querySelector("#categories");
      select.innerHTML = "";
      if (data[0].error === "False") {
        data.forEach((e, index) => {
          if (index > 0) {
            select.innerHTML += `<option value="${e.name}">${e.name}</option>`;
          }
        });
      } else {
        select.innerHTML = `<option value="">No categories found</option>`;
        document.getElementById("msgBox").innerHTML = `<h2 class="error">❌ Error loading categories</h2>`;
      }
    });
  </script>
</body>
</html>
