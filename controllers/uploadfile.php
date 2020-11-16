<?php
    $currentDirectory = getcwd();
    $uploadDirectory = "/uploads/file/";

    $errors = []; // Store errors here

    // $fileExtensionsAllowed = ['jpeg','jpg','png']; // These will be the only file extensions allowed 

    if (isset($_POST['create_case'])) {

      $total = count($_FILES['file']['name']);
      for( $i=0 ; $i < $total ; $i++ ) {
        $fileName = $_FILES['file']['name'][$i];
        $fileSize = $_FILES['file']['size'][$i];
        $fileTmpName  = $_FILES['file']['tmp_name'][$i];
        $fileType = $_FILES['file']['type'][$i];
        // $fileExtension = strtolower(end(explode('.',$fileName)));

        $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName); 


          // if (! in_array($fileExtension,$fileExtensionsAllowed)) {
          //   $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
          // }

          if ($fileSize > 4000000) {
            $errors[] = "File exceeds maximum size (4MB)";
          }

          if (empty($errors)) {
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

            if ($didUpload) {
              $msg = "The file " . basename($fileName) . " has been uploaded";
              $file[$i] = basename($fileName);
            } else {
              $msg = "An error occurred. Please contact the administrator.";
            }
          } else {
            foreach ($errors as $error) {
              $msg = $error . "These are the errors" . "\n";
            }
          }

        }
  }
?>