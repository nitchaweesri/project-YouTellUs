<?php
    include 'config.php';

    $currentDirectory = getcwd();
    $uploadDirectory = "/uploads/file/";

    $errors = []; // Store errors here
    $fileExtensionsAllowed = EXTENSION_ALLOW; 

    if (isset($_POST['create_case'])) {
      // die(print_r($_FILES['file']['name']));
      foreach( $_FILES['file']['name'] as $i => $value ) {
        if ($_FILES['file']['name'][$i] !='' ) {
          $fileName = $_FILES['file']['name'][$i];
          $fileSize = $_FILES['file']['size'][$i];
          $fileTmpName  = $_FILES['file']['tmp_name'][$i];
          $fileType = $_FILES['file']['type'][$i];

          $fileExtension = strtolower(explode('.',$fileName)[1]);
          $fileExtension = str_replace(' ', '', $fileExtension);

          $uploadPath = $currentDirectory . $uploadDirectory . $fileName; 

            if (! in_array($fileExtension,$fileExtensionsAllowed)) {
              $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";

            }



            if ($fileSize > FILE_SIZE_ALLOW) {
              $errors[] = "File exceeds maximum size (".FILE_SIZE_ALLOW."MB)";
            }


            if (empty($errors)) {

              $sur = strrchr($fileName, "."); //ตัดนามสกุลไฟล์เก็บไว้
              $newfilename = $_SESSION['phoneNo'].(Date("dmy_His").$i.$sur); //ผมตั้งเป็น วันที่_เวลา.นามสกุล
              $didUpload = copy($fileTmpName,$currentDirectory . $uploadDirectory.$newfilename); //แล้วค่อยเก็บลงไฟล์
            
              // $didUpload = move_uploaded_file($fileTmpName, $uploadPath);  //ไม่เปลี่ยนชื่อ

              if ($didUpload) {


                $msg = "The file " . $fileName . " has been uploaded";
                $file[$i] = $fileName;
                $linkFile[$i] = $newfilename;

              } 
              else {
                $msg = "An error occurred. Please contact the administrator.";
              }
            } 
            // else {
            //   foreach ($errors as $error) {
            //     $msg = $error . "These are the errors" . "\n";
                
            //   }
            // }
          }
        

        }
  }
?>