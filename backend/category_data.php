<?php
session_start();

require_once "db.php";

$data = array();
$c = new db();
$conn = $c->get_Con();

$str = $conn->prepare("SELECT * FROM category");
if ($str->execute()){
    $data[] = ['error'=>"False"];
    $result = $str->get_result();
    while ($row=$result->fetch_assoc()){
        $data[] = $row;
    }
    echo json_encode($data);
    exit();
    
}else{
    $data[] = ['error'=>"True"];
    echo json_encode($data);
    exit();
}

