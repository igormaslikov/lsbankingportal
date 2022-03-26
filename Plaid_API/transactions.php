<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://development.plaid.com/link/token/create",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\n\t\"client_id\": \"5f606a14aaddb00011248436\",\n\t\"secret\": \"892e84129259b3f1237bd4f778e27e\",\n  \"client_name\": \"Optima\",\n  \"country_codes\": [\"US\"],\n  \"language\": \"en\",\n  \"user\": {\n    \"client_user_id\": \"unique_user_id\"\n  },\n  \"products\": [\"auth\", \"transactions\"]\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;
$data=json_decode($response,true);
$link_token=$data['link_token'];

echo "Link Token: $link_token<hr><br>";

//*****************************************************************************


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://development.plaid.com/transactions/get",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\n  \"client_id\": \"5f606a14aaddb00011248436\",\n  \"secret\": \"892e84129259b3f1237bd4f778e27e\",\n  \"access_token\": \"$link_token\",\n  \"start_date\": \"2017-01-01\",\n  \"end_date\": \"2019-05-10\" \n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
