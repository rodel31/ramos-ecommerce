<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once("actions/connection.php");

    $product_id = isset($_GET['id']) ? $_GET['id'] : null;

    if($_SERVER["REQUEST_METHOD"]=="POST" && $product_id){
        $product_name = $_POST['product_name'];
        $product_desc = $_POST['product_description'];
        $price = $_POST['price'];
        $qty = $_POST['quantity'];

        $targetDir = "uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true); 
        }
        $fileName = basename($_FILES['product_image']['name']);
        $targetFilePath = $targetDir . time() . "_" . $fileName; 
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        $imageUploaded = false;

        if (!empty($fileName) && in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $targetFilePath)) {
                $imageUploaded = true;
            } else {
                echo "<script>alert('Error uploading file. Please try again.');</script>";
            }
        }

        if ($imageUploaded) {
            $stmt = $connection->prepare("UPDATE products SET product_name = ?, product_description = ?, price = ?, qty = ?, product_image = ? WHERE id = ?");
            $stmt->bind_param("ssiis", $product_name, $product_desc, $price, $qty, $targetFilePath, $product_id);
        } else {
            $stmt = $connection->prepare("UPDATE products SET product_name = ?, product_description = ?, price = ?, qty = ?, product_image = ? WHERE id = ?");
            $stmt->bind_param("ssiis", $product_name, $product_desc, $price, $qty, $targetFilePath, $product_id);
        }

        if ($stmt->execute()) {
            echo "<script>alert('School information updated successfully!');</script>";
            echo "<script>window.location.href='ramosUpdateSchool.php';</script>";
        } else {
            echo "<script>alert('Database error: Unable to update record.');</script>";
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    if ($product_id) {
        $stmt = $connection->prepare("SELECT product_name, product_description, price, qty, product_image FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $products = $result->fetch_assoc();
        } else {
            echo "<script>alert('No product found with this ID.');</script>";
        exit;
        }
            $stmt->close();
        } else {
            echo "<script>alert('Invalid school ID.');</script>";
            exit;
        }
        
        $connection->close();
?>

<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update School Information</title>
    <link rel='stylesheet' type='text/css' media='screen' href='CSS/Style.css'>
</head>

<style>
    body {
        background-image: url("bg10.jpeg");
        background-repeat: no-repeat;
        background-size: 100%;
    }

    .container {
        margin: 20px auto;
        max-width: 900px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: bold;
        font-family: Century Gothic;
        text-align: left;
        color: #1f618d; 
    }

    .form-group input, .form-group select {
        width: 97.5%;
        padding: 10px;
        margin-top: 5px;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .form-group button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        border-radius: 4px;
    }

    .form-group button:hover {
        background-color: #45a049;
    }

    .center {
        text-align: center;
        margin-top: 50px;
    }

    p {
        font-family: Century Gothic;
        font-size: 12px;
    }
</style>

<body>

<div class="center">
    <h1>Update Product Information</h1>
</div>

<div class="container">

<form method="POST" enctype="multipart/form-data">

    <div class="form-group">
        <label for="productName">Product Name</label>
        <input type="text" name="productName" id="productName" value="<?php echo htmlspecialchars($products['pproduct_name']); ?>" required>
    </div>

    <div class="form-group">
        <label for="productName">Product Name</label>
        <input type="text" name="productName" id="productName" value="<?php echo htmlspecialchars($products['pproduct_name']); ?>" required>
    </div>

    <div class="form-group">
        <label for="productName">Product Name</label>
        <input type="text" name="productName" id="productName" value="<?php echo htmlspecialchars($products['pproduct_name']); ?>" required>
    </div>

    <div class="form-group">
        <label for="productName">Product Name</label>
        <input type="text" name="productName" id="productName" value="<?php echo htmlspecialchars($products['pproduct_name']); ?>" required>
    </div>

    <div class="form-group">
        <label for="image">School Image</label>
        <?php if (!empty($school['image_path'])): ?>
            <div>
                <p>Current Image:</p>
                <center><img src="<?php echo htmlspecialchars($school['image_path']); ?>" alt="Current School Image" width="200"></center>
            </div>
        <?php endif; ?>
        <input type="file" name="image" id="image">
    </div>

    <div class="form-group">
        <button type="submit">Update</button>
        <button type="button" onclick="window.history.back();">Back</button>
    </div>
</form>
</div>

</body>
</html>