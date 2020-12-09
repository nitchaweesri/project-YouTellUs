<?php 
    include 'database/model/database.php';

     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }else{
       
        print_r($_SESSION['phoneNo']);
        $sql = "SELECT YTU_REQFILE.CASEID
                FROM `YTU_REQFILE`
                INNER JOIN `CASEINFO` ON `CASEINFO`.`CASEID` = `YTU_REQFILE`.`CASEID`
                WHERE `YTU_REQFILE`.`MOBILENO` = '" . $_SESSION['phoneNo'] . "'
                    AND `YTU_REQFILE`.`RECSTATUS` = 'A'
                    AND `YTU_REQFILE`.`EXPIRED_DT` > NOW()";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($conn));
            exit();
        }else{
            echo($result);
            while ($row = mysqli_fetch_assoc($result)) {
                $data = $row;
                print_r($data);
                exit;
            }
            $fileReq = explode(",",$data["FILEDESC"]);
        }
     }
?>
<style>
    .menu {
        background-image: url("public/img/thankyou_smile.png");
        background-repeat: no-repeat;
        background-size: 200px;
    }
</style>
<div style="height:80px"></div>
<div class="container menu mb-4 col-lg-7 col-md-12 col-sm-12" id="menu">
    <div class="row justify-content-end">
        <div class="col-8 ">
            <h3 class="text-secondary text-right mt-5 Regular mb-4">เมนูหลัก</h3>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h6 class="">

            </h6>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col mb-2">
            <a href="index.php?page=upload"
                class="btn btn-lg btn-primary rounded d-flex justify-content-center Regular" style="color: #fff !important; padding: 17px;"><?php echo constant('อัพโหลดไฟล์เอกสาร') ?></a>
        </div>
    </div>
    <div class="row mt-3 mb-2">
        <div class="col ">
            <a href="index.php?page=2"
                class="btn btn-lg btn-primary rounded d-flex justify-content-center Regular" style="color: #fff !important; padding: 17px;"><?php echo constant('ร้องเรียน') ?></a>
        </div>
    </div>
</div>