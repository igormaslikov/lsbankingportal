<?php

include($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');


$query = "select * from fnd_user_profile where website='lspaydayloans' AND application_status='New Application' AND decision_logic_status!='1' AND (date_time_current<DATE_SUB(NOW(), INTERVAL 6 MINUTE ) AND date_time_current>DATE_SUB(NOW(), INTERVAL 24 HOUR))";
$sql=mysqli_query($con, "$query"); 
  $rowcount=mysqli_num_rows($sql);
  
while($row = mysqli_fetch_array($sql)) {
    $application_id = $row['user_fnd_id'];
    $email= $row['email'];
 echo "<br><br><br>";

 
 // echo "<h3>Email is : ".$email."</h3>";
 
  mysqli_query($con, "UPDATE `fnd_user_profile` SET `application_status`='No Decision Logic For Payday' WHERE `user_fnd_id` = '$application_id'");
      $date_update= date('Y-m-d H:i:s');
    $query_insert_activity = "Insert into application_status_updates (application_id, status, creation_date) Values ($application_id, ' Automatic App : Autochange status to No Decision Logic For Payday', '$date_update')";
    mysqli_query ($con , $query_insert_activity);

}



?>