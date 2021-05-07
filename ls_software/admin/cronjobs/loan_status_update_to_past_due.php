<?php


include '../dbconnect.php';
include '../dbconfig.php';

date_default_timezone_set('America/Los_Angeles');

echo "Created time is " . date("H:i"). "<br>";
$now=date("H:i");
$start = "12:00";

//$now = date('H');


//******************Past Due ****************************

 $sql_past_due=mysqli_query($con, "select * from tbl_loan where loan_status= 'Active' AND last_payment_date=''"); 

while($row_past_due = mysqli_fetch_array($sql_past_due)) {

$user_fnd_id=$row_past_due['user_fnd_id'];
$loan_create_id=$row_past_due['loan_create_id'];
$payment_date=$row_past_due['payment_date'];

$date=date('Y-m-d');


if($date>$payment_date)
{
    
    
  mysqli_query($con,"UPDATE tbl_loan SET loan_status = 'Past Due' where loan_create_id= '$loan_create_id'");
    
    
    $date_update= date('Y-m-d H:i:s');
    $query_insert_activity = "Insert into application_status_updates (application_id,loan_create_id,user_id,status,creation_date) Values ('$user_fnd_id','$loan_create_id','N/a','Account Status Auto-Updated to Past Due due to over due date','$date_update')";
    mysqli_query ($con , $query_insert_activity);
    
     
    
    
    
    
    
}

}

//******************Past Due END  ****************************/


?>