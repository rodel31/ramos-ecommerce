<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "ramos_kiosk";

    $connection = mysqli_connect($server, $username, $password, $database);

    if($connection->connect_error){
        die("Database connection failed".$connection->connect_error);
    }
?>