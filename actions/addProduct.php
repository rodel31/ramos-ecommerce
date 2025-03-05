<?php
require_once('../actions/connection.php');
session_start();

    if (isset($_POST["btn-save"])) {
        // Capture product data from form
        $product_name = $_POST['product-name'];
        $product_description = $_POST['product-description'];
        $product_price = $_POST['product-price'];
        $product_qty = $_POST['product-qty'];
        $product_category_id = $_POST['product-category'];

        // Initialize product image variable
        $product_image = null;

        // Check if a file has been uploaded
        if (isset($_FILES["product-picture"])) {
            // Check for upload errors
            if ($_FILES["product-picture"]["error"] == 0) {
                // Get the file name and sanitize it
                $product_image = basename($_FILES["product-picture"]["name"]);
                $target_dir = "../uploads/";

                // Define the target file path
                $target_file = $target_dir . $product_image;

                // Allow only specific file types (images)
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

                if (!in_array($imageFileType, $allowedTypes)) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                } else {
                    // Move the uploaded file to the target directory
                    if (move_uploaded_file($_FILES["product-picture"]["tmp_name"], $target_file)) {
                        echo "The file has been uploaded.";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            } else {
                echo "Error uploading file: " . $_FILES["product-picture"]["error"];
            }
        } else {
            echo "No file uploaded.";
        }

        // Insert product into the database
        if ($product_image) {
            // Prepare SQL statement to insert the product data
            $product_query = "INSERT INTO products (product_name, product_description, price, qty, product_image, category_id) 
                            VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($connection, $product_query)) {
                // Bind parameters to the SQL query
                mysqli_stmt_bind_param($stmt, "ssdisi", $product_name, $product_description, $product_price, $product_qty, $product_image, $product_category_id);

                // Execute the query
                if (mysqli_stmt_execute($stmt)) {
                    echo "Product added successfully!";
                } else {
                    echo "Error adding product to the database.";
                }

                // Close the statement
                mysqli_stmt_close($stmt);
            } else {
                echo "Error preparing the SQL query.";
            }
        } else {
            echo "No image uploaded, product cannot be added.";
        }
    }
?>
