<?php
$id=$_GET['id'];
?>


<?php

$url_logo="https://mymoneyline.com/lsbankingportal/signature_customer/completed/";

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
    $loan_fee=$row_loan['loan_fee'];
    $loan_payable=$amount_of_loan+$loan_fee;
    $loan_payable=number_format($loan_payable, 2);
    $payment_date=$row_loan['payment_date'];
    $payment_date_db=$row_loan['payment_date'];
    $timestamp = strtotime($payment_date);
    $payment_date= date("m-d-Y", $timestamp);
    
    $creation_date=$row_loan['contract_date'];
    $creation_date_db=$row_loan['contract_date'];
    $timestamp = strtotime($creation_date);
    $creation_date= date("m-d-Y", $timestamp);
    
     //$var = "$payment_datee";
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

$start = strtotime($creation_date_db);
$end = strtotime($payment_date_db);
$days_between = ceil(abs($end - $start) / 86400);


 
  
//$calculation = $loan_fee/$amount_of_loan;
//$calculation_1 = $datediff/365;
//$calculation_1 = $calculation_1*10000;
//$calculation_1  = $calculation_1/100;

  //$calculation = round($calculation, 2);

	

	
	
	$created_by = $row_loan['created_by'];
    
 }
 
 
 
    $calculation = $loan_fee/$amount_of_loan*365/$days_between*100;
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
//'.$img_signed.'

 $html = '<h1 style="text-align:center">PAYDAY LOAN CONTRACT AND DISCLOSURE STATEMENT</h1>
 
 <table border="0" style="text-align:left">
 <tbody>
 <tr>
 <td>
    <b>Loan ID :</b> '.$loan_id_bor.' <br>
    <b>Contract Date   :</b>  '.$creation_date.' <br>
    <b>Borrower        :</b> '. $f_name.'<br>
    <b>Address         :</b> '.$address.'<br>
    <b>City, State, ZIP:</b> '.$city.' '.$state.' '.$zip.'<br><br>
 </td>
 <td>
 <b>Lender :</b> MoneyLine <br>
 <b>Address        :</b> 4645 Van Nuys Blvd #202 Sherman Oaks, CA 914035<br>
 <b>Phone         :</b> 888-540-7232<br>
 <b>Lender’s License:</b> 60DBO-88277<br><br>
 </td>
  </tr>
 </tbody>
 </table>


<table border="1" style="text-align:center">
<tbody>
<tr>
<td  colspan="4"><b style="text-align:center">FEDERAL TRUTH-IN-LENDING DISCLOSURE STATEMENT</b></td>
</tr>
<tr>
<td><b style="text-align:center">ANNUAL<br>
PERCENTAGE<br>
RATE</b> <br>The cost of your <br> credit as a yearly<br>rate<br><br>'.$anual_pr.'%<br></td>
<td><b style="text-align:center">FINANCE<br>
CHARGE</b><br>The dollar amount the<br>
Credit will cost you<br><br><br><br> $'.$loan_fee.'<br></td>
<td><b style="text-align:center">AMOUNT <br> FINANCE<br></b>The amount of credit<br>provided to you or on your <br>behalf<br><br><br>$'.$amount_of_loan.'<br></td>
<td><b style="text-align:center">TOTAL OF <br> PAYMENTS</b><br>The amount you will have <br> paid after all scheduled <br> payments are made<br> <br><br> $'.$loan_payable.'<br></td>
</tr>
</tbody>
</table>
<br><br>
<b>ITEMIZATION OF AMOUNT FINANCED</b><br><hr >

<table border="0" style="padding-top:10px;padding-bottom:10px">
 <tbody>
 <tr>
    <td style="text-align:center"><b>Amount Financed.</b></td>
    <td style="text-align:center"><b>Amount Given to you directly.</b></td>
    <td style="text-align:center"><b>Amount Refinanced.</b></td>
 </tr>
 <tr>
    <td style="text-align:center">$<u>'.$amount_of_loan.'</u></td>
    <td style="text-align:center">$<u>'.$amount_of_loan.'</u></td>
    <td style="text-align:center">$<u>0</u></td>
 </tr>
 </tbody>
 </table>

<br>

 <b>PAYMENT SCHEDULE</b> Your payment schedule will be:<br>
 <b><table border="1">
<tbody>
<tr style="text-align:center">
<td>Number of Payments</td>
<td>Amount of Payment</td>
<td>When Payment is Due</td>
</tr>
<tr>
<td align="center"><br>1<br></td>
<td align="center"><br>$'.$loan_payable.'<br></td>
<td align="center"><br>'.$payment_date.'<br></td>
</tr>
</tbody>
</table></b><br>

<div style="font-size:8px">
<b>Security:</b>
 Your post-dated payment(s) and/or Automated Clearing House Authorization (“ACHA”) which if so attached, is/are made part
of this Agreement, as though fully stated herein is security for the loan.<br>
<b>Prepayment:</b>A Consumer may cancel future payment obligations on a payday loan, without cost or finance charges, no later than the end of the
second business day, immediately following the day on which the payday loan was executed. If you pay off early, you will not be
entitled to a refund of a portion of the finance charge.<br>
<b>Dishonored Item Fee:</b> : Borrower will pay a fee to Lender of $ 15.00 if Borrower makes a payment on Borrower’s loan and the check or preauthorized
charge with which Borrower pays is later dishonored.<br>
<b>Deferred Payment:</b> Borrower cannot be prosecuted in a criminal action in conjunction with a deferred deposit transaction for a returned check or be
threatened with prosecution.LS Financing Inc may not accept any collateral in conjunction with a deferred deposit transaction. LS Financing Inc cannot
make a deferred deposit transaction contingent on the purchase of another product or service. Borrower’s check is part of a deferred deposit
transaction made pursuant to Section 23035 of the Financial Code and is not subject to the provisions of Section 1719 of the Civil Code. Borrower may
not be required to pay treble damages if this check does not clear<br>
<b>Complaints and Concerns:</b> Borrower can call to the Department of Financial Protection and Innovation\'s toll-free telephone number: 866-275-2677 for
making complaints and concerns calls.<br>
<u>LS Financing Inc. with License # 60DBO-88277 is licensed by the Department of Financial Protection and Innovation pursuant to the California Deferred
Deposit Transaction Law. California loans other than deferred deposit loans are issued pursuant to the California Financing Law. </u><br>

<b>I UNDERSTAND THAT IF I STILL OWE ON ONE OR MORE PAYDAY LOANS AFTER 35 DAYS, I AM ENTITLED TO
ENTER INTO A REPAYMENT TO ENTER INTO A REPAYMENT PLAN THAT I WILL GIVE ME AT LEAST 55 DAYS TO
REPAY THE LOAN IN INSTALLMENTS WITH NO ADDITIONAL FINANCE CHARGES, INTEREST, FEES, OR OTHER
CHARGES OF ANY KIND. <br><br>
WARNING: THIS LOAN IS NOT INTENTED TO MEET LONG-TERM FINANCIAL NEEDS. THIS LOAN SHOULD ONLY
BE USED TO MEET SHORT-TERM CASH NEEDS. THE COST OF YOUR LOAN MAY BE HIGHER THAT LOANS
OFFERED BY OTHER LENDING INSTITUTIONS. THIS LOAN IS REGULATED BY THE DEPARTMENT OF FINANCIAL
AND PROFESSIONAL REGULATION.<br><br>
YOU CANNOT BE PROSECUTED IN CRIMINAL COURT TO COLLECT THIS LOAN.
</b>
By signing this Loan Contract and Disclosure Statement (this “contract”) and accepting a loan from LS Financing, Inc (“Lender”) the undersigned
borrower (“I”, “you”, “borrower”) agrees to and accept the terms and conditions set forth on all pages of this contract.
<br>
</div>

<table border="1">
<tbody>
<tr>
<td> Signature of Borrower</td>
<td> Date</td>
<td colspan="2"> Lender: MoneyLine</td>
<td> Date</td>
</tr>
<tr>
<td><img src="../completed/doc_signs/'.$img_signed.'" height="300%" alt=""></td>
<td align="center">'.$creation_date.'</td>
<td align="center"> <b>Name</b> <br>'.$f_name.'<br></td>
<td align="center"> <b>Title</b><br> Loan Agent </td>
<td align="center">'.$creation_date.'</td>
</tr>
</tbody>
</table>
 
 
';
// $sign_image_url= "https://mymoneyline.com/lsbankingportal/signature_customer/completed/doc_signs/".$img_signed;

// $img = file_get_contents($sign_image_url);

$pdf->writeHTML($html,25,30); 

// $pdf->Image('@' . $img, 15, 265, '30', '', 'JPG', '', 'T', false, 40, '', false, false, 0, false, false, false);

 
$data_shipment  = ":";



$pdf->Ln();
$html = '<h1>LSBANKING </h1>';
$html_underline = '<b style="text-decoration:underline">PLEASE LEAVE THIS LABEL UNCOVERED.</b>';
// ---------------------------------------------------------

//Close and output PDF document

$file_name = $id."page_1";
$path=dirname(__FILE__)."/Barcodes/".$file_name.".pdf";
$pdf->Output($path,'F');

//============================================================+
// END OF FILE
//============================================================+

?>