<?php
    session_start();

    if (isset($_SESSION['error'])) {
        echo '<script>alert("' . $_SESSION['error'] . '");</script>';
        unset($_SESSION['error']); 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
    <style>
        .ramos-login-page{
            background-color: #ccfbfb;
            background-repeat: no-repeat;
            background-size: cover;
            text-align: center;
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
    </style>
    <script src="js/scripts.js"></script>
<body class="ramos-login-page">

    <div class="container">
        <h1>Login</h1>
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