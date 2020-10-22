<!DOCTYPE html>
<html lang="en">
<?php include 'header.php';?>
<style>
#menu {
    background-image: url("public/img/bg1.png");
    background-repeat: no-repeat;
    background-size: 200px;
}
</style>

<body>
    <?php include 'navbar.php';?>
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
        <div class="row mt-3">
            <div class="col">
                <a href="form1"
                    class="btn btn-lg btn-outline-primary rounded d-flex justify-content-center Regular">ร้องเรียนทั่วไป</a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col ">
                <a href="form2"
                    class="btn btn-lg btn-outline-primary rounded d-flex justify-content-center Regular">ร้องเรียนแทนบุคคลอื่น</a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col ">
                <a href="form3"
                    class="btn btn-lg btn-outline-primary rounded d-flex justify-content-center Regular">ร้องเรียนในนามนิติบุคคล</a>
            </div>
        </div>
    </div>

</body>


</html>