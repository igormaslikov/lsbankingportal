<?php
$id=$_GET['id'];
?>


<?php
include 'dbconnect.php';
include 'dbconfig.php';
$iddd=$_GET['id'];
// echo "idddd". $iddd;

//echo "key is".$mail_key;

$sql1=$con->query("select * from loan_initial_banking where email_key='$iddd' "); 

while($row1 = $sql1->fetch_array()) {

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



$sql_loan=$con->query("select * from tbl_loan where loan_create_id= '$loan_id_bor' "); 

while($row_loan = $sql_loan->fetch_array()) {
    
    
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

$sql_loan_settings=$con->query("select * from tbl_loan_setting where loan_amount= '$amount_of_loan'"); 

while($row_loan_settings = $sql_loan_settings->fetch_array()) {

$loan_fee=$row_loan_settings['loan_fee'];
$loan_payable=$row_loan_settings['payoff_amount'];
}
 
   $calculation = (($loan_fee/$amount_of_loan)/($datediff/365) * 10000) / 100;
    $calculation = round($calculation, 2);
  	$anual_pr= $calculation;




$sql2=$con->query("select * from fnd_user_profile where user_fnd_id='$fnd_id' "); 

while($row2 = $sql2->fetch_array()) {

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

 $html = '<br><br><img src="images/Money-Line-Logo.JPG" style="height:400%" align="left"/><br><span style="text-align:left">11306 EAST 183RD ST SUITE 305A CERRITOS, CA 90703</span><br><br>


<table style="border-collapse:separate;border-spacing: 12px 0;" >
<tbody>
<tr>

<td>
<b style="font-size:8px;"><u>ADDITIONAL TERMS AND CONDITIONS</u></b>
<br><br>
<b style="font-size:8px;">A.HOW THE TOTAL OF PAYMENTS IS COMPUTED:</b><span style="font-size:8px;">The total of payments is the sum of the Amount Financed and the Finance Charge. The Finance Charge includes, but may not be limited to, interest computed daily on the outstanding balance of the Amount Financed plus an administrative fee and any other finance charges disclosed. The Finance Charge and Payment Schedule, shown in the Federal Truth-in-Lending Disclosure on the front side of this Agreement are estimates based on the assumption that each payment will be made on its due date. Since interest is calculated on a daily basis, late payments will result in additional interest and early payments will result in less interest.</span>
<br>
<b style="font-size:8px;">B.INTEREST:</b><span style="font-size:8px;">You will be charge interest on a daily basis on the outstanding balance subject to interest each day. The daily interest rate is equal to the yearly rate divided by the number of days in the calendar year.</span>
<br>

<b style="font-size:8px;">C.APPLICATION OF PAYMENTS:</b><span style="font-size:8px;">Payments will be applied following the order of priority; Interest, Late Charges, Returned Check Fees and then to principal. All payments will be applied to scheduled payments in the order in which they become due.</span>
<br>
<b style="font-size:8px;">D.FEES AND CHARGES:</b><span style="font-size:8px;">Fees and charges payable in connection with this loan are disclosed in the â€œItemization of Amount Financedâ€ and â€œOther Chargesâ€ section on the front side of this Agreement. The Administrative Fee, DMV Fee are non-refundable.</span>
<br>
<b style="font-size:8px;">E.BORROWERâ€™S PROMISES ABOUT LENDERâ€™S SECURITY INTEREST:</b><span style="font-size:8px;">I will not permit anyone other than you to obtain a security interest or other rights to the vehicle. I will pay all filling fees necessary for The Lender to obtain and maintain a security interest in the vehicle. I will assist the Lender in having a security interest noted on the Certificate of Title to the vehicle. I will not sell or give away the vehicle. If someone puts a lien on the vehicle, I will pay the obligation and clear the lien.</span>
<br>
<b style="font-size:8px;">F.BORROWERâ€™S PROMISES ABOUT THE VEHICLE:</b><span style="font-size:8px;">I will keep the vehicle in good condition and repair. I will pay all taxes and charges on the vehicle. I will pay all costs of maintaining the vehicle. I will not abuse the vehicle or permit anything to be done to the vehicle which will reduce its value. I will not use the vehicle for illegal purpose or for hire or lease. I will not move the vehicle from my address shown of this Agreement to a new permanent place of garaging without notifying you in advance. I will let you inspect the vehicle upon reasonable notice.</span>
<br>
<b style="font-size:8px;">G.BORROWERâ€™S PROMISES ABOUT INSURANCE:</b><span style="font-size:8px;">I will keep the vehicle insured against fire, theft and collision until all sums due you are paid in full. The insurance coverage must be satisfactory with a minimum deductible of $1000 and protect my interest and your interest at time of any insured loss. The insurance policy must name the Lender as â€œLoss-payeeâ€. The insurance must be written by an insurance company licensed to sell insurance in the state where the vehicle is permanently garaged. The insurance policy must provide the Lender with at least 10 days prior to written notice of any cancellation or reduction in coverage. On request, I must deliver the policy or other evidence of insurance coverage to the lender.</span>

</td>


<td>
<b style="font-size:8px;"><u>TÃ‰RMINOS Y CONDICIONES ADICIONALES</u></b>
<br><br>
<b style="font-size:8px;">A.CÃ“MO SE COMPUTA EL TOTAL DE PAGOS:</b><span style="font-size:8px;">El total de pagos es la suma del Monto financiado y el Cargo financiero. El Cargo Financiero incluye, entre otros, intereses calculados diariamente sobre el saldo pendiente del Monto Financiado mÃ¡s una tarifa administrativa y cualquier otro cargo financiero divulgado. El Programa de Cargos Financieros y Pagos, que se muestra en la DivulgaciÃ³n Federal de Verdad en PrÃ©stamo al frente de este Acuerdo, son estimaciones basadas en el supuesto de que cada pago se realizarÃ¡ en su fecha de vencimiento. Dado que el interÃ©s se calcula a diario, los pagos atrasados generarÃ¡n intereses adicionales y los pagos anticipados generarÃ¡n menos intereses.</span>
<br>
<b style="font-size:8px;">B.INTERÃ‰S:</b><span style="font-size:8px;">Se le cobrarÃ¡n intereses diariamente sobre el saldo pendiente sujeto a intereses cada dÃ­a. La tasa de interÃ©s diaria es igual a la tasa anual dividida por la cantidad de dÃ­as en el aÃ±o calendario.</span>
<br>

<b style="font-size:8px;">C.APLICACIÃ“N DE PAGOS:</b><span style="font-size:8px;">Los pagos se aplicarÃ¡n siguiendo el orden de prioridad; Intereses, recargos, cargos por cheques devueltos y luego al principal. Todos los pagos se aplicarÃ¡n a los pagos programados en el orden en que vencen.</span>
<br>
<b style="font-size:8px;">D.HONORARIOS Y CARGOS:</b><span style="font-size:8px;">Los honorarios y cargos pagaderos en relaciÃ³n con este prÃ©stamo se revelan en la secciÃ³n "Desglose del monto financiado" y "Otros cargos" en el anverso de este Acuerdo. La tarifa administrativa, la tarifa del DMV no son reembolsables.</span>
<br>
<b style="font-size:8px;">E.PROMESAS DEL PRESTATARIO SOBRE EL INTERÃ‰S DE SEGURIDAD DEL PRESTAMISTA:</b><span style="font-size:8px;">No permitirÃ© que nadie mÃ¡s que usted obtenga un interÃ©s de seguridad u otros derechos sobre el vehÃ­culo. PagarÃ© todas las tarifas de llenado necesarias para que The Lender obtenga y mantenga un interÃ©s de seguridad en el vehÃ­culo. AyudarÃ© al Prestamista a tener un interÃ©s de seguridad anotado en el Certificado de TÃ­tulo del vehÃ­culo. No venderÃ© ni regalarÃ© el vehÃ­culo. Si alguien pone un derecho de retenciÃ³n sobre el vehÃ­culo, pagarÃ© la obligaciÃ³n y borrarÃ© el derecho de retenciÃ³n.</span>
<br>
<b style="font-size:8px;">F.PROMESAS DEL PRESTATARIO SOBRE EL VEHÃCULO:</b><span style="font-size:8px;">MantendrÃ© el vehÃ­culo en buenas condiciones y lo repararÃ©. PagarÃ© todos los impuestos y cargos del vehÃ­culo. PagarÃ© todos los costos de mantenimiento del vehÃ­culo. No abusarÃ© del vehÃ­culo ni permitirÃ© que se haga nada al vehÃ­culo que reduzca su valor. No utilizarÃ© el vehÃ­culo para fines ilegales o para alquiler o arrendamiento. No trasladarÃ© el vehÃ­culo desde la direcciÃ³n que se muestra en este Acuerdo a un nuevo lugar de estacionamiento permanente sin notificarle por adelantado. Le dejarÃ© inspeccionar el vehÃ­culo con un aviso razonable.</span>
<br>
<b style="font-size:8px;">G.PROMESAS DEL PRESTADOR SOBRE EL SEGURO:</b><span style="font-size:8px;">MantendrÃ© el vehÃ­culo asegurado contra incendio, robo y colisiÃ³n hasta que se paguen todas las sumas adeudadas. La cobertura del seguro debe ser satisfactoria con un deducible mÃ­nimo de $ 1000 y proteger mi interÃ©s y su interÃ©s al momento de cualquier pÃ©rdida asegurada. La pÃ³liza de seguro debe nombrar al prestamista como "beneficiario de la pÃ©rdida". El seguro debe ser redactado por una compaÃ±Ã­a de seguros con licencia para vender seguros en el estado donde el vehÃ­culo estÃ¡ permanentemente estacionado. La pÃ³liza de seguro debe proporcionar al Prestamista al menos 10 dÃ­as antes de la notificaciÃ³n por escrito de cualquier cancelaciÃ³n o reducciÃ³n en la cobertura. A pedido, debo entregar la pÃ³liza u otra evidencia de cobertura de seguro al prestamista.</span>

</td>



</tr>

</tbody>
</table>
<br><br>

Initials/Iniciales__________________<br>

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

$file_name = $id."page_7";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>