<?php
session_start();
require_once '../db_connection/db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Get total budget from budgets table
$budgetStmt = $conn->prepare("SELECT SUM(amount) AS total_budget FROM budgets WHERE user_id = ?");
$budgetStmt->bind_param("s", $user_id);
$budgetStmt->execute();
$budgetResult = $budgetStmt->get_result()->fetch_assoc();
$total_budget = floatval($budgetResult['total_budget'] ?? 0);

// Get total spent from transaction_dash where type is 'expense'
$expenseStmt = $conn->prepare("SELECT SUM(amount) AS total_spent FROM transactions_dash WHERE user_id = ? AND type = 'expense'");
$expenseStmt->bind_param("s", $user_id);
$expenseStmt->execute();
$expenseResult = $expenseStmt->get_result()->fetch_assoc();
$total_spent = floatval($expenseResult['total_spent'] ?? 0);

// Calculate remaining budget
$remaining = $total_budget - $total_spent;

// Return data as JSON
echo json_encode([
    'status' => 'success',
    'total_budget' => $total_budget,
    'spent' => $total_spent,
    'remaining' => $remaining
]);
?>
