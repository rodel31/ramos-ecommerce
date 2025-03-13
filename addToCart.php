<?php
// Include database connection
require_once('actions/connection.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the form data is present
if (isset($_GET['id']) && isset($_GET['user_id']) && isset($_GET['order']) ? isset($_GET['order']) != 0 : null) {
    $product_id = $_GET['id'];
    $user_id = $_GET['user_id'];
    $quantity = $_GET['order'];

    // Check if the product exists and fetch its details
    $query = "SELECT * FROM products WHERE id=?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $product_qty = $product['qty'];

        // Check if enough stock is available
        if ($quantity <= $product_qty) {
            // Proceed with adding the product to the cart
            // You can now insert the product into the cart table or session
            // For example, inserting into the cart table:
            $insert_query = "INSERT INTO shopping_cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
            $insert_stmt = $connection->prepare($insert_query);
            $insert_stmt->bind_param("iii", $user_id, $product_id, $quantity);
            $insert_stmt->execute();

            echo "Product added to cart.";
        } else {
            echo "Not enough stock available.";
        }
    } else {
        echo "Product not found.";
    }
} else {
    echo "Invalid data.";
}

mysqli_close($connection);
?>
