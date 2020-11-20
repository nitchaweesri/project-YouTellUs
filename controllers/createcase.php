<?php

include_once('crypt.php') ;

// die ('yes');
if (isset($_POST['create_case'])) {
    // print_r($_POST);
    create_case($_POST);
}

function create_case($data)
{

    try{

        $url = "https://devytuapp.tellvoice.com/TVSSCRAWLER3/youtellus/webhook_fik_test.php";
        
        $idcard = encryptString($_POST['idcard']);
        $ch = curl_init( $url );


        $JsonFile = array();
        foreach ($_POST['file'] as $key => $value) {
            $JsonFile["file$key"] = $value ;
            $JsonFile["linkFile$key"] = 'https://devytuapp.tellvoice.com/youtellus/uploads/file/'.$_POST['linkFile'][$key];

        }

        ///////////// set json data ////////////
        $Jsonbody = array(  "name"=> $_POST['name']
                            ,"idCard"=> $idcard
                            ,"tel"=> $_POST['tel'] 
                            ,"email"=> $_POST['email']
                            ,"idUser"=> $_POST['iduser']
                            ,"other"=> isset($_POST['other'])? $_POST['other'] : "" 
                            ,"description"=> $_POST['description']
                            ,"nameDelegate"=> isset($_POST['nameDelegate'])? $_POST['nameDelegate'] : "" 
                            ,"service"=> isset($_POST['service'])? $_POST['service'] : "" 
                            ,"serviceId"=> isset($_POST['serviceID'])? $_POST['serviceID'] : "" 
                            ,"relationOption"=> isset($_POST['relationOptions'])? $_POST['relationOptions'] : "" 
                            ,"numId"=> isset($_POST['numID'])? $_POST['numID'] : "" 
                            ,"nameAuthorizedPerson"=> isset($_POST['nameAuthorizedPerson'])? $_POST['nameAuthorizedPerson'] : "" 
                            ,"position"=> isset($_POST['position'])? $_POST['position'] : "" 
                            ,"nameOwner"=> isset($_POST['nameOwner'])? $_POST['nameOwner'] : "" 
                            ,"file"=>json_encode($JsonFile)
                        );
        

        $ParamArr = array(   
                            "feedTitle"=> $_POST['feedtype'].' : '.$_POST['tel'].' '.$_POST['name']
                            ,"feedType"=> $_POST['feedtype']
                            ,"feedSubType"=> $_POST['feedsubtype']
                            ,"feedBody"=> json_encode($Jsonbody)
                        );
        
        $payload = json_encode( $ParamArr);

        // die(print_r ($payload));

        // $ParamArr = array( "data"=> "FIK TEST" );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        # Return response instead of printing.
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);
        # Print response.
        // ;
        
        // die(print_r( "<pre>$result</pre>"));

        header("Location: ../index.php?page=thanks");

    }catch (Exception $e) {
        $msg = "error";
        header("Location: ../index.php?page=error&msg=$msg");
    }
}


 ?>