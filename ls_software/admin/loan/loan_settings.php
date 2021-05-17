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
$id=$_GET['id'];





$id=$_GET['id'];
$sql_fnd=mysqli_query($con, "select * from tbl_loan where loan_id = '$id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];
//echo "FND_ID" .$user_fnd_id;
}

$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];
$last_name=$row['last_name'];
$customer_numbr=$row['mobile_number'];


}



$sql_loan=mysqli_query($con, "select * from tbl_loan where loan_id= '$id'"); 

while($row_loan = mysqli_fetch_array($sql_loan)) {

$loan_id=$row_loan['loan_id'];
//echo "fndid is:".$fnd_id;
$amount_loan=$row_loan['amount_of_loan'];

if ($amount_loan !='0')
{
   
   $val="$";
}

//echo "Amount is:".$amount_loan;

$amount_left =$row_loan['loan_total_payable'];
$bg_id=$row_loan['bg_id'];
$next_payment =$row_loan['payment_date'];
$payment_tenure =$row_loan['payment_tenure'];
$escrow=$row_loan['escrow'];
$primary_port=$row_loan['primary_portfolio'];
$creation_date=$row_loan['creation_date'];
$created_by=$row_loan['created_by'];
$last_update=$row_loan['last_update_by'];
$last_update_date=$row_loan['last_update_date'];

 $timestamp = strtotime($creation_date);
 
// Creating new date format from that timestamp
$new_creation_date= date("m-d-Y", $timestamp);
}




$sql_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$username=$row_user['username'];

}



$sql_t="SELECT amount_of_loan FROM tbl_loan  where sign_status='1' ORDER BY loan_id";

if ($result_t=mysqli_query($con,$sql_t))
  {
  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($result_t);
 // printf($rowcount);
  // Free result set
  $ye=mysqli_free_result($result_t);
  echo $ye;
  }
  
  
  $query_us = mysqli_query($con,"SELECT SUM(amount_of_loan) AS value_sum FROM tbl_loan where sign_status='1'");
while ($row_us=mysqli_fetch_array($query_us)){
    $total_amount_of_loan = $row_us['value_sum'];
    
    $total_amount_of_loan = number_format((float)$total_amount_of_loan, 2, '.', '');

   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$total_amount_of_loan;

}


$query_le = mysqli_query($con,"SELECT SUM(loan_total_payable) AS value_sum FROM tbl_loan where sign_status= '1'");
while ($row_le=mysqli_fetch_array($query_le)){
    $pay_off = $row_le['value_sum'];
   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$am_le;

}



 $pay_off = number_format((float)$pay_off, 2, '.', '');
$avg_pay_off= $pay_off/$rowcount;

$avg_pay=round($avg_pay_off, 2);

$avg_amount=$total_amount_of_loan/$rowcount;

$avg = number_format((float)$avg_amount, 2, '.', '');


$query_trns = mysqli_query($con,"SELECT SUM(payoff_amount) AS value_sum FROM loan_transaction ");
while ($row_trns=mysqli_fetch_array($query_trns)){
    $totall_trans = $row_trns['value_sum'];
   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$totall_trans;

}
$totall_trans = number_format((float)$totall_trans, 2, '.', '');




?>

<?php
 
                 //*********************************************************  LOAN FEES  Start**************************************************


$sql=mysqli_query($con, "select * from tbl_loan where sign_status= '1'"); 


$total_loan_fee="0";
while($row = mysqli_fetch_array($sql)) {

$userfnd_id=$row['user_fnd_id'];
$loan_status=$row['loan_status'];
$loan_id_fee=$row['loan_id'];
 $amount_of_loan_fee=$row['amount_of_loan'];
 

$query_payment_fee = mysqli_query($con,"SELECT SUM(payoff_amount) AS value_summ FROM loan_transaction where loan_id= '$loan_id_fee'");
while ($row_payment_fee=mysqli_fetch_array($query_payment_fee)){
    $payment_fee = $row_payment_fee['value_summ'];
    
    $payment_fee = number_format((float)$payment_fee, 2, '.', '');

    //echo"<br>FEE:" .$payment_fee;

}


$loan_payment_fee=$payment_fee-$amount_of_loan_fee;
if($loan_payment_fee>0)
{
$total_loan_fee+=$loan_payment_fee;
}
}
//echo "<br>FEE is:".$total_loan_fee;



//*********************************************************  LOAN FEES  END**************************************************
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
      
      <div align="right" style="padding:30px;background-color: #F5E09E;color: white">
     
<h5  style="float:left;color:black;"> Total Loan Accounts: <span style="color:red;"><?php echo $rowcount;?> </span> </h5>
<h5  style="float:right;color:black;"> Total Loan Amounts: <span style="color:red;"><?php echo $varibl.number_format("$total_amount_of_loan",2);?> </span> </h5>
<br><br>
<h5  style="float:right;color:black;"> Total Payoff Amounts: <span style="color:red;"><?php echo $varibl.number_format("$pay_off",2);?></span>  </h5>
<h5  style="float:left;color:black;"> Avg. Loan Amount: <span style="color:red;"><?php echo $varibl.number_format("$avg",2);?> </span> </h5>
<br><br>
<h5  style="float:left;color:black;"> Avg. Payoff Amount: <span style="color:red;"><?php echo $varibl.number_format("$avg_pay",2);?> </span> </h5>
<h5  style="float:right;color:black;"> Total Payment Received: <span style="color:red;"><?php echo $varibl.number_format("$totall_trans",2);?> </span> </h5>
<br><br>
<h5  style="float:left;color:black;">Total Fees Paid: <span style="color:red;"><?php echo $varibl.number_format("$total_loan_fee",2);?> </span> </h5>
<h5  style="float:right;color:black;">Uncollected Payments: <span style="color:red;"><?php $uncollect=$pay_off-$totall_trans; if ($uncollect>0) {echo $varibl.number_format("$uncollect",2);} ?> </span> </h5>

<br>
</div>
<br><br><br><br>

      <div class="container-fluid">
         <div class="row"> 
         <div class="col-lg-6">
<h3>Loan Settings</h3>

</div>
         
          <div class="col-lg-6" align="right">
<a href="add_new_loan.php?id=<?php echo $id?>"> <button name="btn-submit" type="submit" class="btn btn-danger" style="background-color: #1E90FF;color: white;border-color: #1E90FF;">Add New Loan</button></a>


</div>
</div>
    <br>      
          <table class="table table-striped table-bordered">
<thead>
<tr style="background-color: #F5E09E;color: white">
<th style='width:30px;color:black;'>ID</th>
<th style='width:100px;color:black;'>Loan Amount</th>
<th style='width:100px;color:black;'>Loan Fee</th>
<th style='width:100px;color:black;'>Payoff Amount</th>
<th style='width:50px;color:black;'>Action</th>
</tr>
</thead>
<tbody>
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';;
$count=1;
if (isset($_GET['page_no']) && $_GET['page_no']!="") {
	$page_no = $_GET['page_no'];
	$count = $count + (25*($page_no-1));
	} else {
		$page_no = 1;
        }

	$total_records_per_page = 25;
    $offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2"; 

	$result_count = mysqli_query($con,"SELECT COUNT(*) As total_records FROM `tbl_loan_setting`");
	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1

    $result = mysqli_query($con,"SELECT * FROM `tbl_loan_setting` ORDER BY id  LIMIT $offset, $total_records_per_page");
    while($row = mysqli_fetch_array($result)){
		 $setting_id=$row['id'];
		 $loan_amount=$row['loan_amount'];
	     $loan_fee= $row['loan_fee'];
	      $payoff_amount=$loan_amount+$loan_fee;
		
		echo "<tr>
	 	      
			  <td>".$setting_id."</td>
			  <td>$".$loan_amount."</td>
	 		  <td>$".$loan_fee."</td>
	 		  <td>$".$payoff_amount."</td>
		   	  
<td><a href='edit_loan.php?setting_id=$setting_id&id=$id' title='Edit This User'><span class='glyphicon glyphicon-edit' aria-hidden='true' alt='edit'></span>Edit</a> -

<a class='remove-box' href='delete_setting_loan.php?setting_id=$setting_id&id=$id' title='Delete This User'><span class='glyphicon glyphicon-remove' aria-hidden='true' alt='delete'>Delete</span></a>

</td>

		   	  </tr>";
        }
	mysqli_close($con);
    ?>
</tbody>
</table>


        
        
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
