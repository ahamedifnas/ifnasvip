<?php
include 'includes/db.php';
$product_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
$stmt->bindParam(':id', $product_id);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);
include 'includes/header.php';
?>
<div class="product-detail">
    <img src="assets/images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
    <h2><?= $product['name'] ?></h2>
    <p><?= $product['description'] ?></p>
    <p><strong>$<?= $product['price'] ?></strong></p>
    <form action="cart.php" method="POST">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <button type="submit">Add to Cart</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?>
