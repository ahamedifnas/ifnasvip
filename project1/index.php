<?php
include 'db.php';

// Total student count
$total_students = $conn->query("SELECT COUNT(*) AS count FROM students")->fetch_assoc()['count'];

// Today's date
$today = date('Y-m-d');

// Get today's attendance details (Present and Absent)
$attendance_result = $conn->query("
    SELECT status, COUNT(*) as count 
    FROM student_attendance 
    WHERE date = '$today' 
    GROUP BY status
");

// Initialize counters for Present and Absent
$present_count = 0;
$absent_count = 0;

// Loop through the attendance results to count Present and Absent
while ($row = $attendance_result->fetch_assoc()) {
    if ($row['status'] == 'Present') {
        $present_count = $row['count'];
    } elseif ($row['status'] == 'Absent') {
        $absent_count = $row['count'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Record Management</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .row {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
            margin-top: 30px;
        }
        .col canvas {
            display: block;
            margin: 0 auto;
            width: 4in !important;
            height: 4in !important;
        }
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .attendance-table th, .attendance-table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        .attendance-table th {
            background-color: #f0f0f0;
        }
        .status-present {
            color: green;
            font-weight: bold;
        }
        .status-absent {
            color: red;
            font-weight: bold;
        }
        .status-none {
            color: gray;
            font-style: italic;
        }
    </style>
</head>
<body>

<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li class="dropdown">
            <a href="#" class="dropbtn">Student Management</a>
            <div class="dropdown-content">
                <a href="register.php">Register Student</a>
                <a href="attendance.php">Manage Attendance</a>
                <a href="grades.php">Manage Grades</a>
                <a href="course.php">Manage Courses</a>
            </div>
        </li>
        <li class="dropdown">
            <a href="#" class="dropbtn">Staff Management</a>
            <div class="dropdown-content">
                <a href="staff_register.php">Staff Registration</a>
                <a href="staff_management.php">Staff Management</a>
            </div>
        </li>
        <li><a href="report.php">Student Report</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Welcome to the Student Record System</h2>

    <div class="row">
        <!-- Pie Chart Column -->
        <div class="col">
            <canvas id="studentPieChart" width="384" height="384"></canvas>
            <script>
                var ctx = document.getElementById('studentPieChart').getContext('2d');
                var studentChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Present', 'Absent'],
                        datasets: [{
                            data: [<?= $present_count ?>, <?= $absent_count ?>],
                            backgroundColor: ['#28a745', '#dc3545']
                        }]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw;
                                    }
                                }
                            }
                        }
                    }
                });
            </script>
        </div>

        <!-- Attendance Table Column -->
        <div class="col">
            <h3>Today's Attendance (<?= $today ?>)</h3>
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Get student attendance details for today
                    $attendance_result = $conn->query("
                        SELECT s.id, s.name, a.status 
                        FROM students s
                        LEFT JOIN student_attendance a 
                            ON s.id = a.student_id AND a.date = '$today'
                    ");

                    while ($row = $attendance_result->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td>
                                <?php
                                    if ($row['status'] === 'Present') {
                                        echo "<span class='status-present'>Present</span>";
                                    } elseif ($row['status'] === 'Absent') {
                                        echo "<span class='status-absent'>Absent</span>";
                                    } else {
                                        echo "<span class='status-none'>Not Marked</span>";
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer class="footer">
    <p>&copy; 2025 Student Record System</p>
</footer>

</body>
</html>
