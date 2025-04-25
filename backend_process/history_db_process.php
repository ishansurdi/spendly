<?php
session_start();
include '../db_connection/db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT transaction_id, type, amount, category, timestamp, previous_balance, after_balance 
        FROM transactions_dash 
        WHERE user_id = ?";
        
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$transactions = [];

while ($row = $result->fetch_assoc()) {
    $transactions[] = $row;
}

echo json_encode($transactions);
?>
