<?php
session_start();

require_once 'db.php';
$c = new db();
$conn = $c->get_Con();
$str = $conn->prepare("SELECT * FROM users WHERE username=? and password=?");
$a = $c->check_Username($_POST['username']);
if (!($a)){
    echo "wrong_Username".$a;
    exit();
}
$str->bind_param("ss",$_POST['username'],$_POST['password']);
$str->execute();
$result = $str->get_result();
if ($result->num_rows>0){
    $data = $result->fetch_assoc();
    $_SESSION['user_id'] = $data['user_id'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['name'] = $data['name'];
    $_SESSION['email'] = $data['email'];
    $_SESSION['role'] = $data['role'];
    echo "logged_In";
    exit();
}else{
    echo "wrong_Password";
    exit();
}
