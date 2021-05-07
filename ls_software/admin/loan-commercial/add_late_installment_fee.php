<?php
error_reporting(0);
session_start();
include_once '../dbconnect.php';
include_once '../dbconfig.php';
include_once '../functions.php';
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



 $id=$_GET['id'];
 $intallment_id=$_GET['intallment_id'];

$sql=mysqli_query($con, "select * from tbl_commercial_loan where loan_id= '$id'"); 

while($row = mysqli_fetch_array($sql)) {

    $loan_id=$row['loan_id'];
    $user_fnd_id=$row['user_fnd_id'];
	$daily_interest=$row['daily_interest'];
    $amount_loan=$row['principal_amount'];
    $bg_id=$row['bg_id'];
    $next_payment =$row['payment_date'];
    $creation_date=$row['contract_date'];
    $created_by=$row['created_by'];
    $last_update=$row['last_update_by'];
    $last_update_date=$row['last_update_date'];
    $loan_status=$row['loan_status'];
    $last_payment_date=$row['last_payment_date'];
    $timestamp = strtotime($creation_date);
 
// Creating new date format from that timestamp
$new_creation_date= date("m-d-Y", $timestamp);
}




$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];
$last_name=$row['last_name'];
$customer_numbr=$row['mobile_number'];


}

//echo "fname is:".$first_name;





$sql_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$username=$row_user['username'];

}

//echo "fname is:".$username;




$sql_transaction=mysqli_query($con, "select * from tbl_commercial_loan_installments where id='$intallment_id'"); 

while($row_transaction = mysqli_fetch_array($sql_transaction)) {

$loan_create_id=$row_transaction['loan_create_id'];
$payment_amount=$row_transaction['payment'];
$interest_amount=$row_transaction['interest'];
$principal_amount=$row_transaction['principal'];
$rem_balance=$row_transaction['balance'];
$payment_date=$row_transaction['payment_date'];
$status= $row_transaction['status'];
$fee_status= $row_transaction['fee_status'];


}

$date=date('Y-m-d');



    $sql_installment_late_fees=mysqli_query($con, "select * from tbl_late_fee_installment"); 

while($row_installment_late_fees = mysqli_fetch_array($sql_installment_late_fees)) {

$installment_late_fees=$row_installment_late_fees['late_fees'];
$installment_late_fees_id=$row_installment_late_fees['id'];
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

<style>
table,th, td {
  border: 1px solid black;
}
</style>
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
<div class="col-lg-4"><p>Loan Amount: <b style="color:red"> $<?php echo $val.$amount_loan;?></b></p></div>
<div class="col-lg-4"><p>Loan ID:<b style="color:red"> <?php echo $loan_create_id;?> </b> </p></div>


</div>
      <br><br>
         <div class="container-fluid" style="width:100%; margin:0 auto;">
        <h3>Late Fee Adjustment: </h3>

   <form action ="" method="POST" enctype="multipart/form-data">
  <input type="text" name="name_id" value="<?php echo $name_id;?>"  style="display:none;">
  
  <div class="row">
    
     <div class="col-lg-6">
      <label for="usr">Adjust Fee</label>
      <input type="text" name="fee" class="form-control" id="usr" placeholder="" value="<?php echo '$'.$installment_late_fees;?>">
    </div>
    
    </div>
    
    <br>
    
      <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: blue;border-color: blue;">Add Fee</button>
  </form>
  
</div>
</div>
</div>
        
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  
  
  <?php 

   error_reporting(0);
  

if(isset($_POST['btn-submit'])) 
{
$date= date('Y-m-d');
$fee_up=$_POST['fee'];
$fee_up=str_replace("$","","$fee_up");

 mysqli_query($con, "UPDATE tbl_late_fee_installment SET late_fees='$fee_up'  where id ='$installment_late_fees_id'");
 
 
  
 
 //************************************  Email To LsBanking *************************//

?>

<script type="text/javascript">
window.location.href = 'view_all_installments.php?id=<?php echo $id ;?>';
</script>

  
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
}
?>
</body>

</html>
