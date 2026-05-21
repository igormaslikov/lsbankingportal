<?php
error_reporting(0);

session_start();
include_once '../dbconnect.php';
include '../dbconfig.php';
include_once '../security.php';

require_login();

$user_id_s = (int)$_SESSION['userSession'];
$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=" . $user_id_s);
$userRow = $query->fetch_array();
$u_id = $userRow['user_id'];
$u_access_id = $userRow['access_id'];
if (in_array((string)$u_access_id, ['2','4','5'])) {
    http_response_code(403);
    die('YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.');
}
$DBcon->close();
if (true) { // preserve else block structure

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['email']; ?></title>

<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="../bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">

<link rel="stylesheet" href="../style.css" type="text/css" />

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>


  <section class="wrapper">
    <!-- Row title -->

<br><br>
 <?php

include '../functions.php';

// Status Fund Start
if (isset($_GET["fund_status"])) {
    $loan_id_fund_status = trim($_GET['loan_id'] ?? '');
    if ($loan_id_fund_status !== '') {
        $con->query("UPDATE tbl_loan SET fund_status = '1' WHERE loan_create_id = ?", [$loan_id_fund_status]);
    }
    $application_id = "";
    $status = "Loan Has Been Funded";
    $loan_transaction_id = "";
    application_notes_update($application_id,$loan_id_fund_status,$u_id,$status,$loan_transaction_id);


}

// Status Fund End


// Check connection


$status    = $_GET['status']    ?? '';
$keyword   = $_GET['keyword']   ?? '';
$from_date = $_GET['from_date'] ?? '';
$loan_date = $_GET['loan_date'] ?? '';
$due_date  = $_GET['due_date']  ?? '';
$to_date   = $_GET['to_date']   ?? '';

$where_parts = [
    "sign_status = '1'",
    "payment_date >= CAST(GETDATE() AS DATE)",
    "loan_status != 'Paid'",
];
$search_params = [];

if ($status !== '' && $status !== 'All') {
    $where_parts[] = "loan_status = ?";
    $search_params[] = $status;
}
if ($keyword !== '') {
    $where_parts[] = "loan_create_id = ?";
    $search_params[] = $keyword;
}
if ($from_date !== '' && $to_date !== '') {
    $where_parts[] = "(last_payment_date BETWEEN ? AND ?)";
    $search_params[] = $from_date;
    $search_params[] = $to_date;
}
if ($loan_date !== '' && $to_date !== '') {
    $where_parts[] = "(contract_date BETWEEN ? AND ?)";
    $search_params[] = $loan_date;
    $search_params[] = $to_date;
}
if ($due_date !== '' && $to_date !== '') {
    $where_parts[] = "(payment_date BETWEEN ? AND ?)";
    $search_params[] = $due_date;
    $search_params[] = $to_date;
}

$query_search = "SELECT * FROM tbl_loan WHERE " . implode(" AND ", $where_parts);

$rowcount = 0;
$result_t = $con->query($query_search, $search_params);
if ($result_t) {
    $rowcount = $result_t->num_rows;
}

?>
    <?php


$us = 0; $pay_off = 0; $totall_trans = 0;

$query_us = $con->query("SELECT SUM(TRY_CAST(amount_of_loan AS DECIMAL(18,2))) AS value_sum FROM tbl_loan where sign_status= '1'");
if ($query_us && ($row_us = $query_us->fetch_array())) {
    $us = (float)($row_us['value_sum'] ?? 0);
}

$query_le = $con->query("SELECT SUM(TRY_CAST(loan_total_payable AS DECIMAL(18,2))) AS value_sum FROM tbl_loan where sign_status= '1'");
if ($query_le && ($row_le = $query_le->fetch_array())) {
    $pay_off = (float)($row_le['value_sum'] ?? 0);
}

$query_trns = $con->query("SELECT SUM(TRY_CAST(payoff_amount AS DECIMAL(18,2))) AS value_sum FROM loan_transaction ");
if ($query_trns && ($row_trns = $query_trns->fetch_array())) {
    $totall_trans = (float)($row_trns['value_sum'] ?? 0);
}
$totall_trans = number_format((float)$totall_trans, 2, '.', '');

 $pay_off = number_format((float)$pay_off, 2, '.', '');
$avg_pay_off = ($rowcount > 0) ? ($pay_off / $rowcount) : 0;

$avg_pay=round($avg_pay_off, 2);

$avg_amount = ($rowcount > 0) ? ($us / $rowcount) : 0;

$avg = number_format((float)$avg_amount, 2, '.', '');


 $sql_fees="SELECT loan_create_id, COUNT(*) FROM loan_transaction GROUP BY loan_create_id;";

if ($result_fees=$con->query($sql_fees))
  {
  // Return the number of rows in result set
  $rowcount_fees=$result_fees->num_rows;
  }

$sql=$con->query("select * from tbl_loan where sign_status = '1' AND payment_date >= CAST(GETDATE() AS DATE) AND loan_status!='Paid' ORDER BY payment_date ASC");
$total_loan_fee="0";
while ($sql && ($row = $sql->fetch_array())) {

$userfnd_id=$row['user_fnd_id'];
$loan_status=$row['loan_status'];
$loan_id_fee=$row['loan_id'];
 $amount_of_loan_fee=$row['amount_of_loan'];

$query_payment_fee = $con->query("SELECT SUM(TRY_CAST(payoff_amount AS DECIMAL(18,2))) AS value_summ FROM loan_transaction where loan_id= '$loan_id_fee'");
while ($query_payment_fee && ($row_payment_fee = $query_payment_fee->fetch_array())){
    $payment_fee = $row_payment_fee['value_summ'];

    $payment_fee = number_format((float)$payment_fee, 2, '.', '');
break;
}

$loan_payment_fee=$payment_fee-$amount_of_loan_fee;
if($loan_payment_fee>0)
{
$total_loan_fee+=$loan_payment_fee;
}
}


?>

<div align="right" style="padding:30px;background-color: #F5E09E;color: white">
     <a href="unsigned_payday_loans.php"> <button name="btn-submit" type="submit" class="btn btn-danger" style="background-color: #1E90FF;color: white;border-color: #1E90FF;">Unsigned Payday Loans</button></a>
     <a href="repeat_loan.php"> <button name="btn-submit" type="submit" class="btn btn-danger" style="background-color: #1E90FF;color: white;border-color: #1E90FF;">Loan Repeat Summary</button></a>
    <a href="loan_settings.php"> <button name="btn-submit" type="submit" class="btn btn-danger" style="background-color: #1E90FF;color: white;border-color: #1E90FF;">Loan Settings</button></a>
<a href="../search_customer.php"> <button name="btn-submit" type="submit" class="btn btn-danger" style="background-color: #1E90FF;color: white;border-color: #1E90FF;">Add New Loan</button></a>

<br><br><br>
<h4  style="float:left;color:black;"> Total Loan Accounts: <span style="color:red;"><?php echo $rowcount;?> </span> </h4>
<h4  style="float:right;color:black;"> Total Loan Amounts: <span style="color:red;"><?php echo $varibl.number_format((float)$us,2);?> </span> </h4>
<br><br>
<h4  style="float:right;color:black;"> Total Payoff Amounts: <span style="color:red;"><?php echo $varibl.number_format((float)$pay_off,2);?></span>  </h4>
<h4  style="float:left;color:black;"> Avg. Loan Amount: <span style="color:red;"><?php echo $varibl.number_format((float)$avg,2);?> </span> </h4>
<br><br>
<h4  style="float:left;color:black;"> Avg. Payoff Amount: <span style="color:red;"><?php echo $varibl.number_format((float)$avg_pay,2);?> </span> </h4>
<h4  style="float:right;color:black;"> Total Payment Received: <span style="color:red;"><?php echo $varibl.number_format((float)$totall_trans,2);?> </span> </h4>
<br><br>
<h4  style="float:left;color:black;">Total Fees Paid: <span style="color:red;"><?php echo $varibl.number_format((float)$total_loan_fee,2);?> </span> </h4>
<h4  style="float:right;color:black;">Uncollected Payments: <span style="color:red;"><?php $uncollect=$pay_off-$totall_trans; if ($uncollect>0) {echo $varibl.number_format((float)$uncollect,2);} ?> </span> </h4>

<br>
</div>




<br>
<form action="upcoming_payday.php" method="GET">
<table class="table table-striped tasks-table" id="table_bg" style="font-size:15px !important">
<thead align="center">
<tr>

    <td colspan="2" style="font-weight: bold;">
Account Status
<select name="status" id="app_status" class="form-control"  value="" style="padding: 6px 15px;">
<option value="All" <?php if(($status ?? '')=='All'){ echo 'selected';}?>>All</option>
<option value="Active" <?php if(($status ?? '')=='Active'){ echo 'selected';} ?>>Active</option>
<option value="Paid" <?php if(($status ?? '')=='Paid'){ echo 'selected';} ?>>Paid</option>
<option value="Past Due" <?php if(($status ?? '')=='Past Due'){ echo 'selected';} ?>>Past Due</option>
<option value="Promise to Pay" <?php if(($status ?? '')=='Promise to Pay'){ echo 'selected';} ?>>Promise to Pay</option>
<option value="Payment Plan" <?php if(($status ?? '')=='Payment Plan'){ echo 'selected';} ?>>Payment Plan</option>
<option value="Collections" <?php if(($status ?? '')=='Collections'){ echo 'selected';} ?>>Collections</option>
<option value="Chargeoff" <?php if(($status ?? '')=='Chargeoff'){ echo 'selected';} ?>>Chargeoff</option>
<option value="Closed Account" <?php if(($status ?? '')=='Closed Account'){ echo 'selected';} ?>>Closed Account</option>
<option value="Chargeback"<?php if(($status ?? '')=='Chargeback'){ echo 'selected';}?>>Chargeback</option>
<option value="Bankruptcy"<?php if(($status ?? '')=='Bankruptcy'){ echo 'selected';}?>>Bankruptcy</option>
<option value="Pending"<?php if(($status ?? '')=='Pending'){ echo 'selected';}?>>Pending</option>
<option value="Disbursement"<?php if(($status ?? '')=='Disbursement'){ echo 'selected';}?>>Disbursement</option>
</select>
</td>




<td colspan="2" style="font-weight: bold;">

Search Loan By ID
<input type="text" id="search" class="form-control" name="keyword" placeholder="" value="<?php echo $keyword ?? ''; ?>">

</td>


<td colspan="2" style="font-weight: bold;">

Loan Date:
<input type="date" id="loan_date" class="form-control" name="loan_date" placeholder="" value="" style="line-height:20px">

</td>

<td colspan="2" style="font-weight: bold;">

Due Date:
<input type="date" id="due_date" class="form-control" name="due_date" placeholder="" value="" style="line-height:20px">

</td>

<td colspan="2" style="font-weight: bold;">

Payment Date:
<input type="date" id="from_date" class="form-control" name="from_date" placeholder="" value="" style="line-height:20px">

</td>

<td colspan="2" style="font-weight: bold;">

 To Date:
<input type="date" id="to_date" class="form-control" name="to_date" placeholder="" value="" style="line-height:20px">

</td>

<td colspan="1">

<a href="#"> <button style="background-color: #1E90FF;color: white;border-color: #1E90FF;margin-top:20px;" name="search" type="submit" class="btn">Search</button></a>
</td>
</tr>
</thead>

</table>

<div style="width:100%; margin:0 auto;">

<?php // echo $query_search;?>

<table class="table table-striped table-bordered">
<thead>
<tr style="background-color: #F5E09E;color: white;">
<th style='width:1%;color:black;text-align:center;'>Loan</th>
<th style='width:7%;color:black;text-align:center;'>Account Status</th>
<th style='width:15%;color:black;text-align:center;'>Customers Name</th>
<th style='width:9%;color:black;text-align:center;'>Phone Number</th>
<th style='width:7%;color:black;text-align:center;'>Loan Amount</th>
<th style='width:1%;color:black;text-align:center;'>Fee</th>
<th style='width:7%;color:black;text-align:center;'>Payoff Amount</th>
<th style='width:10%;color:black;text-align:center;'>Loan Date</th>
<th style='width:9%;color:black;text-align:center;'>Due Date</th>
<th style='width:9%;color:black;text-align:center;'>Payment Date</th>
<th style='width:1%;color:black;text-align:center;'>DPD</th>
<th style='width:1%;color:black;text-align:center;'>LH</th>
<th style='width:7%;color:black;text-align:center;'>Balance Due</th>
<th style='width:16%;color:black;text-align:center;'>Action</th>
</tr>
</thead>
<tbody>

<?php
include('../db.php');
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

	$result_count2 = $con->query("SELECT COUNT(*) As total_records FROM tbl_loan where sign_status= '1' AND payment_date >= CAST(GETDATE() AS DATE) AND loan_status!='Paid'");
	$total_records2 = $result_count2 ? $result_count2->fetch_array() : null;
	$total_records2 = $total_records2['total_records'] ?? 0;
	$total_records2 = $rowcount;
    $total_no_of_pages = ceil($total_records2 / $total_records_per_page);
	$second_last = $total_no_of_pages - 1;


$data_query_search = "SELECT * FROM tbl_loan WHERE sign_status= '1' AND payment_date >= CAST(GETDATE() AS DATE) AND loan_status!='Paid'";

$status2    = $_GET['status']    ?? '';
$keyword2   = $_GET['keyword']   ?? '';
$from_date2 = $_GET['from_date'] ?? '';
$loan_date2 = $_GET['loan_date'] ?? '';
$due_date2  = $_GET['due_date']  ?? '';
$to_date2   = $_GET['to_date']   ?? '';

$and_check2 = 0;
if ($status2 != "" && $status2 != "All") {
    $data_query_search .= " AND loan_status = '$status2' ";
    $and_check2 = 1;
}
if ($keyword2 != "") {
    $data_query_search .= " AND loan_create_id = '$keyword2'";
    $and_check2 = 2;
}
if ($from_date2 != "") {
    $data_query_search .= " AND (last_payment_date BETWEEN '$from_date2' AND '$to_date2')";
}
if ($loan_date2 != "") {
    $data_query_search .= " AND (contract_date BETWEEN '$loan_date2' AND '$to_date2')";
}
if ($due_date2 != "") {
    $data_query_search .= " AND (payment_date BETWEEN '$due_date2' AND '$to_date2')";
}

$data_query_search .= " ORDER BY payment_date ASC OFFSET $offset ROWS FETCH NEXT $total_records_per_page ROWS ONLY";

    $result = $con->query($data_query_search);
    while ($result && ($row = $result->fetch_array())){
        $loan_id_calculation= $row['loan_id'];
        $user_fnd_id = $row['user_fnd_id'];
        $result_user_fdn = $con->query("Select * from fnd_user_profile where user_fnd_id = '$user_fnd_id' ");
        while ($result_user_fdn && ($row_user_fdn = $result_user_fdn->fetch_array())){
            $user_name = $row_user_fdn['first_name'];
            $last_name = $row_user_fdn['last_name'];
            $user_mobile = $row_user_fdn['mobile_number'];
        }

$query_payment = $con->query("SELECT SUM(TRY_CAST(payoff_amount AS DECIMAL(18,2))) AS value_sum FROM loan_transaction where loan_id= '$loan_id_calculation'");
while ($query_payment && ($row_payment = $query_payment->fetch_array())){
    $payment = $row_payment['value_sum'];
    $payment = number_format((float)$payment, 2, '.', '');
break;
}

        $result_user_totalloan = $con->query("Select * from tbl_loan where user_fnd_id = '$user_fnd_id' AND sign_status = '1' ");
        $total_loans_lh = 0;
        while ($result_user_totalloan && ($row_user_totalloan = $result_user_totalloan->fetch_array())){
            $total_loans_lh = $total_loans_lh+1;
        }

         $loan_create_id=$row['loan_create_id'];
         $id=$row['loan_id'];
         $loan_status=$row['loan_status'];
          $amount_of_loan=$row['amount_of_loan'];
          $payment_date= $row['payment_date'];
          $fee=$row['loan_fee'];
           $payoff=$row['loan_total_payable'];
           $last_payment_date=$row['last_payment_date'];

     $string_red_rejected = '';
	if ($row['loan_status'] == 'Active'){
		$string_red_rejected = 'style="color:green"';
	}
else if ($row['loan_status'] == 'Paid'){
		$string_red_rejected = 'style="color:black"';
	}
else if ($row['loan_status'] == 'Past Due'){
		$string_red_rejected = 'style="color:#ff8c00"';
	}
else if ($row['loan_status'] == 'Promise to Pay' || $row['loan_status']=='Payment Plan'){
		$string_red_rejected = 'style="color:#1E90FF"';
	}
else if ($row['loan_status'] == 'Collections'){
		$string_red_rejected = 'style="color:#999900"';
	}
else if ($row['loan_status'] == 'Chargeoff' || $row['loan_status']=='Closed Account' || $row['loan_status']=='Chargeback' || $row['loan_status']=='Bankruptcy'){
		$string_red_rejected = 'style="color:red"';
	}

           $timestamp = strtotime($last_payment_date);
           $last_payment_date_fmt= date("m-d-Y", $timestamp);

       $contract_date= $row['contract_date'];
       $timestamp = strtotime($contract_date);
       $new_contract= date("m-d-Y", $timestamp);

       $timestamp = strtotime($payment_date);
       $due_date_fmt= date("m-d-Y", $timestamp);

	 $now = time();
$your_date = strtotime($payment_date);
$datediff = $now-$your_date;
$datediff1= round($datediff / (60 * 60 * 24));
 if ($datediff1<0) { $datediff1=0; }

if ($last_payment_date_fmt=='01-01-1970') { $last_payment_date_fmt=''; }

   $balns_due =$payoff-$payment;
  $balns_due= number_format((float)$balns_due,2);

          $make_payment= "<a href='add_new_transaction.php?id=$id'  title='Make Payment' style='color:red;'><span class='glyphicon glyphicon-usd' aria-hidden='true' alt='Make Payment'></span></a>";
		echo "<tr ".$string_red_rejected.">

			  <td style='text-align:center;'>".$loan_create_id."</td>
			  <td style='text-align:center;'>".$loan_status."</td>
			  <td style='text-align:center;'>".$user_name." ".$last_name."</td>
			  <td style='text-align:center;'>".$user_mobile."</td>
			  <td style='text-align:center;'>".$varibl.$amount_of_loan."</td>
			  <td style='text-align:center;'>".$varibl.$fee."</td>
	 		  <td style='text-align:center;'>".$varibl.$payoff."</td>
	 		  <td style='text-align:center;'>".$new_contract."</td>
	 		  <td style='text-align:center;'>".$due_date_fmt."</td>
	 		  <td style='text-align:center;'>".$last_payment_date_fmt."</td>
		   	  <td style='text-align:center;'>".$datediff1."</td>
		   	  <td style='text-align:center;'>".$total_loans_lh."</td>
		   	  <td style='text-align:center;'>$".$balns_due."</td>



<td style='text-align:center;'><a href='view_payday_loan_summary.php?id=$id'  title='View Summary' style='color:black;margin-right:4px;'><span class='glyphicon glyphicon-user' aria-hidden='true' alt='edit'></span></a>
".$make_payment."
</td>


		   	  </tr>";
    }

    ?>

</tbody>
</table>
<?php //echo $query_search; ?>
<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
<strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
</div>

<ul class="pagination">
	<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
	<a <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?>>Previous</a>
	</li>

    <?php
	if ($total_no_of_pages <= 10){
		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
			if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}
        }
	}
	elseif($total_no_of_pages > 10){

	if($page_no <= 4) {
	 for ($counter = 1; $counter < 8; $counter++){
			if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}
        }
		echo "<li><a>...</a></li>";
		echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
		echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
		}

	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {
		echo "<li><a href='?page_no=1'>1</a></li>";
		echo "<li><a href='?page_no=2'>2</a></li>";
        echo "<li><a>...</a></li>";
        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
           if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}
       }
       echo "<li><a>...</a></li>";
	   echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
	   echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
            }

		else {
        echo "<li><a href='?page_no=1'>1</a></li>";
		echo "<li><a href='?page_no=2'>2</a></li>";
        echo "<li><a>...</a></li>";

        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
          if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}
                }
            }
	}
?>

	<li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
	<a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?>>Next</a>
	</li>
    <?php if($page_no < $total_no_of_pages){
		echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
		} ?>
</ul>


<br /><br />

</div>
 </form>

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
