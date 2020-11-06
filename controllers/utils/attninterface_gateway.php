<?php header ("Content-Type: text/html; charset=UTF-8"); ?>
<?php
//ini_set("display_errors" , 1);
//ini_set("error_reporting" , E_ALL);

include_once("../utils/tvutils.php");

define('LOGFILE', '../log/log_utils/attninterface_gateway_'.date('Ymd').'.log');

$gbTransID = generateRandomString(10);


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
 *     "attach_filename": $attach_filename,
 *     "attach_original" => $attach_original
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
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid request content";
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

$attach_filename = $inputArray['attach_filename'];
if(empty($attach_filename)){
	$outputJSON = array();
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid request content(No 'attach_filename')";
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	echo json_encode($outputJSON);
	logWrite(LOGFILE, "Invalid request content(No httpmethod)");
	exit(-1);
}

$attach_original = $inputArray['attach_original'];
if(empty($attach_original)){
	$outputJSON = array();
	$outputJSON['status'] = "FAIL";    $outputJSON['description'] = "Invalid request content(No 'attach_original')";
	/* Output */
	http_response_code(400);
	header('Content-Type: application/json');
	echo json_encode($outputJSON);
	logWrite(LOGFILE, "Invalid request content(No 'tid')");
	exit(-1);
}


logWrite(LOGFILE, "attach_original = ".$attach_original);
logWrite(LOGFILE, "attach_filename = ".$attach_filename);

if (isset($inputArray['attach_basepath'])) {
	$attach_basepath = $inputArray['attach_basepath'];
	logWrite(LOGFILE, "attach_basepath = ".$attach_basepath);

	//Check if the directory already exists.
	if(!is_dir($attach_basepath)){
		//Directory does not exist, so lets create it.
		logWrite(LOGFILE, "[".$attach_basepath."] does not exist!!!!!");
		mkdir($attach_basepath, 0755, true);
	}
}

$outputJSON = array();
file_put_contents($attach_filename, fopen($attach_original, 'r'));
if(is_file($attach_filename)){
	/* success */
	$outputJSON['status'] = "SUCCESS";
	$outputJSON['description'] = "Get attachment to server";

	logWrite(LOGFILE, "Get attachment to server : SUCCESS ");
	chmod($attach_filename, 0755);
} else {
	/* fail */
	$outputJSON['status'] = "FAIL";
	$outputJSON['description'] = "Cannot get attachment to server";

	logWrite(LOGFILE, "Get attachment to server : FAIL ");
}


/* ---------------- */
/* ---- Output ---- */
/* ---------------- */

http_response_code(200);

header('Content-Type: application/json');

$responseString = json_encode($outputJSON);

echo $responseString;

logWrite(LOGFILE, "Response string = \"".$responseString."\"");

exit(0);

?>