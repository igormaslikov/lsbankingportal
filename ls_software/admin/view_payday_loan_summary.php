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


  
  
  

mysqli_close($con);
?>

<div align="right">

<h4  style="float:left;">Customer's Payday Loan History:  </h4>

</div>

<br>

<div style="width:100%; margin:0 auto;">


<table class="table table-striped table-bordered">
<thead>
<tr style="background-color: #F5E09E;color: black;">
<th style='width:10%;'>Loan ID</th>
<th style='width:10%;color:black;'>Loan Amount</th>
<th style='width:15%;color:black;'>Loan Fee</th>
<th style='width:15%;color:black;'>Payoff Amount</th>
<th style='width:10%;color:black;'>Balance Due</th>
<th style='width:10%;color:black;'>DPD</th>
<th style='width:10%;color:black;'>APR</th>
<th style='width:10%;color:black;'>Loan Date</th>
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
       $payment_date =$row_bank_detail_sec['payment_date'];
       
       $query_payment = mysqli_query($con,"SELECT SUM(payoff_amount) AS value_sum FROM loan_transaction where loan_id= '$loan_id'");
while ($row_payment=mysqli_fetch_array($query_payment)){
    $payment = $row_payment['value_sum'];
    
    $payment = number_format((float)$payment, 2, '.', '');

   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$us;

}

 $now = time(); 
$your_date = strtotime($payment_date);

$datediff = $now-$your_date;

$datediff1= round($datediff / (60 * 60 * 24));
if ($datediff1<0)
{
    $datediff1=str_replace("-","","$datediff1");
    
}
       
    $calculation = $loan_fee/$amount_of_loan*365/$datediff1*100;
    $calculation = round($calculation, 2);
  	$anual_pr= $calculation;
    $anual_pr=str_replace("-","",$anual_pr);
    
       $balns_due =$loan_total_payable-$payment;
       $balns_due= number_format("$balns_due",2);
          
		 
	echo "<tr>
	 	      
			  <td>".$loan_create_id."</td>
			  <td>$".$amount_of_loan."</td>
	 		  <td>$".$loan_fee."</td>
	 		  <td>$".$loan_total_payable."</td>
	 		  <td>$".$balns_due."</td>
	 		  <td>".$datediff1."</td>
	 		  <td>$".$anual_pr."</td>
	 		  <td>".$contract_date."</td>
		   	  

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