<?php 
    include_once 'public/script/inc.php';
    $url_lang = 'index.php';

    $page = @$_REQUEST['page'] != '' ? $_REQUEST['page'] : 1;
    $lang = @$_SESSION['lang'];

    if ($page == '' || $page == 1) {
        $view = 'resources/views/condition.php';
    } elseif ($page == 2) {
        $view = 'resources/views/menu.php';
    } elseif ($page == "form1") {
        $view = 'resources/views/form1.php';
    } elseif ($page == "form2") {
        $view = 'resources/views/form2.php';
    } elseif ($page == "form3") {
        $view = 'resources/views/form3.php';
    } elseif ($page == "thanks") {
        $view = 'resources/views/thanks.php';
    } elseif ($page == "error") {
        $view = 'resources/views/error.php';
    }elseif ($page == "verify") {
        $view = 'resources/views/verify.php';
    }elseif ($page == "otp") {
        $view = 'resources/views/otp.php';
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
    <?php
        // include_once 'lang/lang_'. $lang .'.php';
	?>
</head>
<?php include 'resources/views/layouts/header.php';?>

<body style="padding-bottom: 37px;">
    <?php include_once $view;         /*  === form YouTellUs ===  */    ?>
</body>

</html>