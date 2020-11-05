<?php header ("Content-Type: text/html; charset=UTF-8"); ?>
<?php

/* -----------------------------------------------------------------------
 * genOTP.php
 * -----------------------------------------------------------------------
 * Purpose : API to check personal authentication of
 *           input personal parameters
 * Author  : Pitichat Suttaroj <pitichat@tellvoice.com>
 *           Kittikorn	poonporn <kittikorn@tellvoice.com>
 * Created : 10 Jan 2019
 * History :
 * -----------------------------------------------------------------------
 */

// include_once("services.php");
include_once("../utils/tvutils.php");
include_once("config/authenconfig.php");


define('LOGFILE', '../log/validOTP_'.date('Ymd').'.log');


/* Unique ID */
$gbTransID = sprintf("%08x", abs(crc32($_SERVER['REMOTE_ADDR'] . $_SERVER['REQUEST_TIME'] . $_SERVER['REMOTE_PORT'])));

logWrite(LOGFILE, "Start API...");

/* Output JSON array */
$outputJSON = array(
	'requestId' => '',
	'responseCode' => '0000',
	'responseDesc' => 'OK',
	'valid' => false
);

/* --------------------------- */
/* ---- Is valid request? ---- */
/* --------------------------- */

if($_SERVER['REQUEST_METHOD'] != "POST"){
	$outputJSON['responseCode'] = "1001";    $outputJSON['responseDesc'] = "Invalid request method";
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	$outputJSONStr = json_encode($outputJSON);
	echo $outputJSONStr;
	logWrite(LOGFILE, "Output JSON = ".$outputJSONStr);
	exit(0);
}


/* -------------------------- */
/* ---- Input parameters ---- */
/* -------------------------- */

$inputContent = file_get_contents('php://input');

$inputArray = json_decode($inputContent, true);
if(json_last_error() != JSON_ERROR_NONE){
	$outputJSON['responseCode'] = "1002";    $outputJSON['responseDesc'] = "Invalid request content";
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	$outputJSONStr = json_encode($outputJSON);
	echo $outputJSONStr;
	logWrite(LOGFILE, "Output JSON = ".$outputJSONStr);
	exit(0);
}


/* Params: requestId */
if(!array_key_exists('requestId' , $inputArray)){
	$outputJSON['responseCode'] = '1002';    $outputJSON['responseDesc'] = 'Invalid request content(No \'requestId\')';
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	$outputJSONStr = json_encode($outputJSON);
	echo $outputJSONStr;
	logWrite(LOGFILE, 'Output JSON = '.$outputJSONStr);
	exit(0);
}

$requestId = $inputArray['requestId'];
$outputJSON['requestId'] = $requestId;

logWrite(LOGFILE, 'requestId: '.$requestId);

/* Params: otp */
if(!array_key_exists('otp' , $inputArray) || empty($inputArray['otp'])){
	$outputJSON['responseCode'] = '1002';    $outputJSON['responseDesc'] = 'Invalid request content(No \'otp\')';
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	$outputJSONStr = json_encode($outputJSON);
	echo $outputJSONStr;
	logWrite(LOGFILE, 'Output JSON = '.$outputJSONStr);
	exit(0);
}

$otpNo = $inputArray['otp'];

/* Params: tokenUUID */
if(!array_key_exists('tokenUUID' , $inputArray) || empty($inputArray['tokenUUID'])){
	$outputJSON['responseCode'] = "1002";    $outputJSON['responseDesc'] = 'Invalid request content(No \'tokenUUID\')';
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	$outputJSONStr = json_encode($outputJSON);
	echo $outputJSONStr;
	logWrite(LOGFILE, "Output JSON = ".$outputJSONStr);
	exit(0);
}

$tokenUUID = $inputArray['tokenUUID'];


/* --------------------------------------------- */
/* ---- Send 'nationalId' to back-ended API ---- */
/* --------------------------------------------- */

$validateOTP = validOTP($requestId, $otpNo, $tokenUUID);
if($validateOTP == null){
	$outputJSON['responseCode'] = "3001";    $outputJSON['responseDesc'] = "Call API valid OTP fail";
	/* Output */
	http_response_code(500);
	header('Content-Type: application/json');
	$outputJSONStr = json_encode($outputJSON);
	echo $outputJSONStr;
	logWrite(LOGFILE, "Output JSON = ".$outputJSONStr);
	exit(0);
}

if($validateOTP['status'] == true){
  logWrite(LOGFILE, "validateOTP JSON = ".print_r($validateOTP['info'],true));
	if($validateOTP['info']['status'] == "PASSED"){
    $outputJSON['responseCode'] = "0000";    $outputJSON['responseDesc'] = "OK";
    $outputJSON['valid'] = true;
  }else{
    $outputJSON['responseCode'] = $validateOTP['info']['errors'][0]['code'];    $outputJSON['responseDesc'] = $validateOTP['info']['errors'][0]['description'];
    $outputJSON['valid'] = false;
  }

	/* Add more info... */
	/* Output */
	http_response_code(200);
	header('Content-Type: application/json');
	$outputJSONStr = json_encode($outputJSON);
	echo $outputJSONStr;
	logWrite(LOGFILE, "Output JSON = ".$outputJSONStr);
	exit(0);
}
else if($personalInfo['status'] == false){
	/* Personal authen sucess(this person not exists in GSB system) */
	$outputJSON['responseCode'] = "3000";    $outputJSON['responseDesc'] = "Call API valid OTP fail";
	$outputJSON['valid'] = false;
	http_response_code(500);
	header('Content-Type: application/json');
	$outputJSONStr = json_encode($outputJSON);
	echo $outputJSONStr;
	logWrite(LOGFILE, "Output JSON = ".$outputJSONStr);
	exit(0);
}

exit(0);



function validOTP($requestId, $otpNo, $tokenUUID)
{
	$url = URLHOSTEAPI."scb/rest/ent-api/v3/txnAuth/OTP/validation";
	/* Request */
	$requestString = '{
    "otp": "'.$otpNo.'",
    "otpKey": "TXN_00000001TON",
    "tokenUUID": "'.$tokenUUID.'"
  }';
	// $requestArray = array('requestId' => $requestId, 'username' => API_USER, 'password' => API_PASSWORD, 'citizenId' => $nationalId); // add more parameter
	// $requestString = json_encode($requestArray);
	logWrite(LOGFILE, "validOTP: INFO: requesttext : ". $requestString);

	$retVal = postJSONStringToEAPI($requestId, $requestString, $url, 10);
	if($retVal['status'] == "FAIL" && ($retVal['httpcode'] != 409 && $retVal['httpcode'] != 400)){
		logWrite(LOGFILE, "validOTP: WARNING: status = ".$retVal['status']." , description = ".$retVal['description']." , httpcode = ".$retVal['httpcode']);
		logWrite(LOGFILE, "validOTP: WARNING: responsetext = ".$retVal['responsetext']);
		return(null);
	}

	/* Get response array */
	logWrite(LOGFILE, "validOTP: INFO: responsetext : ". $retVal['responsetext']);
	$responseArray = json_decode($retVal['responsetext'], true);
	if(json_last_error() != JSON_ERROR_NONE){
		logWrite(LOGFILE, "validOTP: WARNING: Invalid response text \"".$retVal['responsetext']."\"!");
		return(null);
	}

	/* Fill in output personal info */
	$validOTPInfo = array();
	$validOTPInfo['status'] = true;
	// if false no data other
	$validOTPInfo['info'] = array();
	$validOTPInfo['info'] = $responseArray;
	return($validOTPInfo);
}

function postJSONStringToEAPI($requestID, $jsonOutString, $url, $timeout)
{
	$retVal = array();

	/* ------------------------------- */
	/* ---- Simple HTTP interface ---- */
	/* ------------------------------- */

	$curl = curl_init();

	curl_setopt($curl, CURLOPT_POST, 1);

	$timeout_ms = intval(1000*$timeout);

	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_TIMEOUT_MS, $timeout_ms);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonOutString);

	$requestUID = "requestUID: ".$requestID;
	$resourceOwnerID = "resourceOwnerID: ".EVENT_CODE;
	$sourceSystem = "sourceSystem: ".SOURCE_SYSTEM;
	$apiKey = "apikey: ".API_KEY_EAPI;
	$apiSecret = "apisecret: ".API_SECRET_EAPI;
	$content = "Content-Type: application/json";
	$headers = array($content, $requestUID, $resourceOwnerID, $sourceSystem, $apiKey, $apiSecret);

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
					$retVal['httpcode'] = $httpStatus;
					$retVal['responsetext'] = $resp;
			}
			else{
					$retVal['status'] = "FAIL";    $retVal['description'] = "Curl description \"".$err."\"";
					$retVal['httpcode'] = $httpStatus;
					$retVal['responsetext'] = $resp;
			}
			curl_close($curl);
			unset($curl);        $curl = null;
			return $retVal;
	}

	if($httpStatus != 200){
			/* HTTP fail! */
			$retVal['status'] = "FAIL";         $retVal['description'] = "HTTP status code ".$httpStatus;
			$retVal['httpcode'] = $httpStatus;
			$retVal['responsetext'] = $resp;
	}
	else{
			/* HTTP success */
			$retVal['status'] = "SUCCESS";      $retVal['description'] = "HTTP status code ".$httpStatus;
			$retVal['httpcode'] = $httpStatus;
			$retVal['responsetext'] = $resp;
	}

	curl_close($curl);
	unset($curl);        $curl = null;

	return $retVal;
}

?>
