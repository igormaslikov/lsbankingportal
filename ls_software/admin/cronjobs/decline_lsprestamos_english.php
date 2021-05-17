<?php
for ($k = 0 ; $k < 10; $k++){
include($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');

include('../functions.php');


//$email=$_GET['email-132'];
$last_date1 = date('Y-m-d', strtotime('-7 days'));
$last_date2 = date('Y-m-d', strtotime('-6 days'));
$last_date3 = date('Y-m-d', strtotime('-5 days'));
$last_date4 = date('Y-m-d', strtotime('-4 days'));
$last_date5 = date('Y-m-d', strtotime('-3 days'));
$last_date6 = date('Y-m-d', strtotime('-2 days'));
$last_date7 = date('Y-m-d', strtotime('-1 days'));
$last_date11 = date('Y/m/d', strtotime('-7 days'));
$last_date22 = date('Y/m/d', strtotime('-6 days'));
$last_date33 = date('Y/m/d', strtotime('-5 days'));
$last_date44 = date('Y/m/d', strtotime('-4 days'));
$last_date55 = date('Y/m/d', strtotime('-3 days'));
$last_date66 = date('Y/m/d', strtotime('-2 days'));
$last_date77 = date('Y/m/d', strtotime('-1 days'));
echo $last_date; 
$date =  date('Y-m-d');
$datee =  date('Y/m/d');
$query = "select * from decision_login_codes where status = '0' AND (date = '$datee' OR date = '$date' OR date = '$last_date1' OR date = '$last_date2' OR date = '$last_date3' OR date = '$last_date4' OR date = '$last_date5' OR date = '$last_date6' OR date = '$last_date7' OR date = '$date' OR date = '$last_date11' OR date = '$last_date22' OR date = '$last_date33' OR date = '$last_date44' OR date = '$last_date55' OR date = '$last_date66' OR date = '$last_date77') Limit 1";
//$query = "select * from decision_login_codes where  id = 564";

echo $query . "<br>";
$sql=mysqli_query($con, "$query"); 

  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($sql);
//  echo "Row Count is : " . $rowcount. "<br>";
if ($rowcount<1){
	
mysqli_query($con,"UPDATE decision_login_codes SET status ='0' where status = '1'");
}
while($row = mysqli_fetch_array($sql)) {
    
$email = $row['email'];
$code =$row['code'];
$curl = curl_init();
echo $code;
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

echo "Email is : ". $email;
$response_str = (string) $response;
$name =  substr($response_str, 357, 1);
echo "<hr>".$name."<hr>";

if($name == 3){
$url="https://lspaydayloans.com/verification?code=".$name;
echo $url;
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
//echo $response;
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
	break;
   
}
	$query_name = "select * from fnd_user_profile where email = '$email'";
$sql_name=mysqli_query($con, "$query_name"); 
$customer_name = '';
while($row_name = mysqli_fetch_array($sql_name)) {
$customer_name = $row_name['first_name'] . " " .$row_name['last_name'] ;
$customer_email = $row_name['email'];
$phone = $row_name['mobile_number'];
$website_DL_check = $row_name['website'];
}


 //echo 'Av Bal : ' .$DL_available_balance ."<hr>";
 
 /// ***** AUTO DECLINED lspaydayloans START
 //$DL_overdraft_ov = 11;
if (($DL_available_balance<-200) || ($DL_current_balance<-200) || ($DL_overdraft_ov>7) || ($DL_average_balance<50) || ($DL_avg_balance_last_month<50)){

if ($website_DL_check == 'lsbanking_pdl'){
    
    

	mysqli_query($con,"UPDATE fnd_user_profile SET application_status ='Declined' where email = '$email'");
	echo "Declined Application ";
	$query_name = "select * from fnd_user_profile where email = '$email'";
$sql_name=mysqli_query($con, "$query_name"); 
$customer_name = '';
while($row_name = mysqli_fetch_array($sql_name)) {
$customer_name = $row_name['first_name'] . " " .$row_name['last_name'] ;
$customer_email = $row_name['email'];
$phone = $row_name['mobile_number'];
$user_fnd_id = $row_name['user_fnd_id'];
}
	 $message = "Hola ".$customer_name." ".",Gracias por aplicar con LS Financing Inc, lamentamos informarle que su aplicación ha sido declinada, usted no ha cumplido con los criterios correpondientes para extenderle un préstamo en estos momentos. Puede volver a aplicar después de 90 días.";
//$to_email = "umersharif905@yahoo.com";
$to_email = $customer_email;
$subject = 'LS BANKING DECLINED';
$headers = 'From: info@lspaydayloans.com';
//mail($to_email,$subject,$message,$headers);

send_email_notification($to_email,$subject,$message);
//$phone = "+923224951307";
  send_sms($phone,$message);


	

$date= date('Y-m-d H:i:s');

echo "<hr> FND ID : ".$user_fnd_id. " ------ ". $date ; 
$query_update_status= "INSERT INTO `application_status_updates`( `application_id`,  `status`, `creation_date`) VALUES ('$user_fnd_id','AUTOMATIC DECLINED - LS PAYDAYLOANS CRITERIA','$date')";
mysqli_query($con, $query_update_status); 



	
}} else {
	echo "Not declined";
}


 /// ***** AUTO DECLINED lspaydayloans END 
 
 
  
 /// ***** AUTO DECLINED lsprestamos START
 //$DL_overdraft_ov = 11;
if (($DL_available_balance<-200) || ($DL_current_balance<-200) || ($DL_overdraft_ov>7) || ($DL_average_balance<50) || ($DL_avg_balance_last_month<50)){

if ($website_DL_check == 'lsbanking_pdl'){
    
    

	mysqli_query($con,"UPDATE fnd_user_profile SET application_status ='Declined' where email = '$email'");
	echo "Declined Application ";
	$query_name = "select * from fnd_user_profile where email = '$email'";
$sql_name=mysqli_query($con, "$query_name"); 
$customer_name = '';
while($row_name = mysqli_fetch_array($sql_name)) {
$customer_name = $row_name['first_name'] . " " .$row_name['last_name'] ;
$customer_email = $row_name['email'];
$phone = $row_name['mobile_number'];
$user_fnd_id = $row_name['user_fnd_id'];
}
	 $message = "Hola ".$customer_name." ".",Gracias por aplicar con LS Financing Inc, lamentamos informarle que su aplicación ha sido declinada, usted no ha cumplido con los criterios correpondientes para extenderle un préstamo en estos momentos. Puede volver a aplicar después de 90 días.";
//$to_email = "umersharif905@yahoo.com";
$to_email = $customer_email;
$subject = 'LS BANKING DECLINED';
$headers = 'From: info@lspaydayloans.com';
//mail($to_email,$subject,$message,$headers);

send_email_notification($to_email,$subject,$message);

//$phone = "+923224951307";
  send_sms($phone,$message);
	

$date= date('Y-m-d H:i:s');

echo "<hr> FND ID : ".$user_fnd_id. " ------ ". $date ; 
$query_update_status= "INSERT INTO `application_status_updates`( `application_id`,  `status`, `creation_date`) VALUES ('$user_fnd_id','AUTOMATIC DECLINED - LS PAYDAYLOANS CRITERIA','$date')";
mysqli_query($con, $query_update_status); 



	
}} else {
	echo "Not declined";
}


 /// ***** AUTO DECLINED lsprestamos END 
 
 
 
// API CODE TO CHECK DL Report END 
mysqli_query($con,"UPDATE decision_login_codes SET status ='5' where code = '$code'");
mysqli_query($con,"UPDATE fnd_user_profile SET decision_logic_status ='1' where email = '$email'");

// For LSPAYDAYLOANS autochange of status start
mysqli_query($con,"UPDATE fnd_user_profile SET application_status ='Approved Payday Loan' where email = '$email' AND application_status!='Declined' AND website = 'lsbanking_pdl'");

    $date_update_nd= date('Y-m-d H:i:s');
$query_insert_activity_nd = "Insert into application_status_updates (application_id, status, creation_date) Values ($user_fnd_id, ' Automatic Status Changed : Approved PayDay Loan ', '$date_update_nd')";
    mysqli_query ($con , $query_insert_activity_nd);

// For LSPAYDAYLOANS autochange of status end


// Mail Sending
$query_name = "select * from fnd_user_profile where email = '$email'";
$sql_name=mysqli_query($con, "$query_name"); 
$customer_name = '';
while($row_name = mysqli_fetch_array($sql_name)) {
$customer_name = $row_name['first_name'] . " " .$row_name['last_name'] ;
}

$to_email = "Kenneth@lsbanking.com";
$subject = 'Decicion Logic Verification Confirmation : ' . $email;
$message = 'Your Client ('.$customer_name.') with Email Address : '. $email . ' has been verified from Decision Logic.';
$headers = 'From: info@lspaydayloans.com';
//mail($to_email,$subject,$message,$headers);
admin_leads_email_notification($subject,$message); 
// To the Customer 


$to_email = $email;
$subject = 'LS BANKING DOCUMENTS REQUIRED (' . $email . ')';
$message = 'Hello '.$customer_name.',
Your  Email Address : '. $email . ' has been verified from Decision Logic. 
Please Follow the link (http://lsbankingportal.com/ls_software/dl_client_files/index.php?email='.$email.'&code='.$code.') to submit your documents (Photo ID, Bank Card Front/Back) to LS BANKING';
$headers = 'From: info@lspaydayloans.com';
//mail($to_email,$subject,$message,$headers);

send_email_notification($to_email,$subject,$message);


// Mail Sending 
}
else {
echo "not verified";
mysqli_query($con,"UPDATE decision_login_codes SET status ='1' where code = '$code'");
}

}
}
//header("Location:$url");