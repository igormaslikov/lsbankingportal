<?php

 include 'dbconnect.php';
include 'dbconfig.php';


$query = "select * from tbl_stock where sku='EQP01144' ";
$sql=mysqli_query($con, "$query");
while($row = mysqli_fetch_array($sql)) {
       
       $pid=$row['pid'];
     
     $qty_avail_dru=$row['qty'];
     $product_id="10710";


echo "ID".$pid."<br>";
echo "Quantity".$qty_avail_dru."<br>";
echo "Product ID".$product_id."<br>";




$post_body = "{ \r\n  \"stock_quantity\": \"12\",\r\n \"manage_stock\": \"true\"}";

echo "<hr>".$post_body."<hr>";
$curl = curl_init();

curl_setopt_array($curl, array(
 CURLOPT_URL => "https://vapealotltd.co.uk/wp-json/wc/v3/products/$product_id?consumer_key=ck_0819391acca3b5492671ddf861f361bad9f27860&consumer_secret=cs_393f577d4045e3dd508fe3515d3983bfedda52bf",
 CURLOPT_RETURNTRANSFER => true,
 CURLOPT_ENCODING => "",
 CURLOPT_MAXREDIRS => 10,
 CURLOPT_TIMEOUT => 30,
 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
 CURLOPT_CUSTOMREQUEST => "POST",
 CURLOPT_POSTFIELDS => "$post_body",
 CURLOPT_HTTPHEADER => array(
   "authorization: Basic Y2tfY2IwMGE3ZTAyMTM0OWUyYjY0NTE1Mjk3YjhlOTQ5ZTE1NTY0NzFlNzpjc18wMGQzZWJmMWYzODMwNGIxNDIzMTQ1YWM5ZmRhMWYwNTAxMmNhZjJl",
   "cache-control: no-cache",
   "content-type: application/json"
 ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
 echo "cURL Error #:" . $err;
} else {
 echo $response."<br><hr>";
}

$data=json_decode($response, true);
$product_id=$data['id'];

echo "Product ID ".$product_id."<br>";








   


}
?>