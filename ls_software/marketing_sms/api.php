<?php

include_once 'dbconfig.php';
date_default_timezone_set('America/Los_Angeles');

//echo "Created timme is " . date("H:i"). "<br>";
$now=date("H:i");
$start = "07:01";
$end = "18:59";
//$now = date('H');


if (($now >= $start  && $now <= $end)) 

{ 
    // echo "time in between";

$sql_sms=mysqli_query($con, "select * from marketing_sms where status='0' LIMIT 2"); 

while($row_sms = mysqli_fetch_array($sql_sms)) {

$phone_number=$row_sms['phone_number'];
$message=$row_sms['message'];
$sms_id = $row_sms['sms_id'];
//echo "number is:".$message."<br>";

$curl = curl_init();

curl_setopt_array($curl, array(
 CURLOPT_URL => "https://api.twilio.com/2010-04-01/Accounts/ACf81a1660d5933a77a5db881fbbadadd8/Messages.json",
 CURLOPT_RETURNTRANSFER => true,
 CURLOPT_ENCODING => "",
 CURLOPT_MAXREDIRS => 10,
 CURLOPT_TIMEOUT => 30,
 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
 CURLOPT_CUSTOMREQUEST => "POST",
 CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"To\"\r\n\r\n.$phone_number.\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"From\"\r\n\r\n(213) 340-0716\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"Body\"\r\n\r\n.$message.\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
 CURLOPT_HTTPHEADER => array(
    "authorization: Basic QUNmODFhMTY2MGQ1OTMzYTc3YTVkYjg4MWZiYmFkYWRkODo0MzM0M2FkZTVhNjE2ZmJiYWMxYzg0YzkyODNlNDExZA==",
   "cache-control: no-cache",
   "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
 ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
 echo "cURL Error #:" . $err;
} else {
 echo $response;
}

$data=json_decode($response,true);

$date_created=$data['date_created'];
$api_status=$data['status'];
if($api_status=='queued')
{
//echo "Created date: $date_created<br>";

}

mysqli_query($con, "UPDATE marketing_sms SET status ='1'  where sms_id = '$sms_id'");
}

}

else{
    
  //echo  "No Time";
}
?>