<?php
sleep(4); 
$email=$_GET['email-132'];

include_once 'dbconnect.php';
include_once 'dbconfig.php';

// Connect to MySQL Database
$con = new mysqli($host, $user, $password, $database);
$curl = curl_init();

curl_setopt_array($curl, array(
 CURLOPT_URL => "https://integration.decisionlogic.com/integration-v2.asmx",
 CURLOPT_RETURNTRANSFER => true,
 CURLOPT_ENCODING => "",
 CURLOPT_MAXREDIRS => 10,
 CURLOPT_TIMEOUT => 30,
 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
 CURLOPT_CUSTOMREQUEST => "POST",
 CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">\r\n  <soap:Body>\r\n    <CreateRequest4 xmlns=\"https://integration.decisionlogic.com\">\r\n       <serviceKey>DN2YYREQ9DPQ</serviceKey>\r\n\t\t<siteUserGuid>18b362a9-96d7-4a34-b510-328606d796a1</siteUserGuid>\r\n\t\t<profileGuid>759dea8e-c494-41e9-8ad0-b7ad8afea899</profileGuid>\r\n      <customerId>string1</customerId>\r\n      <firstName></firstName>\r\n      <lastName></lastName>\r\n      <accountNumber></accountNumber>\r\n      <routingNumber></routingNumber>\r\n      <contentServiceId>0</contentServiceId>\r\n      <emailAddress>$email</emailAddress>\r\n    </CreateRequest4>\r\n  </soap:Body>\r\n</soap:Envelope>\r\n   ",
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
}$dom = new DOMDocument();
$dom->loadXML($response);
$hotels = $dom->getElementsByTagName('CreateRequest4Response');

foreach ($hotels as $hotel) {
   $name = $hotel->getElementsByTagName('CreateRequest4Result')->item(0)->nodeValue;
   
}
$date = date("Y/m/d");
include('ls_software/API_files/Lspayday_API/dbconnect.php');
include('ls_software/API_files/Lspayday_API/dbconfig.php');
mysqli_query($con,"Insert into decision_login_codes (code,email,date) Values ('$name','$email','$date')");
$date = date('Y-m-d H:i:s');
// To check whether user is declined in 90 day period
$date_decline = date('Y-m-d', strtotime('-90 days'));
$query_check = "select * from fnd_user_profile where ( (email = '$email' AND email !='') ) AND (application_status = 'Declined' OR application_status = 'Rejected By Customer') AND (creation_date BETWEEN '$date_decline'AND '$date')";
$sql_check=mysqli_query($con, "$query_check"); 
  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($sql_check);
//  echo "Row Count is : " . $rowcount. "<br>";
if ($rowcount>0){
	//echo "record exists";
	$name = "AAAAAAA";
}
$url="https://lspaydayloans.com/verification?code=".$name;
header("Location:$url");