<?php

$request = $_SERVER['REQUEST_URI'];
// echo trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
switch ($request) {
    case '/tellVoiceProject' :
        require '../src/views/condition.php';
        break;
    case '/tellVoiceProject/' :
        require '../src/views/condition.php';
        break;
    case '/tellVoiceProject/menu' :
        require '../src/views/menu.php';
        break;
    case '/tellVoiceProject/form1' :
        require '../src/views/form1.php';
        break;
    case '/tellVoiceProject/form2' :
        require '../src/views/form2.php';
        break;
    case '/tellVoiceProject/data1' :
        require '../src/views/data1.php';
        break;
    case '/tellVoiceProject/form3' :
        require '../src/views/form3.php';
        break;
    case '/tellVoiceProject/thanks' :
        require '../src/views/thanks.php';
        break;
    default:
        http_response_code(404);
        require '../src/views/condition.php';
        break;
}