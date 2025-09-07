<?php
session_start();
include 'db.php'; // Include the database connection

// Get search parameters (if set) and check if they're not empty
$from = isset($_GET['from']) ? $_GET['from'] : '';
$to   = isset($_GET['to'])   ? $_GET['to']   : '';

// Fetch distinct locations from the database (from_location and to_location)
$locationsQuery = "SELECT DISTINCT from_location AS location FROM flights 
                   UNION 
                   SELECT DISTINCT to_location AS location FROM flights";
$locationsResult = $conn->query($locationsQuery);

// Convert locations into an array
$locations = [];
if ($locationsResult && $locationsResult->num_rows > 0) {
    while ($row = $locationsResult->fetch_assoc()) {
        $locations[] = $row['location'];
    }
}

// Fetch flights based on search criteria (from and to locations)
if (!empty($from) && !empty($to)) {
    $sql = "SELECT * FROM flights WHERE from_location LIKE ? AND to_location LIKE ?";
    $stmt = $conn->prepare($sql);

    $searchFrom = "%$from%";  // Wildcard search for 'from' location
    $searchTo   = "%$to%";    // Wildcard search for 'to' location

    $stmt->bind_param("ss", $searchFrom, $searchTo);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // If no search criteria, show all flights
    $result = $conn->query("SELECT * FROM flights");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decen Air - Flight Booking</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Header Section -->
<header>
    <h1>Welcome to Decen Air</h1>

    <div class="header-buttons">
        <!-- Admin Login Button -->
        <a href="process_booking.php" class="admin-login-btn">Download Your Tickets</a>

        <!-- Download Your Ticket Button (only if booking_id is set) -->
        <?php if (isset($_SESSION['booking_id'])): ?>
            <a href="ticket_verification.php" class="download-ticket-header">Download Your Ticket</a>
        <?php endif; ?>
    </div>
</header>

<section class="admin-login-section">
    <a href="admin_login.php" class="admin-login-btn">Admin Login</a>
</section>

<!-- Search Form -->
<section class="search-form">
    <h2>Find Your Flight</h2>
    <form action="index.php" method="GET">
        <!-- From Location Dropdown -->
        <select name="from" required>
            <option value="" disabled <?= empty($from) ? 'selected' : '' ?>>From Location</option>
            <?php foreach ($locations as $location): ?>
                <option value="<?= htmlspecialchars($location) ?>" <?= $from == $location ? 'selected' : '' ?>>
                    <?= htmlspecialchars($location) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- To Location Dropdown -->
        <select name="to" required>
            <option value="" disabled <?= empty($to) ? 'selected' : '' ?>>To Location</option>
            <?php foreach ($locations as $location): ?>
                <option value="<?= htmlspecialchars($location) ?>" <?= $to == $location ? 'selected' : '' ?>>
                    <?= htmlspecialchars($location) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Search Flights</button>
    </form>
</section>

<!-- Flight Results -->
<section class="flight-results">
    <h2>Available Flights</h2>
    <?php if ($result && $result->num_rows > 0): ?>
        <div class="flight-cards">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="flight-card">
                    <div class="boarding-pass">
                        <div class="flight-header">
                            <h3>Flight Number: <?= htmlspecialchars($row['flight_number']) ?></h3>
                        </div>
                        <div class="flight-details">
                            <div class="flight-route">
                                <p><strong>From:</strong> <?= htmlspecialchars($row['from_location']) ?></p>
                                <p><strong>To:</strong> <?= htmlspecialchars($row['to_location']) ?></p>
                            </div>
                            <div class="flight-times">
                                <p><strong>Departure:</strong> <?= htmlspecialchars($row['departure_time']) ?></p>
                                <p><strong>Arrival:</strong> <?= htmlspecialchars($row['arrival_time']) ?></p>
                            </div>
                            <div class="flight-price">
                                <p><strong>Price:</strong> $<?= number_format($row['price'], 2) ?></p>
                            </div>
                            <!-- Book Now Button -->
                            <a href="book.php?flight_id=<?= $row['id'] ?>" class="book-now">Book Now</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No flights found for your search. Please try again with different locations.</p>
    <?php endif; ?>
</section>

<!-- Footer Section -->
<footer>
    <p>&copy; 2024 Decen Air. All rights reserved.</p>
    <?php if (isset($_SESSION['booking_id'])): ?>
        <a href="ticket_verification.php" class="download-ticket-footer">Download Your Ticket</a>
    <?php endif; ?>
</footer>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
