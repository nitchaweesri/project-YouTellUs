<?php 
    include_once('crypt.php') ;


    function ytu_complainttype()
    {
        include 'database/model/database.php';
        $sql = "SELECT * FROM `CONFIG_YTU_COMPLAINTTYPE`";
        $result = $conn->query($sql);
        return $result;
    }
    function ytu_product()
    {
        include 'database/model/database.php';
        $sql = "SELECT * FROM `CONFIG_YTU_PRODUCT` GROUP BY `PRODUCTCODE`  ORDER BY `PRODUCTID`";
        $result = $conn->query($sql);
        return $result;
    }
    function show_case()
    {
        include 'database/model/database.php';
        $sql = "SELECT * FROM `CASEINFO` ORDER BY `CREATED_DT` DESC LIMIT 15";
        $result = $conn->query($sql);
        return $result;
    }
    function show_case_id()
    {
        include 'database/model/database.php';

        $sql = "SELECT * FROM `CASEINFO` WHERE  `FEEDID` LIKE '".@$_REQUEST['id']."'";
        $sql_column = "SELECT `COLUMN_NAME` 
            FROM `INFORMATION_SCHEMA`.`COLUMNS` 
            WHERE `TABLE_SCHEMA`='scbytu_dev' 
            AND `TABLE_NAME`='CASEINFO';";

        $result = $conn->query($sql);
        $result_column = $conn->query($sql_column);
        return [$result, $result_column];
    
    }
    
?>