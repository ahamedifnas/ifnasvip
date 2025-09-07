<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $student_id = $_POST['student_id'];
    $subject = $_POST['subject'];
    $grade = $_POST['grade'];

    $sql = "INSERT INTO grades (student_id, subject, grade) VALUES ('$student_id', '$subject', '$grade')";
    $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Grades</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <ul>
        <li><a href="index.php">Home</a></li>

        <!-- Student Management Dropdown -->
        <li class="dropdown">
            <a href="#" class="dropbtn">Student Management</a>
            <div class="dropdown-content">
                <a href="register.php">Register Student</a>
                <a href="attendance.php">Manage Attendance</a>
                <a href="grades.php">Manage Grades</a>
                <a href="course.php">Manage Courses</a>
            </div>
        </li>

        <!-- Staff Management Dropdown -->
        <li class="dropdown">
            <a href="#" class="dropbtn">Staff Management</a>
            <div class="dropdown-content">
                <a href="staff_register.php">Staff Registration</a>
            </div>
        </li>

        <!-- Reports Section -->
        <li><a href="report.php">Student Report</a></li>

        <!-- Optional Logout -->
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>


    <div class="container">
        <div class="form-container">
            <h2>Add Student Grades</h2>
            <form method="post">
                <label>Student ID:</label>
                <input type="number" name="student_id" required>

                <label>Subject:</label>
                <input type="text" name="subject" required>

                <label>Grade:</label>
                <input type="text" name="grade" required>

                <input type="submit" name="submit" value="Add Grade">
            </form>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Student Record System</p>
    </footer>

</body>
</html>
