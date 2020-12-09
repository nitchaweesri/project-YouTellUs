
<?php 
session_start();

include 'appintegrate/function/config/authenconfig.php';

$requestId = '112233';


if(isset($_POST['genOtp'])){
//    echo $_POST['tel'];
    $rusult = genOTPToEAPI($requestId, $_POST['tel']);

    if($rusult['status'] == "FAIL"){
        // print_r($rusult);
        echo implode(" ",$rusult);
    }
    elseif($rusult['status'] == "SUCCESS"){
        $_SESSION['uuid'] = $rusult['info']['tokenUUID']; //เก็บ uuid ที่ return จาก genOTPToEAPI ถ้า ไม่ fail
        header("Location: ../index.php?page=testValidOtp");

    }

}elseif(isset($_POST['validOtp'])){


    $rusult = validOTP($requestId, $_POST['otp'],$_SESSION['uuid']);
    // $validateOTP = validOTP($requestId, $otpNo, $tokenUUID);
    echo implode(" ",$rusult);

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
	// // // // logWrite(LOGFILE, "genOTPToEAPI: INFO: requesttext : ". $requestString);

	$retVal = postJSONStringToEAPI($requestId, $requestString, $url, 10);
	if($retVal['status'] == "FAIL"){
		// // // logWrite(LOGFILE, "genOTPToEAPI: WARNING: status = ".$retVal['status']." , description = ".$retVal['description']." , httpcode = ".$retVal['httpcode']);
		// // // logWrite(LOGFILE, "genOTPToEAPI: WARNING: responsetext = ".$retVal['responsetext']);
		return($retVal);
	}

	// // // logWrite(LOGFILE, "genOTPToEAPI : Data Response : ".$retVal['responsetext']);

	/* Get response array */
	// // // logWrite(LOGFILE, "genOTPToEAPI: INFO: responsetext : ". $retVal['responsetext']);
	$responseArray = json_decode($retVal['responsetext'], true);
	if(json_last_error() != JSON_ERROR_NONE){
		// // // logWrite(LOGFILE, "genOTPToEAPI: WARNING: Invalid response text \"".$retVal['responsetext']."\"!");
		return($retVal);
	}

	/* Fill in output personal info */
	$genOTPInfo = array();
	$genOTPInfo['valid'] = true;
	// if false no data other
	$genOTPInfo['info'] = array();
	$genOTPInfo['info'] = $responseArray;
	return($genOTPInfo);
}



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
	// // logWrite(LOGFILE, "validOTP: INFO: requesttext : ". $requestString);

	$retVal = postJSONStringToEAPI($requestId, $requestString, $url, 10);
	if($retVal['status'] == "FAIL" && ($retVal['httpcode'] != 409 && $retVal['httpcode'] != 400)){
		// // logWrite(LOGFILE, "validOTP: WARNING: status = ".$retVal['status']." , description = ".$retVal['description']." , httpcode = ".$retVal['httpcode']);
		// // logWrite(LOGFILE, "validOTP: WARNING: responsetext = ".$retVal['responsetext']);
		return($retVal);
	}

	/* Get response array */
	// // logWrite(LOGFILE, "validOTP: INFO: responsetext : ". $retVal['responsetext']);
	$responseArray = json_decode($retVal['responsetext'], true);
	if(json_last_error() != JSON_ERROR_NONE){
		// // logWrite(LOGFILE, "validOTP: WARNING: Invalid response text \"".$retVal['responsetext']."\"!");
		return($retVal);
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