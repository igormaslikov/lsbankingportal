<?php
$id=$_GET['id'];
?>


<?php

$url_logo="../signature_customer/completed";

include $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

$iddd=$_GET['id'];
 echo "idddd". $iddd;

//echo "key is".$mail_key;

$sql1=mysqli_query($con, "select * from personal_loan_initial_banking where email_key='$iddd' "); 

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



$sql_loan=mysqli_query($con, "select * from tbl_personal_loans where loan_create_id= '$loan_id_bor' "); 

while($row_loan = mysqli_fetch_array($sql_loan)) {
    
    
    $amount_of_loan=$row_loan['amount_of_loan'];
    $amount_of_loan=number_format($amount_of_loan, 2);
    $payment_date=$row_loan['payment_date'];
    $payment_date_db=$row_loan['payment_date'];
    $timestamp = strtotime($payment_date);
    $payment_date= date("m-d-Y", $timestamp);
    
    $creation_date=$row_loan['contract_date'];
    $creation_date_db=$row_loan['contract_date'];
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

$start = strtotime($creation_date_db);
$end = strtotime($payment_date_db);

$days_between = ceil(abs($end - $start) / 86400);

$created_by = $row_loan['created_by'];
$installment_plan = $row_loan['installment_plan'];
    
 }
 
  $sql_loan_settings=mysqli_query($con, "select * from tbl_loan_setting where loan_amount= '$amount_of_loan'"); 

while($row_loan_settings = mysqli_fetch_array($sql_loan_settings)) {

$loan_fee=$row_loan_settings['loan_fee'];
$loan_payable=$row_loan_settings['payoff_amount'];
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
   
  $result_install = mysqli_query($con, "select * from tbl_personal_loan_installments where loan_create_id='$loan_id_bor'");
    while($row_install = mysqli_fetch_array($result_install)){
		 
		  $intallment_id=$row_install['id'];
	      $payment= $row_install['payment'];
	      $interest= $row_install['interest'];
	      $principal= $row_install['principal'];
	      $balance= $row_install['balance'];
	      $payment_date= $row_install['payment_date'];
	      $paid_date= $row_install['paid_date'];
	      $status= $row_install['status'];
	 $total_payment += $payment;
	 $total_interest += $interest;
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

 $html = '<br><br><img src="images/Money-Line-Logo.JPG" style="height:400%" align="left"/><br><span style="text-align:left">4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403</span>
 <br><div style="line-height:7px"><h1 style="text-align:center"><u>Contrato de Prestamo</u></h1>
<span style="text-align:center;font-weight:bold;">Convenio de Préstamo y Condiciones Básicas</span><br><br>
</div>
<span>El Convenio de este Préstamo, comienza en la fecha especificada a continuación entre el Prestatario y cualquier Co-Prestatario
("usted", el “Prestatario”), que vive y puede ser contactado en la siguiente dirección y MoneyLine (“nosotros", "nos", el
"Prestamista"). Se incluye una traducción al español de este Convenio de Préstamo y Condiciones. Tomemos en consideración que
proporcionamos una traducción al español como cortesía porque valoramos a nuestros clientes y tratamos de proporcionar una
traducción precisa. Si la traducción en Español difiere a la versión en Inglés del Convenio de Préstamo y términos básicos, usted
entiende completamente que el Contrato de Préstamo Personal en Inglés es el Acuerdo de unión legal entre prestatario y
prestamista.</span><br><br>
Numero de Prestamo:  '.$loan_id_bor.'<br>
Nombre del Prestatario: '. $f_name.'<br>
Direccion del Prestatario: '.$address.'<br><br>

<span>Los términos "usted" y "su" se refieren a cada Prestatario y Co-Prestatario, si corresponde. Los términos "Prestamista",
"MoneyLine", "nosotros", "nos" y "nuestro” nos referimos al prestamista y a cualquier cesionario del prestamista.</span><br><br>

<table border="1" style="text-align:center">
<tbody>
<tr>
<td  colspan="4"><b style="text-align:center">DECLARACIONES INFORMATIVAS DE VERACIDAD EN LOS PRESTAMOS</b></td>
</tr>
<tr>
<td><b style="text-align:center">TASA DE PORCENTAJE ANUAL</b> <br>El costo del credito expresado
como tasa anual<br><br>'.$anual_pr.'%<br></td>
<td><b style="text-align:center">CARGOS DE FINANCIAMIENTO </b><br>El importe en dolares que le costara el credito.<br><br><br><br> $'.number_format($total_interest,   2, ".", ",").'<br></td>
<td><b style="text-align:center">MONTO FINANCIADO<br></b>Cantidad de credito provista a usted o en su nombre.<br><br><br><br><br>$'.$amount_of_loan.'<br></td>
<td><b style="text-align:center">TOTAL DE PAGOS</b><br>El monto que Habra pagado despues de haber efectuado todos los pagos programados.<br> <br><br> $'.number_format($total_payment,   2, ".", ",").'<br></td>
</tr>
<tr>
<th rowspan="4"><b style="text-align:center">Calendario de Pagos:</b></th>
<th><b style="text-align:center">Numero de Pagos</b></th>
<th><b style="text-align:center">Cantidad del Pago</b></th>
<th colspan="2"><b style="text-align:center">Cuando Vence el Pago</b></th>
</tr>
<tr>
<td>1</td>
<td>'.number_format($payment,   2, ".", ",").'</td>
<td style="text-align:left">Fre de Pago: '.$installment_plan.'<br>Empezando el</td>
</tr>
<tr>
<td>27</td>
<td>'.number_format($payment,   2, ".", ",").'</td>
<td style="text-align:left">Fre de Pago: '.$installment_plan.'</td>
</tr>
<tr>
<td style="text-align:left">Ultimo Pago de</td>
<td> </td>
<td style="text-align:left">Que vence en</td>
</tr>

<tr>
<td colspan="3">
<b style="text-align:left">Pagos Adelantados:</b><span style="font-size:9px">Usted puede liquidar su prestamo en cualquier momento. Si usted paga por adelantado,no tendra que pagar penalidad.</span>
<br>
<b style="text-align:left">Cargo por Incumplimiento:</b><span style="font-size:9px"> Si un pago se hace con mas de 10 dias de retraso, se le cobrara $10.</span>
<br>
<b style="text-align:left">Cargo de Originación:</b><span style="font-size:9px">Se agregará un cargo prepago de financiamiento por $ 75 para cubrir el costo de procesar su solicitud y el acuerdo.</span>
</td>
<td colspan="1">
<b>Licencia del Prestamista:</b> <br><br>
<span>60DBO-88277</span>

</td>
</tr>



</tbody>
</table>
<br><br>
 Este documento, que consta de este formulario (denominado "Términos básicos") y los suplementos adjuntos (llamados "Términos y
condiciones"), crea un acuerdo de préstamo ("Acuerdo") entre el Prestatario y el Prestamista. Al firmar, el Prestatario confirma que el
Prestatario entiende y acepta los términos de este Acuerdo.
<br>
 Consulte los Documentos del Contrato a continuación para obtener información adicional sobre la falta de pago, el incumplimiento, el
derecho a expresar el vencimiento del préstamo y el pago anticipado.<br><br>

Firma del Prestatario :  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fecha : 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b> <u>MoneyLine</u></b> <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nombre del Prestamista
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Firma Autorizada del Prestamista &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fecha
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
$file_name = $id."page_2";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>