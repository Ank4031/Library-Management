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
    <title>Login - InDus Library</title>
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
            background: linear-gradient(135deg, #dff6ff, #a5c9ca);
            min-height: 100vh;
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

        .login_box {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        h1 {
            color: #102c57;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
        }

        table tr {
            margin-bottom: 10px;
        }

        table td {
            padding: 10px 5px;
            font-weight: 500;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #0077b6;
        }

        input[type="submit"] {
            background-color: #394867;
            color: white;
            padding: 10px 25px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #2c3e50;
        }

        .message {
            margin-top: 15px;
            color: #e63946;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="register_Page.php">Register</a>
        <a href="login_Page.php">Login</a>
    </nav>
    <div class="login_box">
        <h1>Login Form</h1>
        <form action="" method="post">
            <table>
                <tr>
                    <td id='label'>Username</td><td><input id="username" type="text" placeholder="Username" name="username" required></td>
                </tr>
                <tr>
                    <td id='label'>Password</td><td><input id="passwd" type="password" placeholder="Password" name="password" required></td>
                </tr>
            </table>
            <input type="submit">
        </form>
        <div class="message"></div>
    </div>
</body>
<script>
    document.querySelector('form').addEventListener("submit",function(e){
        e.preventDefault();
        const formData = new FormData(this);
        fetch("backend/login.php",{
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(data=>{
            console.log(data);
            const msgBox = document.querySelector(".message");
            if (data == "logged_In"){
                window.location.href = "login_Users/dashboard.php";
            } else if (data == "wrong_Username") {
                msgBox.innerHTML = `<h2>Username incorrect !!</h2>`;
            } else if (data == "wrong_Password") {
                msgBox.innerHTML = `<h2>Password incorrect !!</h2>`;
            }
        })
    })
</script>
</html>
