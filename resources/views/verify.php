<style>
@media (min-width: 1025px) and (max-width: 1960px) {
    .container {
        padding: 0px 306px !important;
    }
}

@media (min-width: 768px) and (max-width: 1024px) {
    .container {
        padding: 0px 210px !important;
    }
}

@media (min-width: 320px) and (max-width: 767px) {}
</style>

<div class="container mb-4 p-4 mb-5 bg-white rounded pd-top">
    <form action="index.php?page=otp" method="post" class="needs-validation" id="demo-form" novalidate>
        <div class="form-group">
            <label for="exampleInputEmail1">หมายเลขโทรศัพท์สำหรับรับรหัส OTP</label>
            <input name="tel" type="text" class="form-control" id="tell" placeholder="หมายเลขโทรศัพท์" required pattern="^0([8|9|6])([0-9]{8}$)">
        </div>
        <?php  if (isset($_REQUEST['msg'])&&$_REQUEST['msg']=='expired'){ ?>
            <div class="form-group">
                <label for="exampleInputEmail1" class="text-danger">คุณไม่ใส่ OTP ในระยะเวลาที่กำหนด กรุณาทำรายการใหม่อีกครั้ง</label>
            </div> 
        <?php }?>
            
        <!-- <div class="d-flex justify-content-center">
            <img src="public/img/captcha.png" alt="captcha" width="320" height="140">
        </div> -->
        <!-- <div class="row mt-3">
            <div class="col d-flex justify-content-center">
                <button type="submit" class="btn btn-primary rounded-pill  Regular col-12 g-recaptcha" data-sitekey="6Ldbad4ZAAAAABNqGumBSri1FZbN83i-wnANG_PD" 
        data-callback='onSubmit' data-action='submit'>ส่งรหัส OTP</button>
            </div>
        </div> -->
        <div class="row mt-3">
            <div class="col d-flex justify-content-center">
                <button type="submit" id='makesession' class="btn btn-primary rounded-pill  Regular col-12">ส่งรหัส OTP</button>
            </div>
        </div>
    </form>
    <!-- <button class="g-recaptcha" 
        data-sitekey="6Ldbad4ZAAAAABNqGumBSri1FZbN83i-wnANG_PD" 
        data-callback='onSubmit' 
        data-action='submit'>Submit</button> -->
</div>

<!-- <script src="https://www.google.com/recaptcha/api.js"></script> -->
<script>
    // function onSubmit(token) {
    //     document.getElementById("demo-form").submit();
    // }

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
            url: 'controllers/sessionWrite.php',
            data:{"name": "countStart","value":new Date().getTime()}
            // data: {sessionJson: { countStart :'countStartvalue1' , countStart1: 'countStar1tvalue1'}}
        }); 
        $.ajax({
            type: "POST",
            url: 'controllers/sessionWrite.php',
            data:{"name": "phoneNo","value":$('#tell').val()}
            // data: {sessionJson: { countStart :'countStartvalue1' , countStart1: 'countStar1tvalue1'}}
        }); 
        var countMistake = '<?php echo isset($_SESSION['countMistake'])? $_SESSION['countMistake']: '';?>';

        if (countMistake == '') {
            $.ajax({
            type: "POST",
            url: 'controllers/sessionWrite.php',
            data:{"name": "countMistake","value":"0"}
            // data: {sessionJson: { countStart :'countStartvalue1' , countStart1: 'countStar1tvalue1'}}
        }); 
        }
        
    });
});

</script>