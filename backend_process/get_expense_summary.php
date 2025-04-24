<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user_id'])) {
    // If user is not logged in, return 0 or handle accordingly
    echo "₹0.00";
    exit();
}

include '../db_connection/db_connection.php';

$uid = $_SESSION['user_id'];

$sql = "SELECT SUM(amount) AS total_expenses 
        FROM transactions_dash 
        WHERE user_id = ? 
        AND type = 'expense' 
        AND MONTH(timestamp) = MONTH(CURRENT_DATE()) 
        AND YEAR(timestamp) = YEAR(CURRENT_DATE())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $uid);
$stmt->execute();
$stmt->bind_result($total_expenses);
$stmt->fetch();
$stmt->close();
$conn->close();

// If no expenses found, default to 0.00
$total_expenses = $total_expenses ?? 0.00;

echo "₹" . number_format($total_expenses, 2);
?>