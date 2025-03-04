<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Add Products</title>
</head>
<style>
    
</style>
<script src="js/scripts.js"></script>
<body class = "add-product-page">
    
    <div class="container">
        <h1>Add Product</h1>
        <br>

        <form action="actions/ramosLoginActions.php" method="POST">

            <div class="inpuGroup">
                <label>Username or Email</label>
                <input type="text" name="ramos-email-or-username" required>
            </div>

            <div class="inpuGroup">
                <label>Password</label>
                <input type="password" name="ramos-password" required>
            </div>

            <button type="submit" name="login" class="ramos-login">Login</button>

            <a href="forgot-password.php" target="mid-column">Forgot password?</a>
        </form>
    </div>
</body>
</html>