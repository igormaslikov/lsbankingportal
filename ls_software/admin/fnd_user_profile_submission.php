<?php
include_once 'dbconnect.php';
include_once 'dbconfig.php';


$sql=$con->query("select * from tbl_bank_statements"); 

while($row = $sql->fetch_array()) {

$user_fnd_id=$row['user_fnd_id'];
echo "fname is:".$user_fnd_id."<br>";


$con->query("UPDATE fnd_user_profile SET document_status ='1' where user_fnd_id = '$user_fnd_id' ");







}








?>


