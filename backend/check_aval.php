<?php
session_start();

require_once "db.php";
$c = new db();
$conn = $c->get_Con();

$str = $conn->prepare("SELECT available from books where book_id = ?");
$str->bind_param('i',$_POST['book_id']);
$str->execute();

$result = $str->get_result();
$row = $result->fetch_assoc();

if ($result->num_rows <1){
    echo "no_book";
    exit();
}else if ($row['available']>0){
    echo "available";
    exit();
}else{
    echo "none";
    exit();
}