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


define('LOGFILE', '../log/genOTP_'.date('Ymd').'.log');


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

/* Params: mobileNo */
if(!array_key_exists('mobileNo' , $inputArray) || empty($inputArray['mobileNo'])){
	$outputJSON['responseCode'] = '1002';    $outputJSON['responseDesc'] = 'Invalid request content(No \'mobileNo\')';
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	$outputJSONStr = json_encode($outputJSON);
	echo $outputJSONStr;
	logWrite(LOGFILE, 'Output JSON = '.$outputJSONStr);
	exit(0);
}

$mobileNo = $inputArray['mobileNo'];

/* Params: nationalId */
if(!array_key_exists('nationalId' , $inputArray) || empty($inputArray['nationalId'])){
	$outputJSON['responseCode'] = "1002";    $outputJSON['responseDesc'] = 'Invalid request content(No \'nationalId\')';
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	$outputJSONStr = json_encode($outputJSON);
	echo $outputJSONStr;
	logWrite(LOGFILE, "Output JSON = ".$outputJSONStr);
	exit(0);
}

$nationalId = $inputArray['nationalId'];


/* --------------------------------------------- */
/* ---- Send 'nationalId' to back-ended API ---- */
/* --------------------------------------------- */

$personalInfo = getRMIDFromCityID($requestId, $nationalId);
if($personalInfo == null){
	$outputJSON['responseCode'] = "3001";    $outputJSON['responseDesc'] = "Call API get RMID fail";
	/* Output */
	http_response_code(500);
	header('Content-Type: application/json');
	$outputJSONStr = json_encode($outputJSON);
	echo $outputJSONStr;
	logWrite(LOGFILE, "Output JSON = ".$outputJSONStr);
	exit(0);
}

if($personalInfo['valid'] == true){
	$rmId = str_pad(RMID_PREFIX,LENGTHRMID-strlen($personalInfo['info']['partnerID']),'0').$personalInfo['info']['partnerID'];
	$mobileInfo = getMobilleNoFromRMID($requestId, $rmId);
	if($mobileInfo == null){
		$outputJSON['responseCode'] = "3002";    $outputJSON['responseDesc'] = "Call API Get MobileNo fail";
		/* Output */
		http_response_code(500);
		header('Content-Type: application/json');
		$outputJSONStr = json_encode($outputJSON);
		echo $outputJSONStr;
		logWrite(LOGFILE, "Output JSON = ".$outputJSONStr);
		exit(0);
	}
	if($mobileInfo['valid'] == true){
	  $validresponseCode = "0000";
		foreach ($mobileInfo['info'] as $info) {
			if(preg_replace("/[^0-9]/", "", $info['contactNumber']) == $mobileNo){
				$genOTPInfo = genOTPToEAPI($requestId, $mobileNo);
				if($genOTPInfo == null){

					$outputJSON['responseCode'] = "3003";    $outputJSON['responseDesc'] = "Call API genOTP fail";
					/* Output */
					http_response_code(500);
					header('Content-Type: application/json');
					$outputJSONStr = json_encode($outputJSON);
					echo $outputJSONStr;
					logWrite(LOGFILE, "Output JSON = ".$outputJSONStr);
					exit(0);

				}

				$outputJSON['responseCode'] = "0000";    $outputJSON['responseDesc'] = "OK";
				$outputJSON['rmId'] = $rmId;
				$outputJSON['tokenUUID'] = $genOTPInfo['info']['tokenUUID'];
				$outputJSON['reference'] = $genOTPInfo['info']['reference'];
			  $outputJSON['valid'] = $genOTPInfo['valid'];
				/* Add more info... */
				/* Output */
				http_response_code(200);
				header('Content-Type: application/json');
				$outputJSONStr = json_encode($outputJSON);
				echo $outputJSONStr;
				logWrite(LOGFILE, "Output JSON = ".$outputJSONStr);
				exit(0);

			}else {
			    $validresponseCode = "3004";
// 				$outputJSON['responseCode'] = "3004";    $outputJSON['responseDesc'] = "Not found Mobile No.";
// 				/* Output */
// 				http_response_code(200);
// 				header('Content-Type: application/json');
// 				$outputJSONStr = json_encode($outputJSON);
// 				echo $outputJSONStr;
// 				logWrite(LOGFILE, "Output JSON = ".$outputJSONStr);
// 				exit(0);
			}
		}

		if ($validresponseCode == "3004") {
    		$outputJSON['responseCode'] = "3004";    $outputJSON['responseDesc'] = "Not found Mobile No.";
    		/* Output */
    		http_response_code(200);
    		header('Content-Type: application/json');
    		$outputJSONStr = json_encode($outputJSON);
    		echo $outputJSONStr;
    		logWrite(LOGFILE, "Output JSON = ".$outputJSONStr);
    		exit(0);

		}
	}
}

if($personalInfo['valid'] == false || $mobileInfo['valid'] == false || $genOTPInfo['valid'] == false){
	/* Personal authen sucess(this person not exists in GSB system) */
	$outputJSON['responseCode'] = "3000";    $outputJSON['responseDesc'] = "Call API genOTP fail";
	$outputJSON['valid'] = false;
	http_response_code(200);
	header('Content-Type: application/json');
	$outputJSONStr = json_encode($outputJSON);
	echo $outputJSONStr;
	logWrite(LOGFILE, "Output JSON = ".$outputJSONStr);
	exit(0);
}

exit(0);


/* backendGetPersonalVertifyInfo
 * ----------------------------
 * Purpose : Get personal authenication info from back-end
 * Input   :
 *  (1) '$requestId'  = requestId from client
 *  (1) '$nationalId' = input 13-digit national ID
 * Return  : Personal info array
 */

function getRMIDFromCityID($requestId, $nationalId)
{
	/* Request */
	$url = URLHOSTEAPI."scb/rest/ent-api/v1/party/cust-profile/individuals/findByID?idNumber=".$nationalId;

	$retVal = getURLwithEAPI($url, $requestId, 10);
	if($retVal['status'] == "FAIL"){
		logWrite(LOGFILE, "getRMIDFromCityID: WARNING: status = ".$retVal['status']." , description = ".$retVal['description']." , httpcode = ".$retVal['httpcode']);
		logWrite(LOGFILE, "getRMIDFromCityID: WARNING: responsetext = ".$retVal['responsetext']);
		return(null);
	}

	logWrite(LOGFILE, "getRMIDFromCityID : Data Response : ".$retVal['responsetext']);

	/* Get response array */
	logWrite(LOGFILE, "getRMIDFromCityID: INFO: responsetext : ". $retVal['responsetext']);
	$responseArray = json_decode($retVal['responsetext'], true);
	if(json_last_error() != JSON_ERROR_NONE){
		logWrite(LOGFILE, "getRMIDFromCityID: WARNING: Invalid response text \"".$retVal['responsetext']."\"!");
		return(null);
	}

	/* Fill in output personal info */
	$personalInfo = array();
	if (count($responseArray['items']) > 0) {
		$personalInfo['valid'] = true;
		// if false no data other
		$personalInfo['info'] = array();
		$personalInfo['info'] = $responseArray['items'][0];
	}else {
		$personalInfo['valid'] = false;
	}
	return($personalInfo);
}

function getMobilleNoFromRMID($requestId, $RMID)
{
	/* Request */
	$url = URLHOSTEAPI."scb/rest/ent-api/v3/customer/profile/individuals/".$RMID."/contactChannels?contactTypeCode=002&mobileFilter=Y";

	$retVal = getURLwithEAPI($url, $requestId, 10);
	if($retVal['status'] == "FAIL" && $retVal['httpcode'] != 404){
		logWrite(LOGFILE, "getMobilleNoFromRMID: WARNING: status = ".$retVal['status']." , description = ".$retVal['description']." , httpcode = ".$retVal['httpcode']);
		logWrite(LOGFILE, "getMobilleNoFromRMID: WARNING: responsetext = ".$retVal['responsetext']);
		return(null);
	}

	logWrite(LOGFILE, "getMobilleNoFromRMID : Data Response : ".$retVal['responsetext']);

	/* Get response array */
	logWrite(LOGFILE, "getMobilleNoFromRMID: INFO: responsetext : ". $retVal['responsetext']);
	$responseArray = json_decode($retVal['responsetext'], true);
	if(json_last_error() != JSON_ERROR_NONE){
		logWrite(LOGFILE, "getMobilleNoFromRMID: WARNING: Invalid response text \"".$retVal['responsetext']."\"!");
		return(null);
	}

	/* Fill in output personal info */
	$mobileInfo = array();
	if($responseArray['errors'][0][originalErrorCode] == "RM1005"){
		$mobileInfo['valid'] = false;
	}else if (count($responseArray['items']) > 0) {
		$mobileInfo['valid'] = true;
		// if false no data other
		$mobileInfo['info'] = array();
		$mobileInfo['info'] = $responseArray['items'];
	}else {
		return(null);
	}

	return($mobileInfo);
}

function genOTPToEAPI($requestId, $mobileNo)
{
	$url = URLHOSTEAPI."scb/rest/ent-api/v3/txnAuth/OTP/generation";
	/* Request */
	$requestString = '{
    "otpKey": "TXN_00000001TON",
    "policyId": "SCB_Generic_OTAPolicy",
    "deliveryChannels": [
        {
            "channelAttrib1": "'.$mobileNo.'",
            "channelType": "SMS",
            "channelAttrib2": "OTP_Generic_NoSMS",
						"channelAttrib3": "ใช้",
            "channelAttrib4": "เพื่อยืนยันตัว",
            "channelAttrib5": "Valued customer"
        }
    ],
    "storeId": "SystemTokenStore",
    "realActorId": "FastEasyCardLessApp",
    "otpMessage": "'.MESSAGEOTP.'"
	}';
	// $requestArray = array('requestId' => $requestId, 'username' => API_USER, 'password' => API_PASSWORD, 'citizenId' => $nationalId); // add more parameter
	// $requestString = json_encode($requestArray);
	// logWrite(LOGFILE, "genOTPToEAPI: INFO: requesttext : ". $requestString);

	$retVal = postJSONStringToEAPI($requestId, $requestString, $url, 10);
	if($retVal['status'] == "FAIL"){
		logWrite(LOGFILE, "genOTPToEAPI: WARNING: status = ".$retVal['status']." , description = ".$retVal['description']." , httpcode = ".$retVal['httpcode']);
		logWrite(LOGFILE, "genOTPToEAPI: WARNING: responsetext = ".$retVal['responsetext']);
		return(null);
	}

	logWrite(LOGFILE, "genOTPToEAPI : Data Response : ".$retVal['responsetext']);

	/* Get response array */
	logWrite(LOGFILE, "genOTPToEAPI: INFO: responsetext : ". $retVal['responsetext']);
	$responseArray = json_decode($retVal['responsetext'], true);
	if(json_last_error() != JSON_ERROR_NONE){
		logWrite(LOGFILE, "genOTPToEAPI: WARNING: Invalid response text \"".$retVal['responsetext']."\"!");
		return(null);
	}

	/* Fill in output personal info */
	$genOTPInfo = array();
	$genOTPInfo['valid'] = true;
	// if false no data other
	$genOTPInfo['info'] = array();
	$genOTPInfo['info'] = $responseArray;
	return($genOTPInfo);
}


function getURLwithEAPI($url, $requestID, $timeout)
{
    $retVal = array();

    /* ------------------------------- */
    /* ---- Simple HTTP interface ---- */
    /* ------------------------------- */

    $curl = curl_init();

    $timeout_ms = intval(1000*$timeout);

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_TIMEOUT_MS, $timeout_ms);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		$requestUID = "requestUID: ".$requestID;
		$resourceOwnerID = "resourceOwnerID: ".EVENT_CODE;
		$sourceSystem = "sourceSystem: ".SOURCE_SYSTEM;
		$apiKey = "apikey: ".API_KEY_EAPI;
		$apiSecret = "apisecret: ".API_SECRET_EAPI;
		$headers = array($requestUID, $resourceOwnerID, $sourceSystem, $apiKey, $apiSecret);

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
