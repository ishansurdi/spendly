<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public_pages/login.php");
    exit();
}

include '../db_connection/db_connection.php';

$uid = $_SESSION['user_id'];
$type = $_POST['moneyType'];
$amount = (float) $_POST['amount'];
$reason = trim($_POST['source']);
$category = ""; // Left empty by design
$timestamp = date("Y-m-d H:i:s");
$day = date('l');

// Optional: Custom transaction ID generation (if not using AUTO_INCREMENT)
function generateTransactionId($conn) {
    $prefix = "TXN";
    $randomNumber = mt_rand(100000, 999999);
    $transaction_id = $prefix . $randomNumber;

    // Ensure it's unique
    $checkQuery = "SELECT COUNT(*) FROM transactions WHERE transaction_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $transaction_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    return ($count > 0) ? generateTransactionId($conn) : $transaction_id;
}

try {
    // Start transaction
    $conn->begin_transaction();

    // If you're using custom transaction ID:
    $transaction_id = generateTransactionId($conn);

    $stmt = $conn->prepare("INSERT INTO transactions (transaction_id, user_id, type, amount, reason, category, timestamp, day)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssdssss", $transaction_id, $uid, $type, $amount, $reason, $category, $timestamp, $day);



    if (!$stmt->execute()) {
        throw new Exception("Insertion failed: " . $stmt->error);
    }

    $conn->commit();
    $stmt->close();
    $conn->close();
    header("Location: ../public_pages/Transaction.php?status=success");
    exit();

} catch (Exception $e) {
    $conn->rollback();
    error_log("Transaction failed: " . $e->getMessage());
    header("Location: ../public_pages/Transaction.php?status=error");
    exit();
}
?>
