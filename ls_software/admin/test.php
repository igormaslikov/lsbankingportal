<?php

include_once 'dbconnect.php';
include 'dbconfig.php';

$date_last_7days = date('Y-m-d',time()-(7*86400)); 
echo "Fnd ID: $date_last_7days<br>";

$sql=mysqli_query($con, "select * from loan_transaction where created_at >='$date_last_7days'"); 

while($row = mysqli_fetch_array($sql)) {
$mobile_verification = $row['user_fnd_id'];
$loan_create_id = $row['loan_create_id'];



echo "Fnd ID: $mobile_verification: $loan_create_id<br>";




}

?>