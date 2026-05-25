<?php
session_start();
$id=$_GET['id'];
?>


<?php
$url_logo="https://ofsca.com/loanportal/signature_customer/completed/"; 
include 'dbconnect.php';
include 'dbconfig.php';
$iddd=$_GET['id'];
// echo "idddd". $iddd;

//echo "key is".$mail_key;

$sql1=$con->query("select * from loan_initial_banking where email_key='$iddd' "); 

while($row1 = $sql1->fetch_array()) {

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

     $timestamp = strtotime($card_exp_date);
     $card_exp_date= date("m-Y", $timestamp);



$bank_name=$row1['bank_name'];
$routing_number=$row1['routing_number'];
$account_number=$row1['account_number'];
$account_number = strlen($account_number) > 4 ? substr($account_number, -4) : $account_number;

$cvv_number=$row1['cvv_number'];

$img_signed = $row1['signed_pic'];

$result_sig = $url_logo .'/doc_signs/'. $img_signed;
}


//echo "ID is".$loan_id;



$sql_loan=$con->query("select * from tbl_loan where loan_create_id= '$loan_id_bor' "); 

while($row_loan = $sql_loan->fetch_array()) {
    
    
    $amount_of_loan=$row_loan['amount_of_loan'];
	$total_loan_payable=$row_loan['loan_total_payable'];
    $amount_of_loan=number_format($amount_of_loan, 2);
    $payment_date=$row_loan['payment_date'];
    
     $timestamp = strtotime($payment_date);
     $payment_date= date("m-d-Y", $timestamp);
     
    $creation_date=$row_loan['contract_date'];
    
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

 $html = '<br><div style="line-height:7px"><h1>Optima Financial Solutions Inc</h1>
 <span style="font-size:8px">11306 EAST 183RD ST SUITE 305A CERRITOS, CA 90703</span><br>
 </div>
  <br>
 Borrower Name/Nombre del Deudor: <span style="text-decoration:underline">'.$f_name.'</span><br><br>
 Loan Number/Numero de Prestamo: <span style="text-decoration:underline">'.$loan_id_bor.'</span><br><br>
 Date/Fecha: <span style="text-decoration:underline">'.$creation_date.'</span>

 <h3 style="text-align:center">
 AUTORIZACIÃ“N DE PAGO RECURRENTE
 </h3>
 
 <div style="font-size:8px">
 1. Al firmar a continuaciÃ³n, el titular de la cuenta (â€œ<b>usted</b>â€) autoriza a Optima Financial Solutions Inc y sus afiliados (â€œ<b>nosotros</b>â€, â€œ<b>nos</b>â€ y â€œ<b>nuestro</b>â€) para
retirar automÃ¡ticamente su pago del prÃ©stamo de su cuenta de depÃ³sito que termina en xxxxxx'.$account_number.' (â€œ<b>Cuenta</b>â€) en '.$bank_name.'
(â€œ<b>Banco</b>â€)  a travÃ©s de entradas de dÃ©bito electrÃ³nico ACH (â€œ<b>AutorizaciÃ³n</b>â€). Usted
nos autoriza a iniciar el dÃ©bito de $'.$total_loan_payable.' (â€œ<b>importe de dÃ©bito programado</b>â€) en la fecha de vencimiento del pago, a partir de '.$payment_date.',
que es la fecha de entrada en vigor de esta AutorizaciÃ³n. Este dÃ©bito continuarÃ¡n hasta
que el monto adeudado bajo su prÃ©stamo sea pagado en su totalidad o hasta que esta AutorizaciÃ³n sea cancelada. TambiÃ©n nos autoriza a iniciar
dÃ©bitos o crÃ©ditos ACH en su Cuenta segÃºn sea necesario para corregir transacciones errÃ³neas..<br>
2. Usted tiene derecho a que le notifiquemos por escrito, con 10 dÃ­as de antelaciÃ³n, el importe y la fecha de cualquier cargo que varÃ­e el importe
programado. No obstante, si cargamos en su cuenta cualquier importe comprendido entre 1 dÃ³lar y el importe de cargo programado, usted acepta que
no tenemos que enviarle dicha notificaciÃ³n previa por escrito, a menos que lo exija la ley. No cargaremos en su Cuenta un importe superior al importe
de cargo programado anteriormente.<br>
3. Si cualquier fecha de pago cae en un fin de semana o en un dÃ­a festivo, el dÃ©bito se procesarÃ¡ el siguiente dÃ­a hÃ¡bil. 4. Si su Banco rechaza
cualquier cargo porque usted no tiene una cuenta en el Banco, cancelaremos estos cargos recurrentes. Si su Banco rechaza cualquier dÃ©bito porque
no hay suficiente dinero en su Cuenta, suspenderemos estos dÃ©bitos recurrentes y le daremos de baja de los pagos recurrentes hasta que haya
pagado todos los pagos atrasados y cualquier tarifa de pago devuelto o cualquier otra tarifa debida bajo su pagarÃ©. Una vez que su cuenta estÃ© al dÃ­a,
le volveremos a inscribir en los pagos recurrentes de la ACH bajo esta AutorizaciÃ³n, a menos que nos diga que no desea volver a inscribirse, en cuyo
caso cancelaremos los pagos recurrentes de la ACH..<br>
4. Usted declara que es un firmante autorizado en la Cuenta. Se compromete a notificarnos con prontitud cualquier cambio en la Cuenta y debe
avisarnos con siete (7) dÃ­as de antelaciÃ³n de cualquier cambio en la misma. Usted reconoce que las transacciones ACH a su Cuenta deben cumplir
con la legislaciÃ³n de los Estados Unidos.<br>
5. CÃ³mo cancelar. Puede cancelar esta AutorizaciÃ³n llamÃ¡ndonos al (818) 856-4302 durante nuestro horario de atenciÃ³n. Debe notificarnos la
cancelaciÃ³n al menos 3 dÃ­as antes de la fecha de vencimiento del pago. TambiÃ©n puede cancelar estos pagos recurrentes de la ACH siguiendo los
procedimientos de suspensiÃ³n de pagos de su banco, pero su banco puede cobrarle una comisiÃ³n. Si cancela, deberÃ¡ seguir realizando los pagos de
su prÃ©stamo a tiempo
<br><br>
Salvo que se indique lo contrario, todos los tÃ©rminos en mayÃºsculas utilizados, pero no definidos en el presente documento tendrÃ¡n el significado que
se les atribuye en las Normas de la NACHA (segÃºn se definen mÃ¡s adelante). Al utilizar los Servicios, usted acepta los tÃ©rminos y condiciones de este
Acuerdo. Salvo que se estipule expresamente lo contrario en el presente Anexo, en la medida en que este Anexo sea incompatible con los tÃ©rminos del
Acuerdo inicial, prevalecerÃ¡ el presente Anexo y cualquier modificaciÃ³n de este que se realice periÃ³dicamente, pero sÃ³lo en la medida necesaria para
resolver dicho conflicto. Servicio ACH; cumplimiento de las normas de la NACHA y de la legislaciÃ³n aplicable. La red ACH es un sistema de
transferencia de fondos que permite la compensaciÃ³n interbancaria de las entradas electrÃ³nicas de crÃ©dito y dÃ©bito de las instituciones financieras
participantes.
<br><br>
El sistema ACH se rige por las Normas de funcionamiento y las Directrices de funcionamiento de la AsociaciÃ³n Nacional de CÃ¡maras de
CompensaciÃ³n Automatizadas ("NACHA") (colectivamente, las "Normas NACHA"). Sus derechos y obligaciones con respecto a cualquier Entrada se
rigen por las Normas de la NACHA, el presente Acuerdo y la legislaciÃ³n aplicable. Usted reconoce que tiene acceso a una copia de las Normas de
NACHA y acepta obtener y revisar una copia. (Las Reglas de NACHA pueden obtenerse en el sitio web de NACHA en www.NACHA.org o poniÃ©ndose
en contacto directamente con NACHA en el 703-561-1100). TambiÃ©n acepta suscribirse para recibir las revisiones de las Normas de NACHA
directamente de NACHA. Usted declara y garantiza que cumplirÃ¡ las Normas de NACHA y las leyes, reglamentos y requisitos normativos aplicables.
Asimismo, declara y garantiza que no transmitirÃ¡ ninguna Entrada ni participarÃ¡ en ningÃºn acto u omisiÃ³n que infrinja o nos haga infringir las Normas de
la NACHA o las leyes de los Estados Unidos, o cualquier otra ley, reglamento o requisito normativo aplicable, incluidos, entre otros, los reglamentos de
la Oficina de Control de Activos Extranjeros ("OFAC"), las sanciones o las Ã³rdenes ejecutivas
<br><br>
<b>IMPORTANTE<b><br>
Para evitar cualquier comisiÃ³n por devoluciÃ³n de pago, usted acepta que tendrÃ¡ suficiente dinero en su Cuenta para cubrir el importe del
dÃ©bito programado.Los dÃ©bitos ACH podrÃ­an tardar hasta 5 dÃ­as hÃ¡biles en ser deducidos de su Cuenta.<br><br>
Usted reconoce que (1) esta AutorizaciÃ³n es voluntaria y no se requiere como condiciÃ³n para obtener su prÃ©stamo, (2) la TraducciÃ³n al
espaÃ±ol se proporciona sÃ³lo como una cortesÃ­a y la versiÃ³n en inglÃ©s es la versiÃ³n legalmente efectiva, y (3) usted recibiÃ³ una copia de
esta AutorizaciÃ³n cuando la firmÃ³
 
 </div>
 <table border="0" style="padding-top:10px;padding-bottom:10px">
 <tbody>
 <tr>
 <td style="text-align:left;margin-top:40%"><img src="../completed/doc_signs/'.$img_signed.'" height="300%" alt=""></td>
 <td style="text-align:center">'.$f_name.'</td>
 </tr>
 <tr>
	<td style="text-align:left;"><b><span style="text-decoration: overline">Firma del Titular de la Cuenta</span></b></td>
	<td style="text-align:center;"><b><span style="text-decoration: overline">Nombre del Titular de la Cuenta</span></b></td>
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

$file_name = $id."page_6";
$path=dirname(__FILE__)."/Barcodes/".$file_name.".pdf";
$pdf->Output($path,'F');
// $pdf->writeHTML($html,25,30); 


 
// $data_shipment  = ":";



// $pdf->Ln();
// $html = '<h1>LSBANKING </h1>';
// $html_underline = '<b style="text-decoration:underline">PLEASE LEAVE THIS LABEL UNCOVERED.</b>';
// // ---------------------------------------------------------

// //Close and output PDF document

// $file_name = $id."page_5";
// $path=dirname(__FILE__)."/Barcodes/".$file_name.".pdf";
// $pdf->Output($path,'F');

// $sign_image_url= "https://ofsca.com/loanportal/signature_customer/completed/doc_signs/".$img_signed;

// $img = file_get_contents($sign_image_url);

// $pdf->writeHTML($html,25,30); 

// $pdf->Image('@' . $img, 25, 226, '30', '', 'JPG', '', 'T', false, 40, '', false, false, 0, false, false, false);
 
// $data_shipment  = ":";



// $pdf->Ln();
// $html = '<h1>LSBANKING </h1>';
// $html_underline = '<b style="text-decoration:underline">PLEASE LEAVE THIS LABEL UNCOVERED.</b>';
// // ---------------------------------------------------------

// //Close and output PDF document

// $pdf->Output('Case.pdf', 'I');

// $pdf_data = ob_get_contents();

// $file_name = $id."page_5";
// $path="Barcodes/".$file_name.".pdf";
// file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>