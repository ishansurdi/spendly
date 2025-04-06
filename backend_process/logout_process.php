<?php
session_start();
session_unset();
session_destroy();
header("Location: ../public_pages/login.php"); // Adjust the path if needed
exit();
?>
