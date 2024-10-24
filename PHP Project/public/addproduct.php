<?php
// Include the database connection and session handling for authentication
include 'connection.php';
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location:  ./authentication/login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_level = $_POST['stock_level'];

    // Insert product into the database
    $query = "INSERT INTO products (name, description, price, stock_level) VALUES (:name, :description, :price, :stock_level)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':stock_level', $stock_level);
    $stmt->execute();

    // Redirect to products page after adding
    header("Location: products.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS -->
</head>
<body>
    <h1>Add New Product</h1>
    <form method="POST" action="add_product.php">
        <label for="name">Product Name:</label>
        <input type="text" name="name" required><br>

        <label for="description">Description:</label>
        <textarea name="description" required></textarea><br>

        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" required><br>

        <label for="stock_level">Stock Level:</label>
        <input type="number" name="stock_level" required><br>

        <button type="submit">Add Product</button>
    </form>

    <a href="../public/product.php" >View All Products</a> 

    <a href="../authentication/welcome.php" >Back to Welcome Page</a>
</body>
</html>
