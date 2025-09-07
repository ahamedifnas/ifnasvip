<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $student_id = $_POST['student_id'];
    $course_name = $_POST['course_name'];

    $sql = "INSERT INTO courses (student_id, course_name) VALUES ('$student_id', '$course_name')";
    $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
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
            <h2>Manage Student Courses</h2>
            <form method="post">
                <label>Student ID:</label>
                <input type="number" name="student_id" required>

                <label>Course Name:</label>
                <input type="text" name="course_name" required>

                <input type="submit" name="submit" value="Add Course">
            </form>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Student Record System</p>
    </footer>

</body>
</html>
