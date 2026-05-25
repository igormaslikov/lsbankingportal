<?php
sleep(4); 
$email=$_GET['email'];
$name=$_GET['code'];

include_once 'dbconnect.php';
include_once 'dbconfig.php';

// Connect to MySQL Database
require_once $_SERVER['DOCUMENT_ROOT'] . '/SqlServerDb.php';
$con = portal_get_sqlsrv_db();

$date = date("Y/m/d");
include('ls_software/API_files/Lspayday_API/dbconnect.php');
include('ls_software/API_files/Lspayday_API/dbconfig.php');
$con->query("Insert into decision_login_codes (code,email,date) Values ('$name','$email','$date')");
$date = date('Y-m-d H:i:s');
// To check whether user is declined in 90 day period
$date_decline = date('Y-m-d', strtotime('-90 days'));
$query_check = "select * from fnd_user_profile where ( (email = '$email' AND email !='') ) AND (application_status = 'Declined' OR application_status = 'Rejected By Customer') AND (creation_date BETWEEN '$date_decline'AND '$date')";
$sql_check=$con->query("$query_check");
  // Return the number of rows in result set
  $rowcount=$sql_check->num_rows;
//  echo "Row Count is : " . $rowcount. "<br>";
if ($rowcount>0){
	//echo "record exists";
	$name = "AAAAAAA";
}


?>