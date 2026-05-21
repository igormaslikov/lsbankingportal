<?php
    include_once '../dbconnect.php';
    include_once '../dbconfig.php';
    
    
   

$sql_t="SELECT * FROM tbl_personal_loans WHERE user_fnd_id='3934'";

if ($result_t=$con->query($sql_t))
  {
  $rowcount=$result_t->num_rows;
  
  echo "Count Is: ".$rowcount;
  }

$con->close();

?>
