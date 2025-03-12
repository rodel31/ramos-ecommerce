<?php
    require_once("actions/connection.php");

    if(isset($_GET['id'])){
        $product_id = $_GET['id'];

        $query = "SELECT * FROM products WHERE id=?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $product = $result->fetch_assoc();
            $product_id = $product['id'];
            $product_name = $product['product_name'];
            $product_description = $product['product_description'];
            $product_price = $product['price'];
            $product_qty = $product['qty'];
            $product_image = $product['product_image'];
        }
    }
?>