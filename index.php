<?php
	$url = "https://devytuapp.tellvoice.com/TVSSCRAWLER3/youtellus/webhook.php";
	
	$ch = curl_init( $url );
	# Setup request to send json via POST.
	
	$ParamArr = array("data"=> "FIK TEST" );
	$payload = json_encode( $ParamArr );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	# Return response instead of printing.
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	# Send request.
	$result = curl_exec($ch);
	curl_close($ch);
	# Print response.
    echo "<pre>$result</pre>";
    
     
?>