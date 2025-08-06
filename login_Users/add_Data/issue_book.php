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
  <title>Issue Book - InDus Library</title>
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

    .form-box {
      text-align:center;
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 550px;
      margin-bottom: 20px;
    }

    #label{
        text-align:left;
    }

    table {
      width: 100%;
      margin-bottom: 15px;
    }

    td {
      padding: 10px;
      font-size: 16px;
    }

    input[type="number"],
    input[type="date"] {
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

    .message,
    .message0 {
      margin-top: 10px;
      text-align: center;
      font-weight: bold;
      font-size: 18px;
      color: #155724;
    }

    .message.error,
    .message0.error {
      color: #c0392b;
    }

    @media (max-width: 600px) {
      nav a {
        padding: 8px 14px;
        font-size: 14px;
      }

      .form-box {
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

  <h1>Issue a Book</h1>

  <div class="form-box">
    <form id="check_aval" action="" method='post'>
      <table>
        <tr>
          <td id='label'><label for="book_id">Book ID</label></td>
          <td><input id="book_id" name="book_id" type="number" placeholder="Enter Book ID" required></td>
        </tr>
      </table>
      <input type="submit" value="Check Availability">
      <div class="message0"></div>
    </form>
  </div>

  <div class="form-box">
    <form id="make_issue" action="" method='post'>
      <table>
        <tr>
          <td id='label'><label for="user_id">User ID</label></td>
          <td><input id="user_id" name="user_id" type="number" placeholder="Enter User ID" required></td>
        </tr>
        <tr>
          <td id='label'><label for="issue_date">Issue Date</label></td>
          <td><input id="issue_date" name="issue_date" type="date" required></td>
        </tr>
      </table>
      <input type="submit" value="Issue Book">
    </form>
    <div class="message"></div>
  </div>

  <script>
    let Book_id;

    document.querySelector('#check_aval').addEventListener("submit", function(e) {
      e.preventDefault();
      Book_id = document.querySelector('#book_id').value;
      const message = document.querySelector('.message0');
      const form_data = new FormData(this);

      fetch("../../backend/check_aval.php", {
        method: "POST",
        body: form_data
      })
      .then(res => res.text())
      .then(data => {
        console.log(data);
        message.classList.remove('error');
        if (data === 'available') {
          message.innerHTML = `<span>✅ Book is available.</span>`;
        } else if (data === 'none') {
          message.innerHTML = `<span class="error">❌ Book is not available.</span>`;
          message.classList.add('error');
        } else if (data === 'no_book') {
          message.innerHTML = `<span class="error">❌ No such book exists.</span>`;
          message.classList.add('error');
        }
      });

      document.querySelector('.message').innerHTML = "";
    });

    document.querySelector('#make_issue').addEventListener("submit", function(e) {
      e.preventDefault();
      const user_id = document.querySelector('#user_id').value;
      const issue_date = document.querySelector('#issue_date').value;
      const message = document.querySelector('.message');

      if (Book_id) {
        fetch("../../backend/make_issue.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: "book_id=" + encodeURIComponent(Book_id) + "&user_id=" + encodeURIComponent(user_id) + "&issue_date=" + encodeURIComponent(issue_date)
        })
        .then(res => res.text())
        .then(data => {
          console.log(data);
          message.classList.remove('error');
          if (data === 'issued') {
            message.innerHTML = `<span>✅ Book has been issued.</span>`;
          } else if (data === 'error') {
            message.innerHTML = `<span class="error">❌ Something went wrong.</span>`;
            message.classList.add('error');
          } else if (data === 'no_user') {
            message.innerHTML = `<span class="error">❌ Invalid User ID.</span>`;
            message.classList.add('error');
          } else if (data === 'error1') {
            message.innerHTML = `<span class="error">❌ Modification failed.</span>`;
            message.classList.add('error');
          }
        });
      } else {
        message.innerHTML = `<span class="error">❌ Please check book availability first.</span>`;
        message.classList.add('error');
      }
    });
  </script>
</body>
</html>
