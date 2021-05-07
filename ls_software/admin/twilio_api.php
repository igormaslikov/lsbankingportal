<?php

$to="+18186109673";
$from="+18886951203";
$msg="Hi Testing From Twilio SMS";
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.twilio.com/2010-04-01/Accounts/AC5e18b85197db6e32d1995bf3b40e045b/Messages.json",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "From=$from&To=$to&Body=$msg",
  CURLOPT_HTTPHEADER => array(
    "authorization: Basic QUM1ZTE4Yjg1MTk3ZGI2ZTMyZDE5OTViZjNiNDBlMDQ1YjpiOGI0NmI0Njg5MDQ3OWJjZjI1YTlmYjIwNjdlMWMxZQ==",
    "cache-control: no-cache",
    "content-type: application/x-www-form-urlencoded",
    "postman-token: 10b2dea7-4936-ce5b-76b4-58bf44fe5b7f"
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


?>