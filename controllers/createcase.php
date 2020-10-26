<?php   

    include('crypt.php');


	// $url = "https://devytuapp.tellvoice.com/TVSSCRAWLER3/youtellus/webhook.php";
    
    $idcard = encryptString($_POST['idcard']);
	// $ch = curl_init( $url );
    # Setup request to send json via POST.
    $ParamArr->name = $_POST['name'];
    $ParamArr->idcard = $idcard;    
    $ParamArr->tell = $_POST['tell'];
    $ParamArr->email = $_POST['email'];
    $ParamArr->title = $_POST['title'];
    $ParamArr->title = $_POST['title'];
    $ParamArr->iduser = $_POST['iduser'];
    $ParamArr->description = $_POST['description'];
    $ParamArr->file1 = $_POST['file1'];
    $ParamArr->file2 = $_POST['file2'];
    $ParamArr->file3 = $_POST['file3'];
    $ParamArr->file4 = $_POST['file4'];

    
	$payload = json_encode( $ParamArr);

    print_r ($_POST);

	// $ParamArr = array( "data"=> "FIK TEST" );
	// curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
	// curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	// # Return response instead of printing.
	// curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	// # Send request.
	// $result = curl_exec($ch);
	// curl_close($ch);
	// # Print response.
    // echo "<pre>$result</pre>";
    
     
?>