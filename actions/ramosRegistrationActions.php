<?php
    require_once("../actions/connection.php");

    if (isset($_POST["register"])) {
        $_fname = $_POST["ramos-fname"];
        $_lname = $_POST["ramos-lname"];
        $_mname = $_POST["ramos-mname"];
        $_contact = $_POST["ramos-contact"];
        $_street = $_POST["ramos-street"];
        $_barangay = $_POST["ramos-barangay"];
        $_municipality = $_POST["ramos-municipality"];
        $_province = $_POST["ramos-province"];
        $_zip = $_POST["ramos-zip"];
        $_email = $_POST["ramos-email"];
        $_username = $_POST["ramos-username"];
        $_password = $_POST["ramos-password"];
        $_confirm_password = $_POST["ramos-confirm-password"];
        $_user_type = $_POST["user_type"];
        $_profile = $_FILES["ramos-profile-picture"]['name'];

        // Check if email exists using mysqli
        $check_email_query = "SELECT * FROM users WHERE email = ?";
        $stmt_check_email = mysqli_prepare($connection, $check_email_query);
        mysqli_stmt_bind_param($stmt_check_email, "s", $_email);
        mysqli_stmt_execute($stmt_check_email);
        $result = mysqli_stmt_get_result($stmt_check_email);

        if (mysqli_num_rows($result) == 1) {
            echo '<script>alert("Oops! The email you entered already exists in our system.")</script>';
            echo '<script>window.location.href="../ramosRegistration.php"</script>';
            return;
        }

        // Check if username exists using mysqli
        $check_username_query = "SELECT * FROM users WHERE username = ?";
        $stmt_check_username = mysqli_prepare($connection, $check_username_query);
        mysqli_stmt_bind_param($stmt_check_username, "s", $_username);
        mysqli_stmt_execute($stmt_check_username);
        $result_username = mysqli_stmt_get_result($stmt_check_username);

        if (mysqli_num_rows($result_username) == 1) {
            echo '<script>alert("Oops! The username you entered already exists in our system.")</script>';
            echo '<script>window.location.href="../ramosRegistration.php"</script>';
            return;
        }

        // Check if passwords match
        if ($_password != $_confirm_password) {
            echo '<script>alert("Oops! The passwords you have entered do not match.")</script>';
            echo '<script>window.location.href="../ramosRegistration.php"</script>';
            return;
        } else {
            $_password = password_hash($_POST["ramos-password"], PASSWORD_BCRYPT);
        }

        // Profile picture upload
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["ramos-profile-picture"]["name"]);
        move_uploaded_file($_FILES["ramos-profile-picture"]["tmp_name"], $target_file);

        // Start the transaction using mysqli
        mysqli_begin_transaction($connection);

        try {
            // Insert into users table using mysqli
            $user_query = "INSERT INTO users(username, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt1 = mysqli_prepare($connection, $user_query);
            mysqli_stmt_bind_param($stmt1, "ssss", $_username, $_email, $_password, strtolower($_user_type));
            mysqli_stmt_execute($stmt1);
            $user_id = mysqli_insert_id($connection);

            // Insert into profile table using mysqli
            $profile_query = "INSERT INTO profile(user_id, firstname, lastname, middlename, contact, street, barangay, municipality, province, zip, profile_picture) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt2 = mysqli_prepare($connection, $profile_query);
            mysqli_stmt_bind_param($stmt2, "issssssssss", $user_id, $_fname, $_lname, $_mname, $_contact, $_street, $_barangay, $_municipality, $_province, $_zip, $_profile);
            mysqli_stmt_execute($stmt2);

            // Commit the transaction
            mysqli_commit($connection);

            // Redirect to login page
            header('Location: ../ramosLogin.php');
            exit();
        } catch (Exception $e) {
            // Rollback the transaction if an error occurs
            mysqli_rollback($connection);
            die("Error: " . $e->getMessage());
        }
    }
?>
