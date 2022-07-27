<?php 
date_default_timezone_set('America/Los_Angeles');
include 'dbconnect.php';
include 'dbconfig.php';
function send_email_notification($to_email,$subject,$message){
    $headers = 'From: support@ofsca.com';
    mail($to_email,$subject,$message,$headers);
    
}


function admin_email_notification($admin_subject,$admin_message){
    $admin_headers = 'From: support@ofsca.com';
    $admin_email = "support@ofsca.com";
    mail($admin_email,$admin_subject,$admin_message,$admin_headers);
    
}


function admin_leads_email_notification($admin_subject,$admin_message){
    $admin_headers = 'From: support@ofsca.com';
    $admin_email = "leads@mymoneyline.com";
    mail($admin_email,$admin_subject,$admin_message,$admin_headers);
    
}


function send_sms($phone_number,$message){
    
 $message = str_replace("nnll",'\n',$message);    
// echo $message;
  $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.twilio.com/2010-04-01/Accounts/AC5e18b85197db6e32d1995bf3b40e045b/Messages.json",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "From=+18183010269&To=$phone_number&Body=$message",
  CURLOPT_HTTPHEADER => array(
    "authorization: Basic QUM1ZTE4Yjg1MTk3ZGI2ZTMyZDE5OTViZjNiNDBlMDQ1YjpiOGI0NmI0Njg5MDQ3OWJjZjI1YTlmYjIwNjdlMWMxZQ==",
    "cache-control: no-cache",
    "content-type: application/x-www-form-urlencoded",
    "postman-token: 10b2dea7-4936-ce5b-76b4-58bf44fe5b7f"
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
    
    
}


function send_sms_bluk($phone_number,$message) {
 $message = str_replace("nnll",'\n',$message);    
// echo $message;
  $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.twilio.com/2010-04-01/Accounts/AC5e18b85197db6e32d1995bf3b40e045b/Messages.json",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "From=+18886951203&To=$phone_number&Body=$message",
  CURLOPT_HTTPHEADER => array(
    "authorization: Basic QUM1ZTE4Yjg1MTk3ZGI2ZTMyZDE5OTViZjNiNDBlMDQ1YjpiOGI0NmI0Njg5MDQ3OWJjZjI1YTlmYjIwNjdlMWMxZQ==",
    "cache-control: no-cache",
    "content-type: application/x-www-form-urlencoded",
    "postman-token: 10b2dea7-4936-ce5b-76b4-58bf44fe5b7f"
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
    
    

}




function application_notes_add($user_fnd_id,$app_notes,$creation_date,$created_by){
  include 'dbconfig.php';
   $query= "INSERT INTO `application_notes`( `user_fnd_id`, `app_notes`, `creation_date`, `created_by`) VALUES ('$user_fnd_id','$app_notes','$creation_date','$created_by')";
	   $result = mysqli_query($con, $query);
        if ($result) {
           //echo "<div class='form'><h3> successfully added in application_notes.</h3><br/></div>";
        } else {
        //echo "<h3> Error Inserting Data </h3>";
        }
    
}

function application_notes_update($application_id,$loan_create_id,$user_id,$status,$loan_transaction_id){
    include 'dbconfig.php';
    $date= date('Y-m-d H:i:s');    
   $query= "INSERT INTO `application_status_updates`( `application_id`, `loan_create_id`, `user_id`, `status`, `loan_transaction_id`, `creation_date`) VALUES ('$application_id','$loan_create_id','$user_id','$status','$loan_transaction_id','$date')";
	 // echo $query;
	   $result = mysqli_query($con, $query);
        if ($result) {
          // echo "<div class='form'><h3> successfully added in application_notes.</h3><br/></div>";
        } else {
     //  echo "<h3> Error Inserting Data </h3>";
        }
    
}



function user_roles($user_role,$form_id){
    include 'dbconfig.php';
    $date= date('Y-m-d H:i:s');    
      $sql_role=mysqli_query($con, "select * from access_level_grants where role_id='$user_role' AND form_id='$form_id'"); 


while($row_role = mysqli_fetch_array($sql_role)) {

 
 $delete_allowed=$row_role['delete_allowed'];



//echo $delete_allowed;
}
$delete_allowed = 1; //TODO fix it
return "$delete_allowed";
    
}

function user_edit_roles($user_role,$form_id){
    include 'dbconfig.php';  
      $sql_up=mysqli_query($con, "select * from access_level_grants where role_id='$user_role' AND form_id='$form_id'"); 


while($row_up = mysqli_fetch_array($sql_up)) {

 
 $update_allowed=$row_up['update_allowed'];


//echo $role_id."<br>";

}
$update_allowed = 1; //TODO fix it
return "$update_allowed";
    
}

?>