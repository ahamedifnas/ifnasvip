<?php
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db.php';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $message = "Email is already registered.";
    } else {
        // Insert new user
        $stmt_insert = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt_insert->bind_param("sss", $name, $email, $password);

        if ($stmt_insert->execute()) {
            $message = "Registration successful! You can now <a href='login.php'>login</a>.";
        } else {
            $message = "Error: " . $stmt_insert->error;
        }

        $stmt_insert->close();
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        body { font-family: Arial; background: #f9f9f9; display:flex; justify-content:center; align-items:center; height:100vh; }
        form { background:#fff; padding:20px; border-radius:10px; box-shadow:0 4px 8px rgba(0,0,0,0.1); width:300px; }
        input { display:block; margin:10px 0; padding:10px; width:100%; }
        button { padding:10px; width:100%; background:#28a745; color:#fff; border:none; border-radius:5px; cursor:pointer; }
        button:hover { background:#218838; }
        .message { margin-bottom:10px; color:red; }
    </style>
</head>
<body>

<form action="register.php" method="POST">
    <h2>Register</h2>
    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
</form>

</body>
</html>
