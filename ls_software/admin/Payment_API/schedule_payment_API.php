<?php
error_reporting(0);
session_start();
include_once 'dbconnect.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_api_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$DBcon->close();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LS Financing Registration</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="style.css" type="text/css" />

</head>
<body>
<?php include('menu.php') ;?>
<div class="signin-form">

	<div class="container">
     


<?php


if(isset($_POST['btn-scheduled'])) {
    
    include 'dbconfig.php';
    
    $name=$_POST['name'];
    $customer_id=$_POST['customer_id'];
    $amount=$_POST['amount'];
    $card=$_POST['card'];
    $cvv=$_POST['cvv'];
    $expiry_month_card=$_POST['expiry_month_card'];
    $expiry_year_card=$_POST['expiry_year_card'];
    $expire_date=$expiry_month_card.''.$expiry_year_card;
    $date_from=$_POST['date_from'];
    $timestamp = strtotime($date_from);
    $from_date= date("Y-m-d", $timestamp);
    
    $date_to=$_POST['date_to'];
    $timestamp = strtotime($date_to);
    $to_date= date("Y-m-d", $timestamp);
             
    $frequency=$_POST['frequency'];
    $zip_code=$_POST['zip_code'];
    
    

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
  "Source": "LS Financing"
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
  "Source": "LS Financing",
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
  "Source": "LS Financing",
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
//************************************************************************ Schedule API END*/
?>
  <h2 class="form-signin-heading"> 
  
  <?php 
  if($status=='error')
  {
      echo "Payment Not Scheduled Due to Incorrect Information Try Again<br><br>";
      echo "<a href='scheduled_payment.php'>Go Back</a>";
  }
  else{
  echo $message."<br><br>";
  echo "<a href='scheduled_payment.php'>Go Back</a>";
  }
  
  ?>
  
  </h2><hr />


<!--<script type="text/javascript">-->
<!--window.location.href = 'scheduled_payment.php';-->
<!--</script>-->
<?php
}
?>
 </div>
    
</div>
</body>
</html>