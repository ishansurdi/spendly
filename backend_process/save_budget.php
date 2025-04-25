<?php
session_start();
require_once '../db_connection/db_connection.php';

header('Content-Type: application/json'); // Ensure JSON content-type

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch and sanitize POST data
$amount = isset($_POST['budgetAmount']) ? floatval($_POST['budgetAmount']) : 0;
$category = isset($_POST['budgetCategory']) ? trim($_POST['budgetCategory']) : '';

if ($amount <= 0 || empty($category)) {
    echo json_encode(['status' => 'error', 'message' => 'Please fill out all fields correctly.']);
    exit;
}

// Function to generate unique budget_id with a random number and prefix
function generateBudgetId($conn) {
    $prefix = "BUDGET";  // Prefix for the budget_id
    $randomNumber = mt_rand(100000, 999999);  // Generate a random number
    $budget_id = $prefix . $randomNumber;

    // Ensure the generated ID is unique by checking the database
    $checkQuery = "SELECT budget_id FROM budgets WHERE budget_id = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $budget_id);
    $checkStmt->execute();
    $checkStmt->store_result();

    // If the ID already exists, regenerate it
    while ($checkStmt->num_rows > 0) {
        $randomNumber = mt_rand(100000, 999999);  // Generate a new random number
        $budget_id = $prefix . $randomNumber;     // Create a new budget_id
        $checkStmt->execute();  // Re-check the new ID for uniqueness
    }

    return $budget_id;
}

// Check if a budget already exists for the same category
$checkQuery = "SELECT budget_id FROM budgets WHERE user_id = ? AND category = ?";
$checkStmt = $conn->prepare($checkQuery);
$checkStmt->bind_param("ss", $user_id, $category);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    // Update existing record
    $checkStmt->bind_result($budget_id);
    $checkStmt->fetch();
    $update = $conn->prepare("UPDATE budgets SET amount = ? WHERE budget_id = ?");
    $update->bind_param("ds", $amount, $budget_id);
    $update->execute();
    $update->close();  // Close the update statement
} else {
    // Generate unique budget_id
    $budget_id = generateBudgetId($conn);

    // Insert new record with the unique budget_id
    $insert = $conn->prepare("INSERT INTO budgets (budget_id, user_id, category, amount) VALUES (?, ?, ?, ?)");
    $insert->bind_param("ssss", $budget_id, $user_id, $category, $amount);
    $insert->execute();
    
    // Check for errors in the insert operation
    if ($insert === false) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to insert budget.']);
        exit;
    }
    $insert->close(); // Close the insert statement
}

echo json_encode(['status' => 'success', 'message' => 'Budget updated successfully.']);

?>
