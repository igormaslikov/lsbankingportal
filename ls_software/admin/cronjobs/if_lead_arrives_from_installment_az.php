<?php
include('../dbconnect.php');
include('../dbconfig.php');
date_default_timezone_set('America/Los_Angeles');

$query = "SELECT * FROM fnd_user_profile WHERE date_time_current < DATEADD(MINUTE, -12, GETDATE()) AND application_status = 'New Application' AND website='Installment Arizona'";

//echo $query . "<br>";
$sql=$con->query("$query"); 

  // Return the number of rows in result set
  $rowcount=$sql->num_rows;
  echo "Row Count is : " . $rowcount. "<br>";
  
while($row = $sql->fetch_array()) {
$application_id = $row['user_fnd_id'];
$decision_logic_status = $row['decision_logic_status'];

if ($decision_logic_status=='1')
{
       
         $con->query("UPDATE fnd_user_profile SET application_status='Review Installment AZ'  where user_fnd_id = '$application_id'");
         $date_update= date('Y-m-d H:i:s');
         $query_insert_activity = "Insert into application_status_updates (application_id, status, creation_date) Values ($application_id, ' Automatic App :  Status Changed (Review Installment AZ) On The Bases Of Decision Logic ', '$date_update')";
         $con->query($query_insert_activity);

}


else{


         $con->query("UPDATE fnd_user_profile SET application_status='DL/Bank Installment AZ'  where user_fnd_id = '$application_id'");
         $date_update= date('Y-m-d H:i:s');
         $query_insert_activity = "Insert into application_status_updates (application_id, status, creation_date) Values ($application_id, ' Automatic App :  Status Changed (DL/Bank Installment AZ) On The Bases Of Decision Logic ', '$date_update')";
         $con->query($query_insert_activity);
    
}
    
    
    
}
    
    
?>    
    
    


