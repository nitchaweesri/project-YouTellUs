<div style="height:70px"></div>
    <div class="container mb-4 mb-5 col-lg-6 col-md-12 col-sm-12" align="center" id="menu">
    <div style="height: 195px; padding: 70px 15px;">
        <h3 class="text-secondary text-right Bold txt-menu-topic"><?php echo constant('หมายเลขโทรศัพท์สำหรับรับรหัส OTP') ?></h3>
    </div>
        <form action="index.php?page=otp" method="post" class="needs-validation col-lg-7 col-md-12 col-sm-12" id="demo-form" novalidate>
            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
            <input type="hidden" name="action" value="validate_captcha">
        
            <div class="form-group">
                <input name="tel" type="text" class="form-control" id="tell" placeholder="<?php echo constant('หมายเลขโทรศัพท์มือถือ') ?>" required pattern="^0([8|9|6])([0-9]{8}$)">
            </div>
            <?php  if (isset($_REQUEST['msg'])&&$_REQUEST['msg']=='expired') { ?>
                <div class="form-group">
                    <label for="exampleInputEmail1" class="text-danger" style="float: left;"><?php echo constant('คุณไม่ใส่ OTP ในระยะเวลาที่กำหนด กรุณาทำรายการใหม่อีกครั้ง') ?></label>
                </div> 
            <?php } ?>
            
            <div class="form-group" style="float: center;">
                <div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="6LfFReQZAAAAAD3Mr4HAkoY37Xvh7Bx3B0_HwKg-"></div>
            </div>
            
            <div class="row" align="center" style="display: inline;">
                <div class="col-lg-7 col-md-8 col-sm-10">
                    <div class="col d-flex justify-content-center">
                        <button type="submit" id='makesession' class="btn btn-primary rounded-pill Bold col-12 btn-verify"><?php echo constant('ขอรหัส OTP')?></button>
                    </div>
                </div>
            </div>
            
        </form>
    </div>
    <footer class="footer">
        <p class="txt-policy Bold"><?php echo constant('นโยบายความเป็นส่วนตัวธนาคารไทยพาณิชย์ จำกัด (มหาชน)') ?></p>
        <a href="https://www.scb.co.th/th/personal-banking/privacy-notice.html" target="_blank" class="policy Bold"><?php echo constant('คลิก') ?></button>
        <!-- <button class="policy" onclick="policy()">คลิก</button> -->
    </footer>
</div>
<?php 
    if($_SESSION['lang'] == 'th'){
        echo("<script src='https://www.google.com/recaptcha/api.js?hl=th ' async defer ></script>");
    }else{
        echo("<script src='https://www.google.com/recaptcha/api.js?hl=en ' async defer ></script>");
    }
?>
<script>
$(document).ready(function() {

    // $('#makesession').prop('disabled', true);
    // document.getElementById("makesession").style.display = "none";

    $('#exampleModal').on('show.bs.modal', function (event) {
            var modal = $(this)
            if('<?php echo $_SESSION['form']?>' == 'GN'){
                var string = '<?php echo constant('ท่านมีสำเนาบัตรประจำตัวประชาชนเพื่อใช้ประกอบข้อร้องเรียนหรือไม่') ?>'
            }else if('<?php echo $_SESSION['form']?>' == 'JP'){
                var string = `<div class="Bold"><?php echo constant('ท่านมีสำเนาบัตรประจำตัวประชาชนเพื่อใช้ประกอบข้อร้องเรียนหรือไม่') ?></div><br>
                            <ul>
                                <li><?php echo constant('สำเนาบัตรประจำตัวประชาชนของเจ้าของบัญชี') ?></li>
                                <li><?php echo constant('สำเนาบัตรประจำตัวประชาชนของผู้รับมอบอำนาจ') ?></li>
                                <li><?php echo constant('หนังสือมอบอำนาจ') ?></li>
                            </ul>
                         `
            }else if('<?php echo $_SESSION['form']?>' == 'OT'){
                var string = `<div class="Bold"><?php echo constant('ท่านมีสำเนาบัตรประจำตัวประชาชนเพื่อใช้ประกอบข้อร้องเรียนหรือไม่') ?></div><br>
                            <ul>
                                <li><?php echo constant('สำเนาบัตรประจำตัวประชาชนของผู้มีอำนาจลงนาม') ?></li>
                                <li><?php echo constant('สำเนาบัตรประจำตัวประชาชนของผู้รับมอบอำนาจ') ?></li>
                                <li><?php echo constant('สำเนาหนังสือรับรองนิติบุคคล (อายุไม่เกิน 6 เดือน)') ?></li>
                                <li><?php echo constant('หนังสือมอบอำนาจ') ?></li>
                             </ul>
                         `
            }
            modal.find('#success').css('display','block')
            modal.find('.modal-title').text('')
            modal.find('.modal-body').prepend($(`
                    <div class="row">
                        <div class="col">
                            <div class="Bold text-left" style="font-size: 21px;">`+string+`</div>
                        </div>
                    </div>`
                ));
            // modal.find('#one').          
            })
        if('<?php echo $_SESSION['form']?>' != 'RF'){
            $('#exampleModal').modal('show')
        }
        
});
function policy() {
    $('#modal-policy').on('show.bs.modal', function (event) {
            var modal = $(this)
            modal.find('.modal-title').text('ข้อกำหนดการใช้บริการและนโยบายความเป็นส่วนตัว')
            })
        $('#modal-policy').modal('show')
};
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {Teq
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

$('#makesession').on('click', function () {
    $.ajax({
        type: "POST",
        url: 'controllers/sessionCreate.php',
        data:{"name": "countStart","value":new Date().getTime()}
        // data: {sessionJson: { countStart :'countStartvalue1' , countStart1: 'countStar1tvalue1'}}
    }); 
    $.ajax({
        type: "POST",
        url: 'controllers/sessionCreate.php',
        data:{"name": "phoneNo","value":$('#tell').val()}
        // data: {sessionJson: { countStart :'countStartvalue1' , countStart1: 'countStar1tvalue1'}}
    }); 
    var countMistake = '<?php echo isset($_SESSION['countMistake'])? $_SESSION['countMistake']: '';?>';

    if (countMistake == '') {
        $.ajax({
        type: "POST",
        url: 'controllers/sessionCreate.php',
        data:{"name": "countMistake","value":"0"}
        // data: {sessionJson: { countStart :'countStartvalue1' , countStart1: 'countStar1tvalue1'}}
    }); 
    }

    // window.location.href = 'index.php?page=otp'; 
    
    });


function recaptchaCallback() {
    // $('#makesession').prop('disabled', false);
    document.getElementById("makesession").style.display = "block";
};




</script>