<?php
    require_once("actions/connection.php");  // Assuming you have a DB connection file
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
</head>
<style>
        .product {
            display: flex;
            flex-wrap: wrap;
            background-color: whitesmoke;
            border: 1px solid #ddd;
            margin: 15px;
            padding: 15px;
            text-align: center;
            justify-content:center;
        }
        .product-text{
            margin: 25px;
        }
        .product img {
            width: 100%;
            min-height: 300px;
            max-height: 500px
        }
        .product h3 {
            font-size: 18px;
            color: #333;
        }
        .product p {
            color: #777;
        }
        .product a {
            text-decoration: none;
            color: #007bff;
            padding: 5px;
            background-color: goldenrod;
        }
        .product a:hover {
            text-decoration: underline;
        }
    </style>
<body>
    <?php
        // Check if the 'id' parameter exists in the URL query string
        if (isset($_GET['id'])) {
            $product_id = $_GET['id'];  // Retrieve the product ID from the URL
            
            // Now you can use this ID to fetch product details from the database
            // Example query to get product details
            
            // Example query to get product details based on the product ID
            $query = "SELECT * FROM products WHERE id = ?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            // Fetch the product details
            if ($result->num_rows > 0) {
                $product = $result->fetch_assoc();
                $product_id = $product['id'];
                $product_name = $product['product_name'];
                $product_description = $product['product_description'];
                $product_price = $product['price'];
                $product_qty = $product['qty'];
                $product_image = $product['product_image'];  // Example product detail
                // You can now display the product details on this page
                echo "
                    <div class='product'>
                        <div>
                            <img src='uploads/$product_image' alt='$product_name' class='product-image'>
                        </div>
                        <div class='product-text'>
                            <h3>$product_name</h3>
                            <p>Product description: $product_description</p>
                            <p>Price: $$product_price</p>
                            <p>Stocks: $product_qty</p>
                            <a href='ramosView.php'>Back</a>
                            <a href='addToCart.php?id=$product_id'>Add To Cart</a>
                        </div>
                    </div>
                    ";
            } else {
                echo "Product not found.";
            }
        } else {
            echo "No product ID provided.";
        }
    ?>
    
</body>
</html>