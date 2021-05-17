<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

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
  $to_email= $_GET['email'];
  $email_link= $_GET['email_link'];
 echo "<br><br><br><br><br><br><br><br><br><br>";

                        
  
                          $message = $email_link;
                          send_sms($phone_number,$message); 
                          $subject="Contract Signature From MyMoneyLine";
                          $message_contract = "Please Sign here by clicking on this link : ".$email_link;
                          send_email_notification($to_email,$subject,$message_contract);
                          
                         $date= date('Y-m-d H:i:s');
                         $query_update_status= "INSERT INTO `application_status_updates`( `application_id`, `user_id`, `status`, `creation_date`) VALUES ('$cu_id','$u_id','Contract was sent successfully Via SMS','$date')";
                         echo   $query_update_status;     


	                      $result_status_update = mysqli_query($con, $query_update_status);
                          if ($result_status_update) {
                          // echo "<div class='form'><h3> successfully added in application_status_updates.</h3><br/></div>";
                           } else {
                          echo "<h3> Error Inserting Data </h3>";
                                   }
  ?>
  
  <br><br><br><br>
  <h2 align="center"> Congratulations message has been sent to customer </h2>
   
  <a href="customer_email_message.php?emaill=<?php echo $_GET['email'];?>&mobile_number=<?php echo $_GET['phone'];?>&link=<?php echo $_GET['link'];?>&email_link=<?php echo $_GET['email_link'];?>&user_fnd_id=<?php echo $_GET['id'];?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;center;margin-left: 45%;margin-top: 2%;">Go Back</button> </a>

  </html>
  </body>
<?php
}
?>

    
  