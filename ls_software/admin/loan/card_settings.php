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
<div class="col-lg-4"><p>Loan Amount: <b style="color:red"> <?php echo $amount_loan;?></b></p></div>
<div class="col-lg-4"><p>Created By:<b style="color:red"> <?php echo $username;?> </b> </p></div>


</div>
      <br><br>
     
     <?php
     if(isset($_POST['btn-submit'])) 
{
      $calculation_type= $_POST['calculation_type'];
    
     $source= $_POST['source'];
     $portfolio= $_POST['p_portfolio'];
     $amount_loan_up= $_POST['amount_loan'];
     $amount_left_up= $_POST['amount_left'];
     $next_payment_date_up= $_POST['next_payment_date'];
     $next_payment= $_POST['p_tenure'];
     $notes= $_POST['loan_notes'];
     
      mysqli_query($con, "UPDATE tbl_loan SET amount_of_loan ='$amount_loan_up', loan_total_payable ='$amount_left_up', payment_date ='$next_payment_date_up' where user_fnd_id ='$user_fnd_id'");
      mysqli_query($con, "UPDATE tbl_loan_notes SET notes ='$notes' where loan_id ='$id'");
      
}
      ?>
      <div class="container-fluid">
          <span   style="font-weight:bold;text-align:center;">DEBIT PAYMENT METHOD: </span>
         <br> <br>
      <div class="col-lg-12">
  <form action ="#" method="POST">
    <div class="form-group" >
    <div class="row">
      
      
    <div class="col-lg-6" >
      <label for="usr"> PAYMENT METHOD TITLE </label>
      <input name="pay_method" type="text" class="form-control" id="usr" placeholder="" value="">
    </div>

    
    <div class="col-lg-6">
      <label for="usr"> ADDRESS </label>
      <input name="address" type="text" class="form-control" id="usr" placeholder="" value="">
    </div>
    
    <div class="col-lg-6">
      <label for="usr"> NAME ON CARD </label>
      <input name="name_card" type="text" class="form-control"  id="usr" placeholder="" value="">
    </div>
    
    <div class="col-lg-6" >
      <label for="usr"> ZIPCODE </label>
      <input name="zip_code" type="text" class="form-control" id="usr" placeholder="" value="">
    </div>
    
     <div class="col-lg-6">
      <label for="usr"> CARD NUMBER </label>
      <input name="card_number" type="text" class="form-control" id="usr" placeholder="" value="">
    </div>

    
    
  <div class="col-lg-6">
      <label for="usr"> CARD EXPIRES </label>
<div class="col-lg-6" style="margin-left: -11px;">
      <select name="exp_month" class="form-control">
          <option value="01">01 - January</option>
          <option value="02">02 - February</option>
          <option value="03">03 - March</option>
          <option value="04">04 - April</option>
          <option value="05">05 - May</option>
          <option value="06">06 - June</option>
          <option value="07">07 - July</option>
          <option value="08">08 - August</option>
          <option value="09">09 - September</option>
          <option value="10">10 - October</option>
          <option value="11">11 - November</option>
          <option value="12">12 - December</option>
          
          </select>
    </div>
    
   <div class="col-lg-6" style="margin-left: 270px;margin-top: -41px;">
      <select name="exp_year" class="form-control">
          <option value="2019">2019</option>
          <option value="2020">2020</option>
          <option value="2021">2021</option>
          <option value="2022">2022</option>
          <option value="2023">2023</option>
          <option value="2024">2024</option>
          <option value="2025">2025</option>
          <option value="2026">2026</option>
          <option value="2027">2027</option>
          <option value="2028">2028</option>
          <option value="2029">2029</option>
          
         
          
          </select>
    </div>
    </div>
    
    
    <div class="col-lg-6">
      <label for="usr"> CITY </label>
      <input name="city" type="text" class="form-control"  id="usr" placeholder="" value="">
    </div>
    
     <div class="col-lg-6">
      <label for="usr"> STATE </label>
      <input name="state" type="text" class="form-control"  id="usr" placeholder="" value="">
    </div>
    
    <div class="col-lg-6">
     <label for="usr"> CARD TYPE </label>
      <select name="card_type" class="form-control">
          <option value="">Please Select</option>
          <option value="Visa">Visa</option>
          <option value="MasterCard">MasterCard</option>
          <option value="American Express">American Express</option>
          <option value="Discover">Discover</option>
          
          </select>
    </div>
    
     <div class="col-lg-6">
     <label for="usr"> COUNTRY</label>
      <select name="country" class="form-control">
          <option value="United States">United States</option>
          <option value="Canada">Canada</option>
          </select>
    </div>
     </div>

       <br>  
      <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: white;background-color: #1E90FF;border-radius: 0px;border-color: #1E90FF;">Save Payment Method</button>
  </form>

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
