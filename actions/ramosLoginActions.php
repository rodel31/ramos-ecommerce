<?php
// Include the database connection file
require_once("../actions/connection.php");

// Start the session to store user data after successful login
session_start();

if (isset($_POST["login"])) {
    // Collect the input from the login form
    $_email_or_username = $_POST["ramos-email-or-username"];
    $_password = $_POST["ramos-password"];

    // Check if email is provided
    if (filter_var($_email_or_username, FILTER_VALIDATE_EMAIL)) {
        // If email is provided, use it to check user credentials
        $check_user_query = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($connection, $check_user_query);
        mysqli_stmt_bind_param($stmt, "s", $_email_or_username);
    } else {
        // If not an email, treat it as username
        $check_user_query = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($connection, $check_user_query);
        mysqli_stmt_bind_param($stmt, "s", $_email_or_username);
    }

    // Execute the query
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if the user exists
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Check if the password is correct
        if (password_verify($_password, $user['password'])) {
            // If password is correct, start a session and store user info
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role']; // Store user role (admin, user, etc.)

            // Redirect to dashboard or home page
            header("Location: ../actions/dashboard.php"); // Adjust the page to redirect after login
            exit();
        } else {
            // Incorrect password
            echo '<script>alert("Incorrect password.")</script>';
            echo '<script>window.location.href="../ramosLogin.php"</script>';
            exit();
        }
    } else {
        // User does not exist
        echo '<script>alert("No user found with the provided email/username.")</script>';
        echo '<script>window.location.href="../ramosLogin.php"</script>';
        exit();
    }
}
?>
