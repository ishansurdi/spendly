<?php
session_start();
include '../db_connection/db_connection.php';

// Function to decrypt password securely
function decrypt_password($encrypted_password, $encryption_key) {
    $key = hex2bin($encryption_key); // Convert hex key to binary
    $iv = substr(hash('sha256', $key), 0, 16); // Generate IV (16 bytes)
    return openssl_decrypt($encrypted_password, 'AES-256-CBC', $key, 0, $iv);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate inputs
    if (empty($email) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Please enter both email and password."]);
        exit;
    }

    // Prepare query to fetch user details
    $stmt = $conn->prepare("SELECT user_id, userpassword, enkey, user_name, user_email FROM sign_up WHERE user_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "User not found. Please check your email."]);
        exit;
    }

    // Fetch user data
    $stmt->bind_result($uid, $encrypted_password, $user_encryption_key, $user_name, $user_email);
    $stmt->fetch();
    $stmt->close();

    // Decrypt and verify password
    $decrypted_password = decrypt_password($encrypted_password, $user_encryption_key);
    
    if ($password === $decrypted_password) {
        // Check initial_data_entry status
        $stmt2 = $conn->prepare("SELECT intial_data_entry FROM login_details WHERE user_id = ?");
        $stmt2->bind_param("s", $uid);
        $stmt2->execute();
        $stmt2->bind_result($initial_data_entry);
        $stmt2->fetch();
        $stmt2->close();

        // Set session variables
        $_SESSION['user_id'] = $uid;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $user_name;

        if ($initial_data_entry === 'No') {
            echo json_encode(["status" => "redirect", "location" => "questions.php"]);
        } else {
            echo json_encode(["status" => "success", "message" => "Login successful! Redirecting..."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Incorrect password. Please try again."]);
    }

    $conn->close();
}
?>
