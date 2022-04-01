<?php
error_reporting(0);
session_start();
include_once '../dbconnect.php';
include_once '../dbconfig.php';
include_once '../functions.php';

date_default_timezone_set('America/Los_Angeles');


?>


<!--pay_with_card_api.php?id=<?php echo $id;?>&amount_to_pay=<?php echo $amount_to_pay;?>&card_number=<?php echo $card_number;?>&address=<?php echo $address;?>&zip_code=<?php echo $zip_code;?>&cvv_number=<?php echo $cvv_number;?>&exp_date=<?php echo $exp_date;?>';-->



<?php
 $current_date= date("Y-m-d") ;
 //$id=$_GET['id'];
 $current_time = date('H:i');
//$sql_fnd=mysqli_query($con, "select * from tbl_loan where payment_date = '$current_date' AND repay_status='0' AND loan_status='Active' limit 1"); 
echo  $current_time;
echo "select * from tbl_loan_schedules  where `payment_date` = '$current_date' AND `schedule_time` < '$current_time' AND `status`='0' limit 1";
$sql_fnd1=mysqli_query($con, "select * from tbl_loan_schedules  where `payment_date` = '$current_date' AND `schedule_time` < '$current_time' AND `status`='0'  limit 1"); 

while($row_fnd1 = mysqli_fetch_array($sql_fnd1)) {
    $FFF_id = $row_fnd1['id'];
    $f_loan_id = $row_fnd1['loan_id'];
    $f_amount = $row_fnd1['amount'];
    $f_card = $row_fnd1['card'];
    
$sql_fnd=mysqli_query($con, "select * from tbl_loan where loan_create_id = '$f_loan_id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];
$loan_original_id = $row_fnd['loan_id'];
$loan_create_id=$row_fnd['loan_create_id'];
echo $loan_create_id."<br>";
//echo "FND_ID" .$user_fnd_id;
}






$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];
$last_name=$row['last_name'];
$customer_numbr=$row['mobile_number'];
$address=$row['address'];
$city=$row['city'];
$state=$row['state'];
$zip_code=$row['zip_code'];

}

//echo "fname is:".$first_name;

$sql=mysqli_query($con, "select * from tbl_loan where loan_create_id= '$loan_create_id'"); 

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




$sql_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$username=$row_user['username'];

}






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
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dee2e6;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
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
      
      $sql_user=mysqli_query($con, "SELECT * FROM `loan_initial_banking` WHERE `card_number` = '$f_card'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$card=$row_user['card_number'];
$cvv=$row_user['cvv_number'];
$card_exp_date=$row_user['card_exp_date'];

}
      
      $amount=$f_amount;
      $amount = number_format((float)$amount, 2, '.', '');
      echo "AMOUNT : $amount";
      $card=$card;
      $card=str_replace(" ","","$card");
      
      $zip_code=$zip_code;
      $address=$address ;
      $cvv=$cvv;
      $expiry_card=$card_exp_date;
      $expire_date=str_replace("/","","$expiry_card");
      $customer_id=$loan_create_id;
    
       $firstname=$first_name.' '.$last_name;
    
    
     echo "Customer ID: $customer_id<br>";
    echo "Payment Amount: $amount<br>";
     echo "Card Number: $card<br>";
     echo "Card Exp: $expire_date<br>";
     echo "CVV: $cvv<br>";
     echo "Customer First Name: $firstname<br>";
     echo "Customer address: $address<br>";
     echo "Zip Code: $zip_code<br><hr>";
//********************************************* GET BASE URL 

$sql_payment_api=mysqli_query($con, "select * from payment_api_urls where name='live_url2'"); 

while($row_payment_api = mysqli_fetch_array($sql_payment_api)) {

$url_payment_api=$row_payment_api['url'];
$app_token_payment=$row_payment_api['token'];

//echo "url_payment_api: $url_payment_api<br>";
//echo "app_token_payment: $app_token_payment<br>";
}

//********************************************


//*********************************************** GET Form ID API ***********************************
  $curl = curl_init();

  curl_setopt_array($curl, array(
  CURLOPT_URL => "$url_payment_api/checkout",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "payment_method": "card",
  "Source": "Optima Financial Solutions Inc"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    "Authorization: $app_token_payment"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo "<br>Response 1".$response."<br>";

$data=json_decode($response,true);
$checkout_form_id=$data['checkout_form_id'];
//echo "checkout_form_id: $checkout_form_id.<br><hr>";
//************************************************ GET Form ID API END ***********************************


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "$url_payment_api/checkout-forms/$checkout_form_id/paytoken",
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
    "Authorization: $app_token_payment"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo "<br>Response 2".$response;


$data_paytoken=json_decode($response,true);
$paytoken=$data_paytoken['paytoken'];
echo "paytoken: $paytoken.<br><hr><br>";
//*********************************************************************** Pay Token API END



$curl = curl_init();

curl_setopt_array($curl, array(
 CURLOPT_URL => "$url_payment_api/checkout-forms/$checkout_form_id/token-payment",
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
  "Source": "Optima Financial Solutions Inc",
  "PaymentChannel": "web",
  "convenience_fee": "0",
  "waive_conv_fee": false,
  "address_street": "'.$address.'",
  "address_zip": "'.$zip_code.'",
  "ChannelUser":"denice@lsbanking.com"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
 echo "<br>Response 3".$response.".<br><hr><br>";
 echo '{
  "amount": "'.$amount.'",
  "customer_id": "'.$customer_id.'",
  "transaction_type": "sale",
  "paytoken": "'.$paytoken.'",
  "cardholder_name": "'.$firstname.'",
  "card_number": "'.$card.'",
  "card_cvc": "'.$cvv.'",
  "card_expiration": "'.$expire_date.'",
  "Source": "Optima Financial Solutions Inc",
  "PaymentChannel": "web",
  "convenience_fee": "0",
  "waive_conv_fee": false,
  "address_street": "'.$address.'",
  "address_zip": "'.$zip_code.'",
  "ChannelUser":"denice@lsbanking.com"
}';
// echo '{
//   "amount": "'.$amount.'",
//   "customer_id": "'.$customer_id.'",
//   "transaction_type": "sale",
//   "paytoken": "'.$paytoken.'",
//   "cardholder_name": "'.$firstname.'",
//   "card_number": "'.$card.'",
//   "card_cvc": "'.$cvv.'",
//   "card_expiration": "'.$expire_date.'",
//   "Source": "Optima Financial Solutions Inc",
//   "PaymentChannel": "web",
//   "convenience_fee": "0",
//   "waive_conv_fee": false,
//   "address_street": "'.$address.'",
//   "address_zip": "'.$zip_code.'",
//   "ChannelUser":"lior@lsbanking.com"
// }';



$data_paywithcard=json_decode($response,true);

$status=$data_paywithcard['status'];


$merchant_id=$data_paywithcard['merchant_id'];
$transaction_id=$data_paywithcard['pn_ref'];
$auth_code=$data_paywithcard['auth_code'];
$trx_status=$data_paywithcard['trx_status'];
$result_text=$data_paywithcard['resp_msg'];

$zip=$data_paywithcard['zip'];

//$amount=$data_paywithcard['requested_auth_amount'];
//$amount = number_format((float)$amount, 2, '.', '');
$card_bin=$data_paywithcard['card_bin'];

$exp_date=$data_paywithcard['exp_date'];

$card_last_four=$data_paywithcard['payment_method_detail']['card_last_four'];

$name_on_card=$data_paywithcard['name_on_card'];
$customer_id=$data_paywithcard['customer_id'];
$payment_channel="web";
$merchant_name=$data_paywithcard['merchant_name'];
$date=$data_paywithcard['date'];
$trans_type_id=$data_paywithcard['trans_type_id'];



            
             $new_date= date("Y-m-d");





//  echo "merchant_id: $merchant_id<br>";
//  echo "transaction_id: $transaction_id<br>";
//  echo "auth_code: $auth_code<br>";
//  echo "trx_status: $trx_status<br>";
//  echo "result_text: $result_text<br>";
//  echo "zip: $zip<br>";
//  echo "amount: $amount<br>";
//  echo "card_bin: $card_bin<br>";
//  echo "exp_date: $exp_date<br>";
//  echo "card_last_four: $card_last_four<br>";
//  echo "name_on_card: $name_on_card<br>";
//  echo "customer_id: $customer_id<br>";
//  echo "payment_channel: $payment_channel<br>";
//  echo "merchant_name: $merchant_name<br>";
//  echo "date: $new_date<br>";
//  echo "trans_type_id: $trans_type_id<br><hr><br>";





 if($status=='error')
   {
mysqli_query($con,"UPDATE `tbl_loan` SET `repay_status`='5' WHERE `loan_create_id` = '$loan_create_id'");
      $response= str_replace("[","","$response");
       $response= str_replace("]","","$response");
      // echo "This: ".$response."<br>";
      $data=json_decode($response ,true);
      $status=$data['status'];
      $displayerror=$data['errors']['name'];
      $error_description=$data['errors']['description'];
       $payment_error= "$status: $displayerror $error_description, Try to pay $amount with card ($card)";
     
mysqli_query($con,"UPDATE `tbl_loan_schedules` SET `status`='5' ,`payment_report`='$payment_error',`payment_time`='$current_time',`payment_date_done`='$current_date' WHERE `id` = '$FFF_id'"); 
      
        $payment_method='Repay - Schedule';
        $amount='0.00';
        $date_r= date('Y-m-d');
        $query  = "INSERT INTO loan_transaction (loan_id,loan_create_id,user_fnd_id,payment_method,payoff_amount,payment_date,type_of_payment,type_of_loan,created_at,created_by)  VALUES ('$loan_original_id','$loan_create_id','$user_fnd_id','$payment_method','$amount','$date_r','$payment_error','payday loan','$date_r','$u_id')";
        $result = mysqli_query($con, $query);
 
 
     $date_update= date('Y-m-d H:i:s');
     $loan_account_statuss= "Error In Payment Via Repay ($card)";
    $query_insert_activity = "Insert into application_status_updates (application_id, loan_create_id, user_id, status, creation_date) Values ('$user_fnd_id', '$loan_create_id', '$u_id', '$loan_account_statuss', '$date_update')";
    mysqli_query ($con , $query_insert_activity);
      
  }
   if($card_last_four>0){

        $query_in  = "INSERT INTO `tbl_pay_with_card` (`user_fnd_id`,`loan_create_id`,`merchant_id`, `transaction_id`, `auth_code`, `trx_status`, `result_text`, `zip_code`, `amount`, `card_bin`, `card_exp`, `card_last_four`, `name_on_card`, `customer_id`, `payment_channel`, `source`, `transaction_type`, `transaction_date`)  VALUES ('$user_fnd_id','$loan_create_id','$merchant_id','$transaction_id','$auth_code','$trx_status','$result_text','$zip','$amount','$card_bin','$exp_date','$card_last_four','$name_on_card','$customer_id','$payment_channel','$merchant_name','$trans_type_id','$new_date')";
        $result_in = mysqli_query($con, $query_in);
        if ($result_in) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        //echo "<h3> Error Inserting Data </h3>";
        }
        
        $payment_method='Repay - Schedule';
        $type_of_payment='Repay';
        $query  = "INSERT INTO loan_transaction (loan_id,loan_create_id,user_fnd_id,payment_method,payoff_amount,payment_date,type_of_payment,type_of_loan,created_at,created_by,repay_transaction_id)  VALUES ('$loan_original_id','$loan_create_id','$user_fnd_id','$payment_method','$amount','$new_date','$type_of_payment','payday loan','$date','$u_id','$transaction_id')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        } 
 
 mysqli_query($con, "UPDATE tbl_loan SET  last_payment_date='$payment_date', loan_status='Paid'  where user_fnd_id ='$user_fnd_id' AND loan_id='$id'");
 
mysqli_query($con,"UPDATE `tbl_loan_schedules` SET `status`='1',`payment_report`='$result_text',`payment_time`='$current_time',`payment_date_done`='$current_date',`transaction_id`='$transaction_id' WHERE `id` = '$FFF_id'");
 
     $date_update= date('Y-m-d H:i:s');
     $loan_account_statuss= "Payment is made Via Repay";
    $query_insert_activity = "Insert into application_status_updates (application_id, loan_create_id, user_id, status, creation_date) Values ('$user_fnd_id', '$loan_create_id', '$u_id', '$loan_account_statuss', '$date_update')";
    mysqli_query ($con , $query_insert_activity);


mysqli_query($con,"UPDATE `tbl_loan` SET `repay_status`='1' WHERE `loan_create_id` = '$loan_create_id'");
 }


  if($status=='error')
  {
      echo "<h2 style='color:red'>Payment Not Done,$payment_error</h2>";
      echo "<a href='pay_with_card_amount.php?id=$id'><button name='' type='submit' class='btn btn-danger' style='color: #fff;background-color: blue;border-color: blue;'>Change Information</button></a>";
  }
  else{
  echo "<h2 style='color:#007bff'>Payment Done Successfully with Transaction ID: $transaction_id & Status: $result_text</h2><br><hr>";
  
  echo"<table>
  <tr style='background-color: #F5E09E;color: black;'>
    <th>Card Number</th>
    <th>CVV</th>
    <th>Amount</th>
    <th>Transaction ID</th>
  </tr>
  <tr>
    <td>$card</td>
    <td>$cvv</td>
    <td>$amount</td>
    <td>$transaction_id</td>
  </tr> 
</table><br><hr>";
  echo "<a href='view_all_payments.php?id=$id' style='text-align: center;'><button name='' type='submit' class='btn btn-danger' style='background-image: linear-gradient(to bottom,red 0,red 100%);
    color: #fff;
    background-color: red;border-color: red;'>View Payment</button></a>";
  }
  
  
   //******************************************** **/     
      
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
} 
?>
</body>

</html>
