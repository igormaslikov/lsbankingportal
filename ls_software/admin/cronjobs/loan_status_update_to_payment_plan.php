<?php

include '../dbconnect.php';
include '../dbconfig.php';

date_default_timezone_set('America/Los_Angeles');

echo "Created time is " . date("H:i"). "<br>";

$sql=mysqli_query($con, "select * from tbl_loan"); 

while($row = mysqli_fetch_array($sql)) {

$loan_id=$row['loan_create_id'];
$application_id=$row['user_fnd_id'];
$loan_total_payable=$row['loan_total_payable'];
$totall_trans = 0;
$query_trns = mysqli_query($con,"SELECT SUM(payoff_amount) AS value_sum FROM loan_transaction where loan_create_id= '$loan_id'");
while ($row_trns=mysqli_fetch_array($query_trns)){
    $totall_trans = $row_trns['value_sum'];
   
   $totall_trans = $totall_trans;

}




if ($totall_trans>0 && $loan_total_payable>$totall_trans)
{
    
   
  //  mysqli_query($con,"UPDATE tbl_loan SET loan_status = 'Payment Plan' where loan_create_id = '$loan_id'");
   
     echo "Loan _ ID "  .$loan_id . " & Total Payment is ".$totall_trans." & Toatal Payable is ".$loan_total_payable."<br>";
     
 //   $date_update= date('Y-m-d H:i:s');
  //  $query_insert_activity = "Insert into application_status_updates //(application_id,loan_create_id,user_id,status,creation_date) Values //('$application_id','$loan_id','N/a','Account Status Auto-Updated to //Payment Plan','$date_update')";
   // mysqli_query ($con , $query_insert_activity);
    
    
}

else
{
    
   // echo "haha";


}

}

?>