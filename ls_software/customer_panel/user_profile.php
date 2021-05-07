<?php
session_start();
include_once 'dbconnect.php';

if (!isset($_SESSION['customerSession'])) {
	header("Location: user_login.php");
}

$query = $DBcon->query("SELECT * FROM fnd_user_profile WHERE user_fnd_id= ".$_SESSION['customerSession']);
$userRow=$query->fetch_array();
$id=$userRow['user_fnd_id'];
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

<link rel="stylesheet" href="css/style1.css">  
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="style.css" type="text/css" />
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


</head>
<body>

<?php include('menu.php') ;?>

<br>
<br>

  <section class="wrapper">
    <!-- Row title -->
    <!--END PERSONAL INFO --> 
<div align="right">

</div>
<br>
<b>Personal Information</b>
<br><br>

<main class="row title" style="background-color: blue; color:white">
      
  <ul style="font-weight: bold;">
        <li>First Name</li>
        <li>Email</li>
        <li>phone #</li>
        <li>SSN</li>
        <li>Address</li>
        <li>Action</li>
        
      </ul>
    </main>
     
    <tbody>

<?php


include 'dbconnect.php';

$sql=mysqli_query($DBcon, "select * from fnd_user_profile where user_fnd_id='$id'"); 

while($row = mysqli_fetch_array($sql)) {
    

$name=$row[7];
$email=$row[10];
$phone=$row[12];
$ssn=$row[16];
$mail_address=$row[13];
//$dob=$row[5];

?>

</tbody>
    
    <article class="row nfl" id="clr">
      <ul>

       <li><?php echo $name; ?></li>
        <li><?php echo $email; ?></li>
        <li><?php echo $phone; ?></li>
        <li><?php echo $ssn; ?></li>
        <li><?php echo $mail_address; ?></li>
        
        <li>

<?php
echo"<a href='edit_user_info.php?id=$id' title='Edit This Customer'><span class='glyphicon glyphicon-edit' aria-hidden='true' alt='edit'></span></a> &nbsp";
?>

        </li>
      </ul>
      
    </article>

<?php
}

?>    
    
    <article class="row nfl1">
    
    </article>
    
  </section>
  
   <!--END PERSONAL INFO --> 
  
   <!-- BANKING INFO --> 
  
 <section class="wrapper">
    <!-- Row title -->
    
<div align="right">

</div>
<b>Account Detail</b>
<br><br>

<main class="row title" style="background-color: blue; color:white">
      
  <ul style="font-weight: bold;">
        <li>Routing #</li>
        <li>Account #</li>
        <li>Card #</li>
        <li>Name On Card</li>
        <li>Expiry Date</li>
        <li>Action</li>
        
      </ul>
    </main>
     
    <tbody>

<?php



include 'dbconnect.php';

$sql=mysqli_query($DBcon, "select * from banking_information where user_fnd_id='$id'"); 

while($row = mysqli_fetch_array($sql)) {
    
$rout_num=$row[2];
$acc_num=$row[3];
$card_num=$row[5];
$name_card=$row[7];
$card_exp=$row[6];
$billing_zip=$row[8];

?>

</tbody>
    
    <article class="row nfl" id="clr">
      <ul>

       <li><?php echo $rout_num; ?></li>
        <li><?php echo $acc_num; ?></li>
        <li><?php echo $card_num; ?></li>
        <li><?php echo $name_card; ?></li>
        <li><?php echo $card_exp; ?></li>
         
        <li>

<?php
echo"<a href='edit_banking_info.php?id=$id' title='Edit This Customer'><span class='glyphicon glyphicon-edit' aria-hidden='true' alt='edit'></span></a> &nbsp";
?>

        </li>
      </ul>
      
    </article>

<?php
}

?>    
    
    <article class="row nfl1">
    
    </article>
    
  </section>
  
   <!--END BANKING INFO --> 
  
 <!-- SOURCE INCOME --> 
 
  <section class="wrapper">
    <!-- Row title -->
    
<div align="right">

</div>
<b>Income Detail</b>
<br><br>

<main class="row title" style="background-color:blue; color:white">
      
  <ul style="font-weight: bold;">
        <li>Employer Name</li>
        <li>Work ph#</li>
        <li>Pay Period</li>
        <li>Last Pay Date</li>
        <li>Last Pay Date</li>
        <li>Action</li>
        
      </ul>
    </main>
     
    <tbody>

<?php


include 'dbconnect.php';

$sql=mysqli_query($DBcon, "select * from source_income where user_fnd_id='$id'"); 

while($row = mysqli_fetch_array($sql)) {
    

$emp_name=$row[3];
$work_phone=$row[4];
$pay_period=$row[7];
$last_pay=$row[8];
$next_pay=$row[9];
//$billing_zip=$row[8];

?>

</tbody>
    
    <article class="row nfl" id="clr">
      <ul>

       <li><?php echo $emp_name; ?></li>
        <li><?php echo $work_phone; ?></li>
        <li><?php echo $pay_period; ?></li>
        <li><?php echo $last_pay; ?></li>
        <li><?php echo $next_pay; ?></li>
         
        <li>

<?php
echo"<a href='edit_emp_income.php?id=$id' title='Edit This Customer'><span class='glyphicon glyphicon-edit' aria-hidden='true' alt='edit'></span></a> &nbsp";
?>

        </li>
      </ul>
      
    </article>

<?php
}

?>    
    
    <article class="row nfl1">
    
    </article>
    
  </section>
  
   <!-- END SOUCR INCOME -->
  
   <!-- BINARY QUESTION -->
  
  <section class="wrapper">
    <!-- Row title -->
    
<div align="right">

</div>
<b>Mode Of Payment Detail</b>
<br><br>

<main class="row title" style="background-color: blue; color:white">
      
  <ul style="font-weight: bold;">
        <li>Mode Of Payment</li>
        
        <li>Action</li>
        
      </ul>
    </main>
     
    <tbody>

<?php


include 'dbconnect.php';

$sql=mysqli_query($DBcon, "select * from binary_questions where user_fnd_id='$id'"); 

while($row = mysqli_fetch_array($sql)) {
    
$bq_ques=$row['bq_answer'];


?>

</tbody>
    
    <article class="row nfl" id="clr">
      <ul>

       <li><?php echo $bq_ques; ?></li>
       
        <li>

<?php
echo"<a href='edit_binary_info.php?id=$id' title='Edit This Customer'><span class='glyphicon glyphicon-edit' aria-hidden='true' alt='edit'></span></a> &nbsp";
?>

        </li>
      </ul>
      
    </article>

<?php
}

?>    
    
    <article class="row nfl1">
    
    </article>
    
  </section>
  
  
    <!-- END BINARY QUESTION -->
  
  <style>
      .navbar-default{
          background-color:#fb3f06 !important;
      }
      
  </style>

</body>
</html>