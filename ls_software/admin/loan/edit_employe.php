<?php
error_reporting(0);
session_start();
$id=$_GET['id'];
include_once '../dbconnect.php';
include_once '../dbconfig.php';
if (!isset($_SESSION['userSession'])) {
	header("Location: ../index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$u_id=$userRow['user_id'];
$u_access_id = $userRow['access_id'];
if($u_access_id=='2' || $u_access_id=='4' || $u_access_id=='5'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}
else {
$DBcon->close();

?>
<?php



$sql_fnd=mysqli_query($con, "select * from tbl_loan where loan_id = '$id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];
//echo "FND_ID" .$user_fnd_id;
}

?>

<?php


$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];
$last_name=$row['last_name'];
$customer_numbr=$row['mobile_number'];


}

//echo "fname is:".$first_name;

?>




<?php



$sql=mysqli_query($con, "select * from tbl_loan where user_fnd_id= '$user_fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$loan_id=$row['loan_id'];
//echo "fndid is:".$fnd_id;
$amount_loan=$row['amount_of_loan'];

//echo "Amount is:".$amount_loan;

$amount_left =$row['loan_total_payable'];
$bg_id=$row['bg_id'];
$next_payment =$row['payment_date'];
$payment_tenure =$row['payment_tenure'];
$escrow=$row['escrow'];
$primary_port=$row['primary_portfolio'];
$creation_date=$row['creation_date'];
$created_by=$row['created_by'];
$last_update=$row['last_update_by'];
$last_update_date=$row['last_update_date'];

 $timestamp = strtotime($creation_date);
 
// Creating new date format from that timestamp
$new_creation_date= date("m-d-Y", $timestamp);
}

?>

<?php


$sql_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$username=$row_user['username'];

}

//echo "fname is:".$username;

?>



<?php

$id_src=$_GET['id_src'];

$sql_user=mysqli_query($con, "select * from source_income where scr_inc_id= '$id_src'"); 

while($row_user = mysqli_fetch_array($sql_user)) {
$user_fnd_id=$row_user['user_fnd_id'];
$emp_name=$row_user['employer_name'];
$emp_phone=$row_user['work_phone_no'];
$net_check_amount=$row_user['net_check_amount'];
$direct_deposit=$row_user['direct_deposit'];
$how_paid=$row_user['pay_period'];
$week_day=$row_user['week_day'];
$last_pay_date=$row_user['last_pay_date'];
$next_pay_date=$row_user['next_pay_date'];

}



?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">


  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/simple-sidebar.css" rel="stylesheet">

</head>
<body>
  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading"> </div>
      <div class="list-group list-group-flush">
 
        <?php include('vertical_menu.php'); ?>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <?php include('horizontal_menu.php'); ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

       
      </nav>
      <br>
     <?php
     include '../functions.php';
     
     if(isset($_POST['btn-submit'])) 
{
    $form_name="payday-".basename(__FILE__);
      $calculation_type= $_POST['calculation_type'];
    
    $employer_name_update =$_POST['employer_name'];
$work_phone_update =$_POST['work_phone'];
$direct_deposit_update =$_POST['payment'];
$net_amount_update =$_POST['net_amount'];
$pay_fre_update =$_POST['get_paid'];
$week_day_update =$_POST['week_day'];
$last_date_update=$_POST['last_check'];
$next_date_update=$_POST['next_check'];
$date= date('Y-m-d H:i:s');

$sql_role=mysqli_query($con, "select * from access_form where form_name='$form_name'"); 


while($row_role = mysqli_fetch_array($sql_role)) {

 $form_id=$row_role['id'];
 
}
   $update_allowed = user_edit_roles($u_access_id,$form_id);
    
    
    if ($update_allowed==1)
{
     
     
       mysqli_query($con,"UPDATE source_income SET employer_name ='$employer_name_update', work_phone_no ='$work_phone_update', net_check_amount ='$net_amount_update', direct_deposit='$direct_deposit_update', pay_period='$pay_fre_update',week_day='$week_day_update', last_pay_date='$last_date_update', next_pay_date='$next_date_update', last_update_by='$u_id', last_update_date='$date'  where scr_inc_id ='$id_src' ");

      ?>
   <script type="text/javascript">
window.location.href = 'employer_detail.php?id=<?php echo $id; ?>';
</script>    
      
 <?php
 
}



else{
  echo "<script type='text/javascript'>
window.location.href = '../not_authorize.php';
</script>";
}
}
 ?><br><br>
      <div class="container-fluid">
          <h3>Update This Job: </h3>
         <br>
      <div class="col-lg-12">
  <form action ="#" method="POST">
    <div class="form-group" >
        
         <div class="row">
 
    <div class="col-lg-4">
      <label for="usr">Employer Name</label>
 <input type="text" name="employer_name"  class="form-control" id="usr" value="<?php echo $emp_name; ?>">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Work Phone Number</label>
 <input type="tel" name="work_phone"  class="form-control" id="usr" placeholder="Format:123-456-7890" value="<?php echo $emp_phone; ?>" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
    </div>
    
   
    
	<div class="col-lg-2">
      <label for="usr">Net Check Amount</label>
 <input type="text" name="net_amount"  class="form-control" id="usr" placeholder="" value="<?php echo $net_check_amount; ?>">
    </div>
	
     <div class="col-lg-2">
      <label for="usr"> Direct Deposit</label>
<select name="payment" id="payment" class="form-control">
    <option></option>
<option value="Yes" <?php if($direct_deposit=='Yes'){ echo 'selected';} ?>>Yes</option>
<option value="No"  <?php if($direct_deposit=='No'){ echo 'selected';} ?>>No</option>

</select>
    </div>

    	

<div class="col-lg-4">
      <label for="usr">How often do you get paid?</label>
 <select name="get_paid" id="get_paid" class="form-control">
     <option></option>
<option value="Weekly" <?php if($how_paid=='Weekly'){ echo 'selected';} ?>>Weekly</option>
<option value="Bi-Weekly" <?php if($how_paid=='Bi-Weekly'){ echo 'selected';} ?>>Bi-Weekly</option>
<option value="Semi Monthly" <?php if($how_paid=='Semi Monthly'){ echo 'selected';} ?>>Semi Monthly</option>
<option value="Monthly" <?php if($how_paid=='Monthly'){ echo 'selected';} ?>>Monthly</option>

</select>
 
    </div>

<div class="col-lg-4">
  <label for="week_day">Week Day</label>
  <!-- <select name="week_day" id="week_day_id" class ="form-control"></select>
  <option value=""></option>
  <option value="Sunday" <?php if($week_day=='Sunday'){ echo 'selected';} ?>>Sunday</option>
  <option value="Monday"<?php if($week_day=='Monday'){ echo 'selected';} ?>>Monday</option>
  <option value="Tuseday"<?php if($week_day=='Tuseday'){ echo 'selected';} ?>>Tuseday</option>
  <option value="Wednesday"<?php if($week_day=='Wednesday'){ echo 'selected';} ?>>Wednesday</option>
  <option value="Thursday"<?php if($week_day=='Thursday'){ echo 'selected';} ?>>Thursday</option>
  <option value="Friday"<?php if($week_day=='Friday'){ echo 'selected';} ?>>Friday</option>
  <option value="Saturday"<?php if($week_day=='Saturday'){ echo 'selected';} ?>>Saturday</option>
  </select> -->

  <input type="text" list="week_day_id" class="form-control" name="week_day" value="<?php echo $week_day; ?>"/>
  <datalist id="week_day_id" >
    <option value=""></option>
    <option value="Sunday" <?php if($week_day=='Sunday'){ echo 'selected';} ?>>Sunday</option>
    <option value="Monday"<?php if($week_day=='Monday'){ echo 'selected';} ?>>Monday</option>
    <option value="Tuseday"<?php if($week_day=='Tuseday'){ echo 'selected';} ?>>Tuseday</option>
    <option value="Wednesday"<?php if($week_day=='Wednesday'){ echo 'selected';} ?>>Wednesday</option>
    <option value="Thursday"<?php if($week_day=='Thursday'){ echo 'selected';} ?>>Thursday</option>
    <option value="Friday"<?php if($week_day=='Friday'){ echo 'selected';} ?>>Friday</option>
    <option value="Saturday"<?php if($week_day=='Saturday'){ echo 'selected';} ?>>Saturday</option>
  </datalist>
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
    
    </div>

    <br>
        
      <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: white;background-color: #1E90FF;border-radius: 0px;border-color: #1E90FF;">Update this job</button>
  </form>

</div>
</div>

  </div>
  <br>
      


    
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
<?php
}
?>
</body>

</html>
