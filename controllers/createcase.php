<?php   

    include('crypt.php');
	try{

		// $_POST['name'] = 'matsafik';
		// $_POST['idcard'] = '1960800106547';
		// $_POST['tell'] = '0822671922';
		// $_POST['email'] = 'fik.fik.fuk@gmail.com';
		// $_POST['title'] = 'ร้องเรียน';
		// $_POST['iduser'] = 'f449cdef';
		// $_POST['description'] = 'เรื่องการบริการ';

		$url = "https://devytuapp.tellvoice.com/TVSSCRAWLER3/youtellus/webhook.php";
		
		$idcard = encryptString($_POST['idcard']);
		$ch = curl_init( $url );

		///////////// set json data ////////////
		$Jsonbody->title = $_POST['title'];
		$Jsonbody->iduser = $_POST['iduser'];
		$Jsonbody->description = $_POST['description'];
		

		# Setup request to send json via POST.
		$ParamArr->name = $_POST['name'];
		$ParamArr->idcard = $idcard;    
		$ParamArr->tell = $_POST['tell'];
		$ParamArr->email = $_POST['email'];
		$ParamArr->title = $_POST['title'];
		$ParamArr->description = $Jsonbody;
		$ParamArr->file1 = $_POST['file1'];
		$ParamArr->file2 = $_POST['file2'];
		$ParamArr->file3 = $_POST['file3'];
		$ParamArr->file4 = $_POST['file4'];

		
		$payload = json_encode( $ParamArr);

		// print_r ($payload);

		$ParamArr = array( "data"=> "FIK TEST" );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		# Return response instead of printing.
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		# Send request.
		$result = curl_exec($ch);
		curl_close($ch);
		# Print response.
		// echo "<pre>$result</pre>";
		
		
		header("Location: ../index.php?page=thanks");

	}catch (Exception $e) {
		$msg = "error";
		header("Location: ../index.php?page=error&msg=$msg");
	}

?>