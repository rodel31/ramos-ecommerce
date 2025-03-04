<?php 
    session_start();
    require_once("actions/connection.php"); 

    if(isset($_SESSION["username"])){

        $user_id = $_SESSION["user_id"] ?? null;
        $user_type = $_SESSION["role"] ?? null;

        if ($user_id) {
            $_query = "SELECT firstname, lastname, profile_picture FROM profile WHERE user_id = ?";
            
            $stmt = mysqli_prepare($connection, $_query); 
            
            if($stmt === false){
                echo "Error preparing statement: " . mysqli_error($connection);
                exit();
            }
            
            mysqli_stmt_bind_param($stmt, "i", $user_id);

            if (!mysqli_stmt_execute($stmt)) {
                echo "Error executing statement: " . mysqli_stmt_error($stmt);
                exit();
            }

            $result = mysqli_stmt_get_result($stmt);

            if($result && $row = mysqli_fetch_assoc($result)){
                $_SESSION["username"] = [
                    "firstname" => $row["firstname"],
                    "lastname" => $row["lastname"],
                    "profile_picture" => $row["profile_picture"] ?? "default-profile.png"
                ];

                $stmt->close();
                $connection->close();

                $full_name = htmlspecialchars($_SESSION["username"]["firstname"]) . " " . htmlspecialchars($_SESSION["username"]["lastname"]);
            } 
        }
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Login Signup</title>
</head>

<style>
    .Container{
        display: flex;
        justify-content: flex-end;
        align-items: flex-end;
        margin-top: 55px;
    }
    .box1{
        display: flex;
        gap: 5px;
    }
        .ramos-view{
            padding:3px;
            color: teal;
        }
    .box2{
        display: flex;
        gap: 5px;
        align-items: flex-end;
        margin-left: auto;
    }
        .btn-logout {
            width: 70px;
            padding:8px;
            color: teal;
        }
        .profile-container{
            display: flex;
            align-items: flex-end;
        }
        .profile-picture{
            display: flex;
            width:50px;
            height:50px;
            border-radius: 50%;  /* Makes it a circle */
            object-fit: cover;   /* Ensures the image covers the space without distortion */
            align-items: flex-end;
        }
        h2{
            display: flex;
            align-items: flex-end;
        }
        .user-name{
            margin-top: 15px;
            font-size: 16px;
        }
    

</style>
<body class = "ramos-login-signup">
    <?php if (isset($_SESSION["username"])): ?>
        
        <?php if ($user_type == "admin"): ?>
            <div class="Container">
                <div class="box1">
                    <a href="ramosViewProducts.php" target="mid-column"><button class="ramos-view">View Products</button></a>
                    <a href="ramosAddProducts.php" target="mid-column"><button class="ramos-view">Add Products</button></a>
                    <a href="ramosViewOrders.php" target="mid-column"><button class="ramos-view">Orders</button></a>
                    <a href="ramosViewUsers.php" target="mid-column"><button class="ramos-view">User List</button></a>
                    <a href="ramosViewAdmin.php" target="mid-column"><button class="ramos-view">Profile</button></a>
                    <a href="ramosViewFeedbacks.php" target="mid-column"><button class="ramos-view">Reports</button></a>
                    <a href="ramosSchoolArchive.php" target="mid-column"><button class="ramos-view">Archive</button></a>
                </div>

                <div class="box2">
                    <form action="actions/logout.php" method="POST">
                        <button type="submit" name="logout" class="btn-logout">Logout</button>
                    </form>
                    <div class="profile-container">
                    <img src="<?php echo htmlspecialchars($_SESSION['username']['profile_picture']); ?>" alt="Profile Picture" class="profile-picture">
                        <h2><span class="user-name"><?php echo $full_name; ?></span></h2>   
                    </div>
                </div>
                
            </div>
        <?php elseif ($user_type == "user"): ?>

        <?php endif; ?>
    <?php else: ?>
        <div class="login"> 
            <a type = "button" href="ramosLogin.php" target="mid-column">Login</a>
            <a type = "button" href="ramosRegistration.php" target="mid-column">Signup</a>
        </div>
    

    <?php endif; ?>
</body>
</html>