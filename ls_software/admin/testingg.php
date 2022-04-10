<?php
session_start();
include_once 'dbconnect.php';
include_once 'dbconfig.php';
include_once 'functions.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$u_id=$userRow['user_id'];
$u_name=$userRow['username'];

$u_access_id = $userRow['access_id'];
if($u_access_id=='0'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}


$id=$_GET['id'];
//echo "Name is: $id_fname";


$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$id'"); 

while($row = mysqli_fetch_array($sql)) {
$mobile_verification = $row['mobile_verification_status'];
$first_name=$row['first_name'];
//$middle_name =$row['middle_name'];
$last_name =$row['last_name'];
$customer_phone =$row['mobile_number'];
$customer_email =$row['email'];
$address=$row['address'];
$cityy=$row['city'];
$statee=$row['state'];
$zipp=$row['zip_code'];
$dob=$row['date_of_birth'];
$new_dob=date('Y-m-d',strtotime($dob));




$ssn=$row['ssn'];
$creation_date=$row['creation_date'];
$creationdate=date("m-d-y", strtotime($creation_date) );
$last_update=$row['last_update_by'];
$created_by=$row['created_by'];
$last_update_date=$row['last_update_date'];
$last_updatedate=date("m-d-Y H:i:s", strtotime($last_update_date) );
$fnd_dl_code = $row['dl_code'];

$appli_status=$row['application_status'];
$loan_amount=$row['amount_of_loan'];
$source_lead=$row['source_of_lead'];
$declined_reason=$row['declined_reason'];
$decision_logic_status = $row['decision_logic_status'];
$id_photo = $row['id_photo'];
$bank_front = $row['bank_front'];
$bank_back = $row['bank_back'];
$personal_loan_term = $row['personal_loan'];
$void_img = $row['void_img'];
$apr = $row['apr'];


$web = $row['website'];
$credit_score = $row['experian_credit_score'];

$title_loan_amount_db = $row['title_loan_amount'];
$loan_request_amount = $row['loan_request_amount'];
$payback_period = $row['payback_period'];
}

$sql_loan=mysqli_query($con, "select * from tbl_loan where user_fnd_id= '$id'"); 

while($row_loan = mysqli_fetch_array($sql_loan)) {

$amount_of_loan = $row_loan['amount_of_loan'];
}




$sql=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row = mysqli_fetch_array($sql)) {

$name=$row['username'];
}
//echo $name;


$sql=mysqli_query($con, "select * from tbl_users where user_id= '$last_update'"); 

while($row = mysqli_fetch_array($sql)) {

$name_update=$row['username'];
}
//echo $name;





$sql_source=mysqli_query($con, "select * from source_income where user_fnd_id= '$id'"); 

while($row_source = mysqli_fetch_array($sql_source)) {

$emp_name=$row_source['employer_name'];
$emp_phone=$row_source['work_phone_no'];
$net_check_amount=$row_source['net_check_amount'];
$direct_deposit=$row_source['direct_deposit'];
$how_paid=$row_source['pay_period'];
$last_pay_date=$row_source['last_pay_date'];
$next_pay_date=$row_source['next_pay_date'];
$address_b=$row_source['address_b'];

$income_month=$row_source['how_tell_ur_income'];
$mon_income=$row_source['monthly_income'];
}



$sql_business_query=mysqli_query($con, "select * from tbl_business_info where user_fnd_id= '$id'"); 

while($row_business_source = mysqli_fetch_array($sql_business_query)) {

$business_name=$row_business_source['business_name'];
$business_phone=$row_business_source['business_phone'];
$gross_amount=$row_business_source['monthly_gross_amount'];
$business_direct_deposit=$row_business_source['direct_deposit'];
$how_paid_business=$row_business_source['how_paid'];
$business_docs=$row_business_source['business_docs'];

}





$sql_vehicle_query=mysqli_query($con, "select * from tbl_vehicle_info where user_fnd_id= '$id'"); 

while($row_vehicle_source = mysqli_fetch_array($sql_vehicle_query)) {

$vehicle_year=$row_vehicle_source['vehicle_year'];
$vehicle_make=$row_vehicle_source['vehicle_made'];
$vehicle_model=$row_vehicle_source['vehicle_model'];
$vehicle_miles=$row_vehicle_source['vehicle_miles'];
$vehicle_kbb=$row_vehicle_source['vehicle_kbb'];
$vehicle_ltv=$row_vehicle_source['vehicle_ltv'];


}








$sql_bq=mysqli_query($con, "select * from binary_questions where user_fnd_id= '$id'"); 

while($row_bq = mysqli_fetch_array($sql_bq)) {
    
$mode_payment=$row_bq['bq_answer'];

}


	 $sql_emp="SELECT employer_name FROM source_income where user_fnd_id = '$id' ";

if ($result_emp=mysqli_query($con,$sql_emp))
  {
  // Return the number of rows in result set
  $rowcount_emp=mysqli_num_rows($result_emp);
 // printf($rowcount_customer);
  // Free result set
  $ye=mysqli_free_result($result_emp);
 // echo "<br>".$rowcount_emp;
  }



$sql_app_notes=mysqli_query($con, "select * from application_notes where user_fnd_id= '$id'"); 

while($row_app_notes = mysqli_fetch_array($sql_app_notes)) {
    
$app_notes=$row_app_notes['app_notes'];

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['email']; ?></title>

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />
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

<?php include('menu.php') ;?>
<section class="wrapper">

<div class ="container wrapper" style="margin-top:70px">


<hr>
	
  <hr><br>
 <?php
 // decision login api start
 

$finalDL_code = $fnd_dl_code; 
$decision_login_code = mysqli_query($con,"SELECT * FROM decision_login_codes where email ='$customer_email' ");
 while($row_decision_login_code = mysqli_fetch_array($decision_login_code))
{
$finalDL_code = $fnd_dl_code;

}
echo "<hr>";
echo "<b>Decision Logic Details (".$finalDL_code.")</b><br>";


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://integration.decisionlogic.com/integration-v2.asmx",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">\r\n  <soap:Body>\r\n    <GetMultipleReportDetailsFromRequestCode7 xmlns=\"https://integration.decisionlogic.com\">\r\n      <serviceKey>DN2YYREQ9DPQ</serviceKey>\r\n      <requestCode>$finalDL_code</requestCode>\r\n    </GetMultipleReportDetailsFromRequestCode7>\r\n  </soap:Body>\r\n</soap:Envelope>",
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
?>


<div class="row">


<div class="col-lg-6">
<span style="color:red">Available Balance  :</span><b> $<?php echo  number_format((float)$DL_available_balance, 2, '.', ''); ?></b>
</div>


<div class="col-lg-6">
<span style="color:red">As of Date</span> : <b>  <?php echo $DL_as_date; ?></b>
</div>

<div class="col-lg-6">
<span style="color:red">Current Balance</span> :  <b> $<?php echo  number_format((float)$DL_current_balance, 2, '.', ''); ?></b>
</div>

<div class="col-lg-6">
 <span style="color:red">Average Balance</span> :  <b> $<?php echo  number_format((float)$DL_average_balance, 2, '.', ''); ?></b>
</div>
<div class="col-lg-6">
<span style="color:red"> Total Amount  PAYROLL</span> :<b> $<?php echo  number_format((float)$DL_totalamount, 2, '.', ''); ?></b>
</div>
<div class="col-lg-6">
<span style="color:red"> Over Draft (ov)</span> : <b><?php echo  $DL_available_overdraft; ?></b>
</div>


<div class="col-lg-6">
<span style="color:red">Deposits/Credits</span> :  <b> $<?php echo  number_format((float)$DL_deposits_credit, 2, '.', ''); ?></b>
</div>

<div class="col-lg-6">
<span style="color:red">Avg Bal Latest Month</span> :  <b> $<?php echo  number_format((float)$DL_avg_balance_last_month, 2, '.', ''); ?></b>
</div>

<div class="col-lg-6">
<span style="color:red">Withdrawals/Debits</span> :  <b> $<?php echo  number_format((float)$DL_withdrawals, 2, '.', ''); ?></b>
</div>


</div>

<?php
 // decision login api start
 ?>
 <br>
 <hr>
 <br>
 
 
 
 	<?php
if ($web == 'lsprestamos' || $web == 'lsbanking_pl' || $web == 'mymoneyline_cl') {
$credit_report = mysqli_query($con,"SELECT * FROM  tbl_credit_report where user_fnd_id = '$id'  AND score>0 ");

echo '<br><table style="width:100%;padding:10px" class="table table-striped table-bordered">'."
<tr>
<th>Details Of Credit Report - </th><th>" ; if ($web == 'lsprestamos' || $web == 'lsbanking_pl' || $web == 'mymoneyline_cl') { echo ' - <a style="color:red; text-align:right" href="credit_report.php?id='.$id.'" target="_blank"><b  alt="Regenrate Credit Report">Run New Experian Credit Report
</b></a>';} echo'</th>
</tr>';


while($row_credit_report = mysqli_fetch_array($credit_report))
{
    $credit_report_id = $row_credit_report['id'];
    $credit_report_key = $row_credit_report['credit_report_key'];
    $user_fnd_id_cr = $row_credit_report['user_fnd_id'];
    $creation_date_cr = $row_credit_report['creation_date'];
    $score = $row_credit_report['score'];
	// PDF POPUP Code
	
	// PDF POPUP END CODE
echo "<tr>";
echo '<td><a href="credit_report_exsiting.php?id='.$user_fnd_id_cr.'&key='.$credit_report_key.'">'.$creation_date_cr.'   '."[Score - ". ltrim($score, '0')."]</a></td>";
echo "</tr>";
}
echo "</table><br>";
}
?>
   
 <?php
 //************************************** PayRoll  Decision Logic API Start *****************************************
 echo "<hr>";
echo "<h3 style='text-align:center'>Decision Logic Payroll Details (".$finalDL_code.")</h3><br>";
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
  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">\r\n  <soap:Body>\r\n    <GetMultipleReportDetailsFromRequestCode7 xmlns=\"https://integration.decisionlogic.com\">\r\n      <serviceKey>DN2YYREQ9DPQ</serviceKey>\r\n      <requestCode>$finalDL_code</requestCode>\r\n    </GetMultipleReportDetailsFromRequestCode7>\r\n  </soap:Body>\r\n</soap:Envelope>",
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
  // echo $response;
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
	<?php
	


$lender_documents = mysqli_query($con,"SELECT * FROM lender_documents where fnd_user_id = '$id' ");

echo '<br><table style="width:100%;padding:10px" class="table table-striped table-bordered">'."
<tr>
<th>Date</th>
<th>File Name</th>
<th>Created By</th>
</tr>";

while($row_lender_documents = mysqli_fetch_array($lender_documents))
{
    $doc_id = $row_lender_documents['id'];
$created_by_get_db = $row_lender_documents['created_by'];
$sql_lender_by_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by_get_db'"); 
$final_lender_by_user = '';
while($row_sql_lender_by_user = mysqli_fetch_array($sql_lender_by_user)) {
	$final_lender_by_user = $row_sql_lender_by_user['username'];
}
	// PDF POPUP Code
	
	// PDF POPUP END CODE
echo "<tr>";
echo "<td>" . $row_lender_documents['date_created'] . "</td>";
echo "<td>" . $row_lender_documents['file_name']. ' - <a  onclick="myFunction_lenderdocuments()" target = "frame_lender" href = "uploads_lender_documents/'.$row_lender_documents['file_name'].'">View Now</a>' . " - <a class='remove-box' href='delete_lender_documents.php?id=$id&doc_id=$doc_id' title='Delete This Document'><span class='glyphicon glyphicon-remove' aria-hidden='true' alt='delete'></span></a>".
 
"</td>";
echo "<td>" . $final_lender_by_user . "</td>";
echo "</tr>";
}
echo "</table><br>";


?>

 <div id="frame_lender" style="display:none; color:red">
 
 <b onclick="myFunction_lenderdocuments()">Close (X)</b>
 <iframe name="frame_lender"  style=" width:100%; height: 700px">
 </iframe>
 </div>
 <script>
function myFunction_lenderdocuments() {
  var x = document.getElementById("frame_lender");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>
<div class="row">
    <div class="col-lg-12">
      <label for="usr">Lender Documents </label>
     </div>
</div>

	 <form action="" method="post" enctype="multipart/form-data">
    
    <input type="file" name="lender_documents" class="btn btn-danger" id="lender_documents">
    <input type="submit" value="Upload File" class="btn btn-danger" name="submit_lender_documents">
   </form>
  
  
  </div>
</div>

  </div></div>
   </section>
<hr>
<script type="text/javascript">
    $('.remove-box').on('click', function () {
      var x =  confirm('Are you sure you want to delete?');
      if (x)
      return true;
  else
    return false;
      
    });
</script>
</body>
</html>

<?php 
if(isset($_POST['submit_lender_documents'])) {
include 'dbconnect.php';
include 'dbconfig.php';
$date= date('Y-m-d H:i:s'); 
$target_dir = "uploads_lender_documents/";
$target_file = $target_dir .$id."-".basename($_FILES["lender_documents"]["name"]);
$target_file_db = $id."-".basename($_FILES["lender_documents"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["lender_documents"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["lender_documents"]["name"]). " has been uploaded.";
		$insert_query_lender_docs = "INSERT Into lender_documents(fnd_user_id, file_name, date_created, created_by) VALUES ('$id','$target_file_db','$date','$u_id')";
		mysqli_query($con,$insert_query_lender_docs);
		
		echo '<meta http-equiv="refresh" content="0">';
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

}


if(isset($_POST['btn-notes-submit'])) {
    


$date= date('Y-m-d H:i:s');
$app_notes_update="Notes Updated : ".$_POST['app_notes'];
$query_update_status= "INSERT INTO `application_status_updates`( `application_id`, `user_id`, `status`, `creation_date`) VALUES ('$id','$u_id','$app_notes_update','$date')";
echo   $query_update_status;
	   $result_status_update = mysqli_query($con, $query_update_status);
        if ($result_status_update) {
          // echo "<div class='form'><h3> successfully added in application_status_updates.</h3><br/></div>";
		 
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
		echo '<meta http-equiv="refresh" content="0">';
}
if(isset($_POST['btn-submit'])) {
    

$first_name_update =$_POST['first_name'];
$last_name__update =$_POST['last_name'];
$phone_number_update = $_POST['phone_number'];
$email_update =$_POST['email'];
$monthly_income_update =$_POST['monthly_income'];
$payment_update =$_POST['payment'];
$address_update =$_POST['address'];
$city_update=$_POST['city_cus'];
$state_update=$_POST['state_cus'];
$zip_update=$_POST['zip_cus'];
$dob_update =$_POST['dob'];
$ssn_update =$_POST['ssn'];
$dl_code_update =$_POST['dl_code'];


$employer_name_update =$_POST['employer_name'];
$work_phone_update =$_POST['work_phone'];
$direct_deposit_update =$_POST['payment'];
$net_amount_update =$_POST['net_amount'];
$pay_fre_update =$_POST['get_paid'];
$last_date_update=$_POST['last_check'];
$next_date_update=$_POST['next_check'];

$business_name_update =$_POST['business_name'];
$business_phone_update =$_POST['business_phone'];
$gross_amount_update =$_POST['gross_amount'];
$business_direct_deposit_update =$_POST['business_direct_deposit'];
$business_get_paid_update=$_POST['business_get_paid'];
$business_docs_update=$_POST['business_docs'];


$vehicle_year_update =$_POST['vehicle_year'];
$vehicle_make_update =$_POST['vehicle_make'];
$vehicle_model_update =$_POST['vehicle_model'];
$vehicle_miles_update =$_POST['vehicle_miles'];
$vehicle_kbb_update=$_POST['vehicle_kbb'];
$vehicle_ltv_update=$_POST['vehicle_ltv'];






$app_status_update=$_POST['app_status'];
$source_lead_update=$_POST['source_of_lead'];
$amount_loan_update=$_POST['amount_loan'];
$decline_reason_update=$_POST['decline_reason'];
$app_notes_update="Notes Updated : ".$_POST['app_notes'];
$date= date('Y-m-d H:i:s');
$personal_loan=$_POST['personal_loan'];

$update_apr=$_POST['apr'];
$title_loan_amount=$_POST['title_loan_amount'];
$payback_period_update=$_POST['payback_period'];
$requested_loan_amount_update=$_POST['requested_loan_amount'];

$form_name=basename(__FILE__);

$sql_role=mysqli_query($con, "select * from access_form where form_name ='$form_name'"); 


while($row_role = mysqli_fetch_array($sql_role)) {

 $form_id=$row_role['id'];
 //echo $form_id;
}
 $update_allowed_validate = user_edit_roles($u_access_id,$form_id);
 
  if ($update_allowed_validate==1)
{

//************************************ ADMIN SMS Starts ****************//
     
    // Declined SMS Sent  start
     
	if($app_status_update == 'Declined'){
	    $message = "Hola ".$first_name_update." ".$last_name__update.",Gracias por aplicar con LS Financing Inc, lamentamos informarle que su aplicación ha sido declinada, usted no ha cumplido con los criterios correpondientes para extenderle un préstamo en estos momentos. Puede volver a aplicar después de 90 días.";
  send_sms($phone_number_update,$message);
	    
	}
	
	
	// Declined SMS Sent END
	
	
	// Approved Personal Loan SMS Start
	
	if($app_status_update == 'Approved Personal Loan'){
	   // $phone12 = "+12138840085";
	    $phone121 = "+12138840085";
	    $message = "Approved PL ".$first_name_update." ".$last_name__update." ".$phone_number_update." term ".$personal_loan."";
 send_sms($phone121,$message);




/************************************  Email To Denice *************************

$to_denice = "denice@lsbanking.com";

$subject_denice = "Approved Personal Loan";
$message_denice = "Approved Personal Loan ".$first_name_update." ".$last_name__update.", has been approved ".$phone_number_update." and loan term is ".$personal_loan.". ";
$headers_denice = "From: info@lsbanking.com";

mail($to_denice,$subject_denice,$message_denice,$headers_denice);


************************************  Email To Mayte *************************/ 

$to_mayte = "mayte@lsbanking.com";

$subject_mayte = "Approved Personal Loan";
$message_mayte = "Approved Personal Loan ".$first_name_update." ".$last_name__update.", has been approved ".$phone_number_update." and loan term is ".$personal_loan.". ";
$headers_mayte = "From: info@lsbanking.com";

//mail($to_mayte,$subject_mayte,$message_mayte,$headers_mayte);

admin_leads_email_notification($subject_mayte,$message_mayte);	    
	}
	
	// Approved Personal Loan SMS End
	
	
	
	

				// Review For Payday SMS Start
	
	if($app_status_update == 'Review For Payday'){
	    $phone_re_for_payday = "+18187316919";
	   $message_re_for_payday = "Review For Payday ".$first_name_update." ".$last_name__update;
  send_sms($phone_re_for_payday,$message);
	    
	}
	
	// Review For Payday SMS End
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
			// Credit Report Completed SMS Start
	
	if($app_status_update == 'Credit Report Completed'){
	    $phone12 = "+18187316919";
	    $message = " Credit Report Completed ".$first_name_update." ".$last_name__update;
 send_sms($phone12,$message);
	    
	}
	
	// Credit Report Completed SMS End
	
	
	
	
	
	
	
	
		// Decision Logic Completed SMS Start
	
	if($app_status_update == 'Decision Logic Completed'){
	    $phone_dl_completed = "+18187316919";
	    $message_dl_completed = " Decision Logic Completed ".$first_name_update." ".$last_name__update;
        send_sms($phone_dl_completed,$message);
	    
	}
	
	// Decision Logic Completed SMS End
	
	
	
	
	
	
	
		// Final Review For Personal Loan SMS Start
	
	if($app_status_update == 'Final Review For Personal Loan'){
	    $phone_f_re_pl = "+18187316919";
	    $message_f_re_pl = " Final Review Personal Loan ".$first_name_update." ".$last_name__update;
  send_sms($phone_f_re_pl,$message);
	    
	}
	
	// Final Review For Personal Loan SMS End
	
	
	
	
		// Bank Information Needed Start
	
	if($app_status_update == 'Bank Information Needed'){
	    
	    
/************************************  Email To Denice ************************* 

$to_denice = "denice@lsbanking.com";

$subject_denice = "Bank Information Needed";
$message_denice = "Bank Information Needed ".$first_name_update." ".$last_name__update.", has been approved ".$phone_number_update." and loan term is ".$personal_loan.". ";
$headers_denice = "From: info@lsbanking.com";

mail($to_denice,$subject_denice,$message_denice,$headers_denice);


************************************  Email To Mayte *************************/

$to_mayte = "mayte@lsbanking.com";

$subject_mayte = "Bank Information Needed";
$message_mayte = "Bank Information Needed ".$first_name_update." ".$last_name__update.", has been approved ".$phone_number_update." and loan term is ".$personal_loan.". ";
$headers_mayte = "From: info@lsbanking.com";

//mail($to_mayte,$subject_mayte,$message_mayte,$headers_mayte);
admin_leads_email_notification($subject_mayte,$message_mayte);	    
	    
	}
	
	// Bank Information Needed End
	
	
		// Interview Completed Needed Start
	
	if($app_status_update == 'Interview Completed'){
	    
	    
/************************************  Email To Denice ************************* 

$to_denice = "denice@lsbanking.com";

$subject_denice = "Interview Completed";
$message_denice = "Interview Completed ".$first_name_update." ".$last_name__update.", has been approved ".$phone_number_update." and loan term is ".$personal_loan.". ";
$headers_denice = "From: info@lsbanking.com";

mail($to_denice,$subject_denice,$message_denice,$headers_denice);


************************************  Email To Mayte *************************/ 

$to_mayte = "mayte@lsbanking.com";

$subject_mayte = "Interview Completed";
$message_mayte = "Interview Completed ".$first_name_update." ".$last_name__update.", has been approved ".$phone_number_update." and loan term is ".$personal_loan.". ";
$headers_mayte = "From: info@lsbanking.com";

//mail($to_mayte,$subject_mayte,$message_mayte,$headers_mayte);
	    
	admin_leads_email_notification($subject_mayte,$message_mayte);    
	}
	
	// Interview Completed End
	
	
	
		// Pending Documents Start
	
	if($app_status_update == 'Pending Documents'){
	    
	    
/************************************  Email To Denice ************************* 

$to_denice = "denice@lsbanking.com";

$subject_denice = "Pending Documents";
$message_denice = "Pending Documents ".$first_name_update." ".$last_name__update.", has been approved ".$phone_number_update." and loan term is ".$personal_loan.". ";
$headers_denice = "From: info@lsbanking.com";

mail($to_denice,$subject_denice,$message_denice,$headers_denice);


************************************  Email To Mayte *************************/ 

$to_mayte = "mayte@lsbanking.com";

$subject_mayte = "Pending Documents";
$message_mayte = "Pending Documents ".$first_name_update." ".$last_name__update.", has been approved ".$phone_number_update." and loan term is ".$personal_loan.". ";
$headers_mayte = "From: info@lsbanking.com";

//mail($to_mayte,$subject_mayte,$message_mayte,$headers_mayte);
	admin_leads_email_notification($subject_mayte,$message_mayte);    
	    
	}
	
	// Pending Documents End
	
	
		
		// No decision logic for payday Start
	
	if($app_status_update == 'No Decision Logic For Payday'){
	    
	    
/************************************  Email To Denice ************************* 

$to_denice = "denice@lsbanking.com";

$subject_denice = "No Decision Logic For Payday";
$message_denice = "No Decision Logic For Payday ".$first_name_update." ".$last_name__update.", has been approved ".$phone_number_update." and loan term is ".$personal_loan.". ";
$headers_denice = "From: info@lsbanking.com";

mail($to_denice,$subject_denice,$message_denice,$headers_denice);


************************************  Email To Mayte *************************/ 

$to_mayte = "mayte@lsbanking.com";

$subject_mayte = "No Decision Logic For Payday";
$message_mayte = "No Decision Logic For Payday ".$first_name_update." ".$last_name__update.", has been approved ".$phone_number_update." and loan term is ".$personal_loan.". ";
$headers_mayte = "From: info@lsbanking.com";

//mail($to_mayte,$subject_mayte,$message_mayte,$headers_mayte);
	 admin_leads_email_notification($subject_mayte,$message_mayte);   
	    
	}
	
	// No decision logic for payday End
	
	
	
	
	if($app_status_update == 'Approved Payday Loan'){	
// Final Review For Personal Loan Email Start

$to = "alejandra@lsbanking.com";

$subject = "Approved Payday Loan";
 $message = " Approved Payday Loan ".$first_name_update." ".$last_name__update.", 

has been approved ".$phone_number_update." and loan term is ".$personal_loan.". ";
$headers = "From: info@lsbanking.com";

//mail($to,$subject,$message,$headers);

admin_leads_email_notification($subject,$message);

}

	
	
	
//************************************ ADMIN SMS End ****************//


	

   	


        
	
	$query_update_status= "INSERT INTO `application_status_updates`( `application_id`, `user_id`, `status`, `creation_date`) VALUES ('$id','$u_id','$app_status_update','$date')";
echo   $query_update_status;
	   $result_status_update = mysqli_query($con, $query_update_status);
        if ($result_status_update) {
           echo "<div class='form'><h3> successfully added in application_status_updates.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
	
	

	
	

//mysqli_query ($con,"INSERT INTO `application_status_updates`( `application_id`, `user_id`, `status`, `creation_date`) VALUES ('$id','$u_id','$app_status_update','$date')");
mysqli_query($con, "UPDATE fnd_user_profile SET first_name ='$first_name_update' , last_name='$last_name__update' , mobile_number='$phone_number_update' , email='$email_update', address='$address_update', city='$city_update', state='$state_update', zip_code='$zip_update', date_of_birth='$dob_update', ssn='$ssn_update', last_update_by='$u_id',last_update_date='$date',application_status='$app_status_update',source_of_lead='$source_lead_update',declined_reason='$decline_reason_update', amount_of_loan='$amount_loan_update', dl_code='$dl_code_update', personal_loan='$personal_loan', apr='$update_apr', title_loan_amount='$title_loan_amount', loan_request_amount='$requested_loan_amount_update', payback_period='$payback_period_update' where user_fnd_id ='$id'"); 



if($rowcount_emp<1)
    {
        // *********************************** Employee Info Insertion **********************************************
        
       $query_emp  = "INSERT INTO source_income (user_fnd_id,employer_name,work_phone_no,net_check_amount,direct_deposit,pay_period,last_pay_date,next_pay_date,creation_date)  VALUES ('$id','$employer_name_update','$work_phone_update','$net_amount_update','$direct_deposit_update','$pay_fre_update','$last_date_update','$next_date_update','$date')";
        $result_emp = mysqli_query($con, $query_emp);
        if ($result_emp) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        } 
        
        // *********************************** Business Info Insertion **********************************************
        
       $query_business  = "INSERT INTO tbl_business_info (user_fnd_id,business_name,business_phone,monthly_gross_amount,direct_deposit,how_paid,business_docs,created_by,created_at)  VALUES ('$id','$business_name_update','$business_phone_update','$gross_amount_update','$business_direct_deposit_update','$business_get_paid_update','$business_docs_update','$u_id','$date')";
        $result_business = mysqli_query($con, $query_business);
        if ($result_business) {
            //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        } 
        
        // *********************************** Vehicle Info Insertion **********************************************
        
         $query_vehicle  = "INSERT INTO tbl_vehicle_info (user_fnd_id,vehicle_year,vehicle_made,vehicle_model,vehicle_miles,vehicle_kbb,vehicle_ltv,created_by,created_at)  VALUES ('$id','$vehicle_year_update','$vehicle_make_update','$vehicle_model_update','$vehicle_miles_update','$vehicle_kbb_update','$vehicle_ltv_update','$u_id','$date')";
        $result_vehicle = mysqli_query($con, $query_vehicle);
        if ($result_vehicle) {
            //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        } 
        
        
    }

else{
  mysqli_query($con, "UPDATE source_income SET employer_name ='$employer_name_update', work_phone_no='$work_phone_update', net_check_amount='$net_amount_update', direct_deposit='$direct_deposit_update', pay_period='$pay_fre_update', last_pay_date='$last_date_update', next_pay_date='$next_date_update', last_update_by='$u_id',last_update_date='$date' where user_fnd_id ='$id'"); 

  mysqli_query($con, "UPDATE tbl_business_info SET business_name ='$business_name_update', business_phone='$business_phone_update', monthly_gross_amount='$gross_amount_update', direct_deposit='$business_direct_deposit_update', how_paid='$business_get_paid_update', business_docs='$business_docs_update', last_update_by='$u_id', last_update_date='$date' where user_fnd_id ='$id'"); 
  
  mysqli_query($con, "UPDATE tbl_vehicle_info SET vehicle_year ='$vehicle_year_update', vehicle_made='$vehicle_make_update', vehicle_model='$vehicle_model_update', vehicle_miles='$vehicle_miles_update', vehicle_kbb='$vehicle_kbb_update', vehicle_ltv='$vehicle_ltv_update', last_update_by='$u_id', last_update_date='$date' where user_fnd_id ='$id'"); 
   
    
    
}	

mysqli_query($con, "UPDATE binary_questions SET bq_answer ='$payment_update', creation_date='$date', last_update_date='$date', last_update_by='$u_id',last_update_date='$date' where user_fnd_id ='$id'");   

mysqli_query($con, "UPDATE application_notes SET app_notes ='$app_notes_update', creation_date='$date', last_update_date='$date', last_update_by='$u_id',last_update_date='$date' where user_fnd_id ='$id'");   
  	  $delete_customer_string = "page_no=".$_GET['page_no'];
      $delete_customer_string = str_replace("#","",$delete_customer_string);
    ?>
    
    <script type="text/javascript">
window.location.href = 'edit_customer.php?id=<?php echo $id; ?>';
</script>
	
<?php

}

else{
  echo "<script type='text/javascript'>
window.location.href = 'not_authorize.php';
</script>";
}
}

?>


<h3 style="color:red;">Conversation  <span style="float:right;">  </span>   </h3>
<iframe src="https://pacificafinancegroup.com/loanportal/ls_software/admin/sms-chat/chat.php?admin_name=<?php echo $u_name;?>&fnd_id=<?php echo $cu_id ;?>&customer_name=<?php echo $first_name;?>" height="500px" width="100%" id="conversation"></iframe>