<?php
session_start();
include_once 'dbconnect.php';
include_once 'dbconfig.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$u_id=$userRow['user_id'];
//echo $u_id;
$u_access_id = $userRow['access_id'];
if($u_access_id=='0'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
}
else {
$DBcon->close();

?>
<?php

$cu_id=$_GET['fnd_id'];
$first_name= $_GET['f_name']; 
$ssn=$_GET['cu_ssn'];
$ssn=$_GET['cu_ssn'];
$next_pay_date=$_GET['next_pay_date'];
$loan_amount=$_GET['loan_amount'];
$state=$_GET['state'];
$loan_type=$_GET['loan_type'];
//echo "<br><br><br><br><br><br><br><br><br><br>Name Is: $name_id";
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['email']; ?></title>

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<style>
.wrapper {
    width: 100%;
    max-width: 1330px;
    margin: 20px auto 100px auto;
    padding: 0;
    position: relative;
}
</style>
</head>

<body>

<?php include('menu.php') ;?>

  <div class ="container wrapper" style="margin-top:100px">
      
  <div class="row wrapper">
<?php

$sql_count_loans = "SELECT * FROM tbl_loan";
if ($result_count_loans=mysqli_query($con,$sql_count_loans))
  {
  // Return the number of rows in result set
  $rowcount_count_loans=mysqli_num_rows($result_count_loans)+71019;
  
  $rowcount_count_loans= $rowcount_count_loans-100;
  //echo "<br><br><br><br><br>".$rowcount_count_loans;
  }
?>

<div align="center">

<?php 
  if ($loan_type == "payday"){
   ?> 
    <a href="add_new_loan.php?id=<?php echo $cu_id ;?>&loan_amount=<?php echo $loan_amount; ?>&name=<?php echo $first_name;?>&ssn=<?php echo $ssn; ?>&loan=<?php echo "Payday Loans"; ?>&next_pay_date=<?php echo "$next_pay_date"; ?>&loan_amount=<?php echo "$loan_amount"; ?>&state=<?php echo $state;?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#95c500 0,#639a0a 100%); 
    color: #fff;background-color: #2a8206;border-color: #112f01;height: 100px; width:14%;"><b style="text-align: center;line-height: 85px;">Create a Payday Loan</b></button> </a>
  <?php
  }
  if ($loan_type == "commercial"){
    ?>
    <a href="add_commercial_loan.php?id=<?php echo $cu_id ;?>&loan_amount=<?php echo $loan_amount; ?>&name=<?php echo $first_name;?>&ssn=<?php echo $ssn; ?>&loan=<?php echo "Commercial Loan"; ?>&next_pay_date=<?php echo "$next_pay_date"; ?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#95c500 0,#639a0a 100%); 
    color: #fff;background-color: #2a8206;border-color: #112f01;height: 100px; width:15%;"><b style="text-align: center;line-height: 85px;">Create a Commercial Loan</b></button> </a>
  <?php
  }
  ?>

  
  <!-- <a href="add_commercial_loan.php?id=<?php echo $cu_id ;?>&loan_amount=<?php echo $loan_amount; ?>&name=<?php echo $first_name;?>&ssn=<?php echo $ssn; ?>&loan=<?php echo "Commercial Loan"; ?>&next_pay_date=<?php echo "$next_pay_date"; ?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#95c500 0,#639a0a 100%); 
    color: #fff;background-color: #2a8206;border-color: #112f01;height: 100px; width:15%;"><b style="text-align: center;line-height: 85px;">Create a Commercial Loan</b></button> </a>
  
  <a href="add_personal_loan.php?id=<?php echo $cu_id ;?>&loan_amount=<?php echo $loan_amount; ?>&name=<?php echo $first_name;?>&ssn=<?php echo $ssn; ?>&loan=<?php echo "Personal Loans"; ?>&next_pay_date=<?php echo "$next_pay_date"; ?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#95c500 0,#639a0a 100%); 
    color: #fff;background-color: #2a8206;border-color: #112f01;height: 100px; width:14%;"><b style="text-align: center;line-height: 85px;">Create a Personal Loan</b></button> </a>
  
  <a href="add_title_loan.php?id=<?php echo $cu_id ;?>&loan_amount=<?php echo $loan_amount; ?>&name=<?php echo $first_name;?>&ssn=<?php echo $ssn; ?>&loan=<?php echo "Title Loans"; ?>&next_pay_date=<?php echo "$next_pay_date"; ?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#95c500 0,#639a0a 100%); 
    color: #fff;background-color: #2a8206;border-color: #112f01;height: 100px; width:14%;"><b style="text-align: center;line-height: 85px;">Create a Title Loan</b></button> </a> -->
    

    
    
    </div>
  
</div>
</div>

<hr>




</body>
</html>     
<?php
}
?>