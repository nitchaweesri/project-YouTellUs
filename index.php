<?php 
    include 'config.php';
    include_once 'public/script/inc.php';
    include 'controllers/block.php';

    $url_lang = 'index.php';
    
    if(@$_REQUEST['re_session'] == 'unset') { 
        session_destroy();
        // unset($_SESSION['countStart']); 
        // unset($_SESSION['countMistake']);
        // unset($_SESSION['logOn']);
        header("Location: index.php?page=menu");
    }
    $page = @$_REQUEST['page'] != '' ? $_REQUEST['page'] : 1 ;
    // $lang = @$_SESSION['lang'] != '' ? $_SESSION['lang'] : 'th' ;
    
    if (isset($_SESSION['logOn'])) {
        // if (isset($_REQUEST['condition']) &&$_REQUEST['condition'] == TRUE) {
        //     $view = 'resources/views/condition.php';
        // } else {
            if(time() - $_SESSION['logOn'] > 1800) {

                session_destroy();
                echo "<script>
                        alert('Session หมดอายุ กรุณาทำรายการใหม่อีกครั้ง');
                        window.location.href='index.php?page=menu';
                    </script>";

                // header("Location: index.php?page=menu");
            }
             if ($page == 2) {
                $view = 'resources/views/condition.php';
            } elseif ($page == "GN") {
                $view = 'resources/views/form1.php';
            } elseif ($page == "OT") {
                $view = 'resources/views/form2.php';
            } elseif ($page == "JP") {
                $view = 'resources/views/form3.php';
            } elseif ($page == "thanks") {
                $view = 'resources/views/thanks.php';
            } elseif ($page == "error") {
                $view = 'resources/views/error.php';
            }elseif ($page == "testdb") {
                $view = 'resources/views/query.php';
            }elseif ($page == "querybyid") {
                $view = 'resources/views/querybyid.php';
            }elseif ($page == "menuupload") {
                $view = 'resources/views/menuUpload.php';
            }elseif ($page == "upload") {
                $view = 'resources/views/upload.php';
            }elseif ($page == "test") {
                $view = 'resources/views/test.php';
            }elseif ($page == "error") {
                $view = 'resources/views/error.php';
            }
            else{
                session_destroy();
                $view = 'resources/views/menu.php';
            }
        // }
       
    } else {  
              
        // if ($page == '' || $page == 1) {
        //     session_destroy();
        //     $view = 'resources/views/menu.php';
        // } 
        if ($page == "GN" ||$page == "OT" || $page == "JP") {
            $view = 'resources/views/verify.php';
        } elseif ($page == "verify") {
            $view = 'resources/views/verify.php';
        } elseif ($page == "otp") {
            if (isset($_SESSION['phoneNo'])) {
                $result = new block;
                $block = mysqli_num_rows($result->select_block());
                if($block!=0){
                    $view = 'resources/views/countDown.php';
                }elseif($block==0) {
                    $view = 'resources/views/otp.php';
                }
            } else {
                $view = 'resources/views/menu.php';
            }

        }elseif ($page == "error") {
            $view = 'resources/views/error.php';
        }elseif ($page == "testOtp") {
            $view = 'resources/views/testOtp.php';
        }elseif ($page == "testValidOtp") {
            $view = 'resources/views/testValidOtp.php';
        }else{
            $view = 'resources/views/menu.php';
        }

        
        if (isset($_SESSION['countMistake'])&&$_SESSION['countMistake'] > POSSIBLE_ERROR_OTP) {
            $result = new block;
            $status = '3T';
            $result->create_block($status);
            $msg = '';
            $view = 'resources/views/countDown.php';
            $_SESSION['countMistake'] = 0;
        }
    }   
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
		<title>SCB : You tell US</title>
    	<meta content="Youtellus ได้รับการออกแบบมาเพื่อให้ลูกค้าทุก ท่านสามารถบอกระดับความพึงพอใจ ให้กับ SCB" name="descriptison">
    	<meta content="SCB,Youtellus,ธนาคารไทยพาณิชย์" name="keywords">
  		<link href="assets/img/favicon.png" rel="icon">
  		<link href="assets/img/favicon.png" rel="apple-touch-icon">

        <link rel="stylesheet" href="public/vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="public/css/custom.css">
        <script src="public/vendor/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>


        <!-- <script src="public/js/uploadimage.js"></script> -->

        <?php // include_once 'lang/lang_'. $lang .'.php'; ?>
    </head>

    <?php 
        if($page != "thanks"){
            include 'resources/views/layouts/header.php'; 
        }
    ?>
	<?php include 'resources/views/modal.php'; ?>

    <!-- <body class="body-pd-bt"> -->
    <body>
        <?php include_once $view;         /*  === form YouTellUs ===  */    ?>
    </body>

	<?php /*
    <script>
    $(window).on('load', function(){
    	if (parseInt(localStorage.getItem('countMistake'))>3) {
    		window.location.href = 'index.php?page=error';
    	}
    });
    </script>
    */ ?>

    <script>
    
    
    var lang = '<?php echo isset($_SESSION['lang'])? $_SESSION['lang']: '';?>';

    if (lang == '') {
        $.ajax({
        type: "POST",
        url: 'controllers/sessionCreate.php',
        data:{"name": "lang","value":"th"}
        // data: {sessionJson: { countStart :'countStartvalue1' , countStart1: 'countStar1tvalue1'}}
    }); 
    }
    </script>
</html>