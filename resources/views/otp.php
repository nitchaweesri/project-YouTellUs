<style>
    a { color: black; font-size: 13px; color: #495057; }
    .img-refresh-otp { width: 13px; height: 13px; margin-bottom: 3px; }
    .text-alert { display: none; font-size: 14px; }
</style>
<?php include 'config.php'; ?>
<div class="container mb-4 pt-5 mt-5 mb-5 bg-white rounded otp-pd-top" align="center">
    <div class="col-lg-7 col-md-12 col-sm-12">
        <div class="form-group">
            <label for="exampleInputEmail1" style="float: left;">กรอกรหัส OTP</label>
            <input type="text" class="form-control mb-2" id="otp" placeholder="รหัส OTP" required>

            <?php  if (isset($_REQUEST['msg'])&&$_REQUEST['msg']=='pwd'){ ?>
                <div class="form-group">
                    <label for="exampleInputEmail1" class="text-danger" style="float: left;">รหัส OTP ไม่ถูกต้อง</label>
                </div> 
            <?php }?>
       
           
            <div class="d-flex justify-content-between col-lg-12 col-md-12 col-sm-12 p-0">
                <a href="" onclick="reotp()"><img src="public/img/refresh1.png" class="img-refresh-otp" alt="refresh"> ส่งรหัส OTP ใหม่อีกครั้ง</a>
                <a id="countdown" class="Light"></a>
            </div>
                
        </div>
        <div class="row" align="center" style="display: inline;">
        	<div class="col-lg-7 col-md-8 col-sm-10">
                <div class="col d-flex justify-content-center">
                    <button type="submit" onclick="checkotp()" class="btn btn-primary rounded-pill  Regular col-12">ส่งรหัส OTP</button>
                </div>
            </div>
        </div>
    </div>    
</div>

<div id="myModal" class="modal" style="background: #343a408c;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" style="padding: 5px;">&times;</button>
      </div>
      <div class="modal-body">
        <div style="font-size: 13px;">ใช้  &lt;OTP 1234&gt; &lt;Ref.<?php echo @$_SESSION['phoneNo']; ?>&gt; ใน 2 นาที ห้ามบอก OTP นี้แก่ผู้อื่นไม่ว่ากรณีใด</div>
      </div>
    </div>
  </div>
</div>

<footer class="footer">
    <label>ข้อกำหนดการใช้บริการ | นโยบายความเป็นส่วนตัว</label>
</footer>

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


<script>
var modal = document.getElementById("myModal");
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0];

function myPopUP() {
	modal.style.display = "block";
}
span.onclick = function() {
  modal.style.display = "none";
}
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

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


var how = '<?php echo TIME_OTP?>';
var countStart = '<?php echo $_SESSION['countStart'];?>';
var timeleft = new Date().getTime() - countStart;
var second = Math.floor((timeleft % (1000 * 60)) / 1000);
var downloadTimer = setInterval(function(){
  if(second >= how){
    clearInterval(downloadTimer);
    var oldmistake = parseInt('<?php echo $_SESSION['countMistake'];?>');
    var newmistake = oldmistake+=1;

    $.ajax({
        type: "POST",
        url: 'controllers/sessionCreate.php' ,
        data:{"name": "countMistake","value":newmistake}
        // data: {sessionJson: { countStart :'countStartvalue1' , countStart1: 'countStar1tvalue1'}}
    }); 
    window.location.href = 'index.php?page=verify&msg=expired'; 


  } else {
    var timeleft = how-second;
    document.getElementById("countdown").innerHTML = "โปรดใส่รหัสก่อน " +timeleft + " วินาที" ;
  }
  second += 1;
}, 1000);

function reotp() {

    var oldmistake = parseInt('<?php echo $_SESSION['countMistake'];?>');
    var newmistake = oldmistake+=1;
  
    $.ajax({
        type: "POST",
        url: 'controllers/sessionCreate.php',
        data:{"name": "countStart","value":new Date().getTime()}
        // data: {sessionJson: { countStart :'countStartvalue1' , countStart1: 'countStar1tvalue1'}}
    }); 
    $.ajax({
        type: "POST",
        url: 'controllers/sessionCreate.php' ,
        data:{"name": "countMistake","value":newmistake }
        // data: {sessionJson: { countStart :'countStartvalue1' , countStart1: 'countStar1tvalue1'}}
    }); 


    // if (parseInt(sessionStorage.getItem('countMistake'))>3) {
    //     window.location.href = 'index.php?page=error';
    // }
    window.location.href = 'index.php?page=otp&msg=pwd';    
}

function checkotp(params) {
    if ($('#otp').val()!='1234') {
        var oldmistake = parseInt('<?php echo $_SESSION['countMistake'];?>');
        var newmistake = oldmistake+=1;
        
    
        $.ajax({
            type: "POST",
            url: 'controllers/sessionCreate.php',
            data:{"name": "countMistake","value":newmistake }
            // data: {sessionJson: { countStart :'countStartvalue1' , countStart1: 'countStar1tvalue1'}}
        });

        window.location.href = 'index.php?page=otp&msg=pwd';
        
        
        
    
    } else {
        var oldmistake = parseInt('<?php echo $_SESSION['countMistake'];?>');
        var newmistake = oldmistake+=1;
    
        $.ajax({
            type: "POST",
            url: 'controllers/sessionCreate.php' ,
            data:{"name": "logOn","value":"true" }
            // data: {sessionJson: { countStart :'countStartvalue1' , countStart1: 'countStar1tvalue1'}}
        }); 
        

        ///////////////////   check require file    ///////////////////
        $.ajax({
            url:"controllers/checkPending.php",
            type: "POST",
            data:{"tel": "<?php echo($_SESSION['phoneNo']) ?>"},
            success:function(data){
                // alert(data);
                if(data == '0'){
                    // alert('null');
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
