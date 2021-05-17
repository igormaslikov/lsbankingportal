<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';


 $id=$_GET['id'];
 
$sql_fnd=mysqli_query($con, "select * from tbl_users"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_id'];

$loan_create_id=$row_fnd['loan_create_id'];
echo "FND_ID" .$user_fnd_id;

}


?>