
<?php

include_once('crypt.php') ;

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

        ///////////// set json data ////////////
        $Jsonbody = array(  "name"=> $_POST['name']
                            ,"idCard"=> $idcard
                            ,"tell"=> $_POST['tell'] 
                            ,"email"=> $_POST['email']
                            ,"idUser"=> $_POST['iduser']
                            ,"description"=> $_POST['description']
                            ,"file1"=> isset($_POST['file1'])? $_POST['file1'] : ""
                            ,"file2"=> isset($_POST['file2'])? $_POST['file2'] : ""
                            ,"file3"=> isset($_POST['file3'])? $_POST['file3'] : ""
                            ,"nameDelegate"=> isset($_POST['nameDelegate'])? $_POST['nameDelegate'] : "" 
                            ,"service"=> isset($_POST['service'])? $_POST['service'] : "" 
                            ,"serviceId"=> isset($_POST['serviceID'])? $_POST['serviceID'] : "" 
                            ,"relationOption"=> isset($_POST['relationOptions'])? $_POST['relationOptions'] : "" 
                            ,"relationOption"=> isset($_POST['relationOptions'])? $_POST['relationOptions'] : "" 

                        );
        

        $ParamArr = array(   
                            "feedTitle"=> $_POST['feedtype'].' : '.$_POST['tell'].' '.$_POST['name']
                            ,"feedType"=> $_POST['feedtype']
                            ,"feedSubType"=> $_POST['feedsubtype']
                            ,"feedBody"=> json_encode($Jsonbody)
                        );
        
        $payload = json_encode( $ParamArr);

        // print_r ($payload);

        // $ParamArr = array( "data"=> "FIK TEST" );
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
}


 ?>