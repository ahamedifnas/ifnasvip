<?php
session_start();
include 'includes/db.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle the product addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];

    // Upload the product image to the "assets/images" folder
    move_uploaded_file($_FILES['image']['tmp_name'], "assets/images/" . $image);

    // Insert the product into the database
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (:name, :description, :price, :image)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':image', $image);
    $stmt->execute();
    $message = "Product added successfully!";
}

// Fetch all products from the database
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <h2>Admin Panel</h2>
    <?php if (isset($message)) { echo "<p style='color: green;'>$message</p>"; } ?>

    <!-- Product Addition Form -->
    <h3>Add New Product</h3>
    <form method="POST" action="admin_panel.php" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required><br>
        
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br>
        
        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" required><br>
        
        <label for="image">Product Image:</label>
        <input type="file" id="image" name="image" required><br>
        
        <button type="submit" name="add_product">Add Product</button>
    </form>

    <hr>
    
    <!-- Product List -->
    <h3>Product List</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['name'] ?></td>
                    <td><?= $product['description'] ?></td>
                    <td>$<?= $product['price'] ?></td>
                    <td><img src="assets/images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" width="50"></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <hr>

    <!-- Logout Option -->
    <a href="logout.php">Logout</a>
</body>
</html>
