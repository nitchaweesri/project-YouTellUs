<?php header ("Content-Type: text/html; charset=UTF-8"); ?>
<?php

/* -------------------------------------------------------------------------------
 * botutils.php
 * -------------------------------------------------------------------------------
 * Purpose : Bot utility routines
 * Author  : Pitichat Suttaroj <pitichat@tellvoice.com>
 * Created : 06 Sep 2017
 * History :
 *  06 Sep 2017 - Create file
 *  18 Sep 2017 - Add new input argument '$botSCID' to 'sendWebhookDataToBotTrigger()'
 *  26 Sep 2017 - Check existing of 'tvutils.php'
 *              - Add function 'getChatChannelToken()'
 *  06 Mar 2018 - Add function 'sendWebhookDataToSurveyBotTrigger()' here...
 *  25 Dec 2018 - Modify function ''sendWebhookDataToBotTrigger()'' to add
 *                new input argument '$surveyEnable'
 * -------------------------------------------------------------------------------
 */

if(file_exists('../function/tvutils.php')){
	include_once("../function/tvutils.php");
}
else if(file_exists('tvutils.php')){
	include_once("tvutils.php");
}


/* *********************************** */
/* ******** Utility Functions ******** */
/* *********************************** */

/* sendWebhookDataToBotTrigger
 * ---------------------------
 * Purpose : Send input social media webhook data to Tellvoice's chatbot platform
 * Input   :
 *  (1) '$channel' = input social media channel("LN"/"FB")
 *  (2) '$channelID' = input social media channel ID
 *  (3) '$channelToken' = input channel access token(at least for channel "LINE")
 *  (4) '$webhookArray' = input social media webhook array
 *  (5) '$botURL' = Tellvoice's chatbot platform URL
 *  (6) '$botSCID' = target chatbot's conversation flow ID
 *  (7) '$surveyEnable' = survey enable or not for this conversation('Y'/'N'?)
 * Return  : None
 */

function sendWebhookDataToBotTrigger($channel, $channelID, $channelToken, $webhookArray, $botURL, $botSCID, $surveyEnable='N')
{
	$retVal = array();

	/* Make bot request message */
	$botInputArray = array(
		"channel" => $channel,
		"channelid" => $channelID,
		"channeltoken" => $channelToken,
		"botscid" => $botSCID,
		"surveyenable" => $surveyEnable,
		"data" => $webhookArray
	);
	
	$botInputJSONString = json_encode($botInputArray);
	$jerr = json_last_error();
	if($jerr != JSON_ERROR_NONE){
		/* JSON encode error! */
		return;
	}

	$retVal = postJSONString($botInputJSONString, $botURL, null, 2);

	return;
}


/* sendWebhookDataToSurveyBotTrigger
 * ---------------------------------
 * Purpose : Send input social media webhook data to Tellvoice's survey chatbot platform
 * Input   :
 *  (1) '$channel' = input social media channel("LN"/"FB")
 *  (2) '$channelID' = input social media channel ID
 *  (3) '$channelToken' = input channel access token(at least for channel "LINE")
 *  (4) '$webhookArray' = input social media webhook array
 *  (5) '$sbotURL' = Tellvoice's chatbot platform URL
 * Return  : None
 */

function sendWebhookDataToSurveyBotTrigger($channel, $channelID, $channelToken, $webhookArray, $sbotURL)
{
	/* Make bot request message */
	$sbotInputArray = array(
		"channel" => $channel,
		"channelid" => $channelID,
		"userid" => "",
		"templateid" => "",
		"jobcontactid" => "",
		"jobid" => "",
		"channeltoken" => $channelToken,
		"data" => $webhookArray
	);
	
	$botInputJSONString = json_encode($sbotInputArray);
	$jerr = json_last_error();
	if($jerr != JSON_ERROR_NONE){
		/* JSON encode error! */
		return;
	}

	$retVal = postJSONString($botInputJSONString, $sbotURL, null, 2);

	return;
}


/* getChatChannelToken
 * -------------------
 * Purpose : Get chatting channel token from database
 * Input   :
 *  (1) '$channel' = input social media channel
 *  (2) '$channelID' = social channel ID
 * Return  : Channel token(NULL string if any error)
 */

function getChatChannelToken($channel, $channelID)
{
	$sqlStatement = "SELECT CHANNELTOKEN FROM CHATCHANNELTOKEN WHERE CHANNEL=? AND CHANNELID=?";
	$value = array($channel, $channelID);
	$queryResult = getQueryResult($sqlStatement, $value);
	if($queryResult['numrows'] != 1){
		return("");
	}

	return($queryResult['info'][0]['CHANNELTOKEN']);
}

?>
