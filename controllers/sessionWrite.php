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
            $_SESSION[$_GET['name']] = $_GET['value'];
        // }
?>