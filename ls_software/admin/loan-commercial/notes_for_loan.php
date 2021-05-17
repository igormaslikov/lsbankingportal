<?php
error_reporting(0);
session_start();
$id=$_GET['id'];
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
$loan_create_id=$row_fnd['loan_create_id'];
$payoff=$row_fnd['loan_total_payable'];
$loan_status=$row_fnd['loan_status'];
}



$query_payment = mysqli_query($con,"SELECT SUM(payoff_amount) AS value_sum FROM commercial_loan_transaction where loan_id= '$id'");
while ($row_payment=mysqli_fetch_array($query_payment)){
    $payment = $row_payment['value_sum'];
    
    $payment = number_format((float)$payment, 2, '.', '');

   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$us;

}


$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];
$last_name=$row['last_name'];
$customer_numbr=$row['mobile_number'];


}

//echo "fname is:".$first_name;

$sql=mysqli_query($con, "select * from tbl_commercial_loan where loan_id= '$id'"); 

while($row = mysqli_fetch_array($sql)) {

$loan_id=$row['loan_id'];
//echo "fndid is:".$fnd_id;
$amount_loan=$row['principal_amount'];
$amount_loan = number_format((float)$amount_loan, 2, '.', '');

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

//echo "fname is:".$username;

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
<div class="col-lg-4"><p>Loan Amount: <b style="color:red"> <?php echo $val.$amount_loan.$variable;?></b></p></div>
<div class="col-lg-4"><p>Loan ID:<b style="color:red"> <?php echo $loan_create_id;?> </b> </p></div>


</div>
<br><br>
    
    

      <div class="container-fluid">
         <div class="row">
                <div class="col-lg-3">
        <h3>Notes</h3>
    
    </div>
    
     <div class="col-lg-3" align="center">
    <?php 
    if($payment>=$payoff OR  $loan_status== 'Paid')
    //       {
    //           echo "<a href='renew_loan.php?id=$id' <button name='btn-notes-submit' type='submit' class='btn btn-danger' style='background-image: linear-gradient(to bottom,#95c500 0,#639a0a 100%);
    // color: #fff;
    // background-color: #2a8206;
    // border-color: #112f01;'>Renew Loan</button></a>";

               
            
    //       }
 ?>
</div>
            <div class="col-lg-3" >
<!--<a href="add_new_ptp.php?id=<?php //echo $id;?>">	<button name="btn-notes-submit" type="submit" class="btn btn-danger" style="background-color: #1E90FF;color: white;border-color: #1E90FF;">Add New PTP</button></a>-->

</div>
            
             
             <div class="col-lg-3" >
<!--<a href="add_new_notes.php?id=<?php //echo $id;?>">	<button name="btn-notes-submit" type="submit" class="btn btn-danger" style="background-color: #1E90FF;color: white;border-color: #1E90FF;">Add New Notes</button></a>-->

</div>
   
     </div>

          
        <br>
    	<?php
    $id=$_GET['id'];
     
$result_status = mysqli_query($con,"SELECT * FROM loan_folder_notes where loan_id= '$id' ORDER BY notes_id desc");

echo '<br><table style="width:100%;padding:10px" class="table table-striped table-bordered">'."
<tr>
<th style='width:70%'>Notes Detail</th>
<th style='width:13%'>Created By</th>
<th style='width:17%'>Date</th>
</tr>";

while($row_status = mysqli_fetch_array($result_status))

{
$created_by_get_db_activity = $row_status['created_by'];
$sql_activity_by_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by_get_db_activity'"); 
$final_activity_by_user = '';
while($row_sql_activity_by_user = mysqli_fetch_array($sql_activity_by_user)) {
	$final_activity_by_user = $row_sql_activity_by_user['username'];
}
	

	
echo "<tr>";
echo "<td>" . $row_status['notes'] . "</td>";
echo "<td>".$final_activity_by_user."</td>";
echo "<td>" . $row_status['creation_date'] . "</td>";
echo "</tr>";
}
echo "</table><br>";

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
