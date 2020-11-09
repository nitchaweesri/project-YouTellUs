<?php 
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = 'scbytu_dev';
     $conn = new mysqli($servername, $username, $password, $dbname);
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }else{
        $sql = "SELECT ytu_reqfile.filereq, ytu_reqfile.reqfileid, caseinfo.feedtitle 
                FROM ytu_reqfile
                INNER JOIN caseinfo ON caseinfo.caseid = ytu_reqfile.caseid
                WHERE ytu_reqfile.reqfileid = '" . $_SESSION['reqfileID'] . "'
                    AND ytu_reqfile.status = 1
                    AND ytu_reqfile.expirydate > NOW()";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($conn));
            exit();
        }else{
            while ($row = mysqli_fetch_assoc($result)) {
                $data = $row;
            }
            $fileReq = explode(",",$data["filereq"]);
        }
     }
?>
<style>
button {
    font-family: 'Mitr-Regular';
}

.topic {
    font-family: 'Mitr-Medium';
    font-size: 20px;
    margin: 0;
}

.detail {
    font-family: 'Mitr-Light';
    font-size: 14px;
}

.form-list {
    /* border-bottom: 1px solid #cecece; */
    padding-bottom: 25px;
    padding-top: 12px;
}
.div-files{
    margin-top: 25px;
}
</style>


<div class="container p-3 mb-5 bg-white pd-top">
    <form>
        <div class="form-list">
            <p class="topic text-primary"><?php echo($data["feedtitle"]) ?></p>
            <?php foreach ($fileReq as $value) { ?>
                <div class="div-files">
                    <p class="detail text-primary"><?php echo($value) ?></p>
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <button type="submit" class="btn btn-primary">อัพโหลด</button>
    </form>

</div>