<?php
include 'db.php';

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get values from form fields
    $name = $_POST['name'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $phone_number = $_POST['phone_number'];
    $date_of_birth = $_POST['dob'];

    // Insert query for adding staff
    $sql = "INSERT INTO staff (name, email, position, phone_number, date_of_birth) 
            VALUES ('$name', '$email', '$position', '$phone_number', '$date_of_birth')";

    if ($conn->query($sql) === TRUE) {
        echo "New staff member added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="staff_register.php">Staff Registration</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Register New Staff</h2>
    <form method="POST" action="staff_register.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="position">Position:</label>
        <input type="text" id="position" name="position" required>

        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" required>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required>

        <input type="submit" name="submit" value="Register Staff">
    </form>
</div>

<footer class="footer">
    <p>&copy; 2025 Student Record System</p>
</footer>

</body>
</html>
