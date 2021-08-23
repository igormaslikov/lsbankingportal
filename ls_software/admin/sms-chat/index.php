<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

<style>
  .container {
    width: 99%;
  }
</style>


<?php

date_default_timezone_set('America/Los_Angeles');
include '../dbconfig.php';


$chat_key = $_GET['chat_key'];
$admin_name = $_GET['admin_name'];

if (isset($_POST['submit'])) {

  $message_to_be_sendd =  $_POST['comments'];
  $message_to_be_send = $message_to_be_sendd . ' - ' . $admin_name;
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://conversations.twilio.com/v1/Conversations/$chat_key/Messages",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "Body=$message_to_be_send",
    CURLOPT_HTTPHEADER => array(
      "Authorization: Basic QUM1ZTE4Yjg1MTk3ZGI2ZTMyZDE5OTViZjNiNDBlMDQ1YjpiOGI0NmI0Njg5MDQ3OWJjZjI1YTlmYjIwNjdlMWMxZQ==",
      "Content-Type: application/x-www-form-urlencoded"
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  //echo $response;



}

$curl = curl_init();
mysqli_query($con, "UPDATE `tbl_conversation` SET  `incoming_read`= '1' WHERE `caht_key` = '$chat_key'");
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
  // echo $response;
}


?><style>
  /* Chat containers */
  .container {
    border: 2px solid #dedede;
    background-color: #f1f1f1;
    border-radius: 5px;
    padding: 10px;
    margin: 10px 0;
  }

  /* Darker chat container */
  .darker {
    border-color: #ccc;
    background-color: #ddd;
  }

  /* Clear floats */
  .container::after {
    content: "";
    clear: both;
    display: table;
  }

  /* Style images */
  .container img {
    float: left;
    max-width: 60px;
    width: 100%;
    margin-right: 20px;
    border-radius: 50%;
  }

  /* Style the right image */
  .container img.right {
    float: right;
    margin-left: 20px;
    margin-right: 0;
  }

  /* Style time text */
  .time-right {
    float: right;
    color: #aaa;
  }

  /* Style time text */
  .time-left {
    float: left;
    color: #999;
  }
</style>

<?php
$response = json_decode($response, TRUE);
foreach ($response['messages'] as $messages) {
  $body = $messages['body'];
  $body = str_replace("'", "", "$body");
  $conversation_sid = $messages['conversation_sid'];
  $author = $messages['author'];
  $date_updated = $messages['date_updated'];
  $date_created = $messages['date_created'];
  $delivered = $messages['delivery']['delivered'];
  $read = $messages['delivery']['read'];
  $sid = $messages['sid'];
  $css = "";
  $img = "";

  foreach ($messages['media'] as $mms) {
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

    $response = json_decode($response, TRUE);
    $body = "<img style='    width: 20%;
    max-width: 20%;
    height: auto;
    border-radius: 0;' src='" . $response['links']['content_direct_temporary'] . "'>";
  }



  if ($author == 'system') {
    $css = "darker";

    $img = "avatar.png";
  } else {

    $css = "darker";

    $img = "customer.png";
  }
  $now = date('Y-m-d H:i:s');

  $sql = "SELECT * FROM tbl_conversation WHERE `message_id` = '$sid'";
  $result = mysqli_query($con, $sql);

  if (mysqli_num_rows($result) > 0) {
    // echo 'Rcord exists tbl_products';
    mysqli_query($con, "UPDATE `tbl_conversation` SET `status_deliver`='$delivered',`status_read`='$read' WHERE  `message_id` = '$sid'");
  } else {

    $query  = "INSERT INTO `tbl_conversation`(`caht_key`, `message`, `message_id`, `date`, `status_deliver`, `status_read`) VALUES ('$conversation_sid','$body','$sid','$date_created','$delivered','$read')";
    $result = mysqli_query($con, $query);
    if ($result) {
      //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
    } else {
      //echo "<h3> Error Inserting Data </h3>";
    }
  }
?>


  <div class="container <?php echo $css; ?>">
    <img src="<?php echo $img; ?>" alt="Avatar">
    <p><?php echo $body; ?></p>
    <span class="time-right"><?php
                              $deliverd_sms = '1';
                              $color = "";
                              if ($read == 'none') {
                                $color = "color:gray";
                              } else {
                                $color = "color:blue";
                              }



                              if ($delivered != 'all') {
                                $deliverd_sms = "<span class='glyphicon glyphicon-ok' aria-hidden='true' alt='Not Delivered' style='font-size:8px;color:gray'></span>";
                              } else {
                                $deliverd_sms = "<span class='glyphicon glyphicon-ok' aria-hidden='true' alt='Delivered' style='font-size:8px;$color'></span><span class='glyphicon glyphicon-ok' aria-hidden='true' alt='' style='font-size:8px;$color'></span>";
                              }
                              echo $deliverd_sms . " ";

                              echo $date_updated; ?></span>
  </div>


<?php


}


?>
<form action="#" method="post">
  <textarea name="comments" id="comments" placeholder="Hey... say something!" style="width:93%;height:90px;background-color:#D0F18F;"></textarea>
  <input type="submit" value="Submit" name="submit" style="width:7%;height:90px;float:right;" />
</form>