<?php
include 'db.php';

// Query to get student report with attendance stats
$query = "
    SELECT 
        s.id, 
        s.name,
        COUNT(a.id) AS total_days,
        SUM(a.status = 'Present') AS present_days,
        SUM(a.status = 'Absent') AS absent_days
    FROM students s
    LEFT JOIN student_attendance a ON s.id = a.student_id
    GROUP BY s.id, s.name
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Report</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        .report-table th, .report-table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .report-table th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>

<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="register.php">Register Student</a></li>
        <li><a href="attendance.php">Add Attendance</a></li>
        <li><a href="grades.php">Add Grades</a></li>
        <li><a href="course.php">Manage Courses</a></li>
        <li><a href="staff_register.php">Register Staff</a></li>
        <li><a href="report.php">Student Report</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Student Attendance Report</h2>

    <table class="report-table">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Total Days</th>
                <th>Present</th>
                <th>Absent</th>
                <th>Attendance %</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): 
                $total = $row['total_days'];
                $present = $row['present_days'];
                $absent = $row['absent_days'];
                $percent = $total > 0 ? round(($present / $total) * 100, 2) : 0;
            ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= $total ?></td>
                    <td><?= $present ?></td>
                    <td><?= $absent ?></td>
                    <td><?= $percent ?>%</td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<footer class="footer">
    <p>&copy; 2025 Student Record System</p>
</footer>

</body>
</html>
