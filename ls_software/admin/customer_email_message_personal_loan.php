<?php
error_reporting(0);
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';
include_once 'functions.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$DBcon->close();

?>

<?php
$user_email= $_GET['emaill'];
$link= $_GET['link'];
$email_link= $_GET['email_link'];
$mobile_number= $_GET['mobile_number'];
$user_fnd_id= $_GET['user_fnd_id'];


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
<?php //echo "<br><br><br><br><br><br>LINK".$link;?>
<p style="font-weight: bold;">New Installment Loan Has Been Generated.</p><br>
<!--<p style="font-weight: bold;">An email with contract is sent to: <?php echo $user_email;?> </p><br>-->

<p style="font-weight: bold;">Or you can send the contract to the customer:<a><?php echo"<br>". $email_link;?></a> <a href="sms_send_contract.php?id=<?php echo $user_fnd_id ;?>&phone=<?php echo $mobile_number;?>&email=<?php echo $_GET['emaill'];?>&link=<?php echo $_GET['link'];?>&email_link=<?php echo $_GET['email_link'];?>&email_link=<?php echo $_GET['email_link'];?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;height: 35px; width:18%">Send contract to customer</button> </a></p> 
<br><br>

<form action="" method="post">
    <input type="submit" name="button_pressed" value="Send Contract to Customer (via Email)"  style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;height: 35px; width:29%"/>
    <input type="hidden" name="button_pressed" value="1" />
     </form>
     <form action="" method="post">
    <input type="submit" name="button_sms" value="Send Contract to Customer (via SMS)"  style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;height: 35px; width:29%"/>
    <input type="hidden" name="button_sms" value="1" />
    
    </form>

<?php

if(isset($_POST['button_sms']))
{
   //CUSTOMER SMS STARTS
$phone_number = $_GET['mobile_number'];
$message = "Hello Customer, Please sign the contract here : ".$email_link ;

 $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sms-magic.com/v1/sms/send",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_HTTPPROXYTUNNEL => TRUE,
  CURLOPT_SSL_VERIFYPEER => FALSE,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\r\n\"sms_text\": \"$message\",\r\n\"sender_id\": \"76054\",\r\n\"source\": \"18335210068\",\r\n\"mobile_number\": \"$phone_number\"\r\n\r\n}",
  CURLOPT_HTTPHEADER => array(
    "apikey: 2b731c8cdf8713eae8e30ae382eb43a3",
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 39676d49-3e38-2535-44e6-3a481f4b0808"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
 // echo $response."<hr>";
}     

//CUSTOMER SMS ENDS

echo "<b>Contract was sent successfully via SMS</b>";
}



if(isset($_POST['button_pressed']))
{
   //CUSTOMER EMAIL STARTS

$to_email = $user_email;
$subject = 'Contract Signature From MyMoneyLine';
$message = "Please Sign here by clicking on this link : ".$email_link;
$headers = 'From: support@mymoneyline.com';
mail($to_email,$subject,$message,$headers);
send_email_notification($to_email,$subject,$message);
//CUSTOMER EMAIL ENDS

echo " / <b>Contract was sent successfully via Email </b>";
}

?>
<br>
<iframe src="<?php echo $link; ?>" width="750" height="900" style="display:none;"></iframe>
<?php 
$i = 1;
if($i>0){
    
sleep(2);
  ?>
<iframe src="<?php echo $link; ?>" width="100%" height="900" style="display:none;"></iframe> 

<?php
}
?>
</div>

</body>
</html>