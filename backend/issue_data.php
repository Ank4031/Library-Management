<?php
session_start();

require_once "db.php";

$c = new db();
$conn = $c->get_Con();

$data = array();
$str = $conn->prepare('SELECT * FROM books_issues where user_id = ?');
$str->bind_param('i',$_SESSION['user_id']);
$str->execute();

$result = $str->get_result();
while ($row = $result->fetch_assoc()){
    $data[] = $row;
}
echo json_encode($data);
exit();