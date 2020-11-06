<?php 

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = 'scbytu_dev';
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_POST['tel']) {
        $sql = "SELECT caseinfo.caseid FROM ytu_reqfile
                INNER JOIN caseinfo ON caseinfo.caseid = ytu_reqfile.caseid
                WHERE social_custid = '" . $_POST['tel'] . "'";
        $result = mysqli_query($conn, $sql);
        
        if (!$result) {
            printf("Error: %s\n", mysqli_error($conn));
            exit();
        }else{
            if($result->num_rows != 0){
                echo json_encode(1); 
            }else{
                echo json_encode(0); 
            }
        }
    }

?>