<?php
session_start();

// Include database connection
include 'db.php';

// Initialize variables
$passport = '';
$booking_id = null;
$error_message = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the passport number from the form input
    $passport = isset($_POST['passport']) ? trim($_POST['passport']) : '';

    // Validate passport (you can add further validation here)
    if (!empty($passport)) {
        // Query the database to find the booking associated with the passport
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
                WHERE b.passport = ?";  // Querying using 'passport' column

        // Prepare and execute the query
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $passport);  // "s" means string type for passport
            $stmt->execute();
            $result = $stmt->get_result();

            // If no booking is found, show an error message
            if ($result->num_rows == 0) {
                $error_message = 'No booking found for the provided passport number.';
            } else {
                // Fetch booking details
                $booking = $result->fetch_assoc();
                $booking_id = $booking['booking_id'];
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            // Query preparation failed
            $error_message = 'There was an issue processing your request. Please try again later.';
        }
    } else {
        $error_message = 'Please enter a valid passport number.';
    }
}
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

<!-- Passport number entry form -->
<section class="passport-check">
    <div class="passport-check-header">
        <h1>Decen Air</h1>
        <p>Please enter your passport number to view your booking details:</p>
    </div>

    <div class="passport-check-body">
        <?php if ($error_message): ?>
            <p class="error-message"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>
        
        <form method="POST" action="">
            <label for="passport">Passport Number:</label>
            <input type="text" name="passport" id="passport" value="<?= htmlspecialchars($passport) ?>" required>
            <button type="submit">Check Booking</button>
        </form>
    </div>
</section>

<!-- Flight Ticket / Boarding Pass section (only show if booking is found) -->
<?php if ($booking_id !== null): ?>
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
<?php endif; ?>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
