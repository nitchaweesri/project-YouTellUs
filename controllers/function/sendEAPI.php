<?php header ("Content-Type: text/html; charset=UTF-8"); ?>
<?php

include_once("config/authenconfig.php");
include_once("../dbutil/includes/services.php");
include_once("../utils/tvutils.php");


define('LOGFILE', '../log/sendEAPI_'.date('Ymd').'.log');


/* Unique ID */
$gbTransID = sprintf("%08x", abs(crc32($_SERVER['REMOTE_ADDR'] . $_SERVER['REQUEST_TIME'] . $_SERVER['REMOTE_PORT'])));

logWrite(LOGFILE, "Start E API outgoing script...");

/* Output JSON array */
$outputJSON = array(
    'requestId' => '',
    'responseCode' => '0000',
    'responseDesc' => 'OK'
);

/* --------------------------- */
/* ---- Is valid authen? ---- */
/* --------------------------- */

$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];

$validated = (in_array($user, VALID_USER)) && ($pass == VALID_PASSWORDS[$user]);

if (!$validated) {
    $outputJSON['responseCode'] = "1000";    $outputJSON['responseDesc'] = "Unauthorized";
    /* Output */
    http_response_code(403);
    header('Content-Type: application/json');
    $outputJSONStr = json_encode($outputJSON);
    echo $outputJSONStr;
    logWrite(LOGFILE, "Output JSON = ".$outputJSONStr);
    exit(0);
}

/* --------------------------- */
/* ---- Is valid request? ---- */
/* --------------------------- */

if($_SERVER['REQUEST_METHOD'] != "POST"){
    $outputJSON['responseCode'] = "1001";    $outputJSON['responseDesc'] = "Invalid request method";
    /* Output */
    http_response_code(405);
    header('Content-Type: application/json');
    $outputJSONStr = json_encode($outputJSON);
    echo $outputJSONStr;
    logWrite(LOGFILE, "Output JSON = ".$outputJSONStr);
    exit(0);
}

if($_SERVER["CONTENT_TYPE"] != "application/json"){
	$outputJSON['status'] = "1001";    $outputJSON['description'] = "Invalid content type";
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	echo json_encode($outputJSON);
	logWrite(LOGFILE, 'Output JSON = '.$outputJSONStr);
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

logWrite(LOGFILE, 'inputArray : '.print_r($inputArray, true));

/* -------------------------- */
/* ---- Input parameters ---- */
/* -------------------------- */

/* Params: caseId */
if(!array_key_exists('caseId' , $inputArray) || empty($inputArray['caseId'])){
    $outputJSON['responseCode'] = '1002';    $outputJSON['responseDesc'] = 'Invalid request content(No "caseId")';
    /* Output */
    http_response_code(400);
    header('Content-Type: application/json');
    $outputJSONStr = json_encode($outputJSON);
    echo $outputJSONStr;
    logWrite(LOGFILE, 'Output JSON = '.$outputJSONStr);
    exit(0);
}

$caseId = $inputArray['caseId'];

/* Params: type */
if(!array_key_exists('type' , $inputArray) || empty($inputArray['type'])){
    $outputJSON['responseCode'] = '1002';    $outputJSON['responseDesc'] = 'Invalid request content(No "type")';
    /* Output */
    http_response_code(400);
    header('Content-Type: application/json');
    $outputJSONStr = json_encode($outputJSON);
    echo $outputJSONStr;
    logWrite(LOGFILE, 'Output JSON = '.$outputJSONStr);
    exit(0);
}

$type = $inputArray['type'];

/* Params: timestamp */
if(!array_key_exists('timestamp' , $inputArray) || empty($inputArray['timestamp'])){
    $outputJSON['responseCode'] = '1002';    $outputJSON['responseDesc'] = 'Invalid request content(No "timestamp")';
    /* Output */
    http_response_code(400);
    header('Content-Type: application/json');
    $outputJSONStr = json_encode($outputJSON);
    echo $outputJSONStr;
    logWrite(LOGFILE, 'Output JSON = '.$outputJSONStr);
    exit(0);
}

$timestamp = $inputArray['timestamp'];
$timeStamp = substr($timeStamp, 0, 10);
$dateTime = date_create(date("Y-m-d H:i:s", $timeStamp));
date_modify($dateTime,"+543 years");

$sqlStatement = "SELECT REQ_TYPE FROM LOG_EAPI_PUBLISH WHERE CASEID=? AND (REQ_TYPE=? OR REQ_TYPE=?) ORDER BY RECID DESC LIMIT 0, 1";
$value = array($caseId, 'O', 'C');
$queryResult = getQueryResult($sqlStatement, $value);

$skipSendEAPI = false;
if ($type == 'Open' && ($queryResult['numrows'] <= 0 || $queryResult['info'][0]['REQ_TYPE'] == 'C')) {
	$subEventCode = '01';
  $interactionType = 'O';
  $interactionDesc = 'publication to ADD';
}else if($type == 'Open' && $queryResult['info'][0]['REQ_TYPE'] == 'O'){
	$skipSendEAPI = true;
  $interactionType = 'G';
  $interactionDesc = 'Inquiry to GET';
}else if($type == 'Update' && $queryResult['info'][0]['REQ_TYPE'] == 'O'){
	$subEventCode = '02';
  $interactionType = 'U';
  /* Params: valid */
  if(!array_key_exists('valid' , $inputArray) || empty($inputArray['valid'])){
      $outputJSON['responseCode'] = '1002';    $outputJSON['responseDesc'] = 'Invalid request content(No "valid")';
      /* Output */
      http_response_code(400);
      header('Content-Type: application/json');
      $outputJSONStr = json_encode($outputJSON);
      echo $outputJSONStr;
      logWrite(LOGFILE, 'Output JSON = '.$outputJSONStr);
      exit(0);
  }
  $statusCurrent = $inputArray['valid'];

  // $statusPM = $queryResult['info'][0]['CURRVER'];
  /* Params: rmId */
  if(!array_key_exists('rmId' , $inputArray) || empty($inputArray['rmId'])){
      $outputJSON['responseCode'] = '1002';    $outputJSON['responseDesc'] = 'Invalid request content(No "rmId")';
      /* Output */
      http_response_code(400);
      header('Content-Type: application/json');
      $outputJSONStr = json_encode($outputJSON);
      echo $outputJSONStr;
      logWrite(LOGFILE, 'Output JSON = '.$outputJSONStr);
      exit(0);
  }
  $rmId = $inputArray['rmId'];
  $interactionDesc = 'publication to UPDATE';
}else if($type == 'Close' && $queryResult['info'][0]['REQ_TYPE'] == 'O'){
	$subEventCode = '03';
  $interactionType = 'C';
  $interactionDesc = 'publication to CLOSE';
}else {
  logWrite(LOGFILE, "Can't send to salesforce 'Miss Condition!!!'");
  $outputJSON['responseCode'] = "1001";    $outputJSON['responseDesc'] = "Can't send to salesforce 'Miss Condition!!!'";
  http_response_code(400);
  header('Content-Type: application/json');
  $outputJSONStr = json_encode($outputJSON);
  echo $outputJSONStr;
  logWrite(LOGFILE, 'Output JSON = '.$outputJSONStr);
  exit(0);
}
logWrite(LOGFILE, "skipSendEAPI : ".$skipSendEAPI);
logWrite(LOGFILE, "REQ_TYPE : ".$queryResult['info'][0]['REQ_TYPE']);
if(!$skipSendEAPI){
  $requestUID = gen_uuid();
  $sqlStatement = "SELECT SOCIAL_CUSTID, FEEDTYPE, FEEDSUBTYPE, CURRVER, INTENTID, INTENTION, AGENTID, CREATED_DT FROM CASEINFO WHERE CASEID=? ORDER BY CASEID DESC LIMIT 0, 1";
  $value = array($caseId);
  $queryResult = getQueryResult($sqlStatement, $value);
  if($queryResult['numrows'] <= 0){
      logWrite(LOGFILE, "There is no active case ID");
      $outputJSON['responseCode'] = "1001";    $outputJSON['responseDesc'] = "There is no active case";
      http_response_code(400);
      header('Content-Type: application/json');
      $outputJSONStr = json_encode($outputJSON);
      echo $outputJSONStr;
      logWrite(LOGFILE, 'Output JSON = '.$outputJSONStr);
      exit(0);
  }
  $userId = $queryResult['info'][0]['SOCIAL_CUSTID'];
  $socialType = MASTER_FEEDTYPE[$queryResult['info'][0]['FEEDTYPE']];
  $socialSubType = MASTER_FEEDSUBTYPE[$queryResult['info'][0]['FEEDSUBTYPE']];
  $agentId = $queryResult['info'][0]['AGENTID'];
  $intentId = $queryResult['info'][0]['INTENTID'];
  $intentionType = $queryResult['info'][0]['INTENTION'];
  $createdDT = $queryResult['info'][0]['CREATED_DT'];
  // $sqlStatement = "SELECT INTENTDESC FROM MASTER_INTENTIONS WHERE INTENTID=?";
  // $value = array($intentId);
  // $queryResult = getQueryResult($sqlStatement, $value);
  $contactProduct = $socialType; // $queryResult['info'][0]['INTENTDESC'];
  $sqlStatement = "SELECT USERNAME FROM USERINFO WHERE USERID=?";
  $value = array($agentId);
  $queryResult = getQueryResult($sqlStatement, $value);
  $staffId =  $queryResult['info'][0]['USERNAME'];
  $sqlStatement = "SELECT RMID FROM CUST_SOCIALCONTACTS WHERE SOCIAL_CUSTID=?";
  $value = array($userId);
  $queryResult = getQueryResult($sqlStatement, $value);
  if($queryResult['info'][0]['RMID'] != ""){
    $rmId = $queryResult['info'][0]['RMID'];
  }
  if($type == 'Open'){
    $publicationBody = '{
    	"socialID":"'.$userId.'",
    	"contactChannel":"'.$socialType.'",
    	"contactType":"'.$socialSubType.'",
    	"interactionID":"'.$caseId.'",
    	"interactionType":"'.$interactionType.'",
    	"actionTimestamp":"'.date_format($dateTime, "Y-m-d H:i:s").'",
    	"contactProduct":"'.$contactProduct.'",
    	"intentionType":"'.$intentionType.'",
    	"staffID":"'.$staffId.'"
    }';
  }else if ($type == 'Update') {
    $publicationBody = '{
    	"socialID":"'.$userId.'",
    	"contactChannel":"'.$socialType.'",
    	"contactType":"'.$socialSubType.'",
    	"interactionID":"'.$caseId.'",
    	"interactionType":"'.$interactionType.'",
      "verification":[
        { "verifyType":"PV","verifyStatus":"'.$statusCurrent.'"}
      ],
    	"actionTimestamp":"'.date_format($dateTime, "Y-m-d H:i:s").'",
    	"contactProduct":"'.$contactProduct.'",
    	"intentionType":"'.$intentionType.'",
    	"staffID":"'.$staffId.'"
    }';
  }else if($type == 'Close'){
    $publicationBody = '{
    	"socialID":"'.$userId.'",
    	"contactChannel":"'.$socialType.'",
    	"contactType":"'.$socialSubType.'",
    	"interactionID":"'.$caseId.'",
    	"interactionType":"'.$interactionType.'",
    	"actionTimestamp":"'.date_format($dateTime, "Y-m-d H:i:s").'",
    	"contactProduct":"'.$contactProduct.'",
    	"intentionType":"'.$intentionType.'",
    	"staffID":"'.$staffId.'"
    }';
  }
  if($type == 'Open' && $socialType == 'Line'){
    $publicationBody = '{
    	"socialID":"'.$userId.'",
    	"contactChannel":"'.$socialType.'",
    	"contactType":"'.$socialSubType.'",
    	"interactionID":"'.$caseId.'",
    	"interactionType":"'.$interactionType.'",
      "verification":[
        { "verifyType":"PM","verifyStatus":"S"}
      ],
    	"actionTimestamp":"'.date_format($dateTime, "Y-m-d H:i:s").'",
    	"contactProduct":"'.$contactProduct.'",
    	"intentionType":"'.$intentionType.'",
    	"staffID":"'.$staffId.'"
    }';
  }else if($type == 'Update' && $socialType == 'Line'){
    $publicationBody = '{
    	"socialID":"'.$userId.'",
    	"contactChannel":"'.$socialType.'",
    	"contactType":"'.$socialSubType.'",
    	"interactionID":"'.$caseId.'",
    	"interactionType":"'.$interactionType.'",
      "verification":[
        { "verifyType":"PM","verifyStatus":"S"},
        { "verifyType":"PV","verifyStatus":"'.$statusCurrent.'"}
      ],
    	"actionTimestamp":"'.date_format($dateTime, "Y-m-d H:i:s").'",
    	"contactProduct":"'.$contactProduct.'",
    	"intentionType":"'.$intentionType.'",
    	"staffID":"'.$staffId.'"
    }';
  }else if($type == 'Update' && $socialType == 'Facebook' && array_key_exists('typeCurrent' , $inputArray) && array_key_exists('typeOld' , $inputArray)){
    $publicationBody = '{
    	"socialID":"'.$userId.'",
    	"contactChannel":"'.$socialType.'",
    	"contactType":"'.$socialSubType.'",
    	"interactionID":"'.$caseId.'",
    	"interactionType":"'.$interactionType.'",
      "verification":[
        { "verifyType":"'.$inputArray['typeOld'].'","verifyStatus":"'.$inputArray['statusOld'].'"},
        { "verifyType":"'.$inputArray['typeCurrent'].'","verifyStatus":"'.$statusCurrent.'"}
      ],
    	"actionTimestamp":"'.date_format($dateTime, "Y-m-d H:i:s").'",
    	"contactProduct":"'.$contactProduct.'",
    	"intentionType":"'.$intentionType.'",
    	"staffID":"'.$staffId.'"
    }';
  }else if($type == 'Update' && $socialType == 'Facebook' && array_key_exists('typeCurrent' , $inputArray)){
    $publicationBody = '{
    	"socialID":"'.$userId.'",
    	"contactChannel":"'.$socialType.'",
    	"contactType":"'.$socialSubType.'",
    	"interactionID":"'.$caseId.'",
    	"interactionType":"'.$interactionType.'",
      "verification":[
        { "verifyType":"'.$inputArray['typeCurrent'].'","verifyStatus":"'.$statusCurrent.'"}
      ],
    	"actionTimestamp":"'.date_format($dateTime, "Y-m-d H:i:s").'",
    	"contactProduct":"'.$contactProduct.'",
    	"intentionType":"'.$intentionType.'",
    	"staffID":"'.$staffId.'"
    }';
  }else if($type == 'Update' && $socialType == 'Facebook'){
    $publicationBody = '{
    	"socialID":"'.$userId.'",
    	"contactChannel":"'.$socialType.'",
    	"contactType":"'.$socialSubType.'",
    	"interactionID":"'.$caseId.'",
    	"interactionType":"'.$interactionType.'",
      "verification":[
        { "verifyType":"PM","verifyStatus":"'.$statusCurrent.'"}
      ],
    	"actionTimestamp":"'.date_format($dateTime, "Y-m-d H:i:s").'",
    	"contactProduct":"'.$contactProduct.'",
    	"intentionType":"'.$intentionType.'",
    	"staffID":"'.$staffId.'"
    }';
  }
  $postField = '{
    "publicationHeaders": {
      "eventCode": "'.EVENT_CODE.'",
      "eventDesc": "'.EVENT_DESC.'",
      "eventRQUID": "'.$requestUID.'",
      "eventSource": "'.SOURCE_SYSTEM.'",
      "timeStamp": "'.date_format($dateTime,"Y-m-d\TH:i:sP").'",
      "contentType": "application/json",
      "subEventCode": "'.$subEventCode.'",
      "eventStatus": "S",
      "eventStatusCode": "SUCCESS"
    },
    "retainPublicationFlag": "N",
    "topicString": "'.TOPIC_STRING.'",
    "publicationBody": '.json_encode($publicationBody).',
    "timeToLive": 60000
  }';

  if(isset($rmId)){
    $postField = '{
      "publicationHeaders": {
        "eventCode": "'.EVENT_CODE.'",
        "eventDesc": "'.EVENT_DESC.'",
        "eventRQUID": "'.$requestUID.'",
        "eventSource": "'.SOURCE_SYSTEM.'",
        "timeStamp": "'.date_format($dateTime,"Y-m-d\TH:i:sP").'",
        "contentType": "application/json",
        "subEventCode": "'.$subEventCode.'",
        "eventStatus": "S",
        "eventStatusCode": "SUCCESS",
        "customerID": "'.$rmId.'"
      },
      "retainPublicationFlag": "N",
      "topicString": "'.TOPIC_STRING.'",
      "publicationBody": '.json_encode($publicationBody).',
      "timeToLive": 60000
    }';
  }

  logWrite(LOGFILE, "postJSONStringToEAPI: INFO: postField : ". $postField);
  $url = URLHOSTEAPI."scb/rest/ent-api/v1/support/utility/businessEvents/publication";
  $retVal = postJSONStringToEAPI($requestUID, $postField, $url, 10);
  logWrite(LOGFILE, "postJSONStringToEAPI: INFO: retVal : ". print_r($retVal, true));
  if($retVal['status'] != "SUCCESS"){
  	$httpResponseCode = empty($retVal['httpcode'])?404:$retVal['httpcode'];
  	http_response_code($httpResponseCode);
    header('Content-Type: application/json');
    echo json_encode($retVal);
    exit(0);
  }
  $sqlStatement = "INSERT INTO LOG_EAPI_PUBLISH (REQ_DT, REQ_NAME, REQ_TYPE, REQ_MSG, RESP_MSG, CASEID, AGENTID) VALUES (NOW(), ?, ?, ?, ?, ?, ?)";
  $value = array($interactionDesc, $interactionType, $postField, json_encode($retVal), $caseId, $agentId);
  $execInfo = executeSQL_LastInsertId($sqlStatement, $value);
  if($execInfo["isSuccess"] == true){
      $custContactID = $execInfo["lastId"];
  }
  else{
      logWrite(LOGFILE, "ADD salesforce: ERROR: Cannot insert LOG to 'LOG_EAPI_PUBLISH'!(".$execInfo["errorDescp"].")");
  }
  if($type == 'Update' || $type == 'Close'){
    header('Content-Type: application/json');
    echo json_encode($retVal);
    logWrite(LOGFILE, "Resp : ".json_encode($retVal));
    logWrite(LOGFILE, "type is Update or Close End of script");
    exit(0);
  }
  sleep(11);
}

/*

*/





/* Request get popup */

$url = URLHOSTEAPI."scb/rest/ent-api/v1/customerServices/socialCustInfo/Inquiry";
$requestArray = array('interactionId' => $caseId); // add more parameter
$requestString = json_encode($requestArray);
logWrite(LOGFILE, "getPopUpSalesForce: INFO: requesttext : ". $requestString);

$retVal = postJSONStringToEAPI(gen_uuid(), $requestString, $url, 10);
logWrite(LOGFILE, "getPopUpSalesForce: INFO: retVal : ". print_r($retVal, true));
/* ---------------- */
/* ---- Output ---- */
/* ---------------- */

$httpResponseCode = 200;
if($retVal['status'] != "SUCCESS"){
	$httpResponseCode = empty($retVal['httpcode'])?404:$retVal['httpcode'];
	http_response_code($httpResponseCode);
}
$sqlStatement = "INSERT INTO LOG_EAPI_PUBLISH (REQ_DT, REQ_NAME, REQ_TYPE, REQ_MSG, RESP_MSG, CASEID, AGENTID) VALUES (NOW(), ?, ?, ?, ?, ?, ?)";
$value = array("Inquiry to GET", "G", $postField, json_encode($retVal), $caseId, $agentId);
$execInfo = executeSQL_LastInsertId($sqlStatement, $value);
if($execInfo["isSuccess"] == true){
    $custContactID = $execInfo["lastId"];
}
else{
    logWrite(LOGFILE, "ADD Salesforce: ERROR: Cannot insert LOG to 'LOG_EAPI_PUBLISH'!(".$execInfo["errorDescp"].")");
}

header('Content-Type: application/json');
echo json_encode($retVal);

logWrite(LOGFILE, "End of script");

exit(0);

//------------------------------------------------------------------------------------------//
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

function gen_uuid() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}
?>
