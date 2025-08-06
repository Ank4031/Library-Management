<?php
session_start();
require_once 'db.php';

$c = new db();
$conn = $c->get_Con();
$a1 = $c->check_Email($_POST['email']);
if ($a1){
    echo 'used_Email';
    exit();
}
$a2 = $c->check_Username($_POST['username']);
if ($a2){
    echo 'used_Username';
    exit();
}

$str = $conn->prepare("UPDATE users SET name=?, username=?, email=?, password=? WHERE user_id=?");
$str->bind_param('ssssi',$_POST['name'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['id']);
$str->execute();
echo 'updated';
