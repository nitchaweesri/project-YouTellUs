<?php header ("Content-Type: text/html; charset=UTF-8"); ?>
<?php

/* -----------------------------------------------------------------------
 * tvutils.php
 * -----------------------------------------------------------------------
 * Purpose : TV utility routines for chatbot development
 * Author  : Pitichat Suttaroj <pitichat@tellvoice.com>
 * Created : 18 Jul 2017
 * History :
 *  18 Jul 2017 - Create file
 *  06 Sep 2017 - Add function "postJSONString()"
 *  07 Sep 2017 - Change path of TV_WORDSEGMENTATION_PROGRAM
 *  13 Sep 2017 - Add function "getFromURL()"
 *  21 Sep 2017 - Modify "postJSONString()" and "getFromURL()"
 *  25 Sep 2017 - Add function "generateRandomString()"
 *              - Add function "microtime_float()"
 *  05 Oct 2017 - Add function "postString()"
 *  08 Mar 2018 - Modify function "logWrite()"
 *  01 Aug 2018 - Add function "verifySocialID()"
 *  01 Aug 2018 - Add function "_GetCustomerPriority()"
 *  28 Sep 2018 - Modify function "verifySocialID()" for Facebook
 *  10 Oct 2018 - Modify function "verifySocialID()" for Email
 *  08 Jan 2019 - Remove function "getFacebookPSID()"
 *  08 Jan 2019 - Remove function "getFacebookASID()"
 *  08 Jan 2019 - Remove function "getFacebookID()"
 *  08 Jan 2019 - Remove function "getFacebookID_TSR()"
 *  08 Jan 2019 - Remove function "getFacebookASID_TSR()"
 *  08 Jan 2019 - Remove function "manage_fb_contact()"
 *  08 Jan 2019 - Modify function "verifySocialID()" for Facebook
 *  08 Jan 2019 - Add function "getProfileFromPSID()"
 *  08 Jan 2019 - Add function "getProfileFromASID()"
 *  09 Jan 2019 - Modify function "verifySocialID()" : Getting picture
 * -----------------------------------------------------------------------
 */

define('TV_WORDSEGMENTATION_PROGRAM', 'tv-word-segmentation');

define('TV_TEMP_DIR', '../temp.text/');


/* GetMicroDateTime
 * --------
 * Purpose : Get Micro datetime
 * Input   : None
 * Return  : Current Micro datetime
 */

function GetMicroDateTime()
{

	$micro_time = microtime(true);

	$date_array = explode(".", $micro_time);
	$millisec = substr($date_array[1], 0, 3);

	$date = date("Y-m-d H:i:s",$date_array[0]);
	$micro_datetime = $date.".".$millisec;

	return $micro_datetime;

}


/* logWrite
 * --------
 * Purpose : Write input message to log file
 * Input   : (1) '$filename' = log filename
 *           (2) '$message' = log message
 * Return  : None
 */

function logWrite($logFile, $message)
{
	global $gbTransID;                                /* Transaction ID(global) */

	$fp = fopen($logFile, 'a');
	if($fp == null){
		return;
	}

	$TIMESTAMP = GetMicroDateTime();
	$time = '['.$TIMESTAMP.']';

	if(flock($fp, LOCK_EX)){                           /* Lock target log file */
		fwrite($fp, $time.": ".$gbTransID.": ".$message.PHP_EOL);
		flock($fp, LOCK_UN);
	}
	
	fclose($fp);
}


/* generateRandomString
 * --------------------
 * Purpose : Generate random string with specified output length
 * Input   : (1) '$length' = output random string length(default is 10)
 * Return  : None
 */

function generateRandomString($length = 10)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for($i = 0; $i < $length; $i++){
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}

	return($randomString);
}


/* microtime_float
 * ---------------
 * Purpose : Get current time in floating point value
 * Input   : None
 * Return  : Time in second(with microsecond)
 */

function microtime_float()
{
	list($usec, $sec) = explode(" ", microtime());
	return((float)$usec + (float)$sec);
}


/* getProcessString
 * ----------------
 * Purpose : Get text processing string from input string
 * Input   : (1) '$string' = input string
 * Return  : Processing string
 */

function getProcessString($string)
{
	/* Convert to lowercase */
	$lowercaseString = strtolower($string);

	/* Replace out of range character to whitespace
	 * 0020 -> 007E : Unicode range of English characters and some special characters
	 * 0E01 -> 0E59 : Unicode range of Thai characters
	 */
	$procString = preg_replace('/[^\x{0020}-\x{007E}\x{0E01}-\x{0E59}]+/u', ' ', $lowercaseString);

	return($procString);
}


/* performThaiTextSegmentation
 * ---------------------------
 * Purpose : Perform word segmentation to input UTF-8 text
 * Input   : (1) '$utf8Text' = input UTF-8 text
 *           (2) '$userID' = input user ID(to avoid same temporary file)
 * Return  : Context variables in JSON('null' if error)
 */

function performThaiTextSegmentation($utf8Text, $userID)
{
	$tokenizedText = "";                              /* Output */
	
	/* Convert UTF-8 text to TIS-620 */
	$asciiText = iconv("UTF-8", "TIS620", $utf8Text);

	/* Save to temporary file */
	$tmpFile = TV_TEMP_DIR . rand() . $userID . ".txt";
	file_put_contents($tmpFile, $asciiText);

	/* Use Tellvoice's Thai word segmentation program */
	$tokenizedTextASCII = shell_exec(TV_WORDSEGMENTATION_PROGRAM . " -c 32 -r  < " . $tmpFile);

	/* Convert TIS-620 back to UTF-8 */
	$tokenizedText = iconv("TIS620", "UTF-8", $tokenizedTextASCII);

	unlink($tmpFile);

	return($tokenizedText);
}


/* postJSONString
 * --------------
 * Purpose : Send JSON string to destination URL by HTTP method 'POST'
 * Input   :
 *  (1) '$jsonOutString' = JSON string to be send
 *  (2) '$url' = destination URL
 *  (3) '$authorizedToken' = authorization token('null' if not used)
 *  (4) '$timeout' = URL timeout in second
 * Return  : Array of
 *  (1) $retVal['status'] = send status("SUCCESS"/"FAIL"?)
 *  (2) $retVal['description'] = description of this status
 *  (3) $retVal['httpcode'] = HTTP response code
 *  (4) $retVal['responsetext'] = response string, should be JSON string
 */

function postJSONString($jsonOutString, $url, $authorizedToken, $timeout)
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
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonOutString);
	//curl_setopt($curl, CURLOPT_NOPROXY, "*");
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

	if(empty($authorizedToken)){
		$headers = array('Content-Type: application/json');
	}
	else{
		$authorization = "Authorization: Bearer ".$authorizedToken;
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


/* getFromURL
 * ----------
 * Purpose : Send HTTP 'GET' method to destination URL
 * Input   :
 *  (1) '$url' = destination URL
 *  (2) '$authorizedToken' = authorization token('null' if not used)
 *  (3) '$timeout' = URL timeout in second
 * Return  : Array of
 *  (1) $retVal['status'] = send status("SUCCESS"/"FAIL"?)
 *  (2) $retVal['description'] = description of this status
 *  (3) $retVal['httpcode'] = HTTP response code
 *  (4) $retVal['responsetext'] = response string, should be JSON string
 */

function getFromURL($url, $authorizedToken, $timeout)
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
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

	if(!empty($authorizedToken)){
		$authorization = "Authorization: Bearer ".$authorizedToken;
		$headers = array($authorization);    // Plus authorization in HTTP header
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	}

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


/* postString
 * ----------
 * Purpose : Send string to destination URL by HTTP method 'POST'
 * Input   :
 *  (1) '$outString' = String to be send
 *  (2) '$url' = destination URL
 *  (3) '$contentType' = Content type of this string
 *  (4) '$authorizedToken' = authorization token('null' if not used)
 *  (5) '$timeout' = URL timeout in second
 * Return  : Array of
 *  (1) $retVal['status'] = send status("SUCCESS"/"FAIL"?)
 *  (2) $retVal['description'] = description of this status
 *  (3) $retVal['httpcode'] = HTTP response code
 *  (4) $retVal['responsetext'] = response string, should be JSON string
 */

function postString($outString, $url, $contentType, $authorizedToken, $timeout)
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
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $outString);
	//curl_setopt($curl, CURLOPT_NOPROXY, "*");
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

	/* ----------------------- */
	/* ---- Fill headers? ---- */
	/* ----------------------- */
	
	$headers = array();
	
	if(!empty($authorizedToken)){
		$authorization = "Authorization: Bearer ".$authorizedToken;
		array_push($headers, $authorization);
	}

	if(!empty($contentType)){
		$typeString = "Content-Type: ".$contentType;
		array_push($headers, $typeString);
	}

	if(!empty($headers)){
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	}

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


/* create_new_contact
 * ----------
 * Purpose : Create New contact from social ID
 * Input   :
 *  (1) '$cust_data' = array of customer data
 * Return  : Array of
 *  (1) $retVal['status'] = send status("SUCCESS"/"FAIL"?)
 *  (2) $retVal['description'] = description of this status
 *  (3) $retVal['httpcode'] = HTTP response code
 *  (4) $retVal['responsetext'] = response string, should be JSON string
 */

function create_new_contact($cust_data) {
	global $connection;

	try{
		//logWrite($logFilename,"      create_new_contact :: START.");

		$data_bind = [
		':CONTACTNAME'=>$cust_data['CONTACTNAME']
		,':STATUS'=>$cust_data['STATUS']
		];

		$columnName = implode(',', [
		'CONTACTNAME'
		,'STATUS'
		]);

		$bindColumn = implode(',', [
		':CONTACTNAME'
		,':STATUS'
		]);

		$sql= "INSERT INTO CUST_CONTACTS (" . $columnName . ", ADDED_DT, UPDATED_DT ) 
				VALUES (" . $bindColumn . " , SYSDATE(), SYSDATE())";
		$_return= $connection->ExecuteNonQuery2($sql, $data_bind );

		//logWrite(ks_filename_log,"      create_new_contact :: DB Return::".print_r($_return,true) );
		//logWrite(ks_filename_log,"      create_new_contact :: END.");
		return $_return;
	} catch (Exception $e) {
		logWrite(ks_filename_log,"      create_new_contact :: SQL[".$sql."]" );
		logWrite(ks_filename_log,"      create_new_contact :: ERROR!! ".$e->getMessage() );
	}
}


/* create_new_social_contact
 * ----------
 * Purpose : Create new social contact if not exist
 * Input   :
 *  (1) '$cust_data' = array of customer data
 * Return  : Array of
 *  (1) $retVal['status'] = send status("SUCCESS"/"FAIL"?)
 *  (2) $retVal['description'] = description of this status
 *  (3) $retVal['httpcode'] = HTTP response code
 *  (4) $retVal['responsetext'] = response string, should be JSON string
 */

function create_new_social_contact($cust_data) {
	global $connection;

	try{
		//logWrite(ks_filename_log,"      create_new_social_contact :: START.");
		
		$columnName = implode(',', [
			'CONTACTID'
			,'SOCIAL_CUSTID'
			,'SOCIAL_CUSTNAME'
			,'SOCIAL_CUSTPIC'
			,'SOCIAL_CUSTINFO'
			,'SOCIALTYPE'
			,'SOCIALACCT'
			,'SOCIALAPPID'
			,'STATUS'
		]);

		$bindColumn = implode(',', [
			':CONTACTID'
			,':SOCIAL_CUSTID'
			,':SOCIAL_CUSTNAME'
			,':SOCIAL_CUSTPIC'
			,':SOCIAL_CUSTINFO'
			,':SOCIALTYPE'
			,':SOCIALACCT'
			,':SOCIALAPPID'
			,':STATUS'
		]);

		$data_bind = [
			':CONTACTID'=>$cust_data['CONTACTID']
			,':SOCIAL_CUSTID'=>$cust_data['SOCIAL_CUST']['SOCIAL_CUSTID']
			,':SOCIAL_CUSTNAME'=>$cust_data['SOCIAL_CUST']['SOCIAL_CUSTNAME']
			,':SOCIAL_CUSTPIC'=>$cust_data['SOCIAL_CUST']['SOCIAL_CUSTPIC']
			,':SOCIAL_CUSTINFO'=>$cust_data['SOCIAL_CUST']['SOCIAL_CUSTINFO']
			,':SOCIALTYPE'=>$cust_data['SOCIALTYPE']
			,':SOCIALACCT'=>$cust_data['SOCIALACCT']
			,':SOCIALAPPID'=>$cust_data['SOCIALAPPID']
			,':STATUS'=>$cust_data['STATUS']
		];

		$sql= "INSERT IGNORE INTO CUST_SOCIALCONTACTS (" . $columnName . ", ADDED_DT, UPDATED_DT ) 
				VALUES (" . $bindColumn . " , SYSDATE(), SYSDATE())";
		$_return = $connection->ExecuteNonQuery2($sql, $data_bind );

		//logWrite(ks_filename_log,"      create_new_social_contact :: DB Return::".print_r($_return,true) );
		//logWrite(ks_filename_log,"      create_new_social_contact :: END.");
		return $_return;
	} catch (Exception $e) {
		logWrite(ks_filename_log,"      create_new_social_contact :: SQL[".$sql."]" );
		logWrite(ks_filename_log,"      create_new_social_contact :: ERROR!! ".$e->getMessage() );
	}
}

function getProfileFromASID($userid, &$userInfo, $pageid, $pageToken, &$customer_info){
	global $connection;

	logWrite(ks_filename_log,"      getProfileFromASID");
	$contactID = '-888';

	if ($pageid == $userid) {
		$url = 'https://graph.facebook.com/v2.12/' . $userid . '?fields=id,name,picture.width(320)&access_token=' . $pageToken;
	} else {
		$url = 'https://graph.facebook.com/v2.12/' . $userid . '?fields=id,name,first_name,last_name,picture.width(320)&access_token=' . $pageToken;
	}
	logWrite(ks_filename_log,"      getProfileFromASID url : ".$url);
	$result_array = getFromURL($url, 'null', 30);
	if ($result_array['status'] == "SUCCESS") {
		$custArray = json_decode($result_array['responsetext'], true);

		if (isset($custArray['picture']['data']['url'])) {
/*
			$profile_pic_full = PROFILEPIC_MAINPATH.PROFILEPIC_SUBPATH."FB_".$pageid."_".$userid.".jpg";
			$profile_pic_base = PROFILEPIC_SUBPATH."FB_".$pageid."_".$userid.".jpg";
			file_put_contents($profile_pic_full, fopen($custArray['picture']['data']['url'], 'r'));
			chmod($profile_pic_full, 0755);
*/
//			$profile_pic_base = PROFILE_PIC_SUB."FB_".$pageid."_".$userid.".jpg";
//			$profile_pic_full = PROFILE_PIC_MAIN.$profile_pic_base;

			$attach_filepath = PROFILE_PIC_MAIN.PROFILE_PIC_SUB.date("Ymd");
			$profile_pic_base = "FB_".$pageid."_".$userid.".jpg";
			$profile_pic_full = $attach_filepath.DIRECTORY_SEPARATOR.$profile_pic_base;

			$param = array(
				"attach_basepath" => $attach_filepath,
				"attach_filename" => $profile_pic_full,
				"attach_original" => $custArray['picture']['data']['url']
			);

			$paramString = json_encode($param);
			logWrite(ks_filename_log, "attninterface_gateway: \"".$paramString."\"");
			$retVal = postJSONString($paramString, GET_ATTN_INTERFACE_URL, "", 5);

			$attach_base = PROFILE_PIC_SUB.date("Ymd").DIRECTORY_SEPARATOR.$profile_pic_base;
			$profile_pic_base = $attach_base;
		} else {
			$profile_pic_base = "";
		}

		if ( isset($custArray['first_name']) ) {
			$customer_info['CONTACTNAME'] = $custArray['first_name']." ".$custArray['last_name'];
		} else {
			$customer_info['CONTACTNAME'] = $custArray['name'];
		}
		$userInfo = array('sender_id' => $userid, 'sender_name' => $custArray['name'], 'profile_pic' => $profile_pic_base);
		$customer_info['SOCIAL_CUST'] = array(
			"SOCIAL_CUSTID"		=> $userInfo['sender_id'],
			"SOCIAL_CUSTNAME"	=> $custArray['name'],
			"SOCIAL_CUSTPIC"	=> $profile_pic_base,
			"SOCIAL_CUSTINFO"	=> json_encode($userInfo)
		);
	} else {
		logWrite(ks_filename_log,"      Cannot get data from Facebook.");
		$resmsg = json_decode($result_array['responsetext'], true);
		if (gettype($resmsg == 'array')) {
			logWrite(ks_filename_log, "      Error : ".print_r($resmsg,true));
		} else {
			logWrite(ks_filename_log, "      Error : ".$resmsg );
		}

		$customer_info['CONTACTNAME'] = "UNKNOWN";
		$userInfo = array('sender_id' => $userid, 'sender_name' => "UNKNOWN", 'profile_pic' => "");

		$customer_info['CONTACTNAME'] = "UNKNOWN";
		$userInfo = array('sender_id' => $userid, 'sender_name' => "UNKNOWN", 'profile_pic' => "");
		$customer_info['SOCIAL_CUST'] = array(
			"SOCIAL_CUSTID"		=> $userInfo['sender_id'],
			"SOCIAL_CUSTNAME"	=> "UNKNOWN",
			"SOCIAL_CUSTPIC"	=> "",
			"SOCIAL_CUSTINFO"	=> json_encode($userInfo)
		);
	}
	//logWrite(ks_filename_log, "      customer_info : ".print_r($customer_info,true));

	logWrite(ks_filename_log,"      Start managing Facebook account...");
	$sqlStatement = "SELECT * FROM CUST_SOCIALCONTACTS WHERE SOCIALTYPE='FB' AND SOCIAL_CUSTID='".$userid."' ORDER BY CONTACTID " ;
	$returnStr = $connection->ExecuteReader3($sqlStatement,Array());

	if ($returnStr['NUMROWS'] > 0) {
		$contactID = $returnStr['INFO'][0]['CONTACTID'];
		logWrite(ks_filename_log,"        Found contact [".$contactID."]");
	} else {
		logWrite(ks_filename_log,"        Not found contact");

		$result_array = create_new_contact( $customer_info );
		if ($result_array['id'] != "0") {
			$contactID = $result_array['id'];
			logWrite(ks_filename_log,"        Create new contact ID::DONE[".$contactID."]");

			$customer_info['CONTACTID'] = $contactID;
			$customer_info['SOCIALACCT'] = $pageid;

			$result_array = create_new_social_contact($customer_info);
			if ($result_array['id'] != "0") {
				$scid = $result_array['id'];
				logWrite(ks_filename_log,"          Create new social contact::DONE[".$scid."]");
			}
		} else {
			logWrite(ks_filename_log,"        Create new contact ID::FAIL");
			$contactID = '-999';
		}
	}

	logWrite(ks_filename_log,"      getProfileFromASID : [DONE]");
	return $contactID;
}

function getProfileFromPSID($userid, &$userInfo, $pageid, $pageToken, &$customer_info){
	global $connection;

	logWrite(ks_filename_log,"      getProfileFromPSID");
	$contactID = '-888';

	$url = 'https://graph.facebook.com/v2.12/' . $userid . '?fields=id,name,profile_pic,first_name,last_name&access_token=' . $pageToken;
	logWrite(ks_filename_log,"      getProfileFromPSID url : ".$url);
	$result_array = getFromURL($url, 'null', 30);
	if ($result_array['status'] == "SUCCESS") {
		$custArray = json_decode($result_array['responsetext'], true);
/*
		$profile_pic_full = PROFILEPIC_MAINPATH.PROFILEPIC_SUBPATH."FB_".$pageid."_".$userid.".jpg";
		$profile_pic_base = PROFILEPIC_SUBPATH."FB_".$pageid."_".$userid.".jpg";
		file_put_contents($profile_pic_full, fopen($custArray['profile_pic'], 'r'));
		chmod($profile_pic_full, 0755);
*/
//		$profile_pic_base = PROFILE_PIC_SUB."FB_".$pageid."_".$userid.".jpg";
//		$profile_pic_full = PROFILE_PIC_MAIN.$profile_pic_base;

		$attach_filepath  = PROFILE_PIC_MAIN.PROFILE_PIC_SUB.date("Ymd");
		$profile_pic_base = "FB_".$pageid."_".$userid.".jpg";
		$profile_pic_full = $attach_filepath.DIRECTORY_SEPARATOR.$profile_pic_base;

		$param = array(
			"attach_basepath" => $attach_filepath,
			"attach_filename" => $profile_pic_full,
			"attach_original" => $custArray['profile_pic']
		);

		$paramString = json_encode($param);
		logWrite(ks_filename_log, "attninterface_gateway: \"".$paramString."\"");
		$retVal = postJSONString($paramString, GET_ATTN_INTERFACE_URL, "", 5);

		$attach_base = PROFILE_PIC_SUB.date("Ymd").DIRECTORY_SEPARATOR.$profile_pic_base;
		$profile_pic_base = $attach_base;


		$customer_info['CONTACTNAME'] = $custArray['first_name']." ".$custArray['last_name'];
		$userInfo = array('sender_id' => $userid, 'sender_name' => $custArray['name'], 'profile_pic' => $profile_pic_base);
		$customer_info['SOCIAL_CUST'] = array(
			"SOCIAL_CUSTID"		=> $userInfo['sender_id'],
			"SOCIAL_CUSTNAME"	=> $custArray['name'],
			"SOCIAL_CUSTPIC"	=> $profile_pic_base,
			"SOCIAL_CUSTINFO"	=> json_encode($userInfo)
		);
	} else {
		logWrite(ks_filename_log,"      Cannot get data from Facebook.");
		$resmsg = json_decode($result_array['responsetext'], true);
		if (gettype($resmsg == 'array')) {
			logWrite(ks_filename_log, "      Error : ".print_r($resmsg,true));
		} else {
			logWrite(ks_filename_log, "      Error : ".$resmsg );
		}

		$customer_info['CONTACTNAME'] = "UNKNOWN";
		$userInfo = array('sender_id' => $userid, 'sender_name' => "UNKNOWN", 'profile_pic' => "");

		$customer_info['CONTACTNAME'] = "UNKNOWN";
		$userInfo = array('sender_id' => $userid, 'sender_name' => "UNKNOWN", 'profile_pic' => "");
		$customer_info['SOCIAL_CUST'] = array(
			"SOCIAL_CUSTID"		=> $userInfo['sender_id'],
			"SOCIAL_CUSTNAME"	=> "UNKNOWN",
			"SOCIAL_CUSTPIC"	=> "",
			"SOCIAL_CUSTINFO"	=> json_encode($userInfo)
		);
	}
	//logWrite(ks_filename_log, "      customer_info : ".print_r($customer_info,true));

	logWrite(ks_filename_log,"      Start managing Facebook account...");
	$sqlStatement = "SELECT * FROM CUST_SOCIALCONTACTS WHERE SOCIALTYPE='FB' AND SOCIAL_CUSTID='".$userid."' ORDER BY CONTACTID " ;
	$returnStr = $connection->ExecuteReader3($sqlStatement,Array());

	if ($returnStr['NUMROWS'] > 0) {
		$contactID = $returnStr['INFO'][0]['CONTACTID'];
		logWrite(ks_filename_log,"        Found contact [".$contactID."]");
	} else {
		logWrite(ks_filename_log,"        Not found contact");

		$result_array = create_new_contact( $customer_info );
		if ($result_array['id'] != "0") {
			$contactID = $result_array['id'];
			logWrite(ks_filename_log,"        Create new contact ID::DONE[".$contactID."]");

			$customer_info['CONTACTID'] = $contactID;
			$customer_info['SOCIALACCT'] = $pageid;

			$result_array = create_new_social_contact($customer_info);
			if ($result_array['id'] != "0") {
				$scid = $result_array['id'];
				logWrite(ks_filename_log,"          Create new social contact::DONE[".$scid."]");
			}
		} else {
			logWrite(ks_filename_log,"        Create new contact ID::FAIL");
			$contactID = '-999';
		}
	}

	logWrite(ks_filename_log,"      getProfileFromPSID : [DONE]");
	return $contactID;
}

function verifySocialID($feedtype, $feedsubtype, $userid, &$userInfo, $pageid, $pageInfo) {
	global $connection;

	$contactID = '-97';
	$customer_info = array(
		"CONTACTID"		=>	$contactID,
		"CONTACTNAME"	=>	"",
		"SOCIAL_CUST"	=>	array(),
		"SOCIALTYPE"	=>	$feedtype,
		"SOCIALACCT"	=>	"",
		"SOCIALAPPID"	=>	"",
		"STATUS"		=>	"A"
	);

	logWrite(ks_filename_log,"    in checkSocialCustomerID");
	$sqlStatement = "SELECT * FROM CUST_SOCIALCONTACTS WHERE SOCIAL_CUSTID='".$userid."' AND SOCIALTYPE='".$feedtype."'" ;
	if (strlen($pageid) > 1) {
		$sqlStatement .= " AND SOCIALACCT='".$pageid."'";
	}
	$returnStr = $connection->ExecuteReader3($sqlStatement,Array());

	if ($returnStr['NUMROWS'] > 0) {
		logWrite(ks_filename_log,"    found social contact");
		$contactID = $returnStr['INFO'][0]['CONTACTID'];
		if ($feedtype == 'FB') {
			$userInfo = array('sender_id' => $userid, 'sender_name' => $returnStr['INFO'][0]['SOCIAL_CUSTNAME'], 'profile_pic' => $returnStr['INFO'][0]['SOCIAL_CUSTPIC']);
		}
	} else {
		logWrite(ks_filename_log,"    NOT found social contact");

		switch( $feedtype ) {

			case 'PT' :
				logWrite(ks_filename_log, "    ".$feedtype." userinfo 1 : ".print_r($userInfo,true));
				if (strlen($userInfo['avatar']) > 0) {
//					$profile_pic_base = PROFILE_PIC_SUB.$feedtype."_ACCOUNT_".$userInfo['uid'].".jpg";
//					$profile_pic_full = PROFILE_PIC_MAIN.$profile_pic_base;
//					file_put_contents($profile_pic_full, fopen($userInfo['avatar'], 'r'));
//					chmod($profile_pic_full, 0755);

					$attach_filepath = PROFILE_PIC_MAIN.PROFILE_PIC_SUB.date("Ymd");
					$profile_pic_base = $feedtype."_ACCOUNT_".$userInfo['uid'].".jpg";
					$profile_pic_full = $attach_filepath.DIRECTORY_SEPARATOR.$profile_pic_base;

					$param = array(
						"attach_basepath" => $attach_filepath,
						"attach_filename" => $profile_pic_full,
						"attach_original" => $userInfo['avatar']
					);
					$paramString = json_encode($param);
					logWrite(ks_filename_log, "attninterface_gateway: \"".$paramString."\"");
					$retVal = postJSONString($paramString, GET_ATTN_INTERFACE_URL, "", 5);

					$attach_base = PROFILE_PIC_SUB.date("Ymd").DIRECTORY_SEPARATOR.$profile_pic_base;
					$profile_pic_base = $attach_base;
					$userInfo['avatar'] = $profile_pic_base;
				} else {
					$profile_pic_base = "";
				}
				logWrite(ks_filename_log, "    ".$feedtype." userinfo 2 : ".print_r($userInfo,true));

				$customer_info['CONTACTNAME'] = $userInfo['nickname'];
				$customer_info['SOCIAL_CUST'] = array(
					"SOCIAL_CUSTID"		=> $userInfo['uid'],
					"SOCIAL_CUSTNAME"	=> $userInfo['nickname'],
					"SOCIAL_CUSTPIC"	=> $profile_pic_base,
					"SOCIAL_CUSTINFO"	=> json_encode($userInfo)
				);

				logWrite(ks_filename_log,"    Create new contact ID.");
				$result_array = create_new_contact( $customer_info );

				if ($result_array['id'] != "0") {
					$contactID = $result_array['id'];
					logWrite(ks_filename_log,"    Create new contact ID::DONE[".$contactID."]");

					$customer_info['CONTACTID'] = $contactID;

					logWrite(ks_filename_log,"    Create new social contact");
					$result_array = create_new_social_contact($customer_info);
					if ($result_array['id'] != "0") {
						$scid = $result_array['id'];
						logWrite(ks_filename_log,"    Create new social contact::DONE[".$scid."]");
					} else{
						logWrite(ks_filename_log,"    Create new social contact::FAIL");
					}
				} else {
					logWrite(ks_filename_log,"    Create new contact ID::FAIL");
				}

			break;

			case 'FB' :
				logWrite(ks_filename_log,"    Preparing Facebook customer ID checking process.");
				if ($feedsubtype == 'ME') {
					logWrite(ks_filename_log,"      Checking sender ID (PSID:ME)");
					$contactID = getProfileFromPSID($userid, $userInfo, $pageid, $pageInfo[$pageid]['PAGE_TOKEN'], $customer_info);
				} else {
					logWrite(ks_filename_log,"      Checking sender ID (ASID:FP,CM,CR)");
					$contactID = getProfileFromASID($userid, $userInfo, $pageid, $pageInfo['PAGE_TOKEN'], $customer_info);
				}
			break;

			case 'TT' :
				logWrite(ks_filename_log, "    ".$feedtype." userinfo 1 : ".print_r($userInfo,true));
				if (strlen($userInfo['avatar']) > 0) {
//					$profile_pic_base = PROFILE_PIC_SUB.$feedtype."_ACCOUNT_".$userInfo['userid'].".jpg";
//					$profile_pic_full = PROFILE_PIC_MAIN.$profile_pic_base;
//					file_put_contents($profile_pic_full, fopen($userInfo['avatar'], 'r'));
//					chmod($profile_pic_full, 0755);

					$attach_filepath = PROFILE_PIC_MAIN.PROFILE_PIC_SUB.date("Ymd");
					$profile_pic_base = $feedtype."_ACCOUNT_".$userInfo['userid'].".jpg";
					$profile_pic_full = $attach_filepath.DIRECTORY_SEPARATOR.$profile_pic_base;

					$param = array(
						"attach_basepath" => $attach_filepath,
						"attach_filename" => $profile_pic_full,
						"attach_original" => $userInfo['avatar']
					);
					$paramString = json_encode($param);
					logWrite(ks_filename_log, "attninterface_gateway: \"".$paramString."\"");
					$retVal = postJSONString($paramString, GET_ATTN_INTERFACE_URL, "", 5);

					$attach_base = PROFILE_PIC_SUB.date("Ymd").DIRECTORY_SEPARATOR.$profile_pic_base;
					$profile_pic_base = $attach_base;
					$userInfo['avatar'] = $profile_pic_base;
				} else {
					$profile_pic_base = "";
				}
				logWrite(ks_filename_log, "    ".$feedtype." userinfo 2 : ".print_r($userInfo,true));

				$customer_info['CONTACTNAME'] = $userInfo['fullname'];
				$customer_info['SOCIAL_CUST'] = array(
					"SOCIAL_CUSTID"		=> $userInfo['userid'],
					"SOCIAL_CUSTNAME"	=> $userInfo['username'],
					"SOCIAL_CUSTPIC"	=> $profile_pic_base,
					"SOCIAL_CUSTINFO"	=> json_encode($userInfo)
				);

				logWrite(ks_filename_log,"    Create new contact ID.");
				$result_array = create_new_contact( $customer_info );

				if ($result_array['id'] != "0") {
					$contactID = $result_array['id'];
					logWrite(ks_filename_log,"    Create new contact ID::DONE[".$contactID."]");

					$customer_info['CONTACTID'] = $contactID;

					logWrite(ks_filename_log,"    Create new social contact");
					$result_array = create_new_social_contact($customer_info);
					if ($result_array['id'] != "0") {
						$scid = $result_array['id'];
						logWrite(ks_filename_log,"    Create new social contact::DONE[".$scid."]");
					} else{
						logWrite(ks_filename_log,"    Create new social contact::FAIL");
					}
				} else {
					logWrite(ks_filename_log,"    Create new contact ID::FAIL");
				}

			break;

			case 'EM' :
				logWrite(ks_filename_log, "    ".$feedtype." userinfo 1 : ".print_r($userInfo,true));
				if (strlen($userInfo['avatar']) > 0) {
//					$profile_pic_base = PROFILE_PIC_SUB.$feedtype."_ACCOUNT_".$userInfo['userid'].".jpg";
//					$profile_pic_full = PROFILE_PIC_MAIN.$profile_pic_base;
//					file_put_contents($profile_pic_full, fopen($userInfo['avatar'], 'r'));
//					chmod($profile_pic_full, 0755);

					$attach_filepath = PROFILE_PIC_MAIN.PROFILE_PIC_SUB.date("Ymd");
					$profile_pic_base = $feedtype."_ACCOUNT_".$userInfo['userid'].".jpg";
					$profile_pic_full = $attach_filepath.DIRECTORY_SEPARATOR.$profile_pic_base;

					$param = array(
						"attach_basepath" => $attach_filepath,
						"attach_filename" => $profile_pic_full,
						"attach_original" => $userInfo['avatar']
					);
					$paramString = json_encode($param);
					logWrite(ks_filename_log, "attninterface_gateway: \"".$paramString."\"");
					$retVal = postJSONString($paramString, GET_ATTN_INTERFACE_URL, "", 5);

					$attach_base = PROFILE_PIC_SUB.date("Ymd").DIRECTORY_SEPARATOR.$profile_pic_base;
					$profile_pic_base = $attach_base;
					$userInfo['avatar'] = $profile_pic_base;
				} else {
					$profile_pic_base = "";
				}
				logWrite(ks_filename_log, "    ".$feedtype." userinfo 2 : ".print_r($userInfo,true));

				$customer_info['CONTACTNAME'] = $userInfo['fullname'];
				$customer_info['SOCIAL_CUST'] = array(
					"SOCIAL_CUSTID"		=> $userInfo['userid'],
					"SOCIAL_CUSTNAME"	=> $userInfo['username'],
					"SOCIAL_CUSTPIC"	=> $profile_pic_base,
					"SOCIAL_CUSTINFO"	=> json_encode($userInfo)
				);

				logWrite(ks_filename_log,"    Create new contact ID.");
				$result_array = create_new_contact( $customer_info );

				if ($result_array['id'] != "0") {
					$contactID = $result_array['id'];
					logWrite(ks_filename_log,"    Create new contact ID::DONE[".$contactID."]");

					$customer_info['CONTACTID'] = $contactID;

					logWrite(ks_filename_log,"    Create new social contact");
					$result_array = create_new_social_contact($customer_info);
					if ($result_array['id'] != "0") {
						$scid = $result_array['id'];
						logWrite(ks_filename_log,"    Create new social contact::DONE[".$scid."]");
					} else{
						logWrite(ks_filename_log,"    Create new social contact::FAIL");
					}
				} else {
					logWrite(ks_filename_log,"    Create new contact ID::FAIL");
				}

			break;


			default : 
				logWrite(ks_filename_log,"    Create new contact ID.");
			break;
		}
	}

	return $contactID;
}



function _GetCustomerPriority($customerID, $feedtype, $logFilename)
{
	global $connection;

	//logWrite($logFilename,'_GetCustomerPriority : customerID ==> '.$customerID);
	//logWrite($logFilename,'_GetCustomerPriority : feedtype ==> '.$feedtype);

	$whereStatement = "SOCIAL_CUSTID='".$customerID."' AND FEEDTYPE='".$feedtype."'";

	$sql = " SELECT 
		CONFIG_RTBYCUST_SET.SETID, 
		CONFIG_RTBYCUST_SET.SETTITLE, 
		CONFIG_RTBYCUST_SET.SETSTATUS, 
		CONFIG_RTBYCUST_SET.VALIDDATE AS VALIDDATEDT, 
		CONFIG_RTBYCUST_SET.EXPIREDATE AS EXPIREDATEDT, 
		CONFIG_RTBYCUST_LIST.STATUS AS CUSTSTATUS
	FROM CONFIG_RTBYCUST_LIST LEFT JOIN CONFIG_RTBYCUST_SET ON 
		CONFIG_RTBYCUST_LIST.SETID=CONFIG_RTBYCUST_SET.SETID 
	WHERE 
		".$whereStatement."
	ORDER BY 
		CONFIG_RTBYCUST_SET.SETSTATUS, CONFIG_RTBYCUST_SET.VALIDDATE, CONFIG_RTBYCUST_SET.EXPIREDATE ";

	$getResult = $connection->ExecuteReader2($sql, Array())["data"];
	$numMatch = count($getResult);

	$custSetID = '';
	if ($numMatch > 0) {
		logWrite($logFilename,'_GetCustomerPriority : Found Customer.');
		$err_msg = "";

		foreach ($getResult as $custPriorityList) {
			$numErr = 0;
			$currentdt = strtotime("now");
			$validdt   = strtotime($custPriorityList['VALIDDATEDT']);
			$expiredt  = strtotime($custPriorityList['EXPIREDATEDT']);

			if ($custPriorityList['CUSTSTATUS'] == 'P') {
				$numErr = 1;
				$err_msg = "  _GetCustomerPriority[" . $custPriorityList['SETID'] . "|" . $custPriorityList['SETTITLE']."]: Customer status is pending!!!";
				logWrite($logFilename,'  '.$err_msg);
			}

			if ($custPriorityList['SETSTATUS'] == 'I') {
				$numErr = 1;
				$err_msg = "  _GetCustomerPriority[" . $custPriorityList['SETID'] . "|" . $custPriorityList['SETTITLE']."]: Customer group is inactive!!!";
				logWrite($logFilename,'  '.$err_msg);
			}

			if ($currentdt < $validdt) {
				$numErr = 1;
				$err_msg = "  _GetCustomerPriority[" . $custPriorityList['SETID'] . "|" . $custPriorityList['SETTITLE']."]: Not in valid date!!!";
				logWrite($logFilename,'  '.$err_msg);
			}

			if ($currentdt > $expiredt) {
				$numErr = 1;
				$err_msg = "  _GetCustomerPriority[" . $custPriorityList['SETID'] . "|" . $custPriorityList['SETTITLE']."]: Data is expired!!!";
				logWrite($logFilename,'  '.$err_msg);
			}

			if ($numErr < 1) {
				logWrite($logFilename,'  _GetCustomerPriority = '.$custPriorityList['SETID']);
				$custSetID = $custPriorityList['SETID'];
				break;
			}

		}
	} else {
		logWrite($logFilename,'_GetCustomerPriority : Not Found Customer.');
	}

	return $custSetID;
}

?>
