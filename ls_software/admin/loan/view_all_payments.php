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

$payment_tenure =$row_loan['payment_tenure'];
$escrow=$row_loan['escrow'];
$primary_port=$row_loan['primary_portfolio'];
$creation_date=$row_loan['contract_date'];
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


?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

 <link href="bootstrap/css/bootstrap.minnnnnnnn.css" rel="stylesheet" media="screen">
 
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/simple-sidebar.css" rel="stylesheet">


<style>
    
    
    .chargeback_status{
        
        color:red;
        
    }
</style>


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
<div class="col-lg-3"><p>Money Amount: <b style="color:red"> <?php echo $val.$amount_loan;?></b></p></div>
<div class="col-lg-3"><p>Loan ID:<b style="color:red"> <?php echo $loan_create_id;?> </b> </p></div>
<div class="col-lg-3"><p>User ID:<b style="color:red"> <?php echo $user_fnd_id;?> </b> </p></div>

</div>
<br><br><br><br>

      <div class="container-fluid">
         <div class="row"> 
         <div class="col-lg-4">
<h3>All Payments</h3>

</div>
        
       <div class="col-lg-4" >
    <?php 
    if($payment>=$payoff OR  $loan_status== 'Paid')
           {
              echo "<a href='renew_loan.php?id=$id' <button name='btn' type='submit' class='btn btn-danger' style='background-image: linear-gradient(to bottom,#95c500 0,#639a0a 100%);
    color: #fff;
    background-color: #2a8206;
    border-color: #112f01;'>Renew Loan</button></a>";

               
            
           }
 ?>
</div>
        
       
        
         
          <div class="col-lg-4" align="right">
 <a href="add_new_transaction.php?id=<?php echo $id; ?>"> <button name="btn" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,red 0,red 100%);
    color: #fff;
    background-color: red;
    border-color: red;">Make New Payment</button></a>

</div>
</div>
    <br>      
          <table class="table table-striped table-bordered">
<thead>
<tr style="background-color: #F5E09E;color: white">
    <th style='width:13%;color:black;'>Transaction ID</th>
<th style='width:8%;color:black;'>Loan ID</th>
<th style='width:9%;color:black;'>Amount</th>
<th style='width:14%;color:black;'>Payment Method</th>
<th style='width:11%;color:black;'>Type Payment</th>
<th style='width:11%;color:black;'>Type of Loan</th>
<th style='width:11%;color:black;'>Payment Date</th>
<th style='width:11%;color:black;'>User Name</th>
<th style='width:12%;color:black;'>Details</th>
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

	$result_count = mysqli_query($con,"SELECT COUNT(*) As total_records FROM `loan_transaction` where loan_id='$id'");
	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1

    $result = mysqli_query($con, "select * from loan_transaction where loan_id='$id' order by transaction_id desc");
    while($row = mysqli_fetch_array($result)){
		 
		 $transaction_id=$row['transaction_id'];
		  $loan_create_id=$row['loan_create_id'];
	      $payment_method= $row['payment_method'];
	      $repay_transaction_id= $row['repay_transaction_id'];
	      $payoff_amount= $row['payoff_amount'];
	      $payment_date= $row['payment_date'];
	      $type_of_payment= $row['type_of_payment'];
	      $type_of_loan= $row['type_of_loan'];
	      $payment_description= $row['payment_description'];
	      $created_at= $row['created_at'];
	      $created_by_get_db_activity= $row['created_by'];
	      $chargeback_status=$row['chargeback_status'];
	      $chargeback=$row['chargeback'];
	       
	       $string_red_rejectedd = '';
	       $string_red_rejected = '';
	       	if ($chargeback_status=='1'){
		$string_red_rejected = 'style="color:#FF0000"';
	       	    
	       	}
	       	
	       	
	       	else if ($payment_method=='Charge Off'){
		$string_red_rejectedd = 'style="color:#FF0000"';
	}
	
	if($payment_method=='Repay')
	{
	   $transaction_id= $repay_transaction_id;
	}
	
	     
	      	
	      	$sql_activity_by_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by_get_db_activity'"); 
$final_activity_by_user = '';
while($row_sql_activity_by_user = mysqli_fetch_array($sql_activity_by_user)) {
	$final_activity_by_user = $row_sql_activity_by_user['username'];
}
	      	
	      	
	      	
	      	$timestamp = strtotime($payment_date);
            $payment_date= date("m-d-Y", $timestamp);
            
            $timestamp = strtotime($created_at);
            $created_at= date("m-d-Y", $timestamp);
	      
		echo "<tr ".$string_red_rejected.">
	 	     <td ".$string_red_rejectedd.">".$transaction_id."</td> 
			  <td>".$loan_create_id."</td>
			  <td>$".$payoff_amount."</td>
	 		  <td>".$payment_method."</td>
	 		  <td>".$type_of_payment."</td>
			  <td>".$type_of_loan."</td>
	 		  <td>".$payment_date."</td>
	 		  <td>".$final_activity_by_user."</td>
	 		  <td><a href='edit_payments.php?id=$transaction_id&loan_id=$id&method=$payment_method'>Edit</a> <a href='delete_reason_payments.php?id=$transaction_id&method=$payment_method'>Delete</a> <a href='chargeback.php?id=$transaction_id&method=$payment_method' title='Payment Chargeback'><i class='glyphicon glyphicon-circle-arrow-left' alt='Payment Chargeback'></i></a></td>
		   	  

		   	  </tr>";
        }
	mysqli_close($con);
    ?>
</tbody>
</table>
<?php
if($payoff_amount==''){
	          
		echo "<a href='add_loan_fee.php?id=".$id."'><button name='btn' type='submit' class='btn btn-danger' style='background-image: linear-gradient(to bottom,red 0,red 100%);
    color: #fff;
    background-color: red;
    border-color: red;'>Add NSF Fee</button></a> ";
		
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
