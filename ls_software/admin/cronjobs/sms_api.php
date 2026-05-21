<?php 
include('../dbconnect.php');
include('../dbconfig.php');
include('../functions.php');



date_default_timezone_set('America/Los_Angeles');

//echo "Created time is " . date("H:i"). "<br>";
$now=date("H:i");
$start = "07:01";
$end = "18:59";
//$now = date('H');


if (($now >= $start  && $now <= $end)) 

{ 
    echo "time in between";
    
$sql_sms=$con->query("select TOP 2 * from marketing_sms where status='0'");

while($row_sms = $sql_sms->fetch_array()) {

$phone_number=$row_sms['phone_number'];
$message=$row_sms['message'];
$sms_id = $row_sms['sms_id'];
//echo "number is:".$message."<br>";

send_sms($phone_number,$message);

$data=json_decode($response,true);

$date_created=$data['date_created'];
$api_status=$data['status'];
if($api_status=='queued')
{
//echo "Created date: $date_created<br>";

}

$con->query("UPDATE marketing_sms SET status ='1'  where sms_id = '$sms_id'");
}

    
}


else{
    
    "No Time";
}





?>