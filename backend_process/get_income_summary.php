<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    echo "₹0.00";
    exit();
}

include '../db_connection/db_connection.php';

$uid = $_SESSION['user_id'];

// Just get the current available income (balance)
$sql = "SELECT total_income FROM user_balance WHERE user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $uid);
$stmt->execute();
$stmt->bind_result($total_income);
$stmt->fetch();
$stmt->close();
$conn->close();

// Default to 0 if no record found
$total_income = $total_income ?? 0.00;

echo "₹" . number_format($total_income, 2);
?>