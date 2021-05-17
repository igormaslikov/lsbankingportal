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
$u_name=$userRow['username'];

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
$payoff=$row_fnd['loan_total_payable'];
$loan_status=$row_fnd['loan_status'];
}



$query_payment = mysqli_query($con,"SELECT SUM(payoff_amount) AS value_sum FROM loan_transaction where loan_id= '$id'");
while ($row_payment=mysqli_fetch_array($query_payment)){
    $payment = $row_payment['value_sum'];
    
    $payment = number_format((float)$payment, 2, '.', '');

   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$us;

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



$sql=mysqli_query($con, "select * from tbl_loan where loan_id= '$id'"); 

while($row = mysqli_fetch_array($sql)) {

$loan_id=$row['loan_id'];
//echo "fndid is:".$fnd_id;
$amount_loan=$row['amount_of_loan'];
$apr=$row['apr'];

if ($amount_loan !='0')
{
   
   $val="$";
}

//echo "Amount is:".$amount_loan;

$amount_left =$row['loan_total_payable'];
$bg_id=$row['bg_id'];
$payment_date =$row['payment_date'];
$payment_tenure =$row['payment_tenure'];
$escrow=$row['escrow'];
$primary_port=$row['primary_portfolio'];
$creation_date=$row['contract_date'];
$created_by=$row['created_by'];
$last_update=$row['last_update_by'];
$last_update_date=$row['last_update_date'];
$last_payment_date=$row['last_payment_date'];

$start = strtotime($payment_date);
$end = strtotime($last_payment_date);

$days_between = ceil(abs($end - $start) / 86400);

//echo $days_between;



$timestamp = strtotime($last_payment_date);
$last_payment_date= date("m-d-Y", $timestamp);


 $timestamp = strtotime($creation_date);
 $new_creation_date= date("m-d-Y", $timestamp);


$loan_status=$row['loan_status'];
$primary_port=$row['secondary_portfolio'];
}

 $now = time(); 
$your_date = strtotime($payment_date);

$datediff = $now-$your_date;

$datediff1= round($datediff / (60 * 60 * 24));
if ($datediff1<0)
{
    $datediff1=str_replace("-","","$datediff1");
    
}
$timestamp = strtotime($payment_date);
$new_payment_date= date("m-d-Y", $timestamp);


$query_payment = mysqli_query($con,"SELECT SUM(payoff_amount) AS value_sum FROM loan_transaction where loan_id= '$id'");
while ($row_payment=mysqli_fetch_array($query_payment)){
    $payment = $row_payment['value_sum'];
    
    $payment = number_format((float)$payment, 2, '.', '');

   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$us;

}



 $sql_loan_settings=mysqli_query($con, "select * from tbl_loan_setting where loan_amount= '$amount_loan'"); 

while($row_loan_settings = mysqli_fetch_array($sql_loan_settings)) {

$loan_fee=$row_loan_settings['loan_fee'];
$loan_payable=$row_loan_settings['payoff_amount'];

 $balns_due =$payoff-$payment;
  $balns_due= number_format("$balns_due",2);
    
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
 
        <?php include('vertical_menu.php');?>
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
<div class="col-lg-3"><p>Loan Amount: <b style="color:red"> <?php echo $val.$amount_loan;?></b></p></div>
<div class="col-lg-3"><p>Loan ID:<b style="color:red"> <?php echo $loan_create_id;?> </b> </p></div>
<div class="col-lg-3"><p>User ID:<b style="color:red"> <?php echo $user_fnd_id;?> </b> </p></div>

</div>
      <br><br>
     
  
      <div class="container-fluid">
       <h3>Loan Status Activity Log</h3>  
   	<?php

$result_status = mysqli_query($con,"SELECT * FROM application_status_updates where loan_create_id = '$loan_create_id' order by id desc ");

echo '<br><table style="width:100%;padding:10px" class="table table-striped table-bordered">'."
<tr>
<th>Date</th>
<th>Change</th>
<th>User</th>
</tr>";

while($row_status = mysqli_fetch_array($result_status))

{
$created_by_get_db_activity = $row_status['user_id'];
$sql_activity_by_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by_get_db_activity'"); 
$final_activity_by_user = '';
while($row_sql_activity_by_user = mysqli_fetch_array($sql_activity_by_user)) {
	$final_activity_by_user = $row_sql_activity_by_user['username'];
}
	
	 $log_date=$row_status['creation_date'];
	 $timestamp = strtotime($log_date);
     $new_log_date= date("m-d-Y", $timestamp);

	
echo "<tr>";
echo "<td>" .$new_log_date. "</td>";
echo "<td>Activity Status/SMS : " . $row_status['status'] . "</td>";
echo "<td>" . $final_activity_by_user . "</td>";
echo "</tr>";
}
echo "</table><br>";

?>

<br><hr>
<h3>Loan Payment Activity Log</h3>  
   	<?php

$result_statuss = mysqli_query($con,"SELECT * FROM loan_transaction where loan_create_id = '$loan_create_id'");

echo '<br><table style="width:100%;padding:10px" class="table table-striped table-bordered">'."
<tr>
<th>No</th>
<th>Payment Date</th>
<th>Payment</th>
<th>User</th>
</tr>";
$counter="1";
while($row_statuss = mysqli_fetch_array($result_statuss))

{
$created_by_get_db_activityy = $row_statuss['user_id'];
$sql_activity_by_userr=mysqli_query($con, "select * from tbl_users where user_id= '$created_by_get_db_activityy'"); 
$final_activity_by_userr = '';
while($row_sql_activity_by_userr = mysqli_fetch_array($sql_activity_by_userr)) {
	$final_activity_by_userr = $row_sql_activity_by_userr['username'];
}
	
     $log_payment_date=$row_statuss['payment_date'];
	 $timestamp = strtotime($log_payment_date);
     $new_log_payment_date= date("m-d-Y", $timestamp);
     
	
echo "<tr>";
echo "<td>" . $counter++ . "</td>";
echo "<td>".$new_log_payment_date."</td>";
echo "<td>$".$row_statuss['payoff_amount']."</td>";
echo "<td>" . $username . "</td>";
echo "</tr>";
}
echo "</table><br>";

mysqli_close($con);
?>


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























