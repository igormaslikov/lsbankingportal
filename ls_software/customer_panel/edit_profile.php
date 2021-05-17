<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

if (!isset($_SESSION['customerSession'])) {
	header("Location: user_login.php");
}

$query = $DBcon->query("SELECT * FROM fnd_user_profile WHERE user_fnd_id=".$_SESSION['customerSession']);
$userRow=$query->fetch_array();
$u_id=$userRow['userid'];
$DBcon->close();

?>

<?php

$id=$_GET['id'];

include $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';


$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];
$middle_name =$row['middle_name'];
$last_name =$row['last_name'];
$customer_phone =$row['mobile_number'];
$customer_email =$row['email'];
$address=$row['address'];
$dob=$row['date_of_birth'];
$ssn=$row['ssn'];

}

?>

<?php
$id=$_GET['id'];

include $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';


$sql_banking=mysqli_query($con, "select * from banking_information where user_fnd_id= '$id'"); 

while($row_banking = mysqli_fetch_array($sql_banking)) {

$debit_card_number=$row_banking['card_number'];
$card_exp_date=$row_banking['expiry_date'];
$name_on_card=$row_banking['name_of_card'];
$zip_code=$row_banking['billing_zip_code'];
$cvv_number=$row_banking['routing_aba_number'];
$acc_number=$row_banking['account_number'];

}

?>

<?php

$id=$_GET['id'];

include $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';


$sql_source=mysqli_query($con, "select * from source_income where user_fnd_id= '$id'"); 

while($row_source = mysqli_fetch_array($sql_source)) {

$emp_name=$row_source['employer_name'];
$emp_phone=$row_source['work_phone_no'];
$emp_position=$row_source['start_date'];
$how_paid=$row_source['pay_period'];
$last_pay_date=$row_source['last_pay_date'];
$next_pay_date=$row_source['next_pay_date'];
$income_month=$row_source['how_tell_ur_income'];
}

?>

<?php

$id=$_GET['id'];

include $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';


$sql_bq=mysqli_query($con, "select * from binary_questions where user_fnd_id= '$id'"); 

while($row_bq = mysqli_fetch_array($sql_bq)) {
    
$mode_payment=$row_bq['bq_answer'];

}

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

<div class ="container" style="margin-top:100px">

<h4>  Editing Customer: <b style="color:red"> <?php echo $first_name; ?></b> </h4>

  <div class="row">
      <div class="col-lg-12">
  <form action ="#" method="POST">
    <div class="form-group" >
    <div class="row">
      
  <div class="col-lg-4" >
      <label for="usr">First Name</label>
      <input name="first_name" type="text" class="form-control" id="usr" value="<?php echo $first_name; ?>">
    </div>
  
  <div class="col-lg-4">
      <label for="usr">Middle Name</label>
      <input name="middle_name" type="text" class="form-control" id="usr" placeholder="" value="<?php echo $middle_name; ?>">
    </div>

    <div class="col-lg-4">
      <label for="usr">Last Name</label>
      <input name="last_name" type="text" class="form-control"  id="usr" placeholder="" value="<?php echo $last_name; ?>">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Phone Number</label>
      <input name="phone_number" type="text" class="form-control"  id="usr" placeholder="" value="<?php echo $customer_phone; ?>">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Email</label>
      <input name="email" type="text" class="form-control"  id="usr" placeholder="" value="<?php echo $customer_email; ?>">
    </div>
    
    </div>
     <h3>Pre Qualification</h3>
    <div class="row">
       
    <div class="col-lg-6">
      <label for="usr">How would you like to tell us your income?  </label>
      <select name="income_month" id="income_month" class="form-control"  value="<?php echo $income_month; ?>">
<option value="Per Month" <?php if($income_month=='Per Month'){ echo 'selected';} ?>>Per Month</option>
<option value="Per Paycheck" <?php if($income_month=='Per Paycheck'){ echo 'selected';} ?>>Per Paycheck</option>

</select>
    </div>
    
    <div class="col-lg-6">
      <label for="usr"> Mode of Payment</label>
<select name="payment" id="payment" class="form-control"  value="<?php echo $mode_payment; ?>">
<option value="Direct Deposit" <?php if($mode_payment=='Direct Deposit'){ echo 'selected';} ?>>Direct Deposit</option>
<option value="Check" <?php if($mode_payment=='Check'){ echo 'selected';} ?>>Check</option>
<option value="Cash"  <?php if($mode_payment=='Cash'){ echo 'selected';} ?>>Cash</option>
<option value="Military"  <?php if($mode_payment=='Military'){ echo 'selected';} ?>>Military</option>
<option value="Disability/Workers Compensation"  <?php if($mode_payment=='Disability/Workers Compensation'){ echo 'selected';} ?>>Disability/Workers Compensation</option>

</select>
    </div>
    
    </div>
     <h3>Personal  Information</h3>
    <div class="row">
       
     <div class="col-lg-4">
      <label for="usr">Address</label>
      <input type="text" name="address"  class="form-control" id="usr" value="<?php echo $address; ?>">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">DOB</label>
      <input type="date" name="dob"  class="form-control" id="usr" value="<?php echo $dob; ?>">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">SSN/ITIN</label>
      <input type="text" name="ssn"  class="form-control" id="usr" value="<?php echo $ssn; ?>">
    </div>

    
    </div>
    <h3>Employment Info</h3>
    <div class="row">
 
    <div class="col-lg-4">
      <label for="usr">Employer Name</label>
 <input type="text" name="employer_name"  class="form-control" id="usr" value="<?php echo $emp_name; ?>">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Work Phone Number</label>
 <input type="text" name="work_phone"  class="form-control" id="usr" value="<?php echo $emp_phone; ?>">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">When Did You Begin Working There?</label>
 <input type="date" name="working"  class="form-control" id="usr" value="<?php echo $emp_position; ?>">
    </div>

<div class="col-lg-4">
      <label for="usr">How often do you get paid?</label>
 <input type="text" name="get_paid"  class="form-control" id="usr" value="<?php echo $how_paid; ?>">
    </div>

<div class="col-lg-4">
      <label for="usr">Last Paycheck Date</label>
 <input type="date" name="last_check"  class="form-control" id="usr" value="<?php echo $last_pay_date; ?>">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Next Paycheck Date</label>
 <input type="date" name="next_check"  class="form-control" id="usr" value="<?php echo $next_pay_date; ?>">
    </div>

    </div>

    <h3>Get Fund</h3>
      <div class="row">
 
    
         <div class="col-lg-4">
      <label for="usr">Card Number</label>
      <input type="text" name="card_number"  class="form-control" id="usr" value="<?php echo $debit_card_number; ?>">
    </div>
    
     <div class="col-lg-4">
      <label for="usr"> Exp Date</label>
      <input type="date" name="exp_date"  class="form-control" id="usr" value="<?php echo $card_exp_date; ?>">
    </div>
   
    <div class="col-lg-4">
      <label for="usr">Name on card</label>
      <input type="text" name="name_on_Card"  class="form-control" id="usr" value="<?php echo $name_on_card; ?>">
    </div>


 <div class="col-lg-4">
      <label for="usr"> Account Number </label>
      <input type="number" name="acc_number"  class="form-control" id="usr" value="<?php echo $acc_number; ?>">
    </div>

    <div class="col-lg-4">
      <label for="usr"> ZIP Code </label>
      <input type="number" name="zip_code"  class="form-control" id="usr" value="<?php echo $zip_code; ?>">
    </div>

     <div class="col-lg-4">
      <label for="usr"> CVV Number </label>
      <input type="number" name="cvv_number"  class="form-control" id="usr" value="<?php echo $cvv_number; ?>">
    </div>

    </div>
    <br>
        
      <button  style ="color: white;
    background-color: #fb3f06;
    border-radius: 0px;
    border-color: #fb3f06;"name="btn-submit" type="submit" class="btn btn-danger">Update</button>
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

if(isset($_POST['btn-submit'])) {
    
$first_name_update =$_POST['first_name'];
$middle_name_update =$_POST['middle_name'];
$last_name__update =$_POST['last_name'];
$phone_number_update = $_POST['phone_number'];
$email_update =$_POST['email'];
$state_update =$_POST['state'];
$monthly_income_update =$_POST['monthly_income'];
$payment_update =$_POST['payment'];
$address_update =$_POST['address'];
$dob_update =$_POST['dob'];
$ssn_update =$_POST['ssn'];
$income_month_update=$_POST['income_month'];
$employer_name_update =$_POST['employer_name'];
$work_phone_update =$_POST['work_phone'];
$working_update =$_POST['working'];
$get_paid_update =$_POST['get_paid'];
$last_check_update =$_POST['last_check'];
$next_check =$_POST['next_check'];
$card_number_update =$_POST['card_number'];
$exp_date_update =$_POST['exp_date'];
$name_on_Card_update =$_POST['name_on_Card'];
$zip_code_update =$_POST['zip_code'];
$cvv_number_update =$_POST['cvv_number'];
$acc_number_update =$_POST['acc_number'];

$date = date('Y-m-d H:i:s');

mysqli_query($con, "UPDATE fnd_user_profile SET first_name ='$first_name_update' , middle_name='$middle_name_update' , last_name='$last_name__update' , mobile_number='$phone_number_update' , email='$email_update', address='$address_update', date_of_birth='$dob_update', ssn='$ssn_update', last_update_by='$u_id',last_update_date='$date' where user_fnd_id ='$id'"); 

mysqli_query($con, "UPDATE banking_information SET account_number='$acc_number_update', card_number ='$card_number_update' , expiry_date='$exp_date_update' , name_of_card='$name_on_Card_update' , billing_zip_code='$zip_code_update' , routing_aba_number='$cvv_number_update', last_update_by='$u_id',last_update_date='$date' where user_fnd_id ='$id'");   

mysqli_query($con, "UPDATE source_income SET how_tell_ur_income='$income_month_update' , employer_name ='$employer_name_update' , work_phone_no='$work_phone_update' , pay_period='$get_paid_update' , last_pay_date='$last_check_update' , next_pay_date='$next_check', start_date='$working_update', last_update_by='$u_id',last_update_date='$date' where user_fnd_id ='$id'");   
    
mysqli_query($con, "UPDATE binary_questions SET bq_answer ='$payment_update', creation_date='$date', last_update_date='$date', last_update_by='$u_id',last_update_date='$date' where user_fnd_id ='$id'");   
        
    ?>
    
    <script type="text/javascript">
window.location.href = 'user_profile.php';
</script>
<?php
}


?>