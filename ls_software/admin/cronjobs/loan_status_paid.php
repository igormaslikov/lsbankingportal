<?php

include '../dbconnect.php';
include '../dbconfig.php';








$sql=$con->query("select * from tbl_loan where cron_job_loan_status = '0'"); 

while($row = $sql->fetch_array()) {

$loan_id=$row['loan_create_id'];
$application_id=$row['user_fnd_id'];
$loan_total_payable=$row['loan_total_payable'];



$query_trns = $con->query("SELECT SUM(TRY_CAST(payoff_amount AS DECIMAL(18,2))) AS value_sum FROM loan_transaction where loan_create_id= '$loan_id'");
while ($row_trns=$query_trns->fetch_array()){
    $totall_trans = $row_trns['value_sum'];
   

}
$totall_trans = number_format((float)$totall_trans, 2, '.', '');

 



$balns_due=$loan_total_payable-$totall_trans;

//echo"<br>Loan ID:" .$loan_id."<br>";



if ($balns_due=='0')
{
    
 
    $con->query("UPDATE tbl_loan SET loan_status = 'Paid', cron_job_loan_status='1' where loan_create_id = '$loan_id'");
    
    
    $date_update= date('Y-m-d H:i:s');
    $query_insert_activity = "Insert into application_status_updates (application_id,loan_create_id,user_id,status,creation_date) Values ('$application_id','$loan_id','N/a','Account Status Auto-Updated to Paid','$date_update')";
    $con->query($query_insert_activity);
    
}

else
{
    
   // echo "haha";


}







}


?>