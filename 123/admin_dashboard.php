<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect to login if not logged in
    header("Location: admin_login.php");
    exit;
}

// Include database connection
include 'db.php';

// Fetch all flight booking details from the database
$sql = "SELECT 
            f.flight_number, 
            f.from_location, 
            f.to_location, 
            f.departure_time, 
            f.arrival_time, 
            f.price, 
            b.name, 
            b.booking_date
        FROM flights f
        LEFT JOIN bookings b ON f.id = b.flight_id"; 

// Execute the query
$result = $conn->query($sql);

// Check for errors in the query execution
if (!$result) {
    die("Error executing query: " . $conn->error); // Display query error if any
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Decen Air</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Admin Dashboard Section -->
<header>
    <h1>Welcome to Decen Air Admin Dashboard</h1>
    <p>Manage your flight bookings</p>
    <a href="logout.php" class="logout-btn">Logout</a>
</header>

<!-- Flight Booking Details Section -->
<section class="flight-bookings">
    <h2>All Flight Bookings</h2>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Flight Number</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Departure</th>
                    <th>Arrival</th>
                    <th>Price</th>
                    <th>Customer Name</th>
                    <th>Booking Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['flight_number']) ?></td>
                        <td><?= htmlspecialchars($row['from_location']) ?></td>
                        <td><?= htmlspecialchars($row['to_location']) ?></td>
                        <td><?= htmlspecialchars($row['departure_time']) ?></td>
                        <td><?= htmlspecialchars($row['arrival_time']) ?></td>
                        <td>$<?= number_format($row['price'], 2) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['booking_date']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No flight bookings found.</p>
    <?php endif; ?>
</section>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
