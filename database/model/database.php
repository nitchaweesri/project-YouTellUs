<?php 

include 'config.php';
// $connection = ssh2_connect('devytuapp.tellvoice.com', 22);
// ssh2_auth_password($connection,'devyoutellus','Ytu2020#P@ssw0rd');


    $servername = DATABASE_HOSTNAME;
    $username = DATABASE_USER;
    $password = DATABASE_PASSWORD;
    $dbname = DATABASE_DBNAME;
    $port = DATABASE_HOSTPORT;



    $conn = new mysqli($servername, $username, $password, $dbname , $port);
    mysqli_set_charset($conn, "utf8");
    date_default_timezone_set("Asia/Bangkok");

    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
?>