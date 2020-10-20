<?php

$request = $_SERVER['REQUEST_URI'];

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
    default:
        http_response_code(404);
        require '../src/views/condition.php';
        break;
}