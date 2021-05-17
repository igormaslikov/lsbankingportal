<?php
$id=$_GET['id'];
?>


<?php
include $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

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

 $html = '<br><br><img src="images/Money-Line-Logo.JPG" style="height:400%" align="left"/><br><span style="text-align:left">4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403</span><br><br>

<h1 style="text-align:center">
Loan Agreement/Contrato del Prestamo
</h1>

<table style="border-collapse:separate;border-spacing: 12px 0;" >
<tbody>
<tr>
<td>
<span style="font-size:8px;">For value received, you promise to pay to our order at our office address shown above the total loan amount (“Principal”) shown above and finance charges on the unpaid principal at the simple interest rate of 3.146% per month (      % Per year), in equal monthly installments of Principal and interest shown in the payment schedule above, until you have paid us all that you owe us. If more than one party signs this Agreement, each party will be individually and jointly liable to the Lender for repayment</span>
<br>

<b style="font-size:8px;">•Simple Interest Loan & Your Payments:</b><span style="font-size:8px;">This is a simple interest loan. Finance Charges will accrue on the unpaid Principal balance on a daily basis.  Payments we receive will be applied first to accrued and unpaid finance charges, then to other amounts you may owe us. If you pay late, more finance charges will accrue. If you pay early, less finance charges will accrue. If you make more than one payment before it is due, you still owe the payments due as scheduled (Advance payments are applied to the Principal balance)The Finance Charges, Total of Payments, and Payment Schedule disclosed in The Federal Truth in Lending disclosure may differ from the actual amount you pay if your payments are not received by us on their exact due date, or we advance amounts under this Agreement to fulfill your obligations, which we may add to the unpaid Principal balance. Your final payment may be different than the amount disclosed under the Payment Schedule if you make your payment after the date they are due, or if we have added amounts we advanced to the Principal balance. We earn the Administrative fees in full on the date this loan is made.</span>
<br>
<b style="font-size:8px;">•Late Fee:</b><span style="font-size:8px;">You agreed to pay a late fee (Late Charge) for late payments as disclosed above.<br>Returned Payment Item Fee: If any checks, negotiable order of withdraw or share draft you give us is returned by a depositary institution, you agree to pay a returned fee of $25.00 for each such item returned.</span>
<br>

<b style="font-size:8px;">•Security Interest:</b><span style="font-size:8px;">You grant us a security interest in (1) the vehicle and all parts or accessories (including the stereo, CD player, Navigation System, wheels and tires or any item attached to the vehicle, (2) all money and goods received for the vehicle (proceeds), and (3) all proceeds or refunded insurance premiums or charges for optional products or services financed in the loan, which secure all sums due or to become due under this loan as well as any modifications, extensions, renewals, amendments or refinancing of this loan.</span>
<br>  
<b style="font-size:8px;">•Use of Vehicle:</b><span style="font-size:8px;">you agree to keep of all liens and encumbrances, including taxes liens, except the lien in our favor, and to not use the vehicle or permit the vehicle to be used illegally, improperly or for hire, or to expose the vehicle to misuse, seizure, confiscation, forfeiture or other involuntary transfer, even if the vehicle is not the subject of judicial or administrative proceedings. You agree not to make or allow any material change to be made to the vehicle. You agree to allow us to inspect the vehicle at any reasonable time. You agree not to remove the vehicle, or allow the vehicle to be removed, from California for a period in excess of 30 days without our express permission. You agree not to remove the vehicle from the U.S. or Canada. You agree not to sell, rent, lease or transfer any interest in the vehicle.</span>
<br>

</td>

<td>
<span style="font-size:7px;">Por el valor recibido, usted promete pagar nuestro pedido en la dirección de nuestra oficina que se muestra arriba del monto total del préstamo (“Principal”) que se muestra arriba y los cargos financieros sobre el principal no pagado a la tasa de interés simple de 3.146% por mes (% por año) , en cuotas mensuales iguales de capital e intereses que se muestran en el programa de pagos anterior, hasta que nos haya pagado todo lo que nos debe. Si más de una parte firma este Acuerdo, cada parte será responsable individual y conjuntamente con el Prestamista por el reembolso.</span>
<br>

<b style="font-size:8px;">•Préstamo de interés simple y sus pagos:</b><span style="font-size:7px;">Este es un préstamo de interés simple. Los cargos financieros se acumularán en el saldo de capital impago diariamente. Los pagos que recibimos se aplicarán primero a los cargos financieros acumulados y no pagados, luego a otros montos que nos deba. Si paga tarde, se acumularán más cargos financieros. Si paga temprano, se acumularán menos cargos financieros. Si realiza más de un pago antes de la fecha de vencimiento, aún debe los pagos adeudados según lo programado (los pagos anticipados se aplican al saldo del capital). diferir del monto real que paga si no recibimos sus pagos en su fecha de vencimiento exacta, o si adelantamos los montos conforme a este Acuerdo para cumplir con sus obligaciones, que podemos agregar al saldo del principal impago. Su pago final puede ser diferente al monto revelado en el Programa de pagos si realiza su pago después de la fecha de vencimiento, o si hemos agregado montos que adelantamos al saldo del capital. Ganamos los honorarios administrativos en su totalidad en la fecha en que se otorga este préstamo.</span>
<br>
<b style="font-size:8px;">•Cargo por pago atrasado:</b><span style="font-size:7px;">Usted acordó pagar un cargo por pago atrasado (cargo por pago atrasado) por pagos atrasados como se describe anteriormente.</span>
<br>

<b style="font-size:8px;">•Tarifa de artículo de pago devuelto:</b><span style="font-size:7px;">Si alguna institución depositaria devuelve cualquier cheque, orden de retiro negociable o borrador de parte que nos da, usted acepta pagar una tarifa devuelta de $ 25.00 por cada artículo devuelto.<br>Interés de seguridad: nos otorga un interés de seguridad en (1) el vehículo y todas las piezas o accesorios (incluido el estéreo, el reproductor de CD, el sistema de navegación, las ruedas y los neumáticos o cualquier artículo adjunto al vehículo, (2) todo el dinero y los bienes recibidos para el vehículo (ingresos) y (3) todos los ingresos o primas de seguro reembolsadas o cargos por productos o servicios opcionales financiados en el préstamo, que aseguran todas las sumas adeudadas o vencidas en virtud de este préstamo, así como cualquier modificación, extensión, renovación , modificaciones o refinanciación de este préstamo.</span>
<br>  
<b style="font-size:8px;">•Uso del vehículo:</b><span style="font-size:8px;">Usted acepta mantener todos los gravámenes y gravámenes, incluidos los gravámenes fiscales, excepto el gravamen a nuestro favor, y no usar el vehículo o permitir que el vehículo se use ilegalmente, de manera indebida o contratada, o exponer el vehículo para mal uso, incautación, confiscación, decomiso u otra transferencia involuntaria, incluso si el vehículo no es objeto de procedimientos judiciales o administrativos. Usted acepta no realizar ni permitir que se realicen cambios materiales en el vehículo. Usted acepta permitirnos inspeccionar el vehículo en cualquier momento razonable. Usted acepta no retirar el vehículo, o permitir que el vehículo sea retirado, de California por un período de más de 30 días sin nuestro permiso expreso. Usted acepta no retirar el vehículo de EE. UU. O Canadá. Usted acepta no vender, alquilar, arrendar ni transferir ningún interés en el vehículo.</span>
<br>

</td>




</tr>

</tbody>
</table>
<br>

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

$file_name = $id."page_3";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>