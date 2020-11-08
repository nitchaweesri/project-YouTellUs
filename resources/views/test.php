
<?php
$ip_block[] = "172.16.113.7"; //fik ip
$ip_block[] = "192.168.64.1"; //fik ip


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