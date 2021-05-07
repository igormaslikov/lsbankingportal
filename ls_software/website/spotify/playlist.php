<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.spotify.com/v1/albums/0sNOF9WDwhWunNAHPD3Baj",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "authorization: Bearer BQDNpatmUkEYYwx231iSiO4HzENmZbtmhtjwJzvb8T9iu2UxHO3Kivs8CqykbPPkuGn07H69xsC_El1mYVxO3c4pFKuX9fdqc-jQtsqFK0HX65EUULlNZQeakL5GBqlU-125JuPSweJJVwJee19jmjm3so31eTDrgSZ1blDTcivbcVEDzttAGZ7B3qbfyOq3k7xTEs6MehXkUA6QRx4Tw9KOa82V3dwAE38JjqHE0BeyKuwA4ckvZ5IwnRjf_P2nlT9-F6MlaLKsTn4acHBUQ7it0rUVahet",
    "cache-control: no-cache",
    "postman-token: 41dbc180-6fa9-2f76-d590-250b9f8e6736"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

$products=json_decode($response, true);

foreach ($products['artists'] as $key => $value)
 {
echo $value['external_urls']['spotify']."<br>";

echo $value['name']."<br>";
}


curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
}
?>