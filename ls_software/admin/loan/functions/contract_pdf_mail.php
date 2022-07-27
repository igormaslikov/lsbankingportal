<?php 

include_once '../../dbconnect.php';
include_once '../../dbconfig.php';
include_once '../../functions.php';
date_default_timezone_set('America/Los_Angeles');
$user_id= $_GET['user_id'];
$loan_id = $_GET['loan_id'];
$user_fnd_id = $_GET['user_fnd_id'];
//$loan_id = $_GET['loan_id'];
$phone_number = $_GET['phone_number'];
$email_key = $_GET['email_key'];
$url = "https://ofsca.com/loanportal/signature_customer/completed/index.php?id=".$email_key;
$message = "Hello, Please sign your loan contract by clicking on this url : ".$url;
$email = $_GET['email'];

 	$to_email = $email;
    $subject = 'Payday Loan Contract Link';
   //$fname=$first_name;
   // $lname= $last_name;
    $message = "Hello , 
   
   Please sign, Here is the link to your Payday Loan Contract :  $url ";
   
   $headers = 'From: support@ofsca.com';
   //mail($to_email,$subject,$message,$headers);
    send_email_notification($to_email,$subject,$message);
 
    $date_update= date('Y-m-d H:i:s');
    $query_insert_activity = "Insert into application_status_updates (application_id,loan_create_id,user_id,status,creation_date) Values ('$user_fnd_id','$loan_id','$user_id','Contract Link Sent via Mail','$date_update')";
    mysqli_query ($con , $query_insert_activity);
?>


<script>

  alert("Contract Link Sent to Customer via MAIL");
close(); 
</script>

