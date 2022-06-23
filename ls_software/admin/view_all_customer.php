<?php
 session_start();
 error_reporting(0);
 include_once 'dbconnect.php';
include 'dbconfig.php';
 if (!isset($_SESSION['userSession'])) {
 	header("Location: index.php");
 }

 $query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
 $userRow=$query->fetch_array();
 $u_id=$userRow['user_id'];
 $u_access_id = $userRow['access_id'];
 if($u_access_id=='0'){
     echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
 }
 else {
 $DBcon->close();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="typeahead.min.js"></script>
    
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['email']; ?></title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="style.css" type="text/css" />
<link rel="stylesheet" href="../paging/css/bootstrap.min.css">
<link rel="stylesheet" href="css/style1.css">  
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="style.css" type="text/css" />
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>



    
 
        
    
    
</head>
<body>

<?php include('menu.php') ;?>

<br>
<br>

  <section class="wrapper" style="font-size:15px !important">
    <!-- Row title -->
  
 <br><br>
 <?php

 $query_search = "SELECT * FROM `fnd_user_profile` ";
    $status  = $_GET['status'];
    $keyword = $_GET['keyword'];
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];
	$website = $_GET['website'];
	$state = $_GET['state'];
	$loan_type = $_GET['loan_type'];
    
if (isset($_GET['status']) || isset($_GET['keyword']) || isset($_GET['website']) || isset($_GET['state']) || isset($_GET['loan_type']) || isset($_GET['from_date']) || isset($_GET['to_date'])) {
    $query_search .= " WHERE ";
}
  $and_check = 0;
if (isset($_GET['status']) && $_GET['status']!='All') {
    $query_search .= " application_status = '$status' ";
  $and_check = 1;
}
if (isset($_GET['keyword']) ||  $_GET['keyword'] !="") {
    if($and_check>0){
      $query_search .= " AND ";
      $and_check = 2;
    }
    $query_search .= "  CONCAT(`first_name`, `last_name`, `email`, `mobile_number` , `dl_code` ) LIKE '%".$keyword."%'";
  $and_check = 2;
}if ($_GET['from_date']!="") {
  if($and_check>1 || $and_check>0){
      $query_search .= " AND ";
      $and_check = 3;
    }
    $query_search .= " (creation_date BETWEEN '$from_date'AND '$to_date')";
}
if (isset($_GET['website']) && $_GET['website']!='All') {
	if($and_check>1 || $and_check>0){
      $query_search .= " AND ";
      //$and_check = 2;
    }
    $query_search .= " website = '$website' ";
 // $and_check = 1;
}

if (isset($_GET['state']) && $_GET['state']!='All') {
	if($and_check>1 || $and_check>0){
      $query_search .= " AND ";
      //$and_check = 2;
    }
    $query_search .= " state = '$state' ";
 // $and_check = 1;
}

if (isset($_GET['loan_type']) && $_GET['loan_type']!='All') {
	if($and_check>1 || $and_check>0){
      $query_search .= " AND ";
      //$and_check = 2;
    }
    $query_search .= " loan_type = '$loan_type' ";
 // $and_check = 1;
}
   // $query_search .= " ORDER By user_fnd_id DESC  LIMIT $offset, $total_records_per_page ";

//echo "<br><br><br><br>" . $query_search;
if ($result_t=mysqli_query($con,$query_search))
  {
  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($result_t);
 // printf($rowcount);
  // Free result set
  $ye=mysqli_free_result($result_t);
  echo $ye;
  }

//mysqli_close($con);
?> 
  
<div align="right">
<a href="add_new_customer.php"> <button style="background-color: #1E90FF;color: white;border-color: #1E90FF;" name="btn-submit" type="submit" class="btn btn-danger">Add New Application</button></a>

<h4  style="float:left;"> Total Applications: <?php echo $rowcount;?>   </h4>

</div>
<br>

<form action="view_all_customer.php" method="GET">
<table class="table table-striped tasks-table" id="table_bg" style="font-size:15px !important">
<thead align="center">
<tr>
    
    <td colspan="2" style="font-weight: bold;">
Application Status
<select name="status" id="app_status" class="form-control"  value="" style="padding: 6px 15px;">
<option value="All" <?php if($_GET['status']=='All'){ echo 'selected';}?>>All Applications</option>
<option value="New Application"<?php if($_GET['status']=='New Application'){ echo 'selected';}?>>New Application</option>
<option value="Declined"<?php if($_GET['status']=='Declined'){ echo 'selected';}?>>Declined</option>
<option value="Funded"<?php if($_GET['status']=='Funded'){ echo 'selected';}?>>Funded</option>
<option value="No Answer"<?php if($_GET['status']=='No Answer'){ echo 'selected';}?>>No Answer</option>
<option value="Rejected By Customer"<?php if($_GET['status']=='Rejected By Customer'){ echo 'selected';}?>>Rejected By Customer</option>
<option value="Approved Payday CA"<?php if($_GET['status']=='Approved Payday CA'){ echo 'selected';}?>>Approved Payday CA</option>
<option value="Approved Payday NV"<?php if($_GET['status']=='Approved Payday NV'){ echo 'selected';}?>>Approved Payday NV</option>
<option value="Approved Payday IL"<?php if($_GET['status']=='Approved Payday IL'){ echo 'selected';}?>>Approved Payday IL</option>
<option value="Approved Installment CA"<?php if($_GET['status']=='Approved Installment CA'){ echo 'selected';}?>>Approved Installment CA</option>
<option value="Approved Installment AZ"<?php if($_GET['status']=='Approved Installment AZ'){ echo 'selected';}?>>Approved Installment AZ</option>
<option value="Approved Installment NV"<?php if($_GET['status']=='Approved Installment NV'){ echo 'selected';}?>>Approved Installment NV</option>
<option value="Approved Installment IL"<?php if($_GET['status']=='Approved Installment IL'){ echo 'selected';}?>>Approved Installment IL</option>
<option value="Review Payday CA"<?php if($_GET['status']=='Review Payday CA'){ echo 'selected';}?>>Review Payday CA</option>
<option value="Review Payday NV"<?php if($_GET['status']=='Review Payday NV'){ echo 'selected';}?>>Review Payday NV</option>
<option value="Review Payday IL"<?php if($_GET['status']=='Review Payday IL'){ echo 'selected';}?>>Review Payday IL</option>
<option value="Review Installment CA"<?php if($_GET['status']=='Review Installment CA'){ echo 'selected';}?>>Review Installment CA</option>
<option value="Review Installment AZ"<?php if($_GET['status']=='Review Installment AZ'){ echo 'selected';}?>>Review Installment AZ</option>
<option value="Review Installment NV"<?php if($_GET['status']=='Review Installment NV'){ echo 'selected';}?>>Review Installment NV</option>
<option value="Review Installment IL"<?php if($_GET['status']=='Review Installment IL'){ echo 'selected';}?>>Review Installment IL</option>
<option value="DL/Bank Payday CA"<?php if($_GET['status']=='DL/Bank Payday CA'){ echo 'selected';}?>>DL/Bank Payday CA</option>
<option value="DL/Bank Payday NV"<?php if($_GET['status']=='DL/Bank Payday NV'){ echo 'selected';}?>>DL/Bank Payday NV</option>
<option value="DL/Bank Payday IL"<?php if($_GET['status']=='DL/Bank Payday IL'){ echo 'selected';}?>>DL/Bank Payday IL</option>
<option value="DL/Bank Installment CA"<?php if($_GET['status']=='DL/Bank Installment CA'){ echo 'selected';}?>>DL/Bank Installment CA</option>
<option value="DL/Bank Installment AZ"<?php if($_GET['status']=='DL/Bank Installment AZ'){ echo 'selected';}?>>DL/Bank Installment AZ</option>
<option value="DL/Bank Installment NV"<?php if($_GET['status']=='DL/Bank Installment NV'){ echo 'selected';}?>>DL/Bank Installment NV</option>
<option value="DL/Bank Installment IL"<?php if($_GET['status']=='DL/Bank Installment IL'){ echo 'selected';}?>>DL/Bank Installment IL</option>

<!--<option value="Ready for review"<?php if($_GET['status']=='Ready for review'){ echo 'selected';}?>>Ready for review</option>-->
<!--<option value="Info Needed"<?php if($_GET['status']=='Info Needed'){ echo 'selected';}?>>Info Needed</option>-->
<!--<option value="Approved Payday NV"<?php if($_GET['status']=='Approved Payday NV'){ echo 'selected';}?>>Approved Payday NV</option>-->
<!--<option value="Approved Commercial CA"<?php if($_GET['status']=='Approved Commercial CA'){ echo 'selected';}?>>Approved Commercial CA</option>-->
<!--<option value="DL/Bank Needed"<?php if($_GET['status']=='DL/Bank Needed'){ echo 'selected';}?>>DL/Bank Needed</option>-->
<!--<option value="Review Payday NV"<?php if($_GET['status']=='Review Payday NV'){ echo 'selected';}?>>Review Payday NV</option>-->
<!--<option value="Review Commercial CA"<?php if($_GET['status']=='Review Commercial CA'){ echo 'selected';}?>>Review Commercial CA</option>-->
<!--<option value="Credit Report Completed"<?php if($_GET['status']=='Credit Report Completed'){ echo 'selected';}?>>Credit Report Completed</option>-->
<!--<option value="Decision Logic Completed"<?php if($_GET['status']=='Decision Logic Completed'){ echo 'selected';}?>>Decision Logic Completed</option>-->
<!--<option value="Credit Report Needed"<?php if($_GET['status']=='Credit Report Needed'){ echo 'selected';}?>>Credit Report Needed</option>-->
<!--<option value="Bank Information Needed"<?php if($_GET['status']=='Bank Information Needed'){ echo 'selected';}?>>Bank Information Needed</option>-->
<!--<option value="Final Review For Personal Loan"<?php if($_GET['status']=='Final Review For Personal Loan'){ echo 'selected';}?>>Final Review For Personal Loan</option>-->
<!--<option value="No Decision Logic For Payday"<?php if($_GET['status']=='No Decision Logic For Payday'){ echo 'selected';}?>>No Decision Logic For Payday</option>-->
<!--<option value="Review For Payday"<?php if($_GET['status']=='Review For Payday'){ echo 'selected';}?>>Review For Payday</option>-->
<!--<option value="Approved Payday Loan"<?php if($_GET['status']=='Approved Payday Loan'){ echo 'selected';}?>>Approved Payday Loan</option>-->
<!--<option value="Approved Personal Loan"<?php if($_GET['status']=='Approved Personal Loan'){ echo 'selected';}?>>Approved Personal Loan</option>-->
<!--<option value="Approved Title Loan"<?php if($_GET['status']=='Approved Title Loan'){ echo 'selected';}?>>Approved Title Loan</option>-->
<!--<option value="Interview Completed"<?php if($_GET['status']=='Interview Completed'){ echo 'selected';}?>>Interview Completed</option>-->
<!--<option value="Pending Documents"<?php if($_GET['status']=='Pending Documents'){ echo 'selected';}?>>Pending Documents</option>-->






</select>
</td>  
<!--<td colspan="2" style="font-weight: bold;">-->
<!--Website-->
<!--<select name="website" id="app_status" class="form-control"  value="" style="padding: 6px 15px;">-->
<!--<option value="All" <?php if($_GET['website']=='All'){ echo 'selected';}?>>All Websites</option>-->
<!--<option value="lsprestamos"<?php if($_GET['website']=='lsprestamos'){ echo 'selected';}?>>lsprestamos</option>-->
<!--<option value="lspaydayloans"<?php if($_GET['website']=='lspaydayloans'){ echo 'selected';}?>>lspaydayloans</option>-->
<!--<option value="lsbanking_pdl"<?php if($_GET['website']=='lsbanking_pdl'){ echo 'selected';}?>>lsbanking_pdl</option>-->
<!--<option value="lsbanking_pl"<?php if($_GET['website']=='lsbanking_pl'){ echo 'selected';}?>>lsbanking_pl</option>-->
<!--<option value="Payday CA"<?php if($_GET['website']=='Payday CA'){ echo 'selected';}?>>Payday CA</option>-->
<!--<option value="mymoneyline_cl"<?php if($_GET['website']=='mymoneyline_cl'){ echo 'selected';}?>>mymoneyline_cl</option>-->
<!--<option value="mymoneyline_tl"<?php if($_GET['website']=='mymoneyline_tl'){ echo 'selected';}?>>mymoneyline_tl</option>-->
<!--<option value="Installment CA"<?php if($_GET['website']=='Installment CA'){ echo 'selected';}?>>Installment CA</option>-->
<!--<option value="Installment Nevada"<?php if($_GET['website']=='Installment Nevada'){ echo 'selected';}?>>Installment Nevada</option>-->
<!--<option value="Installment Arizona"<?php if($_GET['website']=='Installment Arizona'){ echo 'selected';}?>>Installment Arizona</option>-->
<!--<option value="Installment IL"<?php if($_GET['website']=='Installment IL'){ echo 'selected';}?>>Installment IL</option>-->
<!--<option value="By Office"<?php if($_GET['website']=='By Office'){ echo 'selected';}?>>By Office</option>-->
<!--</select>-->
<!--</td>-->

<td colspan="2" style="font-weight: bold;">
State
<select name="state" id="state" class="form-control"  value="" style="padding: 6px 15px;">
<option value="All" <?php if($_GET['state']=='All'){ echo 'selected';}?>>All</option>
<option value="CA"<?php if($_GET['state']=='CA'){ echo 'selected';}?>>California</option>
<option value="NV"<?php if($_GET['state']=='NV'){ echo 'selected';}?>>Nevada</option>
<option value="AZ"<?php if($_GET['state']=='AZ'){ echo 'selected';}?>>Arizona</option>
<option value="IL"<?php if($_GET['state']=='IL'){ echo 'selected';}?>>Illinois</option>
</select>
</td>
<td colspan="2" style="font-weight: bold;">
Application Type
<select name="loan_type" id="loan_type" class="form-control"  value="" style="padding: 6px 15px;">
<option value="All" <?php if($_GET['loan_type']=='All'){ echo 'selected';}?>>All</option>
<option value="payday"<?php if($_GET['loan_type']=='payday'){ echo 'selected';}?>>payday</option>
<option value="installment"<?php if($_GET['loan_type']=='installment'){ echo 'selected';}?>>installment</option>
<option value="commercial"<?php if($_GET['loan_type']=='commercial'){ echo 'selected';}?>>commercial</option>
</select>
</td>

<td colspan="2" style="font-weight: bold;">
          
Keyword Search
<input type="text" id="search" class="form-control" name="keyword" placeholder="" value="<?php echo $_GET['keyword']; ?>">

</td>

<td colspan="2" style="font-weight: bold;">

Application Date From:
<input type="date" id="from_date" class="form-control" name="from_date" placeholder="" value="" style="line-height:20px">

</td>

<td colspan="2" style="font-weight: bold;">

Application Date To:
<input type="date" id="to_date" class="form-control" name="to_date" placeholder="" value="" style="line-height:20px">

</td>

<td colspan="1">
    
<a href="#"> <button style="background-color: #1E90FF;color: white;border-color: #1E90FF;" name="search" type="submit" class="btn btn-danger">Search</button></a>
</td>
</tr>
</thead>

</table>


<div style="width:100%; margin:0 auto;">

<table class="table table-striped table-bordered"  style="font-size:16px !important">
    <div style="text-align:center;margin-top: -22px;">
   <span style="font-size:13px"; class="glyphicon glyphicon-filter" aria-hidden="true" alt="edit">  </span> 
   <span style="font-size:13px";  aria-hidden="true" alt="edit">
       <?php
        $from_date_filter=date('Y-m-d'); //echo $from_date; 
        $to_date_filter= date('Y-m-d');  //echo ' '. $to_date;
       echo "
   -<a href='view_all_customer.php?status=".$_GET['status']."&state=".$_GET['state']."&loan_type=".$_GET['loan_type']."&keyword=".$_GET['keyword']."&from_date=$from_date_filter&to_date=$to_date_filter'>  Today  </a> ";
   ?>
   </span>  
   
   <span style="font-size:13px";  aria-hidden="true" alt="edit">
       
       <?php
        $to_date_filter=date('Y-m-d', strtotime('-1 day')); //echo $from_date; 
        
        $from_date_filter= date('Y-m-d', strtotime('-1 day'));  //echo" ". $to_date;
       echo
       "
       -<a href='view_all_customer.php?status=".$_GET['status']."&state=".$_GET['state']."&loan_type=".$_GET['loan_type']."&keyword=".$_GET['keyword']."&from_date=$from_date_filter&to_date=$to_date_filter'>  Yesterday </a> ";
       
       ?>
       </span>
       
       
       <span style="font-size:13px";  aria-hidden="true" alt="edit">
           
           <?php $to_date_filter=date('Y-m-d'); //echo $from_date; 
           
              $from_date_filter= date('Y-m-d', strtotime('-3 day'));  //echo" ". $to_date;
           echo "
       -<a href='view_all_customer.php?status=".$_GET['status']."&state=".$_GET['state']."&loan_type=".$_GET['loan_type']."&keyword=".$_GET['keyword']."&from_date=$from_date_filter&to_date=$to_date_filter'> Last 3 Days </a> ";
       ?>
       </span>
       
       
       <span style="font-size:13px";  aria-hidden="true" alt="edit">
           
           <?php $to_date_filter=date('Y-m-d'); //echo $from_date; 
           $from_date_filter= date('Y-m-d', strtotime('-7 day'));  
           //echo" ". $to_date;
           echo "
       -<a href='view_all_customer.php?status=".$_GET['status']."&state=".$_GET['state']."&loan_type=".$_GET['loan_type']."&keyword=".$_GET['keyword']."&from_date=$from_date_filter&to_date=$to_date_filter'>  Last 7 Days  </a> ";  
       ?>
       </span>
       
       
       
       <span style="font-size:13px";  aria-hidden="true" alt="edit">
           
           <?php $to_date_filter=date('Y-m-d'); //echo $from_date; 
       $from_date_filter= date('Y-m-d', strtotime('first day of this month'));  //echo" ". $to_date;
          echo " 
       -<a href='view_all_customer.php?status=".$_GET['status']."&state=".$_GET['state']."&loan_type=".$_GET['loan_type']."&keyword=".$_GET['keyword']."&from_date=$from_date_filter&to_date=$to_date_filter'> This Month </a>"; 
       ?>
       </span>
       
       
       
       <span style="font-size:13px";  aria-hidden="true" alt="edit">
           <?php $to_date_filter=date('Y-m-d'); // echo $from_date; 
           $from_date_filter= date('Y');  //echo" ". $to_date;
           echo"
       -<a href='view_all_customer.php?status=".$_GET['status']."&state=".$_GET['state']."&loan_type=".$_GET['loan_type']."&keyword=".$_GET['keyword']."&from_date=$from_date_filter&to_date=$to_date_filter'> This Year  </a> ";
       ?>
       
       </span>
    </div>
<thead>
<tr style="background-color: #F5E09E;color: white;">
<th style='width:7%;color:black;'>ID</th>
<th style='width:13%;color:black;'>Application Date</th>
<th style='width:15%;color:black;'>First Name</th>
<th style='width:15%;color:black;'>Last Name</th>
<th style='width:10%;color:black;'>Phone #</th>
<th style='width:6%;color:black;'>State</th>
<th style='width:9%;color:black;'>App Type</th>
<th style='width:15%;color:black;'>Application Status</th>
<th style='width:5%;color:black;'>Website</th>
<th style='width:10%;color:black;'>Action</th>
</tr>
</thead>
<tbody>
<?php
$delete_customer_string = "page_no=".$_GET['page_no']."&status=".$_GET['status']."&state=".$_GET['state']."&loan_type=".$_GET['loan_type']."&keyword=".$_GET['keyword']."&from_date=".$_GET['from_date']."&to_date=".$_GET['to_date'];
$delete_customer_pagination = "status=".$_GET['status']."&keyword=".$_GET['keyword']."&state=".$_GET['state']."&loan_type=".$_GET['loan_type']."&from_date=".$_GET['from_date']."&to_date=".$_GET['to_date'];
   
include('db.php');
$count=1;
if (isset($_GET['page_no']) && $_GET['page_no']!="") {
	$page_no = $_GET['page_no'];
	$count = $count + (100*($page_no-1));
	} else {
		$page_no = 1;
        }

	$total_records_per_page = 100;
    $offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2"; 

	$result_count = mysqli_query($con,"SELECT COUNT(*) As total_records FROM `fnd_user_profile`");
	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
	$total_records = $rowcount;
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1
//  echo "<br>".$total_no_of_pages;
    $query_search = "SELECT * FROM `fnd_user_profile` ";
if (isset($_GET['status']) || isset($_GET['state']) || isset($_GET['loan_type']) || isset($_GET['keyword']) || isset($_GET['from_date']) || isset($_GET['to_date'])) {
    $query_search .= " WHERE ";
}
  $and_check = 0;
if (isset($_GET['status']) && $_GET['status']!='All') {
    $query_search .= " application_status = '$status' ";
  $and_check = 1;
}if (isset($_GET['keyword']) ||  $_GET['keyword'] !="") {
    if($and_check>0){
      $query_search .= " AND ";
      $and_check = 2;
    }
    $query_search .= "  CONCAT(`user_fnd_id`, `first_name`, `last_name`, `email`, `mobile_number` , `dl_code` ) LIKE '%".$keyword."%'";
  $and_check = 2;
}if ($_GET['from_date']!="") {
  if($and_check>1 || $and_check>0){
      $query_search .= " AND ";
      //$and_check = 2;
    }
    $query_search .= " (creation_date BETWEEN '$from_date' AND '$to_date')";
}if (isset($_GET['to_date'])) {
    //$query_search .= " WHERE ";
}

if (isset($_GET['website']) && $_GET['website']!='All') {
	if($and_check>1 || $and_check>0){
      $query_search .= " AND ";
      //$and_check = 2;
    }
    $query_search .= " website = '$website' ";
 // $and_check = 1;
}

if (isset($_GET['state']) && $_GET['state']!='All') {
	if($and_check>1 || $and_check>0){
      $query_search .= " AND ";
      //$and_check = 2;
    }
    $query_search .= " state = '$state' ";
 // $and_check = 1;
}

if (isset($_GET['loan_type']) && $_GET['loan_type']!='All') {
	if($and_check>1 || $and_check>0){
      $query_search .= " AND ";
      //$and_check = 2;
    }
    $query_search .= " loan_type = '$loan_type' ";
 // $and_check = 1;
}
    $query_search .= " ORDER By user_fnd_id DESC  LIMIT $offset, $total_records_per_page ";
 
 //echo $query_search;
    $result = mysqli_query($con,"$query_search");
    while($row = mysqli_fetch_array($result)){
        
		 $id=$row['user_fnd_id'];
		 $cr_date= $row['creation_date'];
		 $created_time = $row['created_time_'];
		 $origDate = "$cr_date";
		 $lang=$row['lang'];
		 $bold_status=$row['bold_status'];
     $website_company = $row['website_company'];
 $newDate = date("m-d-y", strtotime($origDate));
//echo $newDate;

if($lang=='en')
{
    $image_lang="<img id='img' src ='imgs/en.png' style='height:auto; width:auto' /> ";
}
else
{
    $image_lang="<img id='img' src ='imgs/es.png' style='height:auto; width:auto' /> ";
}

$string_red_rejected = '';
	if ($row['application_status'] == 'Declined' || $row['application_status']=='Rejected By Customer'){
		$string_red_rejected = 'style="color:red"';
	}
else if ($row['application_status'] == 'Decision Logic Completed' || $row['application_status']=='Credit Report Needed' || $row['application_status']=='Pending Documents'){
		$string_red_rejected = 'style="color:#b8bb01"';
	}

else if ($row['application_status'] == 'Final Review'){
		$string_red_rejected = 'style="color:orange"';
	}

else if ($row['application_status'] == 'Approved Payday Loan' || $row['application_status']=='Approved Personal Loan' || $row['application_status']=='Approved Title Loan'){
		$string_red_rejected = 'style="color:green"';
	}
else if ($row['application_status'] == 'No Answer'){
		$string_red_rejected = 'style="color:#9370DB"';
	}
else if ($row['application_status'] == 'Funded'){
		$string_red_rejected = 'style="color:black"';
	}

 if($row['decision_logic_status'] > 0 ) {
     $decision_logic_Status = ' <span class="glyphicon glyphicon-ok-circle" aria-hidden="true" alt="Verified" style="color:green"></span>  ';
 }
 if($row['experian_credit_score'] > 100 && $row['experian_credit_score'] < 9999 ) {
     $experian_credit_score = ' <span class="glyphicon glyphicon-ok-circle" aria-hidden="true" alt="Verified" style="color:red"></span>  ';
 }
 
 if($bold_status=='0')
{
    $bold_app = 'style="font-weight:bold"';
}
 else
{
    $bold_app = 'style="font-size:16px !important"';
}
//$gravatar = "https://www.gravatar.com/avatar/".md5($row['email']);
//$gravatar = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $row['email'] ) ) );
$gravatar =  "http://profiles.google.com/s2/photos/profile/". $row['email']."?sz=";
		echo "<tr ".$string_red_rejected. " ".$bold_app. ">
	 	      
			  <td>$image_lang ".$id."</td>
			  <td>".$newDate. " " .$created_time." </td>
			  <td> ".$row['first_name']."</td>
			  <td>".$row['last_name']."</td>
	 		  <td>".$row['mobile_number']."</td>
	 		  <td>".$row['state']."</td>
	 		  <td>".$row['loan_type']."</td>
            
		   	  <td>".$row['application_status']."</td>
           <td>" . $row['website_company'] . "</td>
		   	  
<td> <a href='edit_customer.php?id=$id&$delete_customer_string' title='Edit This Customer'><span class='glyphicon glyphicon-edit' aria-hidden='true' alt='edit'></span></a>
<a class='remove-box' href='delete_customer.php?id=$id&$delete_customer_string' title='Delete This Customer'><span class='glyphicon glyphicon-remove' aria-hidden='true' alt='delete'></span>".$decision_logic_Status.$experian_credit_score."</a>
<a href='customer_loan_history.php?id=$id'  title='Loan History'><span class='glyphicon glyphicon-collapse-up' aria-hidden='true' alt='Loan History'></span>  <span style = 'color:green; text-align:left'></span></a>
</td>

	   	  </tr>";
	   	  $decision_logic_Status = "";
	   	  $experian_credit_score = "";
        }
	mysqli_close($con);
    ?>
</tbody>
</table>

<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
<strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
</div>

<ul class="pagination">
	<?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>
    
	<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
	<a <?php if($page_no > 1){ echo "href='?page_no=$previous_page&$delete_customer_pagination'"; } ?>>Previous</a>
	</li>
       
    <?php 
	if ($total_no_of_pages <= 10){  	 
		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
			if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter&$delete_customer_pagination'>$counter</a></li>";
				}
        }
	}
	elseif($total_no_of_pages > 10){
		
	if($page_no <= 4) {			
	 for ($counter = 1; $counter < 8; $counter++){		 
			if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter&$delete_customer_pagination'>$counter</a></li>";
				}
        }
		echo "<li><a>...</a></li>";
		echo "<li><a href='?page_no=$second_last&$delete_customer_pagination'>$second_last</a></li>";
		echo "<li><a href='?page_no=$total_no_of_pages&$delete_customer_pagination'>$total_no_of_pages</a></li>";
		}

	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
		echo "<li><a href='?page_no=1'>1</a></li>";
		echo "<li><a href='?page_no=2'>2</a></li>";
        echo "<li><a>...</a></li>";
        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
           if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter&$delete_customer_pagination'>$counter</a></li>";
				}                  
       }
       echo "<li><a>...</a></li>";
	   echo "<li><a href='?page_no=$second_last&$delete_customer_pagination'>$second_last</a></li>";
	   echo "<li><a href='?page_no=$total_no_of_pages&$delete_customer_pagination'>$total_no_of_pages</a></li>";      
            }
		
		else {
        echo "<li><a href='?page_no=1'>1</a></li>";
		echo "<li><a href='?page_no=2'>2</a></li>";
        echo "<li><a>...</a></li>";

        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
          if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter&$delete_customer_pagination'>$counter</a></li>";
				}                   
                }
            }
	}
?>
    
	<li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
	<a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page&$delete_customer_pagination'"; } ?>>Next</a>
	</li>
    <?php if($page_no < $total_no_of_pages){
		echo "<li><a href='?page_no=$total_no_of_pages&$delete_customer_pagination'>Last &rsaquo;&rsaquo;</a></li>";
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