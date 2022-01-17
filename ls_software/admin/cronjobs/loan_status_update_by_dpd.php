<?php


include '../dbconnect.php';
include '../dbconfig.php';

date_default_timezone_set('America/Los_Angeles');

echo "Created time is " . date("H:i"). "<br>";
$now=date("H:i");
$start = "12:00";

//$now = date('H');

//*********** Clear last_payment_date if there is not transactions*/


$sql_loan_ids = mysqli_query($con, "SELECT tl.loan_id, tl.user_fnd_id,tl.loan_create_id, tl.last_payment_date, v.value_sum from tbl_loan tl Left JOIN (SELECT loan_id, SUM(payoff_amount) AS value_sum FROM loan_transaction GROUP by loan_id) v on tl.loan_id = v.loan_id where (v.value_sum is NULL or v.value_sum = 0) and tl.last_payment_date != ''");

while($rows = mysqli_fetch_array($sql_loan_ids)){
  $loan_id = $rows['loan_id'];
  $user_fnd_id = $rows['user_fnd_id'];
  $loan_create_id = $rows['loan_create_id'];

  mysqli_query($con,"UPDATE tbl_loan SET loan_status='Active', last_payment_date = '' where loan_id= '$loan_id'");

  $date_update= date('Y-m-d H:i:s');
  $query_insert_activity = "Insert into application_status_updates (application_id,loan_create_id,user_id,status,creation_date) Values ('$user_fnd_id','$loan_create_id','N/a','Loan last_payment_date cleared due to missing transactions','$date_update')";
  $res = mysqli_query($con , $query_insert_activity);
}

//**************************************************************** */

$query = "SELECT tl.*, v.value_sum from tbl_loan tl Left JOIN (SELECT loan_id, SUM(payoff_amount) AS value_sum FROM loan_transaction GROUP by loan_id) v on tl.loan_id = v.loan_id ";

$status_array = array("Chargeoff","Collections","Past Due", "Active");

for ($i = 0; $i < count($status_array); $i++)
{
  $status = $status_array[$i];

  $where = " where tl.loan_status = '".$status."'";

  $sql_loan_ids = mysqli_query($con, "SELECT tl.*, v.value_sum from tbl_loan tl Left JOIN (SELECT loan_id, SUM(payoff_amount) AS value_sum FROM loan_transaction GROUP by loan_id) v on tl.loan_id = v.loan_id".$where);

  while($rows = mysqli_fetch_array($sql_loan_ids)){
    $loan_id = $rows['loan_id'];
    $user_fnd_id = $rows['user_fnd_id'];
    $loan_create_id = $rows['loan_create_id'];
  
    $user_fnd_id=$rows['user_fnd_id'];
    $loan_create_id=$rows['loan_create_id'];
    $loan_id=$rows['loan_id'];
    $payment_date=$rows['payment_date'];
    $current_loan_status = $rows['loan_status'];
  
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
          
      if($current_loan_status != $loan_status){
        $date_update= date('Y-m-d H:i:s');
        $query_insert_activity = "Insert into application_status_updates (application_id,loan_create_id,user_id,status,creation_date) Values ('$user_fnd_id','$loan_create_id','N/a','Account Status Auto-Updated to '.$loan_status.' due to over due date','$date_update')";
        mysqli_query ($con , $query_insert_activity);
      } 
  }
}

//  $sql_past_due=mysqli_query($con, "select * from tbl_loan where loan_status !=  AND last_payment_date !=''"); 

// while($row_past_due = mysqli_fetch_array($sql_past_due)) {

// $user_fnd_id=$row_past_due['user_fnd_id'];
// $loan_create_id=$row_past_due['loan_create_id'];
// $loan_id=$row_past_due['loan_id'];
// $payment_date=$row_past_due['payment_date'];

// $date=date('Y-m-d');

// $datetime1 = date_create($payment_date);
// $datetime2 = date_create($date);
// $interval = date_diff($datetime1, $datetime2);

// $loan_status = "";
// if($interval->days >= 1 && $interval->days <=30)
// {
//   $loan_status = "Past Due";
// }
// elseif($interval->days >= 31 && $interval->days <=60){
//   $loan_status = "Collections";
// }
// elseif($interval->days > 60){
//   $loan_status = "Chargeoff";
// }

// if($loan_status != "")
//   mysqli_query($con,"UPDATE tbl_loan SET  days_past_due=$interval->days where loan_id= '$loan_id'");
      
      
//   $date_update= date('Y-m-d H:i:s');
//   $query_insert_activity = "Insert into application_status_updates (application_id,loan_create_id,user_id,status,creation_date) Values ('$user_fnd_id','$loan_create_id','N/a','Account Status Auto-Updated to $loan_status due to over due date','$date_update')";
//   mysqli_query ($con , $query_insert_activity);
// }

//******************Past Due END  ****************************/
