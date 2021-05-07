<?php
$id=$_GET['id'];
?>


<?php
include 'dbconnect.php';
include 'dbconfig.php';
$iddd=$_GET['id'];
// echo "idddd". $iddd;

//echo "key is".$mail_key;

$sql1=mysqli_query($con, "select * from loan_initial_banking where email_key='$iddd' "); 

while($row1 = mysqli_fetch_array($sql1)) {

$mail_key=$row1['email_key'];
$signed_status=$row1['sign_status'];

$creation_datee=$row1['creation_date'];
$var = "$creation_datee";
$creation_date= date("m-d-Y", strtotime($var) );

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



$sql_loan=mysqli_query($con, "select * from tbl_loan where loan_id= '$loan_id_bor' "); 

while($row_loan = mysqli_fetch_array($sql_loan)) {
    
    
    $amount_of_loan=$row_loan['amount_of_loan'];
   
   $payment_datee=$row_loan['payment_date'];
     $var = "$payment_datee";
$payment_date= date("m-d-Y", strtotime($var) );
    
   
    
     
    $payoff=$row_loan['amount_of_loan'];
    
   
    
  if($payoff== '$50'){
        $payoff= '$8.83' ;
        
        }
        else if($payoff== '$100')
        {
             $payoff= '$17.65' ;
        }
        
        else if($payoff== '$150')
        {
             $payoff= '$26.47' ;
        }
        
        else if($payoff== '$200')
        {
             $payoff= '$35.30' ;
        }
        
        else if($payoff== '$255')
        {
             $payoff= '$45.00' ;
        }  
        
        
        
        
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
	$date1="$creation_date";
	$date2="$payment_date";
	function dateDiff($date1, $date2) 
	{
	  $date1_ts = strtotime($date1);
	  $date2_ts = strtotime($date2);
	  $diff = $date2_ts - $date1_ts;
	  return round($diff / 86400);
	}
	$dateDiff= dateDiff($date1, $date2);
// echo "Days".$dateDiff."<br>";


$payoff=str_replace('$', '', $payoff);

$amount_of_loan=str_replace('$', '', $amount_of_loan);
$total_amount= $payoff+$amount_of_loan;     
$apr=$payoff/$amount_of_loan;
$apr_total=$apr*365;
$anual_prr=($apr_total/$dateDiff)*100;
	//echo $anual_pr;
	$anual_pr= number_format((float)$anual_prr, 2, '.', '');

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

 $html = '<br><div style="line-height:7px"><h1>MoneyLine</h1>
<span style="font-size:8px">4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403</span><br><br>
</div>
 Borrower Name/Nombre del Deudor: <span style="text-decoration:underline">'.$f_name.'</span><br>
 Loan Number/Numero de Prestamo : <span style="text-decoration:underline">'.$loan_id_bor.'</span>
 <br>
 Date/Fecha: <span style="text-decoration:underline">'.$creation_date.'</span>
 
 
 <h2 style="text-align:center">SMS POLICY LOAN # <span style="text-decoration:underline">'.$loan_id_bor.'</span></h2>
 <br>
 <span style="text-size:8px;font-size:8px">By providing your cellular phone number, you have provided us with consent to send you text messages (SMS) in conjunction with the services you
have requested. Your cellular providers MSG & Data Rates may apply to our confirmation message and all subsequent messages.<br><br>
You understand the text messages we send may be seen by anyone with access to your phone. Accordingly, you should tahe steps to safeguard your
phone and your text messages if you want them to remain private (NO CONFIDENTIAL INFORMATION SHOULD BE SENT VIA SMS)
Please notify us immediately if you change mobile numbers.<br><br>
If we notufy this SMS Policy, we will notify you by sending you a SMS. We may terminate our SMS Policy at any time.<br><br>
If you have any questions about this SMS Policy, would like us to mail you a paper copy or are having problems receiving or stopping our text
messages, please contact us using the following information: MoneyLine 4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403
support@mymoneyline.com or (747) 300-1542.<br><br>
You agree and consent to the contracted by the Company, our agents, employees, attorneys, subsequent creditors, loan servicing companies and third
party collectors through the use of email, and/or telephone calls, and/or SMS to your cellular, home or work phone numbers, as well as any other phone
number you have provided in conjunction with this account, including the use of automatic telephoning dailing systems, auto-dailers, or an artificial or
prerecorded voice. <br>


<h2 style="text-align:center">OPT-OUT or STOP</h2>
This SMS Policy applies to the text messages sent by MoneyLine to our customers while and after they use our service. If you wish to stop receiving
SMS from MoneyLine reply to any text message we have sent you and, in your reply, simply type STOP. Your stop request will become effective
immediately. You may also stop SMS by calling us suing the following information: MoneyLine 4645 Van Nuys Boulevard Suite 202 Sherman
Oaks, CA 91403 support@mymoneyline.com or (747) 300-1542.
 <h2 style="text-align:center">HELP or SUPPORT</h2>
If at any time you need our contact information os information on how to stop SMS, reply to any text message we have sent you and in this reply
simply type HELP. Upon receiving your text message, we will send you a text message with this information. The message we sned provide you with
information about your account. Some of the SMS we send may include links to websites. To access these websites, you will need a web browser and
Internet access.
 <h2 style="text-align:center">AGREEMENT TO RECEIVE SMS</h2>
By signing this section, you authorize MoneyLine or Our Agents to send marketing to the mobile number you have provided and that is listed
below using and automatic dailing system, You are not required to authorize marketing SMS to obtain credit or other services from us. If you do not
wish to receive, sales or marketing SMS from us, you should not sign this section. You understand that at any messages we send you may be accessed
by anyone with access to your SMS. You also understand that your mobile phone service provider amy charge you fees for any SMS that we send you,
and you agree that we shall have no liability for any cost related to such SMS. At any time, you may withdraw your consent to receive marketing by
calling us at (747) 300-1542. 

<br>
<br><br>

<b>Borrowers Name:<br><br>
'.$f_name.'
<br><br>
Borrowers Mobile Telephone #:<br><br><br>
'.$mobile_number.'<br><br>
Borrowers Signature<br><br>
Date: '.$creation_date.'<br>
</b>
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

$file_name = $id."page_3";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>