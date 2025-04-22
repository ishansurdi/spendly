<?php
session_start();
require_once '../db_connection/db_connection.php';

// Check if user is logged in (user_id in session)
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in or sign up first.");
}
$user_id = $_SESSION['user_id'];

// Check if the user's current plan has expired and update the account status to 'Invalid' if needed
$update_expired = $conn->prepare("
    UPDATE transactions 
    SET account_status = 'Invalid' 
    WHERE user_id = ? 
    AND account_status = 'Active' 
    AND end_of_plan < CURDATE()
");
$update_expired->bind_param("s", $user_id);
$update_expired->execute();
$update_expired->close();


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

        // Prevent multiple active paid plans
        if ($plan !== 'Free') {
            $check_active_query = $conn->prepare("
                SELECT * FROM transactions 
                WHERE user_id = ? 
                AND account_status = 'Active' 
                AND end_of_plan >= CURDATE() 
                AND purchase_plan != 'Free'
                LIMIT 1
            ");
            $check_active_query->bind_param("s", $user_id);
            $check_active_query->execute();
            $result = $check_active_query->get_result();
    
            if ($result->num_rows > 0) {
                echo '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                  <meta charset="UTF-8">
                  <title>Plan Already Active</title>
                  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
                </head>
                <body class="bg-gray-50 flex items-center justify-center min-h-screen px-4">
                  <div class="max-w-lg w-full bg-white shadow-xl rounded-2xl p-8 border border-gray-200 text-center">
                    <div class="text-yellow-500 text-4xl mb-4">⚠️</div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Plan Still Active</h2>
                    <p class="text-gray-600 text-sm">You already have an active paid plan. Please wait until it ends before purchasing a new one.</p>
                    <div class="mt-6">
                      <a href="../public_pages/payment.php" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg shadow hover:bg-indigo-700 transition">Back to Payment</a>
                    </div>
                  </div>
                </body>
                </html>
                ';
                exit;
            }
        }
    

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

    $remarks = ''; // Default remarks

    // Fetch user's last plan details to check conditions
    // Fetch user's last plan details to check conditions
$result = $conn->query("SELECT * FROM transactions WHERE user_id = '$user_id' ORDER BY start_of_plan DESC LIMIT 1");
if ($result->num_rows > 0) {
    $last_transaction = $result->fetch_assoc();
    $last_end_date = $last_transaction['end_of_plan'];
    $last_plan = $last_transaction['purchase_plan'];

    // If previous plan is "Free" and current plan is not "Free", set the start date to the current date
    if ($last_plan === 'Free' && $plan !== 'Free') {
        // Set start date to current date
        $start_of_plan = date("Y-m-d");
        $end_of_plan = date("Y-m-d", strtotime("+30 days"));
        $remarks = 'Previous Free plan account status changed to Inactive due to upgrade. New plan start date set to today.';
        $conn->query("UPDATE transactions SET account_status = 'Invalid' WHERE transaction_id = '{$last_transaction['transaction_id']}'");
    } else {
        // Ensure new transaction starts after the previous plan ends
        if ($last_end_date > $start_of_plan) {
            $start_of_plan = date("Y-m-d", strtotime($last_end_date . " +1 day"));
            $end_of_plan = date("Y-m-d", strtotime($start_of_plan . " +30 days"));
            $remarks .= ' Transaction start date adjusted due to previous plan end date.';
        }
    }
} else {
    $remarks = 'No previous plan found. Starting from scratch.';
}


    // Insert transaction
    $stmt = $conn->prepare("INSERT INTO transactions 
    (transaction_id, user_id, purchase_amount, purchase_plan, transaction_type, payment_method, upi_id, masked_card_number, status, payment_ref_number, start_of_plan, end_of_plan, account_status, is_recurring, ip_address, device_info, remarks)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");


$stmt->bind_param("ssdssssssssssisss", $transaction_id, $user_id, $amount, $plan, $transaction_type, $payment_method, $upi_id, $masked_card, $status, $payment_ref_number, $start_of_plan, $end_of_plan, $account_status, $is_recurring, $ip_address, $device_info, $remarks);


    if ($stmt->execute()) {
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <title>Payment Confirmation | Spendly</title>
          <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        </head>
        <body class="bg-gray-50 flex items-center justify-center min-h-screen px-4">
          <div class="max-w-xl w-full bg-white shadow-xl rounded-2xl p-8 border border-gray-200">
            <div class="text-center space-y-4">
              <div class="text-green-600 text-4xl">✅</div>
              <h2 class="text-2xl font-bold text-gray-800">Payment Successful</h2>
              <p class="text-gray-600">Thank you for upgrading your plan. Below are your transaction details:</p>
            </div>
    
            <div class="mt-6 space-y-2 text-sm text-gray-700">
              <p><span class="font-semibold">User ID:</span> ' . htmlspecialchars($user_id) . '</p>
              <p><span class="font-semibold">Transaction ID:</span> ' . htmlspecialchars($transaction_id) . '</p>
              <p><span class="font-semibold">Plan:</span> ' . htmlspecialchars($plan) . '</p>
              <p><span class="font-semibold">Amount:</span> ₹' . htmlspecialchars($amount) . '</p>
              <p><span class="font-semibold">Status:</span> ' . htmlspecialchars($status) . '</p>
              <p><span class="font-semibold">Plan Start:</span> ' . htmlspecialchars($start_of_plan) . '</p>
              <p><span class="font-semibold">Plan End:</span> ' . htmlspecialchars($end_of_plan) . '</p>
              <p><span class="font-semibold">Remarks:</span> ' . htmlspecialchars($remarks) . '</p>
            </div>
    
            <div class="mt-8 text-center">
              <a href="../public_pages/login.php" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg shadow hover:bg-indigo-700 transition">Go to Login</a>
            </div>
          </div>
        </body>
        </html>
        ';
    } else {
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <title>Payment Failed | Spendly</title>
          <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        </head>
        <body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">
          <div class="bg-white border border-red-200 rounded-2xl shadow p-8 max-w-lg text-center">
            <div class="text-red-600 text-4xl">❌</div>
            <h2 class="text-xl font-bold text-red-700 mt-4">Payment Failed</h2>
            <p class="text-sm text-gray-600 mt-2 mb-4">There was an issue processing your payment.</p>
            <p class="text-xs text-gray-500 italic">Error Details: ' . htmlspecialchars($stmt->error) . '</p>
            <a href="../public_pages/payment.php" class="mt-6 inline-block text-indigo-600 hover:underline">← Try Again</a>
          </div>
        </body>
        </html>
        ';
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
