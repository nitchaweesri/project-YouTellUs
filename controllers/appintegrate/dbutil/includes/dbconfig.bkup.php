<?php
	if(file_exists('PHP_adodb212/adodb.inc.php')){
		include_once('PHP_adodb212/adodb.inc.php');
	}else if(file_exists('../PHP_adodb212/adodb.inc.php')){
		include_once('../PHP_adodb212/adodb.inc.php');
	}else if(file_exists('../../PHP_adodb212/adodb.inc.php')){
		include_once('../../PHP_adodb212/adodb.inc.php');
	}else if(file_exists('../../../PHP_adodb212/adodb.inc.php')){
		include_once('../../../PHP_adodb212/adodb.inc.php');
	}


	define('DBCONFIG_SERVER', 'tv03');
	define('DBCONFIG_USER', 'tellvoice');
	define('DBCONFIG_PASSWORD', 'eciovllet');
	define('DBCONFIG_DBNAME', 'DEVTVSS');
	define('DEF_ADODB_FETCH_MODE', 'ADODB_FETCH_ASSOC');
/**/
	

?>
