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
        
        <?php /* ?>    
        <!-- <div class="d-flex justify-content-center">
            <img src="public/img/captcha.png" alt="captcha" width="320" height="140">
        </div> -->
        <!-- <div class="row mt-3">
            <div class="col d-flex justify-content-center">
                <button type="submit" class="btn btn-primary rounded-pill  Regular col-12 g-recaptcha" data-sitekey="6Ldbad4ZAAAAABNqGumBSri1FZbN83i-wnANG_PD" 
        data-callback='onSubmit' data-action='submit'>ส่งรหัส OTP</button>
            </div>
        </div> -->
        <?php */ ?>
        
        <div class="row" align="center" style="display: inline;">
            <div class="col-lg-7 col-md-8 col-sm-10">
                <div class="col d-flex justify-content-center">
                    <button type="submit" id='makesession' class="btn btn-primary rounded-pill  Regular col-12" style="width: "><?php echo constant('ส่งรหัส OTP')?></button>
                </div>
            </div>
        </div>
        
    </form>
    
    <?php /* ?>
    <!-- 
    <button class="g-recaptcha" 
        data-sitekey="6Ldbad4ZAAAAABNqGumBSri1FZbN83i-wnANG_PD" 
        data-callback='onSubmit' 
        data-action='submit'>Submit</button> 
    -->
    <?php */ ?>
        
</div>






<!-- <script src="https://www.google.com/recaptcha/api.js"></script> -->
<!-- <script src="https://www.google.com/recaptcha/api.js?render=6Ldbad4ZAAAAABNqGumBSri1FZbN83i-wnANG_PD"></script> -->
<script>
    // grecaptcha.ready(function() {
    //     grecaptcha.execute('6Ldbad4ZAAAAABNqGumBSri1FZbN83i-wnANG_PD', {action:'validate_captcha'}).then(function(token) {
    //         // add token value to form
    //         document.getElementById('g-recaptcha-response').value = token;
    //     });
    // });


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



$(document).ready(function(){
    localStorage.setItem('firstime','true');

    var langSession = '<?php echo isset($_SESSION['lang'])? 'TRUE' : 'FALSE' ?>';
    
    if (langSession == 'FALSE') {
        $('#exampleModal').on('show.bs.modal', function (event) {
            var modal = $(this)
            modal.find('.modal-title').text('เลือกภาษา')
            modal.find('.modal-body').prepend($(` <div class="row">
                <div class="col">
                    <a <?php echo (@$lang == 'th') ? 'class="se"':'' ; ?> onclick="setGetParameter('lang','th')">
                        <img src="public/img/thailand.svg" alt="">
                    </a>
                </div>
                <div class="col">
                    <a <?php echo (@$lang == 'en') ? 'class="se"':'' ; ?> onclick="setGetParameter('lang','en')">
                        <img src="public/img/united-states.svg" alt="">
                    </a>
                    </div>
                </div>`
                ));
            modal.find('.modal-footer').text('')
            
            })
        $('#exampleModal').modal('show')
    }
    
});

</script>