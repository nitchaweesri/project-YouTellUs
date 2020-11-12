<?php 
    include 'config.php';
    include_once 'public/script/inc.php';
    include 'controllers/block.php';

    $url_lang = 'index.php';

    $page = @$_REQUEST['page'] != '' ? $_REQUEST['page'] : 1;
    $lang = @$_SESSION['lang'];

    if (isset($_SESSION['logOn'])&& $_SESSION['logOn']=='true') {
        if ($page == 2) {
            $view = 'resources/views/menu.php';
        } elseif ($page == "GN") {
            $view = 'resources/views/form1.php';
        } elseif ($page == "JP") {
            $view = 'resources/views/form2.php';
        } elseif ($page == "OT") {
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
            $view = 'resources/views/menu.php';
        }
    } else {  
              
        if ($page == '' || $page == 1) {
            $view = 'resources/views/condition.php';
        }elseif ($page == "verify") {
            $view = 'resources/views/verify.php';
        }elseif ($page == "otp") {
            if (isset($_SESSION['phoneNo'])) {
                $result = new block;
                $block = mysqli_num_rows($result->select_block());
                if($block!=0){
                    $view = 'resources/views/countDown.php';
                }elseif($block==0) {
                    $view = 'resources/views/otp.php';
                }
            } else {
                $view = 'resources/views/condition.php';
            }

        }elseif ($page == "error") {
            $view = 'resources/views/error.php';
        }elseif ($page == "test") {
            $view = 'resources/views/test.php';
        }else{
            $view = 'resources/views/condition.php';
        }

        
        if (isset($_SESSION['countMistake'])&&$_SESSION['countMistake'] > POSSIBLE_ERROR_OTP) {
            $result = new block;
            $result->create_block();
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
    <title>YouTellUs</title>
    <link rel="stylesheet" href="public/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/custom.css">
    <script src="public/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

    <?php
        // include_once 'lang/lang_'. $lang .'.php';
	?>
</head>
<?php include 'resources/views/layouts/header.php';?>

<body style="padding-bottom: 37px;">
    <?php include_once $view;         /*  === form YouTellUs ===  */    ?>
</body>

<script>
// $(window).on('load', function(){
//     if (parseInt(localStorage.getItem('countMistake'))>3) {
//             window.location.href = 'index.php?page=error';
//         }
// });

</script>

</html>

