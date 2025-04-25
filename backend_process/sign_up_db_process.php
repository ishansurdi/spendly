<?php
session_start();
include '../db_connection/db_connection.php';

// Function to generate a random user ID
function generate_random_uid($length = 15) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function generate_user_encryption_key() {
    return bin2hex(random_bytes(32)); // 64-character hex string (256-bit key)
}

// Function to encrypt password securely
function encrypt_password($password, $encryption_key) {
    $key = hex2bin($encryption_key); // Convert hex to binary
    $iv = substr(hash('sha256', $key), 0, 16); // Ensure IV is exactly 16 bytes
    return openssl_encrypt($password, 'AES-256-CBC', $key, 0, $iv);
}

// Function to insert user data into the database with transaction rollback on failure
function submit_data_to_db($conn, $name, $email, $password) {
    $check_stmt = $conn->prepare("SELECT user_email FROM sign_up WHERE user_email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $_SESSION['error'] = "This email is already registered!";
        $check_stmt->close();
        header("Location: ../public_pages/sign-up.php");
        exit();
    }
    $check_stmt->close();
    
    $uid = generate_random_uid();
    $user_encryption_key = generate_user_encryption_key();
    $encrypted_password = encrypt_password($password, $user_encryption_key);
    $creation_day = date('l');

    // Start database transaction
    $conn->begin_transaction();

    try {
        // Insert into sign_up table
        $stmt = $conn->prepare("INSERT INTO sign_up (user_name, user_email, user_id, userpassword, enkey, creation_day) 
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $uid, $encrypted_password, $user_encryption_key, $creation_day);

        if (!$stmt->execute()) {
            throw new Exception("Database Insert Failed (sign_up): " . $stmt->error);
        }

        // Insert into user_login_data table
        $login_day = $creation_day;
        $stmt_login = $conn->prepare("INSERT INTO login_details (user_id, login_count, intial_data_entry, last_login_day)
                                      VALUES (?, 0, 'No', ?)");
        $stmt_login->bind_param("ss", $uid, $login_day);

        if (!$stmt_login->execute()) {
            throw new Exception("Database Insert Failed (user_login_data): " . $stmt_login->error);
        }

        // Send welcome email via Python
        $pythonScript = escapeshellcmd("python ../email_with_python/email_sender.py") . 
                        " " . escapeshellarg($email) . 
                        " " . escapeshellarg($name) . 
                        " " . escapeshellarg($uid);
        $output = shell_exec($pythonScript . " 2>&1"); // Capture stderr
        error_log("Python Output: " . $output);

        // Commit transaction
        $conn->commit();
        $_SESSION['success'] = "Account for $name created with user ID $uid. Redirecting to payment page...";
        $_SESSION['redirect_to_payment'] = true;
        $_SESSION['user_id'] = $uid;
        header("Location: ../public_pages/sign-up.php");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error'] = "Error: " . $e->getMessage();
        error_log("Sign-Up Error: " . $e->getMessage());
        return false;

    } finally {
        if (isset($stmt) && $stmt instanceof mysqli_stmt) {
            $stmt->close();
        }
        if (isset($stmt_login) && $stmt_login instanceof mysqli_stmt) {
            $stmt_login->close();
        }
        $conn->close();
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate inputs
    if (empty($name) || empty($email) || empty($password)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: ../public_pages/sign-up.php");
        exit();
    }

    // Call function to register user
    submit_data_to_db($conn, $name, $email, $password);
    // header("Location: ../public_pages/sign-up.php");
    // exit();
}
?>