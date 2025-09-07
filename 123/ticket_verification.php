<?php
session_start();
include 'db.php'; // Include the database connection

// Initialize variables
$passportNumber = '';
$tickets = [];
$errorMessage = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $passportNumber = trim($_POST['passport_number']);

    if (!empty($passportNumber)) {
        // Query to fetch tickets and join flights table for details
        $sql = "SELECT b.id AS booking_id, b.name AS passenger_name, b.booking_date, b.price,
                       f.flight_number, f.from_location, f.to_location, f.departure_time, f.arrival_time
                FROM bookings b
                JOIN flights f ON b.flight_id = f.id
                WHERE b.passport = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $passportNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tickets[] = $row;
            }
        } else {
            $errorMessage = "No tickets found for this passport number.";
        }

        $stmt->close();
    } else {
        $errorMessage = "Please enter a valid passport number.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Verification - Decen Air</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .error { color: red; margin-top: 10px; }
        ul { list-style-type: none; padding: 0; }
        li { background: #f4f4f4; margin: 15px 0; padding: 15px; border-radius: 8px; }
    </style>
</head>
<body>

<header>
    <h1>Ticket Verification</h1>
</header>

<section class="ticket-verification-form">
    <h2>Enter Your Passport Number to View Your Ticket(s)</h2>
    <form method="POST" action="">
        <input type="text" name="passport_number" placeholder="Enter Passport Number" value="<?= htmlspecialchars($passportNumber) ?>" required>
        <button type="submit">Check Tickets</button>
    </form>

    <?php if (!empty($errorMessage)): ?>
        <p class="error"><?= htmlspecialchars($errorMessage) ?></p>
    <?php endif; ?>

    <?php if (!empty($tickets)): ?>
        <h3>Your Booked Tickets</h3>
        <ul>
            <?php foreach ($tickets as $ticket): ?>
                <li>
                    <p><strong>Flight Number:</strong> <?= htmlspecialchars($ticket['flight_number']) ?></p>
                    <p><strong>From:</strong> <?= htmlspecialchars($ticket['from_location']) ?></p>
                    <p><strong>To:</strong> <?= htmlspecialchars($ticket['to_location']) ?></p>
                    <p><strong>Departure:</strong> <?= htmlspecialchars($ticket['departure_time']) ?></p>
                    <p><strong>Arrival:</strong> <?= htmlspecialchars($ticket['arrival_time']) ?></p>
                    <p><strong>Passenger Name:</strong> <?= htmlspecialchars($ticket['passenger_name']) ?></p>
                    <p><strong>Booking Date:</strong> <?= htmlspecialchars($ticket['booking_date']) ?></p>
                    <p><strong>Price:</strong> $<?= number_format($ticket['price'], 2) ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>

<footer>
    <p>&copy; 2024 Decen Air. All rights reserved.</p>
</footer>

</body>
</html>

<?php
$conn->close();
?>
