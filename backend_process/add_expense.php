<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public_pages/login.php");
    exit();
}

include '../db_connection/db_connection.php';

$uid = $_SESSION['user_id'];
$amount = (float) $_POST['amount'];
$category = trim($_POST['category']);
$type = 'expense';
$timestamp = date("Y-m-d H:i:s");
$day = date('l');

function generateTransactionId($conn) {
    $prefix = "TXN";
    $randomNumber = mt_rand(100000, 999999);
    $transaction_id = $prefix . $randomNumber;
    $count = 0;

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
    $conn->begin_transaction();

    // Step 1: Fetch or create user balance record
    $balanceQuery = "SELECT total_income, total_expense FROM user_balance WHERE user_id = ?";
    $stmt = $conn->prepare($balanceQuery);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $stmt->bind_result($total_income, $total_expense);
    $exists = $stmt->fetch();
    $stmt->close();

    if (!$exists) {
        $total_income = 0;
        $total_expense = 0;
        $stmt = $conn->prepare("INSERT INTO user_balance (user_id, total_income, total_expense) VALUES (?, 0, 0)");
        $stmt->bind_param("s", $uid);
        $stmt->execute();
        $stmt->close();
    }

    $current_balance = $total_income - $total_expense;

    if ($amount > $current_balance) {
        throw new Exception("Insufficient balance for this expense.");
    }

    $new_balance = $current_balance - $amount;

    // Step 2: Insert transaction
    $transaction_id = generateTransactionId($conn);
    $stmt = $conn->prepare("INSERT INTO transactions (transaction_id, user_id, type, amount, category, timestamp, day, previous_balance, after_balance)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdsssdd", $transaction_id, $uid, $type, $amount, $category, $timestamp, $day, $current_balance, $new_balance);

    if (!$stmt->execute()) {
        throw new Exception("Transaction insert failed: " . $stmt->error);
    }
    $stmt->close();

    // Step 3: Update user_balance
    $updateBalance = $conn->prepare("UPDATE user_balance SET total_expense = total_expense + ? WHERE user_id = ?");
    $updateBalance->bind_param("ds", $amount, $uid);

    if (!$updateBalance->execute()) {
        throw new Exception("Balance update failed: " . $updateBalance->error);
    }
    $updateBalance->close();

    $conn->commit();
    $conn->close();
    header("Location: ../public_pages/Transaction.php?status=success");
    exit();

} catch (Exception $e) {
    $conn->rollback();
    error_log("Expense failed: " . $e->getMessage());
    $errorMessage = urlencode($e->getMessage());
    header("Location: ../public_pages/Transaction.php?status=error&msg=$errorMessage");
    exit();
}
?>
