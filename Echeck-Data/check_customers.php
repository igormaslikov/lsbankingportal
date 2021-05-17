<?php
 
 include($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
 

$sql=mysqli_query($con, "select * from fnd_user_profile"); 
$rowcount_funded=mysqli_num_rows($sql);
echo "Row Count: $rowcount_funded<br><hr><br>";
while($row = mysqli_fetch_array($sql)) {

$mobile_number=$row['mobile_number'];
$email=$row['email'];
//echo "mobile_number: $mobile_number<br><br>";




    $query = "DELETE FROM tbl_echeck_customer WHERE mobile_number = '$mobile_number'";
    $result = mysqli_query($con, $query);





}
?>