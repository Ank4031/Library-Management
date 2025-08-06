<?php
session_start();
require_once "db.php";

$c = new db();
$conn = $c->get_Con();
$table = $_POST['table'];
$query = "SELECT * FROM `$table`";
$result = $conn->query($query);
$data = array();
while ($row = $result->fetch_assoc()){
    $data[] = $row;
}
echo json_encode($data);
exit();