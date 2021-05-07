<?php


$curl = curl_init();
$url='https://ro.expertaccounts.com';
$url .='?api=public&t1=a3d102cbbb0c4b3b8f0f4bcac52072e6&t2=7e19999864bb17b5cf10e68e3c7e6276';
$url .='&doctype=pdf.pdf';
$url .='&invoice_date=24-01-2020';

$url .='&src=new_salesOrder';
$url .='&json=true';
echo $url."<br>";
curl_setopt_array($curl, array(
  CURLOPT_URL => "$url",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 110c96b9-d6d1-ea37-e0d3-f7c1cdd07898"
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