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
<b style="font-size:8px;"><u>SMS POLICY LOAN</u></b><br>

<span style="font-size:8px;">By providing your cellular phone number, you have provided us with consent to send you text messages (SMS) in conjunction with the services you have requested. Your cellular providers MSG & Data Rates may apply to our confirmation message and all subsequent messages.
<br>
You understand the text messages we send may be seen by anyone with access to your phone. Accordingly, you should take steps to safeguard your phone and your text messages if you want them to remain private (NO CONFIDENTIAL INFORMATION SHOULD BE SENT VIA SMS)
Please notify us immediately if you change mobile numbers.

<br>

If we notify this SMS Policy, we will notify you by sending you a SMS. We may terminate our SMS Policy at any time.
<br>

If you have any questions about this SMS Policy, would like us to mail you a paper copy or are having problems receiving or stopping our text messages, please contact us using the following information: Pacifica Finance Group 5900 S Eastern Ave Suite 114 Commerce, CA 90040 info@pacificafinancegroup.com or (323) 797-5398.
<br>
You agree and consent to the contracted by the Company, our agents, employees, attorneys, subsequent creditors, loan servicing companies and third party collectors through the use of email, and/or telephone calls, and/or SMS to your cellular, home or work phone numbers, as well as any other phone number you have provided in conjunction with this account, including the use of automatic telephoning dialing systems, auto-dialers, or an artificial or prerecorded voice.
</span>
<br>
<b style="font-size:8px;">OPT-OUT or STOP:</b><span style="font-size:8px;">This SMS Policy applies to the text messages sent by Pacifica Finance Group to our customers while and after they use our service. If you wish to stop receiving SMS from Pacifica Finance Group reply to any text message we have sent you and, in your reply, simply type STOP. Your stop request will become effective immediately. You may also stop SMS by calling, sending a letter or email us to the following information: Pacifica Finance Group 5900 S Eastern Ave Suite 114 Commerce, CA 90040 info@pacificafinancegroup.com or (323) 797-5398.
</span><br>
<b style="font-size:8px;">HELP or SUPPORT: </b><span style="font-size:8px;">: If at any time you need our contact information on how to stop SMS, reply to any text message we have sent you and, in this reply, simply type HELP. Upon receiving your text message, we will send you a text message with this information. The message we send provide you with information about your account. Some of the SMS we send may include links to websites. To access these websites, you will need a web browser and Internet access. 
</span><br>

<b style="font-size:8px;">AGREEMENT TO RECEIVE SMS: </b><span style="font-size:8px;">By signing this section, you authorize Pacifica Finance Group or Our Agents to send marketing to the mobile number you have provided and that is listed below using and automatic dialing system, You are not required to authorize marketing SMS to obtain credit or other services from us. If you do not wish to receive, sales or marketing SMS from us, you should not sign this section. You understand that at any messages we send you may be accessed by anyone with access to your SMS. You also understand that your mobile phone service provider any charge you fees for any SMS that we send you, and you agree that we shall have no liability for any cost related to such SMS. At any time, you may withdraw your consent to receive marketing by calling us at (323) 797-5398. 
</span>

<br><br>

<span style="font-size:8px;">Borrower’s Signature / Firma del Prestatario:</span>
<br>
X____________________________________      
<br>
<span style="font-size:8px;">Co-Borrower’s Signature / Firma del Co-Prestatario:</span>
<br>
X_____________________________________





</td>





<td>
<b style="font-size:8px;"><u>POLÍTICA DE SMS</u></b><br>

<span style="font-size:8px;">Al proporcionar su número de teléfono celular, nos ha dado su consentimiento para enviarle mensajes de texto (SMS) junto con los servicios que ha solicitado. Las tarifas de datos y MSG de su proveedor de telefonía celular pueden aplicarse a nuestro mensaje de confirmación y a todos los mensajes posteriores.
<br>
Usted comprende que los mensajes de texto que enviamos pueden ser vistos por cualquier persona con acceso a su teléfono. En consecuencia, debe tomar medidas para proteger su teléfono y sus mensajes de texto si desea que se mantengan privados (NO DEBE ENVIARSE INFORMACIÓN CONFIDENCIAL POR SMS)
<br>

If we notify this SMS Policy, we will notify you by sending you a SMS. We may terminate our SMS Policy at any time.
<br>

Notifíquenos de inmediato si cambia los números de teléfono móvil.
Si notificamos esta Política de SMS, se lo notificaremos enviándole un SMS. Podemos rescindir nuestra Política de SMS en cualquier momento.
Si tiene alguna pregunta sobre esta Política de SMS, desea que le enviemos una copia en papel o si tiene problemas para recibir o detener nuestros mensajes de texto, contáctenos utilizando la siguiente información: Pacifica Finance Group 4645 Van Nuys Boulevard Suite 202 Sherman Oaks , CA 91403 info@pacificafinancegroup.com o (323) 797-5398.

<br>
Usted acepta y consiente lo contratado por la Compañía, nuestros agentes, empleados, abogados, acreedores posteriores, compañías de servicios de préstamos y recaudadores externos mediante el uso de correo electrónico y / o llamadas telefónicas y / o SMS a su celular, hogar o números de teléfono de trabajo, así como cualquier otro número de teléfono que haya proporcionado junto con esta cuenta, incluido el uso de sistemas de marcación telefónica automática, marcadores automáticos o una voz artificial o pregrabada.
</span>
<br>
<b style="font-size:8px;">OPT-OUT o STOP:</b><span style="font-size:7px;">Esta Política de SMS se aplica a los mensajes de texto enviados por Pacifica Finance Group a nuestros clientes mientras y después de que usan nuestro servicio. Si desea dejar de recibir SMS de Pacifica Finance Group, responda a cualquier mensaje de texto que le hayamos enviado y, en su respuesta, simplemente escriba STOP. Su solicitud de detención entrará en vigencia de inmediato. También puede detener los SMS llamando, enviando una carta o envíenos un correo electrónico a la siguiente información: Pacifica Finance Group 5900 S Eastern Ave Suite 114 Commerce, CA 90040 info@pacificafinancegroup.com o (323) 797-5398.
</span><br>
<b style="font-size:8px;">AYUDA o APOYO: </b><span style="font-size:7px;">Si en algún momento necesita nuestra información de contacto sobre cómo detener SMS, responda cualquier mensaje de texto que le hayamos enviado y en esta respuesta simplemente escriba HELP. Al recibir su mensaje de texto, le enviaremos un mensaje de texto con esta información. El mensaje que enviamos le brinda información sobre su cuenta. Algunos de los SMS que enviamos pueden incluir enlaces a sitios web. Para acceder a estos sitios web, necesitará un navegador web y acceso a Internet. 
</span><br>

<b style="font-size:8px;">ACUERDO PARA RECIBIR SMS: </b><span style="font-size:7px;">Al firmar esta sección, autoriza a Pacifica Finance Group o Nuestros agentes a enviar marketing al número de teléfono móvil que ha proporcionado y que se detalla a continuación utilizando un sistema de marcación automática. No está obligado a autorizar SMS de marketing para obtener crédito u otros servicios de nosotros. Si no desea recibir nuestros SMS de ventas o marketing, no debe firmar esta sección. Usted comprende que cualquier mensaje que le enviemos puede ser accedido por cualquier persona que tenga acceso a su SMS. También comprende que su proveedor de servicios de telefonía móvil le cobra honorarios por cualquier SMS que le enviemos, y acepta que no tendremos ninguna responsabilidad por los costos relacionados con dicho SMS. En cualquier momento, puede retirar su consentimiento para recibir marketing llamándonos al (323) 797-5398. 
</span>
<br><br>
<span style="font-size:8px;">Date/Fecha:</span>
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

$file_name = $id."page_13";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>