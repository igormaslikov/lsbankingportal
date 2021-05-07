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
if($u_access_id=='0'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}
else {
$DBcon->close();

?>
<?php


$setting_id=$_GET['setting_id'];
$id=$_GET['id'];
$sql_fnd=mysqli_query($con, "select * from tbl_loan_setting where id = '$setting_id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$loan_amount=$row_fnd['loan_amount'];
$loan_fee=$row_fnd['loan_fee'];
$payoff_amount=$row_fnd['payoff_amount'];

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

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom" >
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
    $form_name="setting-".basename(__FILE__);
     
    $loan_amount_f =$_POST['loan_amount'];
    $loan_fee =$_POST['loan_fee'];
     $loan_amount_f = number_format((float)$loan_amount_f, 2, '.', '');
    
    $payoff_amount=$loan_amount_f+$loan_fee;
    
    $sql_role=mysqli_query($con, "select * from access_form where form_name='$form_name'"); 
    while($row_role = mysqli_fetch_array($sql_role)) {

 $form_id=$row_role['id'];
 
}
   $update_allowed = user_edit_roles($u_access_id,$form_id);
    
    
    if ($update_allowed==1)
{
   
   
    mysqli_query($con,"UPDATE tbl_loan_setting SET loan_amount ='$loan_amount_f', loan_fee ='$loan_fee', payoff_amount ='$payoff_amount'where id ='$setting_id' ");
     

 ?>
  <script type="text/javascript">
window.location.href = 'loan_settings.php';
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
      <div class="container-fluid">
          <h3>Edit Loan: </h3>
         <br>
      <div class="col-lg-12">
  <form action ="#" method="POST">
    <div class="form-group" >
        
         <div class="row">
 
    <div class="col-lg-4">
      <label for="usr">Loan Amount</label>
 <input type="text" name="loan_amount"  class="form-control" id="usr" value="<?php echo $loan_amount;?>">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Loan Fee</label>
 <input type="tel" name="loan_fee"  class="form-control" id="usr" placeholder="" value="<?php echo $loan_fee; ?>">
    </div>
    
 
   

    </div>
    
    </div>

    <br>
        
      <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: white;background-color: #1E90FF;border-radius: 0px;border-color: #1E90FF;">Update loan</button>
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
