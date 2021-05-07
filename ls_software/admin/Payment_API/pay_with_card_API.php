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

if(isset($_POST['btn-paynow'])) {
    include 'dbconfig.php';
    
    $customer_id=$_POST['customer_id'];
    $amount=$_POST['amount'];
    $card=$_POST['card'];
    $expiry_year_card=$_POST['expiry_year_card'];
    $expiry_month_card=$_POST['expiry_month_card'];
    $expire_date=$expiry_month_card.''.$expiry_year_card;
    $cvv=$_POST['cvv'];
    $firstname=$_POST['firstname'];
    $zip_code=$_POST['zip_code'];
    
    // echo "$customer_id<br>";
    // echo "$amount<br>";
    // echo "$card<br>";
    // echo "$expire_date<br>";
    // echo "$cvv<br>";
    // echo "$firstname<br>";
    // echo "$zip_code<br>";
    

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
//echo "checkout_form_id: $checkout_form_id.<br><hr>";
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
  "amount": "'.$amount.'",
  "customer_id": "'.$customer_id.'",
  "transaction_type": "sale"
  
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: apptoken YTE0ODY5ZmUtOTQ1OS00NWQ5LTk0NjctOTk3MTJiNzM5MmNhOjkzMTdhMmYxLWNlZjAtNGY5Mi04MDQ0LWI0MDYwYzcxZDg1Mg=='
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;


$data_paytoken=json_decode($response,true);
$paytoken=$data_paytoken['paytoken'];
//echo "paytoken: $paytoken.<br><hr><br>";
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
  "amount": "'.$amount.'",
  "customer_id": "'.$customer_id.'",
  "transaction_type": "sale",
  "paytoken": "'.$paytoken.'",
  "cardholder_name": "'.$firstname.'",
  "card_number": "'.$card.'",
  "card_cvc": "'.$cvv.'",
  "card_expiration": "'.$expire_date.'",
  "Source": "LS Financing",
  "PaymentChannel": "web",
  "address_zip" : "'.$zip_code.'"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response.".<br><hr><br>";




$data_paywithcard=json_decode($response,true);

$status=$data_paywithcard['status'];

$merchant_id=$data_paywithcard['merchant_id'];
$transaction_id=$data_paywithcard['pn_ref'];
$auth_code=$data_paywithcard['auth_code'];
$trx_status=$data_paywithcard['trx_status'];
$result_text=$data_paywithcard['result_text'];

$zip=$data_paywithcard['zip'];

$amount=$data_paywithcard['requested_auth_amount'];

$card_bin=$data_paywithcard['card_bin'];

$exp_date=$data_paywithcard['exp_date'];

$card_last_four=$data_paywithcard['payment_method_detail']['card_last_four'];

$name_on_card=$data_paywithcard['name_on_card'];
$customer_id=$data_paywithcard['customer_id'];
$payment_channel="web";
$merchant_name=$data_paywithcard['merchant_name'];
$date=$data_paywithcard['date'];
$trans_type_id=$data_paywithcard['trans_type_id'];



             $timestamp = strtotime($date);
             $new_date= date("Y-m-d", $timestamp);





// echo "merchant_id: $merchant_id<br>";
// echo "transaction_id: $transaction_id<br>";
// echo "auth_code: $auth_code<br>";
// echo "trx_status: $trx_status<br>";
// echo "result_text: $result_text<br>";
// echo "zip: $zip<br>";
// echo "amount: $amount<br>";
// echo "card_bin: $card_bin<br>";
// echo "exp_date: $exp_date<br>";
// echo "card_last_four: $card_last_four<br>";
// echo "name_on_card: $name_on_card<br>";
// echo "customer_id: $customer_id<br>";
// echo "payment_channel: $payment_channel<br>";
// echo "merchant_name: $merchant_name<br>";
// echo "date: $new_date<br>";
// echo "trans_type_id: $trans_type_id<br>";

if($status=='error')
  {
  }
  else{

        $query_in  = "INSERT INTO `tbl_pay_with_card` (`merchant_id`, `transaction_id`, `auth_code`, `trx_status`, `result_text`, `zip_code`, `amount`, `card_bin`, `card_exp`, `card_last_four`, `name_on_card`, `customer_id`, `payment_channel`, `source`, `transaction_type`, `transaction_date`)  VALUES ('$merchant_id','$transaction_id','$auth_code','$trx_status','$result_text','$zip','$amount','$card_bin','$exp_date','$card_last_four','$name_on_card','$customer_id','$payment_channel','$merchant_name','$trans_type_id','$new_date')";
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
      echo "Payment Not Done,Due to Incorrect Information<br><br>";
      echo "<a href='pay_with_card.php'>Go Back</a>";
  }
  else{
  echo "Payment Done Successfully with Transaction ID: $transaction_id & Status: $result_text<br><br>";
  echo "<a href='pay_with_card.php'>Go Back</a>";
  }
  
  ?>
  </h2><hr />

<!--<script type="text/javascript">-->
<!--window.location.href = 'pay_with_card.php';-->
<!--</script>-->
<?php
}
?>
 </div>
    
</div>
</body>
</html>