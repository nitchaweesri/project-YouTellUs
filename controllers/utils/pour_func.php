<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Bangkok');

header ("Content-Type: text/html; charset=UTF-8");
require_once ("tvutils.php");

function checkSocialCustomerID($feedtype, $feedsubtype, $userid, &$userInfo, $pageid, $pageInfo) {
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
	$sqlStatement = "SELECT * FROM CUST_SOCIALCONTACTS WHERE SOCIALTYPE='".$feedtype."' AND SOCIAL_CUSTID='".$userid."'" ;
	if (strlen($pageid) > 1) {
		$sqlStatement .= " AND SOCIALACCT='".$pageid."'";
	}
	$returnStr = $connection->ExecuteReader3($sqlStatement,Array());

	if ($returnStr['NUMROWS'] > 0) {
		logWrite(ks_filename_log,"    found social contact");
		$contactID = $returnStr['INFO'][0]['CONTACTID'];
		if ($feedtype == 'FB') {
			$userInfo = array('sender_id' => $userid, 'sender_name' => $returnStr['INFO'][0]['SOCIAL_CUSTNAME']);
		}
	} else {
		logWrite(ks_filename_log,"    NOT found social contact");

		switch( $feedtype ) {

			case 'PT' :
				$customer_info['CONTACTNAME'] = $userInfo['nickname'];
				$customer_info['SOCIAL_CUST'] = array(
					"SOCIAL_CUSTID"		=> $userInfo['uid'],
					"SOCIAL_CUSTNAME"	=> $userInfo['nickname'],
					"SOCIAL_CUSTPIC"	=> $userInfo['avatar'],
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
					$contactID = getFacebookID($userid, $userInfo, $pageid, $pageInfo, $customer_info);
				} else {
					logWrite(ks_filename_log,"      Checking sender ID (ASID:FP,CM,CR)");
					$psid = getFacebookPSID($userid, $pageid, $pageInfo);
					if ($psid > 1) {
						$contactID = getFacebookID($psid, $userInfo, $pageid, $pageInfo, $customer_info);
						$userInfo['sender_id'] = $userid;
					}

				}
			break;


			default : 
				logWrite(ks_filename_log,"    Create new contact ID.");
			break;
		}
	}

	return $contactID;
}
/*
function getFacebookPSID($asid, $pageid, $pageInfo){
	global $connection;

	logWrite(ks_filename_log,"      getFBPSID");
	$psid = '-1';
	$proof = hash_hmac('sha256', $pageInfo[$pageid]['PAGE_TOKEN'], $pageInfo[$pageid]['APP_SECRET']);

	$url = 'https://graph.facebook.com/v2.12/' . $asid . '/ids_for_pages?access_token=' . $pageInfo[$pageid]['APP_ID'] . '|' . $pageInfo[$pageid]['APP_SECRET'] . '&appsecret_proof=' . $proof;
	$result_array = getFromURL($url, 'null', 30);
	if ($result_array['status'] == "SUCCESS") {
		$custArray = json_decode($result_array['responsetext'], true);
//		print "<br/>custArray = <pre>".print_r($custArray, true)."</pre><br/>-------------------<br/>";
		foreach( $custArray['data'] as $items)
		{
			if ($items['page']['id'] == $pageid) {
				$psid = $items['id'];
				break;
			}
		}
	}
	return $psid;
}

function getFacebookASID(){
	global $connection;
	logWrite(ks_filename_log,"    getFBPSID");
	return true;
}

function getFacebookID($userid, &$userInfo, $pageid, $pageInfo, &$customer_info){
	global $connection;

	logWrite(ks_filename_log,"      getFacebookID");

	$url = 'https://graph.facebook.com/v2.12/' . $userid . '?fields=id,name,profile_pic,first_name,last_name,gender,ids_for_apps,ids_for_pages&access_token=' . $pageInfo[$pageid]['PAGE_TOKEN'];
	$result_array = getFromURL($url, 'null', 30);
	if ($result_array['status'] == "SUCCESS") {
		$custArray = json_decode($result_array['responsetext'], true);

		$customer_info['CONTACTNAME'] = $custArray['first_name']." ".$custArray['last_name'];

		$userInfo = array('sender_id' => $userid, 'sender_name' => $custArray['name'], 'profile_pic' => $custArray['profile_pic']);
		$customer_info['SOCIAL_CUST'] = array(
			"SOCIAL_CUSTID"		=> $userInfo['sender_id'],
			"SOCIAL_CUSTNAME"	=> $custArray['name'],
			"SOCIAL_CUSTPIC"	=> $custArray['profile_pic'],
			"SOCIAL_CUSTINFO"	=> json_encode($userInfo)
		);

		$_ids_for_apps="";
		$_ids_for_pages="";
		$_myids="";
		if(isset($custArray['ids_for_pages']))
		{
			foreach( $custArray['ids_for_pages']['data'] as $items)
			{
				$_ids_for_pages.=",".$items['id'];
				$_myids.=",".$items['id'];
			}
		}
		
		if(isset($custArray['ids_for_apps']))
		{
			foreach( $custArray['ids_for_apps']['data'] as $items)
			{
				$_ids_for_apps.=",".$items['id'];
				$_myids.=",".$items['id'];
			}
		}

		$custArray['my_ids_for_apps']=ltrim($_ids_for_apps, ',');
		$custArray['my_ids_for_pages']=ltrim($_ids_for_pages, ',');
		$custArray['my_ids_all']=ltrim($_myids, ',');
		$contactID = manage_fb_contact($custArray, $customer_info);
	} else {
		logWrite(ks_filename_log,"      Cannot get data from Facebook.");
		logWrite(ks_filename_log,"      Error =>".json_decode($result_array['responsetext'], true) );
		$userInfo = array('sender_id' => $userid, 'sender_name' => "UNKNOWN", 'profile_pic' => "");
		$contactID = '-888';
	}

	return $contactID;
}

function manage_fb_contact($fbCustArray, $customer_info) {
	global $connection;

	logWrite(ks_filename_log,"      manage_fb_contact : all ID [START]");
	$sqlStatement = "SELECT * FROM CUST_SOCIALCONTACTS WHERE SOCIALTYPE='FB' AND SOCIAL_CUSTID IN (".$fbCustArray['my_ids_all'].") ORDER BY CONTACTID " ;
	$returnStr = $connection->ExecuteReader3($sqlStatement,Array());
//	print "<br/>returnStr = <pre>".print_r($returnStr, true)."</pre><br/>-------------------<br/>";

	if ($returnStr['NUMROWS'] > 0) {
		$contactID = $returnStr['INFO'][0]['CONTACTID'];
		logWrite(ks_filename_log,"        Found contact [".$contactID."]");
	} else {
		logWrite(ks_filename_log,"        Not found contact");
		$result_array = create_new_contact( $customer_info );
		if ($result_array['id'] != "0") {
			$contactID = $result_array['id'];
			logWrite(ks_filename_log,"        Create new contact ID::DONE[".$contactID."]");
		} else {
			logWrite(ks_filename_log,"        Create new contact ID::FAIL");
			$contactID = '-999';
		}
	}
	$customer_info['CONTACTID'] = $contactID;

	if( isset( $fbCustArray['ids_for_apps'] ) ) {
		logWrite(ks_filename_log,"        Manage Facebook ASID");

		$tempCust = $customer_info;
		foreach($fbCustArray['ids_for_apps']['data'] as $custItem )
		{
			$tempCust['SOCIALAPPID'] = $custItem['app']['id'];
			$tempCust['SOCIAL_CUST']['SOCIAL_CUSTID'] = $custItem['id'];
			$tempCust['SOCIAL_CUST']['SOCIAL_CUSTINFO'] = json_encode($custItem);

			$sqlStatement = "SELECT * FROM CUST_SOCIALCONTACTS WHERE SOCIALTYPE='FB' AND SOCIAL_CUSTID='" . $custItem['id']."'" ;
			$returnStr = $connection->ExecuteReader3($sqlStatement,Array());
			if ($returnStr['NUMROWS'] < 1) {
				$result_array = create_new_social_contact($tempCust);
				if ($result_array['id'] != "0") {
					$scid = $result_array['id'];
					logWrite(ks_filename_log,"          Create new social contact::DONE[".$scid."]");
				}
			}
		}
	}

	if( isset( $fbCustArray['ids_for_pages'] ) ) {
		logWrite(ks_filename_log,"        Manage Facebook PSID");

		$tempCust = $customer_info;
		foreach($fbCustArray['ids_for_pages']['data'] as $custItem )
		{
			$tempCust['SOCIALACCT'] = $custItem['page']['id'];
			$tempCust['SOCIAL_CUST']['SOCIAL_CUSTID'] = $custItem['id'];
			$tempCust['SOCIAL_CUST']['SOCIAL_CUSTINFO'] = json_encode($custItem);

			$sqlStatement = "SELECT * FROM CUST_SOCIALCONTACTS WHERE SOCIALTYPE='FB' AND SOCIAL_CUSTID='" . $custItem['id']."'" ;
			$returnStr = $connection->ExecuteReader3($sqlStatement,Array());
			if ($returnStr['NUMROWS'] < 1) {
				$result_array = create_new_social_contact($tempCust);
				if ($result_array['id'] != "0") {
					$scid = $result_array['id'];
					logWrite(ks_filename_log,"          Create new social contact::DONE[".$scid."]");
				}
			}
		}
	}

	logWrite(ks_filename_log,"      manage_fb_contact : all ID [DONE]");
	return $contactID;
}
*/




function checkSocialCustomerID1($feedtype, $feedsubtype, $userid, &$userInfo, $pageid, $pageInfo) {
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
	$sqlStatement = "SELECT * FROM CUST_SOCIALCONTACTS WHERE SOCIALTYPE='".$feedtype."' AND SOCIAL_CUSTID='".$userid."'" ;
	if (strlen($pageid) > 1) {
		$sqlStatement .= " AND SOCIALACCT='".$pageid."'";
	}
	$returnStr = $connection->ExecuteReader3($sqlStatement,Array());
	//print "<br/>returnStr = <pre>".print_r($returnStr, true)."</pre><br/>-------------------<br/>";

	if ($returnStr['NUMROWS'] > 0) {
		logWrite(ks_filename_log,"    found social contact");
		$contactID = $returnStr['INFO'][0]['CONTACTID'];
		if ($feedtype == 'FB') {
			$userInfo = array('sender_id' => $userid, 'sender_name' => $returnStr['INFO'][0]['SOCIAL_CUSTNAME']);
		}
	} else {
		logWrite(ks_filename_log,"    NOT found social contact");

/*		if ($feedtype == 'FB') {
			logWrite(ks_filename_log,"    Preparing Facebook customer ID checking process.");
			if ($feedsubtype == 'ME') {
				logWrite(ks_filename_log,"      Checking messengerID");
				$url = 'https://graph.facebook.com/v2.12/' . $sender_id . '?fields=id,name,first_name,last_name,gender,ids_for_apps,ids_for_pages&access_token=' . $access_token;
			} else {
				logWrite(ks_filename_log,"      Checking customerID");
				$url = 'https://graph.facebook.com/v2.12/' . $sender_id . '?fields=id,name,first_name,last_name,gender,ids_for_apps,ids_for_pages&access_token=' . $access_token;
				https://graph.facebook.com/v2.12/720860838117661/ids_for_pages?access_token=355645551467760|d470fe5059831728b29e1a9311949523&appsecret_proof=d5e810e236e550f512ea6ccf057c8a5053171b0ed3167407bdd131b66e58c849
			}
		} else {
			logWrite(ks_filename_log,"    Create new contact ID.");
		}*/

		switch( $feedtype ) {
			case 'FB' :
				logWrite(ks_filename_log,"    Preparing Facebook customer ID checking process.");
				$proof = hash_hmac('sha256', $pageInfo[$pageid]['PAGE_TOKEN'], $pageInfo[$pageid]['APP_SECRET']);
				//print "<br/>pageInfo = <pre>".print_r($pageInfo, true)."</pre><br/>-------------------<br/>";

				if ($feedsubtype == 'ME') {
					logWrite(ks_filename_log,"      Checking messengerID");
					$url = 'https://graph.facebook.com/v2.12/' . $userid . '?fields=id,name,profile_pic,first_name,last_name,gender,ids_for_apps,ids_for_pages&access_token=' . $pageInfo[$pageid]['PAGE_TOKEN'];
					$result_array = getFromURL($url, 'null', 30);
					if ($result_array['status'] == "SUCCESS") {
						logWrite(ks_filename_log,"      start loop");
						$custArray = json_decode($result_array['responsetext'], true);

						$userInfo = array('sender_id' => $userid, 'sender_name' => $custArray['name'], 'profile_pic' => $custArray['profile_pic']);

						$customer_info['CONTACTNAME'] = $custArray['first_name']." ".$custArray['last_name'];
						$customer_info['SOCIAL_CUST'] = array(
							"SOCIAL_CUSTID"		=> $userInfo['sender_id'],
							"SOCIAL_CUSTNAME"	=> $userInfo['sender_name'],
							"SOCIAL_CUSTPIC"	=> $userInfo['profile_pic'],
							"SOCIAL_CUSTINFO"	=> json_encode($userInfo)
						);
/*
						foreach($custArray as $key => $custList) {
print "<br/>custList[$key] = <pre>".print_r($custList, true)."</pre><br/>-------------------<br/>";
						}*/

						$_ids_for_apps="";
						$_ids_for_pages="";
						$_myids="";
						if(isset($custArray['ids_for_pages']))
						{
							foreach( $custArray['ids_for_pages']['data'] as $items)
							{
								$_ids_for_pages.=",".$items['id'];
								$_myids.=",".$items['id'];
							}
						}
						
						if(isset($custArray['ids_for_apps']))
						{
							foreach( $custArray['ids_for_apps']['data'] as $items)
							{
								$_ids_for_apps.=",".$items['id'];
								$_myids.=",".$items['id'];
							}
						}

						$custArray['my_ids_for_apps']=ltrim($_ids_for_apps, ',');
						$custArray['my_ids_for_pages']=ltrim($_ids_for_pages, ',');
						$custArray['my_ids_all']=ltrim($_myids, ',');
//print "<br/>custArray = <pre>".print_r($custArray, true)."</pre><br/>-------------------<br/>";
						manage_fb_contact($custArray, $customer_info);
					}
				} else {
					logWrite(ks_filename_log,"      Checking customerID");
//print "<br/>pageInfo = <pre>".print_r($pageInfo, true)."</pre><br/>-------------------<br/>";

					$url = 'https://graph.facebook.com/v2.12/' . $userid . '/ids_for_pages?access_token=' . $pageInfo[$pageid]['APP_ID'] . "|" . $pageInfo[$pageid]['APP_SECRET'] . "&appsecret_proof=" . $proof;
					//echo "url = $url<br/>";
					$result_array = getFromURL($url, 'null', 30);
					if ($result_array['status'] == "SUCCESS") {
						logWrite(ks_filename_log,"      start loop");
						$custArray = json_decode($result_array['responsetext'], true);
print "<br/>custArray = <pre>".print_r($custArray, true)."</pre><br/>-------------------<br/>";
						foreach($custArray['data'] as $custList) {
							print "SOCIAL_CUSTID='".$custList['id']."'<br/>";
//print "<br/>custList = <pre>".print_r($custList, true)."</pre><br/>-------------------<br/>";
							$sqlStatement = "SELECT * FROM CUST_SOCIALCONTACTS WHERE SOCIALTYPE='".$feedtype."' AND SOCIAL_CUSTID='".$custList['id']."' AND SOCIALACCT='".$custList['page']['id']."'";
							$returnStr = $connection->ExecuteReader3($sqlStatement,Array());
							if ($returnStr['NUMROWS'] > 0) {
//print "<br/>returnStr = <pre>".print_r($returnStr, true)."</pre><br/>-------------------<br/>";
							}
						}
					}
//					$tempArray = json_decode($result, true);
//print "<br/>tempArray = <pre>".print_r($tempArray, true)."</pre><br/>-------------------<br/>";
				}
			break;

			case 'PT' :
				$customer_info['CONTACTNAME'] = $userInfo['nickname'];
				$customer_info['SOCIAL_CUST'] = array(
					"SOCIAL_CUSTID"		=> $userInfo['uid'],
					"SOCIAL_CUSTNAME"	=> $userInfo['nickname'],
					"SOCIAL_CUSTINFO"	=> json_encode($userInfo)
				);

				logWrite(ks_filename_log,"    Create new contact ID.");
				$result_array = create_new_contact( $customer_info );
				//echo "result_array = <br/><pre>".print_r($result_array, true)."</pre><br/>";
				
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

?>
