<?php
    $servername = 'localhost';
    $database = 'shop4';
    $username = 'root';
    $password = 'Nashwa@2002';

    // Create connection

    $conn = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
