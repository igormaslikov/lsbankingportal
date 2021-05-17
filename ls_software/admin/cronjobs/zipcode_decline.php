<?php
   include($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
   
   include('../functions.php');
   $query = "select * from fnd_user_profile WHERE `date_time_current` < (NOW() - INTERVAL 5 MINUTE) AND application_status='New Application'";
   $sql=mysqli_query($con, "$query");
   while($row = mysqli_fetch_array($sql)) {
     $first_name = $row['first_name'];
      $last_name = $row['last_name'];
      $email = $row['email'];
      $mobile_number = $row['mobile_number'];
      $user_fnd_id = $row['user_fnd_id'];
      $zip_code=$row['zip_code'];
     echo"Zip Code:". $zip_code."<br>";
     //echo"ID:". $user_fnd_id."<br>";
     $code= substr($zip_code, 0, 1);
   echo "Code: ".$code."<br>";
   if ($code != '9' AND $code != '8' AND $code != '6')
   {
      mysqli_query($con,"UPDATE fnd_user_profile SET application_status ='Declined' where user_fnd_id='$user_fnd_id' ");
      $date= date('Y-m-d H:i:s');
   //echo "<hr> FND ID : ".$user_fnd_id. " ------ ". $date ; 
   $query_update_status= "INSERT INTO `application_status_updates`( `application_id`,  `status`, `creation_date`) VALUES ('$user_fnd_id','AUTOMATIC DECLINED - On the basis of Zip Code.','$date')";
   mysqli_query($con, $query_update_status); 
      $message = "Hola ".$first_name.",Your Application is Declined on the basis of this $zip_code Zip Code .";
   send_sms($mobile_number,$message);
      // MAIL TO FUNCTION FOR Declined APPLICATIONS START
      	$to_email = $email;
   $subject = 'Application Declined';
   $fname=$first_name;
    $lname= $last_name;
    $message = "Hola ".$fname." ".$lname.", 
   
   Your Application is Declined on the basis of this $zip_code Zip Code.";
   
   $headers = 'From: info@lsbanking.com';
  // mail($to_email,$subject,$message,$headers);
      send_email_notification($to_email,$subject,$message);
   // MAIL TO FUNCTION FOR Declined APPLICATIONS END  
     
     
     
     // MAIL TO ADMIN FOR Declined APPLICATIONS START
    $to_email_1 = "kenneth@lsbanking.com";
    $subject_1 = 'Application Declined';
    $fname_1=$first_name;
    $lname_1= $last_name;
    $message_1 = "Hola Admin, 
   
   This is $fname_1 $lname_1  customer with this email:$email and  application status is Declined on the basis of this $zip_code Zip Code.";
   
   $headers_1 = 'From: info@lsbanking.com';
  // mail($to_email_1,$subject_1,$message_1,$headers_1);
      admin_leads_email_notification($subject_1,$message_1);
   // MAIL TO ADMIN FOR Declined APPLICATIONS END
   }
   
   else 
   {
     // echo "that";
   }
   }
   ?>