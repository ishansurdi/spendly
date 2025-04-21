<?php
session_start();
require_once '../db_connection/db_connection.php';

// Check if user is logged in (user_id in session)
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in or sign up first.");
}
$user_id = $_SESSION['user_id'];

// Utility functions
function generateTransactionId() {
    return 'TXN' . strtoupper(uniqid());
}

function sanitize($conn, $data) {
    return mysqli_real_escape_string($conn, trim($data));
}

function maskCard($card) {
    return str_repeat('*', strlen($card) - 4) . substr($card, -4);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize inputs
    $plan = sanitize($conn, $_POST['purchase_plan']);
    $amount = sanitize($conn, $_POST['purchase_amount']);
    $upi_id = !empty($_POST['upi_id']) ? sanitize($conn, $_POST['upi_id']) : null;
    $debit_card = !empty($_POST['debit_card']) ? sanitize($conn, $_POST['debit_card']) : null;
    $cvv = !empty($_POST['cvv']) ? sanitize($conn, $_POST['cvv']) : null;

    $payment_method = '';
    $masked_card = null;

    if (!empty($upi_id)) {
        $payment_method = 'UPI';
    } elseif (!empty($debit_card) && !empty($cvv)) {
        $payment_method = 'Card';
        $masked_card = maskCard($debit_card);
    } else {
        die("Please enter valid UPI or Card details.");
    }

    // Generate details
    $transaction_id = generateTransactionId();
    $status = 'Success'; // Simulate always success for now
    $payment_ref_number = 'REF' . rand(10000000, 99999999);
    $start_of_plan = date("Y-m-d");
    $end_of_plan = date("Y-m-d", strtotime("+30 days"));
    $account_status = 'Active';
    $transaction_type = 'Purchase';
    $is_recurring = false;
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $device_info = $_SERVER['HTTP_USER_AGENT'];

    // Insert transaction
    $stmt = $conn->prepare("INSERT INTO transactions 
        (transaction_id, user_id, purchase_amount, purchase_plan, transaction_type, payment_method, upi_id, masked_card_number, status, payment_ref_number, start_of_plan, end_of_plan, account_status, is_recurring, ip_address, device_info)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssdssssssssssiss", $transaction_id, $user_id, $amount, $plan, $transaction_type, $payment_method, $upi_id, $masked_card, $status, $payment_ref_number, $start_of_plan, $end_of_plan, $account_status, $is_recurring, $ip_address, $device_info);

    if ($stmt->execute()) {
        echo "<h2>✅ Payment Successful</h2>";
        echo "<p><strong> User ID: $user_id</strong></p>";
        echo "<p><strong>Transaction ID:</strong> $transaction_id</p>";
        echo "<p><strong>Plan:</strong> $plan</p>";
        echo "<p><strong>Amount:</strong> ₹$amount</p>";
        echo "<p><strong>Status:</strong> $status</p>";
        echo "<p><strong>Start:</strong> $start_of_plan</p>";
        echo "<p><strong>End:</strong> $end_of_plan</p>";
        echo "<a href='../public_pages/login.php'>← Login</a>";
    } else {
        echo "<h2>❌ Payment Failed</h2>";
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
