<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process the order here
    $user_id = 1; // Replace with actual user ID from session or login system
    $total = 0;
    foreach ($_SESSION['cart'] as $product_id) {
        $stmt = $conn->prepare("SELECT price FROM products WHERE id = :id");
        $stmt->bindParam(':id', $product_id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        $total += $product['price'];
    }
    // Insert order into database
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (:user_id, :total)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':total', $total);
    $stmt->execute();
    
    // Clear the cart
    unset($_SESSION['cart']);
    echo "Order placed successfully!";
}
?>
<?php include 'header.php'; ?>
<h2>Checkout</h2>
<form method="POST">
    <button type="submit">Place Order</button>
</form>
<?php include 'footer.php'; ?>
