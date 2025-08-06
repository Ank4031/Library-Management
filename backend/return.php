<?php
session_start();
require_once 'db.php';
$c = new db();
$conn = $c->get_Con();

$str = $conn->prepare('SELECT * FROM books_issues WHERE user_id=? and book_id=?');
$str->bind_param('ii',$_POST['user_id'],$_POST['book_id']);
$str->execute();
$result = $str->get_result();
if($result->num_rows < 1){
    echo "no_Issue";
    exit();
}
$data = $result->fetch_assoc();

$return_Date = new DateTime($data['return_date']);
$actual_Return_Date = new DateTime($_POST['return_date']);

if ($actual_Return_Date>$return_Date){
    $late_Days = $actual_Return_Date->diff($return_Date)->days;
    $fine = $late_Days*10;
    $str1 = $conn->prepare('UPDATE books_issues set actual_return_date=?, fine=? where user_id=? and book_id=?');
    $str1->bind_param('siii',$_POST['return_date'], $fine, $_POST['user_id'], $_POST['book_id']);
    $str1->execute();
    echo "late_Submission";
}
else{
    $str1 = $conn->prepare('UPDATE books_issues set actual_return_date=? where user_id=? and book_id=?');
    $str1->bind_param('sii',$_POST['return_date'], $_POST['user_id'], $_POST['book_id']);
    $str1->execute();
    echo "on_Time";
}
$str2 = $conn->prepare('UPDATE books set available= available+1 where book_id=?');
$str2->bind_param('i', $_POST['book_id']);
$str2->execute();
exit();