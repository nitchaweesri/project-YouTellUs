<?php header ("Content-Type: text/html; charset=UTF-8"); ?>
<?php

/* -----------------------------------------------------------------------
 * createcaseinfofrombot.php
 * -----------------------------------------------------------------------
 * Purpose : TVSS service function to create conversation case that
 *           being transferred from TV chatbot
 * Author  : Pitichat Suttaroj <pitichat@tellvoice.com>
 * Created : 22 Mar 2018
 * History :
 *  22 Mar 2018 - Create file
 *  04 May 2018 - Modify $outputJSON['description']
 *              - Modify $feedID value in 'createCaseInfoFromBot()'
 *              - Set 'FROMBOT' to 'Y' in 'createCaseInfoFromBot()'
 *  08 Jun 2018 - Modify 'createCaseInfoFromBot()' to use
 *                $threadID as $channelID."_".$userID;
 *  21 Jul 2018 - Modify function 'createCaseInfoFromBot()' to add
 *                customer priority retrieval function '_GetCustomerPriority()'
 *              - Declare other style to connect database variable '$connection'
 *                that being used in '_GetCustomerPriority()'
 *  22 Jul 2018 - Modify function 'createCaseInfoFromBot()'
 *  26 Dec 2018 - Modify function 'createCaseInfoFromBot()'
 * -----------------------------------------------------------------------
 */

include_once("../dbutil/includes/services.php");
include_once("../utils/tvutils.php");
include_once("../utils/priorityfunc.php");
include_once('../dbutil/CDatabase.php');


define('LOGFILE', '../log/log_utils/createcaseinfofrombot_'.date('Ymd').'.log');


/* Unique ID */
$gbTransID = sprintf("%08x", abs(crc32($_SERVER['REMOTE_ADDR'] . $_SERVER['REQUEST_TIME'] . $_SERVER['REMOTE_PORT'])));

logWrite(LOGFILE, "Start script...");

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
 *    "channel": $Channel,
 *    "channelid": $LineChannelID,
 *    "userid": $LineUserID,
 *    "language": $Language,
 *    "topic": $Topic
 * }
 *
 * *******************************
 *
 * Output JSON format
 * ------------------
 * {
 *    "status": "SUCCESS"/"FAIL"?,
 *    "description": $ErrorDescription
 * }
 *
 * *******************************
 */

$input = file_get_contents('php://input');

logWrite(LOGFILE, "Incoming message = ".$input);

$inputArray = json_decode($input, true);
if(json_last_error() != JSON_ERROR_NONE){
	$outputJSON = array();
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid request content";    $outputJSON['httpcode'] = "";
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
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid request content(No 'channel')";    $outputJSON['httpcode'] = "";
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
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid request content(No 'channelid')";    $outputJSON['httpcode'] = "";
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
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid request content(No 'userid')";    $outputJSON['httpcode'] = "";
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	echo json_encode($outputJSON);
	logWrite(LOGFILE, "End of script(Invalid request content - No 'userid'!)");
	exit(-1);
}

$language = $inputArray['language'];
if(empty($language)){
	$language = "TH";
}

$topic = $inputArray['topic'];
if(empty($topic)){
	$topic = "";
}

logWrite(LOGFILE, "channel = ".$channel." , channelID = ".$channelID." , userID = ".$userID);
logWrite(LOGFILE, "language = ".$language." , topic = ".$topic);

/* This is for Pour's included routine
 * that use this database class as global -_-"
 */
$connection = new CDatabase();
$connection->Connect();

/* Create case... */
$retVal = createCaseInfoFromBot($channel, $channelID, $userID, $language, $topic);

/* ---------------- */
/* ---- Output ---- */
/* ---------------- */

$httpResponseCode = ($retVal == true)?200:404;
http_response_code($httpResponseCode);

$outputJSON = array();
$outputJSON['status'] = ($retVal == true)?"SUCCESS":"FAIL";
$outputJSON['description'] = ($retVal == true)?"Ok":"Cannot create case info";

header('Content-Type: application/json');
echo json_encode($outputJSON);

$connection->Disconnect();    unset($connection);

logWrite(LOGFILE, "End of script");

exit(0);


/* createCaseInfoFromBot
 * ---------------------
 * Purpose : Create TVSS case info from TV chatbot function
 * Input   :
 *  (1) '$channel' = input social media channel
 *  (2) '$channelID' = input social media channel ID
 *  (3) '$userID' = target user ID
 *  (4) '$language' = conversation language info from bot
 *  (5) '$topic' = conversation topic from bot
 * Return  : Process status boolean flag(true/false)
 */

function createCaseInfoFromBot($channel, $channelID, $userID, $language, $topic)
{
	/* Is $userID already in table 'CONVERSATION_CONTACT_INFO'? */
	$sqlStatement = "SELECT SOCIAL_CUSTNAME, CONTACTID, USERSTATE, CASEID FROM CONVERSATION_CONTACT_INFO WHERE FEEDTYPE=? AND FEEDACCOUNT=? AND SOCIAL_CUSTID=?";
	$value = array($channel, $channelID, $userID);
	$queryResult = getQueryResult($sqlStatement, $value);
	if($queryResult['numrows'] <= 0){
		/* Not found this contact before */
		logWrite(LOGFILE, "createCaseInfoFromBot: WARNING: Not found contact info for (\"".$channel."\", \"".$channelID."\", \"".$userID."\")");
		return(false);
	}

	$custContactID = $queryResult['info'][0]['CONTACTID'];
	$userName = $queryResult['info'][0]['SOCIAL_CUSTNAME'];
	$userState = $queryResult['info'][0]['USERSTATE'];
	$caseID = $queryResult['info'][0]['CASEID'];

	$feature01 = $topic;
	
	/* Get customer set ID */
	logWrite(LOGFILE, "createCaseInfoFromBot: Call '_GetCustomerPriority()' with ".$userID);
	$customerSetID = _GetCustomerPriority($userID, "LN", LOGFILE);
	logWrite(LOGFILE, "createCaseInfoFromBot: customerSetID = ".$customerSetID);
	$feature02 = $customerSetID;

	$feature03 = $feature04 = $feature05 = "";

	/* Get priority score */
	$priorityList = getPriorityList();
	$sla = $ola = 3600;
	$priorityScore = getPriorityScore($priorityList, $sla, $ola, $channel, "ME", $language, $channelID, $feature01, $feature02, $feature03, $feature04, $feature05);

	logWrite(LOGFILE, "createCaseInfoFromBot: priorityScore = ".$priorityScore);
	
	/* Update case info */
	if($caseID != -1){
		$sqlStatement = "UPDATE CASEINFO SET CASESTATUS=?, FEATURE01=?, LANGUAGE=?, BOTENDDT=NOW(), FROMBOT=?, PRIORITYSCORE=? WHERE CASEID=?";
		$value = array('N', $feature01, $language, 'Y', $priorityScore, $caseID);
		executeSQL($sqlStatement, $value);
		logWrite(LOGFILE, "Already updated case ".$caseID);
	}
	else{
		logWrite(LOGFILE, "There's no case to be updated");
	}

	return(true);
}

?>
