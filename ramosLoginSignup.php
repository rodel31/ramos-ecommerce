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
            } else {
                echo "No user data found.";
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
    .profile-container {
        display: flex;
        align-items: center;
        margin-left: 10px;
    }

    .profile-picture {
        width: 50px;
        height: 50px;
        border-radius: 50%; 
        object-fit: cover;
        margin-right: 10px;
    }

    .user-name {
        font-family: Century Gothic;
        color: whitesmoke;
        font-size: 20px;
    }

    .Container {
        display: flex;
        margin-top: -25px;
    }

    .login {
        display: flex;
        justify-content: flex-end;
        margin-top: 25px;
    }

    .box1,
    .box2 {
        flex: 1;
        padding: 10px;
        margin-top: 1.5%;
    }

    .box1 {
        display: flex;
        overflow: hidden;
    }

    .box2 {
        display: flex;
        justify-content: flex-end;
        width: 20%; 
        max-width: 200px; 
    }

    .galvanLogin, .galvanSignup {
        width: 200px;
    }

    .galvanClear {
        width: 150px;
    }
</style>
<body class = "ramos-login-signup">
    <?php if (isset($_SESSION["username"])): ?>
        <div class="profile-container">
            <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" class="profile-picture">
            <h2><span class="user-name"><?php echo $full_name; ?></span></h2>   
        </div>
        <?php if ($user_type == "admin"): ?>
            <div class="Container">
                <div class="box1">
                    <a href="ramosIndex.php" target="mid_column"><button class="galvanView">Products</button></a>
                    <a href="ramosViewUsers.php" target="mid_column"><button class="galvanView">User List</button></a>
                    <a href="ramosViewAdmin.php" target="mid_column"><button class="galvanView">Profile</button></a>
                    <a href="ramosViewFeedbacks.php" target="mid_column"><button class="galvanView">Report</button></a>
                    <a href="ramosSchoolArchive.php" target="mid_column"><button class="galvanView">Archive</button></a>
                </div>

                <div class="box2">
                    <form action="actions/logout.php" method="POST">
                        <button type="submit" name="logout" class="galvanClear">Logout</button>
                    </form>
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