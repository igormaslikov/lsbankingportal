<?php
include($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');



date_default_timezone_set('America/Los_Angeles');

$last_date2 = date('Y-m-d', strtotime('-7 days'));
$date =  date('Y-m-d');

$query = "select * from fnd_user_profile where decision_logic_status = '1' AND application_status = 'New Application'";

//echo $query . "<br>";
$sql=mysqli_query($con, "$query"); 

  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($sql);
  echo "Row Count is : " . $rowcount. "<br>";
  
while($row = mysqli_fetch_array($sql)) {

    $website =  $row['website'];
    $application_id = $row['user_fnd_id'];
    
    if ($website == 'lsprestamos'){
        
    mysqli_query($con, "UPDATE `fnd_user_profile` SET `application_status`='Decision Logic Completed' WHERE `user_fnd_id` = '$application_id'");
     $date_update= date('Y-m-d H:i:s');
    $query_insert_activity = "Insert into application_status_updates (application_id, status, creation_date) Values ($application_id, ' Auto Update : DL verified & status changed to DL Completed', '$date_update')";
    mysqli_query ($con , $query_insert_activity);
    }
    else if ($website == 'lspaydayloans'){
    
    
    mysqli_query($con, "UPDATE `fnd_user_profile` SET `application_status`='Review For Payday' WHERE `user_fnd_id` = '$application_id'");
    
    $date_update= date('Y-m-d H:i:s');
    $query_insert_activity = "Insert into application_status_updates (application_id, status, creation_date) Values ($application_id, ' Auto Update : DL verified & status changed to Review For PAYDAY', '$date_update')";
    mysqli_query ($con , $query_insert_activity);
    
}
}

?>