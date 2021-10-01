<?php
$id = $_GET['id'];
$url_logo = "https://mymoneyline.com/lsbankingportal/signature_commercial_loan/completed/";

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
		$every = "semana";
		break;
	case "Bi-Weekly":
		$every = "dos semanas";
		break;
	case "Monthly":
		$every = "mes ";
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
 <br><br>
Borrower Name/Nombre del Deudor: <span style="text-decoration:underline">' . $f_name . '</span><br>
&nbsp;&nbsp;Loan Number/Numero de Prestamo: <span style="text-decoration:underline">' . $loan_id_bor . '</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date/Fecha: <span style="text-decoration:underline">' . $creation_date . '</span>
 <br>
<h1 style="text-align:center">
AUTHORIZACION DE PAGOS RECURRENTES POR ACH
</h1>

<div style="font-size:8px;">
<p>
1. Al firmar a continuación, el titular de la Cuenta  (“<b>usted</b>”) autoriza a LS Financing Inc y a sus afiliados  (“<b>nosotros</b>”y “<b>nuestro</b>”) a retirar automáticamente los pagos de su préstamo de su cuenta de depósito terminada en xxxxxx' . $account_number . '(“<b>Cuenta</b>”) del banco ' . $bank_name . '(“<b>Banco</b>”), a través de débitos electrónicos recurrentes por ACH (“<b>Autorización</b>”). Usted nos autoriza a comenzar a hacer débitos de $' . $fitst_payment . ' (“<b>monto a debitar programado</b>”) Cada  ' . $every. '  en las fechas de vencimiento del pago, a partir del  ' . $fitst_payment_date . ', que es la fecha de entrada en vigor de esta Autorizacíon. Estos débitos continuarán hasta que el monto adeudado de su préstamo se pague en su totalidad o hasta que se cancele esta Autorización. Usted también nos autoriza a iniciar débitos o créditos por ACH a su Cuenta, según sea necesario, para corregir transacciones equivocadas.
<br/>2. Usted tiene el derecho de recibir una notificación por escrito de parte de nosotros, con 10 días de anticipación, sobre el monto y fecha de cualquier débito que difiera del monto a debitar programado. Sin embargo, si debitamos de su Cuenta cualquier monto entre $1 hasta el monto a debitar programado, usted acepta que no tenemos que enviarle dicha notificación previa por escrito, excepto que la ley así lo exija. No debitaremos de su cuenta un monto superior al monto a debitar programado indicado anteriormente.
<br/>3. Si cualquier fecha de pago cae en fin de semana o día festivo, el débito será procesado el siguiente día hábil. Si su Banco rechaza cualquier débito porque usted no tiene una cuenta con ese Banco, cancelaremos estos débitos recurrentes. Si su Banco rechaza cualquier débito porque no hay suficiente dinero en su Cuenta, suspenderemos estos débitos recurrentes y daremos de baja su suscripción a los pagos recurrentes hasta que usted haya efectuado todos los pagos atrasados y haya pagado cualquier cargo por pago rechazado u otros cargos debidos según el pagaré. Cuando su Cuenta vuelva a estar al día, volveremos a inscribirlo a los pagos recurrentes por ACH acorde a esta Autorización, excepto que nos indique que no desea volver a inscribirse; en ese caso, cancelaremos los pagos recurrentes por ACH.
<br/>4. Usted declara que es un firmante autorizado de la Cuenta. Usted acuerda notificarnos de inmediato cualquier cambio en la Cuenta y debe proporcionarnos un aviso con siete (7) días de anticipación sobre cualquier cambio en la Cuenta. Reconoce que las transacciones por ACH de su Cuenta deben cumplir con las leyes de los Estados Unidos.
<br/>5. <b>Cómo cancelar</b>. Usted puede cancelar esta Autorización llamándonos a (888) 540-7232 durante nuestro horario comercial. Debe notificarnos sobre la cancelación por lo menos <b>3 días</b> antes de la fecha de vencimiento del pago. También puede cancelar estos pagos recurrentes por ACH siguiendo los procedimientos de su Banco para detener pagos, pero su Banco puede cobrarle un cargo. Aun si usted los cancela, debe seguir realizando los pagos del préstamo a tiempo.
</p>


<p>
<b>IMPORTANT</b><br><br>
Para evitar cualquier cargo por pago rechazado, usted acuerda contar con suficiente dinero en su Cuenta para cubrir el monto del débito programado. Los débitos por ACH pueden demorar hasta 5 días hábiles en debitarse de su Cuenta.
<br><br>
Salvo que se indique lo contrario, todos los términos en mayúsculas utilizados, pero no definidos en el presente documento tendrán el significado que se les atribuye en las Normas de la NACHA (según se definen más adelante). Al utilizar los Servicios, usted acepta los términos y condiciones del presente Acuerdo. Salvo que se disponga expresamente lo contrario en el presente Apéndice, en la medida en que el presente Apéndice sea incompatible con los términos del Acuerdo inicial, prevalecerá el presente Apéndice y cualquier modificación de este que se realice periódicamente, pero sólo en la medida necesaria para resolver dicho conflicto.
<br><br>
Servicio ACH; cumplimiento de las normas de la NACHA y de la legislación aplicable. La red ACH es un sistema de transferencia de fondos que permite la compensación interbancaria de las entradas electrónicas de crédito y débito de las instituciones financieras participantes. El sistema ACH se rige por las Normas de funcionamiento y las Directrices de funcionamiento de la Asociación Nacional de Cámaras de Compensación Automatizadas ("NACHA") por sus siglas en ingles (colectivamente, las "Normas NACHA"). Sus derechos y obligaciones con respecto a cualquier Entrada se rigen por las Normas de la NACHA, el presente Acuerdo y la legislación aplicable. Usted reconoce que tiene acceso a una copia de las Normas de NACHA y acepta obtener y revisar una copia. (Las Reglas de NACHA pueden obtenerse en el sitio web de NACHA en www.NACHA.org o poniéndose en contacto directamente con NACHA en el 703-561-1100). También acepta suscribirse para recibir las revisiones de las Normas de NACHA directamente de NACHA. Usted declara y garantiza que cumplirá las Normas de NACHA y las leyes, reglamentos y requisitos normativos aplicables. Asimismo, declara y garantiza que no transmitirá ninguna Entrada ni realizará ningún acto u omisión que infrinja o nos haga infringir las Normas de la NACHA o las leyes de Estados Unidos, o cualquier otra ley, reglamento o requisito normativo aplicable, incluyendo, sin limitación, los reglamentos de la Oficina de Control de Activos Extranjeros ("OFAC"), las sanciones o las órdenes ejecutivas.

</p>


<br><br><br>

<br> <b>
Firma del Titular de la Cuenta de Banco: <img src="https://mymoneyline.com/lsbankingportal/signature_commercial_loan/completed/doc_signs/' . $img_signed . '" alt="" style="height:300%" align="left"/><br><br>
<span style="text-decoration:underline">' . $f_name . '</span><br> <b>
Nombre del Titular de la Cuenta de Banco
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
// $file_name = $id."page_14";
// $path = dirname(__FILE__) . "/Barcodes/" . $file_name . ".pdf";
// file_put_contents( $path, $pdf_data );

$file_name = $id . "page_14";
$path = dirname(__FILE__) . "/Barcodes/" . $file_name . ".pdf";
$pdf->Output($path, 'F');
//============================================================+
// END OF FILE
//============================================================+

?>