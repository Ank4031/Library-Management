<?php
session_start();
require_once "db.php";

$c = new db();
$conn = $c->get_Con();

$str = $conn->prepare("INSERT INTO books(title,author,category,quantity,available) values (?,?,?,?,?)");
$str->bind_param("sssii",$_POST['title'],$_POST['author'],$_POST['category'],$_POST['quantity'],$_POST['availability']);
if ($str->execute()){
    echo "added";
}else{
    echo "error";
}

