<?php
session_start();
if (isset($_SESSION['user_id'])){
    header("location: ../login_Users/dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - InDus Library</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
            background: linear-gradient(135deg, #dff6ff, #a5c9ca);
            padding: 40px 20px;
        }

        nav {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 40px;
        }

        nav a {
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            padding: 10px 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        nav a:hover {
            background-color: #394867;
            color: #fff;
            transform: scale(1.05);
        }

        h1 {
            font-size: 36px;
            color: #102c57;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="register_Page.php">Register</a>
        <a href="login_Page.php">Login</a>
    </nav>
    <h1>Welcome to the InDus Library</h1>
</body>
</html>
