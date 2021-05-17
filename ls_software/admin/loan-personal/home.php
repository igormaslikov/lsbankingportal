<?php
error_reporting(0);

$id=$_GET['id'];
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
 session_start();
}
else {
$DBcon->close();

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
 
include $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

// Check connection


$query_search = "SELECT * FROM `tbl_personal_loans` order by p_loan_id DESC";
 
    $status  = $_GET['status'];
    $keyword = $_GET['keyword'];
    $from_date = $_GET['from_date'];
    $loan_date = $_GET['loan_date'];
    $due_date = $_GET['due_date'];
    $to_date = $_GET['to_date'];
   
if ((isset($_GET['status']) && $_GET['status']!='All') || (isset($_GET['keyword']) && $_GET['keyword']!='') || isset($_GET['from_date'])  || isset($_GET['loan_date']) || isset($_GET['due_date']) || isset($_GET['to_date'])) {
    $query_search .= "WHERE";
}
  $and_check = 0;
if (isset($_GET['status']) && $_GET['status']!="" && $_GET['status']!="All") {
    $query_search .= " loan_status = '$status' ";
  $and_check = 1;
}
if (isset($_GET['keyword']) &&  $_GET['keyword'] !="") {
    if($and_check>0){
      $query_search .= " AND ";
      $and_check = 2;
    }
   $query_search .= "  loan_create_id = '$keyword'";
  
}

if ($_GET['from_date']!="") {
  if($and_check>1 || $and_check>0){
      $query_search .= " AND ";
      //$and_check = 2;
    }
    $query_search .= " (last_payment_date BETWEEN '$from_date' AND '$to_date')";
}if (isset($_GET['to_date'])) {
    //$query_search .= " WHERE ";
}

if ($_GET['loan_date']!="") {
  if($and_check>1 || $and_check>0){
      $query_search .= " AND ";
      //$and_check = 2;
    }
    $query_search .= " (contract_date BETWEEN '$loan_date' AND '$to_date')";
}if (isset($_GET['to_date'])) {
    //$query_search .= " WHERE ";
}

if ($_GET['due_date']!="") {
  if($and_check>1 || $and_check>0){
      $query_search .= " AND ";
      //$and_check = 2;
    }
    $query_search .= " (payment_date BETWEEN '$due_date' AND '$to_date')";
}if (isset($_GET['to_date'])) {
    //$query_search .= " WHERE ";
}

//$query_search .= "order by loan_create_id asc Limit ". $offset. ", ". $total_records_per_page;

if ($result_t=mysqli_query($con,$query_search))
  {
  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($result_t);
 // printf($rowcount);
  // Free result set
  $ye=mysqli_free_result($result_t);
  echo $ye;
  }

?>
    <?php


$query_us = mysqli_query($con,"SELECT SUM(principal_amount) AS value_sum FROM tbl_personal_loans where sign_status= '1'");
while ($row_us=mysqli_fetch_array($query_us)){
    $us = $row_us['value_sum'];
    
    $us = number_format((float)$us, 2, '.', '');
break;

}


$query_le = mysqli_query($con,"SELECT SUM(payment) AS value_sum FROM tbl_personal_loan_installments where status= '0'");
while ($row_le=mysqli_fetch_array($query_le)){
    $pay_off = $row_le['value_sum'];
break;
}

$query_trns = mysqli_query($con,"SELECT SUM(principal_amount) AS value_sum FROM personal_loan_transaction ");
while ($row_trns=mysqli_fetch_array($query_trns)){
    $totall_trans = $row_trns['value_sum'];
break;
}
$totall_trans = number_format((float)$totall_trans, 2, '.', '');

 $pay_off = number_format((float)$pay_off, 2, '.', '');
$avg_pay_off= $pay_off/$rowcount;

$avg_pay=round($avg_pay_off, 2);

$avg_amount=$us/$rowcount;

$avg = number_format((float)$avg_amount, 2, '.', '');


$query_interest = mysqli_query($con,"SELECT SUM(interest) AS value_sum FROM personal_loan_transaction ");
while ($row_interest=mysqli_fetch_array($query_interest)){
    $total_loan_fee = $row_interest['value_sum'];
break;
}

$query_pament_amount = mysqli_query($con,"SELECT SUM(payment_amount) AS value_sum FROM personal_loan_transaction ");
while ($row_pament_amount=mysqli_fetch_array($query_pament_amount)){
    $totall_pament_amount = $row_pament_amount['value_sum'];
break;
}



?>

<div align="right" style="padding:30px;background-color: #F5E09E;color: white">
    <a href="view_upcoming_installments.php"> <button name="btn-submit" type="submit" class="btn btn-danger" style="background-color: #1E90FF;color: white;border-color: #1E90FF;">View All Upcoming Installments</button></a>
    <a href="unsigned_personal_loans.php"> <button name="btn-submit" type="submit" class="btn btn-danger" style="background-color: #1E90FF;color: white;border-color: #1E90FF;">Unsigned Personal Loans</button></a>
     <a href="repeat_loan.php"> <button name="btn-submit" type="submit" class="btn btn-danger" style="background-color: #1E90FF;color: white;border-color: #1E90FF;">Loan Repeat Summary</button></a>
    <a href="loan_settings.php"> <button name="btn-submit" type="submit" class="btn btn-danger" style="background-color: #1E90FF;color: white;border-color: #1E90FF;">Loan Settings</button></a>
<a href="../search_customer.php"> <button name="btn-submit" type="submit" class="btn btn-danger" style="background-color: #1E90FF;color: white;border-color: #1E90FF;">Add New Loan</button></a>

<br><br><br>
<div  style="float:left;color:black;font-size:18px"> Total Loan Accounts: <span style="color:red;"><?php echo $rowcount;?> </span> </div>
<div  style="float:right;color:black;font-size:18px"> Total Loan Amounts: <span style="color:red;"><?php echo $varibl.number_format("$us",2);?> </span> </div>
<br><br>
<div  style="float:right;color:black;font-size:18px"> Total Payoff Amounts: <span style="color:red;"><?php echo $varibl.number_format("$pay_off",2);?></span>  </div>
<div  style="float:left;color:black;font-size:18px"> Avg. Loan Amount: <span style="color:red;"><?php echo $varibl.number_format("$avg",2);?> </span> </div>
<br><br>
<div  style="float:left;color:black;font-size:18px"> Avg. Payoff Amount: <span style="color:red;"><?php echo $varibl.number_format("$avg_pay",2);?> </span> </div>
<div  style="float:right;color:black;font-size:18px"> Total Payment Received: <span style="color:red;"><?php echo $varibl.number_format("$totall_trans",2);?> </span> </div>
<br><br>
<div  style="float:left;color:black;font-size:18px">Total Interest Collected: <span style="color:red;"><?php echo $varibl.number_format("$total_loan_fee",2);?> </span> </div>
<div  style="float:right;color:black;font-size:18px">Uncollected Payments: <span style="color:red;"><?php $uncollect=$pay_off-$totall_pament_amount; if ($uncollect>0) {echo $varibl.number_format("$uncollect",2);} ?> </span> </div>

<br>
</div>




<br>
<form action="home.php" method="GET">
<table class="table table-striped tasks-table" id="table_bg" style="font-size:15px !important">
<thead align="center">
<tr>
    
    <td colspan="2" style="font-weight: bold;">
Account Status
<select name="status" id="app_status" class="form-control"  value="" style="padding: 6px 15px;">
<option value="All" <?php if($_GET['status']=='All'){ echo 'selected';}?>>All</option>
<option value="Active" <?php if($_GET['status']=='Active'){ echo 'selected';} ?>>Active</option>
<option value="Paid" <?php if($_GET['status']=='Paid'){ echo 'selected';} ?>>Paid</option>
<option value="Past Due" <?php if($_GET['status']=='Past Due'){ echo 'selected';} ?>>Past Due</option>
<option value="Promise to Pay" <?php if($_GET['status']=='Promise to Pay'){ echo 'selected';} ?>>Promise to Pay</option>
<option value="Payment Plan" <?php if($_GET['status']=='Payment Plan'){ echo 'selected';} ?>>Payment Plan</option>
<option value="Collections" <?php if($_GET['status']=='Collections'){ echo 'selected';} ?>>Collections</option>
<option value="Chargeoff" <?php if($_GET['status']=='Chargeoff'){ echo 'selected';} ?>>Chargeoff</option>
<option value="Closed Account" <?php if($_GET['status']=='Closed Account'){ echo 'selected';} ?>>Closed Account</option>
<option value="Chargeback"<?php if($_GET['status']=='Chargeback'){ echo 'selected';}?>>Chargeback</option>
<option value="Bankruptcy"<?php if($_GET['status']=='Bankruptcy'){ echo 'selected';}?>>Bankruptcy</option>
</select>
</td>  


<td colspan="2" style="font-weight: bold;">
          
Search Loan By ID
<input type="text" id="search" class="form-control" name="keyword" placeholder="" value="<?php echo $_GET['keyword']; ?>">

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
<th style='width:10%;color:black;text-align:center;'>Account Status</th>
<th style='width:15%;color:black;text-align:center;'>Customers Name</th>
<th style='width:12%;color:black;text-align:center;'>Phone Number</th>
<th style='width:11%;color:black;text-align:center;'>Principal Balance</th>
<th style='width:12%;color:black;text-align:center;'>Expected Interest</th>
<th style='width:10%;color:black;text-align:center;'>Loan Date</th>
<th style='width:9%;color:black;text-align:center;'>Due Date</th>
<th style='width:9%;color:black;text-align:center;'>Payment Date</th>
<th style='width:10%;color:black;text-align:center;'>Action</th>
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
$total_records_per_page = 200;

	
    $offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2"; 

	$result_count = mysqli_query($con,"SELECT COUNT(*) As total_records FROM `tbl_personal_loans` where sign_status= '1'");
	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
	$total_records = $rowcount;
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1
	

$query_search = "SELECT * FROM `tbl_personal_loans`";
 

    $status  = $_GET['status'];
    $keyword = $_GET['keyword'];
    $from_date = $_GET['from_date'];
    $loan_date = $_GET['loan_date'];
    $due_date = $_GET['due_date'];
    $to_date = $_GET['to_date'];
   
if ((isset($_GET['status']) && $_GET['status']!='All') || (isset($_GET['keyword']) && $_GET['keyword']!='') || isset($_GET['from_date'])  || isset($_GET['loan_date']) || isset($_GET['due_date']) || isset($_GET['to_date'])) {
    $query_search .= "WHERE";
}
  $and_check = 0;
if (isset($_GET['status']) && $_GET['status']!="" && $_GET['status']!="All") {
    $query_search .= " loan_status = '$status' ";
  $and_check = 1;
}
if (isset($_GET['keyword']) &&  $_GET['keyword'] !="") {
    if($and_check>0){
      $query_search .= " AND ";
      $and_check = 2;
    }
   $query_search .= "  loan_create_id = '$keyword'";
  
}

if ($_GET['from_date']!="") {
  if($and_check>1 || $and_check>0){
      $query_search .= " AND ";
      //$and_check = 2;
    }
    $query_search .= " (last_payment_date BETWEEN '$from_date' AND '$to_date')";
}if (isset($_GET['to_date'])) {
    //$query_search .= " WHERE ";
}

if ($_GET['loan_date']!="") {
  if($and_check>1 || $and_check>0){
      $query_search .= " AND ";
      //$and_check = 2;
    }
    $query_search .= " (contract_date BETWEEN '$loan_date' AND '$to_date')";
}if (isset($_GET['to_date'])) {
    //$query_search .= " WHERE ";
}

if ($_GET['due_date']!="") {
  if($and_check>1 || $and_check>0){
      $query_search .= " AND ";
      //$and_check = 2;
    }
    $query_search .= " (payment_date BETWEEN '$due_date' AND '$to_date')";
}if (isset($_GET['to_date'])) {
    //$query_search .= " WHERE ";
}

$query_search .= "order by loan_create_id DESC Limit ". $offset. ", ". $total_records_per_page;
 

	

    $result = mysqli_query($con,"$query_search");
    while($row = mysqli_fetch_array($result)){
        $loan_id_calculation= $row['p_loan_id'];
        $user_fnd_id = $row['user_fnd_id'];
        $result_user_fdn = mysqli_query($con,"Select * from `fnd_user_profile` where user_fnd_id = '$user_fnd_id' ");
        while($row_user_fdn = mysqli_fetch_array($result_user_fdn)){
            $user_name = $row_user_fdn['first_name'];
            $last_name = $row_user_fdn['last_name'];
            $user_mobile = $row_user_fdn['mobile_number'];
            $decision_logic_status= $row_user_fdn['decision_logic_status'];

            
        }
        
  
        
        
    


        $result_user_totalloan = mysqli_query($con,"Select * from `tbl_personal_loans` where user_fnd_id = '$user_fnd_id' AND sign_status = '1' ");
        $total_loans_lh = 0;
        while($row_user_totalloan = mysqli_fetch_array($result_user_totalloan)){
            $total_loans_lh = $total_loans_lh+1;
            
            
        }
        
       

         $loan_create_id=$row['loan_create_id'];
         $id=$row['p_loan_id'];
         $loan_status=$row['loan_status'];
          $amount_of_loan=$row['principal_amount'];
          $balance_due=$row['balance_due'];
          $payment_date= $row['payment_date'];
           $daily_interest=$row['daily_interest'];
           $last_payment_date=$row['last_payment_date'];
          
          
          $date1 = date_create($payment_date);
$date2 = date_create($last_payment_date);

//difference between two dates
$diff = date_diff($date1,$date2);

//count days
$days_between= $diff->format("%r%a");

          
        
//echo"days_between" .$days_between;
     //******************************************************** Color Status ***********************************************
     
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
     
     //********************************************************* Color Status End ********************************************
          
           $query_payment = mysqli_query($con,"SELECT SUM(interest) AS value_sum FROM tbl_personal_loan_installments where loan_create_id= '$loan_create_id'");
while ($row_payment=mysqli_fetch_array($query_payment)){
    $payment = $row_payment['value_sum'];
    
    $interest_amount = number_format((float)$payment, 2, '.', '');
break;
   // echo"<br>User_Key:" .$payment;

}  
           
           $a="";
           if($payment>=$payoff OR  $loan_status== 'Paid')
           {
               
               
              // $a="<a href='renew_loan.php?id=$id' style='color:green'>Renew Loan</a>";
           }
           
        
             if ($payoff=="300")
             {
              
              $decimal=".00"  ; 
                 
             }
              
          
             $timestamp = strtotime($last_payment_date);
             $last_payment_date= date("m-d-Y", $timestamp);
       
        
       $contract_date= $row['contract_date'];
       $timestamp = strtotime($contract_date);
       $new_contract= date("m-d-Y", $timestamp);

    
    
    
       $timestamp = strtotime($payment_date);
       $due_date= date("m-d-Y", $timestamp);
		
	 $now = time(); 
$your_date = strtotime($payment_date);

$datediff = $now-$your_date;

$datediff1= round($datediff / (60 * 60 * 24));
 if ($datediff1<0)
{
    $datediff1=str_replace("$datediff1","0","$datediff1");
    
}

if ($due_date==$last_payment_date)
{
    $datediff1=str_replace("$datediff1","0","$datediff1");
    
}






if ($last_payment_date=='01-01-1970')
{
    $last_payment_date=str_replace("$last_payment_date","","$last_payment_date");
    
}




  
   $balns_due= number_format("$balance_due",2);
   $daily_interest= number_format("$daily_interest",2);
   $amount_of_loan= number_format("$amount_of_loan",2);	
		// $envalope= "<a href='view_all_loan_notification.php?id=$id'  title='View Notifications'><span class='glyphicon glyphicon-envelope' aria-hidden='true' alt='View Notifications'></span></a>";
 
          $make_payment= "<a href='add_new_transaction.php?id=$id'  title='Make Payment' style='color:red;'><span class='glyphicon glyphicon-usd' aria-hidden='true' alt='Make Payment'></span></a>";
		echo "<tr ".$string_red_rejected.">
	 	      
			  <td style='text-align:center;'>".$loan_create_id."</td>
			  <td style='text-align:center;'>".$loan_status."</td>
			  <td style='text-align:center;'>".$user_name." ".$last_name."</td>
			  <td style='text-align:center;'>".$user_mobile."</td>
			  <td style='text-align:center;'>$".$amount_of_loan."</td>
			  <td style='text-align:center;'>$".$interest_amount."</td>
	 		  <td style='text-align:center;'>".$new_contract."</td>
	 		  <td style='text-align:center;'>".$due_date."</td>
	 		  <td style='text-align:center;'>".$last_payment_date."</td>
		
		   	  
		   	  
		 
<td style='text-align:center;'><a href='loan_summary.php?id=$id'  title='View Summary' style='color:black;margin-right:4px;'><span class='glyphicon glyphicon-user' aria-hidden='true' alt='edit'></span></a>    ";

    if ($decision_logic_status== '1') 
         {
              
             echo  "<a href='#'  title='DL Verified'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true' alt='echo $alt_dl;'></span>  <span style = 'color:green; text-align:left'></span></a>";
         
          } 
           else 
          {
              echo "<a href='#'  title='Bank Statement'><span class='glyphicon glyphicon-book' aria-hidden='true' alt='$alt;'></span>  <span style = 'color:green; text-align:left'></span></a>";
          
          }
          echo "<a class='remove-box' href='delete-loan.php?loan_id=$id&fnd_id=$user_fnd_id'  title='Delete Loan'><span class='glyphicon glyphicon-remove' aria-hidden='true' alt='$alt;'></span>  <span style = 'color:green; text-align:left'></span></a>";
          
echo  $a.' '.$make_payment.' '.$envalope."</td>

		   	</tr>";
    }
	mysqli_close($con);
    ?>
   
</tbody>
</table>
<?php //echo $query_search; ?>
<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
<strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
</div>

<ul class="pagination">
	<?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>
    
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


<script type="text/javascript">
    $('.remove-box').on('click', function () {
      var x =  confirm('Are you sure you want to delete?');
      if (x)
      return true;
  else
    return false;
      
    });
</script>


  <style>
      .navbar-default{
          background-color:#fb3f06 !important;
      }
      
  </style>

</body>
</html>

<?php
}
?>