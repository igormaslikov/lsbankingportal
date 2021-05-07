<?php

include('../dbconnect.php');
include('../dbconfig.php');


$query = "select * from decision_login_codes where status='5' AND loan_amount_check !='1' order by id desc Limit 20 ";
//$query = "select * from decision_login_codes where  id = 564";

//echo $query . "<br>";
$sql=mysqli_query($con, "$query"); 

  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($sql);
//  echo "Row Count is : " . $rowcount. "<br>";
if ($rowcount<1){
	
//mysqli_query($con,"UPDATE decision_login_codes SET status ='0' where status = '1'");
}
while($row = mysqli_fetch_array($sql)) {
    
$email = $row['email'];
$code = $row['code'];
$code_id = $row['id'];
    
$query_app_id = "select * from fnd_user_profile where email = '$email' ";
//$query = "select * from decision_login_codes where  id = 564";

//echo $query . "<br>";
$sql_app_id=mysqli_query($con, $query_app_id); 

while($row_app_id = mysqli_fetch_array($sql_app_id)) {    
    $application_id = $row_app_id['user_fnd_id'];
}

// API CODE


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
//echo $response;
}



$dom = new DOMDocument();
$dom->loadXML($response);
$hotels = $dom->getElementsByTagName('ReportDetail5');
$payroll = '';
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
foreach ($hotels as $hotel) {
    $payroll = $hotel->getElementsByTagName('TotalAmount')->item(0)->nodeValue;
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
	break;
   
}


// API CODE END

if($payroll>7000 && $DL_average_balance>300 && $DL_available_balance>-150 && $DL_overdraft_ov < 4 ) { 
    echo "$250 Loan Amount approved for code : "; 
    mysqli_query($con, "UPDATE `fnd_user_profile` SET `amount_of_loan`='255' WHERE `email` = '$email'");
    mysqli_query($con, "UPDATE `decision_login_codes` SET `loan_amount_check`='1' WHERE `id` = '$code_id'");
    $date_update= date('Y-m-d H:i:s');
    $query_insert_activity = "Insert into application_status_updates (application_id, status, creation_date) Values ($application_id, ' Auto Update : LOAN AMOUNT UPDATED TO 255', '$date_update')";
    mysqli_query ($con , $query_insert_activity);
    
}



else if($payroll>4000 && $DL_average_balance>200 && $DL_available_balance>-100 && $DL_overdraft_ov < 4 ) { 
    echo "$200 Loan Amount approved for code : ";
    
    mysqli_query($con, "UPDATE `fnd_user_profile` SET `amount_of_loan`='200' WHERE `email` = '$email'");
    mysqli_query($con, "UPDATE `decision_login_codes` SET `loan_amount_check`='1' WHERE `id` = '$code_id'");
    $date_update= date('Y-m-d H:i:s');
    $query_insert_activity = "Insert into application_status_updates (application_id, status, creation_date) Values ($application_id, ' Auto Update : LOAN AMOUNT UPDATED TO 200', '$date_update')";
    mysqli_query ($con , $query_insert_activity);
    
}


else if($DL_deposits_credit>8000 && $DL_average_balance>150 && $DL_available_balance>-75 && $DL_overdraft_ov < 5 ) { 
    echo "$150 Loan Amount approved for code : ";
    
    mysqli_query($con, "UPDATE `fnd_user_profile` SET `amount_of_loan`='150' WHERE `email` = '$email'");
    
    mysqli_query($con, "UPDATE `decision_login_codes` SET `loan_amount_check`='1' WHERE `id` = '$code_id'");
    $date_update= date('Y-m-d H:i:s');
    $query_insert_activity = "Insert into application_status_updates (application_id, status, creation_date) Values ($application_id, ' Auto Update : LOAN AMOUNT UPDATED TO 150', '$date_update')";
    mysqli_query ($con , $query_insert_activity);
    
}



else if($DL_deposits_credit>6000 && $DL_average_balance>100 && $DL_available_balance>-50 && $DL_overdraft_ov < 6) { 
    echo "$100 Loan Amount approved for code : ";
    
    mysqli_query($con, "UPDATE `fnd_user_profile` SET `amount_of_loan`='100' WHERE `email` = '$email'");
    
    mysqli_query($con, "UPDATE `decision_login_codes` SET `loan_amount_check`='1' WHERE `id` = '$code_id'");
    $date_update= date('Y-m-d H:i:s');
    $query_insert_activity = "Insert into application_status_updates (application_id, status, creation_date) Values ($application_id, ' Auto Update : LOAN AMOUNT UPDATED TO 100', '$date_update')";
    mysqli_query ($con , $query_insert_activity);
    
}


else if( $DL_deposits_credit>4000 && $DL_average_balance>50 && $DL_available_balance>0 && $DL_overdraft_ov < 7 ) { 
    echo "$250 Loan Amount approved for code : ";
    
    mysqli_query($con, "UPDATE `fnd_user_profile` SET `amount_of_loan`='50' WHERE `email` = '$email'");
    
    mysqli_query($con, "UPDATE `decision_login_codes` SET `loan_amount_check`='1' WHERE `id` = '$code_id'");
    $date_update= date('Y-m-d H:i:s');
    $query_insert_activity = "Insert into application_status_updates (application_id, status, creation_date) Values ($application_id, ' Auto Update : LOAN AMOUNT UPDATED TO 50', '$date_update')";
    mysqli_query ($con , $query_insert_activity);
    
}

else { 
    echo "Not Approved "; 
    
    
    mysqli_query($con, "UPDATE `fnd_user_profile` SET `amount_of_loan`='Needs Review' WHERE `email` = '$email'");
    
    mysqli_query($con, "UPDATE `decision_login_codes` SET `loan_amount_check`='1' WHERE `id` = '$code_id'");
    $date_update= date('Y-m-d H:i:s');
    $query_insert_activity = "Insert into application_status_updates (application_id, status, creation_date) Values ($application_id, ' Auto Update : LOAN AMOUNT UPDATED TO (Needs Review)', '$date_update')";
    mysqli_query ($con , $query_insert_activity);
    
}

echo $code. " OV : ".$DL_overdraft_ov." | Payroll : ".$payroll." | Deposits : ".$DL_deposits_credit." | Average Balannce : ".$DL_average_balance. " | Available Balance : ".$DL_available_balance. " ====> ".$application_id ." <hr>";
}

?>