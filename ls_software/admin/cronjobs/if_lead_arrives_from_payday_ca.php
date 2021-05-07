<?php
include('../dbconnect.php');
include('../dbconfig.php');
date_default_timezone_set('America/Los_Angeles');
echo "The time is " . date("h:i:sa");
$query = "SELECT * FROM fnd_user_profile WHERE `date_time_current` < (NOW() - INTERVAL 12 MINUTE) AND application_status = 'New Application' AND website='Payday CA'";

//echo $query . "<br>";
$sql=mysqli_query($con, "$query"); 

  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($sql);
  echo "Row Count is : " . $rowcount. "<br>";
  
while($row = mysqli_fetch_array($sql)) {
$application_id = $row['user_fnd_id'];
echo "APP ID : " . $application_id. "<br>";
$decision_logic_status = $row['decision_logic_status'];

if ($decision_logic_status=='1')
{
       
         mysqli_query ($con , "UPDATE `fnd_user_profile` SET `application_status`='Review Payday CA'  where `user_fnd_id` = '$application_id'");
         $date_update= date('Y-m-d H:i:s');
         $query_insert_activity = "Insert into application_status_updates (application_id, status, creation_date) Values ($application_id, ' Automatic App :  Status Changed (Review Payday CA) On The Bases Of Decision Logic ', '$date_update')";
         mysqli_query ($con , $query_insert_activity);
   
}


else{
    
    
         mysqli_query ($con , "UPDATE `fnd_user_profile` SET `application_status`='DL/Bank Payday CA'  where `user_fnd_id` = '$application_id'");
         $date_update= date('Y-m-d H:i:s');
         $query_insert_activity = "Insert into application_status_updates (application_id, status, creation_date) Values ($application_id, ' Automatic App :  Status Changed (DL/Bank Payday CA) On The Bases Of Decision Logic ', '$date_update')";
         mysqli_query ($con , $query_insert_activity);
    
}
    
    
    
}
    
    
?>    
    
    


