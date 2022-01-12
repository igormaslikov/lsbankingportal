<?php
error_reporting(0);
session_start();
include_once '../dbconnect.php';
include_once '../dbconfig.php';
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
$fund_card="fund_card";
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
table,th, td {
  border: 1px solid black;
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
<div class="col-lg-3"><p>Loan Amount: <b style="color:red"> $<?php echo $val.$amount_loan;?></b></p></div>
<div class="col-lg-3"><p>Loan ID:<b style="color:red"> <?php echo $loan_create_id;?> </b> </p></div>
<div class="col-lg-3"><p>User ID:<b style="color:red"> <?php echo $user_fnd_id;?> </b> </p></div>

</div>
      <br><br>
         <div class="container-fluid" style="width:100%; margin:0 auto;">
        <h3>Make a Payment: </h3>

   <form action ="" method="POST" enctype="multipart/form-data">
  <input type="text" name="name_id" value="<?php echo $name_id;?>"  style="display:none;">
  
  <div class="row">
      
       <div class="col-lg-6">
      <label for="usr">Amount</label>
      <input type="text" name="payoff_amount" class="form-control" id="usr" placeholder="Payment Amount" value="">
    </div>
      
      <div class="col-lg-6">
      <label for="usr">Payment Method</label>
    <select name="payment_method" id="payment_method" class="form-control"  value="">
<option value=""></option>
<option value="Debit">Debit</option>
<option value="ACH">ACH</option>
<option value="Bank Deposit">Bank Deposit</option>
<option value="Cash">Cash</option>
<option value="eCheck">eCheck</option>
<option value="Repay">Repay</option>
<option value="Zelle">Zelle</option>
<option value="Venmo">Venmo</option>
<option value="Charge Off">Charge Off</option>

</select>
    </div>
      
      
    
    
     <div class="col-lg-6">
      <label for="usr">Payment Date</label>
      <input type="date" name="payment_date" class="form-control" id="usr" placeholder="" value="<?php echo $next_payment;?>">
    </div>
    
    
    
        <div class="col-lg-6">
      <label for="usr">Type Of Payment</label>
    <select name="type_of_payment" id="type_of_payment" class="form-control"  value="">
<option value=""></option>
<option value="Payoff">Payoff</option>
<option value="Pay Down">Pay Down</option>
<option value="Settlement">Settlement</option>
<option value="Chargeoff">Chargeoff</option>

</select>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Payment Description</label>
      <textarea name="loan_notes" class="form-control" id="usr" placeholder="Payment Description" value=""></textarea>
    </div>
    
    
    </div>
    
    <br>
    
      <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: blue;border-color: blue;">Add New Transaction</button>
      <button name="btn" class="btn btn-danger" style="background-image: linear-gradient(to bottom,red 0,red 100%);color: #fff;background-color:red;border-color: red;"><a href="add_auth_code.php?id=<?php echo $id; ?>" style="color:white">Pay Via Repay</a></button>
      <button name="btn" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#FFA500 0,#FFA500 100%);color: #FFA500;background-color:#FFA500;border-color: #FFA500;"><a href="add_auth_code.php?id=<?php echo $id; ?>&fund_card=<?php echo $fund_card;?>" style="color:white">Fund A Card</a></button>
  </form>
  
</div>
</div>
</div>
        
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  
  
  <?php 

   error_reporting(0);
  

if(isset($_POST['btn-submit'])) 
{

$payment_method= $_POST['payment_method']; 
$payoff_amount= $_POST['payoff_amount'];
$payoff_amount = number_format((float)$payoff_amount, 2, '.', '');
$payment_date= $_POST['payment_date'];
$loan_id_payoff= $_POST['loan_id'];
$info="";
$quick_pay= "";
$type_of_payment= $_POST['type_of_payment'];
$laon_notes=$_POST['loan_notes'];
$date = date('Y-m-d H:i:s');

$query  = "INSERT INTO loan_transaction (loan_id,loan_create_id,user_fnd_id,payment_method,payoff_amount,payment_date,info,quick_pay,type_of_payment,type_of_loan,payment_description,created_at,created_by)  VALUES ('$id','$loan_create_id','$user_fnd_id','$payment_method','$payoff_amount','$payment_date','$info','$quick_pay','$type_of_payment','payday loan','$laon_notes','$date','$u_id')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        } 
 
 mysqli_query($con, "UPDATE tbl_loan SET  last_payment_date='$payment_date'  where user_fnd_id ='$user_fnd_id' AND loan_id='$id'");
 
 
  $date_update= date('Y-m-d H:i:s');
     $loan_account_statuss= "Payment is made";
    $query_insert_activity = "Insert into application_status_updates (application_id, loan_create_id, user_id, status, creation_date) Values ('$user_fnd_id', '$loan_create_id', '$u_id', '$loan_account_statuss', '$date_update')";
    mysqli_query ($con , $query_insert_activity);
    
 
 //************************************  Email To LsBanking *************************// 

$start = strtotime($next_payment);
$end   = strtotime($payment_date);

$days_between = ceil(abs($end - $start) / 86400);

//echo $days_between;





//************************************  Email To LsBanking END *************************// 


$to  = 'leads@mymoneyline.com'; 

// subject
$subject = 'Payday Loan';

// message
$message = '
<html>

<body>
  <p>Payday Loan Payment ('.$loan_create_id.')</p>
  
  <table class="table table-striped table-bordered">
    <tr style="background-color: #F5E09E;color: black;">
      <th style="width:20%;">Customer</th>
<th style="width:25%;color:black;">Amount</th>
<th style="width:20%;color:black;">Payment Method</th>
<th style="width:20%;color:black;">Account Status</th>
<th style="width:15%;color:black;">DPD</th>
    </tr>
    <tr>
              <td align="center">'.$first_name.' '.$last_name.'</td>
			  <td align="center">$'.$payoff_amount.'</td>
	 		  <td align="center">'.$payment_method.'</td>
	 		  <td align="center">'.$loan_status.'</td>
	 		  <td align="center">'.$payment_description.'</td>
	 		  <td style="padding-right:50px">'.$days_between.'</td>

    </tr>
   
  </table>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


//mail($to, $subject, $message, $headers);

admin_leads_email_notification($subject,$message)

//*******************************************************************************
?>

<script type="text/javascript">
window.location.href = 'loan_summary.php?id=<?php echo $id ;?>';
</script>


  
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
