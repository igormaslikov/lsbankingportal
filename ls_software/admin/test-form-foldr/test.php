<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';
    
    
    
   

$sql_t="SELECT * FROM tbl_personal_loans WHERE `user_fnd_id`='3934'";

if ($result_t=mysqli_query($con,$sql_t))
  {
  $rowcount=mysqli_num_rows($result_t);
  
  echo "Count Is: ".$rowcount;
  }

mysqli_close($con);

?>
