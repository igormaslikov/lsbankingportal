<?php
$id=$_GET['id'];
$url_logo="https://pacificafinancegroup.com/loanportal/signature_commercial_loan/completed/";

include 'dbconnect.php';
include 'dbconfig.php';
$iddd=$_GET['id'];
 echo "idddd". $iddd;

//echo "key is".$mail_key;

$sql1=mysqli_query($con, "select * from commercial_loan_initial_banking where email_key='$iddd' "); 

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


$sql_loan=mysqli_query($con, "select * from tbl_commercial_loan where loan_create_id= '$loan_id_bor' "); 

while($row_loan = mysqli_fetch_array($sql_loan)) {
    
    
    $principal=$row_loan['amount_of_loan'];
    $principal=number_format($principal, 2);
    $payment_date=$row_loan['payment_date'];
    $interest_rate=$row_loan['loan_interest'];
    $interest_rate=number_format($interest_rate, 2);
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


 
  
//$calculation = $loan_fee/$amount_of_loan;
//$calculation_1 = $datediff/365;
//$calculation_1 = $calculation_1*10000;
//$calculation_1  = $calculation_1/100;

  //$calculation = round($calculation, 2);

	

	
	
	$created_by = $row_loan['created_by'];
    
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

$id=$_GET['id'];
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

$pdf->SetFont('helvetica', '', 11);

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

 $html = '
 <br>
<div style=";display:inline-block">
	<img src="images/Money-Line-Logo.JPG" style="height:400%;clear: both" align="left"/>
</div>
<br><span style="text-align:left;width:100%"><b>4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403</b></span>
 <br><br>
Borrower Name/Nombre del Deudor: <span style="text-decoration:underline">'.$f_name.'</span><br>
&nbsp;&nbsp;Loan Number/Numero de Prestamo: <span style="text-decoration:underline">'.$loan_id_bor.'</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date/Fecha: <span style="text-decoration:underline">'.$creation_date.'</span>
 <br>

<div style="text-align:center;font-size:12px;">
<b>
SMS POLICY LOAN #<span style="text-decoration:underline">'.$loan_id_bor.'</span>
</b>
</div>

<span style="text-align:justify;font-size:8px;">
    By providing your cellular phone number, you have provided us with consent to send you text messages (SMS) in conjunction with the services you have requested. Your cellular providers MSG & Data Rates may apply to our confirmation message and all subsequent messages
    <br>
    You understand the text messages we send may be seen by anyone with access to your phone. Accordingly, you should take steps to safeguard your phone and your text messages if you want them to remain private (NO CONFIDENTIAL INFORMATION SHOULD BE SENT VIA SMS) <br>
    Please notify us immediately if you change mobile numbers<br>
    If we notify this SMS Policy, we will notify you by sending you a SMS. We may terminate our SMS Policy at any time.<br>
    If you have any questions about this SMS Policy, would like us to mail you a paper copy or are having problems receiving or stopping our text messages, please contact us using the following information: Pacifica Finance Group 4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403 info@lsbanking.com or (747) 300-1542.<br>
    You agree and consent to the contracted by the Company, our agents, employees, attorneys, subsequent creditors, loan servicing companies and third party collectors through the use of email, and/or telephone calls, and/or SMS to your cellular, home or work phone numbers, as well as any other phone number you have provided in conjunction with this account, including the use of automatic telephoning dialing systems, auto-dialers, or an artificial or prerecorded voice.
</span>
<div style="text-align:center;font-size:10px;">
  <b style="text-align:center">OPT-OUT or STOP</b>
</div>
<br>
<span style="font-size:8px">This SMS Policy applies to the text messages sent by Pacifica Finance Group to our customers while and after they use our service. If you wish to stop receiving SMS from Pacifica Finance Group reply to any text message we have sent you and, in your reply, simply type STOP. Your stop request will become effective immediately. You may also stop SMS by calling, sending a letter or email us to the following information: Pacifica Finance Group 4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403 info@lsbanking.com or (747) 300-1542.</span>
<br>
<div style="text-align:center;font-size:10px;">
  <b style="text-align:center">HELP or SUPPORT</b><br>
</div>

<span style="font-size:8px">If at any time you need our contact information on how to stop SMS, reply to any text message we have sent you and in this reply simply type HELP. Upon receiving your text message, we will send you a text message with this information. The message we send provide you with information about your account. Some of the SMS we send may include links to websites. To access these websites, you will need a web browser and Internet access.</span><br>
<div style="text-align:center;font-size:16px;">
  <b style="text-align:center">AGREEMENT TO RECEIVE SMS</b>
</div>
<br>
<span style="font-size:8px; text-align:justify">By signing this section, you authorize Pacifica Finance Group or Our Agents to send marketing to the mobile number you have provided and that is listed below using and automatic dialing system, You are not required to authorize marketing SMS to obtain credit or other services from us. If you do not wish to receive, sales or marketing SMS from us, you should not sign this section. You understand that at any messages we send you may be accessed by anyone with access to your SMS. You also understand that your mobile phone service provider any charge you fees for any SMS that we send you, and you agree that we shall have no liability for any cost related to such SMS. At any time, you may withdraw your consent to receive marketing by calling us at (747) 300-1542.</span>

<br><br>
<table style="width:100%; font-size:10px; text-align:left">
<tbody>
<tr>
<td>
Borrower Name : <br><br>
<span style="text-decoration:underline">'.$f_name.'</span><br><br>

Borrower Mobile Telephone #: <br><br>
<span style="text-decoration:underline">'.$mobile_number.'</span><br><br>

Borrower Signature <br>
________________________<br>
 
</td>

<td> </td>

<td>

Co-Borrower Name : <br>
________________________<br><br>

Co-Borrower Mobile Telephone #: <br>
________________________<br><br>

Co-Borrower Signature <br>
_________________________<br>

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

// $pdf->Output('Case.pdf', 'I');

// $pdf_data = ob_get_contents();

// $file_name = $id."page_11";
// $path="Barcodes/".$file_name.".pdf";
// file_put_contents( $path, $pdf_data );
// $pdf->Output(dirname(__FILE__).'/Case.pdf', 'I');

// $pdf_data = ob_get_contents();
// $file_name = $id."page_11";
// $path = dirname(__FILE__) . "/Barcodes/" . $file_name . ".pdf";
// file_put_contents( $path, $pdf_data );

$file_name =$id. "page_11";
$path=dirname(__FILE__)."/Barcodes/".$file_name.".pdf";
$pdf->Output($path, 'F');

//============================================================+
// END OF FILE
//============================================================+

?>