
<?php

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}



$ip_block[] = get_client_ip(); //fik ip


echo $_SERVER["REMOTE_ADDR"];

if(isset($_SERVER["REMOTE_HOST"])) {
   $ip = $_SERVER["REMOTE_HOST"];
} else {
   $ip = $_SERVER["REMOTE_ADDR"];
}

foreach($ip_block as $key =>$val) {
  if($ip == $val) {
     echo "ไม่สามารถเข้าเว็บได้";
     exit();
  }
}
?>