<!DOCTYPE html>
<html lang="en">
<?php    
 $msg = isset($_REQUEST['msg'])? $_REQUEST['msg']: isset($msg)? $msg: '';
// include 'controllers/block.php';


foreach ($result->select_block() as $key => $value) {
    $expired = $value['EXPIRED_DT'];
}

// $block = new block;
$now = strtotime(date('Y-m-d H:i:s'));
if($now >= strtotime($expired) ){
    $result->delete_block();
}

?>
<style>
    #main {
        /* background-image: url("public/img/bg-thanks.png"); */
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
        <div class="row mb-8">
            <div class="col">
                <h5 class="text-primary text-center" id="msg"><?php echo $msg?></h5>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <a href="index.php?page=1" class="text-primary d-flex justify-content-center">กลับหน้าแรก</a>
            </div>
        </div>
    </div>
</body>




<script>

var expired = '<?php echo $expired ?>';
// Set the date we're counting down to
var countDownDate = new Date(expired).getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("msg").innerHTML = minutes + "m " + seconds + "s ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("msg").innerHTML = "EXPIRED";
  }
}, 1000);
</script>
</html>
