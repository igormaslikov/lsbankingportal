<?php
include('../dbconnect.php');
include('../dbconfig.php');
include('../functions.php');
date_default_timezone_set('America/Los_Angeles');

echo "Created time is " . date("H:i"). "<br>";
$now=date("H:i");
$start = "08:30";
$end = "09:32";
$start1 = "13:30";
$end1 = "14:32";
$start2 = "18:30";
$end2 = "19:32";
//$now = date('H');

if (($now >= $start && $now <= $end) || ($now >= $start1 && $now <= $end1) || ($now >= $start2 && $now <= $end2 ))
{
    echo "time in between";
    
$last_date2 = date('Y-m-d', strtotime('-3 days'));
$date =  date('Y-m-d');

$query = "select * from fnd_user_profile where application_status = 'Approved Personal Loan' AND website='lsprestamos' AND (last_update_date BETWEEN '$last_date2' AND '$date') ";

//echo $query . "<br>";
$sql=mysqli_query($con, "$query"); 

  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($sql);
  echo "Row Count is : " . $rowcount. "<br>";
  
while($row = mysqli_fetch_array($sql)) {
    $application_id = $row['user_fnd_id'];
    $phone = $row['mobile_number'];
    //$phone = "+923224951307";
    $fname = $row['first_name'];
    $lang = $row['lang'];
    echo $application_id . "<br>";
    
    if($lang=='en')
    {
    $query_sms_content = "select * from msg_template where msg_name='approvedpersonalloan' ";
    $msg_content = '';
    $sql_sms_content=mysqli_query($con, "$query_sms_content"); 
    $rowcount_sms_content=mysqli_num_rows($sql_sms_content);
    while($row_sms_content = mysqli_fetch_array($sql_sms_content)) {
    $msg_name2 = $row_sms_content['msg_name'];
    $msg_content= $row_sms_content['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_content."</h3>";

}
    
  }
  
else{
    
    $query_sms_content = "select * from msg_template where msg_name='approvedpersonalloanspanish' ";
    $msg_content = '';
    $sql_sms_content=mysqli_query($con, "$query_sms_content"); 
    $rowcount_sms_content=mysqli_num_rows($sql_sms_content);
    while($row_sms_content = mysqli_fetch_array($sql_sms_content)) {
    $msg_name2 = $row_sms_content['msg_name'];
    $msg_content= $row_sms_content['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_content."</h3>";

}
}  
  
  
  // Send SMS Start 
    
      $message = "Hola ".$fname.", ".$msg_content;
      send_sms($phone,$message);
    
    // Send SMS api Code end
    
    $date_update= date('Y-m-d H:i:s');
    $query_insert_activity = "Insert into application_status_updates (application_id, status, creation_date) Values ($application_id, ' Automatic App : Auto Approved Personal Loan SMS Sent', '$date_update')";
    mysqli_query ($con , $query_insert_activity);
    
    
}
    
    
    // Status changing to NO ANSWER START
    

$last_date2_na = date('Y-m-d', strtotime('-8 days'));
$date_na =   date('Y-m-d', strtotime('-3 days'));    
$query_na = "select * from fnd_user_profile where application_status = 'Approved Personal Loan'  AND website='lsprestamos' AND (last_update_date BETWEEN '$last_date2_na' AND '$date_na') ";

//echo $query . "<br>";
$sql=mysqli_query($con, "$query_na"); 

  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($sql);
  echo "Row Count is : " . $rowcount. "<br>";
  
while($row = mysqli_fetch_array($sql)) {
    $application_id = $row['user_fnd_id'];
  $time_na = "20:00"; 
  if($now>$time_na){
    mysqli_query($con, "UPDATE `fnd_user_profile` SET `application_status`='No Answer' WHERE `user_fnd_id` = '$application_id'");
      $date_update= date('Y-m-d H:i:s');
    $query_insert_activity = "Insert into application_status_updates (application_id, status, creation_date) Values ($application_id, ' Automatic App : Autochange status to NO ANSWER', '$date_update')";
    mysqli_query ($con , $query_insert_activity);
  }
    echo "no asnwer " .$application_id.  " <br> ";
}
    
    // Status changing to NO ANSWER END
    
    
}
else
{
    echo "time not between";
}



