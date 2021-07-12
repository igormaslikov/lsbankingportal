<?php
error_reporting(0);
session_start();
include_once '../dbconnect.php';

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
include_once '../dbconnect.php';
include_once '../dbconfig.php';
$id=$_GET['id'];
$sql_fnd=mysqli_query($con, "select * from tbl_personal_loans where p_loan_id = '$id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];
$loan_create_id=$row_fnd['loan_create_id'];
$payoff=$row_fnd['loan_total_payable'];
$loan_status=$row_fnd['loan_status'];
}



$query_payment = mysqli_query($con,"SELECT SUM(payoff_amount) AS value_sum FROM personal_loan_transaction where loan_id= '$id'");
while ($row_payment=mysqli_fetch_array($query_payment)){
    $payment = $row_payment['value_sum'];
    
    $payment = number_format((float)$payment, 2, '.', '');

   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$us;

}
?>

<?php

include_once '../dbconnect.php';
include_once '../dbconfig.php';

$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];
$last_name=$row['last_name'];
$customer_numbr=$row['mobile_number'];
$chat_key=$row['chat_key'];

}

//echo "fname is:".$first_name;

?>




<?php

include_once '../dbconnect.php';
include_once '../dbconfig.php';

$sql=mysqli_query($con, "select * from tbl_personal_loans where p_loan_id= '$id'"); 

while($row = mysqli_fetch_array($sql)) {

$loan_id=$row['loan_id'];
//echo "fndid is:".$fnd_id;
$amount_loan=$row['principal_amount'];
$amount_loan = number_format((float)$amount_loan, 2, '.', '');
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

 $date1 = date_create($payment_date);
          $date2 = date_create($last_payment_date);

//difference between two dates
$diff = date_diff($date1,$date2);

//count days
$days_between= $diff->format("%r%a");

//echo $days_between;



$timestamp = strtotime($last_payment_date);
$last_payment_date= date("m-d-Y", $timestamp);


 $timestamp = strtotime($creation_date);
 
// Creating new date format from that timestamp
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


$query_payment = mysqli_query($con,"SELECT SUM(payoff_amount) AS value_sum FROM personal_loan_transaction where loan_id= '$id'");
while ($row_payment=mysqli_fetch_array($query_payment)){
    $payment = $row_payment['value_sum'];
    
    $payment = number_format((float)$payment, 2, '.', '');

   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$us;

}

?>

<?php

include_once '../dbconnect.php';
include_once '../dbconfig.php';

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
<div class="col-lg-4"><p>Loan Date:<b style="color:red"> <?php echo $new_creation_date;?> </b></p></div>
<div class="col-lg-4"><p>Loan Amount: <b style="color:red"> <?php echo $val.$amount_loan;?></b></p></div>
<div class="col-lg-4"><p>Loan ID:<b style="color:red"> <?php echo $loan_create_id;?> </b> </p></div>


</div>
      <br><br>
     
  
      <div class="container-fluid">
          <h3>Loan Summary:</h3>
        <!-- <a href=../../../../signature_customer/loan/case_pdf.php?id=<?php //echo $id;?> target='_blank' style="margin-left: 900px;"> <img src="https://img.icons8.com/color/48/000000/pdf.png"></a><br>-->
        <br>
      <div class="col-lg-12">
  <form action ="#" method="POST">
    <div class="form-group" >
    <div class="row">
     <div class="col-lg-6">
    <label for="usr">Account Status</label>
<select name="account_status" id="app_status" class="form-control"  value="" style="padding: 6px 15px;">
<option value="">Account Status</option>
<option value="Active" <?php if($loan_status=='Active'){ echo 'selected';} ?>>Active</option>
<option value="Paid" <?php if($loan_status=='Paid'){ echo 'selected';} ?>>Paid</option>
<option value="Past Due" <?php if($loan_status=='Past Due'){ echo 'selected';} ?>>Past Due</option>
<option value="Promise to Pay" <?php if($loan_status=='Promise to Pay'){ echo 'selected';} ?>>Promise to Pay</option>
<option value="Payment Plan" <?php if($loan_status=='Payment Plan'){ echo 'selected';} ?>>Payment Plan</option>
<option value="Collections" <?php if($loan_status=='Collections'){ echo 'selected';} ?>>Collections</option>
<option value="Chargeoff" <?php if($loan_status=='Chargeoff'){ echo 'selected';} ?>>Chargeoff</option>
<option value="Closed Account" <?php if($loan_status=='Closed Account'){ echo 'selected';} ?>>Closed Account</option>
<option value="Chargeback" <?php if($loan_status=='Chargeback'){ echo 'selected';} ?>>Chargeback</option>
<option value="Bankruptcy" <?php if($loan_status=='Bankruptcy'){ echo 'selected';} ?>>Bankruptcy</option>

</select>
</div>
    <div class="col-lg-6">
      <label for="usr">Secondary Portfolio</label>
      <select name="p_portfolio" id="p_portfolio" class="form-control"  value="<?php echo $primary_port; ?>" >
     <option value="None" <?php if($primary_port=='None'){ echo 'selected';} ?>>None</option>
     <option value="Collection Agency" <?php if($primary_port=='Collection Agency'){ echo 'selected';} ?>>Collection Agency</option>
     <option value="Bankruptcy" <?php if($primary_port=='Bankruptcy'){ echo 'selected';} ?>>Bankruptcy</option>
     <option value="Consolidation" <?php if($primary_port=='Consolidation'){ echo 'selected';} ?>>Consolidation</option>
     <option value="No Collections" <?php if($primary_port=='No Collections'){ echo 'selected';} ?>>No Collections</option>
     <option value="In House Collections" <?php if($primary_port=='In House Collections'){ echo 'selected';} ?>>In House Collections</option>
     <option value="Settlement Accounts" <?php if($primary_port=='Settlement Accounts'){ echo 'selected';} ?>>Settlement Accounts</option>
     </select>
    </div>
   

     <div class="col-lg-6">
      <label for="usr">Loan Amount</label>
      <input type="text" name="amount_loan" class="form-control" id="usr" placeholder="Amount Of Loan" value="<?php echo $val.$amount_loan; ?>" >
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Payoff Amount</label>
      <input type="text" name="amount_left" class="form-control" id="usr" placeholder="Amount Left" value="<?php echo $val.$loan_payable; ?>" >
    </div>
    
     <div class="col-lg-6">
      <label for="usr">Due Date</label>
      <input type="date" name="next_payment_date" class="form-control" id="usr" placeholder="MM/DD/YYYY" value="<?php echo $payment_date; ?>" >
    </div>
    
     <div class="col-lg-6">
      <label for="usr">Days Past Due</label>
       <input type="text" name="days_past_due" class="form-control" id="usr" placeholder="" value="<?php if ($last_payment_date== '01-01-1970') 
         {
              
             echo  "$datediff1";
         
          } 
           else 
          {
              echo "$days_between";
          
          } ?>" >
     </div>
     
     <div class="col-lg-6">
      <label for="usr">Contract APR</label>
       <input type="text" name="apr" class="form-control" id="usr" placeholder="" value="<?php echo $apr; ?>" >
     </div>
     
     
     <div class="col-lg-6">
      <label for="usr">Balance Due</label>
       <input type="text" name="blns" class="form-control" id="usr" placeholder="" value="<?php echo $balns_due; ?>" >
     </div>

    
    </div>

    <br>
        
     
      <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: white;background-color: #1E90FF;border-radius: 0px;border-color: #1E90FF;">Update</button>
  <button name="btn" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,red 0,red 100%);color: #fff;background-color:red;border-color: red;"><a href="add_new_transaction.php?id=<?php echo $id; ?>" style="color:white">Make a Payment</a></button>
  <button name="btn" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,red 0,red 100%);color: #fff;background-color:red;border-color: red;"><a href="schedule_payment.php?id=<?php echo $id; ?>" style="color:white">Schedule Payment</a></button>
        
     
     <?php 
    if($payment>=$payoff OR  $loan_status== 'Paid')
           {
              echo "<a href='renew_loan.php?id=$id' <button name='btn' type='submit' class='btn btn-danger' style='background-image: linear-gradient(to bottom,#95c500 0,#639a0a 100%);
    color: #fff;
    background-color: #2a8206;
    border-color: #112f01;'>Renew Loan</button></a>";

               
            
           }
 ?>
  </form>

 

</div>
</div>

  </div>
  
  <br>
  
  
<br><br>
      <div class="container-fluid" style="width:100%; margin:0 auto;">
        
        <table class="table table-striped table-bordered">
<thead>
<tr style="background-color: #F5E09E;color: black;">
<th style='width:8%;color:black;'>Loan ID</th>
<th style='width:8%;color:black;'>Payment</th>
<th style='width:16%;color:black;'>Interest</th>
<th style='width:16%;color:black;'>Principal</th>
<th style='width:12%;color:black;'>Balance</th>
<th style='width:15%;color:black;'>Payment Date</th>
<th style='width:14%;color:black;'>User Name</th>
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

	$result_count = mysqli_query($con,"SELECT COUNT(*) As total_records FROM `personal_loan_transaction` where loan_id='$id'");
	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1

   $sql_loan=mysqli_query($con, "select * from personal_loan_transaction where loan_id='$id' order by transaction_id desc"); 

while($row_loan = mysqli_fetch_array($sql_loan)) {

          $transaction_id=$row_loan['transaction_id'];
		  $loan_create_id=$row_loan['loan_create_id'];
	      $payment_amount= $row_loan['payment_amount'];
	      $interest_amount= $row_loan['interest'];
	      $principal_amount= $row_loan['principal_amount'];
	      $remaining_balance= $row_loan['remaining_balance'];
	      $payment_description= $row_loan['payment_description'];
	      $payment_date= $row_loan['payment_date'];
	      $created_at= $row_loan['c$row_loanreated_at'];
	      $created_by_get_db_activity= $row_loan['created_by'];

 $query_balnce = mysqli_query($con,"SELECT * FROM tbl_personal_loans where loan_create_id= '$loan_create_id'");
while ($row_balnce=mysqli_fetch_array($query_balnce)){
    $amount_of_loan = $row_balnce['amount_of_loan'];
    
    $amount_of_loan = number_format((float)$amount_of_loan, 2, '.', '');
break;
   // echo"<br>User_Key:" .$payment;

} 

          $total_payment += $payment_amount;
	      $total_interest += $interest_amount;
	      $total_principal += $principal_amount;
	      $total_balnce=$amount_of_loan-$total_principal;
	      
	      	$sql_activity_by_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by_get_db_activity'"); 
$final_activity_by_user = '';
while($row_sql_activity_by_user = mysqli_fetch_array($sql_activity_by_user)) {
	$final_activity_by_user = $row_sql_activity_by_user['username'];
}
	      	
	      	$timestamp = strtotime($payment_date);
            $payment_date= date("m-d-Y", $timestamp);
            
            $timestamp = strtotime($created_at);
            $created_at= date("m-d-Y", $timestamp);
			echo "<tr>
	 	      
			  <td>".$loan_create_id."</td>
			  <td>$".number_format($payment_amount,   2, ".", ",")."</td>
	 		  <td>$".number_format($interest_amount,   2, ".", ",")."</td>
	 		  <td>$".number_format($principal_amount,   2, ".", ",")."</td>
			  <td>$".number_format($remaining_balance,   2, ".", ",")."</td>
	 		  <td>".$payment_date."</td>
	 		  <td>".$final_activity_by_user."</td>
	 		  
		   	  

		   	  </tr>";
        }

    ?>
   
</tbody>
</table>

<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;display:none;'>
<strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
</div>

<ul class="pagination" style="display:none">
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

<h3 style="color:red;">Conversation  <span style="float:right;">  </span>   </h3>
<iframe src="https://mymoneyline.com/lsbankingportal/ls_software/admin/sms-chat?chat_key=<?php echo $chat_key;?>&admin_name=<?php echo $u_name;?>" height="500px" width="100%" id="conversation"></iframe>

    
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
     if(isset($_POST['btn-submit'])) 
{
      $calculation_type= $_POST['calculation_type'];
    
     $account_status= $_POST['account_status'];
     $portfolio= $_POST['p_portfolio'];
     $amount_loan_up= $_POST['amount_loan'];
     $amount_left_up= $_POST['amount_left'];
     $next_payment_date_up= $_POST['next_payment_date'];
     $next_payment= $_POST['p_tenure'];
     $days_past_due= $_POST['days_past_due'];
     $apr_up= $_POST['apr'];
     $amount_loan_up=str_replace("$","","$amount_loan_up");
     $amount_left_up=str_replace("$","","$amount_left_up");
     
      mysqli_query($con, "UPDATE tbl_personal_loans SET loan_status='$account_status' where user_fnd_id ='$user_fnd_id' AND p_loan_id='$id'");
    
    
     $date_update= date('Y-m-d H:i:s');
     $loan_account_statuss= "Account Status Updated to: ".$_POST['account_status'];
    $query_insert_activity = "Insert into application_status_updates (application_id, loan_create_id, user_id, status, creation_date) Values ('$user_fnd_id', '$loan_create_id', '$u_id', '$loan_account_statuss', '$date_update')";
    mysqli_query ($con , $query_insert_activity);
    
    
     ?>
    <script type="text/javascript">
window.location.href = 'loan_summary.php?id=<?php echo $id;?>';
</script>
      
     
<?php
}
}
?>
</body>

</html>
