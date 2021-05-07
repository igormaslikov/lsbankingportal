<?php
error_reporting(0);
session_start();
include_once '../dbconnect.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: ../index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$u_id=$userRow['user_id'];
$u_access_id = $userRow['access_id'];
if($u_access_id!='1'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}
else {
$DBcon->close();

?>

<?php

include_once '../dbconnect.php';
include_once '../dbconfig.php';

 $id=$_GET['id'];
 
$sql_fnd=mysqli_query($con, "select * from tbl_personal_loans where p_loan_id = '$id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];
$loan_create_id=$row_fnd['loan_create_id'];
//echo "FND_ID" .$user_fnd_id;
}





$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];
$last_name=$row['last_name'];
$customer_numbr=$row['mobile_number'];


}



$sql=mysqli_query($con, "select * from tbl_personal_loans where p_loan_id= '$id'"); 

while($row = mysqli_fetch_array($sql)) {

$loan_id=$row['loan_id'];
//echo "fndid is:".$fnd_id;
$amount_loan=$row['principal_amount'];
$amount_loan = number_format((float)$amount_loan, 2, '.', '');

//echo "Amount is:".$amount_loan;

$amount_left =$row['loan_total_payable'];
$bg_id=$row['bg_id'];
$next_payment =$row['payment_date'];
$payment_tenure =$row['payment_tenure'];
$escrow=$row['escrow'];
$primary_port=$row['primary_portfolio'];
$creation_date=$row['contract_date'];
$created_by=$row['created_by'];
$last_update=$row['last_update_by'];
$last_update_date=$row['last_update_date'];

 $timestamp = strtotime($creation_date);
 
// Creating new date format from that timestamp
$new_creation_date= date("m-d-Y", $timestamp);
}



$sql_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$username=$row_user['username'];

}


$sql_vehicle_query=mysqli_query($con, "select * from tbl_vehicle_info where user_fnd_id= '$user_fnd_id'"); 

while($row_vehicle_source = mysqli_fetch_array($sql_vehicle_query)) {

$vehicle_year=$row_vehicle_source['vehicle_year'];
$vehicle_make=$row_vehicle_source['vehicle_made'];
$vehicle_model=$row_vehicle_source['vehicle_model'];
$vehicle_miles=$row_vehicle_source['vehicle_miles'];
$vehicle_kbb=$row_vehicle_source['vehicle_kbb'];
$vehicle_ltv=$row_vehicle_source['vehicle_ltv'];


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

<div class="row container-fluid" style="background-color: #F5E09E;color:black;padding:20px;">

<div class="col-lg-4"><p>Customer First Name:<b style="color:red"> <?php echo $first_name;?></b></p></div>
<div class="col-lg-4"><p>Customer Last Name: <b style="color:red"><?php echo $last_name;?> </b></p></div>
<div class="col-lg-4"><p>Customer Phone:<b style="color:red"> <?php echo $customer_numbr;?> </b> </p></div>
<div class="col-lg-4"><p>Loan Date:<b style="color:red"> <?php echo $new_creation_date;?> </b></p></div>
<div class="col-lg-4"><p>Loan Amount: <b style="color:red">$<?php echo $amount_loan;?></b></p></div>
<div class="col-lg-4"><p>Loan ID:<b style="color:red"> <?php echo $loan_create_id;?> </b> </p></div>


</div>
      <br><br>
      
    
         <div class="container-fluid" style="width:100%; margin:0 auto;">
        

  <form action ="" method="POST" enctype="multipart/form-data">
 <input type="text" name="emaill" value="<?php echo $email;?>" style="display:none;">
<input type="text" name="link" value="<?php echo $message;?>" style="display:none;">


 
 
     <h3>Vehicle Info</h3>
     <br>
    <div class="row">
 
    <div class="col-lg-4">
      <label for="usr">Vehicle Year</label>
 <input type="text" name="vehicle_year"  class="form-control" id="usr" value="<?php echo $vehicle_year; ?>">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Vehicle Make</label>
 <input type="text" name="vehicle_make"  class="form-control" id="usr" placeholder="" value="<?php echo $vehicle_make; ?>">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Vehicle Model</label>
 <input type="text" name="vehicle_model"  class="form-control" id="usr" placeholder="" value="<?php echo $vehicle_model; ?>">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Vehicle Miles</label>
 <input type="text" name="vehicle_miles"  class="form-control" id="usr" placeholder="" value="<?php echo $vehicle_miles; ?>">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Vehicle KBB</label>
 <input type="text" name="vehicle_kbb"  class="form-control" id="usr" placeholder="" value="<?php echo $vehicle_kbb; ?>">
    </div>
    
     <div class="col-lg-4">
      <label for="usr">Vehicle LTV</label>
 <input type="text" name="vehicle_ltv"  class="form-control" id="usr" placeholder="" value="<?php echo $vehicle_ltv; ?>">
    </div>
    

    </div>
       <br> 
       
      
      <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: white;background-color: #1E90FF;border-radius: 0px;border-color: #1E90FF;">Update</button>
    </form>

</div>
</div>
</div>
        
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  
    <?php
     
     if(isset($_POST['btn-submit'])) 
{
    $date=date('Y-m-d');
$vehicle_year_update =$_POST['vehicle_year'];
$vehicle_make_update =$_POST['vehicle_make'];
$vehicle_model_update =$_POST['vehicle_model'];
$vehicle_miles_update =$_POST['vehicle_miles'];
$vehicle_kbb_update=$_POST['vehicle_kbb'];
$vehicle_ltv_update=$_POST['vehicle_ltv'];

    
      mysqli_query($con, "UPDATE tbl_vehicle_info SET vehicle_year='$vehicle_year_update', vehicle_made='$vehicle_make_update', vehicle_model='$vehicle_model_update', vehicle_miles='$vehicle_miles_update', vehicle_kbb='$vehicle_kbb_update', vehicle_ltv='$vehicle_ltv_update', last_update_by='$u_id', last_update_date='$date' where user_fnd_id ='$user_fnd_id' AND loan_create_id='$loan_create_id'");
      
?>

<script type="text/javascript">
window.location.href = 'vehicle_information.php?id=<?php echo $id; ?>';
</script> 


<?php

}
      ?>
  
  
  
  
  
  
  
  
  
  
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
