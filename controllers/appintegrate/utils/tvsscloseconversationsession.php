<?php header ("Content-Type: text/html; charset=UTF-8"); ?>
<?php

/* -----------------------------------------------------------------------
 * tvsscloseconversationsession.php
 * -----------------------------------------------------------------------
 * Purpose : API for closing conversation message session for TVSS3.0
 * Author  : Pitichat Suttaroj <pitichat@tellvoice.com>
 * Created : 09 Mar 2018
 * History :
 *  09 Mar 2018 - Create file from "tvss_closemsgsession.php"
 *  12 Mar 2018 - Modify input argument(remove $tid)
 *  13 Mar 2018 - Correct user state setting
 *  26 Dec 2018 - Add new input argument 'frombot'
 * -----------------------------------------------------------------------
 */

include_once("../dbutil/includes/services.php");
include_once("../utils/tvutils.php");

define('LOGFILE', '../log/log_utils/tvsscloseconversationsession_'.date('Ymd').'.log');

/* Unique ID */
$gbTransID = sprintf("%08x", abs(crc32($_SERVER['REMOTE_ADDR'] . $_SERVER['REQUEST_TIME'] . $_SERVER['REMOTE_PORT'])));

logWrite(LOGFILE, "Start TVSS close conversation session script...");

/* Is valid request? */
if($_SERVER['REQUEST_METHOD'] != "POST"){
	$outputJSON = array();
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid request method";
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	echo json_encode($outputJSON);
	logWrite(LOGFILE, "End of script(Invalid request method!)");
	exit(-1);
}

if($_SERVER["CONTENT_TYPE"] != "application/json"){
	$outputJSON = array();
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid content type";
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	echo json_encode($outputJSON);
	logWrite(LOGFILE, "End of script(Invalid content type!)");
	exit(-1);
}


/* Input JSON format
 * -----------------
 * {
 *    "channel": $channel,
 *    "channelid": $channelID,
 *    "userid": $userID,
 *    "frombot": $fromBot
 * }
 *
 * *******************************
 *
 * Output JSON format
 * ------------------
 * {
 *    "status": "SUCCESS"/"FAIL"?,
 *    "description": $errorDescription
 * }
 *
 * *******************************
 */

$input = file_get_contents('php://input');

$inputArray = json_decode($input, true);
if(json_last_error() != JSON_ERROR_NONE){
	$outputJSON = array();
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid request content";
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	echo json_encode($outputJSON);
	logWrite(LOGFILE, "End of script(Invalid request content!)");
	exit(-1);
}

/* -------------------------- */
/* ---- Input parameters ---- */
/* -------------------------- */

$channel = $inputArray['channel'];
if(empty($channel)){
	$outputJSON = array();
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid request content(No 'channel')";
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	echo json_encode($outputJSON);
	logWrite(LOGFILE, "End of script(Invalid request content - No 'channel'!)");
	exit(-1);
}

$channelID = $inputArray['channelid'];
if(empty($channelID)){
	$outputJSON = array();
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid request content(No 'channelid')";
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	echo json_encode($outputJSON);
	logWrite(LOGFILE, "End of script(Invalid request content - No 'channelid'!)");
	exit(-1);
}

$userID = $inputArray['userid'];
if(empty($userID)){
	$outputJSON = array();
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid request content(No 'userid')";
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	echo json_encode($outputJSON);
	logWrite(LOGFILE, "End of script(Invalid request content - No 'userid'!)");
	exit(-1);
}

$fromBot = empty($inputArray['frombot'])?'N':$inputArray['frombot'];
$fromBot = ($fromBot == 'Y')?'Y':'N';

logWrite(LOGFILE, "channel = ".$channel." , channelID = ".$channelID." , userID = ".$userID." , fromBot = ".$fromBot);

/* ------------------------------------ */
/* ---- Close conversation session ---- */
/* ------------------------------------ */

$success = true;

if($fromBot == 'N'){
	$sqlStatement = "UPDATE CONVERSATION_CONTACT_INFO SET USERSTATE=? WHERE FEEDTYPE=? AND FEEDACCOUNT=? AND SOCIAL_CUSTID=?";
	$value = array('I', $channel, $channelID, $userID);
	executeSQL($sqlStatement, $value);

	logWrite(LOGFILE, "Update conversation contact info(fromBot = ".$fromBot.")");
}
else{
	/* Get case ID */
	$sqlStatement = "SELECT ROWID, CASEID FROM CONVERSATION_CONTACT_INFO WHERE FEEDTYPE=? AND FEEDACCOUNT=? AND SOCIAL_CUSTID=?";
	$value = array($channel, $channelID, $userID);
	$queryResult = getQueryResult($sqlStatement, $value);
	if($queryResult['numrows'] <= 0){
		/* Not found this contact before */
		logWrite(LOGFILE, "Not found conversation contact info!");
		$success = false;
	}
	else{
		$converContactID = $queryResult['info'][0]['ROWID'];
		$caseID = $queryResult['info'][0]['CASEID'];
		
		/* Update conversation contact info */
		$sqlStatement = "UPDATE CONVERSATION_CONTACT_INFO SET USERSTATE=? WHERE FEEDTYPE=? AND FEEDACCOUNT=? AND SOCIAL_CUSTID=?";
		$value = array('I', $channel, $channelID, $userID);
		executeSQL($sqlStatement, $value);

		logWrite(LOGFILE, "Update conversation contact info(fromBot = ".$fromBot.")");

		/* Update case info */
		$sqlStatement = "UPDATE CASEINFO SET FINBYBOTFLAG=?, BOTENDDT=NOW(), CASESTATUS=? WHERE CASEID=?";
		$value = array('Y', 'C', $caseID);
		executeSQL($sqlStatement, $value);

		logWrite(LOGFILE, "Update case id ".$caseID."(fromBot = ".$fromBot.")");
	}
}


/* ---------------- */
/* ---- Output ---- */
/* ---------------- */

$outputJSON = array();
if($success == true){
	$httpResponseCode = 200;
	$outputJSON['status'] = "SUCCESS";    $outputJSON['description'] = "OK";
}
else{
	$httpResponseCode = 404;
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Cannot close conversation session info";
}
http_response_code($httpResponseCode);
header('Content-Type: application/json');
echo json_encode($outputJSON);

logWrite(LOGFILE, "End of script");

exit(0);

?>
