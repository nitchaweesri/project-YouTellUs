
<?php 
include 'controllers/case.php';
$result = ytu_complainttype();
?>
<div style="height:80px"></div>
<div class="container mb-4 col-lg-7 col-md-12 col-sm-12" id="menu">
    <div class="row justify-content-end">
        <div class="col-8 ">
            <h2 class="text-secondary text-right mt-5 Regular">กรุณาระบุประเภทการร้องเรียน</h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h6 class="">


            </h6>
        </div>
    </div>
    <?php 
    foreach ($result as $key => $value) {
        echo '<div class="row mt-3">
                <div class="col ">
                    <a href="index.php?page='.$value['COMPLAINTCODE'].'"
                        class="btn btn-lg btn-outline-primary rounded d-flex justify-content-center Regular">'
                        .$value['COMPLAINTTITLE_'.strtoupper(isset($_SESSION['lang'])? $_SESSION['lang'] : 'th')].
                        '</a>
                </div>
            </div>';
    }
    ?>
    
</div>
