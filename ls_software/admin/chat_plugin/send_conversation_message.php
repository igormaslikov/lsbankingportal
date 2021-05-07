<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://conversations.twilio.com/v1/Conversations/CH3c092b2705c846faac493d0b7008830a/Messages",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "participant_sid=CH3c092b2705c846faac493d0b7008830a&Body=Hi%20Lior%2CTesting%20from%20twilio%20conversation.please%20reply%20to%20this%20message.%20Also%20share%20screenshot%20in%20group.%20by%20Asim",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Basic QUM1ZTE4Yjg1MTk3ZGI2ZTMyZDE5OTViZjNiNDBlMDQ1YjpiOGI0NmI0Njg5MDQ3OWJjZjI1YTlmYjIwNjdlMWMxZQ==",
    "Content-Type: application/x-www-form-urlencoded"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
?>