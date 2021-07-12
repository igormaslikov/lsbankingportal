<?php
date_default_timezone_set('America/Los_Angeles');
$host = "mymoneyline.com/lsbankingportal/"; 
$user = "dblsuser2021"; 
$password = "^%D24L*!Ti5%"; 
$database = "dbs57337"; 

// Connect to MySQL Database
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnection.php';
$con = new mysqli($db_host,$db_user,$db_pass,$db_name);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://conversations.twilio.com/v1/Conversations/CH416c2d459e5e4c818925ad650236bce1/Messages",
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
  // echo $response;
}


$response = json_decode($response,TRUE);
foreach($response['messages'] as $messages){
    $body = $messages['body'];
    $conversation_sid = $messages['conversation_sid'];
    $delivered = $messages['delivery']['delivered'];
    $read = $messages['delivery']['read'];
    $sid = $messages['sid'];
    //echo "Body: $sid<br>";
    foreach($messages['media'] as $mms){
        $file_name =  $mms['filename'];
        $sid_mms = $mms['sid'];
        //echo $sid_mms;
                
                
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://mcs.us1.twilio.com/v1/Services/IScdf26a719c164f7a85b2e162b40c00ef/Media/$sid_mms",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"\"; filename=\"WhatsApp Image 2021-03-11 at 4.20.06 PM.jpeg\"\r\nContent-Type: image/jpeg\r\n\r\n\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
          CURLOPT_HTTPHEADER => array(
            "authorization: Basic QUM1ZTE4Yjg1MTk3ZGI2ZTMyZDE5OTViZjNiNDBlMDQ1YjpiOGI0NmI0Njg5MDQ3OWJjZjI1YTlmYjIwNjdlMWMxZQ==",
            "cache-control: no-cache",
            "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
            "postman-token: ee33fa6a-c5f2-efdb-03a6-9fa104f20bc3"
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
        
        $response = json_decode($response,TRUE);
        echo "<img src='".$response['links']['content_direct_temporary']."'>";
        
    }
    
$query  = "INSERT INTO `tbl_conversation`(`caht_key`, `message`, `message_id`, `date`, `status_deliver`, `status_read`) VALUES ('$conversation_sid','$body','$sid','$now','$delivered','$read')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }


    
    
}
?>