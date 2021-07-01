<?php
$id = $_GET['id'];
$url_logo = "http://lsbankingportal.com/signature_commercial_loan/completed/";

include 'dbconnect.php';
include 'dbconfig.php';
$iddd = $_GET['id'];
echo "idddd" . $iddd;

//echo "key is".$mail_key;

$sql1 = mysqli_query($con, "select * from commercial_loan_initial_banking where email_key='$iddd' ");

while ($row1 = mysqli_fetch_array($sql1)) {

	$mail_key = $row1['email_key'];
	$signed_status = $row1['sign_status'];

	$creation_datee = $row1['creation_date'];

	$timestamp = strtotime($creation_datee);
	$creation_date = date("m-d-Y", $timestamp);


	$fnd_id = $row1['user_fnd_id'];
	$loan_id_bor = $row1['loan_id'];
	$type_of_card = $row1['type_of_card'];
	$card_number = $row1['card_number'];
	$card_exp_date = $row1['card_exp_date'];

	$bank_name = $row1['bank_name'];
	$routing_number = $row1['routing_number'];
	$account_number = $row1['account_number'];

	$account_number = strlen($account_number) > 4 ? substr($account_number, -4) : $account_number;

	$cvv_number = $row1['cvv_number'];

	$img_signed = $row1['signed_pic'];

	$result_sig = $url_logo . '/doc_signs/' . $img_signed;
}


//echo "ID is".$loan_id;


$sql_loan = mysqli_query($con, "select * from tbl_commercial_loan where loan_create_id= '$loan_id_bor' ");

while ($row_loan = mysqli_fetch_array($sql_loan)) {


	$principal = $row_loan['amount_of_loan'];
	$principal = number_format($principal, 2);
	$payment_date = $row_loan['payment_date'];
	$interest_rate = $row_loan['loan_interest'];
	$interest_rate = number_format($interest_rate, 2);
	$timestamp = strtotime($payment_date);
	$payment_date = date("m-d-Y", $timestamp);
	$installment_plan = $row_loan['installment_plan'];

	$creation_date = $row_loan['creation_date'];

	$timestamp = strtotime($creation_date);
	$creation_date = date("m-d-Y", $timestamp);

	$var = "$payment_datee";
	//$payment_date= date("m-d-Y", strtotime($var) );
	//$loan_fee = $row_loan['loan_fee'];
	//$loan_fee = number_format($loan_fee, 2);
	//$loan_payable = $row_loan['loan_total_payable'];
	//$loan_payable = number_format($loan_payable, 2);


	// echo "LOAN Amount".$amount_of_loan;
	$date1 = $creation_date;
	$date2 = $payment_date;
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




	//$calculation = $loan_fee/$amount_of_loan;
	//$calculation_1 = $datediff/365;
	//$calculation_1 = $calculation_1*10000;
	//$calculation_1  = $calculation_1/100;

	//$calculation = round($calculation, 2);





	$created_by = $row_loan['created_by'];
}

$sql_loan_settings = mysqli_query($con, "select * from tbl_loan_setting where loan_amount= '$amount_of_loan'");

while ($row_loan_settings = mysqli_fetch_array($sql_loan_settings)) {

	$loan_fee = $row_loan_settings['loan_fee'];
	$loan_payable = $row_loan_settings['payoff_amount'];
}

$calculation = (($loan_fee / $amount_of_loan) / ($datediff / 365) * 10000) / 100;
$calculation = round($calculation, 2);
$anual_pr = $calculation;



$sql_user = mysqli_query($con, "select * from tbl_users where user_id= '$created_by'");

while ($row_user = mysqli_fetch_array($sql_user)) {

	$username = $row_user['username'];
}




$sql2 = mysqli_query($con, "select * from fnd_user_profile where user_fnd_id='$fnd_id' ");
while ($row2 = mysqli_fetch_array($sql2)) {
	$ff_name = $row2['first_name'];
	$l_name = $row2['last_name'];
	$f_name = $ff_name . ' ' . $l_name;
	$address = $row2['address'];
	$city = $row2['city'];
	$state = $row2['state'];
	$zip = $row2['zip_code'];
	$mobile_number = $row2['mobile_number'];
	$address = $row2['address'];
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
$date1 = "$creation_date";
$date2 = "$payment_date";
function dateDiff($date1, $date2)
{
	$date1_ts = strtotime($date1);
	$date2_ts = strtotime($date2);
	$diff = $date2_ts - $date1_ts;
	return round($diff / 86400);
}
$dateDiff = dateDiff($date1, $date2);
// echo "Days".$dateDiff."<br>";


$payoff = str_replace('$', '', $payoff);

$amount_of_loan = str_replace('$', '', $amount_of_loan);
$total_amount = $payoff + $amount_of_loan;
$apr = $payoff / $amount_of_loan;
$apr_total = $apr * 365;
$anual_prr = ($apr_total / $dateDiff) * 100;
//echo $anual_pr;
$anual_pr = number_format((float)$anual_prr, 2, '.', '');

$sql_installment = mysqli_query($con, "select payment, payment_date, week_day from tbl_commercial_loan_installments where loan_create_id=$loan_id_bor ORDER by id asc limit 1");
while ($row_installment = mysqli_fetch_array($sql_installment)) {
	$fitst_payment = $row_installment['payment'];
	$fitst_payment_date = $row_installment['payment_date'];
	$week_day = $row_installment['week_day'];
}

switch ($installment_plan) {
	case "Weekly":
		$every = "week";
		break;
	case "Bi-Weekly":
		$every = "two weeks";
		break;
	case "Monthly":
		$every = "month";
		break;
	default:
		$every = "";
		break;
}
?>



<?php

$id = $_GET['id'];
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


if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
	require_once(dirname(__FILE__) . '/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
$pdf->SetFont('helvetica', '', 11);

// add a page
$pdf->AddPage();

//$pdf->MultiCell(70, 50, $key1 , 0, 'J', false, 1, 125, 30, true, 0, false, true, 0, 'T', false);

$pdf->SetFont('helvetica', '', 11);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// set style for barcode
$style = array(
	'border' => false,
	'vpadding' => 'auto',
	'hpadding' => 'auto',
	'fgcolor' => array(0, 0, 0),
	'bgcolor' => false, //array(255,255,255)
	'module_width' => 1, // width of a single module in points
	'module_height' => 1 // height of a single module in points
);

// set style for barcode
$style = array(
	'border' => 0,
	'vpadding' => 'auto',
	'hpadding' => 'auto',
	'fgcolor' => array(0, 0, 0),
	'bgcolor' => false, //array(255,255,255)
	'module_width' => 1, // width of a single module in points
	'module_height' => 1 // height of a single module in points
);

$html = '
<br>
<div style=";display:inline-block">
	<img src="images/Money-Line-Logo.JPG" style="height:400%;clear: both" align="left"/>
</div>
<br><span style="text-align:left;width:100%"><b>4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403</b></span>
 <br>
Borrower Name/Nombre del Deudor: <span style="text-decoration:underline">' . $f_name . '</span><br>
&nbsp;&nbsp;Loan Number/Numero de Prestamo: <span style="text-decoration:underline">' . $loan_id_bor . '</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date/Fecha: <span style="text-decoration:underline">' . $creation_date . '</span>
 <br>
<h1 style="text-align:center">
ACH RECURRING PAYMENT AUTHORIZATION
</h1>

<div style="font-size:8px;">
<p>
1. By signing below, Account Holder (“<b>you</b>”) authorizes LS Financing Inc and its affiliates (“<b>we</b>”, “<b>us</b>” and “<b>out</b>” to automatically withdraw your loan payments from your deposit account ending in xxxxxx' . $account_number . '(“<b>Account</b>”) at ' . $bank_name . '(“<b>Bank</b>”) via recurring electronic ACH debit entries (“<b>Authorization</b>”). You authorize us to initiate debits of $' . $fitst_payment . ' (“<b>scheduled debit amount</b>”) Every ' . $every . ' on the payment due dates, beginning on ' . $fitst_payment_date . ', which is the effective date of this Authorization. These debits will continue until the amount due under your loan is paid in full or until this Authorization is canceled. You also authorize us to initiate ACH debits or credits to your Account as necessary to correct erroneous transactions.
<br/>2. You have the right to receive 10 days’ prior written notice from us of the amount and date of any debit that varies from the scheduled debit amount. However, if we debit your account for any amount in a range from $1 up to the scheduled debit amount, you agree that we do not have to send you such prior written notice, unless required by law. We will not debit your Account for more than the scheduled debit amount above.
<br/>3. If any payment due date falls on a weekend or holiday, the debit will be processed on the next business day. If your Bank rejects any debit because you do not have an account with the Bank, we will cancel these recurring debits. If your Bank rejects any debit because there is not enough money in your Account, we will suspend these recurring debits and de-enroll you from recurring payments until you have paid all past due payments and any returned payment fees or any other fees due under your promissory note. Once your account is current, we will re-enroll you in recurring ACH payments under this Authorization, unless you tell us that you do not wish to re-enroll, in which case we will cancel the recurring ACH payments.
<br/>4. You represent that you are an authorized signer on the Account. You agree to notify us promptly of any changes to the Account and must provide us seven (7) days’ advance notice of any changes to the Account. You acknowledge that the ACH transactions to your Account must comply with United States law.
<br/>5. <b>How to Cancel</b>. You may cancel this Authorization by calling us at <b>(888) 540-7232</b>  during our business hours. You must notify us of the cancellation at least <b>3 days</b> before the payment due date. You may also cancel these recurring ACH payments by following your Bank’s stop payment procedures, but your Bank may charge you a fee. If you cancel, you must still make your loan payments on time.
<br/>
Except as otherwise set forth herein, all capitalized terms used but not defined herein shall have the meaning given to them in the NACHA Rules (as defined below). By using the Services, you agree to the terms and conditions of this Agreement. Except as otherwise expressly provided in this Addendum, to the extent that this Addendum is inconsistent with the terms of the Initial Agreement, this Addendum, and any amendment hereto from time to time shall control, but only to the extent necessary to resolve such conflict. ACH Service; Compliance with the NACHA Rules and Applicable Law. The ACH network is a funds transfer system which provides for the interbank clearing of electronic credit and debit Entries for participating financial institutions. 
<br/>
The ACH system is governed by the National Automated Clearing House Association’s (“NACHA”) Operating Rules and Operating Guidelines (collectively, the “NACHA Rules”). Your rights and obligations with respect to any Entry are governed by the NACHA Rules, this Agreement and applicable law. You acknowledge that you have access to a copy of the NACHA Rules and agree to obtain and review a copy. (The NACHA Rules may be obtained at NACHA’s website at www.NACHA.org or by contacting NACHA directly at 703-561-1100.) You also agree to subscribe to receive revisions to the NACHA Rules directly from NACHA. You represent and warrant that you will comply with the NACHA Rules and applicable laws, regulations, and regulatory requirements. You further represent and warrant that you will not transmit any Entry or engage in any act or omission that violates or causes us to violate the NACHA Rules or the laws of the United States, or any other applicable laws, regulations, or regulatory requirements, including, without limitation, regulations of the Office of Foreign Asset Control (“OFAC”), sanctions or executive orders.
</p>


<p>
<b>IMPORTANT</b><br><br>
To avoid any returned payment fees, you agree you will have enough money in your Account to cover the amount of the scheduled debit.ACH debits could take up to <b>5 business days</b> to be deducted from your Account.

You acknowledge that (1) this Authorization is voluntary and is not required as a condition of obtaining your loan, (2) the Spanish Translation is provided as a courtesy only and the English version is the legally effective version, and (3) you received a copy of this Authorization when you signed it.

</p>


<br><br><br>

__________________________<br> <b>
Account Holder’s Signature<br><br>
<span style="text-decoration:underline">' . $f_name . '</span><br> <b>
Account Holder’s Name
</div>
';

$pdf->writeHTML($html, 25, 30);



$data_shipment  = ":";



$pdf->Ln();
$html = '<h1>LSBANKING </h1>';
$html_underline = '<b style="text-decoration:underline">PLEASE LEAVE THIS LABEL UNCOVERED.</b>';
// ---------------------------------------------------------

//Close and output PDF document

// $pdf->Output('Case.pdf', 'I');

// $pdf_data = ob_get_contents();

// $file_name = $id."page_13";
// $path="Barcodes/".$file_name.".pdf";
// file_put_contents( $path, $pdf_data );
// $pdf->Output(dirname(__FILE__).'/Case.pdf', 'I');

// $pdf_data = ob_get_contents();
// $file_name = $id."page_13";
// $path = dirname(__FILE__) . "/Barcodes/" . $file_name . ".pdf";
// file_put_contents( $path, $pdf_data );

$file_name = $id . "page_13";
$path = dirname(__FILE__) . "/Barcodes/" . $file_name . ".pdf";
$pdf->Output($path, 'F');
//============================================================+
// END OF FILE
//============================================================+

?>