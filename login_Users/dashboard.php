<?php
session_start();
if (!(isset($_SESSION['user_id']))) {
    header("location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Live Search - InDus Library</title>
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
      margin-bottom: 20px;
      color: #102c57;
    }

    .search-container {
      background-color: white;
      padding: 25px 30px;
      border-radius: 10px;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 650px;
    }

    table {
      width: 100%;
    }

    td {
      padding: 10px;
    }

    #search_here input {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #bbb;
      border-radius: 6px;
      outline: none;
    }

    #search_button button {
      padding: 10px 15px;
      font-size: 16px;
      background-color: #102c57;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    #search_button button:hover {
      background-color: #1d3557;
    }

    #search_result {
      margin-top: 30px;
      width: 100%;
      max-width: 650px;
    }

    .data_box {
      background-color: #fff;
      padding: 20px;
      margin-bottom: 20px;
      border-left: 5px solid #102c57;
      border-radius: 8px;
      box-shadow: 0 0 8px rgba(0,0,0,0.05);
    }

    .data_box table {
      width: 100%;
      border-collapse: collapse;
    }

    .data_box td {
      padding: 6px 8px;
      font-size: 15px;
    }

    .data_box td:first-child {
      font-weight: bold;
      width: 30%;
    }

    @media (max-width: 600px) {
      nav a {
        padding: 8px 14px;
        font-size: 14px;
      }

      .search-container {
        padding: 20px;
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
    <a href="issue_details.php">Issue Details</a>
    <a href="logout.php">Logout</a>
  </nav>

  <h1>Live Search</h1>

  <div class="search-container">
    <table>
      <tr>
        <td><label for="search">Search</label></td>
        <td id="search_here">
          <input id="search" type="text" list="suggestions" placeholder="Enter title, author, or category...">
          <datalist id="suggestions"></datalist>
        </td>
        <td id="search_button">
          <button type="button">🔍</button>
        </td>
      </tr>
    </table>
  </div>

  <div id="search_result"></div>

  <script>
    const datalist = document.querySelector("#suggestions");

    fetch("../backend/search.php")
      .then(res => res.json())
      .then(data => {
        data.forEach(d => {
          datalist.innerHTML += `<option value="${d.title}">`;
          datalist.innerHTML += `<option value="${d.author}">`;
          datalist.innerHTML += `<option value="${d.category}">`;
        });
      });

    document.querySelector("#search_button button").addEventListener("click", () => {
      const value = document.querySelector("#search").value;

      fetch("../backend/search_data.php", {
        method: 'POST',
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "filter=" + encodeURIComponent(value)
      })
      .then(res => res.json())
      .then(data => {
        const search_result = document.querySelector("#search_result");
        search_result.innerHTML = '';
        
        data.forEach(d => {
          const new_class = document.createElement('div');
          new_class.className = "data_box";
          new_class.innerHTML = `
            <table>
              <tr><td>Title:</td><td>${d.title}</td></tr>
              <tr><td>Author:</td><td>${d.author}</td></tr>
              <tr><td>Category:</td><td>${d.category}</td></tr>
              <tr><td>Available:</td><td>${d.available}</td></tr>
            </table>
          `;
          search_result.appendChild(new_class);
        });
      });
    });
  </script>
</body>
</html>
