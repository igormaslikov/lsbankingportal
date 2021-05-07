<?php
session_start();
include_once 'dbconnect.php';
include('dbconfig.php');
if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$u_id=$userRow['user_id'];

$u_access_id = $userRow['access_id'];
if($u_access_id=='0'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}
else {
$DBcon->close();

?>










<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['email']; ?></title>

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />

</head>
<body>

<?php include('menu.php') ;?>

  <iframe src="../marketing_sms/index.php" width="100%" height="860px"></iframe>
  <?php





$query = "select * from url_counter where url='dinero' ";
//$query = "select * from decision_login_codes where  id = 564";

//echo $query . "<br>";
$sql=mysqli_query($con, "$query"); 

  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($sql);

while($row = mysqli_fetch_array($sql)) {
    
$counter = $row['url_counter'];
$website = $row['url'];
echo "<h3>Counter for Page ".$website." is : ".$counter."</h3>";

}

?>

<a href="" style="font-weight: bold;">Activity Log</a><br>
  <iframe src="http://lsbankingportal.com/ls_software/admin/activity_log.php" width="100%" height="900px"></iframe>
</body>
</html>

<?php

}
?>
