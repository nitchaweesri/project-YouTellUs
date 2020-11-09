<?php   

class Block {

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


    function create_block()
    {
        include 'database/model/database.php';
        include 'config.php';

        $ip_block = $this->get_client_ip();
        $phone_block = $_SESSION['phoneNo'];
        $now = date('Y-m-d H:i:s');

        $currentDate = strtotime($now);
        $futureDate = $currentDate+(60* TIME_BLOCK_EXPIRE);
        $formatDate = date('Y-m-d H:i:s', $futureDate);

        $sql = "INSERT INTO `CONFIG_YTU_BLOCK` ( `BLOCKIP`, `BLOCKTEL`, `CREATED_DT`,`EXPIRED_DT`)
        VALUES ('$ip_block', '$phone_block', '$now' , '$formatDate' )";

        if ($conn->query($sql) === TRUE) {
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();

    }

    function select_block()
    {
        include 'database/model/database.php';

        $ip_block = $this->get_client_ip();

        if (isset($_SESSION['phoneNo'])) {
            $tel_block = $_SESSION['phoneNo'];
            $sql = "SELECT * FROM `CONFIG_YTU_BLOCK` WHERE `BLOCKTEL` LIKE '%$tel_block%'";
            $result = $conn->query($sql);
            return $result;
        } else {
            $sql = "SELECT * FROM `CONFIG_YTU_BLOCK` WHERE `BLOCKIP` LIKE '%$ip_block%'";
            $result = $conn->query($sql);
            return $result;
        }
    
        $conn->close();

    }

    function delete_block()
    {
        include 'database/model/database.php';

        $ip_block = $this->get_client_ip();

        if (isset($_SESSION['phoneNo'])) {
            $tel_block = $_SESSION['phoneNo'];
            $sql = "DELETE  FROM `CONFIG_YTU_BLOCK` WHERE `BLOCKTEL` LIKE '%$tel_block%'";
            $result = $conn->query($sql);
            return $result;
        } else {
            $sql = "DELETE FROM `CONFIG_YTU_BLOCK` WHERE `BLOCKIP` LIKE '%$ip_block%'";
            $result = $conn->query($sql);
            return $result;
        }
    
        $conn->close();

    }

    
}


?>