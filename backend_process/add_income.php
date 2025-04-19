<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public_pages/login.php");
    exit();
}

include '../db_connection/db_connection.php';

$uid = $_SESSION['user_id'];
$type = $_POST['moneyType']; // 'income' or 'expense'
$amount = (float) $_POST['amount'];
$category = trim($_POST['category']);
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

    // Step 1: Get or create user_balance row
    $balanceQuery = "SELECT total_income, total_expense FROM user_balance WHERE user_id = ?";
    $stmt = $conn->prepare($balanceQuery);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $stmt->bind_result($total_income, $total_expense);
    $exists = $stmt->fetch();
    $stmt->close();

    if (!$exists) {
        // First time user: create row
        $total_income = 0;
        $total_expense = 0;
        $stmt = $conn->prepare("INSERT INTO user_balance (user_id, total_income, total_expense) VALUES (?, 0, 0)");
        $stmt->bind_param("s", $uid);
        $stmt->execute();
        $stmt->close();
    }

    $current_balance = $total_income;
    $new_balance = $type === 'income' ? $current_balance + $amount : $current_balance - $amount;

    // Safety check: avoid negative balance (optional)
    if ($type === 'expense' && $new_balance < 0) {
        throw new Exception("Not enough balance for this expense.");
    }

    // Step 2: Insert into transactions
    $transaction_id = generateTransactionId($conn);
    $stmt = $conn->prepare("INSERT INTO transactions (transaction_id, user_id, type, amount, category, timestamp, day, previous_balance, after_balance)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdsssdd", $transaction_id, $uid, $type, $amount, $category, $timestamp, $day, $current_balance, $new_balance);

    if (!$stmt->execute()) {
        throw new Exception("Transaction insert failed: " . $stmt->error);
    }
    $stmt->close();

    // Step 3: Update user_balance accordingly
    if ($type === 'income') {
        $updateBalance = $conn->prepare("UPDATE user_balance SET total_income = total_income + ? WHERE user_id = ?");
        $updateBalance->bind_param("ds", $amount, $uid);
    } else {
        $updateBalance = $conn->prepare("UPDATE user_balance SET total_income = total_income - ?, total_expense = total_expense + ? WHERE user_id = ?");
        $updateBalance->bind_param("dds", $amount, $amount, $uid);
    }

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
    error_log("Transaction failed: " . $e->getMessage());
    //to catch error
    $errorMessage = urlencode($e->getMessage());
    header("Location: ../public_pages/Transaction.php?status=error&msg=$errorMessage");
    exit();
}
?>