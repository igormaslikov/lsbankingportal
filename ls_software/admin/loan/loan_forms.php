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

<?php
$id=$_GET['id'];

$transaction_id = $id;



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

//$mail_key=$row_bank_detail['email_key'];
$first_name=$row['first_name'];
$last_name=$row['last_name'];
$customer_numbr=$row['mobile_number'];
$customer_email=$row['email'];


}



$sql_loan=mysqli_query($con, "select * from tbl_loan where loan_id= '$id'"); 

while($row_loan = mysqli_fetch_array($sql_loan)) {

$loan_id=$row_loan['loan_id'];
$loan_create_id=$row_loan['loan_create_id'];
//echo "fndid is:".$fnd_id;
$amount_loan=$row_loan['amount_of_loan'];

$sql_mail_key=mysqli_query($con, "select * from loan_initial_banking where loan_id = '$loan_create_id'"); 

while($row_mail_key = mysqli_fetch_array($sql_mail_key)) {

$mail_key=$row_mail_key['email_key'];

}


if ($amount_loan !='0')
{
   
   $val="$";
}
$sign_status=$row_loan['sign_status'];
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

if($sign_status>0){
    $signed_button_payday = "(Contract Signed)";
    $signed_button_payday .= '<a target="_blank" href="https://pacificafinancegroup.com/loanportal/signature_customer/files/sign_contract.php?id='.$mail_key.'" title=""><i class="glyphicon glyphicon-search" alt="" title="Preview The Payday Contract"></i></a>';

}
else {
    $signed_button_payday = '<a target="_blank" href="https://pacificafinancegroup.com/loanportal/signature_customer/files/sign_contract.php?id='.$mail_key.'" title=""><i class="glyphicon glyphicon-search" alt="" title="Preview The Payday Contract"></i></a>';
    $signed_button_payday .= ' <a target="_blank" href="functions/contract_pdf_mail.php?email_key='.$mail_key.'&email='.$customer_email.'&user_id='.$u_id.'&loan_id='.$loan_create_id.'&customer_id='.$user_fnd_id.'" title=""><i class="glyphicon glyphicon-envelope" alt="" title="Send Contract via Mail"></i></a>';
    $signed_button_payday .= ' <a target="_blank" href="functions/contract_pdf_sms.php?email_key='.$mail_key.'&phone_number='.$customer_numbr.'&user_id='.$u_id.'&loan_id='.$loan_create_id.'&customer_id='.$user_fnd_id.'" title=""><i class="glyphicon glyphicon-phone" alt="" title="Send Contract via SMS"></i></a>';
}

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
<h3>Loan Forms</h3>

</div>
        
    
       
        
         
          
</div>
    <br>    
    <b>System Forms</b>
          <table class="table table-striped table-bordered">
<thead>
<tr style="background-color: #F5E09E;color: white">
    <th style='width:40%;color:black;'>Title</th>
<th style='width:30%;color:black;'>Size</th>
<th style='width:15%;color:black;'>Action</th>
<th style='width:15%;color:black;'>Options</th>
</tr>
</thead>
<tbody>
<?php



include('db.php');
	      	
	       	echo "<tr>
			  <td align='center'>Payment Coupon Book</td>
	 		  <td align='center'>Letter</td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-print' alt=''></i></a></td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-file' alt=''></i></a></td>
		   	  

		   	  </tr>";
     

    ?>
</tbody>
</table>
    
    <br>    
    <b>Funding</b>
          <table class="table table-striped table-bordered">
<thead>
<tr style="background-color: #F5E09E;color: white">
    <th style='width:40%;color:black;'>Title</th>
<th style='width:20%;color:black;'>Size</th>
<th style='width:20%;color:black;'>Action</th>
<th style='width:10%;color:black;'>Sign</th>
<th style='width:10%;color:black;'>Options</th>
</tr>
</thead>
<tbody>
<?php



include('db.php');
	      	
	       	echo "<tr>
			  <td align='center'>Commercial Loan Application</td>
	 		  <td align='center'>Letter</td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-print' alt=''></i></a></td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-pencil' alt=''></i></a></td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-file' alt=''></i></a></td>
		   	  

		   	  </tr>
		   	  
		   	  <tr>
			  <td align='center'>Personal Loan Application</td>
	 		  <td align='center'>Letter</td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-print' alt=''></i></a></td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-pencil' alt=''></i></a></td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-file' alt=''></i></a></td>
		   	  </tr>
		   	  
		   	  
		   	  <tr>
			  <td align='center'>Payday Loan Contract</td>
	 		  <td align='center'>Letter</td>
	 		  <td align='center'>$signed_button_payday</td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-pencil' alt=''></i></a></td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-file' alt=''></i></a></td>
		   	  </tr>
		   	  
		   	  <tr>
			  <td align='center'>Personal Loan Contract</td>
	 		  <td align='center'>Letter</td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-print' alt=''></i></a></td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-pencil' alt=''></i></a></td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-file' alt=''></i></a></td>
		   	  </tr>
		   	  
		   	  
		   	  <tr>
			  <td align='center'>Commercial Loan Contract</td>
	 		  <td align='center'>Letter</td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-print' alt=''></i></a></td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-pencil' alt=''></i></a></td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-file' alt=''></i></a></td>
		   	  </tr>
		   	  
		   	  
		   	  
		   	  
		   	  
		   	  ";
     
	
    ?>
</tbody>
</table>
     
 <br>    
    <b>Servicing</b>
          <table class="table table-striped table-bordered">
<thead>
<tr style="background-color: #F5E09E;color: white">
    <th style='width:40%;color:black;'>Title</th>
<th style='width:20%;color:black;'>Size</th>
<th style='width:20%;color:black;'>Print</th>
<th style='width:10%;color:black;'>Sign</th>
<th style='width:10%;color:black;'>Options</th>
</tr>
</thead>
<tbody>
<?php



include('db.php');
	      	
	       	echo "<tr>
			  <td align='center'>Delinquent Payday Loan Letter</td>
	 		  <td align='center'>Letter</td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-print' alt=''></i></a></td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-pencil' alt=''></i></a></td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-file' alt=''></i></a></td>
		   	  

		   	  </tr>
		   	  
		   	  <tr>
			  <td align='center'>Delinquent Personal Loan Letter</td>
	 		  <td align='center'>Letter</td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-print' alt=''></i></a></td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-pencil' alt=''></i></a></td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-file' alt=''></i></a></td>
		   	  </tr>
		   	  
		   	  
		   	  <tr>
			  <td align='center'>Delinquent Commercial Loan Letter</td>
	 		  <td align='center'>Letter</td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-print' alt=''></i></a></td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-pencil' alt=''></i></a></td>
	 		  <td align='center'><a href='?id=".$transaction_id."' title=''><i class='glyphicon glyphicon-file' alt=''></i></a></td>
		   	  </tr>
		   	  ";
     
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
