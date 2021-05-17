<?php
error_reporting(0);
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

include_once '../functions.php';
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
 
$sql_fnd=mysqli_query($con, "select * from tbl_loan where loan_id = '$id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];

$loan_create_id=$row_fnd['loan_create_id'];
//echo "FND_ID" .$user_fnd_id;
}


}


?>


<?php



$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];
$last_name=$row['last_name'];
$customer_numbr=$row['mobile_number'];


}

//echo "fname is:".$first_name;

?>
<?php



$sql=mysqli_query($con, "select * from tbl_loan where loan_id= '$id'"); 

while($row = mysqli_fetch_array($sql)) {

$loan_id=$row['loan_id'];
	$loan_create_id=$row['loan_create_id'];

//echo "fndid is:".$fnd_id;
$amount_loan=$row['amount_of_loan'];



//echo "Amount is:".$amount_loan;

$amount_left =$row['loan_total_payable'];
$bg_id=$row['bg_id'];
$next_payment =$row['payment_date'];
$payment_tenure =$row['payment_tenure'];
$escrow=$row['escrow'];
$primary_port=$row['primary_portfolio'];
$creation_date=$row['contract_date'];
$created_by=$row['created_by'];
$last_update=$row['last_update_by'];
$last_update_date=$row['last_update_date'];
$loan_status=$row['loan_status'];
 $timestamp = strtotime($creation_date);
 
// Creating new date format from that timestamp
$new_creation_date= date("m-d-Y", $timestamp);


$timestamppp = strtotime($next_payment);
$new_next_payment= date("m-d-Y", $timestamppp);


}

?>

 <?php



$sql_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$username=$row_user['username'];

}

//echo "fname is:".$username;

?> 


 <?php



$sql_transaction=mysqli_query($con, "select * from loan_transaction where loan_id= '$id'"); 

while($row_transaction = mysqli_fetch_array($sql_transaction)) {

$payment_method=$row_transaction['payment_method'];

$payoff_amount=$row_transaction['payoff_amount'];
$payment_date=$row_transaction['payment_date'];
$info=$row_transaction['info'];
$quick_pay=$row_transaction['quick_pay'];
$type_of_payment=$row_transaction['type_of_payment'];



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
<div class="col-lg-3"><p>Loan Amount: <b style="color:red"> $<?php echo $val.$amount_loan;?></b></p></div>
<div class="col-lg-3"><p>Loan ID:<b style="color:red"> <?php echo $loan_create_id;?> </b> </p></div>
<div class="col-lg-3"><p>User ID:<b style="color:red"> <?php echo $user_fnd_id;?> </b> </p></div>

</div>
      <br><br>
         <div class="container-fluid" style="width:100%; margin:0 auto;">
        <h3>Funded SMS: </h3>


 <?php 
 
  
  $name=$first_name.' '.$last_name;
  $message = "($name) Thank you for using Money Line, your for ($$amount_loan) has been deposited into your account. Your due date will be on ($new_next_payment). Have a great day!.";
  
send_sms($customer_numbr,$message);

//******************************************************************************** Spanish SMS **********************************************

  $name=$first_name.' '.$last_name;
  $message_spanish = "($name) gracias por usar Money Line, su préstamo de ($$amount_loan) ha sido depositado en su cuenta. La fecha de pago será ($new_next_payment).¡Tenga un excelente día!.";
 
 send_sms($customer_numbr,$message);

//*************************************************************************** Spanish SMS END *************************************************

$loan_transaction_id="";
//$date= date('Y-m-d H:i:s');
//$query_update_status= "INSERT INTO `application_status_updates`( `application_id`, `loan_create_id`, `user_id`, `status`, `creation_date`) VALUES ('$user_fnd_id','$loan_create_id','$u_id','Funded Payday Loan SMS English/Spanish Sent','$date')";
//echo   $query_update_status;     
//$result_status_update = mysqli_query($con, $query_update_status);
  
  application_notes_update($user_fnd_id,$loan_create_id,$u_id,'Funded Payday Loan SMS English/Spanish Sent',$loan_transaction_id);     
  mysqli_query($con,"UPDATE tbl_loan SET loan_status ='Active' where  loan_id='$id' AND loan_create_id='$loan_create_id'");
  
  
      mysqli_query($con,"UPDATE `fnd_user_profile` SET `application_status`='Funded' WHERE `user_fnd_id` = '$user_fnd_id'");
    mysqli_query($con,"UPDATE `tbl_loan` SET `fund_status`='1' WHERE `loan_create_id` = '$loan_create_id'");
    $application_id = "";
    $status = "Loan Has Been Funded and Application Status changed to Funded Against The Loan ID: $loan_create_id";
    application_notes_update($user_fnd_id,$loan_create_id,$u_id,$status,$loan_transaction_id);
    
  
  ?>
  



<br><br><br><br>
  <h2 align="center"> Congratulations message has been sent to customer </h2>
   
  <a href="loan_summary.php?id=<?php echo $id;?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;center;margin-left: 45%;margin-top: 2%;">Go Back</button> </a>







  
</div>
</div>
</div>
        
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  
  
 
</body>

</html>
