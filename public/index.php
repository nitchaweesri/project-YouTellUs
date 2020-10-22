<?php

$_GET['path'] = isset($_GET['path']) ? $_GET['path'] : "";

switch ($_GET['path']) {
    case '' :
        require '../src/views/condition.php';
        break;
    case 'menu' :
        require '../src/views/menu.php';
        break;
    case 'form1' :
        require '../src/views/form1.php';
        break;
    case 'form2' :
        require '../src/views/form2.php';
        break;
    case 'data1' :
        require '../src/controller/data1.php';
        break;
    case 'store.php' :
        require '../src/views/store.php';
        break;
    case 'form3' :
        require '../src/views/form3.php';
        break;
    case 'thanks' :
        require '../src/views/thanks.php';
        break;
    default:
        http_response_code(404);
        require '../src/views/condition.php';
        break;
}