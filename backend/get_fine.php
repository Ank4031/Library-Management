<?php
session_start();

require_once 'db.php';
$data= array();
$c = new db();
$conn = $c->get_Con();

$str = $conn->prepare('SELECT user_id, issue_id, fine from books_issues where user_id = ? and fine>0');
$str->bind_param('i',$_POST['id']);
$str->execute();
$result = $str->get_result();
if ($result->num_rows <1){
    $data[] = ['error'=>'no_Fine'];
    echo json_encode($data);
    exit();
}
$data[] = ['error'=>'fine'];
while($row = $result->fetch_assoc()){
    $data[] = $row;
}
echo json_encode($data);
exit();
