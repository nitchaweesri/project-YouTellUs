<?php 

// $connection = ssh2_connect('devytuapp.tellvoice.com', 22);
// ssh2_auth_password($connection,'devyoutellus','Ytu2020#P@ssw0rd');

    ////////////////////////  dev  //////////////////////////
    // $servername = "devscbdb01";
    // $username = "tellvoice";
    // $password = "eciovllet";
    // $dbname = "scbytu_dev";
    // $port = "9306";

    //////////////////     localhost     ///////////////////
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "scbytu_dev";
    $port = "3306";



    $conn = new mysqli($servername, $username, $password, $dbname , $port);
    mysqli_set_charset($conn, "utf8");

    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
?>