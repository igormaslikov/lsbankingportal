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


<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

<style>
.wrapper {
    width: 100%;
    max-width: 1340px;
    margin: 20px auto 100px auto;
    padding: 0;
    position: relative;
}
</style>
</head>

<body>

<?php include('menu.php') ;?>

    
  <div class ="container wrapper" style="margin-top:100px">

<h4>  DEBIT PAYMENT METHOD:</h4>

  <div class="row wrapper">

  <form action ="#" method="POST">
  
  <div class="col-lg-6" >
      <label for="usr"> PAYMENT METHOD TITLE </label>
      <input name="pay_method" type="text" class="form-control" id="usr" placeholder="" value="">
    </div>
  
 

  <div class="col-lg-6">
      <label for="usr"> ADDRESS </label>
      <input name="address" type="text" class="form-control" id="usr" placeholder="" value="">
    </div>

    <div class="col-lg-6">
      <label for="usr"> NAME ON CARD </label>
      <input name="name_card" type="text" class="form-control"  id="usr" placeholder="" value="">
    </div>
    
    <div class="col-lg-6" >
      <label for="usr"> ZIPCODE </label>
      <input name="zip_code" type="text" class="form-control" id="usr" placeholder="" value="">
    </div>
  
 

  <div class="col-lg-6">
      <label for="usr"> CARD NUMBER </label>
      <input name="card_number" type="text" class="form-control" id="usr" placeholder="" value="">
    </div>

    
    

 
<label for="usr" style="margin-left: 17px;"> CARD EXPIRES </label>
  <div class="row">
      
      <div class="col-lg-3">
      <select name="exp_month" class="form-control">
          <option value="01">01 - January</option>
          <option value="02">02 - February</option>
          <option value="03">03 - March</option>
          <option value="04">04 - April</option>
          <option value="05">05 - May</option>
          <option value="06">06 - June</option>
          <option value="07">07 - July</option>
          <option value="08">08 - August</option>
          <option value="09">09 - September</option>
          <option value="10">10 - October</option>
          <option value="11">11 - November</option>
          <option value="12">12 - December</option>
          
          </select>
    </div><div class="col-lg-3">
      <select name="exp_year" class="form-control">
          <option value="2019">2019</option>
          <option value="2020">2020</option>
          <option value="2021">2021</option>
          <option value="2022">2022</option>
          <option value="2023">2023</option>
          <option value="2024">2024</option>
          <option value="2025">2025</option>
          <option value="2026">2026</option>
          <option value="2027">2027</option>
          <option value="2028">2028</option>
          <option value="2029">2029</option>
          
         
          
          </select>
    </div>
    </div>


<div class="col-lg-6">
      <label for="usr"> CITY </label>
      <input name="city" type="text" class="form-control"  id="usr" placeholder="" value="">
    </div>
    
    
    <div class="col-lg-6">
      <label for="usr"> STATE </label>
      <input name="state" type="text" class="form-control"  id="usr" placeholder="" value="">
    </div>
    
     


 <div class="col-lg-6">
     <label for="usr"> CARD TYPE </label>
      <select name="card_type" class="form-control">
          <option value="">Please Select</option>
          <option value="Visa">Visa</option>
          <option value="MasterCard">MasterCard</option>
          <option value="American Express">American Express</option>
          <option value="Discover">Discover</option>
          
          </select>
    </div>
    
    <div class="col-lg-6">
     <label for="usr"> COUNTRY</label>
      <select name="country" class="form-control">
          <option value="United States">United States</option>
          <option value="Canada">Canada</option>
          </select>
    </div>
    
    
    
    </div>
      <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: #1E90FF;border-color: #1E90FF;">Save Payment Method</button>
  </form>
  
</div>
</div>

  </div></div>
   
<hr>

</body>
</html>     

<?php 

$created_by= $userRow['user_id'];

if(isset($_POST['btn-submit'])) {
 
$user_name = $_POST['user_name'];
$user_email= $_POST['user_email'];
$user_password= $_POST['user_password'];
$phone = $_POST['phone'];
$address= $_POST['address'];
$c_id= $_POST['c_id'];
$level_access=$_POST['level_access'];

$date = date('Y-m-d H:i:s');
 
    ?>
    
    
<?php
}

?>

<?php
}
?>