<?php
session_start();
require_once "db.php";

$c = new db();
$conn = $c->get_Con();
$data = array();

$str = $conn->prepare("SELECT * FROM books where title=?");
$str->bind_param("s",$_POST['filter']);
$str->execute();
$result = $str->get_result();
while ($row = $result->fetch_assoc()){
    $data[] = $row;
}

$str1 = $conn->prepare("SELECT * FROM books where author=?");
$str1->bind_param("s",$_POST['filter']);
$str1->execute();
$result1 = $str1->get_result();
while ($row1 = $result1->fetch_assoc()){
    $data[] = $row1;
}

$str2 = $conn->prepare("SELECT * FROM books where category=?");
$str2->bind_param("s",$_POST['filter']);
$str2->execute();
$result2 = $str2->get_result();
while ($row2 = $result2->fetch_assoc()){
    $data[] = $row2;
}

echo json_encode($data);
exit();