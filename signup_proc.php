
<?php
include("includes/classes/user.php");
require_once("includes/fedex/fedex-common.php");

//Checks to see if the user ID session variable is set. If it is, then they're logged in and get redirected to index.php
if(isset($_SESSION["SESS_MEMBER_ID"])){
    header("location: index.php");
}
if(isset($_POST["button"])){
$u = new User(null, strtolower($_POST["username"]), password_hash($_POST["password"], PASSWORD_DEFAULT), $_POST["firstname"], $_POST["lastname"], $_POST["address"], $_POST["province"], $_POST["postalCode"], $_POST["phone"], $_POST["email"], null, null, $_POST["location"], $_POST["desc"], $_POST["url"]);

CheckPostalCode($u->postalCode, $u->province);
User::UsernameExists($u);
}
function CheckPostalCode($postalCode, $province){
    $path_to_wsdl = "includes/Fedex/wsdl/CountryService/CountryService_v5.wsdl";
    ini_set("soap.wsdl_cache_enabled", 0);
    $client = new SoapClient($path_to_wsdl, array('trace' => 1));
    
    $request['WebAuthenticationDetail'] = array(
	'ParentCredential' => array(
		'Key' => getProperty('parentkey'), 
		'Password' => getProperty('parentpassword')
	),
	'UserCredential' => array(
		'Key' => getProperty('key'), 
		'Password' => getProperty('password')
	)
    );

$request['ClientDetail'] = array(
	'AccountNumber' => getProperty('shipaccount'), 
	'MeterNumber' => getProperty('meter')
);
$request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Validate Postal Code Request using PHP ***');
$request['Version'] = array(
	'ServiceId' => 'cnty', 
	'Major' => '5', 
	'Intermediate' => '0', 
	'Minor' => '1'
);

$request['Address'] = array(
	'PostalCode' => $postalCode,
	'CountryCode' => 'CA'
);

$request['CarrierCode'] = 'FDXE';


try {
    if(setEndpoint('changeEndpoint')){
	$newLocation = $client->__setLocation(setEndpoint('endpoint'));
    }
    $response = $client -> validatePostal($request); 
        if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){  	
            printSuccess($client, $response);
            printPostalDetails($response->PostalDetail, "", $province);
            //loop through array that is returned in the reply
            echo "<table>\n";
            printPostalDetails($response -> PostalDetail, "", $province);
            echo "</table>\n";
	}
        else{
            printError($client, $response);
        } 
    
    writeToLog($client);    // Write to log file   
} 
catch (SoapFault $exception) {
   printFault($exception, $client);        
}

}
function printPostalDetails($details, $spacer, $province){
	foreach($details as $key => $value){
		if($key =="StateOrProvinceCode"){
                    if($value == $province){
                        header("Location: login.php");
                    }
                    else{
                        header("Location:signup.php?msg=Province does not match postal code");
                    }
                if(is_arry($value) || is_object($value)){
                    $newSpacer = $spacer. '&nbsp;&nbsp;&nbsp;&nbsp;';
    		echo '<tr><td>'. $spacer . $key.'</td><td>&nbsp;</td></tr>';
    		printPostalDetails($value, $newSpacer);
                }
        	
                }
    }
}
?>