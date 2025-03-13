<?php
    // Include your database connection
    require_once('actions/connection.php');
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $user_id = $_SESSION['user_id']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <style>
        body{
            background-color: #ccfbfb;
        }
        .product-list {
            display: flex;
            flex-wrap: wrap;
        }
        .product {
            background-color: whitesmoke;
            border: 1px solid #ddd;
            margin: 10px;
            padding: 15px;
            width: 300px;
            height: 450px;
            text-align: center;
        }
        .product img {
            width: 100%;
            height: 60%;
        }
        h2{
            text-align: left;
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
            justify-items: left;
            background-color: goldenrod;
            margin: 3px;
            padding: 1px;
        }
        .product a:hover {
            text-decoration: underline;
        }
        input{
            width: 35px;
        }
        
    </style>
    <script src="js/scripts.js"></script>
</head>
<body>
    <h2>Features</h2>
    <?php
        
        // Query to fetch all products
        $query = "SELECT * FROM products";  // Adjust your table name and fields
        $result = mysqli_query($connection, $query);

        // Check if products are found
        if (mysqli_num_rows($result) > 0) {
            echo "<div class='product-list'>";
            
            // Loop through all products
            while ($row = mysqli_fetch_assoc($result)) {
                $product_id = $row['id'];
                $product_name = $row['product_name'];
                $product_description = $row['product_description'];
                $product_price = $row['price'];
                $product_qty = $row['qty'];
                $product_image = $row['product_image'];  // Assume this field stores the image path
                
                // Display the product
                echo "
                <div class='product'>
                    <img src='uploads/$product_image' alt='$product_name' class='product-image'>
                    <h3>$product_name</h3>
                    <p>Price: $$product_price</p>
                    <p>Stocks: $product_qty</p>
                    <form action='addToCart.php' method='get'>
                        <div>    
                            <label for='order'>Quantity:
                                <input type='number' name='order' id='order' min='1' max='$product_qty' value = 1 required>
                            </label>
                        </div>
                        <input type='hidden' name='id' value='$product_id'>
                        <input type='hidden' name='user_id' value='$user_id'>
                        <button type='submit'>Add To Cart</button>
                    </form>
                    <a href='productDetails.php?id=$product_id'>View Details</a>
                    <a href='payment.php?id=$product_id'>Buy now</a>
                </div>
                ";
            }
            echo "</div>";
        } else {
            echo "No products found.";
        }

        // Close the database connection
        mysqli_close($connection);
    ?>
</body>
</html>