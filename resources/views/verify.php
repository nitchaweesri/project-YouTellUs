

<div class="container mb-4 p-4 mb-5 bg-white rounded pd-top" align="center">
    <form action="index.php?page=otp" method="post" class="needs-validation col-lg-7 col-md-12 col-sm-12" id="demo-form" novalidate>
        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
        <input type="hidden" name="action" value="validate_captcha">
       
        <div class="form-group">
            <label for="exampleInputEmail1" style="float: left;"><?php echo constant('หมายเลขโทรศัพท์สำหรับรับรหัส OTP') ?></label>
            <input name="tel" type="text" class="form-control" id="tell" placeholder="<?php echo constant('หมายเลขโทรศัพท์') ?>" required pattern="^0([8|9|6])([0-9]{8}$)">
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
                    <button type="submit" id='makesession' class="btn btn-primary rounded-pill  Regular col-12" style="width: "><?php echo constant('ส่งรหัส OTP')?></button>
                </div>
            </div>
        </div>
        
    </form>
</div>
<footer class="footer">
    <button class="policy" onclick="policy()">ข้อกำหนดการใช้บริการ | นโยบายความเป็นส่วนตัว</button>
</footer>


<script src='https://www.google.com/recaptcha/api.js' async defer ></script>
<script>
$(document).ready(function() {
    // $('#makesession').prop('disabled', true);
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
        var validation = Array.prototype.filter.call(forms, function(form) {
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

$(function () {
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
});


function recaptchaCallback() {
    $('#makesession').prop('disabled', false);
};




</script>