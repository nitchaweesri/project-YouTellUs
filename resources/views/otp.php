<style>
    a{
        color: black;
        font-size: 13px;
        color: #495057;
    }
    .img-refresh-otp{
        width: 13px;
        height: 13px;
        margin-bottom: 3px;
    }
    .text-alert{
        display: none;
        font-size: 14px;
    }
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
    <!-- <form action="index.php?page=2" method="post" class="needs-validation" novalidate> -->
        <div class="form-group">
            <label for="exampleInputEmail1">กรอกรหัส OTP</label>
            <input type="text" class="form-control mb-2" id="otp" placeholder="รหัส OTP" required>
            
            <div class="form-group text-alert" id="msg">
                <label class="text-danger">รหัส OTP ไม่ถูกต้อง</label>
            </div>
            <div class="d-flex justify-content-between">
                <a href=""><img src="public/img/refresh1.png" class="img-refresh-otp" alt="refresh" width="15"> ส่งรหัส OTP ใหม่อีกครั้ง</a>
                <a id="countdown" class="Light"></a>
            </div>
                
        </div>
        <div class="row mt-3">
            <div class="col d-flex justify-content-center">
                <button type="submit" onclick="checkotp()" class="btn btn-primary rounded-pill  Regular col-12">ส่งรหัส OTP</button>
            </div>
        </div>
    <!-- </form> -->
</div>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
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

var how = 30;
var timeleft = new Date().getTime() - localStorage.getItem('countStart');
var second = Math.floor((timeleft % (1000 * 60)) / 1000);
var downloadTimer = setInterval(function(){
  if(second >= how){
    clearInterval(downloadTimer);
    var oldmistake = localStorage.getItem('countMistake');
    localStorage.setItem('countMistake',oldmistake+=1);
    window.location.href = 'index.php?page=verify&msg=expired'; 

  } else {
    var timeleft = how-second;
    document.getElementById("countdown").innerHTML = "โปรดใส่รหัสก่อน " +timeleft + " วินาที" ;
  }
  second += 1;
}, 1000);

function checkotp(params) {
    if ($('#otp').val()!='1234') {
        var oldmistake = localStorage.getItem('countMistake')
        localStorage.setItem('countMistake',oldmistake+=1);
        document.getElementById('msg').style.display = 'flex';
        // $('#msg').html('รหัส OTP ไม่ถูกต้อง');
    } else {
        $.ajax({
            url:"controllers/checkPending.php",
            type: "POST",
            data:{"tel": "<?php echo($_POST['tel']) ?>"},
            success:function(data){
                if(data === '0'){
                    window.location.href = 'index.php?page=2';
                }else{
                    window.location.href = 'index.php?page=menuupload';
                }
            },error:function(){
                alert("error!!!!");
            }
        });
    }
}
</script>