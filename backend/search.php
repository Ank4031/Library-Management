<?php
session_start();
require_once "db.php";

$c = new db();
$conn = $c->get_Con();
$str = $conn->query("SELECT * from books");
$data=array();
while($row=$str->fetch_assoc()){
    $data[] = $row;
}
echo json_encode($data);
exit();