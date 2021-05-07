<?php

 include 'dbconnect.php';
include 'dbconfig.php';


$query = "select * from tbl_products where status= '0'   limit 10";
$sql=mysqli_query($con, "$query");
while($row = mysqli_fetch_array($sql)) {
       
       $pid=$row['pid'];
      $book_name = $row['name'];
     $book_category = $row['cat_name'];
     $cat_id = $row['cat_id'];
     $sku = $row['sku'];
     $book_sale_price = $row['price'];
     $book_description_s = $row['desc_short'];
     $book_description_l = $row['desc_long'];
     $qty_avail_dru=$row['qty'];
      $img=$row['img_url'];


echo "ID".$pid."<br>";
//echo "Name".$book_name."<br>";
//echo "book_category".$book_category."<br>";
//echo "sku".$sku."<br>";
//echo "book_sale_price".$book_sale_price."<br>";

//echo "Img".$img."<br>";

$book_description_s=$style_des_fr.$style_des_en;
$book_description_s = (string)$book_description_s;

$book_description_l=$style_des_frr.$style_des_enn;
$book_description_l = (string)$book_description_l;

//echo "book_description".$book_description_l."<br>";
//echo "book_description Short".$book_description_s."<br>";

$sku = (string)$sku;
$l_price = (string)$l_price;
$word = "CBD";



if(strpos($book_name, $word) !== false){
    echo "Word Found!"."<hr>";
    
    mysqli_query($con,"UPDATE tbl_products SET status ='1'  where sku='$sku' ");
}


else{

$post_body = "{\r\n  \"name\": \"$book_name\",\r\n  \"type\": \"simple\",\r\n  \"regular_price\": \"$book_sale_price\",\r\n \"sku\": \"$sku\",\r\n \"stock_quantity\": \"$qty_avail_dru\",\r\n \"manage_stock\": \"true\",\r\n \"description\": \"$book_description_l\",\r\n  \"short_description\": \" $book_description_s\",\r\n  \"categories\": [\r\n {\r\n \"id\": \"$cat_id\" \r\n, \r\n \"name\": \"$book_category\" \r\n},\r\n {\r\n \"id\": 14\r\n }\r\n ],\r\n \"images\": [\r\n {\r\n \"src\": \" $img\"\r\n    }  ]\r\n}";

echo "<hr>".$post_body."<hr>";
$curl = curl_init();

curl_setopt_array($curl, array(
 CURLOPT_URL => "https://vapealotltd.co.uk/wp-json/wc/v3/products?consumer_key=ck_0819391acca3b5492671ddf861f361bad9f27860&consumer_secret=cs_393f577d4045e3dd508fe3515d3983bfedda52bf",
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



if($product_id=='')
{
   // echo "Empty";
}


mysqli_query($con,"UPDATE tbl_products SET status ='1', product_id='$product_id' where sku='$sku' ");
mysqli_query($con,"UPDATE tbl_stock SET  product_id='$product_id', status ='1' where sku='$sku' ");


   
}

}
?>