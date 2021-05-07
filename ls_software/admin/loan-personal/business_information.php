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

$loan_id=$row['p_loan_id'];
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

$sql_business_query=mysqli_query($con, "select * from tbl_business_info where user_fnd_id= '$user_fnd_id'"); 

while($row_business_source = mysqli_fetch_array($sql_business_query)) {

$business_name=$row_business_source['business_name'];
$business_phone=$row_business_source['business_phone'];
$gross_amount=$row_business_source['monthly_gross_amount'];
$business_direct_deposit=$row_business_source['direct_deposit'];
$how_paid_business=$row_business_source['how_paid'];
$business_docs=$row_business_source['business_docs'];

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


 <h3>Business Info</h3>
 <br>
    <div class="row">
 
    <div class="col-lg-4">
      <label for="usr">Business Name</label>
 <input type="text" name="business_name"  class="form-control" id="usr" value="<?php echo $business_name; ?>">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Business Phone Number</label>
 <input type="tel" name="business_phone"  class="form-control" id="usr" placeholder="Format:123-456-7890" value="<?php echo $business_phone; ?>" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
    </div>
    
	<div class="col-lg-4">
      <label for="usr">Monthly Gross Amount</label>
 <input type="text" name="gross_amount"  class="form-control" id="usr" placeholder="" value="<?php echo $gross_amount; ?>">
    </div>
	
     <div class="col-lg-4">
      <label for="usr"> Direct Deposit</label>
<select name="business_direct_deposit" id="payment" class="form-control">
    <option></option>
<option value="Yes" <?php if($business_direct_deposit=='Yes'){ echo 'selected';} ?>>Yes</option>
<option value="No"  <?php if($business_direct_deposit=='No'){ echo 'selected';} ?>>No</option>

</select>
    </div>

    	

<div class="col-lg-4">
      <label for="usr">How often do you get paid?</label>
 <select name="business_get_paid" id="get_paid" class="form-control">
     <option></option>
<option value="Weekly" <?php if($how_paid_business=='Weekly'){ echo 'selected';} ?>>Weekly</option>
<option value="Bi-Weekly" <?php if($how_paid_business=='Bi-Weekly'){ echo 'selected';} ?>>Bi-Weekly</option>
<option value="Semi Monthly" <?php if($how_paid_business=='Semi Monthly'){ echo 'selected';} ?>>Semi Monthly</option>
<option value="Monthly" <?php if($how_paid_business=='Monthly'){ echo 'selected';} ?>>Monthly</option>

</select>
 
    </div>

<div class="col-lg-4">
      <label for="usr">Business Documentation</label>
 <select name="business_docs" id="payment" class="form-control">
    <option></option>
<option value="Business License" <?php if($business_docs=='Business License'){ echo 'selected';} ?>>Business License</option>
<option value="Sellers Permit"  <?php if($business_docs=='Sellers Permit'){ echo 'selected';} ?>>Sellers Permit</option>
<option value="DBA"  <?php if($business_docs=='DBA'){ echo 'selected';} ?>>DBA</option>

</select>
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
$business_name_update =$_POST['business_name'];
$business_phone_update =$_POST['business_phone'];
$gross_amount_update =$_POST['gross_amount'];
$business_direct_deposit_update =$_POST['business_direct_deposit'];
$business_get_paid_update=$_POST['business_get_paid'];
$business_docs_update=$_POST['business_docs'];

    
      mysqli_query($con, "UPDATE tbl_business_info SET business_name='$business_name_update', business_phone='$business_phone_update', monthly_gross_amount='$gross_amount_update', direct_deposit='$business_direct_deposit_update', how_paid='$business_get_paid_update', business_docs='$business_docs_update', last_update_by='$u_id', last_update_date='$date' where user_fnd_id ='$user_fnd_id' AND loan_create_id='$loan_create_id'");
      
?>

<script type="text/javascript">
window.location.href = 'business_information.php?id=<?php echo $id; ?>';
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
