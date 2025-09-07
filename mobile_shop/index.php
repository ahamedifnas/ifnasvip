<?php include 'includes\header.php'; ?>
<div class="container">
    <h1>Welcome to the Mobile Shop</h1>
    <div class="product-list">
        <?php
        include 'includes\db.php';
        $stmt = $conn->query("SELECT * FROM products");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='product'>
                    <img src='assets/images/{$row['image']}' alt='{$row['name']}'>
                    <h2>{$row['name']}</h2>
                    <p>{$row['description']}</p>
                    <p><strong>\${$row['price']}</strong></p>
                    <a href='product.php?id={$row['id']}'>View Details</a>
                  </div>";
        }
        ?>
    </div>
</div>
<?php include 'includes\footer.php'; ?>
