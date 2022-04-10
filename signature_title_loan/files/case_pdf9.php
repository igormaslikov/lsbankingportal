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



$fnd_id=$row1['user_fnd_id'];
$loan_id_bor=$row1['loan_id'];
$type_of_card=$row1['type_of_card'];
$card_number=$row1['card_number'];
$card_exp_date=$row1['card_exp_date'];

$creation_datee=$row1['creation_date'];
     $timestamp = strtotime($creation_datee);
     $creation_date= date("m-d-Y", $timestamp);
     
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

	
    
 }

$sql_loan_settings=mysqli_query($con, "select * from tbl_loan_setting where loan_amount= '$amount_of_loan'"); 

while($row_loan_settings = mysqli_fetch_array($sql_loan_settings)) {

$loan_fee=$row_loan_settings['loan_fee'];
$loan_payable=$row_loan_settings['payoff_amount'];
}
 
   $calculation = (($loan_fee/$amount_of_loan)/($datediff/365) * 10000) / 100;
    $calculation = round($calculation, 2);
  	$anual_pr= $calculation;




$sql2=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id='$fnd_id' "); 

while($row2 = mysqli_fetch_array($sql2)) {

$ff_name=$row2['first_name'];
$l_name=$row2['last_name'];
$f_name= $ff_name.' '.$l_name;
$address1=$row2['address'];
$city=$row2['city'];
$state=$row2['state'];
$zip=$row2['zip_code'];
$mobile_number=$row2['mobile_number'];
$address= $address1.' '.$city.' '.$state.' '.$zip;




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

 $html = '<br><br><img src="images/pacifica.jpeg" style="height:400%" align="left"/><br><span style="text-align:left">5900 S Eastern Ave Suite 114 Commerce, CA 90040</span><br><br>


<table style="border-collapse:separate;border-spacing: 12px 0;" >
<tbody>
<tr>

<td>
<b style="font-size:8px;">L.COMMUNICATIONS CONCERNING DISPUTED DEBTS:</b><span style="font-size:8px;">All communications concerning disputed debts, including any payments made by check and marked “Payment in full” or with other restrictive endorsements or notice, tendered as full satisfaction of my balance must be sent to: <u>4645 Van Nuys Blvd suite 202 Sherman Oaks, CA 91403</u>. 

</span>
<br>
<b style="font-size:8px;">M.COLLECTION COSTS:</b><span style="font-size:8px;">I may have to pay the Lender reasonable collection cost, including but not limited to Attorney’s fees, court fees, collections agency fees and fees for other reasonable collection efforts, to the extent permitted by law.
</span>
<b style="font-size:8px;">N.NOTICE AND CHANGE OF ADDRESS: </b><span style="font-size:8px;">Any notice you send me concerning this Agreement of the vehicle will be sent to my current mailing address shown in your records. I will notify you if my mailing address changes within a reasonable time. 
</span><br>
<b style="font-size:8px;">O. CONTINUED EFFECTIVENESS: </b><span style="font-size:8px;"> If any part of this Agreement is determined by a court to be invalid, the rest will remain in effect. 
</span><br>

<b style="font-size:8px;">P. ASSIGMENT: </b><span style="font-size:8px;">I may not assign or transfer my rights under this Agreement to anyone else, the Lender may sell, transfer or assign this Agreement and any security Agreement given to secure this Agreement and my rights and obligations under this Agreement will continue unchanged. 
</span><br>
<b style="font-size:8px;">Q. HEIRS AND PERSONAL REPRESENTATIVES BOUND: </b><span style="font-size:8px;">The provisions of this Agreement will be binding upon borrower, Co-Signer and Co-Owner, individually and together and the heirs and personal representatives of each. 
</span><br>

<b style="font-size:8px;">R. GOVERNING LAW PROVISION: </b><span style="font-size:8px;">This loan is made pursuant to the California Finance Lender Law, Division 9 of the Financial Code, Ca. Fin. Code22000 et seq. This Agreement and its validity, construction and enforceability will be governed by the laws of California, except to the extent that such law have been preempted or superseded by federal law. 
</span><br>
<b style="font-size:8px;">S. NOTICE: </b><span style="font-size:8px;">If a substantial portion of the proceeds of this loan is used for the purchase of consumer goods, any holder of this consumer credit contract is subject to all claims and defenses which the debtor could assert against seller of goods or services obtained with the proceeds hereof. Recovery hereunder by the debtor shall not exceed amounts paid by debtor hereunder. 
</span><br>
<b style="font-size:8px;">T. TELEPHONE AND TEXT MESSAGE CONSENT: </b><span style="font-size:8px;"> You consent to	 allowing us to contact you at the telephone numbers and/or email addresses provided carrier will charge you for our incoming calls and text messages according to your plan. In the event you change any of the telephone numbers or addresses supplied herein, you will notify us and provide us with the new telephone number and or address. 
</span><br>
<b style="font-size:8px;">U. ENTIRE AGREEMENT: </b><span style="font-size:8px;">The terms and conditions set forth in this.Agreement constitute the entire Agreement between me and lender.

</span>

<br><br><br><br><br>

<span style="font-size:8px;">Borrower’s Signature / Firma del Prestatario:</span>
<br><br>
X____________________________________      
<br><br>
<span style="font-size:8px;">Co-Borrower’s Signature / Firma del Co-Prestatario:</span>
<br><br>
X_____________________________________





</td>





<td>
<b style="font-size:8px;">L. COMUNICACIONES RELATIVAS A DEUDAS DISPUTADAS:</b><span style="font-size:8px;">Todas las comunicaciones relacionadas con deudas en disputa, incluidos los pagos realizados con cheque y marcados como "Pago total" o con otros endosos o avisos restrictivos, presentados como satisfacción total de mi saldo deben enviarse a: <u>4645 Van Nuys Blvd suite 202 Sherman Oaks, CA 91403.</u>. 

</span>
<br>
<b style="font-size:8px;">M. COSTOS DE RECAUDACIÓN:</b><span style="font-size:8px;">es posible que deba pagar al Prestamista un costo de cobranza razonable, que incluye, entre otros, los honorarios del abogado, los honorarios del tribunal, los honorarios de la agencia de cobranza y los honorarios por otros esfuerzos de cobranza razonables, en la medida permitida por la ley.
</span>
<b style="font-size:8px;">N. AVISO Y CAMBIO DE DIRECCIÓN: </b><span style="font-size:8px;">Cualquier notificación que me envíe con respecto a este Acuerdo del vehículo se enviará a mi dirección de correo actual que se muestra en sus registros. Le notificaré si mi dirección de correo cambia dentro de un tiempo razonable. 
</span><br>
<b style="font-size:8px;">O. EFICACIA CONTINUA: </b><span style="font-size:8px;"> Si un tribunal determina que una parte de este Acuerdo no es válida, el resto permanecerá vigente. 
</span><br>

<b style="font-size:8px;">P. ASIGNACIÓN: </b><span style="font-size:8px;">No puedo asignar ni transferir mis derechos bajo este Acuerdo a nadie más, el Prestamista puede vender, transferir o asignar este Acuerdo y cualquier Acuerdo de seguridad otorgado para asegurar este Acuerdo y mis derechos y obligaciones bajo este Acuerdo continuarán sin cambios. 
</span><br>
<b style="font-size:8px;">Q. LÍDERES Y REPRESENTANTES PERSONALES VINCULADOS: </b><span style="font-size:8px;">Las disposiciones de este Acuerdo serán vinculantes para el prestatario, el Co-firmante y el Co-Propietario, individualmente y en conjunto, y los herederos y representantes personales de cada uno. 
</span><br>

<b style="font-size:8px;">R. GOVERNING LAW PROVISION: </b><span style="font-size:8px;">Este préstamo se otorga de conformidad con la Ley de Prestamista de Finanzas de California, División 9 del Código Financiero, Ca. Aleta. Código 22000 y ss. Este Acuerdo y su validez, construcción y exigibilidad se regirán por las leyes de California, excepto en la medida en que dicha ley haya sido reemplazada o reemplazada por la ley federal. 
</span><br>
<b style="font-size:8px;">S. AVISO: </b><span style="font-size:8px;">Si una parte sustancial de los ingresos de este préstamo se utiliza para la compra de bienes de consumo, cualquier titular de este contrato de crédito al consumidor está sujeto a todos los reclamos y defensas que el deudor podría hacer valer contra el vendedor de bienes o servicios obtenidos con los ingresos. de esto. La recuperación en virtud del presente por el deudor no excederá los montos pagados por el deudor en virtud del presente. 
</span><br>
<b style="font-size:8px;">T. CONSENTIMIENTO DE MENSAJES DE TELÉFONO Y TEXTO: </b><span style="font-size:8px;">Usted acepta que nos comuniquemos con usted a los números de teléfono y / o direcciones de correo electrónico que el proveedor le cobrará por nuestras llamadas entrantes y mensajes de texto de acuerdo con su plan. En caso de que cambie alguno de los números de teléfono o direcciones provistos en este documento, nos notificará y nos proporcionará el nuevo número de teléfono o dirección. 
</span><br>
<b style="font-size:8px;">U. ACUERDO COMPLETO: </b><span style="font-size:8px;">Los términos y condiciones establecidos en este Acuerdo constituyen el Acuerdo completo entre el prestamista y yo.

</span>
<br><br><br>
<span style="font-size:8px;">Date/Fecha:</span>
<br><br>
      
<br><br>
<span style="font-size:8px;">Date/Fecha:</span>



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

$file_name = $id."page_10";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>