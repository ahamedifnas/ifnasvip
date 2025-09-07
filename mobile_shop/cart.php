<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    // Add to cart logic here
    $_SESSION['cart'][] = $_POST['product_id'];
}

$cart_items = $_SESSION['cart'] ?? [];
?>
<?php include 'includes/header.php'; ?>
<h2>Your Cart</h2>
<div class="cart-items">
    <?php
    foreach ($cart_items as $product_id) {
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->bindParam(':id', $product_id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<div class='cart-item'>
                <h3>{$product['name']}</h3>
                <p>\${$product['price']}</p>
              </div>";
    }
    ?>
</div>
<a href="checkout.php">Proceed to Checkout</a>
<?php include 'includes/footer.php'; ?>
