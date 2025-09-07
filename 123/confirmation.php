<?php
session_start();
include 'db.php';

// Get the booking ID from URL (e.g., process_booking.php?booking_id=3)
$booking_id = $_GET['booking_id'] ?? null;

if ($booking_id && is_numeric($booking_id)) {
    // Fetch booking + flight details
    $sql = "SELECT 
                b.id AS booking_id,
                b.name,
                b.email,
                b.phone,
                b.passport,
                b.payment_method,
                f.flight_number
            FROM bookings b
            JOIN flights f ON b.flight_id = f.id
            WHERE b.id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();

    if ($booking) {
        echo "<h2>Booking Confirmation</h2>";
        echo "<p><strong>Flight Number:</strong> " . htmlspecialchars($booking['flight_number']) . "</p>";
        echo "<p><strong>Name:</strong> " . htmlspecialchars($booking['name']) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($booking['email']) . "</p>";
        echo "<p><strong>Phone:</strong> " . htmlspecialchars($booking['phone']) . "</p>";
        echo "<p><strong>Passport:</strong> " . htmlspecialchars($booking['passport']) . "</p>";
        echo "<p><strong>Payment Method:</strong> " . htmlspecialchars($booking['payment_method']) . "</p>";
        echo "<p><a href='index.php'>Back to Home</a></p>";
    } else {
        echo "<p>Booking not found!</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<p>Invalid booking request.</p>";
}
?>
