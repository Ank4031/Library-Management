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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tables - InDus Library</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(to right, #f0f4f8, #d9e4f5);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
            min-height: 100vh;
        }

        nav {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        nav a {
            text-decoration: none;
            color: #fff;
            background-color: #102c57;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: #1d3557;
        }

        .button table {
            margin-bottom: 30px;
        }

        .button td {
            padding: 10px;
        }

        .button button {
            width: 200px;
            padding: 10px;
            font-size: 16px;
            background-color: #394867;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button button:hover {
            background-color: #2c3e50;
        }

        .table {
            width: 100%;
            overflow-x: auto;
        }

        .table table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color: white;
        }

        .table th,
        .table td {
            border: 1px solid #ccc;
            padding: 10px 15px;
            text-align: center;
            font-size: 14px;
        }

        .table th {
            background-color: #0077b6;
            color: white;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        @media screen and (max-width: 768px) {
            .button table {
                width: 100%;
            }

            .button button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="profile.php">Profile</a>
        <?php if($_SESSION['role']=='admin'):?>
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

    <div class="button">
        <table>
            <tr><td><button id="fine_data">Fine Table</button></td></tr>
            <tr><td><button id="user_data">Users Table</button></td></tr>
            <tr><td><button id="issue_data">Issued Book</button></td></tr>
            <tr><td><button id="book_data">Books Table</button></td></tr>
            <tr><td><button id="category_data">Categories</button></td></tr>
        </table>
    </div>

    <div class="table">
        <table>
            <thead>
                <tr id="heading"></tr>
            </thead>
            <tbody id="data"></tbody>
        </table>
    </div>

    <script>
        const buttons = document.querySelectorAll('button');
        let table_name;
        buttons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                const head = document.querySelector("#heading");
                const body = document.querySelector("#data");
                head.innerHTML = "";
                body.innerHTML = "";

                switch (e.target.id) {
                    case 'fine_data':
                        table_name = "fine";
                        break;
                    case 'user_data':
                        table_name = "users";
                        break;
                    case 'issue_data':
                        table_name = "books_issues";
                        break;
                    case 'book_data':
                        table_name = "books";
                        break;
                    case 'category_data':
                        table_name = "category";
                        break;
                }

                fetch("../backend/data.php", {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "table=" + encodeURIComponent(table_name)
                })
                .then(res => res.json())
                .then(data => {
                    let keys = Object.keys(data[0]);
                    keys.forEach(h => {
                        head.innerHTML += `<th>${h}</th>`;
                    });

                    data.forEach((d, idx) => {
                        let rowHtml = "<tr>";
                        keys.forEach(k => {
                            rowHtml += `<td>${d[k]}</td>`;
                        });
                        rowHtml += "</tr>";
                        body.innerHTML += rowHtml;
                    });
                });
            });
        });
    </script>
</body>
</html>
