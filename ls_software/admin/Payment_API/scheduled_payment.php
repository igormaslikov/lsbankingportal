<?php
error_reporting(0);
session_start();
include_once 'dbconnect.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_api_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$DBcon->close();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Optima Financial Solutions Inc Registration</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="style.css" type="text/css" />

</head>
<body>
<?php include('menu.php') ;?>
<div class="signin-form">

	<div class="container">
     
        
       <form action="schedule_payment_API.php" class="form-signin" method="POST" id="register-form">
      
        <h2 class="form-signin-heading" style="font-size:23px">Set Up A Scheduled Payment With A Card</h2><hr />
        
        <?php
		if (isset($msg)) {
			echo $msg;
		}
		?>
          
        <div class="form-group">
            <label for="fname">Cardholder Name*</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Cardholder Name..">
        </div>
        
        <div class="form-group">
            <label for="fname">Customer ID*</label>
    <input type="text" class="form-control" id="customer_id" name="customer_id" placeholder="Customer ID..">
        </div>
        
        <div class="form-group">
        <label for="fname">Amount*</label>
    <input type="text" id="amount" class="form-control" name="amount" placeholder="Amount..">    
        </div>
        
        <div class="form-group">
        <label for="lname">Card Number*</label>
        <input type="text" id="card" class="form-control" name="card" placeholder="Card Number..">
        </div>
        
         <div class="form-group">
        <label for="lname">Card CVV*</label>
    <input type="text" id="cvv" class="form-control" name="cvv" placeholder="Card cvv..">
        </div>
        
        <div class="form-group">
        <label for="lname">Expiration Date*</label><br>
     Month 
      <select style="width:20%" name="expiry_month_card" id="expiry_month_card" class="form-control"  value="" required>
     <option></option>
     <option value="01">01</option>
     <option value="02">02</option>
     <option value="03">03</option>
     <option value="04">04</option>
     <option value="05">05</option>
     <option value="06">06</option>
     <option value="07">07</option>
     <option value="08">08</option>
     <option value="09">09</option>
     <option value="10">10</option>
     <option value="11">11</option>
     <option value="12">12</option>
     </select>
     
     Year
      <select  style="width:20%" name="expiry_year_card" id="expiry_year_card" class="form-control"  value="" required>
     <option></option>
     <option value="21">21</option>
     <option value="22">22</option>
     <option value="23">23</option>
     <option value="24">24</option>
     <option value="25">25</option>
     <option value="26">26</option>
     <option value="27">27</option>
     <option value="28">28</option>
     <option value="29">29</option>
     <option value="30">30</option>
     </select>
        </div>
        
       
        
        <div class="form-group">
        <label for="lname">Schedule From</label>
    <input type="date" id="date" class="form-control" name="date_from" placeholder="">
        </div>
        
        <div class="form-group">
        <label for="lname">Schedule To</label>
    <input type="date" id="date" class="form-control" name="date_to" placeholder="">
        </div>
        
         <div class="form-group">
         <label for="lname">Schedule Frequency</label>
    <select name="frequency" id="frequency" class="form-control">
        <option value="MONTHLY">Monthly</option>
        <option value="BIWEEKLY">Bi-Weekly</option>
        <option value="WEEKLY">Weekly</option>
    </select>
        </div>
        
          <div class="form-group">
            <label for="fname">Zip Code*</label>
    <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Zip Code..">
        </div>
        
     	<hr />
        
        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-scheduled">
    		<span class=""></span> &nbsp; Scheduled Now
			</button> 
        </div> 
      
      </form>

    </div>
    
</div>

</body>
</html>