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
 
 <br> <br>
 <div style="font-size:8px">
<table border="0">
<tbody>
<tr >
     <td align="center"><b>SMS POLICY LOAN #</b><u>'.$loan_id_bor.'</u></td>
     <td align="center"><b>POL??TICA DE SMS PR??STAMO #</b><u>'.$loan_id_bor.'</u></td>
</tr>
<tr>
     <td>
     By providing your cellular phone number, you have provided us with consent to
     send you text messages (SMS) in conjunction with the services you have
     requested. Your cellular provider\'s MSG & Data Rates may apply to our
     confirmation message and all subsequent messages. You understand the text
     messages we send may be seen by anyone with access to your phone.
     Accordingly, you should take steps to safeguard your phone and your text
     messages if you want them to remain private (NO CONFIDENTIAL
     INFORMATION SHOULD BE SENT VIA SMS) Please notify us immediately if you
     change mobile numbers.If we notify this SMS Policy, we will notify you by
     sending you a SMS. We may terminate our SMS Policy at any time.
     If you have any questions about this SMS Policy, would like us to mail you a
     paper copy or are having problems receiving or stopping our text messages,
     please contact us using the following information: LS Financing, Inc 4645 Van
     Nuys Boulevard Suite 202 Sherman Oaks, CA 91403 info@lsbanking.com or
     (888) 540-7232. You agree and consent to the contracted by the Company, our
     agents, employees, attorneys, subsequent creditors, loan servicing companies
     and third party collectors through the use of email, and/or telephone calls,
     and/or SMS to your cellular, home or work phone numbers, as well as any other
     phone number you have provided in conjunction with this account, including
     the use of automatic telephoning dialing systems, auto-dialers, or an artificial or
     prerecorded voice.OPT-OUT or STOP This SMS Policy applies to the text
     messages sent by LS Financing to our customers while and after they use our
     service. If you wish to stop receiving SMS from LS Financing, Inc reply to any
     text message we have sent you and, in your reply, simply type STOP. Your stop
     request will become effective immediately. You may also stop SMS by calling,
     sending a letter or email us to the following information: LS Financing, Inc 4645
     Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403 info@lsbanking.com or
     (888) 540-7232. HELP or SUPPORT If at any time you need our contact
     information on how to stop SMS, reply to any text message we have sent you
     and, in this reply, simply type HELP. Upon receiving your text message, we will
     send you a text message with this information. The message we send provide
     you with information about your account. Some of the SMS we send may
     include links to websites. To access these websites, you will need a web
     browser and Internet access. AGREEMENT TO RECEIVE SMS By signing this
     section, you authorize LS Financing, Inc or Our Agents to send marketing to the
     mobile number you have provided and that is listed below using and automatic
     dialing system, you are not required to authorize marketing SMS to obtain
     credit or other services from us. If you do not wish to receive, sales or
     marketing SMS from us, you should not sign this section. You understand that
     at any messages we send you may be accessed by anyone with access to your
     SMS. You also understand that your mobile phone service provider any charge
     you fees for any SMS that we send you, and you agree that we shall have no
     liability for any cost related to such SMS. At any time, you may withdraw your
     consent to receive marketing by calling us at (888) 540-7232.

     <br>
     <br><br>
     '.$f_name.' - ('.$mobile_number.')<hr>
     <b>Borrower???s Name/Nombre - (Phone Number/Telefono)<br><br>
     
     <br>
     <hr>
     Borrower???s Signature/Firma del Prestatario<br><br>
   
   
     </b>

     </td>
     <td style="width:10px"></td>
     <td>
     Al proporcionar su n??mero de tel??fono m??vil, nos ha dado su consentimiento
     para enviarle mensajes de texto (SMS) en relaci??n con los servicios que ha
     solicitado. Las tarifas de datos y MSG de su proveedor de telefon??a m??vil
     pueden aplicarse a nuestro mensaje de confirmaci??n y a todos los mensajes
     posteriores.Usted entiende que los mensajes de texto que enviamos pueden
     ser vistos por cualquier persona con acceso a su tel??fono. En consecuencia,
     debe tomar medidas para proteger su tel??fono y sus mensajes de texto si desea
     que sigan siendo privados (NO SE DEBE ENVIAR INFORMACI??N CONFIDENCIAL
     POR SMS)Le rogamos que nos notifique inmediatamente si cambia de n??mero
     de m??vil.Si notificamos esta Pol??tica de SMS, se lo notificaremos envi??ndole un
     SMS. Podemos poner fin a nuestra Pol??tica de SMS en cualquier momento.Si
     tiene alguna pregunta sobre esta Pol??tica de SMS, desea que le enviemos una
     copia en papel o tiene problemas para recibir o detener nuestros mensajes de
     texto, p??ngase en contacto con nosotros utilizando la siguiente informaci??n: LS
     Financing, Inc 4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403
     info@lsbanking.com o (888) 540-7232.Usted acepta y consiente la contrataci??n
     por parte de la Compa????a, nuestros agentes, empleados, abogados, acreedores
     posteriores, empresas de servicios de pr??stamos y coleccionistas de terceros a
     trav??s del uso de correo electr??nico, y / o llamadas telef??nicas, y / o SMS a su
     celular, casa o n??meros de tel??fono del trabajo, as?? como cualquier otro
     n??mero de tel??fono que ha proporcionado en relaci??n con esta cuenta,
     incluyendo el uso de sistemas de marcaci??n telef??nica autom??tica, marcadores
     autom??ticos, o una voz artificial o pregrabada. OPTAR o DETENER
     Esta Pol??tica de SMS se aplica a los mensajes de texto enviados por LS Financing
     a nuestros clientes mientras y despu??s de que utilicen nuestro servicio. Si desea
     dejar de recibir SMS de LS Financing, Inc. responda a cualquier mensaje de texto
     que le hayamos enviado y, en su respuesta, simplemente escriba STOP. Su
     solicitud de interrupci??n se har?? efectiva inmediatamente. Tambi??n puede
     dejar de recibir SMS llamando, enviando una carta o un correo electr??nico a la
     siguiente informaci??n LS Financing, Inc 4645 Van Nuys Boulevard Suite 202
     Sherman Oaks, CA 91403 info@lsbanking.com o (888) 540-7232.
     AYUDA o APOYO Si en alg??n momento necesita nuestra informaci??n de
     contacto sobre c??mo detener los SMS, responda a cualquier mensaje de texto
     que le hayamos enviado y, en esta respuesta, simplemente escriba AYUDA. Al
     recibir tu mensaje de texto, te enviaremos un mensaje de texto con esta
     informaci??n. El mensaje que enviamos le proporciona informaci??n sobre su
     cuenta. Algunos de los SMS que enviamos pueden incluir enlaces a sitios web.
     Para acceder a estos sitios web, necesitar?? un navegador web y acceso a
     Internet.ACUERDO PARA RECIBIR SMS Al firmar esta secci??n, usted autoriza a LS
     Financing, Inc o a nuestros agentes a enviar marketing al n??mero de m??vil que
     nos ha proporcionado y que figura a continuaci??n mediante un sistema de
     marcaci??n autom??tica, no est?? obligado a autorizar el marketing por SMS para
     obtener cr??dito u otros servicios de nosotros. Si no desea recibir, ventas o SMS
     de marketing de nosotros, no debe firmar esta secci??n. Usted entiende que a
     cualquier mensaje que le enviemos puede acceder cualquier persona con
     acceso a sus SMS. Tambi??n entiende que su proveedor de servicios de telefon??a
     m??vil puede cobrarle tarifas por cualquier SMS que le enviemos, y acepta que
     no tendremos ninguna responsabilidad por cualquier coste relacionado con
     dichos SMS. En cualquier momento, puede retirar su consentimiento para
     recibir marketing llam??ndonos al (888) 540-7232.
     </td>
</tr>
</tbody>
</table>
</div>

';

$pdf->writeHTML($html,25,30); 


 
$data_shipment  = ":";



$pdf->Ln();
$html = '<h1>LSBANKING </h1>';
$html_underline = '<b style="text-decoration:underline">PLEASE LEAVE THIS LABEL UNCOVERED.</b>';
// ---------------------------------------------------------

//Close and output PDF document

$file_name = $id."page_3";
$path=dirname(__FILE__)."/Barcodes/".$file_name.".pdf";
$pdf->Output($path,'F');

//============================================================+
// END OF FILE
//============================================================+

?>