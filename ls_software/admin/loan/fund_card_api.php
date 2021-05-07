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




$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];
$last_name=$row['last_name'];
$customer_numbr=$row['mobile_number'];


}

//echo "fname is:".$first_name;

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




$sql_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$username=$row_user['username'];

}

//echo "fname is:".$username;



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
      
      $amount=$_GET['amount_to_pay'];
      $amount = number_format((float)$amount, 2, '.', '');
      $card=$_GET['card_number'];
      $card=str_replace(" ","","$card");
      
      $zip_code=$_GET['zip_code'];
      $address=$_GET['address'] ;
      $cvv=$_GET['cvv_number'];
      $expiry_card=$_GET['exp_date'];
      $expire_date=str_replace("/","","$expiry_card");
      $customer_id=$loan_create_id;
    
       $firstname=$first_name.' '.$lastname;
    
    
    //  echo "Customer ID: $customer_id<br>";
    // echo "Payment Amount: $amount<br>";
    //  echo "Card Number: $card<br>";
    //  echo "Card Exp: $expire_date<br>";
    //  echo "CVV: $cvv<br>";
    //  echo "Customer First Name: $firstname<br>";
    //  echo "Customer address: $address<br>";
    //  echo "Zip Code: $zip_code<br><hr>";
//********************************************* GET BASE URL 

$sql_payment_api=mysqli_query($con, "select * from payment_api_urls where name='live_url'"); 

while($row_payment_api = mysqli_fetch_array($sql_payment_api)) {

$url_payment_api=$row_payment_api['url'];
$app_token_payment=$row_payment_api['token'];

//echo "url_payment_api: $url_payment_api<br>";
//echo "app_token_payment: $app_token_payment<br>";
}

//******************************************************************************************************************************

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "$url_payment_api/instant-funding-pages/dee04842-f272-4937-8db0-480ba6942f4a/one-time-use-url",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "customer_id": "'.$customer_id.'",
    "amount": "'.$amount.'"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    "Authorization: $app_token_payment"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response."<br><hr>";

$data_paywithcard=json_decode($response,true);

$status=$data_paywithcard['status'];

$url=$data_paywithcard['url'];

//echo $url."<br> $status <hr>";

//********************************************************************************************************************************
if($status=='error')
  {
      $response= str_replace("[","","$response");
      $response= str_replace("]","","$response");
     // echo "This: ".$response."<br>";
     $data=json_decode($response ,true);
     $status=$data['status'];
     $displayerror=$data['errors']['name'];
     $error_description=$data['errors']['description'];
      $payment_error= "$status: $displayerror $error_description, Try to Fund $amount.";
      
      
         $query_in  = "INSERT INTO `tbl_fund_card`(`customer_id`, `amount`, `url`)  VALUES ('$customer_id','$amount','$payment_error')";
        $result_in = mysqli_query($con, $query_in);
        if ($result_in) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        //echo "<h3> Error Inserting Data </h3>";
        }
 
 
     $date_update= date('Y-m-d H:i:s');
     $loan_account_statuss= "Error In Fund Card Via Repay";
    $query_insert_activity = "Insert into application_status_updates (application_id, loan_create_id, user_id, status, creation_date) Values ('$user_fnd_id', '$loan_create_id', '$u_id', '$loan_account_statuss', '$date_update')";
    mysqli_query ($con , $query_insert_activity);
      
  }
  else{

       $query_in  = "INSERT INTO `tbl_fund_card`(`customer_id`, `amount`, `url`)  VALUES ('$customer_id','$amount','$url')";
        $result_in = mysqli_query($con, $query_in);
        if ($result_in) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        //echo "<h3> Error Inserting Data </h3>";
        }
        
       
 
 
     $date_update= date('Y-m-d H:i:s');
     $loan_account_statuss= "Successfully Fund Card Via Repay";
    $query_insert_activity = "Insert into application_status_updates (application_id, loan_create_id, user_id, status, creation_date) Values ('$user_fnd_id', '$loan_create_id', '$u_id', '$loan_account_statuss', '$date_update')";
    mysqli_query ($con , $query_insert_activity);
}


  if($status=='error')
  {
      echo "<h2 style='color:red'>Card is Not Funded,Due to $payment_error</h2>";
      echo "<a href='fund_card_amount.php?id=$id'><button name='' type='submit' class='btn btn-danger' style='color: #fff;background-color: blue;border-color: blue;'>Change Information</button></a>";
  }
  else{
  echo "<h2 style='color:#007bff'>Card Funded Successfully with Amount: $amount & Customer ID: $customer_id</h2><br><hr>";
  
  echo"<table>
  <tr style='background-color: #F5E09E;color: black;'>
    <th>Funding Amount</th>
    <th>Funding URL</th>
  </tr>
  <tr>
    <td>$amount</td>
    <td><a href='$url' target='_blank'>Click Here To Fund A Card</a></td>
  </tr> 
</table><br><hr>";
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
  
?>
</body>

</html>
