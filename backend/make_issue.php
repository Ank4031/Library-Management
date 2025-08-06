<?php
session_start();

require_once "db.php";
$c = new db();
$conn = $c->get_Con();

$str0 = $conn->prepare("SELECT user_id from users where user_id = ?");
$str0->bind_param('i',$_POST['user_id']);
$str0->execute();

$result0 = $str0->get_result();
if ($result0->num_rows <1){
    echo "no_user";
    exit();
}

$issue_date = $_POST['issue_date'];
$date = new DateTime($issue_date);
$date->modify('+14 days');
$return_date = $date->format('Y-m-d');

$str = $conn->prepare("INSERT INTO books_issues(book_id, user_id, issue_date, return_date) values (?,?,?,?)");
$str->bind_param('iiss',$_POST['book_id'],$_POST['user_id'],$_POST['issue_date'],$return_date);
if ($str->execute()){
    $str1 = $conn->prepare("UPDATE books set available = available - 1 WHERE book_id = ?");
    $str1->bind_param('i',$_POST['book_id']);
    if($str1->execute()){
        echo "issued";
        exit();
    }else{
        echo "error1";
        exit();
    }
}else{
    echo "error";
    exit();
}