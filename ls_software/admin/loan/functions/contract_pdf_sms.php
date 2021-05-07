<?php 

include_once '../../dbconnect.php';
include_once '../../dbconfig.php';
include_once '../../functions.php';
date_default_timezone_set('America/Los_Angeles');
$user_id= $_GET['user_id'];
$loan_id = $_GET['loan_id'];
$user_fnd_id = $_GET['user_fnd_id'];
//$loan_id = $_GET['loan_id'];
$phone_number = $_GET['phone_number'];
$email_key = $_GET['email_key'];
$url = "https://lsbankingportal.com/signature_customer/completed/index.php?id=".$email_key;
$message = "Hello, Please sign your loan contract by clicking on this url : ".$url;


send_sms($phone_number,$message);


 /**$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sms-magic.com/v1/sms/send",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTPPROXYTUNNEL => TRUE,
  CURLOPT_SSL_VERIFYPEER => FALSE,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\r\n\"sms_text\": \"$message\",\r\n\"sender_id\": \"76054\",\r\n\"source\": \"18335210068\",\r\n\"mobile_number\": \"$phone_number\"\r\n\r\n}",
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
  echo "Response Error : cURL Error #:" . $err;
} else {
  echo "Response : ".$response."<hr>";
}     
**/

 
    $date_update= date('Y-m-d H:i:s');
    $query_insert_activity = "Insert into application_status_updates (application_id,loan_create_id,user_id,status,creation_date) Values ('$user_fnd_id','$loan_id','$user_id','Contract Link Sent via SMS','$date_update')";
    mysqli_query ($con , $query_insert_activity);
?>


<script>

  alert("Contract Link Sent to Customer via SMS");
close(); 
</script>

