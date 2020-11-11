<?
session_start();

// die(print_r($request->input('data')));
// $sessionData = $_POST['sessionJson'] ;
// foreach ($sessionData as $key => $value) {
//     if (!isset($_SESSION[$key])) {
//         $_SESSION[$key] = $value;
//     }
// }

// if (!isset($_SESSION[$_GET['name']])) {
            $_SESSION[$_POST['name']] = $_POST['value'];
            // $_SESSION['phoneNo'] = '0822671922';
            // $_SESSION['countMistake'] = '0';
            // $_SESSION['countStart'] = date("Y-m-d H:i:s");

        // }
?>