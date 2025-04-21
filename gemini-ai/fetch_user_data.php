<?php
session_start();
include '../db_connection/db_connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Initialize empty arrays
$transactions = [];
$financial_profile = [];

// Fetch transactions
$transaction_sql = "SELECT * FROM transactions WHERE user_id = ?";
$stmt = $conn->prepare($transaction_sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $transactions[] = $row;
}
$stmt->close();

// Fetch financial profile
$profile_sql = "SELECT * FROM financial_profiles WHERE user_id = ?";
$stmt = $conn->prepare($profile_sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $financial_profile = $row;
}
$stmt->close();

// Determine eligibility from transactions
$eligible = false;
foreach ($transactions as $txn) {
    if (
        isset($txn['account_status'], $txn['purchase_plan']) &&
        strtolower($txn['account_status']) === 'active' &&
        strtolower($txn['purchase_plan']) !== 'free'
    ) {
        $eligible = true;
        break;
    }
}

// Final response
echo json_encode([
    "transactions" => $transactions,
    "financial_profile" => $financial_profile,
    "eligible" => $eligible
]);
