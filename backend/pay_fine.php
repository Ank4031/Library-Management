<?php
session_start();
require_once 'db.php';

$c = new db();
$conn = $c->get_Con();
$id = $_POST['id'];
$amount = $_POST['fine'];

$stmt = $conn->prepare("SELECT issue_id, fine FROM books_issues WHERE user_id = ? AND fine > 0 ORDER BY issue_id ASC");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $issue_id = $row['issue_id'];
    $fine = $row['fine'];

    if ($amount == 0) break;

    if ($amount >= $fine) {
        $amount -= $fine;
        $update = $conn->prepare("UPDATE books_issues SET fine = 0 WHERE issue_id = ?");
        $update->bind_param('i', $issue_id);
        $update->execute();
        $d = date("Y-m-d");
        $stmt0 = $conn->prepare("INSERT INTO fine(user_id,issue_id,amount,paid_on) values (?,?,?,?)");
        $stmt0->bind_param('iiis', $_POST['id'],$issue_id, $fine,$d);
        $stmt0->execute();
    } else {
        $new_fine = $fine - $amount;
        $amt = $amount;
        $amount = 0;
        $update = $conn->prepare("UPDATE books_issues SET fine = ? WHERE issue_id = ?");
        $update->bind_param('di', $new_fine, $issue_id);
        $update->execute();
        $d = date("Y-m-d");
        $stmt0 = $conn->prepare("INSERT INTO fine(user_id,issue_id,amount,paid_on) values (?,?,?,?)");
        $stmt0->bind_param('iiis', $_POST['id'],$issue_id, $amt,$d);
        $stmt0->execute();
    }
}

echo "fine_Updated";