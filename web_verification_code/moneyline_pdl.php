<?php
sleep(4); 
$email=$_GET['email'];
$name=$_GET['code'];

echo "Email: ".$email."<br>";
echo "Code: ".$name;


include_once 'dbconnect.php';
include_once 'dbconfig.php';

// Connect to MySQL Database
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnection.php';
$con = new mysqli($db_host,$db_user,$db_pass,$db_name);

$date = date("Y/m/d");
include('ls_software/API_files/Lspayday_API/dbconnect.php');
include('ls_software/API_files/Lspayday_API/dbconfig.php');
mysqli_query($con,"Insert into decision_login_codes (code,email,date) Values ('$name','$email','$date')");
$date = date('Y-m-d H:i:s');
// To check whether user is declined in 90 day period
$date_decline = date('Y-m-d', strtotime('-90 days'));
$query_check = "select * from fnd_user_profile where ( (email = '$email' AND email !='') ) AND (application_status = 'Declined' OR application_status = 'Rejected By Customer') AND (creation_date BETWEEN '$date_decline'AND '$date')";
$sql_check=mysqli_query($con, "$query_check"); 
  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($sql_check);
//  echo "Row Count is : " . $rowcount. "<br>";
if ($rowcount>0){
	//echo "record exists";
	$name = "AAAAAAA";
}


?>