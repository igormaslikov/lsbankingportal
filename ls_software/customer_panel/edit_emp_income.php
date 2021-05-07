<?php
session_start();
include_once 'dbconnect.php';

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

include 'dbconnect.php';
include 'dbconfig.php';

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

<h4>  Editing Employer Info: <b style="color:red"> <?php echo $emp_name; ?></b> </h4>

  <div class="row">
  <div class="col-lg-12">
  <form action ="#" method="POST">
    <div class="form-group" >
    <div class="row">
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
    <br>
        
      <button  style ="background-image: linear-gradient(to bottom,blue 0,blue 100%);color: white;background-color: blue;border-radius: 0px;border-color: blue;"name="btn-submit" type="submit" class="btn btn-danger">Update</button>
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
    

$employer_name_update =$_POST['employer_name'];
$work_phone_update =$_POST['work_phone'];
$working_update =$_POST['working'];
$get_paid_update =$_POST['get_paid'];
$last_check_update =$_POST['last_check'];
$next_check =$_POST['next_check'];


$date = date('Y-m-d H:i:s');


mysqli_query($con, "UPDATE source_income SET how_tell_ur_income='$income_month_update' , employer_name ='$employer_name_update' , work_phone_no='$work_phone_update' , pay_period='$get_paid_update' , last_pay_date='$last_check_update' , next_pay_date='$next_check', start_date='$working_update', last_update_by='$u_id',last_update_date='$date' where user_fnd_id ='$id'");   
    
?>
    
    <script type="text/javascript">
window.location.href = 'user_profile.php';
</script>
<?php
}

?>