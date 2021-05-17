<?php
error_reporting(0);
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

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

if(isset($_POST['submit'])) {
    
    
    $customer_id=$_POST['customer_id'];
    $amount=$_POST['amount'];
    
      //echo "$customer_id<br>";
      //echo "$amount<br>";
}

//************************************************ GET Form ID API ***********************************


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://lsbanking.sandbox.repay.io/checkout/merchant/api/v1/instant-funding-pages/99770010-991f-494f-b215-bd0037967dec/one-time-use-url",
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
    'Authorization: apptoken OWU4NjE3NzgtMDkwYy00NzI4LWE4NmEtMzhmOTJkZjYwODA0OmEyYzZiNzY5LWRkN2MtNGNjZS1hNmI4LTRmZDFhMDI5MTNiOQ=='
    //'Authorization: apptoken YTE0ODY5ZmUtOTQ1OS00NWQ5LTk0NjctOTk3MTJiNzM5MmNhOjkzMTdhMmYxLWNlZjAtNGY5Mi04MDQ0LWI0MDYwYzcxZDg1Mg=='
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response."<br><hr>";

$data_paywithcard=json_decode($response,true);

$status=$data_paywithcard['status'];

$url=$data_paywithcard['url'];

//echo $url."<br> $status <hr>";

if($status=='error')
  {
  }
  else{

        $query_in  = "INSERT INTO `tbl_fund_card`(`customer_id`, `amount`, `url`)  VALUES ('$customer_id','$amount','$url')";
        $result_in = mysqli_query($con, $query_in);
        if ($result_in) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        //echo "<h3> Error Inserting Data </h3>";
        }
}
?>
 <h2 class="form-signin-heading">


<?php 
  if($status=='error')
  {
      echo "Card is Not Funded,Due to Incorrect Information<br><br>";
      echo "<a href='fund_card.php'>Go Back</a>";
  }
  else{
  echo "Card Funded Successfully with Amount: $amount & Customer ID: $customer_id<br><br>";
  echo "<a href='fund_card.php'>Go Back</a>";
  }
  
  ?>
  </h2><hr />

<!--<script type="text/javascript">-->
<!--window.location.href = 'pay_with_card.php';-->
<!--</script>-->


 </div>
    
</div>
</body>
</html>