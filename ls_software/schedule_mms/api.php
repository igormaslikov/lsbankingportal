<?php

date_default_timezone_set('America/Los_Angeles');


$sql_sms=mysqli_query($con, "select * from schedule_mms where status='0' LIMIT 30"); 

while($row_sms = mysqli_fetch_array($sql_sms)) {
$sms_id = $row_sms['id'];
$phone_number="+1".$row_sms['phone'];
$message=$row_sms['message'];
$time_db = $row_sms['time'];
$date_db = $row_sms['date'];
$img_url = $row_sms['img_url'];

$now_time=date("H:i");
$now_date = date("m-d-Y");

//$start = $time_db;

if (($time_db <= $now_time  && $date_db <= $now_date)) 

{ 

//echo $message. " <br> " ;

// API to send Code

 $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sms-magic.com/v1/sms/send",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_HTTPPROXYTUNNEL => TRUE,
  CURLOPT_SSL_VERIFYPEER => FALSE,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"sms_text\":\"$message\", \"mobile_number\": \"$phone_number\", \"sender_id\": \"76054\", \"mms_url_list\": [\"$img_url\"]}",
  CURLOPT_HTTPHEADER => array(
    "apikey: 2b731c8cdf8713eae8e30ae382eb43a3",
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 39676d49-3e38-2535-44e6-3a481f4b0808"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response."<hr>";
}     


mysqli_query($con, "UPDATE schedule_mms SET status ='1'  where id = '$sms_id'");



// API to send code END
}
else {
echo  "<br>nothing<br>";
}

}

echo $now_time. "<br>".$now_date; 
?>