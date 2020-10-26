<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tellvoiceDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


// $sql = "INSERT INTO `case`( `user_name`, `user_tel`, `status`, `description`) VALUES ('fik','0822671922',1,'des')";

// if ($conn->query($sql) === TRUE) {
//   echo "New record created successfully";
// } else {
//   echo "Error: " . $sql . "<br>" . $conn->error;
// }

// $conn->close();
?>