<?php 

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = 'scbytu_dev';
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }else{
        if ($_SESSION['phoneNo']) {
            $sql = "SELECT `YTU_REQFILE`.`REQFILEID` FROM `YTU_REQFILE`
                    INNER JOIN `CASEINFO` ON `CASEINFO`.`CASEID` = `YTU_REQFILE`.`CASEID`
                    WHERE `SOCIAL_CUSTID` = '" . $_SESSION['phoneNo'] . "'";
            $result = mysqli_query($conn, $sql);
            
            if (!$result) {
                printf("Error: %s\n", mysqli_error($conn));
                exit();
            }else{
                if($result->num_rows != 0){
                    while ($row = mysqli_fetch_assoc($result)) {
                        $data = $row;
                    }
                    session_start();
                    $_SESSION['reqfileID'] = $data["REQFILEID"];
    
                    echo json_encode(1); 
                }else{
                    echo json_encode(0); 
                }
            }
        }
    }


?>