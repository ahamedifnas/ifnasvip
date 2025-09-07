<?php
session_start(); // Start the session

// Destroy all session variables and session data
session_unset();
session_destroy();

// Redirect to the login page or home page after logout
header("Location: index.php");
exit();
?>
