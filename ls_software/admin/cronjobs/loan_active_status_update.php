<?php


include '../dbconnect.php';
include '../dbconfig.php';

date_default_timezone_set('America/Los_Angeles');

echo "Created time is " . date("H:i"). "<br>";
$now=date("H:i");
$start = "12:00";

//$now = date('H');


//******************Change Active Loans status ****************************

 $sql_past_due=mysqli_query($con, "select * from tbl_loan where loan_status= 'Active' AND last_payment_date=''"); 

while($row_past_due = mysqli_fetch_array($sql_past_due)) {

$user_fnd_id=$row_past_due['user_fnd_id'];
$loan_create_id=$row_past_due['loan_create_id'];
$loan_id=$row_past_due['loan_id'];
$payment_date=$row_past_due['payment_date'];

$date=date('Y-m-d');

$datetime1 = date_create($payment_date);
$datetime2 = date_create($date);
$interval = date_diff($datetime1, $datetime2);
$days = $interval->invert == 1 ? -$interval->days : $interval->days;

$loan_status = "";
if($days >= 1 && $days <=30)
{
  $loan_status = "Past Due";
}
elseif($days >= 31 && $days <=60){
  $loan_status = "Collections";
}
elseif($days > 60){
  $loan_status = "Chargeoff";
}

if($loan_status != "")
  mysqli_query($con,"UPDATE tbl_loan SET loan_status = '$loan_status', days_past_due=$days where loan_id= '$loan_id'");
      
      
  $date_update= date('Y-m-d H:i:s');
  $query_insert_activity = "Insert into application_status_updates (application_id,loan_create_id,user_id,status,creation_date) Values ('$user_fnd_id','$loan_create_id','N/a','Account Status Auto-Updated to $loan_status due to over due date','$date_update')";
  mysqli_query ($con , $query_insert_activity);
}

//******************Past Due END  ****************************/


?>