<?php
	if(file_exists('dbutil/PHP_adodb212/adodb.inc.php')){
		include_once('dbutil/PHP_adodb212/adodb.inc.php');
	}else if(file_exists('../dbutil/PHP_adodb212/adodb.inc.php')){
		include_once('../dbutil/PHP_adodb212/adodb.inc.php');
	}else if(file_exists('../../dbutil/PHP_adodb212/adodb.inc.php')){
		include_once('../../dbutil/PHP_adodb212/adodb.inc.php');
	}else if(file_exists('../../../dbutil/PHP_adodb212/adodb.inc.php')){
		include_once('../../../dbutil/PHP_adodb212/adodb.inc.php');
	}

	include_once('../dbutil/SMMconfig.php');

/*	define('DBCONFIG_SERVER', 'tv03');
	define('DBCONFIG_USER', 'tellvoice');
	define('DBCONFIG_PASSWORD', 'eciovllet');
	define('DBCONFIG_DBNAME', 'DEVSMMDEV');
	define('DEF_ADODB_FETCH_MODE', 'ADODB_FETCH_ASSOC');
*/
/**/
	

?>
