<?php header ("Content-Type: text/html; charset=UTF-8"); ?>
<?php

/* -----------------------------------------------------------------------
 * ibmwatsoninterface_gateway.php
 * -----------------------------------------------------------------------
 * Purpose : TV routines for interface with IBM Watson Conversation
 *           via gateway
 * Author  : Pitichat Suttaroj <pitichat@tellvoice.com>
 * Created : 05 Sep 2017
 * History :
 *  05 Sep 2017 - Create file
 *  13 Sep 2017 - Add header 'Content-Type: application/json' to response
 *  04 Apr 2018 - Modify script for TVSS3.0 integration
 * -----------------------------------------------------------------------
 */

include_once("../utils/tvutils.php");

define('LOGFILE', '../log/log_utils/ibmwatsoninterface_gateway_'.date('Ymd').'.log');


/* Unique ID */
$gbTransID = sprintf("%08x", abs(crc32($_SERVER['REMOTE_ADDR'] . $_SERVER['REQUEST_TIME'] . $_SERVER['REMOTE_PORT'])));

/* Is valid request? */
if($_SERVER['REQUEST_METHOD'] != "POST"){
	$outputJSON = array();
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid request method";
	/* Output */
	header('Content-Type: application/json');
	echo json_encode($outputJSON);
	exit(-1);
}

if($_SERVER["CONTENT_TYPE"] != "application/json"){
	$outputJSON = array();
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid content type";
	/* Output */
	header('Content-Type: application/json');
	echo json_encode($outputJSON);
	exit(-1);
}


/* Input JSON format
 * -----------------
 * {
 *    "tokenizedtext": "ABCDEFG",
 *    "conversationid": "123456",
 *    "username": "watsonusername",
 *    "password": "watsonpassword",
 *    "workspaceid": "watsonworkspaceid"
 *    "timeout": watsontimeout(in second)
 * }
 *
 * *******************************
 *
 * Output JSON format
 * ------------------
 * {
 *    "status": "SUCCESS"/"FAIL"?,
 *    "description": "errordescription",
 *    "response": {...}
 * }
 *
 * *******************************
 */

$input = file_get_contents('php://input');

logWrite(LOGFILE, "Incoming message = ".$input);

$inputArray = json_decode($input, true);
if(json_last_error() != JSON_ERROR_NONE){
	$outputJSON = array();
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid request content";    $outputJSON['response'] = "";
	/* Output */
	header('Content-Type: application/json');
	echo json_encode($outputJSON);
	logWrite(LOGFILE, "Invalid request content!");
	exit(-1);
}

/* -------------------------- */
/* ---- Input parameters ---- */
/* -------------------------- */

$tokenizedText = $inputArray['tokenizedtext'];
$watsonConversationID = $inputArray['conversationid'];
$watsonUserName = $inputArray['username'];
$watsonPassword = $inputArray['password'];
$watsonWorkspaceID = $inputArray['workspaceid'];
$timeout = $inputArray['timeout'];

logWrite(LOGFILE, "Conversation ID = ".$watsonConversationID);

$context = null;
$outputJSON = watsonConversationGetResponse($tokenizedText, $watsonConversationID, $watsonUserName, $watsonPassword, $watsonWorkspaceID, $timeout, "", $context);

/* ---------------- */
/* ---- Output ---- */
/* ---------------- */

$responseString = json_encode($outputJSON);

header('Content-Type: application/json');

echo $responseString;

logWrite(LOGFILE, "Response string = ".$responseString);

exit(0);


/* watsonConversationGetResponse
 * -----------------------------
 * Purpose : Get IBM's Watson conversation response from input 'tokenized' text
 * Input   :
 *  (1) '$tokenizedText' = input tokenized text(UTF-8)  (2) '$conversationID' = input conversation ID
 *  (3) '$userName' = Watson's credential username      (4) '$password' = Watson's credential password
 *  (5) '$workspaceID' = conversation's workspace ID    (6) '$timeout' = Watson service timeout in second
 *  (7) '$proxy' = local network proxy(if not used set to 'null')
 *  (8) '$context' = context variable of Watson conversation(JSON object)
 * Return  : Array of...
 *  (1) $retVal['status'] = Status of this function(SUCCESS/FAIL?)
 *  (2) $retVal['description'] = Status description
 *  (3) $retVal['response'] = Watson's JSON response
 * Note :
 *  Main conversation loop should keep 'context' value along conversation,
 *  if start of conversation please set '$context' to 'null'
 */

function watsonConversationGetResponse($tokenizedText, $conversationID, $userName, $password, $workspaceID, $timeout, $proxy, &$context)
{
	$retVal = array();

	$url = "https://gateway.watsonplatform.net/conversation/api/v1/workspaces/" . $workspaceID . "/message?version=2016-09-20";
		
	/* This is very simple form of conversation input text */
	if(empty($context)){
		/* Start of conversation */
		$context = array('conversation_id' => $conversationID);
	}

	$inputJSON = array('input' => array('text' => $tokenizedText), 'context' => $context);
	
	$inputJSONString = json_encode($inputJSON);
	$jerr = json_last_error();
	if($jerr != JSON_ERROR_NONE){
		/* JSON encode error! */
		logWrite(LOGFILE, "Input JSON error with code ".$jerr);
		$retVal['status'] = "FAIL";         $retVal['description'] = "Input JSON error with code ".$jerr;
		$retVal['response'] = array();
		return($retVal);
	}

	logWrite(LOGFILE, "Request JSON = \"". $inputJSONString . "\"");

	/* ------------------------------- */
	/* ---- Simple HTTP interface ---- */
	/* ------------------------------- */
	
	$curl = curl_init();

	curl_setopt($curl, CURLOPT_POST, 1);

	if(!empty($proxy)){
		curl_setopt($curl, CURLOPT_PROXY, $proxy);
	}

	$timeout_ms = intval(1000*$timeout);
	
	curl_setopt($curl, CURLOPT_URL, $url);
	/* curl_setopt($curl, CURLOPT_FAILONERROR, true); */
	curl_setopt($curl, CURLOPT_TIMEOUT_MS, $timeout_ms);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($curl, CURLOPT_USERPWD, $userName.":".$password);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $inputJSONString);

	$headers = array('Content-Type: application/json');
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

	/* Execute POST message */
	$resp = curl_exec($curl);

	$err = curl_error($curl);    $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	if($err){
		/* Curl error! */
		$errno = curl_errno($curl);
		if($errno == CURLE_OPERATION_TIMEDOUT){
			/* HTTP timeout */
			$retVal['status'] = "FAIL";    $retVal['description'] = "Timeout";
			$retVal['response'] = array();
		}
		else{
			$retVal['status'] = "FAIL";    $retVal['description'] = "Curl status \"".$err."\"";
			$retVal['response'] = array();
		}
		curl_close($curl);
		unset($curl);        $curl = null;
		return($retVal);
	}

	logWrite(LOGFILE, "HTTP status = ". $httpStatus . " , Response JSON = \"".$resp."\"");

	if($httpStatus != 200){
		/* HTTP fail! */
		$retVal['status'] = "FAIL";         $retVal['description'] = "HTTP status code ".$httpStatus;
		$retVal['response'] = array();
	}
	else{

		/* Convert text to JSON array */
		$jsonResp = json_decode($resp, true);

		/* HTTP success */
		$retVal['status'] = "SUCCESS";      $retVal['description'] = "HTTP status code ".$httpStatus;
		$retVal['response'] = $jsonResp;

		$context = $jsonResp['context'];
	}

	curl_close($curl);
	unset($curl);        $curl = null;

	return($retVal);
}

?>
