<?php header ("Content-Type: text/html; charset=UTF-8"); ?>
<?php

/* -----------------------------------------------------------------------
 * jsonhttpinterface_gateway.php
 * -----------------------------------------------------------------------
 * Purpose : TV general purpose routine for other HTTP services interface
 *           via gateway(content type should be JSON only)
 * Author  : Pitichat Suttaroj <pitichat@tellvoice.com>
 * Created : 03 Apr 2018
 * History :
 *  03 Apr 2018 - Create file
 *  04 Apr 2018 - Modify script script response #1
 * -----------------------------------------------------------------------
 */

include_once("../dbutil/includes/services.php");
include_once("../utils/tvutils.php");

define('LOGFILE', '../log/log_utils/jsonhttpinterface_gateway_'.date('Ymd').'.log');


/* Unique ID */
$gbTransID = sprintf("%08x", abs(crc32($_SERVER['REMOTE_ADDR'] . $_SERVER['REQUEST_TIME'] . $_SERVER['REMOTE_PORT'])));

/* Is valid request? */
if($_SERVER['REQUEST_METHOD'] != "POST"){
	$outputJSON = array();
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid request method";
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	echo json_encode($outputJSON);
	exit(-1);
}

if($_SERVER["CONTENT_TYPE"] != "application/json"){
	$outputJSON = array();
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid content type";
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	echo json_encode($outputJSON);
	exit(-1);
}


/* Input JSON format
 * -----------------
 * {
 *     "httpmethod": $httpMethod,
 *     "tid" => $tid,
 *     "url" => $targetURL,
 *     "querypairs" => $queryStringArray,
 *     "accesstoken" => $accessToken,
 *     "contents": $contentArray,
 *     "timeout" => $timeout
 * }
 *
 * *******************************
 *
 * Output JSON format
 * ------------------
 * {
 *    "status": "SUCCESS"/"FAIL"?,
 *    "httpcode": $ReturnHTTPCodeFromLine,
 *    "description": $ErrorDescription,
 *    "responsetext": $ResponseText
 * }
 *
 * *******************************
 */

$input = file_get_contents('php://input');

logWrite(LOGFILE, "Incoming message = ".$input);

$inputArray = json_decode($input, true);
if(json_last_error() != JSON_ERROR_NONE){
	$outputJSON = array();
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid request content";
	$outputJSON['httpcode'] = "";      $outputJSON['responsetext'] = "";
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	echo json_encode($outputJSON);
	logWrite(LOGFILE, "Invalid request content!");
	exit(-1);
}

/* -------------------------- */
/* ---- Input parameters ---- */
/* -------------------------- */

$httpMethod = $inputArray['httpmethod'];
if(empty($httpMethod)){
	$outputJSON = array();
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid request content(No 'httpmethod')";
	$outputJSON['httpcode'] = "";      $outputJSON['responsetext'] = "";
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	echo json_encode($outputJSON);
	logWrite(LOGFILE, "Invalid request content(No httpmethod)");
	exit(-1);
}

$tid = $inputArray['tid'];
if(empty($tid)){
	$outputJSON = array();
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid request content(No 'tid')";
	$outputJSON['httpcode'] = "";      $outputJSON['responsetext'] = "";
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	echo json_encode($outputJSON);
	logWrite(LOGFILE, "Invalid request content(No 'tid')");
	exit(-1);
}

$url = $inputArray['url'];
if(empty($url)){
	$outputJSON = array();
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid request content(No 'url')";
	$outputJSON['httpcode'] = "";      $outputJSON['responsetext'] = "";
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	echo json_encode($outputJSON);
	logWrite(LOGFILE, "Invalid request content(No 'url')");
	exit(-1);
}

$queryStrArray = $inputArray['querypairs'];
if(empty($queryStrArray)){
	$queryStrArray = array();
}

$accessToken = $inputArray['accesstoken'];
if(empty($accessToken)){
	$accessToken = "";
}

$contentArray = $inputArray['contents'];
if(empty($contentArray)){
	$contentArray = array();
}

$timeout = $inputArray['timeout'];
if(empty($timeout)){
	$timeout = 5;                     /* Default is 5 second */
}

logWrite(LOGFILE, "tid = ".$tid);

$contentText = json_encode($contentArray);
$outputJSON = httpInterface($httpMethod, $url, $queryStrArray, $accessToken, $contentText, $timeout);

/* ---------------- */
/* ---- Output ---- */
/* ---------------- */

http_response_code(200);

header('Content-Type: application/json');

$responseString = json_encode($outputJSON);

echo $responseString;

logWrite(LOGFILE, "Response string = \"".$responseString."\"");

exit(0);


/* httpInterface
 * -------------
 * Purpose : Main HTTP interface function
 * Input   :
 *  (1) '$httpMethod' = input HTTP method("GET"/"POST"/"PUT"/"DELETE")
 *  (2) '$url' = Wit.ai URL(base)
 *  (3) '$queryStrArray' = query string array
 *  (4) '$accessToken' = Access token
 *  (5) '$contentText' = outgoing content text(JSON) to other HTTP service
 *  (6) '$timeout' = response timeout in second
 * Return  : Array of...
 *  (1) $retVal['status'] = Status of this function(SUCCESS/FAIL?)
 *  (2) $retVal['description'] = Status description
 *  (3) $retVal['httpcode'] = Returned HTTP status from other HTTP service
 *  (4) $retVal['responsetext'] = Response from other HTTP service
 */

function httpInterface($httpMethod, $url, $queryStrArray, $accessToken, $contentText, $timeout)
{
	$retVal = array();

	$queryString = http_build_query($queryStrArray);

	if(!empty($queryString)){
		$url = $url."?".$queryString;
	}

	logWrite(LOGFILE, "httpInterface: URL = \"".$url."\"");
	logWrite(LOGFILE, "httpInterface: contentText = \"".$contentText."\"");

	$curl = curl_init();

	curl_setopt($curl, CURLOPT_URL, $url);

	switch($httpMethod){
		case "GET":
			break;
		case "POST":
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $contentText);
			break;
		case "PUT":
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
			if(!empty($contentText)){
				curl_setopt($curl, CURLOPT_POSTFIELDS, $contentText);
			}
			break;
		case "DELETE":
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
			if(!empty($contentText)){
				curl_setopt($curl, CURLOPT_POSTFIELDS, $contentText);
			}
			break;
	}

	$timeout_ms = intval(1000*$timeout);
	
	curl_setopt($curl, CURLOPT_TIMEOUT_MS, $timeout_ms);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

	if(empty($accessToken)){
		$headers = array('Content-Type: application/json');
	}
	else{
		$authorization = "Authorization: Bearer ".$accessToken;
		$headers = array('Content-Type: application/json', $authorization);    // Plus authorization in HTTP header
	}
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
			$retVal['responsetext'] = "";
		}
		else{
			$retVal['status'] = "FAIL";    $retVal['description'] = "Curl status \"".$err."\"";
			$retVal['httpcode'] = $httpStatus;
			$retVal['responsetext'] = $resp;
		}
		curl_close($curl);
		unset($curl);        $curl = null;
		return($retVal);
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

	return($retVal);
}

?>
