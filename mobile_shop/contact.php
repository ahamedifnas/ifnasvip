<?php
// contact.php
include 'includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Mobile Shop</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Mobile Shop</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <h2>Contact Us</h2>
            <p>We'd love to hear from you! If you have any questions or need assistance, feel free to reach out to us through the contact form or any of the methods below.</p>

            <!-- Contact Form -->
            <form action="contact_form.php" method="POST" class="contact-form">
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" required placeholder="Enter your full name">
                </div>
                <div class="form-group">
                    <label for="email">Your Email</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email address">
                </div>
                <div class="form-group">
                    <label for="message">Your Message</label>
                    <textarea id="message" name="message" rows="5" required placeholder="Type your message here"></textarea>
                </div>
                <button type="submit" class="submit-btn">Send Message</button>
            </form>

            <!-- Contact Information -->
            <div class="contact-info">
                <h3>Our Contact Information:</h3>
                <p><strong>Email:</strong> support@mobileshop.com</p>
                <p><strong>Phone:</strong> +1 (800) 123-4567</p>
                <p><strong>Address:</strong> 123 Mobile St, Tech City, 12345, USA</p>
            </div>

            <!-- Map -->
            <div class="contact-map">
                <h3>Our Location</h3>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.8758726599446!2d-122.4232486846815!3d37.77492977975805!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085809a5b3f5c1b%3A0x7a29b1bda34cc557!2sSan%20Francisco%20City%20Hall!5e0!3m2!1sen!2sus!4v1646684917308!5m2!1sen!2sus" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Mobile Shop. All rights reserved.</p>
    </footer>
</body>
</html>
