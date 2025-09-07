<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Booking Not Found</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Fallback styling in case styles.css is missing */
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .error {
            background: #fff;
            border: 1px solid #ddd;
            padding: 30px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .error h1 {
            color: #d9534f;
            margin-bottom: 15px;
        }
        .error p {
            margin-bottom: 20px;
            color: #555;
        }
        .error a {
            text-decoration: none;
            background: #0275d8;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
        }
        .error a:hover {
            background: #025aa5;
        }
    </style>
</head>
<body>

<section class="error">
    <h1>Error: Booking Not Found</h1>
    <p>The booking ID you provided does not exist. Please check and try again.</p>
    <a href="index.php">Go back to Home</a>
</section>

</body>
</html>
