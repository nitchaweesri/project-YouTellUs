<?php

// Check if image file is a actual image or fake image
if(isset($_POST["create_case"])) {
    $target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["file1"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $check = getimagesize($_FILES["file1"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}
?>