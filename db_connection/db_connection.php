<?php
//DB CONNECTION FILE
//NOT TO BE CHANGED
include '../credentials/db_details.php';
$servername = "localhost"; // Change this to your database server
$username = "root"; // Your database username
$password = "123456789"; // Your database password
$dbname = "spendly"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    // echo "Connection Established <br>";
}
?>
