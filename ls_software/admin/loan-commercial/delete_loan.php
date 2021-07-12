<?php
error_reporting(0);
session_start();
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

include '../functions.php';


 $id=$_GET['loan_id'];
 
$sql_fnd=mysqli_query($con, "select * from tbl_commercial_loan where loan_id = '$id'"); 

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



$sql=mysqli_query($con, "select * from tbl_commercial_loan where loan_id= '$id'"); 

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






     
     
     
     
     
     
     
     if(isset($_POST['btn-submit'])) 
{
    $form_name="commercial-".basename(__FILE__);
    
    
    $sql_role=mysqli_query($con, "select * from access_form where form_name='$form_name'"); 


while($row_role = mysqli_fetch_array($sql_role)) {

 $form_id=$row_role['id'];
 
}
   $delete_allowed = user_roles($u_access_id,$form_id);
   $delete_allowed  = 1;
    
    if ($delete_allowed==1)
{
    
    $date=date('Y-m-d');
$del_reason ="Unsigned Loan ID $loan_create_id is deleted,".$_POST['del_reason']." and User ID is $user_fnd_id.";

    $query = "DELETE FROM tbl_commercial_loan WHERE loan_id = '$id'";
    $result = mysqli_query($con, $query);
    
    $query_transaction = "DELETE FROM commercial_loan_transaction WHERE loan_id = '$id'";
    $result_transaction = mysqli_query($con, $query_transaction);
    
    $query_installments = "DELETE FROM tbl_commercial_loan_installments WHERE loan_create_id = '$loan_create_id'";
    $result_installments = mysqli_query($con, $query_installments);
    
    $sql_transaction=mysqli_query($con, "select * from commercial_loan_transaction where loan_id= '$id'"); 

while($row_transaction = mysqli_fetch_array($sql_transaction)) {

$transaction_id=$row_transaction['transaction_id'];
}
    
    
application_notes_update($user_fnd_id,$loan_create_id,$u_id,$del_reason,$transaction_id);
    

?>

 
<script type="text/javascript">
window.location.href = 'home.php';
</script>

<?php
}



else{
  echo "<script type='text/javascript'>
window.location.href = '../not_authorize.php';
</script>";
}
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
<div class="col-lg-3"><p>Loan Date:<b style="color:red"> <?php echo $new_creation_date;?> </b></p></div>
<div class="col-lg-3"><p>Loan Amount: <b style="color:red">$<?php echo $amount_loan;?></b></p></div>
<div class="col-lg-3"><p>Loan ID:<b style="color:red"> <?php echo $loan_create_id;?> </b> </p></div>
<div class="col-lg-3"><p>User ID:<b style="color:red"> <?php echo $user_fnd_id;?> </b> </p></div>

</div>
      <br><br>
      
    
         <div class="container-fluid" style="width:100%; margin:0 auto;">
         

  <form action ="" method="POST" enctype="multipart/form-data">
 <input type="text" name="emaill" value="<?php echo $email;?>" style="display:none;">
<input type="text" name="link" value="<?php echo $message;?>" style="display:none;">


 
 
     <h3>Are you sure you want to delete Loan ID <?php echo $loan_create_id;?></h3>
     <br>
    <div class="row">
        <?php
		if(isset($msg)){
			echo $msg;
		}
		?>
        
 <div class="col-lg-12">
      <label for="usr">Add Reason*</label>
      <textarea type="text" name="del_reason"  class="form-control" id="usr" style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;" maxlength="10000" required> </textarea>
    </div>
</div>
       <br> 
       
      
      <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: white;background-color: #1E90FF;border-radius: 0px;border-color: #1E90FF;">Delete Loan</button>
    </form>

</div>
</div>
</div>
        
    </div>
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
