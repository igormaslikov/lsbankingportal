<?php


$curl = curl_init();
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
  CURLOPT_POSTFIELDS => "{\r\n\"sms_text\": \"Hi Asim\",\r\n\"sender_id\": \"76054\",\r\n\"source\": \"18335210068\",\r\n\"mobile_number\": \"+923054564195\"\r\n\r\n}",
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
    
//***************************************************************************** Chat Plugin *************************************
 $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sms-magic.com/v1/sms/send",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\r\n\"sms_text\": \"$this->text\",\r\n\"sender_id\": \"76054\",\r\n\"mobile_number\": \"$mobile_number\"\r\n\r\n}",
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
  //echo $response;
}     


?>