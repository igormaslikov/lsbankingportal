<?php
error_reporting(0);
session_start();
include_once '../dbconnect.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: ../index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
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

<?php include('../menu.php') ;?>
    <br><br><br>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="js/scripts.js"></script>
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
    
 #rcorners1 {
  border-radius: 25px; 
 }
 
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

    
  <div class ="container wrapper" style="margin-top:10px;border:2px solid black" id="rcorners1">


  <div class="row wrapper">

  <form action ="#" method="POST">
  
  
  <!-- <input name="id_type" type="text" class="form-control" id="usr" placeholder="" value="<?php echo $id_type;?>">-->

  <div class="col-lg-3" id="rcorners1">
  <label for="usr"> Select Loan Type :   </label>
       <select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" style="width: 220px;height: 33px;" id="" class="form-control">
    <option value=""></option>
    <option value="https://ofsca.com/loanportal/ls_software/admin/calculator/payday_loan.php" >Payday Loan</option>
    <option value="https://ofsca.com/loanportal/ls_software/admin/calculator/personal_loan.php" selected>Personal Loan</option>
</select>

    </div>
<br> <br>
<h4><hr>&nbsp;&nbsp;Personal Loan Calculator</h4>
<br>
    <div class="col-lg-2" id="rcorners1">
      <label for="usr"> Loan Amount </label>
      <input name="loan_amount" type="text" class="form-control"  id="usr" placeholder="" value="<?php echo  $_POST['loan_amount'];?>">
    </div>
    
     
<div class="col-lg-1" style="margin-left: -7%;" id="rcorners1">
      <label for="usr"> USD </label>
     <select name="usd" class="form-control">
        <option>USD</option>
 
        </select>
    </div>
    
    <br> <br> <br>
     <div class="col-lg-2" id="rcorners1">
      <label for="usr">Interest rate (%)</label>
<input name="int_rate" type="text" class="form-control"  id="usr" placeholder="" value="<?php echo  $_POST['int_rate'];?>">
    </div>
    
    <br> <br> <br>
    
    <div class="col-lg-2" id="rcorners1">
      <label for="usr"> Time/Months </label>
      <input name="months" type="text" class="form-control"  id="usr" placeholder="" value="<?php echo $_POST['months']; ?>">
    </div>
    
     

    
    
<br> <br> <br>
    <label for="usr"></label>
    
    </div>
<br>
      <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: #1E90FF;border-color: #1E90FF;margin-left: 9px;margin-bottom: 2px;">Calculate</button>
  </form>
  
  <?php 
  if (isset($_POST['btn-submit'])){
      //echo 'hello';
  $loan_amount = $_POST['loan_amount'];
  $int_rate = $_POST['int_rate'];
  $int_rate = $int_rate/1000;
  $months = $_POST['months'];
  $one_plus_int = 1 + $int_rate;
  
  $n_value = pow($one_plus_int,$months);
  $calculation = $int_rate * $n_value ;
  $calculation_1 = $n_value - 1;
  $calculation_final = $calculation/$calculation_1;
  $calculation_final_1 = $loan_amount * $calculation_final ;
  $calculation_final_1 = round($calculation_final_1,2 );
  
  $total_payment = $calculation_final_1 * $months;
  $total_payment = round($total_payment, 2);
  //L[c(1 + c)n]/[(1 + c)n - 1]
  //echo $calculation_final_1;
//  echo $n_value;
//echo(pow(2,4) . "<br>");

//echo(pow(4,4) . "<br>");
  ?>
  <br><br>
   <div class="col-lg-4" style="border:1px solid grey;"  id="rcorners1"><h4>Monthly Payment = <?php echo $calculation_final_1 ?></h4></div>
 
    <div class="col-lg-4" style="border:1px solid grey;"  id="rcorners1"><h4>Total Payment = <?php echo $total_payment ?></h4></div>
    <br><br> <br><br>
  <?php
  
  }
  
  ?>
   
</div>

</div>

  </div></div>
  

</body>
</html>     