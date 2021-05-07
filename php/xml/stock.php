<?php


include_once 'dbconnect.php';

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.eqdropship.co.uk/feed.php?feed=stock&uid=7529&key=810753a25fec903e475d9b1b26b398bb",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "postman-token: 6d481cd3-e8ce-08c2-28f5-075bc1ffd33b"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
 // echo $response;
}


$dom = new DOMDocument();
$dom->loadXML($response);
$Header = $dom->getElementsByTagName('feed');


foreach ($Header as $hotel) {
    
    $OrderHeader = $hotel->getElementsByTagName('itm');
foreach ($OrderHeader as $hotell) {
    
    $pid = $hotell->getElementsByTagName('pid')->item(0)->nodeValue;
    $name = $hotell->getElementsByTagName('name')->item(0)->nodeValue;
    $sku = $hotell->getElementsByTagName('sku')->item(0)->nodeValue;
    $qty = $hotell->getElementsByTagName('qty')->item(0)->nodeValue;
    $price = $hotell->getElementsByTagName('price')->item(0)->nodeValue;
    
    
    $price = number_format((float)$price, 2, '.', '');
    

    
    //echo "P ID: ".$pid."<br>";
    //echo "Name: ".$name."<br>";
    //echo "Sku : ".$sku."<br>";
    //echo "Quantity : ".$qty."<br>";
    //echo "Price : ".$price."<br><br><br>";
    
     $sql = "SELECT * FROM tbl_stock WHERE `sku` = '$sku'";
        $result = mysqli_query($con, $sql);

       if(mysqli_num_rows($result) > 0)
       {
           
           mysqli_query($con,"UPDATE tbl_stock SET  qty='$qty' where sku='$sku' ");
     }
       else
       {  
   

   


  $query  = "INSERT INTO tbl_stock (pid,name,sku,qty,price)  VALUES ('$pid','$name','$sku','$qty','$price')";
        $result = mysqli_query($con, $query);
        if ($result) {
           echo "<div class='form'><h3> successfully added in tbl_stock.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }





       }
       
    
    
    
    
    
    
    
    
    
    
    
   

}
}










?>