<?php
error_reporting(0);
session_start();

include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['email']; ?></title>

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />


<link rel="stylesheet" href="../paging/css/bootstrap.min.css">

<link rel="stylesheet" href="css/style1.css">  
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>


</head>
<body>

<?php include('menu.php') ;?>

<br>
<br>


  <section class="wrapper">
    <!-- Row title -->
<br><br>

<?php

$id=$_GET['id'];

$sql_t="SELECT * from tbl_loan where user_fnd_id=$id";

if ($result_t=mysqli_query($con,$sql_t))
  {
  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($result_t);
 // printf($rowcount);
  // Free result set
  $ye=mysqli_free_result($result_t);
  echo $ye;
  }
  
  
  $sql_persoanl="SELECT * from tbl_personal_loans where user_fnd_id=$id";

if ($result_personal=mysqli_query($con,$sql_persoanl))
  {
 
  $rowcount_persoanl=mysqli_num_rows($result_personal);
  
 }
  
  
  

mysqli_close($con);
?>

<div align="right">

<h4  style="float:left;">Customer's Payday Loans: <?php echo $rowcount;?>  </h4>

</div>

<br>

<div style="width:100%; margin:0 auto;">


<table class="table table-striped table-bordered">
<thead>
<tr style="background-color: #F5E09E;color: black;">
<th style='width:8%;'>Loan ID</th>
<th style='width:8%;color:black;'>Loan Amount</th>
<th style='width:16%;color:black;'>Loan Fee</th>
<th style='width:16%;color:black;'>Payoff Amount</th>
<th style='width:18%;color:black;'>Loan Date</th>
<th style='width:8%;color:black;'>Action</th>
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

	$result_count = mysqli_query($con,"SELECT COUNT(*) As total_records FROM tbl_loan where user_fnd_id=$id");
	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1

    $result = mysqli_query($con,"SELECT * FROM tbl_loan where user_fnd_id=$id LIMIT $offset, $total_records_per_page");
    while($row_bank_detail_sec = mysqli_fetch_array($result)){
		$loan_id=$row_bank_detail_sec['loan_id'];
       $amount_of_loan=$row_bank_detail_sec['amount_of_loan'];
       $loan_create_id=$row_bank_detail_sec['loan_create_id'];
       $loan_fee=$row_bank_detail_sec['loan_fee'];
       $loan_total_payable=$row_bank_detail_sec['loan_total_payable'];
       $contract_date=$row_bank_detail_sec['contract_date'];
		 
	echo "<tr>
	 	      
			  <td>".$loan_create_id."</td>
			  <td>".$amount_of_loan."</td>
	 		  <td>".$loan_fee."</td>
	 		  <td>".$loan_total_payable."</td>
	 		  <td>".$contract_date."</td>
	 		
	 		  <td><a href='view_payday_loan_summary.php?id=$id' title='Loan History'><span class='glyphicon glyphicon-edit' aria-hidden='true' alt='Loan History'></span></a>
</td>
		   	  

		   	  </tr>";
        }
	mysqli_close($con);
    ?>
</tbody>
</table>


</div>
    <br><hr><br>
    
    <div align="right">

<h4  style="float:left;">Customer's Pesonal Loans: <?php echo $rowcount_persoanl;?>  </h4>

</div>

<br>

<div style="width:100%; margin:0 auto;">


<table class="table table-striped table-bordered">
<thead>
<tr style="background-color: #F5E09E;color: black;">
<th style='width:8%;'>Loan ID</th>
<th style='width:16%;color:black;'>Account Status</th>
<th style='width:8%;color:black;'>Principal Balance</th>
<th style='width:16%;color:black;'>Expected Interest</th>
<th style='width:18%;color:black;'>Loan Date</th>
<th style='width:8%;color:black;'>Action</th>
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

	$result_count = mysqli_query($con,"SELECT COUNT(*) As total_records FROM tbl_personal_loans where user_fnd_id=$id");
	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1

    $result = mysqli_query($con,"SELECT * FROM tbl_personal_loans where user_fnd_id=$id LIMIT $offset, $total_records_per_page");
    while($row_bank_detail_sec = mysqli_fetch_array($result)){
	   $loan_id=$row_bank_detail_sec['p_loan_id'];
       $amount_of_loan=$row_bank_detail_sec['amount_of_loan'];
       $loan_create_id=$row_bank_detail_sec['loan_create_id'];
       $loan_status=$row_bank_detail_sec['loan_status'];
       $loan_total_payable=$row_bank_detail_sec['loan_total_payable'];
       $payment_date=$row_bank_detail_sec['payment_date'];
       $timestamp = strtotime($payment_date);
       $due_date= date("m-d-Y", $timestamp);
		 
	        $query_payment = mysqli_query($con,"SELECT SUM(interest) AS value_sum FROM tbl_personal_loan_installments where loan_create_id= '$loan_create_id'");
while ($row_payment=mysqli_fetch_array($query_payment)){
    $payment = $row_payment['value_sum'];
    
    $interest_amount = number_format((float)$payment, 2, '.', '');
break;
   // echo"<br>User_Key:" .$payment;

}  	 
		 
	echo "<tr>
	 	      
			  <td>".$loan_create_id."</td>
			  <td>".$loan_status."</td>
			  <td>$".$amount_of_loan."</td>
	 		  <td>$".$interest_amount."</td>
	 		  <td>".$due_date."</td>
	 		
	 		  <td><a href='#?id=$id' title='loan History'><span class='glyphicon glyphicon-edit' aria-hidden='true' alt='Loan History'></span></a>
</td>
		   	  

		   	  </tr>";
        }
	mysqli_close($con);
    ?>
</tbody>
</table>


</div>
    
  </section>

  <style>
      .navbar-default{
          background-color:#fb3f06 !important;
      }
      
  </style>
<script type="text/javascript">
    $('.remove-box').on('click', function () {
      var x =  confirm('Are you sure you want to delete?');
      if (x)
      return true;
  else
    return false;
      
    });
</script>

</body>
</html>
<?php 
}
?>