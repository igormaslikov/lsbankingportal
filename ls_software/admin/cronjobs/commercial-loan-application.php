<?php
include('../dbconnect.php');
include('../dbconfig.php');
include'../functions.php';
date_default_timezone_set('America/Los_Angeles');

$query = "SELECT * FROM fnd_user_profile WHERE date_time_current < DATEADD(MINUTE, -12, GETDATE()) AND application_status = 'New Application' AND website='mymoneyline_cl'";

//echo $query . "<br>";
$sql=$con->query("$query"); 

  // Return the number of rows in result set
  $rowcount=$sql->num_rows;
  echo "Row Count is : " . $rowcount. "<br>";
  
while($row = $sql->fetch_array()) {
$application_id = $row['user_fnd_id'];
$state = $row['state'];
$decision_logic_status = $row['decision_logic_status'];
$loan_create_id="";
$user_id="";
$loan_transaction_id="";
if ($decision_logic_status=='1')
{
       
         $con->query("UPDATE fnd_user_profile SET application_status='Review Installment $state'  where user_fnd_id = '$application_id'");
         $date_update= date('Y-m-d H:i:s');
         $status = "Automatic App :  Status Changed (Review Installment $state) On The Bases Of Decision Logic";
   application_notes_update($application_id,$loan_create_id,$user_id,$status,$loan_transaction_id);
}


else{


         $con->query("UPDATE fnd_user_profile SET application_status='DL/Bank Installment $state'  where user_fnd_id = '$application_id'");
         $date_update= date('Y-m-d H:i:s');
         $status = "Automatic App :  Status Changed (DL/Bank Installment $state) On The Bases Of Decision Logic";
         
    application_notes_update($application_id,$loan_create_id,$user_id,$status,$loan_transaction_id);
}
    
    
    
}
    
    
?>    
    
    


