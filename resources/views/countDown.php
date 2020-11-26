<!DOCTYPE html>
<html lang="en">
<?php    
 
//  $msg = isset($_REQUEST['msg'])? $_REQUEST['msg']: isset($msg)? $msg: '';
// include 'controllers/block.php';


foreach ($result->select_block() as $key => $value) {
    $expired = intval($value['EXPIRED_DT']);


}

// $block = new block;
$now = strtotime(date('Y-m-d H:i:s'));
if($now >= $expired){
    $result->delete_block();
    // unset($_SESSION['phoneNo']);
    header("Location: index.php?page=menu");
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
    .txt-block{
        font-size: 28px;
    }
    .txt-back{
        font-size: 22px;
        text-decoration: revert;
    }

</style>

<body>
    <div style="height:80px"></div>
    <div class="container" id="main">
        <div class="row mb-5">
            <div class="col">
                <h5 class="text-primary text-center Bold txt-block  mb-2 mt-3" id="msg"></h5>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <a href="index.php?page=condition" class="text-primary d-flex justify-content-center Bold txt-back"><?php echo constant('กลับหน้าแรก') ?></a>
            </div>
        </div>
    </div>
</body>


<script>


var expired = '<?php echo $expired ?>'*1000;

var downloadTimer = setInterval(function(){
    var timeleft = expired - new Date().getTime();

    var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
    var second = Math.floor((timeleft % (1000 * 60)) / 1000);
  if(timeleft < 0 ){
    document.getElementById("msg").innerHTML = "EXPIRED" ;


  } else {
    document.getElementById("msg").innerHTML = "This phone number has blocked <br>"+  minutes + "m " + second + "s ";
  }
//   timeleft -= 1;
}, 1000);


</script>
</html>
