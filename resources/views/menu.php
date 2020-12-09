<?php 
include 'controllers/case.php';
$result = ytu_complainttype();
// session_start();
?>
<style>
.bt-unset {
    position: absolute;
    bottom: 0px;
    right: 0px;
}

a.textunset {
    color: #EEE;
    text-decoration: none;
    background-color: transparent;
    text-transform: none;
}
</style>
<div style="height:70px"></div>
<div class="container mb-4 col-lg-6 col-md-12 col-sm-12" id="menu">
    <input type="hidden" name="test" value="<?php echo $_SESSION['lang'] ?>">
    <div class="row justify-content-end">
        <div class="col-lg-8 col-md-11 col-sm-11" style="height: 195px; padding: 70px 15px;">
            <h1 class="text-secondary text-right Bold txt-menu-topic"><?php echo constant('กรุณาระบุ')?> </h1>
            <h1 class="text-secondary text-right Bold txt-menu-topic"><?php echo constant('ประเภทการร้องเรียน')?> </h1>
        </div>
    </div>
    <div class="container-btn-menu">
        <?php
        foreach ($result as $key => $value) {
            $page_vl = $value['COMPLAINTCODE'];
            $name_vl = $value['COMPLAINTTITLE_'.strtoupper(isset($_SESSION['lang']) ? $_SESSION['lang'] : 'th')];
        ?>
        <div class="row mt-3 justify-content-md-center justify-content-sm-center">
            <div class="col-lg-11 col-md-8 col-sm-10 mb-2">
                <a id="goForm<?php echo $key ?>" href="index.php?page=verify"
                    class="btn btn-lg rounded d-flex justify-content-center Bold btn-menu">
                    <?php echo $name_vl?>
                </a>
            </div>
        </div>

        <script>
        $('#goForm' + '<?php echo $key ?>').on('click', function() {
            $.ajax({
                type: "POST",
                url: 'controllers/sessionCreate.php',
                data: {
                    "name": "form",
                    "value": '<?php echo $page_vl  ?>'
                }
                // data: {sessionJson: { countStart :'countStartvalue1' , countStart1: 'countStar1tvalue1'}}
            });
        });
        </script>

        <?php } ?>
        <!-- <div class="row mt-3 justify-content-md-center justify-content-sm-center">
            <div class="col-lg-11 col-md-8 col-sm-10 mb-2">
                <a id="goFormReq" href="index.php?page=verify"
                    class="btn btn-lg rounded d-flex justify-content-center Bold btn-menu">
                    ส่งเอกสารเพิ่มเติม
                </a>
            </div>
        </div> -->
    </div>


</div>
<div class="bt-unset">
    <a class="textunset" href="index.php?re_session=unset"> UNSET SESSION </a>
</div>



<script>
$(document).ready(function() {

    localStorage.setItem('firstime', 'true');

    var langSession = '<?php echo isset($_SESSION['lang'])? 'TRUE' : 'FALSE' ?>';

    if (langSession == 'FALSE') {
        $('#exampleModal').on('show.bs.modal', function(event) {
            var modal = $(this)
            modal.find('#success').css('display', 'block')
            modal.find('.modal-title').text('เลือกภาษา')
            modal.find('.modal-body').prepend($(` 
            <div class="row">
                <div class="col mr-0 pr-0">
                    <a onclick="langFunc('th')">
                        <div class="img-hover-zoom">
                            <img class="img-lang" src="public/img/thailand.svg" width="70px" alt="">
                        </div>
                    </a>
                    <div class="row">
                        <h7 class="mx-auto mt-2 Bold" style="font-size: 20px;">ไทย</h7>
                    </div>
                </div>
                <div class="col ml-0 pl-0">
                    <a onclick="langFunc('en')">
                        <div class="img-hover-zoom"  >
                            <img class="img-lang" src="public/img/united-states.svg" width="70px" alt="">
                        </div>
                    </a>
                    <div class="row">
                        <h7 class="mx-auto mt-2 Bold" style="font-size: 20px;">อังกฤษ</h7>
                    </div>
                </div>
            </div>`));
            modal.find('.modal-footer').text('')

        })
        $('#exampleModal').modal('show')
    }

    $('#goFormReq').on('click', function() {
        $.ajax({
            type: "POST",
            url: 'controllers/sessionCreate.php',
            data: {
                "name": "form",
                "value": 'RF'
            }
        });
    });

});



function langFunc(lang) {

    $.ajax({
        type: "POST",
        url: 'controllers/sessionCreate.php',
        data:{ name: 'lang', value: lang}
    }); 
    location.reload();
}

</script>
