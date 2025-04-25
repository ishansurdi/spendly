<?php
session_start();
include __DIR__ . '/../db_connection/db_connection.php';


if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT budget_id, category, amount, created_at FROM budgets WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$budgets = [];

while ($row = $result->fetch_assoc()) {
    $budgets[] = $row;
}

header('Content-Type: application/json');
echo json_encode($budgets);
?>
