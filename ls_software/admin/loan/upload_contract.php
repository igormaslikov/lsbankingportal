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
 

$id=$_GET['id'];
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

if ($amount_loan !='0')
{
  
   $val="$";
}

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

 
$sql_user=mysqli_query($con, "select * from tbl_loan_notes where loan_id= '$id'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$loan_notes=$row_user['notes'];

}

//echo "fname is:".$loan_notes;

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
<div class="col-lg-4"><p>Money Amount: <b style="color:red"> <?php echo $val.$amount_loan.$variable;?></b></p></div>
<div class="col-lg-4"><p>Created By:<b style="color:red"> <?php echo $username;?> </b> </p></div>


</div>

<br><br>
      <div class="container-fluid">
        
       <form action="" method="post" enctype="multipart/form-data">
  
<div class="row">
      <div class="col-lg-6">
      <label for="usr">Select File</label>
      <input type="file" name="lender_documents" class="form-control" id="lender_documents">
      </div>
</div>
<br>
	<button name="btn-notes-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#95c500 0,#639a0a 100%);
    color: #fff;
    background-color: #2a8206;
    border-color: #112f01;">Upload Contract</button>

  </form>
        
        
<?php 
include '../functions.php';
if(isset($_POST['btn-notes-submit'])) {
 
$description =$_POST['description'];
$form_name="payday-".basename(__FILE__);


$date= date('Y-m-d H:i:s'); 
$target_dir = "uploads_contract/";
$target_file = $target_dir .$user_fnd_id."-".basename($_FILES["lender_documents"]["name"]);
$target_file_db = $user_fnd_id."-".basename($_FILES["lender_documents"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if $uploadOk is set to 0 by an error

 $sql_role=mysqli_query($con, "select * from access_form where form_name='$form_name'"); 


while($row_role = mysqli_fetch_array($sql_role)) {

 $form_id=$row_role['id'];
 
}
   $update_allowed = user_edit_roles($u_access_id,$form_id);
    if ($update_allowed==1)
{

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["lender_documents"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["lender_documents"]["name"]). " has been uploaded.";
         mysqli_query($con,"UPDATE tbl_loan SET contract ='$target_file_db', contract_status='1' where user_fnd_id ='$user_fnd_id'");
		echo '<meta http-equiv="refresh" content="0">';
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

}



else{
  echo "<script type='text/javascript'>
window.location.href = '../not_authorize.php';
</script>";
}

?>
        

<?php
}
?>      
        
        
        
        
        
        
        
        
        
        
        
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
