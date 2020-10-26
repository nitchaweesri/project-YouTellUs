<?php 
@session_start();

$re_lang = @$_REQUEST['lang'];
if ($re_lang != '') {
    session_unset ();
    $_SESSION['lang'] = $re_lang;
} else {
    ($_SESSION['lang'] != '') ? $_SESSION['lang']:'th';
}
?>