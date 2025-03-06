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
        $image_name = null;

        // Check if a file has been uploaded
        if (isset($_FILES["product-picture"])) {
            // Check for upload errors
            if ($_FILES["product-picture"]["error"] == UPLOAD_ERR_OK) {
                // Get the file name and sanitize it
                $allowed_extension = ['jpg', 'jpeg', 'png', 'gif'];
                $file_extension = pathinfo($_FILES["product-picture"]["name"], PATHINFO_EXTENSION);
                $target_path = "../uploads/";
                // Allow only specific file types (images)
                $image_file_type = strtolower($file_extension);
                if (in_array($image_file_type,  $allowed_extension)) {
                    // Generate unique file name and move the uploaded image
                    $image_name = uniqid() . '.' . $file_extension;
                    // Define the target file path
                    $target_file = $target_path . $image_name;
                    // Move the uploaded file to the target directory
                    if (move_uploaded_file($_FILES["product-picture"]["tmp_name"], $target_file)) {
                       // echo "<script>alert(The file has been uploaded.)</script>";
                        echo "<script>parent.location.href = '../ramosIndex.php';</script>";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                } else {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                }
            } else {
                echo "Error uploading file: " . $_FILES["product-picture"]["error"];
            }
        } else {
            echo "No file uploaded.";
        }

        // Insert product into the database
        if ($image_name) {
            // Prepare SQL statement to insert the product data
            $product_query = "INSERT INTO products (product_name, product_description, price, qty, product_image, category_id) 
                            VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($connection, $product_query)) {
                // Bind parameters to the SQL query
                mysqli_stmt_bind_param($stmt, "ssdisi", $product_name, $product_description, $product_price, $product_qty, $image_name, $product_category_id);

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
