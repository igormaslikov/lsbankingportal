<?php
$id= $_GET['id'];
include 'dbconnect.php';

$sql=$DBcon->query("select * from fnd_user_profile where user_fnd_id='$id'"); 

while($row = $sql->fetch_array()) {
    
$name=$row[7];
$email=$row[10];
$phone=$row[12];
$ssn=$row[16];
$mail_address=$row[13];
echo $mail_address;
}
?>