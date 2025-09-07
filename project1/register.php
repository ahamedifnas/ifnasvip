<?php
include 'db.php';

// Check if updating an existing profile
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    $student_result = $conn->query("SELECT * FROM students WHERE id = $student_id");
    $student = $student_result->fetch_assoc();
}

// Handle form submission for registration/update
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $course = $_POST['course'];

    if (isset($student_id)) {
        // Update student profile
        $sql = "UPDATE students SET name = '$name', dob = '$dob', course = '$course' WHERE id = $student_id";
    } else {
        // Register new student
        $sql = "INSERT INTO students (name, dob, course) VALUES ('$name', '$dob', '$course')";
    }

    $conn->query($sql);
    header('Location: register.php'); // Redirect after form submission
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register or Update Student</title>
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

    </nav>

    <div class="container">
        <div class="form-container">
            <h2><?php echo isset($student_id) ? 'Update Student Profile' : 'Register New Student'; ?></h2>
            <form method="post">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo isset($student) ? $student['name'] : ''; ?>" required>

                <label>Date of Birth:</label>
                <input type="date" name="dob" value="<?php echo isset($student) ? $student['dob'] : ''; ?>" required>

                <label>Course:</label>
                <input type="text" name="course" value="<?php echo isset($student) ? $student['course'] : ''; ?>" required>

                <input type="submit" name="submit" value="<?php echo isset($student_id) ? 'Update Profile' : 'Register Student'; ?>">
            </form>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Student Record System</p>
    </footer>

</body>
</html>
