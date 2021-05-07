<?php
$id=$_GET['id'];
?>


<?php

$url_logo="../signature_customer/completed";

include 'dbconnect.php';
include 'dbconfig.php';
$iddd=$_GET['id'];
 echo "idddd". $iddd;

//echo "key is".$mail_key;

$sql1=mysqli_query($con, "select * from loan_initial_banking where email_key='$iddd' "); 

while($row1 = mysqli_fetch_array($sql1)) {

$mail_key=$row1['email_key'];
$signed_status=$row1['sign_status'];

$creation_datee=$row1['creation_date'];
 
 $timestamp = strtotime($creation_datee);
 $creation_date= date("m-d-Y", $timestamp);


$fnd_id=$row1['user_fnd_id'];
$loan_id_bor=$row1['loan_id'];
$type_of_card=$row1['type_of_card'];
$card_number=$row1['card_number'];
$card_exp_date=$row1['card_exp_date'];

$bank_name=$row1['bank_name'];
$routing_number=$row1['routing_number'];
$account_number=$row1['account_number'];

$cvv_number=$row1['cvv_number'];

$img_signed = $row1['signed_pic'];

$result_sig = $url_logo .'/doc_signs/'. $img_signed;
}


//echo "ID is".$loan_id;



$sql_loan=mysqli_query($con, "select * from tbl_loan where loan_create_id= '$loan_id_bor' "); 

while($row_loan = mysqli_fetch_array($sql_loan)) {
    
    
    $amount_of_loan=$row_loan['amount_of_loan'];
    $amount_of_loan=number_format($amount_of_loan, 2);
    $payment_date=$row_loan['payment_date'];
   
    $timestamp = strtotime($payment_date);
    $payment_date= date("m-d-Y", $timestamp);
    
    $creation_date=$row_loan['creation_date'];
    
    $timestamp = strtotime($creation_date);
    $creation_date= date("m-d-Y", $timestamp);
    
     $var = "$payment_datee";
//$payment_date= date("m-d-Y", strtotime($var) );
//$loan_fee = $row_loan['loan_fee'];

//$loan_fee = number_format($loan_fee, 2);
//$loan_payable = $row_loan['loan_total_payable'];
//$loan_payable = number_format($loan_payable, 2);

    
    // echo "LOAN Amount".$amount_of_loan;
    $date1=$creation_date;
	$date2=$payment_date;
//	function dateDiff($date1, $date2) 
//	{
//	  $date1_ts = strtotime($date1);
//	  $date2_ts = strtotime($date2);
//	  $diff = $date2_ts - $date1_ts;
//	  return round($diff / 86400);
//	}
//	$dateDiff= dateDiff($date1, $date2);
// echo "Days".$dateDiff."<br>";

$diff_creation_date = strtotime($creation_date);
$diff_payment_date = strtotime($payment_date);
$datediff =  $diff_payment_date - $diff_creation_date;
$datediff = round($datediff / (60 * 60 * 24));


   
	
	$created_by = $row_loan['created_by'];
    
 }
 
  $sql_loan_settings=mysqli_query($con, "select * from tbl_loan_setting where loan_amount= '$amount_of_loan'"); 

while($row_loan_settings = mysqli_fetch_array($sql_loan_settings)) {

$loan_fee=$row_loan_settings['loan_fee'];
$loan_payable=$row_loan_settings['payoff_amount'];
}
 
   $calculation = (($loan_fee/$amount_of_loan)/($datediff/365) * 10000) / 100;
    $calculation = round($calculation, 2);
  	$anual_pr= $calculation;
 
 
 $sql_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$username=$row_user['username'];

}


 
 
 

$sql2=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id='$fnd_id' "); 
while($row2 = mysqli_fetch_array($sql2)) {
$ff_name=$row2['first_name'];
$l_name=$row2['last_name'];
$f_name= $ff_name.' '.$l_name;
$address=$row2['address'];
$city=$row2['city'];
$state=$row2['state'];
$zip=$row2['zip_code'];
$mobile_number=$row2['mobile_number'];
$address=$row2['address'];
}
    $search_dir = "doc_signs/$result";
   $images = glob("$search_dir/*.png");
   sort($images);

   // Image selection and display:

   //display first image
   if (count($images) > 0) { // make sure at least one image exists
       $img = $images[0]; // first image
      // echo "<img src='$img' height='150' width='150' /> ";
   } else {
       // possibly display a placeholder image?
   }
?>




<?php
ob_start();


// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Crunch Apple');
$pdf->SetTitle('LSBANKING');
$pdf->SetSubject('');
$pdf->SetKeywords('');

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);


if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
$pdf->SetFont('helvetica', '', 11);

// add a page
$pdf->AddPage();

//$pdf->MultiCell(70, 50, $key1 , 0, 'J', false, 1, 125, 30, true, 0, false, true, 0, 'T', false);

$pdf->SetFont('helvetica', '', 10);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// set style for barcode
$style = array(
	'border' => false,
	'vpadding' => 'auto',
	'hpadding' => 'auto',
	'fgcolor' => array(0,0,0),
	'bgcolor' => false, //array(255,255,255)
	'module_width' => 1, // width of a single module in points
	'module_height' => 1 // height of a single module in points
);

// set style for barcode
$style = array(
	'border' => 0,
	'vpadding' => 'auto',
	'hpadding' => 'auto',
	'fgcolor' => array(0,0,0),
	'bgcolor' => false, //array(255,255,255)
	'module_width' => 1, // width of a single module in points
	'module_height' => 1 // height of a single module in points
);

 $html = '<br><br><img src="images/Money-Line-Logo.JPG" style="height:400%" align="left"/><br><span style="text-align:left">4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403</span><br><br>
 <b style="text-align:center">CALIFORNIA PROMISSORY NOTE AND SECURITY AGREEMENTCONSUMER GOODS DIRECT -CONSUMER PURPOSE</b>
<br><br>

<span style="font-size:8px;"><table border="1" style="text-align:center">
<tbody>
<tr>
<td style="text-align:left">Borrower Name and Address</td>
<td style="text-align:left">Lender Name and Address</td>
</tr>
<tr>
<td style="text-align:center" height="50">Borrower Name and Address</td>
<td style="text-align:center" height="50">LS Financing, Inc
DBA Money Line
4645 Van Nuys Blvd Suite 202
Sherman Oaks, CA 91403
Ph. (747) 300-1542
</td>
</tr>
<tr>
<td style="text-align:left">Co-Borrower Name and Address</td>
<td style="text-align:left">License No.:60DBO-88277</td>
</tr>
<tr>
<td style="text-align:center" height="50"></td>
<td style="text-align:left" height="50">Account Number:</td>
</tr>
<tr>
<td style="text-align:left">Date of Loan:</td>
<td style="text-align:left">Maturity Date: </td>
</tr>

</tbody>
</table></span>
<span style="font-size:9px;">In this Promissory Note and Security Agreement (“Agreement”). Borrower and Co-Borrower are referred to as “you” and “your” and Lender is referred to as “we” “us” and “our”. The Federal Truth in Lending Act Disclosure is part of this Agreement. On the date shown opposite your signature(s) below, we have loaned you money and you have granted to us security interest in your motor vehicle described below (“Vehicle”) as collateral to secure repayment. </span>
<br><br>
<span style="font-size:8px;"><table border="1" style="text-align:center">
<tbody>
<tr>
<td style="text-align:left">Vehicle Description:</td>
<td style="text-align:left">Make: </td>
<td style="text-align:left">VIN# </td>
</tr>
<tr>
<td style="text-align:left">Year:</td>
<td style="text-align:left">Model: </td>
<td style="text-align:left">Color: Balck</td>
</tr>
<tr>
<td style="text-align:left">Odometer:</td>
<td style="text-align:left">License/Plate No: </td>
<td style="text-align:left">Body Style:</td>
</tr>

</tbody>
</table></span><br>
<span style="font-size:8px;"> <table border="1" style="text-align:center">
<tbody>
<tr>
<td  colspan="4" style="text-align:center"><b>FEDERAL TRUTH-IN-LENDING DISCLOSURE STATEMENT</b></td>
</tr>
<tr>
<td style="text-align:center"><b>ANNUAL PERCENTAGE RATE </b><br>The cost of your <br> credit as a yearly<br>rate<br><br>'.$anual_pr.'%<br></td>
<td style="text-align:center"><b>FINANCE CHARGE</b><br>The dollar amount the<br>
Credit will cost you<br><br><br><br> $'.$loan_fee.'<br></td>
<td style="text-align:center"><b>AMOUNT FINANCE</b><br>The amount of credit<br>provided to you or on your <br>behalf<br><br><br>$'.$amount_of_loan.'<br></td>
<td style="text-align:center"><b>TOTAL OF PAYMENTS</b><br>The amount you will have <br> paid after all scheduled <br> payments are made<br> <br><br> $'.$loan_payable.'<br></td>
</tr>
</tbody>
</table></span>
<br>
Your payment schedule will be:<br>
 <span style="font-size:9px;"><table border="1">
<tbody>
<tr style="text-align:center">
<td>Number of Payments</td>
<td>Amount of Payment</td>
<td>When Payment is Due</td>
</tr>
<tr>
<td align="center"><br>1<br></td>
<td align="center">$</td>
<td align="center"></td>
</tr>
<tr>
<td align="center"></td>
<td align="center"></td>
<td align="center">Monthly, Beginning</td>
</tr>
<tr>
<td align="center"></td>
<td align="center"></td>
<td align="center"><br>/         /<br></td>
</tr>
<tr>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
</tr>
</tbody>
</table></span>
<b style="font-size:8px;">Security: </b><span style="font-size:8px;">You are giving a security interest in your vehicle.<span><br>
<b style="font-size:8px;">Late Charge: </b><span style="font-size:8px;">If any payment is not made within 10 days after it is due, you will be charged a $10.00 late fee.<span><br>
<b style="font-size:8px;">Prepayment: </b><span style="font-size:8px;">If you pay off early you will not have to pay a penalty. See your contract document for any additional information about nonpayment default and the right to accelerate the maturity of the obligation.<span><br>
<b style="font-size:8px;text-align:center"> *The Lender may retain a portion of these amounts </b><br><br>
<table border="1">
<tbody>
<tr>
<td> Itemization of Amount Financed</td>
<td> Important Notice to Borrower(s)</td>
</tr>
<tr>

<td align="left">
<span style="font-size:9px;">

A-0. Amount Given to you Directly<br> 
A-1. Amount Paid To:<br>
  A-2. Amount Paid To:<br>                                     
A-3. Amount Paid To:<br>                                     
A-4. Amount Paid To:<br>                                     
A-5. Amount Paid To:<br>        
B. DMV Registration Fees<br>
  C. DMV Lien Fee<br>
  D. Renewal Fee<br>
  E. Amount Financed (A through D)<br>
  F. Administrative Fee (Prepaid Finance Charge)<br>
  G. Total Loan Amount
</span>

</td>
<td align="left"> <b style="font-size:7px;">THIS IS A HIGH-COST LOAN. YOU MAY BE ABLE TO OBTAIN A LOAN FROM SOMEONE ELSE AT A LOWER INTEREST RATE. LS FINANCING ADVISES YOU TO THINK CAREFULLY BEFORE YOU DECIDE TO TAKE THIS LOAN.</b>
<br><br>
Borrower’s Signature &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date :
<br><br>
X__________________________________

<br><br>
Co-Borrower’s Signature &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date :

<br><br>
X__________________________________
</td>
</tr>
</tbody>
</table>

';

$pdf->writeHTML($html,25,30); 


 
$data_shipment  = ":";



$pdf->Ln();
$html = '<h1>LSBANKING </h1>';
$html_underline = '<b style="text-decoration:underline">PLEASE LEAVE THIS LABEL UNCOVERED.</b>';
// ---------------------------------------------------------

//Close and output PDF document

$pdf->Output('Case.pdf', 'I');

$pdf_data = ob_get_contents();
$file_name = $id."page_1";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>