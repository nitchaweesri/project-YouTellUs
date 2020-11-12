<?php header ("Content-Type: text/html; charset=UTF-8"); ?>
<?php

/* -----------------------------------------------------------------------
 * priorityfunc.php
 * -----------------------------------------------------------------------
 * Purpose : Priority score handle function for TVSS3.0
 * Author  : Pitichat Suttaroj <pitichat@tellvoice.com>
 * Created : 07 Mar 2018
 * History :
 *  07 Mar 2018 - Create file
 * -----------------------------------------------------------------------
 */

include_once("../dbutil/includes/services.php");


/* getPriorityList
 * ---------------
 * Purpose : Get priority list object routine
 * Input   : None
 * Return  : Priority list array(null if error occurred!)
 */

function getPriorityList()
{
	$sqlString = "SELECT * FROM CASEPRIORITY ORDER BY ITEM_ORDER ASC";
	$value = array();
	$queryResult = getQueryResult($sqlString, $value);
	if($queryResult['numrows'] <= 0){
		return(null);
	}
	
	return($queryResult['info']);
}


/* getPriorityScore
 * ----------------
 * Purpose : Get priority score of input's features
 * Input   :
 *  (1) '$priorityList' = input priority list
 *  (2) '$sla' = output SLA for this input feature(why does set here!?)
 *  (3) '$ola' = output OLA for this input feature(why does set here!?)
 *  (4) '$feedType' = input feed type feature
 *  (5) '$feedSubtype' = input feed subtype feature
 *  (6) '$feedLang' = input feed language feature
 *  (7) '$feedAccount' = input feed account feature
 *  (8) '$param1' = additional feature parameter #1
 *  (9) '$param2' = additional feature parameter #2
 *  (10) '$param3' = additional feature parameter #3
 *  (11) '$param4' = additional feature parameter #4
 *  (12) '$param5' = additional feature parameter #5
 * Return  : Priority score(0-100?)
 */

function getPriorityScore($priorityList, &$sla, &$ola, $feedType, $feedSubtype, $feedLang, $feedAccount, $param1 = "", $param2 = "", $param3 = "", $param4 = "", $param5 = "")
{
	$featArray = array(
		"FEEDTYPE",
		"FEEDSUBTYPE",
		"FEEDLANG",
		"FEEDACCOUNT",
		"PARAM1",
		"PARAM2",
		"PARAM3",
		"PARAM4",
		"PARAM5"
	);
	
	$inputArray = array(
		"FEEDTYPE" => $feedType,
		"FEEDSUBTYPE" => $feedSubtype,
		"FEEDLANG" => $feedLang,
		"FEEDACCOUNT" => $feedAccount,
		"PARAM1" => $param1,
		"PARAM2" => $param2,
		"PARAM3" => $param3,
		"PARAM4" => $param4,
		"PARAM5" => $param5
	);

	$sla = $ola = 3600;                    // Just initial

	foreach($priorityList as $priorityItem){
		$score = $priorityItem['PRIORITYSCORE'];
		$match = true;
		foreach($featArray as $featItem){
			if(($priorityItem[$featItem] != $inputArray[$featItem]) && ($priorityItem[$featItem] != "")){
				$match = false;
				break;
			}
		}
		if($match == true){
			$sla = $priorityItem['SLASEC'];    $ola = $priorityItem['OLASEC'];
			return($score);
		}
	}
		
	return(0);
}

?>
