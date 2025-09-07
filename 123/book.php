<?php
// Include the database connection and start session
session_start();
include 'db.php';

// Check if a flight ID is passed in the URL
if (isset($_GET['flight_id'])) {
    $flight_id = $_GET['flight_id'];

    // Fetch the flight details from the database
    $sql = "SELECT * FROM flights WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $flight_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $flight = $result->fetch_assoc();

    // If no flight found, redirect back
    if (!$flight) {
        header("Location: index.php");
        exit;
    }
} else {
    // If no flight is selected, redirect back to the main page
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decen Air - Book Your Flight</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Header Section -->
<header>
    <h1>Decen Air - Flight Booking</h1>
    <p>Complete your booking and get ready for your journey!</p>
</header>

<!-- Flight Details Section -->
<section class="flight-details">
    <h2>Your Selected Flight</h2>
    <div class="flight-info">
        <p><strong>Flight Number:</strong> <?= htmlspecialchars($flight['flight_number']) ?></p>
        <p><strong>From:</strong> <?= htmlspecialchars($flight['from_location']) ?></p>
        <p><strong>To:</strong> <?= htmlspecialchars($flight['to_location']) ?></p>
        <p><strong>Departure:</strong> <?= htmlspecialchars($flight['departure_time']) ?></p>
        <p><strong>Arrival:</strong> <?= htmlspecialchars($flight['arrival_time']) ?></p>
        <p><strong>Price:</strong> $<?= number_format($flight['price'], 2) ?></p>
    </div>
</section>

<!-- Booking Form Section -->
<section class="booking-form">
    <h2>Complete Your Booking</h2>
    <form action="process_booking.php" method="POST">
        <input type="hidden" name="flight_id" value="<?= $flight['id'] ?>"> <!-- Store flight_id -->

        <!-- Personal Details -->
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required placeholder="Enter your full name">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required placeholder="Enter your email address">

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" required placeholder="Enter your phone number">

        <label for="passport">Passport Number:</label>
        <input type="text" id="passport" name="passport" required placeholder="Enter your passport number">

        <!-- Payment Details -->
        <label for="payment">Payment Method:</label>
        <select name="payment_method" id="payment" required>
            <option value="" disabled selected>Select Payment Method</option>
            <option value="credit_card">Credit Card</option>
            <option value="paypal">PayPal</option>
            <option value="bank_transfer">Bank Transfer</option>
        </select>

        <!-- Submit Button -->
        <button type="submit">Confirm Booking</button>
    </form>
</section>

<!-- Footer Section -->
<footer>
    <p>&copy; 2024 Decen Air. All rights reserved.</p>
</footer>

</body>
</html>
