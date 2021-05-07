<?php

date_default_timezone_set('America/Los_Angeles');
include '../dbconfig.php';

 $result1 = mysqli_query($con,"SELECT DISTINCT `caht_key`  FROM `tbl_conversation` where `api_status` = '0' order by id desc limit 100");
 
   $rowcount_mc=mysqli_num_rows($result_1);
      if($rowcount_mc<1){
                   mysqli_query($con,"UPDATE `tbl_conversation` SET `api_status`='0' ");
                  }
 
    while($row1 = mysqli_fetch_array($result1)){
		 $chat_key=$row1['caht_key'];
		 
        mysqli_query($con,"UPDATE `tbl_conversation` SET `api_status`='1' WHERE `caht_key` = '$chat_key'");

    $admin_name = $_GET['admin_name'];



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://conversations.twilio.com/v1/Conversations/$chat_key/Messages",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "authorization: Basic QUM1ZTE4Yjg1MTk3ZGI2ZTMyZDE5OTViZjNiNDBlMDQ1YjpiOGI0NmI0Njg5MDQ3OWJjZjI1YTlmYjIwNjdlMWMxZQ==",
    "cache-control: no-cache",
    "postman-token: 86acb3f6-c789-52b2-5ccd-d47a2871b2be"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
 echo $response . "<br>";
}


?>

<?php 
$response = json_decode($response,TRUE);
foreach($response['messages'] as $messages){
    $body = $messages['body'];
    $body=str_replace("'","","$body");
    $conversation_sid = $messages['conversation_sid'];
    $author = $messages['author'];
    $date_updated = $messages['date_updated'];
    $date_created = $messages['date_created'];
    $delivered = $messages['delivery']['delivered'];
    $read = $messages['delivery']['read'];
    $sid = $messages['sid'];
    $css = "";
    $img = "";
   
    $now = date('Y-m-d H:i:s');
    
    $sql = "SELECT * FROM tbl_conversation WHERE `message_id` = '$sid'";
        $result = mysqli_query($con, $sql);

       if(mysqli_num_rows($result) > 0)
       {
         // echo 'Rcord exists tbl_products';
         mysqli_query($con,"UPDATE `tbl_conversation` SET `status_deliver`='$delivered',`status_read`='$read' WHERE  `message_id` = '$sid'");
            
       }
       
       else{
    
    $query  = "INSERT INTO `tbl_conversation`(`caht_key`, `message`, `message_id`, `date`, `status_deliver`, `status_read`  , `incoming_read`) VALUES ('$conversation_sid','$body','$sid','$date_created','$delivered','$read','0')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        //echo "<h3> Error Inserting Data </h3>";
        }
       }
    

    
    
}
 
    }

?>