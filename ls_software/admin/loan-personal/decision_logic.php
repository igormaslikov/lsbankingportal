<?php
error_reporting(0);
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: ../index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$u_id=$userRow['user_id'];
$u_access_id = $userRow['access_id'];
if($u_access_id!='1'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}
else {
$DBcon->close();

?>

<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

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

include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';


$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];
$last_name=$row['last_name'];
$customer_numbr=$row['mobile_number'];
$decision_logic_status=$row['decision_logic_status'];


}

//echo "fname is:".$first_name;

?>




<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';


$sql=mysqli_query($con, "select * from tbl_personal_loans where user_fnd_id= '$user_fnd_id' AND p_loan_id = '$id'"); 

while($row = mysqli_fetch_array($sql)) {

$loan_id=$row['p_loan_id'];
//echo "fndid is:".$fnd_id;
$amount_loan=$row['principal_amount'];
$amount_loan = number_format((float)$amount_loan, 2, '.', '');

if ($amount_loan !='0')
{
   
   $val="$";
}

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

 $timestamp = strtotime($creation_date);
 
// Creating new date format from that timestamp
$new_creation_date= date("m-d-Y", $timestamp);
}

?>

<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';


$sql_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$username=$row_user['username'];

}

//echo "fname is:".$username;

?>



<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';


$sql_user=mysqli_query($con, "select * from tbl_loan_notes where loan_id= '$id'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$loan_notes=$row_user['notes'];

}

//echo "fname is:".$loan_notes;



$sql_t="SELECT p_loan_id FROM tbl_personal_loans  where sign_status='1' ORDER BY p_loan_id";

if ($result_t=mysqli_query($con,$sql_t))
  {
  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($result_t);
 // printf($rowcount);
  // Free result set
  $ye=mysqli_free_result($result_t);
  echo $ye;
  }

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
  border: 1px solid #dddddd;
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

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom" >
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
      
         <div class="container-fluid" style="width:100%; margin:0 auto;">
              <div class="row"> 
         <div class="col-lg-6">
<h3>Decision Logic Details:</h3>

</div>
        
        <div class="col-lg-6" align="right">
    
<b style="font-size: 20px;"><?php 
$dl_cmplt='<span class="glyphicon glyphicon-search" aria-hidden="true"></span>';

if($decision_logic_status =='1')
{echo '<span style = "color:green; text-align:left">Decision Logic Verified</span>'.$dl_cmplt;}

else{
    
    echo '<span style = "color:green; text-align:left">Decision Logic Not Verified</span>';
}

?></b>
    
    
    </div>

 <div class="col-lg-4">
    
 <form action="" method="post" enctype="multipart/form-data">
     <?php
     if($decision_logic_status=='0'){
         echo'
	<button name="btn-approve" type="submit" class="btn btn-danger" style="background-color: #1E90FF;color: white;border-color: #1E90FF;">Apprrove DL</button>';
     }
     
    else {
         echo'
	<button name="btn-disaprove" type="submit" class="btn btn-danger" style="background-color: #1E90FF;color: white;border-color: #1E90FF;">Disapprrove DL</button>';
     }
     
    ?>

  </form>

</div>

<div class="col-lg-4" align="center">
    <?php 
    if($payment>=$payoff OR  $loan_status== 'Paid')
           {
              echo "<a href='renew_loan.php?id=$id' <button name='btn' type='submit' class='btn btn-danger' style='background-image: linear-gradient(to bottom,#95c500 0,#639a0a 100%);
    color: #fff;
    background-color: #2a8206;
    border-color: #112f01;'>Renew Loan</button></a>";

               
            
           }
 ?>
</div>

<div class="col-lg-4" align="right">
 <a href="add_dl_code.php?id=<?php echo $id; ?>"> <button name="btn" type="submit" class="btn btn-danger" style="background-color: #1E90FF;color: white;border-color: #1E90FF;">Add New DL Code</button></a>

</div>

	

<?php
if(isset($_POST['btn-approve'])) {

mysqli_query($con,"UPDATE fnd_user_profile SET decision_logic_status ='1' where user_fnd_id= '$user_fnd_id' ");

}

?>
<?php
if(isset($_POST['btn-disaprove'])) {

mysqli_query($con,"UPDATE fnd_user_profile SET decision_logic_status ='0' where user_fnd_id= '$user_fnd_id' ");

}

?>

</div>
        <br>
        <table class="table table-striped table-bordered">
<thead>
<tr style="background-color: #F5E09E;color: black;">
<th style='width:8%;text-alig:center;'>Available Balance</th>
<th style='width:29%;text-alig:center;'>As of Date</th>
<th style='width:6%;'>Current Balance</th>
<th style='width:11%;'>Average Balance</th>
<th style='width:11%;'>Total Amount  PAYROLL</th>
<th style='width:6%;'>Over Draft (ov)</th>
<th style='width:11%;'>Deposits/Credits</th>
<th style='width:6%;'>Avg Bal Latest Month</th>
<th style='width:12%;'>Withdrawals/Debits</th>

</tr>
</thead>
<tbody>
    
    
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';


 $id=$_GET['id'];
 
$sql_dl_code=mysqli_query($con, "select * from tbl_decision_logic_codes where user_fnd_id= '$user_fnd_id'"); 
while($row_dl_code = mysqli_fetch_array($sql_dl_code)) {
	$dl_code = $row_dl_code['dl_code'];
	
// ************************API CODE ***************************

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://integration.decisionlogic.com/integration-v2.asmx",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">\r\n  <soap:Body>\r\n    <GetMultipleReportDetailsFromRequestCode7 xmlns=\"https://integration.decisionlogic.com\">\r\n      <serviceKey>DN2YYREQ9DPQ</serviceKey>\r\n      <requestCode>$dl_code</requestCode>\r\n    </GetMultipleReportDetailsFromRequestCode7>\r\n  </soap:Body>\r\n</soap:Envelope>",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: text/xml; charset=utf-8",
    "host: integration.decisionlogic.com",
    "postman-token: 656d6424-254f-0521-fabb-3e0fe463fc5d",
    "soapaction: https://integration.decisionlogic.com/GetMultipleReportDetailsFromRequestCode7"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
//echo $response;
}



$dom = new DOMDocument();
$dom->loadXML($response);
$hotels = $dom->getElementsByTagName('ReportDetail5');

foreach ($hotels as $hotel) {
    $DL_available_overdraft = $hotel->getElementsByTagName('TotalCount')->item(4)->nodeValue;
    $DL_available_balance = $hotel->getElementsByTagName('AvailableBalance')->item(0)->nodeValue;
	$DL_totalamount = $hotel->getElementsByTagName('TotalAmount')->item(0)->nodeValue;
	$DL_totalamount_loan = $hotel->getElementsByTagName('TotalAmount')->item(3)->nodeValue;
	$DL_as_date = $hotel->getElementsByTagName('AsOfDate')->item(0)->nodeValue;
    $DL_current_balance = $hotel->getElementsByTagName('CurrentBalance')->item(0)->nodeValue;
	$DL_average_balance = $hotel->getElementsByTagName('AverageBalance')->item(0)->nodeValue;
	
	$DL_deposits_credit = $hotel->getElementsByTagName('TotalCredits')->item(0)->nodeValue;
    $DL_avg_balance_last_month = $hotel->getElementsByTagName('AverageBalanceRecent')->item(0)->nodeValue;
	
	$DL_withdrawals = $hotel->getElementsByTagName('TotalDebits')->item(0)->nodeValue;
	break;
   
}

$DL_available_balance=number_format((float)$DL_available_balance, 2, '.', '');
$DL_current_balance=number_format((float)$DL_current_balance, 2, '.', '');
$DL_average_balance=number_format((float)$DL_average_balance, 2, '.', '');
$DL_totalamount=number_format((float)$DL_totalamount, 2, '.', '');
$DL_deposits_credit=number_format((float)$DL_deposits_credit, 2, '.', '');
$DL_avg_balance_last_month=number_format((float)$DL_avg_balance_last_month, 2, '.', '');
$DL_withdrawals=number_format((float)$DL_withdrawals, 2, '.', '');
// ************************ API CODE END**************************
     

        
        echo"<tr>
        
        <td>$$DL_available_balance</td>
        <td>$DL_as_date</td>
        <td>$$DL_current_balance</td>
        <td>$$DL_average_balance</td>
        <td>$$DL_totalamount</td>
        <td>$DL_available_overdraft</td>
        <td>$$DL_deposits_credit</td>
        <td>$$DL_avg_balance_last_month</td>
        <td>$$DL_withdrawals</td>
        </tr>";


}
	
    ?>
   
</tbody>
</table>



<br/><br/>
<hr>
<?php
 //************************************** PayRoll  Decision Logic API Start *****************************************
 echo "<hr>";
echo "<h3 style='text-align:center'>Decision Logic Payroll Details (".$dl_code.")</h3><br>";
echo "<span style='font-weight: bold;'>Type Of Transaction</span>";
echo "	  <span style='font-weight: bold; margin-left:3.5%'>Payroll Description:Standard Employment Income</span>";
	  
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://integration.decisionlogic.com/integration-v2.asmx",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">\r\n  <soap:Body>\r\n    <GetMultipleReportDetailsFromRequestCode7 xmlns=\"https://integration.decisionlogic.com\">\r\n      <serviceKey>DN2YYREQ9DPQ</serviceKey>\r\n      <requestCode>$dl_code</requestCode>\r\n    </GetMultipleReportDetailsFromRequestCode7>\r\n  </soap:Body>\r\n</soap:Envelope>",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: text/xml; charset=utf-8",
    "host: integration.decisionlogic.com",
    "postman-token: 656d6424-254f-0521-fabb-3e0fe463fc5d",
    "soapaction: https://integration.decisionlogic.com/GetMultipleReportDetailsFromRequestCode7"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
   //echo $response;
}



$dom = new DOMDocument();
$dom->loadXML($response);
$hotels = $dom->getElementsByTagName('TransactionSummary5');
	
	echo "<table>
  <tr>
    <th>Date</th>
    <th>Description</th>
    <th>Amount</th>
  </tr>";
	
foreach ($hotels as $hotel) {
	
	$TypeCode = $hotel->getElementsByTagName('TypeCodes')->item(0)->nodeValue;
    $Amount = $hotel->getElementsByTagName('Amount')->item(0)->nodeValue;
    $Description= $hotel->getElementsByTagName('Description')->item(0)->nodeValue;
	$TransactionDate= $hotel->getElementsByTagName('TransactionDate')->item(0)->nodeValue;
	
	$payroll_date= date('m/d/Y',strtotime($TransactionDate));

	//echo" ".$TypeCode.' '.$Amount."<br>";
	
	
	if($TypeCode == "py,dp")
	{
	
 echo"
 <tr>
    <td>$payroll_date</td>
    <td>$Description</td>
    <td>$$Amount</td>
  </tr>
 ";

        
	
	}
	
   
} 
 
 echo"</table>";
 
//************************************** PayRoll  Decision Logic API End ***************************************** 

?>
 <hr>
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
