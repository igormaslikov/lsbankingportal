<?php
error_reporting(0);
session_start();
$id=$_GET['id'];
include_once '../dbconnect.php';
include_once '../dbconfig.php';
date_default_timezone_set('America/Los_Angeles');
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
$loan_create_id=$row_fnd['loan_create_id'];
//echo "FND_ID" .$user_fnd_id;


$loan_id=$row_fnd['loan_id'];
$amount_loan=$row_fnd['amount_of_loan'];


$amount_left =$row_fnd['loan_total_payable'];
$bg_id=$row_fnd['bg_id'];
$next_payment =$row_fnd['payment_date'];
$payment_tenure =$row_fnd['payment_tenure'];
$escrow=$row_fnd['escrow'];
$primary_port=$row_fnd['primary_portfolio'];
$creation_date=$row_fnd['contract_date'];
$created_by=$row_fnd['created_by'];
$last_update=$row_fnd['last_update_by'];
$last_update_date=$row_fnd['last_update_date'];

 $timestamp = strtotime($creation_date);
 
// Creating new date format from that timestamp
$new_creation_date= date("m-d-Y", $timestamp);
}


$sql_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$username=$row_user['username'];

}


$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];
$last_name=$row['last_name'];
$customer_numbr=$row['mobile_number'];


}

//echo "fname is:".$first_name;



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
<div class="col-lg-3"><p>Money Amount: <b style="color:red"> <?php echo $val.$amount_loan.$variable;?></b></p></div>
<div class="col-lg-3"><p>Loan ID:<b style="color:red"> <?php echo $loan_create_id;?> </b> </p></div>
<div class="col-lg-3"><p>User ID:<b style="color:red"> <?php echo $user_fnd_id;?> </b> </p></div>

</div>
<br><br>
      <div class="container-fluid">
        
        <form action = "" method = "POST">
  
<div class="row">
 <div class="col-lg-12">
      <label for="usr">Notes</label>
      <textarea type="text" name="app_notes"  class="form-control" id="usr" style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;" maxlength="10000"><?php echo $app_notes;?></textarea>
    </div>
</div>
<br>
	<button name="btn-notes-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#95c500 0,#639a0a 100%);
    color: #fff;
    background-color: #2a8206;
    border-color: #112f01;">Add Notes</button>

  </form>
        
        </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <?php
 
$id=$_GET['id'];

  if(isset($_POST['btn-notes-submit'])) {


$date= date('Y-m-d H:i:s');
$app_notes_update= $_POST['app_notes'];
$app_notes_update = str_replace("'","\'",$app_notes_update);
$query_update_status= "INSERT INTO `loan_folder_notes`( `user_fnd_id`, `loan_id`, `notes`, `creation_date`, `created_by`) VALUES ('$user_fnd_id','$id','$app_notes_update','$date','$u_id')";
echo   $query_update_status;
	   $result_status_update = mysqli_query($con, $query_update_status);
        if ($result_status_update) {
          // echo "<div class='form'><h3> successfully added in application_status_updates.</h3><br/></div>";
		 
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }


  
  
  ?>
  
  <script type="text/javascript">
window.location.href = 'notes_for_loan.php?id=<?php echo $id; ?>';
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
