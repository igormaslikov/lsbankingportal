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
$auth_code=$userRow['auth_code'];
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
$customer_zip_code=$row['zip_code'];

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
      
      
      
      <?php
      
      
        $sql_loan=mysqli_query($con, "select * from loan_initial_banking where user_fnd_id = '$user_fnd_id' AND loan_id='$loan_create_id'"); 

while($row_bank_detail_sec = mysqli_fetch_array($sql_loan)) {
     $card=$row_bank_detail_sec['card_number'];
     $cvv=$row_bank_detail_sec['cvv_number'];
     $expiry_card=$row_bank_detail_sec['card_exp_date'];
     
     $expire_date=str_replace("/","","$expiry_card");
}

 $sql_fre=mysqli_query($con, "select * from source_income where user_fnd_id = '$user_fnd_id'"); 

while($row_fre = mysqli_fetch_array($sql_fre)) {
     $frequency=$row_fre['pay_period'];
     
     if($frequency=='Bi-Weekly')
     {
         $frequency='BIWEEKLY';
     }
     
     if($frequency=='Weekly')
     {
         $frequency='WEEKLY';
     }
     
      if($frequency=='Mothly')
     {
         $frequency='MONTHLY';
     }
     
}
    $customer_id=$loan_create_id;
    $amount=$_GET['amount_to_pay'];
    $zip_code=$customer_zip_code;
    $name=$first_name.' '.$lastname;
   
    $date_from=$_POST['date_from'];
    $timestamp = strtotime($date_from);
    $from_date= date("Y-m-d", $timestamp);
    
    $date_to=$_POST['date_to'];
    $timestamp = strtotime($date_to);
    $to_date= date("Y-m-d", $timestamp);
    
    
     echo "Customer ID: $customer_id<br>";
      echo "Customer First Name: $name<br>";
     echo "Payment Amount: $amount<br>";
     echo "Payment Freequency: $frequency<br>";
     echo "Card Number: $card<br>";
     echo "Card Exp: $expire_date<br>";
     echo "CVV: $cvv<br>";
    
     echo "Zip Code: $zip_code<br>";
     echo "From Date: $from_date<br>";
     echo "To Date: $to_date<br>";

/*********************************************** GET Form ID API ***********************************
  
    
    

//************************************************ GET Form ID API ***********************************
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://lsbanking.sandbox.repay.io/checkout/merchant/api/v1/checkout',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "payment_method": "card",
  "Source": "Pacifica Finance Group"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: apptoken YTE0ODY5ZmUtOTQ1OS00NWQ5LTk0NjctOTk3MTJiNzM5MmNhOjkzMTdhMmYxLWNlZjAtNGY5Mi04MDQ0LWI0MDYwYzcxZDg1Mg=='
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;

$data=json_decode($response,true);
$checkout_form_id=$data['checkout_form_id'];
//echo "checkout_form_id: $checkout_form_id<br>";
//************************************************ GET Form ID API END ***********************************


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://lsbanking.sandbox.repay.io/checkout/merchant/api/v1/checkout-forms/$checkout_form_id/paytoken",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "transaction_type": "scheduled_sale",
  "schedule_frequency": "'.$frequency.'",
  "schedule_interval": 1,
  "schedule_starts": "'.$from_date.'",
  "schedule_ends": "'.$to_date.'",
  "schedule_max_runs": 30,
  "amount": "'.$amount.'",
  "customer_id": "'.$customer_id.'",
  "cardholder_name": "'.$name.'",
  "card_number": "'.$card.'",
  "card_cvc": "'.$cvv.'",
  "card_expiration": "'.$expire_date.'",
  "Source": "Pacifica Finance Group",
  "PaymentChannel": "web"
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: apptoken YTE0ODY5ZmUtOTQ1OS00NWQ5LTk0NjctOTk3MTJiNzM5MmNhOjkzMTdhMmYxLWNlZjAtNGY5Mi04MDQ0LWI0MDYwYzcxZDg1Mg==',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;

$data_paytoken=json_decode($response,true);
$paytoken=$data_paytoken['paytoken'];
//echo "paytoken: $paytoken";
//*********************************************************************** Pay Token API END



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://lsbanking.sandbox.repay.io/checkout/merchant/api/v1/checkout-forms/$checkout_form_id/token-payment",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "transaction_type": "scheduled_sale",
  "schedule_frequency": "'.$frequency.'",
  "schedule_interval": 1,
  "schedule_starts": "'.$from_date.'",
  "schedule_ends": "'.$to_date.'",
  
  "amount": "'.$amount.'",
  "customer_id": "'.$customer_id.'",
  "paytoken": "'.$paytoken.'",
  "cardholder_name": "'.$name.'",
  "card_number": "'.$card.'",
  "card_cvc": "'.$cvv.'",
  "card_expiration": "'.$expire_date.'",
  "Source": "Pacifica Finance Group",
  "PaymentChannel": "web",
  "address_zip" : "'.$zip_code.'"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: apptoken YTE0ODY5ZmUtOTQ1OS00NWQ5LTk0NjctOTk3MTJiNzM5MmNhOjkzMTdhMmYxLWNlZjAtNGY5Mi04MDQ0LWI0MDYwYzcxZDg1Mg=='
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;

$data_schedule=json_decode($response,true);

$status=$data_schedule['status'];

$message=$data_schedule['message'];
$scheduled_payment_id=$data_schedule['scheduled_payment_id'];
$schedule_max_runs=$data_schedule['schedule_max_runs'];
$schedule_ends=$data_schedule['schedule_ends'];
$schedule_starts=$data_schedule['schedule_starts'];
$schedule_summary=$data_schedule['schedule_summary'];
$payment_channel=$data_schedule['payment_data']['payment_channel'];
$MultiPay=$data_schedule['payment_data']['MultiPay'];
$amount=$data_schedule['payment_data']['amount'];
$customer_id=$data_schedule['payment_data']['customer_id'];
$address_zip=$data_schedule['payment_data']['address_zip'];
$transaction_type=$data_schedule['payment_data']['transaction_type'];
$Source=$data_schedule['payment_data']['Source'];
$payment_method=$data_schedule['payment_data']['payment_method'];
$card_bin=$data_schedule['payment_data']['card_bin'];
$card_token=$data_schedule['payment_data']['card_token'];
$card_last_four=$data_schedule['payment_method_detail']['card_last_four'];


// echo "message: $status<br>";
// echo "scheduled_payment_id: $scheduled_payment_id<br>";
// echo "schedule_max_runs: $schedule_max_runs<br>";
// echo "schedule_ends: $schedule_ends<br>";
// echo "schedule_starts: $schedule_starts<br>";
// echo "schedule_summary: $schedule_summary<br>";
// echo "payment_channel: $payment_channel<br>";
// echo "MultiPay: $MultiPay<br>";
// echo "amount: $amount<br>";
// echo "customer_id: $customer_id<br>";
// echo "address_zip: $address_zip<br>";
// echo "transaction_type: $transaction_type<br>";
// echo "Source: $Source<br>";
// echo "payment_method: $payment_method<br>";
// echo "card_bin: $card_bin<br>";
// echo "card_token: $card_token<br>";
// echo "card_last_four: $card_last_four<br>";
$new_creationDate = date("Y-m-d");
if($status=='error')
  {
  }
  else{
$query_in  = "INSERT INTO `tbl_schedule_payment`(`message`, `scheduled_payment_id`, `schedule_max_runs`, `schedule_ends`, `schedule_starts`, `schedule_summary`, `payment_channel`, `multi_pay`, `amount`, `customer_id`, `address_zip`, `transaction_type`, `source`, `payment_method`, `card_bin`, `card_token`, `card_last_four`, `paytoken`, `created_at`)  VALUES ('$message','$scheduled_payment_id','$schedule_max_runs','$schedule_ends','$schedule_starts','$schedule_summary','$payment_channel','$MultiPay','$amount','$customer_id','$address_zip','$transaction_type','$Source','$payment_method','$card_bin','$card_token','$card_last_four','$paytoken','$new_creationDate')";
        $result_in = mysqli_query($con, $query_in);
        if ($result_in) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        //echo "<h3> Error Inserting Data </h3>";
        }
  }
************************************************************************ Schedule API END

    **/     
      
      ?>
      
     </div>
</div>
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
  
?>
</body>

</html>
