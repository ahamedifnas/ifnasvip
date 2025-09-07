<?php
session_start();

// Include database connection
include 'db.php';

// Include TCPDF library (adjust path if necessary)
require_once('tcpdf/tcpdf.php');

// Check if the 'id' parameter is passed in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: error.php");
    exit;
}

// Get the 'id' from the URL
$booking_id = (int) $_GET['id'];

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

// If booking doesn't exist, redirect to error page
if ($result->num_rows === 0) {
    header("Location: error.php");
    exit;
}

// Fetch booking details
$booking = $result->fetch_assoc();

$stmt->close();
$conn->close();

// Escape values safely before output
$flight_number   = htmlspecialchars($booking['flight_number']);
$from_location   = htmlspecialchars($booking['from_location']);
$to_location     = htmlspecialchars($booking['to_location']);
$departure_time  = htmlspecialchars($booking['departure_time']);
$arrival_time    = htmlspecialchars($booking['arrival_time']);
$customer_name   = htmlspecialchars($booking['customer_name']);
$booking_date    = htmlspecialchars($booking['booking_date']);
$price           = number_format($booking['price'], 2);

// Create new TCPDF instance
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Decen Air');
$pdf->SetTitle('Boarding Pass');
$pdf->SetSubject('Flight Ticket');

// Set margins
$pdf->SetMargins(15, 15, 15);
$pdf->SetAutoPageBreak(true, 15);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Build HTML content
$html = <<<EOD
    <h1 style="text-align:center;">Decen Air - Flight Ticket</h1>
    <h3>Flight Details</h3>
    <p><strong>Flight Number:</strong> {$flight_number}</p>
    <p><strong>From:</strong> {$from_location}</p>
    <p><strong>To:</strong> {$to_location}</p>
    <p><strong>Departure:</strong> {$departure_time}</p>
    <p><strong>Arrival:</strong> {$arrival_time}</p>

    <h3>Passenger Details</h3>
    <p><strong>Passenger Name:</strong> {$customer_name}</p>
    <p><strong>Booking Date:</strong> {$booking_date}</p>
    <p><strong>Price:</strong> \${$price}</p>

    <br><br>
    <p style="text-align:center;"><strong>Thank you for choosing Decen Air!</strong></p>
EOD;

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF for download
$pdf->Output("boarding_pass_{$booking_id}.pdf", 'D');  // D = download

exit;
?>
