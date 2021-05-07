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
  <style>
      
      a.disabled {
  pointer-events: none;
  cursor: default;
}
  </style>

</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
       <?php include('horizontal_menu.php'); ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

       
      </nav>
      <br>
      
    
<br><br><br><br>

      <div class="container-fluid">
         <div class="row"> 
         <div class="col-lg-4">
<h3>All Installments</h3>

</div>
        
     
        
         
    
</div>
    <br>      
          <table class="table table-striped table-bordered">
<thead>
<tr style="background-color: #F5E09E;color: white">
<th style='width:7%;color:black;'>Loan ID</th>
<th style='width:21%;color:black;'>Customer Name</th>
<th style='width:8%;color:black;'>Payment</th>
<th style='width:8%;color:black;'>Interest</th>
<th style='width:8%;color:black;'>Principal</th>
<th style='width:8%;color:black;'>Balance</th>
<th style='width:14%;color:black;'>Deposite Frequency</th>
<th style='width:7%;color:black;'>Status</th>
<th style='width:12%;color:black;'>Payment Date</th>
<th style='width:7%;color:black;'>Action</th>
</tr>
</thead>
<tbody>
<?php


include('db.php');
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

	$result_count = mysqli_query($con,"SELECT COUNT(*) As total_records FROM `tbl_commercial_loan_installments` where status='0'");
	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1

    $result = mysqli_query($con, "select * from tbl_commercial_loan_installments where status='0'");
    while($row = mysqli_fetch_array($result)){
		 
		 $intallment_id=$row['id'];
		  $loan_create_id=$row['loan_create_id'];
	      $payment= $row['payment'];
	      $interest= $row['interest'];
	      $principal= $row['principal'];
	      $balance= $row['balance'];
	      $payment_date= $row['payment_date'];
	      $paid_date= $row['paid_date'];
	      $status= $row['status'];
	 $total_payment += $payment;
	 
	 $total_interest += $interest;
	 $total_principal += $principal;
	 $total_balance += $balance;
	$string_red_rejected = '';
	

	      
$result_query = mysqli_query($con, "select * from tbl_commercial_loan where loan_create_id='$loan_create_id'");
    while($row_payfre = mysqli_fetch_array($result_query)){
        $p_loan_id= $row_payfre['loan_id'];
        $user_fnd_id= $row_payfre['user_fnd_id'];
       $installment_plan= $row_payfre['installment_plan'];
       
       
     // echo "Fnd ID: ".$user_fnd_id."<br>";
      //echo "Loan ID: ".$loan_create_id."<br>";
    $result_query_customer = mysqli_query($con, "select * from fnd_user_profile where user_fnd_id='$user_fnd_id'");
    while($row_customer = mysqli_fetch_array($result_query_customer)){
        $first_name= $row_customer['first_name'];
        $last_name= $row_customer['last_name'];
       $customer_name= $first_name.' '.$last_name;
    }  
       
    }
    
   
	      
	  
if($status=='1')
{
    $installment_status="Paid";
    $string_red_rejected = 'style="color:green;font-weight:bold"';
 $a="<a href='add_new_transaction.php?intallment_id=$intallment_id&id=$p_loan_id' class='disabled'>PayNow</a>";
}

else
{
    $installment_status="Unpaid";
    $a="<a href='add_new_transaction.php?intallment_id=$intallment_id&id=$p_loan_id'>PayNow</a>";
}


$date=date('Y-m-d');

//echo $date;

if($date>$payment_date)
{
    $string_red_rejected = 'style="color:red;font-weight:bold"';
}	  
	  
	      
		echo "<tr ".$string_red_rejected.">
	 	      
			  <td>".$loan_create_id."</td>
			  <td>".$customer_name."</td>
			  <td>$".number_format($payment,   2, ".", ",")."</td>
	 		  <td>".number_format($interest,   2, ".", ",")."</td>
	 		  <td>".number_format($principal,   2, ".", ",")."</td>
			  <td>".number_format($balance,   2, ".", ",")."</td>
			  <td>".$installment_plan."</td>
			  <td>".$installment_status."</td>
              <td>".$payment_date."</td>
              <td>".$a."</td>
	 		  
		   	  </tr>";
		   	  	
		   	  
        }
        echo "<tr>
	 	      
			  <td>Total</td>
			  <td></td>
			  <td>$".number_format($total_payment,   2, ".", ",")."</td>
	 		  <td>$".number_format($total_interest,   2, ".", ",")."</td>
	 		  <td>$".number_format($total_principal,   2, ".", ",")."</td>
	 		  <td>$".number_format($total_balance,   2, ".", ",")."</td>
	 		  
		   	  </tr>";
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
