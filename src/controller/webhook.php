<?php header ("Content-Type: text/html; charset=UTF-8"); ?>
<?php


// Webhook FB feed API A 
// 20-05-2020  Create file

// Include Function and Class
//include_once("config/authenconfig.php");
include_once("../line_scb/config/authenconfig.php");
require_once('../dbutil/CDatabase.php');
require_once("../utils/priorityfunc.php");
require_once("../utils/tvutils.php");
require_once("function_post.php"); //acomment


// LOG
	$gbTransID = generateRandomString(10);
	define('LOGFILE',  '../log/log_youtellus/webhooks_'.date('Ymd').'.log');

	logWrite(LOGFILE, "===================== Begin App Connect FB Feed Webhook =========================");

/* Output JSON array */
	$outputJSON = array(
	    'requestId' => '',
	    'responseCode' => '0000',
	    'responseDesc' => 'OK'
	);

/* --------------------------- */
/* ---- Is valid authen? ----- */  // NO authen return 1000 Unauthorized
/* --------------------------- */  // Return 403 Forbidden Not Registion API

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


/* --------------------------- */ // This method is POST
/* ---- Is valid request? ---- */ // Return 1001 Invalid request method
/* --------------------------- */ // Return 405 Method Not Allowed ; Wrong HTTP Method
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


/* -------------------------- */
/* ---- Input parameters ---- */	// Return 1002 Invalid request content
/* -------------------------- */	// Return 400 Bad Request Wrong or Not match parameter
$inputContent = file_get_contents('php://input');

$inputArray = json_decode($inputContent, true);
if(json_last_error() != JSON_ERROR_NONE){
    $outputJSON['responseCode'] = "1002";    
    $outputJSON['responseDesc'] = "Invalid request content";
    /* Output */
    http_response_code(400);
    header('Content-Type: application/json');
    $outputJSONStr = json_encode($outputJSON);
    echo $outputJSONStr;
    logWrite(LOGFILE, "Output JSON = ".$outputJSONStr);
    exit(0);
}

/* -------------------------- */
/* ----- Params: events ----- */	// Return 1002 Invalid request content
/* -------------------------- */	// Return 400 Bad Request Wrong or Not match parameter
if(!array_key_exists('events' , $inputArray) || empty($inputArray['events'])){
    $outputJSON['requestId'] = $inputArray['requestId'];
    $outputJSON['responseCode'] = '1002';    
    $outputJSON['responseDesc'] = 'Invalid request content(No \'events\')';
    /* Output */
    http_response_code(400);
    header('Content-Type: application/json');
    $outputJSONStr = json_encode($outputJSON);
    echo $outputJSONStr;
    logWrite(LOGFILE, 'Output JSON = '.$outputJSONStr);
    exit(0);
}


	logWrite(LOGFILE, "===================== Start [Event] FB Feed Webhook =========================");

	$object = json_decode($inputContent, true);

	if (gettype($object) == 'array') {
		logWrite(LOGFILE, "Object : ".print_r($object, true));
	} else {
		logWrite(LOGFILE, "Object : ".$object);
	}

	//SET OBJECT TO DEFULT
	$object = $object['events'];

if($object)
{
	//Connect Database//
	$connection = new CDatabase();
	$connection->Connect();
	//Connect Database//
	$fb_page = getFacebookPageConfigConnect($connection); //acomment NEW CONFIG CONNECT
	//$fb_page = getFacebookPageConfig($connection); //acomment

	$config_connector = get_Connector($connection); //acomment
	logWrite(LOGFILE, "===================== config_connector =========================");
	

	/*================Begin Feed===================*/
	$mydata = initWebHooks($object);

	logWrite(LOGFILE, "mydata :: ".print_r($mydata, true));
	logWrite(LOGFILE, "gettype : mydata :: ".gettype($mydata));
	logWrite(LOGFILE, "Facebook-Feed Count =>".count($mydata['datas']));
	//print "mydata : <pre>".print_r($mydata, true)."</pre>----- ----- -----<br/>";
	if ((gettype($mydata) == 'array') && (isset($mydata['datas']))) {

		logWrite(LOGFILE,"Facebook-Feed Count =>".count($mydata['datas']));

		if(count($mydata['datas']) > 0)
		{
			//logWrite("Facebook-Feed mydata =>".print_r($mydata,true));
			foreach($mydata['datas'] as $n_entry => $data)
			{
				if (isset($data['messaging'])) {
					//logWrite("This is messaging --- SKIP!!!");
					continue;
				}

				//Check Page
				logWrite(LOGFILE,"Facebook-Feed data =>".print_r($data,true));
				logWrite(LOGFILE,"Facebook-Feed pageID =>".$data['pageID']);
				if ( isset($data["sender_id"]) ) {
					$_sender_id = $data["sender_id"];
					//logWrite("Facebook-Feed _sender_id =>".$data['sender_id']);
				} else if ( isset($data["from"]) ) {
					$_sender_id = $data["from"]["id"];
					//logWrite("Facebook-Feed _sender_id 1 =>".print_r($data['from'],true));
					//logWrite("Facebook-Feed _sender_id 2 =>".$data['from']['id']);
				} else {
					$_sender_id = 1;
				}
				logWrite(LOGFILE,"Facebook-Feed sender_id =>".$_sender_id);

				if(isset($fb_page[$data['pageID']]))
				{
					$mypage = $fb_page[$data['pageID']];
					//logWrite("Facebook-Feed curr-mypage=>".print_r($mypage,true));

					///init_fbData
					$sData= init_fbData($data); //acomment FB=>FS
					if($sData['FEEDTYPE'] != "-1")
					{
						$sData["THREADINFO"]=json_encode($object);
						$sData["SOCIAL_CUSTID"]=$_sender_id;
						$userInfo=array("sender_id"=>$_sender_id
								,"sender_name"=>'');

						logWrite(LOGFILE,"xxxxxxxxx  => ".$data["from"]["name"]);

						if(isset($data["sender_name"])) {
							$userInfo["sender_name"] = $data["sender_name"];
							logWrite(LOGFILE,"f1 userInfo Info =>".$userInfo["sender_name"]);
						}else{
							$userInfo["sender_name"] = $data["from"]["name"];
							logWrite(LOGFILE,"f1 userInfo Info [from] =>".$userInfo["sender_name"]);
						} 

						if ( !isset($data['message']) ) {
							$data['message'] = null;
						}
						if ($data['fbjson']['entry'][0]['changes'][0]['field'] == 'mention') {
							logWrite(LOGFILE,"field=mention >>> sleep 30 sec.");
							sleep(30);
						}

			//$sData["CONTACTID"] = verifySocialID("FB",$sData["FEEDSUBTYPE"], $sData["SOCIAL_CUSTID"], $userInfo, $data["pageID"], $mypage); 
			//verifySocialID use FEEDTYPE FB to verifySocialID
			logWrite(LOGFILE, "tvssProcessFacebookEvent_NewContact : New Contact : SOCIAL_CUSTID : ".$sData["SOCIAL_CUSTID"]);
			$sData["CONTACTID"] = tvssProcessFacebookEvent_NewContact($data["pageID"], $sData["SOCIAL_CUSTID"]); //acomment

						if ($sData["CONTACTID"] == '-888') {
//							$userInfo['sender_name'] = $data['sender_name'];
							if(isset($data["sender_name"])) {
								$userInfo["sender_name"] = $data["sender_name"];
								logWrite(LOGFILE,"f2 userInfo Info =>".$userInfo["sender_name"]);
							} else if ( isset($data["form"]["name"]) ) {
								$userInfo["sender_name"] = $data["from"]["name"];
								logWrite(LOGFILE,"f2 userInfo Info [from] =>".$userInfo["sender_name"]);
							}
						}
				
						logWrite(LOGFILE,"Facebook-Feed sData=>".print_r($sData,true));

						$chk_sTHREADS=chk_SOCIAL_THREADS($connection,$sData);

						if(isset($chk_sTHREADS[0]['RECID']) && ( isset($sData["verb"]) && ($sData["verb"]!="add") ) )
						{
							logWrite(LOGFILE,"Is Already SOCIAL_THREADS.");
						}
						else
						{
							if (isset($chk_sTHREADS[0]['RECID']) && ($data['fbjson']['entry'][0]['changes'][0]['field'] == 'mention') ) {
								logWrite(LOGFILE,"Is Already SOCIAL_THREADS[mention].");
								continue;
							}

							logWrite(LOGFILE,"Is New SOCIAL_THREADS.");

							// --- check that this post/comment accept private reply

							if ($data['fbjson']['entry'][0]['changes'][0]['field'] == 'mention') {
								$sData["IS_PRIVATEREPLY"] = 'N';
							} else {
								if ($sData["FEEDSUBTYPE"] == "FP") {
									if ($_sender_id != $data["pageID"]) {
										$sData["IS_PRIVATEREPLY"] = 'Y';
									} else {
										$sData["IS_PRIVATEREPLY"] = 'N';
									}
								} else if ($sData["FEEDSUBTYPE"] == "CM") {
									$sData["IS_PRIVATEREPLY"] = 'N';
									$mainSender = get_PostSenderID($connection, $sData["MAINID"]);
									if ( ($mainSender > 0) && ($mainSender == $data["pageID"]) ) {
										if($_sender_id != $data["pageID"]) {
											$sData["IS_PRIVATEREPLY"] = 'Y';
										}
									}
								} else if ($sData["FEEDSUBTYPE"] == "CR") {
									$sData["IS_PRIVATEREPLY"] = 'N';
									$mainSender = get_PostSenderID($connection, $sData["MAINID"]);
									if ( ($mainSender > 0) && ($mainSender == $data["pageID"]) ) {
										// Post from page
										if($_sender_id != $data["pageID"]) {
											$sData["IS_PRIVATEREPLY"] = 'Y';
	/*										// Then check comment ? reply from comment sender
											$mentSender = get_PostSenderID($connection, $sData["PARENTID"]);
											if ( ($mentSender > 0) && ($mentSender == $_sender_id) ) {
												$sData["IS_PRIVATEREPLY"] = 'Y';
											}*/
										}
									}
								} else {
									$sData["IS_PRIVATEREPLY"] = 'N';
								}
							}


							//--- Update URL for attachment
							$threadJSON['object'] = $object['object'];
							$threadJSON['entry'] = $data['fbjson']['entry'];

							if( isset($data['photos']) )
							{
								logWrite(LOGFILE,"Update photo attachments url...");
								foreach ($data['photos'] as $n_attn => $attachInfo) {

									if ( isset($attachInfo) ) {

										//Add function to receive facebook's attachment
										$attach_original = $attachInfo;

										$path = parse_url($attach_original, PHP_URL_PATH);
										$attach_basename = basename($path);

										$attach_pagepath = ATTACHMENTS_MAIN . DIRECTORY_SEPARATOR . ATTACHMENTS_FACEBOOK . $data["pageID"];
										$attach_filepath = $attach_pagepath . DIRECTORY_SEPARATOR . $data["pageID"] . '_' . $_sender_id;
										$attach_filename = $attach_filepath . DIRECTORY_SEPARATOR . $attach_basename;

										$param = array(
											"attach_basepath" => $attach_filepath,
											"attach_filename" => $attach_filename,
											"attach_original" => $attach_original
										);
										$paramString = json_encode($param);
										//logWrite(ks_filename_log, "attninterface_gateway: \"".$paramString."\"");
										$retVal = postJSONString($paramString, GET_ATTN_INTERFACE_URL, "", 5);

										$attach_newname = ATTACHMENTS_URL . DIRECTORY_SEPARATOR . ATTACHMENTS_FACEBOOK . $data["pageID"] . DIRECTORY_SEPARATOR . $data["pageID"] . '_' . $_sender_id . DIRECTORY_SEPARATOR . $attach_basename;
										logWrite(LOGFILE,"attach_newname url... \"".$attach_newname."\"");

										$data['fbjson']['entry'][0]['changes'][0]['value']['photos'][$n_attn] = $attach_newname;
									}
								}

								$threadJSON['entry'] = $data['fbjson']['entry'];
							}

							if( isset($data['photo']) )
							{
								logWrite(LOGFILE,"Update photo attachments url...");

								//Add function to receive facebook's attachment
								$attachInfo = $data['photo'];
								$attach_original = $attachInfo;

								$path = parse_url($attach_original, PHP_URL_PATH);
								$attach_basename = basename($path);

								$attach_pagepath = ATTACHMENTS_MAIN . DIRECTORY_SEPARATOR . ATTACHMENTS_FACEBOOK . $data["pageID"];
								$attach_filepath = $attach_pagepath . DIRECTORY_SEPARATOR . $data["pageID"] . '_' . $_sender_id;
								$attach_filename = $attach_filepath . DIRECTORY_SEPARATOR . $attach_basename;

								$param = array(
									"attach_basepath" => $attach_filepath,
									"attach_filename" => $attach_filename,
									"attach_original" => $attach_original
								);
								$paramString = json_encode($param);
								//logWrite(ks_filename_log, "attninterface_gateway: \"".$paramString."\"");
								$retVal = postJSONString($paramString, GET_ATTN_INTERFACE_URL, "", 5);

								$attach_newname = ATTACHMENTS_URL . DIRECTORY_SEPARATOR . ATTACHMENTS_FACEBOOK . $data["pageID"] . DIRECTORY_SEPARATOR . $data["pageID"] . '_' . $_sender_id . DIRECTORY_SEPARATOR . $attach_basename;
								logWrite(LOGFILE,"attach_newname url... \"".$attach_newname."\"");

								$data['fbjson']['entry'][0]['changes'][0]['value']['photo'] = $attach_newname;
								$threadJSON['entry'] = $data['fbjson']['entry'];
							}

							if ( ($data['item'] == 'photo') && isset($data['link']) )
							{
								logWrite(LOGFILE,"Update photo attachments url...");

								//Add function to receive facebook's attachment
								$attachInfo = $data['link'];
								$attach_original = $attachInfo;

								$path = parse_url($attach_original, PHP_URL_PATH);
								$attach_basename = basename($path);

								$attach_pagepath = ATTACHMENTS_MAIN . DIRECTORY_SEPARATOR . ATTACHMENTS_FACEBOOK . $data["pageID"];
								$attach_filepath = $attach_pagepath . DIRECTORY_SEPARATOR . $data["pageID"] . '_' . $_sender_id;
								$attach_filename = $attach_filepath . DIRECTORY_SEPARATOR . $attach_basename;

								$param = array(
									"attach_basepath" => $attach_filepath,
									"attach_filename" => $attach_filename,
									"attach_original" => $attach_original
								);
								$paramString = json_encode($param);
								//logWrite(ks_filename_log, "attninterface_gateway: \"".$paramString."\"");
								$retVal = postJSONString($paramString, GET_ATTN_INTERFACE_URL, "", 5);

								$attach_newname = ATTACHMENTS_URL . DIRECTORY_SEPARATOR . ATTACHMENTS_FACEBOOK . $data["pageID"] . DIRECTORY_SEPARATOR . $data["pageID"] . '_' . $_sender_id . DIRECTORY_SEPARATOR . $attach_basename;
								logWrite(LOGFILE,"attach_newname url... \"".$attach_newname."\"");

								$data['fbjson']['entry'][0]['changes'][0]['value']['link'] = $attach_newname;
								$threadJSON['entry'] = $data['fbjson']['entry'];
							}

							if ( ($data['item'] == 'video') && isset($data['link']) )
							{
								logWrite(LOGFILE,"Update video attachments url...");

								//Add function to receive facebook's attachment
								$attachInfo = $data['link'];
								$attach_original = $attachInfo;

								$path = parse_url($attach_original, PHP_URL_PATH);
								$attach_basename = basename($path);

								$attach_pagepath = ATTACHMENTS_MAIN . DIRECTORY_SEPARATOR . ATTACHMENTS_FACEBOOK . $data["pageID"];
								$attach_filepath = $attach_pagepath . DIRECTORY_SEPARATOR . $data["pageID"] . '_' . $_sender_id;
								$attach_filename = $attach_filepath . DIRECTORY_SEPARATOR . $attach_basename;

								$param = array(
									"attach_basepath" => $attach_filepath,
									"attach_filename" => $attach_filename,
									"attach_original" => $attach_original
								);
								$paramString = json_encode($param);
								//logWrite(ks_filename_log, "attninterface_gateway: \"".$paramString."\"");
								$retVal = postJSONString($paramString, GET_ATTN_INTERFACE_URL, "", 5);

								$attach_newname = ATTACHMENTS_URL . DIRECTORY_SEPARATOR . ATTACHMENTS_FACEBOOK . $data["pageID"] . DIRECTORY_SEPARATOR . $data["pageID"] . '_' . $_sender_id . DIRECTORY_SEPARATOR . $attach_basename;
								logWrite(LOGFILE,"attach_newname url... \"".$attach_newname."\"");

								$data['fbjson']['entry'][0]['changes'][0]['value']['link'] = $attach_newname;
								$threadJSON['entry'] = $data['fbjson']['entry'];
							}

							$sData["THREADINFO"]=json_encode($threadJSON);
							logWrite(LOGFILE,"sData[THREADINFO] : ".print_r($sData["THREADINFO"], true));
							$return_Insert=Insert_SOCIAL_THREADS($connection,$sData);


							if(($sData["verb"]!="edited") && ($sData["verb"]!="edit"))
							{
								if ($mypage["STATUS"] == 'A')
								{
									logWrite(LOGFILE,"Page status is active");
									if($return_Insert["id"]>0)
									{
										//verify enable connector..

										if(chk_Connector($config_connector,"EN_FB_GETPOST"))
										{
											logWrite(LOGFILE,"go to insert caseinfo...");

											logWrite(LOGFILE,"data PageID... : ".$data["pageID"]);

											logWrite(LOGFILE,"data Sender_id... : ".$_sender_id);

											if($data["pageID"]!=$_sender_id)
											{
												logWrite(LOGFILE,"go to insert caseinfo...222");
												$isparentresp = 1;
												$casestatus = "N"; 
												$caseclosetype = "";
												$closecode = "";

												if($sData["FEEDSUBTYPE"]=="CM")
												{//check post is already?
													logWrite(LOGFILE,"check post is already?.");
													$mainID = explode("_", $sData["PARENTID"]);
													$suspend_arr = array(
														":feedtype"=>"FS", //FB to FS
														":feedsubtype"=>"FP",
														":feedaccount"=>$sData["FEEDACCOUNT"],
														":feedid"=>$mainID[1]);

													if ( isSuspendFeed($connection,$suspend_arr) ) {
														$casestatus = "C"; 
														$caseclosetype = "NA";
														$closecode = "SUSPEND";
													}

												}else if($sData["FEEDSUBTYPE"]=="CR"){
													logWrite(LOGFILE,"check post and comment is already?.");
													$mainID = explode("_", $sData["PARENTID"]);
													$suspend_arr = array(
														":feedtype"=>"FS", //FB to FS
														":feedsubtype"=>"CM",
														":feedaccount"=>$sData["FEEDACCOUNT"],
														":feedid"=>$mainID[1]);

													if ( isSuspendFeed($connection,$suspend_arr) ) {
														$casestatus = "C"; 
														$caseclosetype = "NA";
														$closecode = "SUSPEND";
													} else {
														$mainID = explode("_", $sData["MAINID"]);
														$suspend_arr = array(
															":feedtype"=>"FS", //FB to FS
															":feedsubtype"=>"FP",
															":feedaccount"=>$sData["FEEDACCOUNT"],
															":feedid"=>$mainID[1]);

														if ( isSuspendFeed($connection,$suspend_arr) ) {
															$casestatus = "C"; 
															$caseclosetype = "NA";
															$closecode = "SUSPEND";
														}
													}
												}

												$sData["language"]=isThai($data["message"]);
												$priorityInfo=getPriorityList();
												$slasec = $olasec = 3600;
												$customerSetID = _GetCustomerPriority($_sender_id, "FB", ks_filename_log);
												logWrite(LOGFILE,"  !!! customer ==>[".$_sender_id."]");
												logWrite(LOGFILE,"  !!! customerSetID ==>[".$customerSetID."]");

												$priScore = getPriorityScore($priorityInfo, $slasec, $olasec, "FB", $sData["FEEDSUBTYPE"], $sData["language"], $data["pageID"], $customerSetID, '', '', '', '');

												logWrite(LOGFILE,"  priScore =>".$priScore);
												logWrite(LOGFILE,"  slasec =>".$slasec);

												logWrite(LOGFILE," created_time=>".$data["created_time"]);
												$arrInfo=array("CASEID"=>"-1"
													,"FEEDID"=>$sData["THREADID"]
													,"FEEDTYPE"=>"FS" //FB TO FS
													,"FEEDSUBTYPE"=>$sData["FEEDSUBTYPE"]
													,"FEEDACCOUNT"=>$sData["FEEDACCOUNT"]
													,"FEEDTITLE"=> mb_substr($data["message"],0,250,'UTF-8')
													,"FEEDBODY"=>$data["message"]//json_encode($object)
													,"FEATURE01"=>$customerSetID
													,"FEATURE02"=>null
													,"FEATURE03"=>null
													,"FEATURE04"=>null
													,"FEATURE05"=>null
													,"SOCIAL_CUSTID"=>$_sender_id
													,"SOCIAL_CUSTNAME"=>$userInfo["sender_name"]
													,"SOCIAL_CUSTINFO"=>null
													,"CONTACTID"=>$sData["CONTACTID"]
													,"CREATED_DT"=>date("Y-m-d H:i:s",$data["created_time"])
													,"PRIORITYSCORE"=>$priScore
													,"SLASEC"=>$slasec
													,"SLADUE_DT"=>date("Y-m-d H:i:s",$data["created_time"]+$slasec)
													,"OLASEC"=>$olasec
													,"OLADUE_DT"=>date("Y-m-d H:i:s",$data["created_time"]+$olasec)
													,"ADDED_DT"=>date("Y-m-d H:i:s")
													,"LANGUAGE"=>$sData["language"]
													,"FEEDPARENTID"=>$sData["PARENTID"]
													,"ISPARENTRESP"=>$sData["ISPARENTRESP"]
													,"TARGETAGENTID"=>-1
													,"RP_STATUS"=>"F"
													,"FROMBOT"=>"N"
													,"CASESTATUS"=>$casestatus
													,"AGENTID"=>-1
													,"CONVERSESSIONID"=>""
													,"CLOSEDTYPE"=>$caseclosetype
													,"CLOSEDCODE"=>$closecode
												);

												if($arrInfo["FEEDSUBTYPE"]=="CM")
												{
													$arrInfo["TARGETAGENTID"]=get_TargetAgentID($connection,array("FEEDSUBTYPE"=>"FP","FEEDPARENTID"=>$sData["PARENTID"]));
													$arrInfo["ISPARENTRESP"]=get_IsparentResp($connection,$sData);
												}else if($arrInfo["FEEDSUBTYPE"]=="CR"){
													$arrInfo["TARGETAGENTID"]=get_TargetAgentID($connection,array("FEEDSUBTYPE"=>"CM","FEEDPARENTID"=>$sData["PARENTID"]));
													$arrInfo["ISPARENTRESP"]=get_IsparentResp($connection,$sData);
												}

												$Lastfeed=get_Lastfeed_byCustomer($connection,$sData);
												//logWrite(" Lastfeed =>".print_r($Lastfeed,true));
												if(isset($Lastfeed[0]["CREATED_DT"]))
												{
													logWrite(LOGFILE," Check RP_STATUS ([".$data["created_time"]."]-[".strtotime($Lastfeed[0]["CREATED_DT"])."])>[86400]?");
													if(!isOverRepeatSec($data["created_time"], strtotime($Lastfeed[0]["CREATED_DT"]),86400))
													{
														$arrInfo["RP_STATUS"]="R";
													}
												}
												logWrite(LOGFILE," RP_STATUS =>".$arrInfo["RP_STATUS"]);
												logWrite(LOGFILE," TARGETAGENTID =>".$arrInfo["TARGETAGENTID"]);
												logWrite(LOGFILE," ISPARENTRESP =>".$arrInfo["ISPARENTRESP"]);

												Insert_CASEINFO($connection,$arrInfo);

											//End check not admin
											}else{
												logWrite(LOGFILE,"Stop insert caseinfo =>  [pageID:".$data["pageID"]."]==[sender_id:".$_sender_id."]");
											}

										//End check EN_FB_GETPOST
										} else {
											logWrite(LOGFILE," Not insert caseinfo ==> EN_FB_GETPOST is inactive.");
										}
									} else {
										logWrite(LOGFILE," Not insert caseinfo ==> error from SOCIAL_THREADS");
									}
								} else {
									logWrite(LOGFILE," Not insert caseinfo ==> page's status is inactive.");
								}
							}else{
								logWrite(LOGFILE," Not insert caseinfo ==> verb[".$sData["verb"]."]");
							}
						}
					}//FEEDTYPE != -1
					else
					{
						logWrite(LOGFILE,"sData=>".print_r($sData,true));
						logWrite(LOGFILE,"Object item does not match.");
					}

				} else {
					logWrite(LOGFILE," Fb page[".$data['pageID']."] not find!");
				}
			}
		}
	}

	/*================End Feed===================*/

	$connection->Disconnect();
	unset($connection);

} //if($object) //end object

logWrite(LOGFILE,"===================== End App Connect FB Webhook =========================");

// IF Complete
$outputJSON['requestId'] = $inputArray['requestId'];
$outputJSON['responseCode'] = '0000';    
$outputJSON['responseDesc'] = 'OK';
http_response_code(200);
header('Content-Type: application/json');
$outputJSONStr = json_encode($outputJSON);
echo $outputJSONStr;
logWrite(LOGFILE, 'Output JSON = '.$outputJSONStr);

exit();


?>