<?php
session_start();

require_once "db.php";

$c = new db();
$conn = $c->get_Con();

$str = $conn->prepare("INSERT INTO category(name) values (?)");
$str->bind_param("s",$_POST['name']);
if ($str->execute()){
    echo "added";
}else{
    echo "error";
}

