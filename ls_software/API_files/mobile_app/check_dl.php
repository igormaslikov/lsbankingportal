<?php
//include($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');

//include('../functions.php');

$email = $_GET['email'];
$code =$_GET['code'];
    
    	$query_name = "SELECT * FROM `decision_login_codes` WHERE `code` = '$code'";
    	$status_dl = 0;
        $sql_name=mysqli_query($con, "$query_name"); 
        $customer_name = '';
        while($row_name = mysqli_fetch_array($sql_name)) {
        $status_dl = $row_name['status']  ;
        }

    
$curl = curl_init();
//echo $code;
curl_setopt_array($curl, array(
 CURLOPT_URL => "https://integration.decisionlogic.com/integration-v2.asmx",
 CURLOPT_RETURNTRANSFER => true,
 CURLOPT_ENCODING => "",
 CURLOPT_MAXREDIRS => 10,
 CURLOPT_TIMEOUT => 30,
 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
 CURLOPT_CUSTOMREQUEST => "POST",
 CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">\r\n  <soap:Body>\r\n    <GetRequestStatus3 xmlns=\"https://integration.decisionlogic.com\">\r\n       <serviceKey>DN2YYREQ9DPQ</serviceKey>     <requestCode>$code</requestCode>\r\n\t\t<siteUserGuid>18b362a9-96d7-4a34-b510-328606d796a1</siteUserGuid>\r\n\t\t<profileGuid>759dea8e-c494-41e9-8ad0-b7ad8afea899</profileGuid>\r\n      <customerId>string1</customerId>\r\n      <firstName></firstName>\r\n      <lastName></lastName>\r\n      <accountNumber></accountNumber>\r\n      <routingNumber></routingNumber>\r\n      <contentServiceId>0</contentServiceId>\r\n      <emailAddress>$email</emailAddress>\r\n    </GetRequestStatus3>\r\n  </soap:Body>\r\n</soap:Envelope>\r\n   ",
 CURLOPT_HTTPHEADER => array(
   "cache-control: no-cache",
   "content-type: text/xml"
 ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
 echo "cURL Error #:" . $err;
} else {
//echo $response;
}

//echo "Email is : ". $email;
$response_str = (string) $response;
$name =  substr($response_str, 357, 1);
//echo "<hr>".$name."<hr>";

if($name == 3){
//$url="https://lspaydayloans.com/verification?code=".$name;
     echo '{ "status" : "Verified",';
// API CODE TO CHECK DL Report


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://integration.decisionlogic.com/integration-v2.asmx",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">\r\n  <soap:Body>\r\n    <GetMultipleReportDetailsFromRequestCode7 xmlns=\"https://integration.decisionlogic.com\">\r\n      <serviceKey>DN2YYREQ9DPQ</serviceKey>\r\n      <requestCode>$code</requestCode>\r\n    </GetMultipleReportDetailsFromRequestCode7>\r\n  </soap:Body>\r\n</soap:Envelope>",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: text/xml; charset=utf-8",
    "host: integration.decisionlogic.com",
    "postman-token: 656d6424-254f-0521-fabb-3e0fe463fc5d",
    "soapaction: https://integration.decisionlogic.com/GetMultipleReportDetailsFromRequestCode7"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
//echo "hello ".$response;
}



$dom = new DOMDocument();
$dom->loadXML($response);
$hotels = $dom->getElementsByTagName('ReportDetail5');
$DL_available_balance = '';
	$DL_totalamount = '';
	$DL_totalamount_loan = '';
	$DL_as_date = '';
    $DL_current_balance = '';
	$DL_average_balance = '';
	
	$DL_deposits_credit = '';
    $DL_avg_balance_last_month = '';
	
	$DL_withdrawals = '';
	$DL_overdraft_ov = '';
	$payrol = '';
foreach ($hotels as $hotel) {
    $DL_available_balance = $hotel->getElementsByTagName('AvailableBalance')->item(0)->nodeValue;
	$DL_totalamount = $hotel->getElementsByTagName('TotalAmount')->item(0)->nodeValue;
	$DL_totalamount_loan = $hotel->getElementsByTagName('TotalAmount')->item(3)->nodeValue;
	$DL_as_date = $hotel->getElementsByTagName('AsOfDate')->item(0)->nodeValue;
    $DL_current_balance = $hotel->getElementsByTagName('CurrentBalance')->item(0)->nodeValue;
	$DL_average_balance = $hotel->getElementsByTagName('AverageBalance')->item(0)->nodeValue;
	
	$DL_deposits_credit = $hotel->getElementsByTagName('TotalAmount')->item(0)->nodeValue;
    $DL_avg_balance_last_month = $hotel->getElementsByTagName('AverageBalanceRecent')->item(0)->nodeValue;
	
	$DL_withdrawals = $hotel->getElementsByTagName('TotalDebits')->item(0)->nodeValue;
	$DL_overdraft_ov = $hotel->getElementsByTagName('TotalCount')->item(4)->nodeValue;
	$overdraft = "";
	
	$payroll = $hotel->getElementsByTagName('TransactionAnalysisSummary5');
	foreach($payroll as $payrol_element){
	        if($payrol_element->getElementsByTagName('TypeName')->item(0)->nodeValue == 'Payroll'){
	    	$payrol = $payrol_element->getElementsByTagName('TotalAmount')->item(0)->nodeValue;
	        }
	  
	}
	
	$payroll = $hotel->getElementsByTagName('TransactionAnalysisSummary5');
	foreach($payroll as $payrol_element){
	        if($payrol_element->getElementsByTagName('TypeName')->item(0)->nodeValue == 'Overdraft'){
	    	$overdraft = $payrol_element->getElementsByTagName('TotalCount')->item(0)->nodeValue;
	        }
	  
	}
	
	$payroll = $hotel->getElementsByTagName('TransactionAnalysisSummary5');
	foreach($payroll as $payrol_element){
	        if($payrol_element->getElementsByTagName('TypeName')->item(0)->nodeValue == 'Deposit'){
	    	$deposits = $payrol_element->getElementsByTagName('TotalAmount')->item(0)->nodeValue;
	        }
	  
	}
	
	
	break;
   
}


	$query_name = "select * from fnd_user_profile where email = '$email'";
$sql_name=mysqli_query($con, "$query_name"); 
$customer_name = '';
while($row_name = mysqli_fetch_array($sql_name)) {
$customer_name = $row_name['first_name'] . " " .$row_name['last_name'];
$customer_email = $row_name['email'];
$phone = $row_name['mobile_number'];
$website_DL_check = $row_name['website'];
}


// echo 'Av Bal : ' .$DL_available_balance ."<hr>";
// echo "$payrol - $DL_available_balance - $DL_average_balance - $overdraft - $deposits";
$json_array_loans = '"loans":[';
// 255$ start 
if($payrol>6999 && $DL_average_balance>300 && $DL_available_balance>-150 && $overdraft<3){
    $json_array_loans .= '255.00,';
}


if($payrol>3999 && $DL_average_balance>200 && $DL_available_balance>-100 && $overdraft<4){
    $json_array_loans .= '200.00,';
}


if($deposits>8000 && $DL_average_balance>150 && $DL_available_balance>-75 && $overdraft<5){
   $json_array_loans .= '150.00,';
}


if($deposits>6000 && $DL_average_balance>100 && $DL_available_balance>-50 && $overdraft<6){
    $json_array_loans .= '100,';
}


if($deposits>4000 && $DL_average_balance>50 && $DL_available_balance>0 && $overdraft<7){
   $json_array_loans .= '50.00,';
}


if(($payrol>-4000 || $payrol>-4000) && $DL_average_balance>0 && $DL_available_balance>0 && $overdraft<7){
    $json_array_loans .= '25.00,';
}

$json_array_loans = rtrim($json_array_loans,",");
$json_array_loans .= "]}";
echo $json_array_loans;
// 255$ End
 
// API CODE TO CHECK DL Report END 
mysqli_query($con,"UPDATE decision_login_codes SET status ='5' where code = '$code'");
mysqli_query($con,"UPDATE fnd_user_profile SET decision_logic_status ='1',dl_code='$code' where email = '$email'");

}
else {

     echo '{ "status" : "Not Verified"}';
//mysqli_query($con,"UPDATE decision_login_codes SET status ='1' where code = '$code'");
}



//header("Location:$url");