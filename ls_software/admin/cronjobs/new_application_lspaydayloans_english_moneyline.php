<?php
include($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');

date_default_timezone_set('America/Los_Angeles');
echo "Created time is " . date("h:i"). "<br>";
$now=date("h:i");
$date_1 = date('Y-m-d', strtotime('-5 days'));
$date =  date('Y-m-d', strtotime('-1 days'));

$query = "select * from fnd_user_profile where application_status = 'New Application' AND (creation_date BETWEEN '$date_1' AND '$date') AND website ='mymoneyline_pdl' ";

echo $query . "<br>";
$sql=mysqli_query($con, "$query"); 

  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($sql);
  echo "Row Count is : " . $rowcount. "<br>";
  
while($row = mysqli_fetch_array($sql)) {
    $application_id = $row['user_fnd_id'];
    $phone = $row['mobile_number'];
    //$phone = "+923224951307";
    $fname = $row['first_name'];
    echo $application_id . "<br>";
    
    mysqli_query ($con , "UPDATE `fnd_user_profile` SET `application_status`='No Decision Logic For Payday' where `user_fnd_id` = '$application_id'");
    
    
    $date_update= date('Y-m-d H:i:s');
    $query_insert_activity = "Insert into application_status_updates (application_id, status, creation_date) Values ($application_id, ' Automatic App :  Status Changed/No Decision Logic For Payday ', '$date_update')";
        mysqli_query ($con , $query_insert_activity);
    
    
}
    
    
    
    
    


