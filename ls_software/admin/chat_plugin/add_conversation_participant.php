<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://conversations.twilio.com/v1/Conversations/CH3c092b2705c846faac493d0b7008830a/Participants",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "MessagingBinding.Address=+18186109673&MessagingBinding.ProxyAddress=+18886951203",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Basic QUM1ZTE4Yjg1MTk3ZGI2ZTMyZDE5OTViZjNiNDBlMDQ1YjpiOGI0NmI0Njg5MDQ3OWJjZjI1YTlmYjIwNjdlMWMxZQ==",
    "Content-Type: application/x-www-form-urlencoded"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

?>