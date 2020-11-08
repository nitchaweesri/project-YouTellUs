<?php 
    include 'database/model/database.php';
    $sql = "SELECT * FROM `CONFIG_YTU_BLOCK`";
    $result = $conn->query($sql);
    return $result;


    $sql = "INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('John', 'Doe', 'john@example.com')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>