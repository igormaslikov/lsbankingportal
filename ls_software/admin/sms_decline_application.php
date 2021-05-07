<?php
session_start();
include_once 'dbconnect.php';
include 'dbconfig.php';
include_once 'functions.php';

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
  
 
  
  <?php 
  $cu_id= $_GET['id'];
  $phone= $_GET['phone'];
  $fname=$_GET['f_name'];
  $lname= $_GET['l_name'];
  $lang=$_GET['lang'];


if ($lang=='en')
{

$query_sms_content = "select * from msg_template where msg_name='declinedsms' ";
$msg_content = '';
$sql_sms_content=mysqli_query($con, "$query_sms_content"); 
  $rowcount_sms_content=mysqli_num_rows($sql_sms_content);
while($row_sms_content = mysqli_fetch_array($sql_sms_content)) {
    $msg_name2 = $row_sms_content['msg_name'];
    $msg_content= $row_sms_content['msg_content'];
 //echo "<br><br><br><br><br>";
 
 //echo "<h3> is : ".$msg_content."</h3>";

}

}
else{
    
    $query_sms_content = "select * from msg_template where msg_name='declinedsmsspanish' ";
$msg_content = '';
$sql_sms_content=mysqli_query($con, "$query_sms_content"); 
  $rowcount_sms_content=mysqli_num_rows($sql_sms_content);
while($row_sms_content = mysqli_fetch_array($sql_sms_content)) {
    $msg_name2 = $row_sms_content['msg_name'];
    $msg_content= $row_sms_content['msg_content'];
 //echo "<br><br><br><br><br>";
 
 //echo "<h3> is : ".$msg_content."</h3>";

}
}
$del_reason="Decline SMS Sent";
$transaction_id="";
$loan_create_id="";

application_notes_update($cu_id,$loan_create_id,$u_id,$del_reason,$transaction_id);
  
  $message = "Hola ".$fname." ".$lname.",".$msg_content;
  send_sms($phone,$message);
  ?>
  
  <br><br><br><br>
  <h2 align="center"> Decline SMS has been sent to <?php echo $fname; ?> </h2>
   
  <a href="edit_customer.php?id=<?php echo $cu_id ;?>&f_name=<?php echo $fname;?>&phone=<?php echo $phone;?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;center;margin-left: 45%;margin-top: 2%;">Go Back</button> </a>

  </html>
  </body>
<?php
}
?>

    
  