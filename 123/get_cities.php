<?php
// Database credentials
$host = 'localhost'; // Database host
$dbname = 'flight_bookings'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password (for XAMPP it's usually empty)

header('Content-Type: application/json; charset=utf-8'); // Ensure JSON response

try {
    // Create a new PDO instance with UTF-8 support
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exception mode

    // Query to fetch city names
    $sql = "SELECT city_name FROM cities ORDER BY city_name ASC";
    $stmt = $conn->query($sql);

    // Fetch all city names in one line
    $cities = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Return the cities as JSON
    echo json_encode([
        'status' => 'success',
        'cities' => $cities
    ], JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    // Return error message as JSON
    echo json_encode([
        'status' => 'error',
        'message' => 'Database connection failed: ' . $e->getMessage()
    ]);
}
