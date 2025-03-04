<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Add Products</title>
</head>
<style>
    .add-product-page{
        background-color: #ccfbfb;
        background-repeat: no-repeat;
        background-size: cover;
        text-align: center;
    }
    .container{
        margin-top: 10em;
    }
    html {
            height: 75%;
            margin: 0;
            display: flex;
            justify-content: center; 
            align-items: center;   
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        h1 {
            color: #1f618d;
            font-family: Century Gothic;
        }
    .ramos-cancel{   
        background-color:rgb(239, 185, 6) ; 
        border-color: goldenrod; 
        color: white;
        padding: 10px 20px; 
        font-size: 18px; 
        cursor: pointer; 
        border-radius: 5px; 
        margin: 2px;
        max-width: 500px;
    }
    
</style>
<script src="js/scripts.js"></script>
<body class = "add-product-page">
    
    <div class="container">
        <h1>Add Product</h1>
        <br>

        <form action="actions/ramosLoginActions.php" method="POST">

            <div class="inpuGroup">
                <label>Product Name</label>
                <input type="text" name="ramos-product-name" required>
            </div>

            <div class="inpuGroup">
                <label>Description</label>
                <input type="textarea" name="ramos-product-description" required>
            </div>

            <div class="inpuGroup">
                <label>Price</label>
                <input type="number" name="ramos-product-description" required>
            </div>

            <div class="inpuGroup">
                <label>Quantity</label>
                <input type="number" name="ramos-product-description" required>
            </div>
            <div class="inpuGroup1">
                <label>Product Picture</label>
                <input type="file" class="DP" name="ramos-profile-picture" accept="image/*" required>
            </div>

            <button type="submit" name="btn-save" class="ramos-login">Save</button>
            <button type="submit" name="btn-cancel" class="ramos-cancel">Cancel</button>
        </form>
    </div>
</body>
</html>