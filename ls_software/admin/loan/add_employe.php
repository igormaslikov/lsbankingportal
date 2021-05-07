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


$id=$_GET['id'];
$sql_fnd=mysqli_query($con, "select * from tbl_loan where loan_id = '$id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];
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
    
      
      
      <div class="container-fluid">
          <h3>Add New Job: </h3>
         <br>
      <div class="col-lg-12">
  <form action ="#" method="POST">
    <div class="form-group" >
        
         <div class="row">
 
    <div class="col-lg-4">
      <label for="usr">Employer Name</label>
 <input type="text" name="employer_name"  class="form-control" id="usr" value="">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Work Phone Number</label>
 <input type="tel" name="work_phone"  class="form-control" id="usr" placeholder="Format:123-456-7890" value="" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
    </div>
    
   
    
	<div class="col-lg-2">
      <label for="usr">Net Check Amount</label>
 <input type="text" name="net_amount"  class="form-control" id="usr" placeholder="" value="">
    </div>
	
     <div class="col-lg-2">
      <label for="usr"> Direct Deposit</label>
<select name="payment" id="payment" class="form-control">
    <option></option>
<option value="Yes">Yes</option>
<option value="No">No</option>

</select>
    </div>

    	

<div class="col-lg-4">
      <label for="usr">How often do you get paid?</label>
 <select name="get_paid" id="get_paid" class="form-control">
     <option></option>
<option value="Weekly">Weekly</option>
<option value="Bi-Weekly">Bi-Weekly</option>
<option value="Semi Monthly">Semi Monthly</option>
<option value="Monthly">Monthly</option>

</select>
 
    </div>

<div class="col-lg-4">
      <label for="usr">Last Paycheck Date</label>
 <input type="date" name="last_check"  class="form-control" id="usr" value="">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Next Paycheck Date</label>
 <input type="date" name="next_check"  class="form-control" id="usr" value="">
    </div>

    </div>
    
    </div>

    <br>
        
      <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: white;background-color: #1E90FF;border-radius: 0px;border-color: #1E90FF;">Add this job</button>
  </form>

</div>
</div>

  </div>
  <br>
      

 <?php
     if(isset($_POST['btn-submit'])) 
{
      $calculation_type= $_POST['calculation_type'];
    
    $employer_name_update =$_POST['employer_name'];
$work_phone_update =$_POST['work_phone'];
$direct_deposit_update =$_POST['payment'];

$net_amount_update =$_POST['net_amount'];
$net_amount_update = number_format((float)$net_amount_update, 2, '.', '');
$pay_fre_update =$_POST['get_paid'];
$last_date_update=$_POST['last_check'];
$next_date_update=$_POST['next_check'];
$date= date('Y-m-d H:i:s');
     
      $query_emp  = "INSERT INTO source_income (user_fnd_id,employer_name,work_phone_no,net_check_amount,direct_deposit,pay_period,last_pay_date,next_pay_date,creation_date)  VALUES ('$user_fnd_id','$employer_name_update','$work_phone_update','$net_amount_update','$direct_deposit_update','$pay_fre_update','$last_date_update','$next_date_update','$date')";
        $result_emp = mysqli_query($con, $query_emp);
        if ($result_emp) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        } 
      

      ?>
      <script type="text/javascript">
window.location.href = 'employer_detail.php?id=<?php echo $id; ?>';
</script>    
      
 <?php
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
