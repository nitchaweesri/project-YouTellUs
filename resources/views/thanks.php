<?php
    session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<style>
    #main {
        background-image: url("public/img/bg-thanks.png");
        background-repeat: no-repeat;
        background-size: 320px;
        height: 100vh;
        background-position-x: right;
        background-position-y: center;
    }
    h2{
        font-family: 'Mitr-Medium' ,Fallback, sans-serif;
    }
    h5,a{
        font-family: 'Mitr-Regular', Fallback, sans-serif;
    }

</style>

<body>
    <div style="height:80px"></div>
    <div class="container" id="main">
        <div class="row mt-4">
            <div class="col">
                <h2 class="text-primary text-center">ขอบคุณค่ะ</h2>
            </div>
        </div>
        <div class="row mb-8">
            <div class="col">
                <h5 class="text-primary text-center">เราได้รับข้อมูลของคุณเรียบร้อยแล้ว</h5>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <a href="index.php?page=1&re_session=unset" class="text-primary d-flex justify-content-center" id="finish">กลับหน้าแรก</a>
            </div>
        </div>
    </div>
</body>

</html>