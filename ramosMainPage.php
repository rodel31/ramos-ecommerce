<?php 
    session_start();
    require_once("actions/connection.php"); 
    $user_type = $_SESSION["role"] ?? null;
    $username = $_SESSION["username"] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

</head>
<style>
    .home-bg {
        background-image: url("images/heroPage1.png");
        background-repeat: no-repeat;
        background-size: cover;
        opacity: 0.2;
        height: 100vh;
    }
    h1{
        text-align: center;
        color: goldenrod;
    }
    .home {
        background-color: #ccfbfb;
        background-repeat: no-repeat;
        background-size: cover;
        text-align: center;
    }
</style>
<body class="home">
    <!-- <div class="home-bg">
        <h1>Welcome to e-commerce website</h1>
    </div> -->
    <?php if (isset($_SESSION["username"])): ?>
        
        <?php if ($user_type == "admin"): ?>
            <?php include("adminDefaultView.php"); ?>
        
        <?php elseif ($user_type == "user"): ?>
            <?php include("ramosView.php"); ?>
        <?php endif; ?>    
        <?php else: ?>
            <h1>Welcome to e-commerce website</h1>
            <div class="home-bg">
                
            </div> 
    <?php endif; ?>
</body>
</html>