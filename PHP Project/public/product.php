<?php
// Start the session and include session authentication check
session_start();

// Check if the user is logged in, if not redirect to login
if (!isset($_SESSION['username'])) {
    header("Location: ../authentication/login.php");
    exit();
}

include 'connection.php';

// Set the number of products to display per page
$products_per_page = 5; // Change this to your desired number of products per page
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $products_per_page;

// Fetch total products to calculate total pages
$total_query = "SELECT COUNT(*) FROM products";
$total_stmt = $pdo->query($total_query);
$total_products = $total_stmt->fetchColumn();
$total_pages = ceil($total_products / $products_per_page);

// Fetch products for the current page
$query = "SELECT * FROM products LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':limit', $products_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<html>
    <head>
        <title>Product List</title>
        <link rel="stylesheet" href="../public/styles.css">
    </head>
    <body>
        <div class="product-container">
            <h1>Product List</h1>

            <p><a href="addproduct.php">Add New Product</a></p> <!-- Link to Add Product -->

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock Level</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['description']); ?></td>
                            <td><?php echo number_format($product['price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($product['stock_level']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="pagination">
                <?php if ($current_page > 1): ?>
                    <a href="?page=<?php echo $current_page - 1; ?>">« Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" <?php if ($i == $current_page) echo 'class="active"'; ?>><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <a href="?page=<?php echo $current_page + 1; ?>">Next »</a>
                <?php endif; ?>
            </div>

            <!-- Back to Welcome Page -->
            <div class="back-button">
                <a href="../authentication/welcome.php" class="back-link">Back to Welcome Page</a>
            </div>
        </div>
    </body>
</html>
