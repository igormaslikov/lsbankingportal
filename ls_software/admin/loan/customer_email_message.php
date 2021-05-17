<?php
error_reporting(0);
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';
include_once '../functions.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$u_access_id = $userRow['access_id'];
if($u_access_id=='2' || $u_access_id=='4' || $u_access_id=='5'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}
else {
$DBcon->close();


?>

<?php
$user_email= $_GET['emaill'];
$link= $_GET['link'];
$email_link= $_GET['email_link'];
//echo "<br><br><br><br><br><br>Link is".$link;
//echo "<br><br><br><br><br><br>Email is".$user_email;
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


<div class="container" style="margin-top:150px;text-align:center;font-family:Verdana, Geneva, sans-serif;font-size:15px;">

<p style="font-weight: bold;">Loan Has Been Generated.</p><br>
<!--<p style="font-weight: bold;">An email with contract is sent to: <?php echo $user_email;?> </p><br>-->

<p style="font-weight: bold;">Or you can send the contract to the customer:<a><?php echo"<br>". $email_link;?></a> </p><br>

<form action="" method="post">
    <input type="submit" name="button_pressed" value="Send Contract to Customer"  style="color: #fff;background-color: blue;border-color: blue;"/>
    <input type="hidden" name="button_pressed" value="1" />
</form>

<?php

if(isset($_POST['button_pressed']))
{
   //CUSTOMER EMAIL STARTS

$to_email = $user_email;
$subject = 'Contract Signature From LSBANKING';
$message = "Please Sign here by clicking on this link : ".$email_link;
$headers = 'From: admin@lsfinancing.com';
//mail($to_email,$subject,$message,$headers);
send_email_notification($to_email,$subject,$message);

//CUSTOMER EMAIL ENDS
}

?>
<br>
<iframe src="<?php echo $link; ?>" width="750" height="900" style="display:none;"></iframe>
<?php 
$i = 1;
if($i>0){
    
sleep(2);
  ?>
<iframe src="<?php echo $link; ?>" width="1050" height="900" style="display:;"></iframe>
<?php
}
?>
</div>

</body>
</html>
<?php
}
?>