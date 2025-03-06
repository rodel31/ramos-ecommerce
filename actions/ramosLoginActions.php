<?php
require_once("../actions/connection.php");
session_start();

if (isset($_POST["login"])) {
    $_email_or_username = $_POST["ramos-email-or-username"];
    $_password = $_POST["ramos-password"];

    if (filter_var($_email_or_username, FILTER_VALIDATE_EMAIL)) {
        $check_user_query = "SELECT * FROM users WHERE email = ?";
    } else {
        $check_user_query = "SELECT * FROM users WHERE username = ?";
    }

    $stmt = mysqli_prepare($connection, $check_user_query);
    mysqli_stmt_bind_param($stmt, "s", $_email_or_username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($_password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            echo "<script>parent.location.href = '../ramosIndex.php';</script>";
            exit();
        } else {
            $_SESSION['error'] = "Incorrect password.";
        }
    } else {
        $_SESSION['error'] = "No user found with the provided email/username.";
    }

    header("Location: ../ramosLogin.php");
    exit();
}
?>
