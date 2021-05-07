<?php

include_once 'dbconnect.php';

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.eqdropship.co.uk/feed.php?feed=products&uid=7529&key=810753a25fec903e475d9b1b26b398bb",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "postman-token: 92a1375d-4259-678e-e4ae-91d852b3c543"
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


$dom = new DOMDocument();
$dom->loadXML($response);
$Header = $dom->getElementsByTagName('feed');


foreach ($Header as $hotel) {
    
    $OrderHeader = $hotel->getElementsByTagName('itm');
foreach ($OrderHeader as $hotell) {
    
    $pid = $hotell->getElementsByTagName('pid')->item(0)->nodeValue;
    $name = $hotell->getElementsByTagName('name')->item(0)->nodeValue;
    $var = $hotell->getElementsByTagName('var')->item(0)->nodeValue;
    $sku = $hotell->getElementsByTagName('sku')->item(0)->nodeValue;
    $qty = $hotell->getElementsByTagName('qty')->item(0)->nodeValue;
    $price = $hotell->getElementsByTagName('price')->item(0)->nodeValue;
    $weight = $hotell->getElementsByTagName('weight')->item(0)->nodeValue;
    $size = $hotell->getElementsByTagName('size')->item(0)->nodeValue;
    $img_url = $hotell->getElementsByTagName('img_url')->item(0)->nodeValue;
    $desc_short = $hotell->getElementsByTagName('desc_short')->item(0)->nodeValue;
    $desc_long = $hotell->getElementsByTagName('desc_long')->item(0)->nodeValue;
    $cat_name = $hotell->getElementsByTagName('cat_name')->item(0)->nodeValue;
    $cat_id = $hotell->getElementsByTagName('cat_id')->item(0)->nodeValue;
    $par_name = $hotell->getElementsByTagName('par_name')->item(0)->nodeValue;
    $par_id = $hotell->getElementsByTagName('par_id')->item(0)->nodeValue;
   
   $price = number_format((float)$price, 2, '.', '');
    
    //echo "Price: ".$price."<br>";
    
    
    
     $sql = "SELECT * FROM tbl_products WHERE `sku` = '$sku'";
        $result = mysqli_query($con, $sql);

       if(mysqli_num_rows($result) > 0)
       {
           // ********************* Stock API
           

$query_stock = "select * from tbl_stock where `sku` = '$sku'";
$sql_stock=mysqli_query($con, "$query_stock");
while($row_stock = mysqli_fetch_array($sql_stock)) {
       
       $pid_db=$row_stock['pid'];
      $qty_db = $row_stock['qty'];
      
   mysqli_query($con,"UPDATE tbl_products SET  qty='$qty_db' where sku='$sku' ");   
}

           
           
           //*************************************************************
           
           
            
            
            
     }
       else
       {  
   

   


  $query  = "INSERT INTO tbl_products (pid,name,var,sku,qty,price,weight,size,img_url,desc_short,desc_long,cat_name,cat_id,par_name,par_id)  VALUES ('$pid','$name','$var','$sku','$qty','$price','$weight','$size','$img_url','$desc_short','$desc_long','$cat_name','$cat_id','$par_name','$par_id')";
        $result = mysqli_query($con, $query);
        if ($result) {
          // echo "<div class='form'><h3> successfully added in tbl_products.</h3><br/></div>";
        } else {
       // echo "<h3> Error Inserting Data tbl_products</h3>";
        }





       }
       
       
}
}
 

    ?>
   