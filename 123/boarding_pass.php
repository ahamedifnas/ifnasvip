<?php
session_start();

// Include database connection
include 'db.php';

// Get booking ID from URL (e.g., ticket.php?id=5)
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $booking_id = (int) $_GET['id'];
} else {
    echo "<p>Invalid booking request. Please provide a valid booking ID.</p>";
    exit;
}

// Fetch booking details from the database
$sql = "SELECT 
            b.id AS booking_id, 
            b.name AS customer_name,
            b.flight_id, 
            b.booking_date, 
            f.flight_number, 
            f.from_location, 
            f.to_location, 
            f.departure_time, 
            f.arrival_time, 
            f.price
        FROM bookings b
        JOIN flights f ON b.flight_id = f.id
        WHERE b.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

// Handle case when booking not found
if ($result->num_rows === 0) {
    echo "<p>No booking found for the given ID.</p>";
    exit;
}

$booking = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking - Boarding Pass</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Flight Ticket / Boarding Pass -->
<section class="boarding-pass">
    <div class="boarding-pass-header">
        <h1>Decen Air</h1>
        <p>Flight Booking Confirmation</p>
    </div>

    <div class="boarding-pass-body">
        <div class="flight-details">
            <p><strong>Flight Number:</strong> <?= htmlspecialchars($booking['flight_number']) ?></p>
            <p><strong>From:</strong> <?= htmlspecialchars($booking['from_location']) ?></p>
            <p><strong>To:</strong> <?= htmlspecialchars($booking['to_location']) ?></p>
            <p><strong>Departure:</strong> <?= htmlspecialchars($booking['departure_time']) ?></p>
            <p><strong>Arrival:</strong> <?= htmlspecialchars($booking['arrival_time']) ?></p>
        </div>

        <div class="customer-details">
            <p><strong>Passenger Name:</strong> <?= htmlspecialchars($booking['customer_name']) ?></p>
            <p><strong>Booking Date:</strong> <?= htmlspecialchars($booking['booking_date']) ?></p>
            <p><strong>Price:</strong> $<?= number_format($booking['price'], 2) ?></p>
        </div>
    </div>

    <div class="boarding-pass-footer">
        <p>Thank you for choosing Decen Air!</p>
        <!-- Download Ticket Button -->
        <a href="download_ticket.php?id=<?= $booking['booking_id'] ?>" class="download-btn">Download Your Ticket</a>
    </div>
</section>

</body>
</html>
