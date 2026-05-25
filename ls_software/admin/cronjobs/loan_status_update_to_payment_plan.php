<?php

include '../dbconnect.php';
include '../dbconfig.php';

date_default_timezone_set('America/Los_Angeles');

echo "Created time is " . date("H:i"). "<br>";

$sql=$con->query("select * from tbl_loan"); 

while($row = $sql->fetch_array()) {

$loan_id=$row['loan_create_id'];
$application_id=$row['user_fnd_id'];
$loan_total_payable=$row['loan_total_payable'];
$totall_trans = 0;
$query_trns = $con->query("SELECT SUM(TRY_CAST(payoff_amount AS DECIMAL(18,2))) AS value_sum FROM loan_transaction where loan_create_id= '$loan_id'");
while ($row_trns=$query_trns->fetch_array()){
    $totall_trans = $row_trns['value_sum'];
   
   $totall_trans = $totall_trans;

}




if ($totall_trans>0 && $loan_total_payable>$totall_trans)
{
    
   
  //  $con->query("UPDATE tbl_loan SET loan_status = 'Payment Plan' where loan_create_id = '$loan_id'");
   
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