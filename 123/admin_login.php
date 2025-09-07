<?php
session_start();

// Check if the admin is already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin_dashboard.php"); // Redirect to the admin dashboard
    exit;
}

// Define updated admin credentials (username: Sithu, password: 1234)
$admin_username = 'ifnas';
$admin_password = '1234'; // Updated password

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve input values
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if credentials match
    if ($username == $admin_username && $password == $admin_password) {
        // Set session variables
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;

        // Redirect to the admin dashboard
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Decen Air</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body and Background */
body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(135deg, #042558, #c2e8ff); /* Gradient background */
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #333;
}

/* Container for Centered Login Form */
.login-container {
    width: 100%;
    max-width: 400px;
    background-color: rgba(255, 255, 255, 0.9); /* White background with transparency */
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Header and Error Message */
h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

.error {
    color: red;
    font-size: 14px;
    text-align: center;
    margin-bottom: 15px;
}

/* Form Styling */
form {
    display: flex;
    flex-direction: column;
}

/* Input Fields */
label {
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"], input[type="password"] {
    padding: 12px;
    margin-bottom: 15px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
    transition: border-color 0.3s;
}

input[type="text"]:focus, input[type="password"]:focus {
    border-color: #FF6347; /* Highlight border color on focus */
}

/* Button Styling */
.login-btn {
    padding: 12px;
    font-size: 16px;
    background-color: #6b9cba;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.login-btn:hover {
    background-color: #114b63; /* Darker shade on hover */
}

/* Mobile Responsiveness */
@media (max-width: 600px) {
    .login-container {
        padding: 20px;
    }

    .login-form h2 {
        font-size: 24px;
    }

    input[type="text"], input[type="password"], .login-btn {
        font-size: 14px;
    }
}

        </style>
</head>
<body>

<!-- Admin Login Section -->
<div class="login-container">
    <div class="login-form">
        <h2>Admin Login</h2>
        
        <?php if (isset($error_message)): ?>
            <div class="error"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>

        <form action="admin_login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required placeholder="Enter your username">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required placeholder="Enter your password">

            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
</div>

</body>
</html>
