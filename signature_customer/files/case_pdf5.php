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
$account_number = strlen($account_number) > 4 ? substr($account_number, -4) : $account_number;

$cvv_number=$row1['cvv_number'];

$img_signed = $row1['signed_pic'];

$result_sig = $url_logo .'/doc_signs/'. $img_signed;
}


//echo "ID is".$loan_id;



$sql_loan=mysqli_query($con, "select * from tbl_loan where loan_create_id= '$loan_id_bor' "); 

while($row_loan = mysqli_fetch_array($sql_loan)) {
    
    
    $amount_of_loan=$row_loan['amount_of_loan'];
    $total_loan_payable=$row_loan['loan_total_payable'];
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

 $html = '<br><div style="line-height:7px"><h1>MoneyLine</h1>
<span style="font-size:8px">4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403</span><br>
</div>
 <br>
Borrower Name/Nombre del Deudor: <span style="text-decoration:underline">'.$f_name.'</span><br><br>
Loan Number/Numero de Prestamo: <span style="text-decoration:underline">'.$loan_id_bor.'</span><br><br>
Date/Fecha: <span style="text-decoration:underline">'.$creation_date.'</span>
 <br>
<h3 style="text-align:center">
AUTORIZACI??N DE PAGO RECURRENTE
</h3>

<div style="font-size:8px">
1. Al firmar a continuaci??n, el titular de la cuenta (???<b>usted</b>???) autoriza a Money Line y sus afiliados (???<b>nosotros</b>???, ???<b>nos</b>??? y ???<b>nuestro</b>???) para
retirar autom??ticamente sus pagos de pr??stamos de su cuenta de dep??sito que termina en xxxxxx'.$account_number.' (???<b>Cuenta</b>???) en '.$bank_name.'
(???<b>Banco</b>???)  a trav??s de entradas de d??bito electr??nico recurrente ACH (???<b>Autorizaci??n</b>???). Usted
nos autoriza a iniciar d??bitos de $'.$total_loan_payable.' (???<b>importe de d??bito programado</b>???) cada _ en las fechas de vencimiento de los
pagos, a partir de '.$payment_date.',
que es la fecha de entrada en vigor de esta Autorizaci??n. Estos d??bitos continuar??n hasta que el monto
adeudado bajo su pr??stamo sea pagado en su totalidad o hasta que esta Autorizaci??n sea cancelada. Tambi??n nos autoriza a iniciar
d??bitos o cr??ditos ACH en su Cuenta seg??n sea necesario para corregir transacciones err??neas.<br>
2. Usted tiene derecho a que le notifiquemos por escrito, con 10 d??as de antelaci??n, el importe y la fecha de cualquier cargo que var??e el
importe programado. No obstante, si cargamos en su cuenta cualquier importe comprendido entre 1 d??lar y el importe de cargo
programado, usted acepta que no tenemos que enviarle dicha notificaci??n previa por escrito, a menos que lo exija la ley. No cargaremos
en su Cuenta un importe superior al importe de cargo programado anteriormente.<br>
3. Si cualquier fecha de pago cae en un fin de semana o en un d??a festivo, el d??bito se procesar?? el siguiente d??a h??bil. 4. Si su Banco
rechaza cualquier cargo porque usted no tiene una cuenta en el Banco, cancelaremos estos cargos recurrentes. Si su Banco rechaza
cualquier d??bito porque no hay suficiente dinero en su Cuenta, suspenderemos estos d??bitos recurrentes y le daremos de baja de los
pagos recurrentes hasta que haya pagado todos los pagos atrasados y cualquier tarifa de pago devuelto o cualquier otra tarifa debida
bajo su pagar??. Una vez que su cuenta est?? al d??a, le volveremos a inscribir en los pagos recurrentes de la ACH bajo esta Autorizaci??n, a
menos que nos diga que no desea volver a inscribirse, en cuyo caso cancelaremos los pagos recurrentes de la ACH.<br>
4. Usted declara que es un firmante autorizado en la Cuenta. 5. Se compromete a notificarnos con prontitud cualquier cambio en la
Cuenta y debe avisarnos con siete (7) d??as de antelaci??n de cualquier cambio en la misma. Usted reconoce que las transacciones ACH a
su Cuenta deben cumplir con la legislaci??n de los Estados Unidos.<br>
5. 5. C??mo cancelar. Puede cancelar esta Autorizaci??n llam??ndonos al (888) 540-7232 durante nuestro horario de atenci??n. Debe
notificarnos la cancelaci??n al menos 3 d??as antes de la fecha de vencimiento del pago. Tambi??n puede cancelar estos pagos recurrentes
de la ACH siguiendo los procedimientos de suspensi??n de pagos de su banco, pero su banco puede cobrarle una comisi??n. Si cancela,
deber?? seguir realizando los pagos de su pr??stamo a tiempo
<br><br>
Salvo que se indique lo contrario, todos los t??rminos en may??sculas utilizados, pero no definidos en el presente documento tendr??n el
significado que se les atribuye en las Normas de la NACHA (seg??n se definen m??s adelante). Al utilizar los Servicios, usted acepta los
t??rminos y condiciones de este Acuerdo. Salvo que se estipule expresamente lo contrario en el presente Anexo, en la medida en que este
Anexo sea incompatible con los t??rminos del Acuerdo inicial, prevalecer?? el presente Anexo y cualquier modificaci??n de este que se
realice peri??dicamente, pero s??lo en la medida necesaria para resolver dicho conflicto. Servicio ACH; cumplimiento de las normas de la
NACHA y de la legislaci??n aplicable. La red ACH es un sistema de transferencia de fondos que permite la compensaci??n interbancaria de
las entradas electr??nicas de cr??dito y d??bito de las instituciones financieras participantes.
<br><br>
El sistema ACH se rige por las Normas de funcionamiento y las Directrices de funcionamiento de la Asociaci??n Nacional de C??maras de
Compensaci??n Automatizadas ("NACHA") (colectivamente, las "Normas NACHA"). Sus derechos y obligaciones con respecto a cualquier
Entrada se rigen por las Normas de la NACHA, el presente Acuerdo y la legislaci??n aplicable. Usted reconoce que tiene acceso a una copia
de las Normas de NACHA y acepta obtener y revisar una copia. (Las Reglas de NACHA pueden obtenerse en el sitio web de NACHA en
www.NACHA.org o poni??ndose en contacto directamente con NACHA en el 703-561-1100). Tambi??n acepta suscribirse para recibir las
revisiones de las Normas de NACHA directamente de NACHA. Usted declara y garantiza que cumplir?? las Normas de NACHA y las leyes,
reglamentos y requisitos normativos aplicables. Asimismo, declara y garantiza que no transmitir?? ninguna Entrada ni participar?? en
ning??n acto u omisi??n que infrinja o nos haga infringir las Normas de la NACHA o las leyes de los Estados Unidos, o cualquier otra ley,
reglamento o requisito normativo aplicable, incluidos, entre otros, los reglamentos de la Oficina de Control de Activos Extranjeros
("OFAC"), las sanciones o las ??rdenes ejecutivas
<br><br>
<b>IMPORTANTE<b><br>
Para evitar cualquier comisi??n por devoluci??n de pago, usted acepta que tendr?? suficiente dinero en su Cuenta para cubrir el importe del
d??bito programado.Los d??bitos ACH podr??an tardar hasta 5 d??as h??biles en ser deducidos de su Cuenta.<br><br>
Usted reconoce que (1) esta Autorizaci??n es voluntaria y no se requiere como condici??n para obtener su pr??stamo, (2) la Traducci??n al
espa??ol se proporciona s??lo como una cortes??a y la versi??n en ingl??s es la versi??n legalmente efectiva, y (3) usted recibi?? una copia de
esta Autorizaci??n cuando la firm??

</div>
<table border="0" style="padding-top:10px;padding-bottom:10px">
<tbody>
<tr>
   <td style="text-align:left">____________________________________</td>
   <td style="text-align:center">____________________________________</td>
</tr>
<tr>
   <td style="text-align:left"><b>Firma del Ttitular de la Cuenta</b></td>
   <td style="text-align:center"><b>Nombre del Titular de la Cuenta</b></td>
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

//============================================================+
// END OF FILE
//============================================================+

?>