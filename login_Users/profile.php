<?php
session_start();
if (!(isset($_SESSION['user_id']))){
    header("location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - InDus Library</title>
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

        h1 {
            margin-bottom: 30px;
            font-size: 32px;
            color: #102c57;
        }

        nav {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        nav a {
            text-decoration: none;
            color: white;
            background-color: #102c57;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: #1d3557;
        }

        .profile_box table {
            border-collapse: collapse;
            width: 100%;
            max-width: 600px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .profile_box table tr td {
            padding: 12px 15px;
            font-size: 16px;
        }

        .profile_box table tr td:first-child {
            font-weight: bold;
            color: #1d3557;
            background-color: #f2f2f2;
            width: 40%;
        }

        .profile_box input[type="text"] {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .buttons button {
            padding: 10px 20px;
            background-color: #394867;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .buttons button:hover:enabled {
            background-color: #2c3e50;
        }

        .buttons button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .message h2 {
            color: green;
            margin-top: 15px;
            font-size: 18px;
        }

        @media screen and (max-width: 600px) {
            .profile_box table, .profile_box table tr, .profile_box table td {
                display: block;
                width: 100%;
            }

            .profile_box table tr {
                margin-bottom: 10px;
            }

            .profile_box table td:first-child {
                background-color: transparent;
                font-weight: normal;
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

    <h1>User Profile</h1>

    <div class="profile_box">
        <table>
            <tr>
                <td>ID</td>
                <td><input id='id' type="text" value='<?php echo $_SESSION['user_id'] ?>' disabled></td>
            </tr>
            <tr>
                <td>Name</td>
                <td><input id='name' type="text" value='' disabled></td>
            </tr>
            <tr>
                <td>Username</td>
                <td><input id='username' type="text" value='' disabled></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input id='email' type="text" value='' disabled></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input id='password' type="text" value='' disabled></td>
            </tr>
        </table>
    </div>

    <div class="buttons">
        <button id='edit_Button'>Edit Profile</button>
        <button id='save_Button' disabled>Save</button>
        <button id='reset_Button' disabled>Reset</button>
    </div>

    <div class="message"></div>

    <script>
        const Name = document.querySelector('#name');
        const username = document.querySelector('#username');
        const email = document.querySelector('#email');

        function get_Data(){
            fetch("../backend/get_data.php", {
                method:'POST',
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "id=" + encodeURIComponent("<?php echo $_SESSION['user_id']?>")
            })
            .then(res => res.json())
            .then(data => {
                Name.value = data[0].name;
                username.value = data[0].username;
                email.value = data[0].email;
                document.querySelector('#password').value = data[0].password;
            });
        }

        get_Data();

        document.querySelector('#edit_Button').addEventListener('click', () => {
            document.querySelectorAll('input').forEach(e => e.disabled = false);
            document.querySelector("#id").disabled = true;
            document.querySelector("#save_Button").disabled = false;
            document.querySelector("#reset_Button").disabled = false;
        });

        document.querySelector('#save_Button').addEventListener('click', () => {
            fetch("../backend/update_profile.php", {
                method: 'POST',
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "id=" + encodeURIComponent("<?php echo $_SESSION['user_id']?>") +
                      "&name=" + encodeURIComponent(Name.value) +
                      "&username=" + encodeURIComponent(username.value) +
                      "&email=" + encodeURIComponent(email.value) +
                      "&password=" + encodeURIComponent(document.querySelector('#password').value)
            })
            .then(res => res.text())
            .then(data => {
                const msg = document.querySelector(".message");
                if (data == "used_Email") {
                    msg.innerHTML = `<h2>Email already in use.</h2>`;
                } else if (data == "used_Username") {
                    msg.innerHTML = `<h2>Username already in use.</h2>`;
                } else if (data == "updated") {
                    get_Data();
                    msg.innerHTML = `<h2>Update Complete.</h2>`;
                    document.querySelector("#save_Button").disabled = true;
                    document.querySelector("#reset_Button").disabled = true;
                    document.querySelectorAll('input').forEach(e => e.disabled = true);
                }
            });
        });

        document.querySelector('#reset_Button').addEventListener("click", () => {
            get_Data();
            document.querySelector("#save_Button").disabled = true;
            document.querySelector("#reset_Button").disabled = true;
            document.querySelectorAll('input').forEach(e => e.disabled = true);
        });
    </script>
</body>
</html>
