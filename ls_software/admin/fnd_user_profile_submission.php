<?php
include_once 'dbconnect.php';
include_once 'dbconfig.php';


$sql=mysqli_query($con, "select * from tbl_bank_statements"); 

while($row = mysqli_fetch_array($sql)) {

$user_fnd_id=$row['user_fnd_id'];
echo "fname is:".$user_fnd_id."<br>";


mysqli_query($con,"UPDATE fnd_user_profile SET document_status ='1' where user_fnd_id = '$user_fnd_id' ");







}








?>


