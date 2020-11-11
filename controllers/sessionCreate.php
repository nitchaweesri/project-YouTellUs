<?php 

    $name = $_POST['name'];
    $value = $_POST['value'];
  
    session_start();
    $_SESSION[$name] = $value;

?>