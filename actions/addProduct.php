<?php
    require_once('../actions/connection.php');
    session_start();

    if(isset($_POST["btn-save"])){
        $product_name = $_POST['product-name'];
        $product_description = $_POST['product-description'];
        $product_price = $_POST['product-price'];
        $product_qty = $_POST['product-qty'];
        $product_image = $_POST['product_image'];
        $product_category_id = $_POST['product-category'];


        echo "message " .$product_category_id. "</p>";
        //$product_query = "INSERT INTO products('name', 'description', 'price', 'qty', category_id ) VALUES(?, ?, ?, ?, ?)";
    }

?>