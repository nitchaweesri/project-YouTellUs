<?php header ("Content-Type: text/html; charset=UTF-8"); ?>
<?php

/* -----------------------------------------------------------------------
 * textprocfunc.php
 * -----------------------------------------------------------------------
 * Purpose : TVSS3.0 text processing utility functions
 * Author  : Pitichat Suttaroj <pitichat@tellvoice.com>
 * Created : 12 Mar 2018
 * History :
 *  12 Mar 2018 - Create file
 * -----------------------------------------------------------------------
 */

include_once("../dbutil/includes/services.php");


/* getKeywordGroupList
 * -------------------
 * Purpose : Get keyword group list routine
 * Input   : None
 * Return  : Keyword group list array
 */

function getKeywordGroupList()
{
	$keywordGroupList = array();
	
	$sqlString = "SELECT GROUPNAME, KEYWORDLIST FROM CONFIG_KEYWORDGROUP WHERE ENABLE=? ORDER BY ITEM_ORDER DESC";
	$value = array('Y');
	$queryResult = getQueryResult($sqlString, $value);
	if($queryResult['numrows'] <= 0){
		return($keywordGroupList);
	}

	foreach($queryResult['info'] as $infoItem){
		$keywordList = json_decode($infoItem["KEYWORDLIST"], true);
		if(json_last_error() != JSON_ERROR_NONE){
			$keywordList = array();
		}
		$keywordInfo = array("GROUPNAME" => $infoItem["GROUPNAME"], "KEYWORDLIST" => $keywordList);
		array_push($keywordGroupList, $keywordInfo);
	}
	
	return($keywordGroupList);
}


/* getInputStringKeywordGroup
 * --------------------------
 * Purpose : Get keyword group from input string
 * Input   :
 *  (1) '$keywordGroupList' = input keyword group list
 *  (2) '$inputString' = input string
 * Return  : Keyword group(null string if not found)
 */

function getInputStringKeywordGroup($keywordGroupList, $inputString)
{
	foreach($keywordGroupList as $keywordInfo){
		foreach($keywordInfo["KEYWORDLIST"] as $keyword){
			$pos = strpos($inputString, $keyword);
			if($pos !== false){
				return($keywordInfo["GROUPNAME"]);
			}
		}
	}

	return("");            /* Not found */
}

?>
