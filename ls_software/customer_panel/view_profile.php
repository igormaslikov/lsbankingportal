<?php
session_start();
include_once 'dbconnect.php';

if (!isset($_SESSION['customerSession'])) {
	header("Location: user_login.php");
}

$query = $DBcon->query("SELECT * FROM fnd_user_profile WHERE user_fnd_id=".$_SESSION['customerSession']);
$userRow=$query->fetch_array();
$id=$userRow['user_fnd_id'];
//echo $id;
$DBcon->close();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php $mail=$userRow['email']; echo $mail;  ?></title>

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />

</head>
<body>

<?php include('menu.php') ;?>

<div class ="container" style="margin-top:100px">

<h3> <b style="color:red"> Profile Detail </b> </h3>

  <div class="row">
      <div class="col-lg-12">
  <form action ="user_profile.php" method="POST">
      
<button  style ="background-image: linear-gradient(to bottom,blue 0,blue 100%);float:right;color: white;background-color: blue;border-radius: 0px;border-color: blue;"name="btn-submit" type="submit" class="btn btn-danger">Edit Profile</button>
    
    <div class="form-group" >
        
    <div class="row">
        
  </form>
  
</div>
</div>

  </div></div>
   
<hr>
 <style>
      .navbar-default{
          background-color:#fb3f06 !important;
      }
      
  </style>
</body>
</html>

<?php


include 'dbconnect.php';
include 'dbconfig.php';

$sql_source=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id='$id'"); 
echo "<table width='900'>";
while($row_source = mysqli_fetch_array($sql_source)) {

$first_name=$row_source['first_name'];
$middle_name=$row_source['middle_name']; 
$last_name=$row_source['last_name'];
$email=$row_source['email'];
$mobile_number=$row_source['mobile_number'];
$address=$row_source['address'];
$zip_code=$row_source['zip_code'];
$date_of_birth=$row_source['date_of_birth'];
$ssn=$row_source['ssn'];



echo "<td>" . "<b>First Name: </b>" . $first_name."<br>"."<b>Middle Name: </b>" . $middle_name."<br>". "<b>Last Name: </b>" . $last_name."<br>". "<b>Email: </b>" . $email."<br>"."<b>Mobile Number: </b>" . $mobile_number."<br>"."<b>Address: </b>" . $address."<br>"."<b>Zip Code: </b>" . $zip_code."<br>"."<b>Date Of Birth: </b>" . $date_of_birth."<br>". "<b>SSN: </b>" .$ssn."<br>".  "</td>" ;
}
echo "</table>";
?>






<?php

//....Source Income Table...//

include 'dbconnect.php';
include 'dbconfig.php';

$sql_source=mysqli_query($con, "select * from source_income where user_fnd_id='$id'"); 
echo "<table width='900'>";
while($row_source = mysqli_fetch_array($sql_source)) {

$emp_name=$row_source['employer_name'];
$emp_phone=$row_source['work_phone_no'];
$emp_position=$row_source['start_date'];
$how_paid=$row_source['pay_period'];
$last_pay_date=$row_source['last_pay_date'];
$next_pay_date=$row_source['next_pay_date'];
$income_month=$row_source['how_tell_ur_income'];


echo "<td>" . "<b>Employe Name: </b>" . $emp_name."<br>"."<b>Emp-Phone: </b>" . $emp_phone."<br>". "<b>Start Date: </b>" . $emp_position."<br>". "<b>How Pay: </b>" . $how_paid."<br>"."<b>Last Pay Date: </b>" . $last_pay_date."<br>"."<b>Next Pay Date: </b>" . $next_pay_date."<br>"."<b>Income: </b>" . $income_month."<br>".    "</td>" ;


}
echo "</table>";

//....Source Income Table END...//
?>



<?php


include 'dbconnect.php';
include 'dbconfig.php';

$sql_banking=mysqli_query($con, "select * from banking_information where user_fnd_id='$id'"); 
echo "<table width='900'>";
while($row_banking = mysqli_fetch_array($sql_banking)) {

$debit_card_number=$row_banking['card_number'];
$card_exp_date=$row_banking['expiry_date'];
$name_on_card=$row_banking['name_of_card'];
$zip_code=$row_banking['billing_zip_code'];
$cvv_number=$row_banking['routing_aba_number'];
$acc_number=$row_banking['account_number'];


echo "<td>" . "<b>Card Number: </b>" . $debit_card_number."<br>"."<b>Exp-Date: </b>" . $card_exp_date."<br>". "<b>Name On Card: </b>" . $name_on_card."<br>". "<b>Zip Code: </b>" . $zip_code."<br>"."<b>CVV Number: </b>" . $cvv_number."<br>"."<b>Account Number: </b>" . $acc_number."<br>".    "</td>" ;


}
echo "</table>";
?>
<div class="row">
<?php


include 'dbconnect.php';
include 'dbconfig.php';

$sql_bq=mysqli_query($con, "select * from binary_questions where user_fnd_id='$id'"); 
echo "<table width='900'>";
while($row_bq = mysqli_fetch_array($sql_bq)) {
    
    
    

 $ans=$row_bq['bq_answer'];
 echo "<td>" . "<b>Payment Method: </b>" . $ans."<br>". "</td>" ;
    

}


echo "</table>";

?>




<?php


include 'dbconnect.php';
include 'dbconfig.php';

$sql=mysql_query($con, "select * from binary_questions where user_fnd_id='$id'"); 
$query_count=mysql_query($sql);
    $per_page =25; //define how many games for a page
$count = mysql_num_rows($query_count);
$pages = ceil($count/$per_page);

if($_GET['page']==""){
$page="1";
}else{
$page=$_GET['page'];
}
$start    = ($page - 1) * $per_page;
$sql     = $sql." LIMIT $start,$per_page";
$query2=mysql_query($sql);
    
    

 
 echo $query2;
    




?>











</div>



























