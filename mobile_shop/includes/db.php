<?php
// Database connection settings
$servername = "localhost";  // Host, usually localhost
$username = "root";         // Database username (default is 'root' for local development)
$password = "";             // Database password (default is an empty string for local development)
$dbname = "mobile_shop";    // Database name

try {
    // Create a new PDO instance for connecting to the database
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception, so any error will throw an exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // In case of an error, display the error message
    echo "Connection failed: " . $e->getMessage();
}
?>
