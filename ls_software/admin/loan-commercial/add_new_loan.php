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
if($u_access_id!='1'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}
else {
$DBcon->close();

?>
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

$id=$_GET['id'];
$sql_fnd=mysqli_query($con, "select * from tbl_commercial_loan where loan_id = '$id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];
//echo "FND_ID" .$user_fnd_id;
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
  
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['email']; ?></title>

<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="../bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="../style.css" type="text/css" />

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
     if(isset($_POST['btn-submit'])) 
{
     
    $loan_amount_f =$_POST['loan_amount'];
    $loan_fee =$_POST['loan_fee'];
     $loan_amount_f = number_format((float)$loan_amount_f, 2, '.', '');
    
    $payoff_amount=$loan_amount_f+$loan_fee;
    
   
     
      $query_emp  = "INSERT INTO tbl_loan_setting (loan_amount,loan_fee,payoff_amount)  VALUES ('$loan_amount_f','$loan_fee','$payoff_amount')";
        $result_emp = mysqli_query($con, $query_emp);
        if ($result_emp) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        } 
 
 
 ?>
  <script type="text/javascript">
window.location.href = 'loan_settings.php?id=<?php echo $id; ?>';
</script> 
 <?php
      
}
      ?>
      <div class="container-fluid">
          <h3>Add New Loan: </h3>
         <br>
      <div class="col-lg-12">
  <form action ="#" method="POST">
    <div class="form-group" >
        
         <div class="row">
 
    <div class="col-lg-4">
      <label for="usr">Loan Amount</label>
 <input type="text" name="loan_amount"  class="form-control" id="usr" value="">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Loan Fee</label>
 <input type="tel" name="loan_fee"  class="form-control" id="usr" placeholder="" value="">
    </div>
    
 
   

    </div>
    
    </div>

    <br>
        
      <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: white;background-color: #1E90FF;border-radius: 0px;border-color: #1E90FF;">Add this loan</button>
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
