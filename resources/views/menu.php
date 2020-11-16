<?php 
include 'controllers/case.php';
$result = ytu_complainttype();
?>
<style>
    .bt-unset { position: absolute; bottom: 0px; right: 0px; }
    a.textunset { color: #EEE; text-decoration: none; background-color: transparent; text-transform: none; }
</style>
<div style="height:80px"></div>
<div class="container mb-4 col-lg-7 col-md-12 col-sm-12" id="menu">
    <div class="row justify-content-end">
        <div class="col-lg-8 col-md-10 col-sm-10">
            <h3 class="text-secondary text-right mt-4 Regular mb-4">กรุณาระบุประเภทการร้องเรียน</h3>
        </div>
    </div>
    <?php 
    foreach ($result as $key => $value) {
        $page_vl = $value['COMPLAINTCODE'];
        $name_vl = $value['COMPLAINTTITLE_'.strtoupper(isset($_SESSION['lang']) ? $_SESSION['lang'] : 'th')];
        echo '<div class="row mt-3 justify-content-md-center justify-content-sm-center">
                <div class="col-lg-8 col-md-8 col-sm-10 mb-2">
                    <a href="index.php?page='. $page_vl .'" class="btn btn-lg btn-primary rounded d-flex justify-content-center Regular" style="color: #fff !important; padding: 17px;">
                        '. $name_vl .'
                    </a>
                </div>
            </div>';
    }
    ?>

</div>
<div class="bt-unset">
	<a class="textunset" href="index.php?re_session=unset"> UNSET SESSION </a>
</div>