<?php
include 'db.php';

// Fetch staff data
$staff_query = "SELECT * FROM staff";
$staff_result = $conn->query($staff_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="staff_register.php">Register Staff</a></li>
        <li><a href="staff_management.php">Staff Management</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Staff Management</h2>

    <table class="staff-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Position</th>
                <th>Phone Number</th>
                <th>Date of Birth</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are any staff members in the database
            if ($staff_result->num_rows > 0) {
                // Loop through the staff records and display them in the table
                while ($row = $staff_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['position']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['phone_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['date_of_birth']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No staff members found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<footer class="footer">
    <p>&copy; 2025 Student Record System</p>
</footer>

</body>
</html>
