<?php 
    $servername = "devscbdb01";
    $username = "tellvoice";
    $password = "eciovllet";
    $dbname = "scbytu_dev";
    $port = "9306";
    $conn = new mysqli($servername, $username, $password, $dbname , $port);
    mysqli_set_charset($conn, "utf8");

    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
?>