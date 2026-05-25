<?php

include('../dbconnect.php');
include('../dbconfig.php');

$query = "select * from fnd_user_profile where website='mymoneyline_pdl' AND application_status='New Application' AND decision_logic_status!='1' AND (date_time_current<DATEADD(MINUTE, -6, GETDATE()) AND date_time_current>DATEADD(HOUR, -24, GETDATE()))";
$sql=$con->query("$query"); 
  $rowcount=$sql->num_rows;
  
while($row = $sql->fetch_array()) {
    $application_id = $row['user_fnd_id'];
    $email= $row['email'];
 echo "<br><br><br>";

 
 // echo "<h3>Email is : ".$email."</h3>";
 
  $con->query("UPDATE fnd_user_profile SET application_status='No Decision Logic For Payday' WHERE user_fnd_id = '$application_id'");
      $date_update= date('Y-m-d H:i:s');
    $query_insert_activity = "Insert into application_status_updates (application_id, status, creation_date) Values ($application_id, ' Automatic App : Autochange status to No Decision Logic For Payday', '$date_update')";
    $con->query($query_insert_activity);

}



?>