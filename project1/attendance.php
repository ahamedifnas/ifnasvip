<?php
include 'db.php';
$notification_message = ''; // Variable to store notification message

// Get today's date
$today = date('Y-m-d'); 

if (isset($_POST['submit'])) {
    $student_id = $_POST['student_id'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    // Check if the student has already marked attendance for today
    $check_sql = "SELECT COUNT(*) AS count FROM student_attendance WHERE student_id = '$student_id' AND date = '$date'";
    $check_result = $conn->query($check_sql);
    $check_data = $check_result->fetch_assoc();

    if ($check_data['count'] == 0) {
        // If no record exists, insert the new attendance record
        $insert_sql = "INSERT INTO student_attendance (student_id, date, status) VALUES ('$student_id', '$date', '$status')";
        if ($conn->query($insert_sql) === TRUE) {
            $notification_message = "Attendance marked successfully!";
        } else {
            $notification_message = "Error: " . $conn->error;
        }
    } else {
        $notification_message = "Attendance for this student has already been marked for today.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Notification Styles */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #28a745;
            color: white;
            padding: 15px;
            border-radius: 5px;
            font-size: 16px;
            display: none;
            z-index: 1000;
        }
        .notification.error {
            background-color: #dc3545;
        }
        .notification.success {
            background-color: #28a745;
        }
    </style>
</head>
<body>

<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="register.php">Register Student</a></li>
        <li><a href="attendance.php">Manage Attendance</a></li>
        <li><a href="grades.php">Manage Grades</a></li>
        <li><a href="report.php">Student Report</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Mark Student Attendance</h2>

    <!-- Notification -->
    <div class="notification" id="notification"></div>

    <form method="post">
        <label>Student ID:</label>
        <input type="number" name="student_id" required>

        <label>Date:</label>
        <input type="date" name="date" value="<?php echo $today; ?>" required> <!-- Auto-fill with today's date -->

        <label>Status:</label>
        <select name="status">
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
        </select>

        <input type="submit" name="submit" value="Mark Attendance">
    </form>
</div>

<footer class="footer">
    <p>&copy; 2025 Student Record System</p>
</footer>

<script>
    // Display the notification
    <?php if ($notification_message): ?>
        var message = "<?php echo $notification_message; ?>";
        var notification = document.getElementById("notification");
        notification.innerText = message;
        notification.classList.add("success"); // Add success or error class based on the message
        notification.style.display = "block";

        // Automatically hide notification after 5 seconds
        setTimeout(function() {
            notification.style.display = "none";
        }, 5000);
    <?php endif; ?>
</script>

</body>
</html>
