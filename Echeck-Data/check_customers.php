<?php
 include('../ls_software/admin/dbconfig.php');
 include('../ls_software/admin/dbconnect.php');
 

$sql=$con->query("select * from fnd_user_profile");
$rowcount_funded=$sql->num_rows;
echo "Row Count: $rowcount_funded<br><hr><br>";
while($row = $sql->fetch_array()) {

$mobile_number=$row['mobile_number'];
$email=$row['email'];
//echo "mobile_number: $mobile_number<br><br>";




    $query = "DELETE FROM tbl_echeck_customer WHERE mobile_number = '$mobile_number'";
    $result = $con->query($query);





}
?>