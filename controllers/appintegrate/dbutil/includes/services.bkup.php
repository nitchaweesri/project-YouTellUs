<?php
if(file_exists('dbutil/includes/dbconfig.php')){
	include_once('dbutil/includes/dbconfig.php');
	include_once('dbutil/includes/checkauthorization.php');
}else if(file_exists('../dbutil/includes/dbconfig.php')){
	include_once('../dbutil/includes/dbconfig.php');
	include_once('../dbutil/includes/checkauthorization.php');
}else if(file_exists('../../dbutil/includes/dbconfig.php')){
	include_once('../../dbutil/includes/dbconfig.php');
	include_once('../../dbutil/includes/checkauthorization.php');
}else if(file_exists('../../../dbutil/includes/dbconfig.php')){
	include_once('../../../dbutil/includes/dbconfig.php');
	include_once('../../../dbutil/includes/checkauthorization.php');
}

// PHP5 COMPATIBILITY //
$HTTP_COOKIE_VARS=$_COOKIE;

date_default_timezone_set("Asia/Bangkok");


class iimysqli_result
{
    public $stmt, $nCols, $fields;
}    

function iimysqli_stmt_get_result($stmt)
{
    /**    EXPLANATION:
     * We are creating a fake "result" structure to enable us to have
     * source-level equivalent syntax to a query executed via
     * mysqli_query().
     *
     *    $stmt = mysqli_prepare($conn, "");
     *    mysqli_bind_param($stmt, "types", ...);
     *
     *    $param1 = 0;
     *    $param2 = 'foo';
     *    $param3 = 'bar';
     *    mysqli_execute($stmt);
     *    $result _mysqli_stmt_get_result($stmt);
     *        [ $arr = _mysqli_result_fetch_array($result);
     *            || $assoc = _mysqli_result_fetch_assoc($result); ]
     *    mysqli_stmt_close($stmt);
     *    mysqli_close($conn);
     *
     * At the source level, there is no difference between this and mysqlnd.
     **/
    $metadata = mysqli_stmt_result_metadata($stmt);
    $ret = new iimysqli_result;
    if (!$ret) return NULL;

    $ret->nCols = mysqli_num_fields($metadata);
	$ret->fields = mysqli_fetch_fields($metadata);
    $ret->stmt = $stmt;

    mysqli_free_result($metadata);
    return $ret;
}

function iimysqli_result_fetch_array(&$result)
{
    $ret = array();
    $code = "return mysqli_stmt_bind_result(\$result->stmt ";

    for ($i=0; $i<$result->nCols; $i++)
    {
        $ret[$i] = NULL;
        $code .= ", \$ret['" .$i ."']";
    };

    $code .= ");";
    if (!eval($code)) { return NULL; };

    // This should advance the "$stmt" cursor.
    if (!mysqli_stmt_fetch($result->stmt)) { return NULL; };

    // Return the array we built.
	
	// ADDED BY SUWICH //
	$ret2 = array();
	foreach($ret as $nItem=>$retdata){
		$ret2[$nItem] = $retdata;
		$fldname = $result->fields[$nItem]->name;
		$ret2[$fldname] = $retdata;
	}
	
	
	
    return $ret2;
}



function getHTTPResult($url){
	$handle = fopen($url, "rb");
	if (FALSE === $handle) {
		return "FAIL";
	}

	$contents = '';

	while (!feof($handle)) {
		$contents .= fread($handle, 8192);
	}
	fclose($handle);

	return $contents;
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////// DATABASE MANIPULATION FUNCTIONS //////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function getResultSet($SQLStatement)
{
	$MainDB = &ADONewConnection('mysql');
	if(!$MainDB->Connect(DBCONFIG_SERVER, DBCONFIG_USER, DBCONFIG_PASSWORD, DBCONFIG_DBNAME)){
		print "Error MySQL Connection";
	}
	
	$MainDB->Execute('SET NAMES utf8');

	$rs = $MainDB->Execute($SQLStatement);
	if (!$rs){
		print $MainDB->ErrorMsg();
		return NULL;
	}

	return $rs;
}



function executeSQLArray($SQLStatementArray)
{
	$MainDB = &ADONewConnection('mysql');
	if(!$MainDB->Connect(DBCONFIG_SERVER, DBCONFIG_USER, DBCONFIG_PASSWORD, DBCONFIG_DBNAME)){
		print "Error MySQL Connection";
		return false;
	}

	$MainDB->Execute('SET NAMES utf8');

	foreach( $SQLStatementArray as $SQLStatement){
		$rs = $MainDB->Execute($SQLStatement);
	}

	return true;
}

function getQueryResult($SQLStatement, $value = null){

	$ReturnResultArray = array();
	$ReturnResultArray["result"] = -1;


	// CREATE CONNECTION //
	$mysqli = new mysqli(DBCONFIG_SERVER, DBCONFIG_USER, DBCONFIG_PASSWORD, DBCONFIG_DBNAME);
	//$mysqli = new mysqli(DBCONFIG_SERVER, DBCONFIG_USER, DBCONFIG_PASSWORD, "lionmaster");
	if (mysqli_connect_error()) {
		die('Connect Error (' . mysqli_connect_errno() . ') '	. mysqli_connect_error());
	}
	//mysqli_select_db($mysqli, "lionmaster");

	$stmt_code = $mysqli->prepare('SET NAMES utf8');
	$stmt_code->execute();
	mysqli_stmt_close($stmt_code);

	$stmt = $mysqli->prepare($SQLStatement);

	$types = str_repeat("s", count($value));

	if (strnatcmp(phpversion(),'5.3') >= 0)
	{
		
		$bind = array();
		if(count($value) > 0){
			foreach($value as $key => $val)
			{
				$bind[$key] = &$value[$key];
			}
		}

	} else {

		$bind = $value;
	}

	array_unshift($bind, $types);
	if(count($value) > 0){
		call_user_func_array(array($stmt, 'bind_param'), $bind);
	}
/*
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try { 
     $stmt->execute();
     $res = $stmt->get_result();
   } catch (mysqli_sql_exception $e) { 
      print_r( $e); 
   } 
	
return $ReturnResultArray;
	$ReturnResultArray["result"] = 1;
	$ReturnResultArray["numrows"] = $res->num_rows;
	
	$ResultList = array();
	while($row = $res->fetch_assoc()){
		//print_r($row);print "<BR/><BR/>";
		//var_dump($row);
		$ResultList[] = $row;
	}

*/
$stmt->execute();
$res = iimysqli_stmt_get_result($stmt);
		$ReturnResultArray["result"] = 1;
		
		
		$numrow = 0;
		$ResultList = array();
		while($row = iimysqli_result_fetch_array($res)){
			//print_r($row);print "<BR/><BR/>";
			//var_dump($row);
			$ResultList[] = $row;
			$numrow++;
		}
		
		$ReturnResultArray["numrows"] = $numrow;
		
	mysqli_stmt_close($stmt);

	mysqli_close($mysqli);



	$ReturnResultArray["info"] = $ResultList;
	return $ReturnResultArray;

	
}

function executeSQL($SQLStatement, $value = null)
{
	// CREATE CONNECTION //
	$mysqli = new mysqli(DBCONFIG_SERVER, DBCONFIG_USER, DBCONFIG_PASSWORD, DBCONFIG_DBNAME);
	if (mysqli_connect_error()) {
		die('Connect Error (' . mysqli_connect_errno() . ') '	. mysqli_connect_error());
	}

	$stmt_code = $mysqli->prepare('SET NAMES utf8');
	$stmt_code->execute();
	mysqli_stmt_close($stmt_code);

	$stmt = $mysqli->prepare($SQLStatement);

	$types = str_repeat("s", count($value));

	foreach($value as $nVal=>$valValue){
		if($valValue == ""){
			$value[$nVal] = $valValue;
		}
	}
	
	if (strnatcmp(phpversion(),'5.3') >= 0)
	{
		
		$bind = array();
		foreach($value as $key => $val)
		{
			$bind[$key] = &$value[$key];
		}

	} else {

		$bind = $value;
	}
	//print_r($bind);

	array_unshift($bind, $types);
	call_user_func_array(array($stmt, 'bind_param'), $bind);
	
	$stmt->execute();

	mysqli_stmt_close($stmt);

	mysqli_close($mysqli);

	return true;
}


/* Added by Pitichat 2017-02-27 */
function executeSQL_LastInsertId($sqlStatement)
{
	$execInfo = array("isSuccess" => true, "errorDescp" => "", "lastId" => "");
		
	/* Create connection */
	$conn = mysqli_connect(DBCONFIG_SERVER, DBCONFIG_USER, DBCONFIG_PASSWORD, DBCONFIG_DBNAME);
	
	/* Check connection */
	if(!$conn){
		$execInfo["isSuccess"] = false;    $execInfo["errorDescp"] = "Cannot connect to database";
		return($execInfo);
	}

	if(mysqli_query($conn, $sqlStatement)){
		$execInfo["lastId"] = mysqli_insert_id($conn);
	}
	else{
		$execInfo["isSuccess"] = false;    $execInfo["errorDescp"] = mysqli_error($conn);
	}

	mysqli_close($conn);

	return($execInfo);
}


function InsertDatabase($Tablename, $InsertStatement)
{
	$SQLStatement = "INSERT INTO $Tablename SET $InsertStatement";
	$ResultSet = getResultSet($SQLStatement);
}

function UpdateDatabase($Tablename, $updateStatement)
{
	$SQLStatement = "UPDATE $Tablename $updateStatement";
	$ResultSet = getResultSet($SQLStatement);
}

function DeleteDatabase($Tablename, $WhereStatement)
{
	$SQLStatement = "DELETE FROM $Tablename WHERE $WhereStatement";
	$ResultSet = getResultSet($SQLStatement);
}

function OptimizeDatabase($Tablename)
{
	$SQLStatement = "OPTIMIZE TABLE $Tablename ";
	$ResultSet = getResultSet($SQLStatement);
}

function WriteLog($LOGEVENT, $LOGMSG)
{

	$USERID = $_SESSION['USERID'];
	if($USERID==""){ $USERID = -1; }
	$USERNAME = $_SESSION['USERNAME'];
	$SQLStatement = "INSERT INTO EVENTLOG (LOGDATETIME, USERID, USERNAME, EVENTTYPE, EVENTDETAIL) VALUES (NOW(), $USERID, '$USERNAME', ?, ?)";
	$value = array($LOGEVENT, $LOGMSG);
	executeSQL($SQLStatement, $value);
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////// END DATABASE MANIPULATION FUNCTIONS /////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function CheckAuthorizeCode($AuthCode, $GROUPACCESSINFO){
	if(!in_array($AuthCode, $GROUPACCESSINFO)){
		// INVALID AUTHENTICATION //
		print "Invalid Authentication";//
?>
	<IMG SRC="images/icons/blank1x1.gif" onLoad="window.location='index.php?Result=EXPIRE';alert('Invalid Authentication');"/>
<?php
		exit;return;
	}
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////// HELP FUNCTIONS //////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getDisplayDateString($DBDateString){
	$DateVariable  = mktime(0, 0, 0, substr($DBDateString,4,2)  , substr($DBDateString,-2), substr($DBDateString,0,4));
	return date("D d F Y",$DateVariable);
}

function getDateFormat($DateNumber){
	$DayVal = substr($DateNumber,-2);
	$MonthVal = substr($DateNumber, 4, 2);
	$YearVal = substr($DateNumber, 0, 4);

	return $DayVal . "/" . $MonthVal . "/" .  $YearVal;
}

function getTimeFormat($TimeNumer){
	$TempTimeString = "000000" . $TimeNumer;
	$TimeString = substr($TempTimeString, -6);

	$SecondVal = substr($TimeString,-2);
	$MinuteVal = substr($TimeString, 2, 2);
	$HourVal = substr($TimeString, 0, 2);

	return $HourVal . ":" . $MinuteVal . ":" . $SecondVal;
}

function ConvertExtJSToDateDB($DateFromJS)
{
	return substr($DateFromJS, -4) . substr($DateFromJS, 3, 2) . substr($DateFromJS, 0, 2);
}

function ExtractXML($XMLTag, $FullText){
	$XML1 = "<" . $XMLTag . ">";
	$XML2 = "</" . $XMLTag . ">";

	$pos1 = strpos($FullText, $XML1);
	if ($pos1 === false) {return ""; }

	$pos2 = strpos($FullText, $XML2);
	if ($pos2 === false) {return ""; }
	
	$pos1 += strlen($XML1);

	return substr($FullText, $pos1, $pos2-$pos1);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function WriteMovementLog($ITEMID, $RFIDTAG, $ACTIONCODE, $LOCATIONCODE, $USERID, $USERNAME, $DEVICECODE){
	$SQLStatement = "INSERT INTO ITEMMOVEMENTLOG (LOGDT, ITEMID, RFIDTAG, ACTIONCODE, LOCATIONCODE, USERID, USERNAME, DEVICECODE) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?)";
	$value=array($ITEMID, $RFIDTAG, $ACTIONCODE, $LOCATIONCODE, $USERID, $USERNAME, $DEVICECODE);
	executeSQL($SQLStatement, $value);
}
?>
