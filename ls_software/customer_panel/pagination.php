<?php
$id= $_GET['id'];
include $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

$sql=mysqli_query($DBcon, "select * from fnd_user_profile where user_fnd_id='$id'"); 

while($row = mysqli_fetch_array($sql)) {
    
$name=$row[7];
$email=$row[10];
$phone=$row[12];
$ssn=$row[16];
$mail_address=$row[13];
echo $mail_address;
}
?>