<?php 

    include '../database/model/database.php';

    $tel = $_POST['tel'];
    if (isset($tel)) {
        $sql = "SELECT `YTU_REQFILE`.`RECID` FROM `YTU_REQFILE`
                INNER JOIN `CASEINFO` ON `CASEINFO`.`CASEID` = `YTU_REQFILE`.`CASEID`
                WHERE `SOCIAL_CUSTID` LIKE '$tel'
                    AND `YTU_REQFILE`.`RECSTATUS` = 'A'
                    AND `YTU_REQFILE`.`EXPIRED_DT` > NOW()";
        $result = $conn->query($sql);
        
        if (!$result) {
            printf("Error: %s\n", mysqli_error($conn));
            exit();
        }else{
            if($result->num_rows != 0){
                while ($row = mysqli_fetch_assoc($result)) {
                    $data = $row;
                }
                session_start();
                $_SESSION['reqfileID'] = $data["RECID"];
                $_SESSION['pending'] = "1";

                echo json_encode(1); 
            }else{
                echo json_encode(0);
            }
        }
    }
    


?>