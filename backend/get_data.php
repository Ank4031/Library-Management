<?php
session_start();

require_once 'db.php';

$c = new db();
$conn = $c->get_Con();
$data = array();
$str = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$str->bind_param('i', $_POST['id']);
$str->execute();
$result = $str->get_result();
$data[] = $result->fetch_assoc();
echo json_encode($data);