<?php
function MonthCombo($FLDNAME, $DEFAULTMONTH){
	$MONTHARRAY = array();
	$MONTHARRAY[] = array("CODE"=>1, "TITLE"=>"January");
	$MONTHARRAY[] = array("CODE"=>2, "TITLE"=>"February");
	$MONTHARRAY[] = array("CODE"=>3, "TITLE"=>"March");
	$MONTHARRAY[] = array("CODE"=>4, "TITLE"=>"April");
	$MONTHARRAY[] = array("CODE"=>5, "TITLE"=>"May");
	$MONTHARRAY[] = array("CODE"=>6, "TITLE"=>"June");
	$MONTHARRAY[] = array("CODE"=>7, "TITLE"=>"July");
	$MONTHARRAY[] = array("CODE"=>8, "TITLE"=>"August");
	$MONTHARRAY[] = array("CODE"=>9, "TITLE"=>"September");
	$MONTHARRAY[] = array("CODE"=>10, "TITLE"=>"October");
	$MONTHARRAY[] = array("CODE"=>11, "TITLE"=>"November");
	$MONTHARRAY[] = array("CODE"=>12, "TITLE"=>"December");
?>
<SELECT NAME="<?php print $FLDNAME;?>" ID="<?php print $FLDNAME;?>">
<?php
	foreach($MONTHARRAY as $nItem=>$MonthInfo){
?>
	<OPTION VALUE="<?php print $MonthInfo['CODE'];?>" <?php if(intval($DEFAULTMONTH)==$MonthInfo['CODE']){print "SELECTED";}?>><?php print $MonthInfo['CODE'];?> - <?php print $MonthInfo['TITLE'];?></OPTION>
<?php }?>
</SELECT>
<?php
}


function YearCombo($FLDNAME, $DEFAULTYEAR){
?>
<SELECT NAME="<?php print $FLDNAME;?>" ID="<?php print $FLDNAME;?>">
<?php
	for($iYear=date("Y")-5; $iYear<= date("Y")+1;$iYear++){
?>
	<OPTION VALUE="<?php print $iYear;?>" <?php if($DEFAULTYEAR==$iYear){print "SELECTED";}?>><?php print $iYear;?></OPTION>
<?php }?>
</SELECT>
<?php
}

function MonthPeriodCombo($FLDNAME, $DEFAULTVAL){
?>
<SELECT NAME="<?php print $FLDNAME;?>" ID="<?php print $FLDNAME;?>">
<?php
	for($ii=1; $ii<= 12;$ii++){
?>
	<OPTION VALUE="<?php print $ii;?>" <?php if($DEFAULTVAL==$ii){print "SELECTED";}?>><?php print $ii;?></OPTION>
<?php }?>
</SELECT>
<?php
}


function DispSelMasterData($DATATYPE, $HASALL, $FLDTITLE, $DEFVAL){
?>
<select name="<?php print $FLDTITLE;?>" id="<?php print $FLDTITLE;?>" >
<?php if($HASALL){?>
	<option value="" <?php if($DEFVAL == ""){print "SELECTED";}?>>All</option>
<?php }?>
<?php
		$SQLStatement = "SELECT * FROM MASTERDATA WHERE DATATYPE = '$DATATYPE' ORDER BY FLDPK ASC ";
		$value = array();
		$QueryResult = getQueryResult($SQLStatement, $value);
		//print_r($QueryResult);exit;return;
		if($QueryResult['numrows'] > 0){
			$ResultList = $QueryResult['info'];
			foreach($ResultList as $nItem=>$ResultInfo){
?>
	<option value="<?php print $ResultInfo['FLDPK'];?>" <?php if($ResultInfo['FLDPK'] == $DEFVAL){print "SELECTED";}?>><?php print $ResultInfo['FLDPK'];?> : <?php print $ResultInfo['FLDDESC'];?></option>
<?php
			}
		}
?>
</select>
<?php
	}
	
	
function ShowMsg($TITLE, $TXT, $JSTXT = ""){
?>
<IMG SRC="images/icons/blank1x1.gif" onLoad="
	BootstrapDialog.show({
		title: '<?php print $TITLE?>',
		message: '<?php print $TXT?>',
		buttons: [{
			label: 'Close',
			action: function(dialog) {
				<?php print $JSTXT;?>
				dialog.close();
			}
		}]
	});
"/>
<?php
}

function ShowErrorMsg($TITLE, $TXT){
?>
<IMG SRC="images/icons/blank1x1.gif" onLoad="
	BootstrapDialog.alert({
			title: '<?php print $TITLE?>',
			message: '<?php print $TXT?>',
			type: BootstrapDialog.TYPE_DANGER, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
			buttonLabel: 'OK',
			callback: function(result) {
				
				if($('#INVPROC_INVID').val()){
					
					setTimeout(function(){$('#INVPROC_INVID').focus();$('#INVPROC_INVID').select();}, 50);
					
					
				}
			}
		});
		
"/>
<?php
}


function ShowAutoHideMsg($TITLE, $TXT, $DISPMILLISEC, $AUTOFOCUSAFTER = null){
?>
<IMG SRC="images/icons/blank1x1.gif" onLoad="
	BootstrapDialog.show({
		title: '<?php print $TITLE?>',
		message: '<?php print $TXT?>',
		buttons: [{
			label: 'Close',
			action: function(dialog) {
				dialog.close();
			}
		}],
		onshown: function(dialogRef){
			setTimeout(function(){dialogRef.close();<?php if($AUTOFOCUSAFTER != null){?>$('#<?php print $AUTOFOCUSAFTER;?>').focus();$('#<?php print $AUTOFOCUSAFTER;?>').select();<?php }?>}, <?php print $DISPMILLISEC;?>);
		}
	});
"/>
<?php
}

function ShowMsgWithDelay($TITLE, $TXT, $JSTXT = "", $CLOSEALLDIALOG=false, $DELAY=200){
?>
<IMG SRC="images/icons/blank1x1.gif" onLoad="
	BootstrapDialog.show({
		title: '<?php print $TITLE?>',
		message: '<?php print $TXT?>',
		buttons: [{
			label: 'Close',
			action: function(dialog) {
				dialog.close();
			}
		}],
		onhidden: function(dialogRef){
			<?php if($CLOSEALLDIALOG){?>BootstrapDialog.closeAll();<?php }?>
			setTimeout(function(){
				<?php print $JSTXT;?>
			}, <?php print $DELAY;?>);
		}
	});
"/>
<?php
}


function AutoFocusAfter($FLDID, $DISPMILLISEC){
?>
<IMG SRC="images/icons/blank1x1.gif" onLoad="
	setTimeout(function(){$('#<?php print $FLDID;?>').focus();$('#<?php print $FLDID;?>').select();}, <?php print $DISPMILLISEC;?>);
"/>
<?php
}


function RunJS($JSTXT){
?>
<IMG SRC="images/icons/blank1x1.gif" onLoad="
	<?php print $JSTXT;?>
"/>
<?php
}
?>