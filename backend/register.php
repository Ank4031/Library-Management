<?php
session_start();

if (!(isset($_SESSION['user_id']))){
    header("location: ../login_Users/dashboard.php");
}
if (!(ctype_alnum($_POST['username']))){
    echo "invalid_Username";
    exit();
}
if (!(ctype_alnum($_POST['name']))){
    echo "invalid_Name";
    exit();
}
if(isset($_POST['conf_Password'])){
    if ($_POST['password'] != $_POST['conf_Password']){
        echo "passwd_MissMatched";
        exit();
    }
}
if (!($_POST['username'] && $_POST['name'] && $_POST['email'] && $_POST['password'])){
    echo "empty_Feild";
    exit();
}
require_once 'db.php';
$conn = new db();
$a1 = $conn->check_Email($_POST['email']);
if ($a1){
    echo "used_Email";
    exit();
}
$a2 = $conn->check_Username($_POST['username']);
if ($a2){
    echo "used_Username";
    exit();
}
if ($conn->create_User($_POST)){
    echo "registered";
    exit();
}


