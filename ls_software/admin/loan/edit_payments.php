<?php
error_reporting(0);
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

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
$id_transaction=$_GET['id'];
$loan_id=$_GET['loan_id'];
$pay_method=$_GET['method'];
if($pay_method=='Repay')
{


$sql_trnsaction=mysqli_query($con, "select * from loan_transaction where repay_transaction_id='$id_transaction'"); 

while($row_trnsaction = mysqli_fetch_array($sql_trnsaction)) {

$transaction_id=$row_trnsaction['transaction_id'];
$loan_create_id=$row_trnsaction['loan_create_id'];
$payment_method=$row_trnsaction['payment_method'];
$payoff_amount=$row_trnsaction['payoff_amount'];
$payment_description=$row_trnsaction['payment_description'];
$payment_date_db=$row_trnsaction['payment_date'];

$timestamp = strtotime($payment_date);
 
// Creating new date format from that timestamp
$payment_date= date("m-d-Y", $timestamp);

}
}
else{

$sql_trnsaction=mysqli_query($con, "select * from loan_transaction where transaction_id='$id_transaction'"); 

while($row_trnsaction = mysqli_fetch_array($sql_trnsaction)) {

$transaction_id=$row_trnsaction['transaction_id'];
$loan_create_id=$row_trnsaction['loan_create_id'];
$payment_method=$row_trnsaction['payment_method'];
$payoff_amount=$row_trnsaction['payoff_amount'];
$payment_description=$row_trnsaction['payment_description'];
$payment_date_db=$row_trnsaction['payment_date'];

$timestamp = strtotime($payment_date);
 
// Creating new date format from that timestamp
$payment_date= date("m-d-Y", $timestamp);

}

}




$sql=mysqli_query($con, "select * from tbl_loan where loan_create_id= '$loan_create_id'"); 

while($row = mysqli_fetch_array($sql)) {
    
   
   $id=$row['loan_id']; 
    
$user_fnd_id=$row['user_fnd_id'];

}

?>


<?php




$sql_fnd=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {
    
$first_name=$row_fnd['first_name'];
$last_name=$row_fnd['last_name'];
$full_name= $first_name.' '.$last_name;
$email=$row_fnd['email'];
$mobile_number=$row_fnd['mobile_number'];
$address=$row_fnd['address'];
$date_of_birth=$row_fnd['date_of_birth'];
$ssn=$row_fnd['ssn']; 
$id_photo=$row_fnd['customer_img'];


}



$sql=mysqli_query($con, "select * from tbl_loan where loan_create_id= '$loan_create_id'"); 

while($row = mysqli_fetch_array($sql)) {


	$loan_create_id=$row['loan_create_id'];

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



$sql_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$username=$row_user['username'];

}







?> 




<!DOCTYPE html>
<html lang="en">

<head>

<style>
.buttonHolder{ text-align: left; 
    margin-left: 15px;
}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
  
  
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>

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
        <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

       
      </nav>
   <br>
   <div class="row container-fluid" style="background-color: #F5E09E;color:black;padding:20px;">

<div class="col-lg-4"><p>Customer First Name:<b style="color:red"> <?php echo $first_name;?></b></p></div>
<div class="col-lg-4"><p>Customer Last Name: <b style="color:red"><?php echo $last_name;?> </b></p></div>
<div class="col-lg-4"><p>Customer Phone:<b style="color:red"> <?php echo $mobile_number;?> </b> </p></div>
<div class="col-lg-4"><p>Loan Date:<b style="color:red"> <?php echo $new_creation_date;?> </b></p></div>
<div class="col-lg-4"><p>Loan Amount: <b style="color:red"> $<?php echo $val.$amount_loan;?></b></p></div>
<div class="col-lg-4"><p>Lona ID:<b style="color:red"> <?php echo $loan_create_id;?> </b> </p></div>


</div>
 <br>
      <div class="container-fluid">
        
        <div class="row"> 
         <div class="col-lg-6">
<h3>Payments</h3>

</div>
         
          <div class="col-lg-6" align="right">
<a href="view_all_payments.php?id=<?php echo $loan_id?>"> <button name="btn-submit" type="submit" class="btn btn-danger" style="background-color: #1E90FF;color: white;border-color: #1E90FF;">View All Payments</button></a>


</div>
</div>
    <br>
 <form action ="" method="POST" enctype="multipart/form-data">

     <br>
    <div class="row">
 
    <div class="col-lg-6">
      <label for="usr">Loan ID</label>
 <input type="text" name="loan_id"  class="form-control" id="usr" value="<?php echo $loan_create_id; ?>">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Amount</label>
 <input type="text" name="amount"  class="form-control" id="usr" placeholder="" value="<?php echo "$".$payoff_amount; ?>">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Payment Method</label>
 <select name="payment_method" id="app_status" class="form-control"  value="" style="padding: 6px 15px;">
<option value="">Account Status</option>
<option value="Debit" <?php if($payment_method=='Debit'){ echo 'selected';} ?>>Debit</option>
<option value="ACH" <?php if($payment_method=='ACH'){ echo 'selected';} ?>>ACH</option>
<option value="Bank Deposit" <?php if($payment_method=='Bank Deposit'){ echo 'selected';} ?>>Bank Deposit</option>
<option value="Cash" <?php if($payment_method=='Cash'){ echo 'selected';} ?>>Cash</option>
<option value="eCheck" <?php if($payment_method=='eCheck'){ echo 'selected';} ?>>eCheck</option>
<option value="Charge Off" <?php if($payment_method=='Charge Off'){ echo 'selected';} ?>>Charge Off</option>
<option value="Repay" <?php if($payment_method=='Repay'){ echo 'selected';} ?>>Repay</option>
</select>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Payment Date</label>
 <input type="date" name="payment_date" class="form-control" id="usr"  value="<?php echo $payment_date_db; ?>" >
    </div>

    
     <div class="col-lg-12">
      <label for="usr">Reason</label>
 <textarea type="text" name="edit_reason"  class="form-control" id="usr" style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"> </textarea>
     
     </textarea>
    </div>

    </div>
       <br> 
       
      
      <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: white;background-color: #1E90FF;border-radius: 0px;border-color: #1E90FF;">Update</button>
    </form>

        
        </div>
    </div>
    
   <?php
      include '../functions.php';
     if(isset($_POST['btn-submit'])) 
{
    $form_name="payday-".basename(__FILE__);
   
     
     $loan_id_up= $_POST['loan_id'];
     $amount_up= $_POST['amount'];
     $payment_method_up= $_POST['payment_method'];
     $payment_date_up= $_POST['payment_date'];
     
     $amount_upp=str_replace("$","","$amount_up");
     
     
     $sql_role=mysqli_query($con, "select * from access_form where form_name='$form_name'"); 


while($row_role = mysqli_fetch_array($sql_role)) {

 $form_id=$row_role['id'];
 
}
   $update_allowed = user_edit_roles($u_access_id,$form_id);
    
    
    if ($update_allowed==1)
{
     
     $edit_reason= "Payment Edit Reason: ". $_POST['edit_reason'];
    
mysqli_query($con, "UPDATE loan_transaction SET loan_create_id='$loan_id_up', payment_method='$payment_method_up', payoff_amount='$amount_upp', payment_date='$payment_date_up' where loan_create_id='$loan_id_up' AND transaction_id='$transaction_id' AND user_fnd_id='$user_fnd_id'");
      
   //******************************************************* Application Notes ****************************************
   
   $date= date('Y-m-d H:i:s'); 

   
$query_app  = "INSERT INTO application_status_updates (application_id,loan_create_id,user_id,status,creation_date,loan_transaction_id)  VALUES ('$user_fnd_id','$loan_id_up','$u_id','$edit_reason','$date','$transaction_id')";
        $result_app = mysqli_query($con, $query_app);
        if ($result_app) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        } 
   
   
   
   
   //******************************************************* Application Notes END ****************************************
   
   
   
      

      ?>  
    
 <script type="text/javascript">
window.location.href = 'view_all_payments.php?id=<?php echo $loan_id; ?>';
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
