<?php
$id=$_GET['id'];
?>


<?php

include 'dbconnect.php';
include 'dbconfig.php';
$iddd=$_GET['id'];
// echo "idddd". $iddd;

//echo "key is".$mail_key;

$sql1=mysqli_query($con, "select * from personal_loan_initial_banking where email_key='$iddd' "); 

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



$sql_loan=mysqli_query($con, "select * from tbl_personal_loans where loan_create_id= '$loan_id_bor' "); 

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
Borrower Name/Nombre del Deudor: <span style="text-decoration:underline">'.$f_name.'</span><br>
Loan Number/Numero de Prestamo: <span style="text-decoration:underline">'.$loan_id_bor.'</span><br>
Date/Fecha: <span style="text-decoration:underline">'.$creation_date.'</span>
 <br><br>
 <h4><u>Disclosures and Acknowledgements for Customers / Avisos y Authorizaciones para Clientes</u></h4>
<table>
<tbody>
<tr>
<td><span style="font-size:8px;">To the right, you will find a Spanish-Language translation of our Disclosures and Acknowledgements for Customers. An independent third party has certified this translation. While it is our intention to provide an accurate translation, if the Spanish translation differs from the English Document; you understand and agree that the Spanish translation is provided solely as courtesy to you, and that the English Document is the legally binding agreement between you and us.</span>
<br>
<b style="font-size:8px;">Authorization to be called and to be sent SMS Text Messages to your Mobile Phone, and to Receive Electronic Communications.</b><br><span style="font-size:6px;">You agree that you will accept calls, SMS text messages. Emails and other electronic communications from us regarding your loan application, your loan payments, the collection of your loan account, and other important communications regarding your loan. You understand these calls could be automatically dialed and a recorded message may be played. You agree that such calls and electronic communications will not be unsolicited calls for purposes of state and federal law. You also agree that we may monitor telephone conversations between you and us to assure the quality of your customer service. By signing below, you authorize us to call and send SMS text messages to the mobile phone number you have provided to us for the purposes described above and for marketing purposes. You acknowledge that you are not required to authorize marketing calls or SMS text messages to obtain credit from us.</span>
<br>

<b style="font-size:8px;">•Right to Opt-Out:</b><span style="font-size:6px;">You may opt out of receiving such calls and/or text messages from Pacifica Finance Group by our calling customer service at (747)300-1542.</span>
<br>  
<b style="font-size:8px">•Authorizations to Investigate your Employment:</b><span style="font-size:6px;">By signing below, you authorize Pacifica Finance Group to investigate as it deems necessary your employment history at any time as long you have a remaining balance on your loan with us. If you have a co-applicant, each co-applicant, by signing below, also authorizes us to review such person’s employment history.</span>
<br>
<b style="font-size:8px;">•Privacy Policy:</b><span style="font-size:6px;">By signing below, you acknowledge that you have received a copy of the notice entitled “Privacy Policy.</span>
<br>  

</td>
<td></td>


<td><span style="font-size:6px;">A continuación, usted encontrara la traducción al español de nuestro Avisos y Autorizaciones para Clientes. Un tercero independiente ha certificado esta traducción. Aunque nuestra intención es proveerle una traducción exacta, si la traducción al español es destina al documento en ingles, usted entiende y está de acuerdo que esta traducción se brinda simplemente como una cortesía, y que el documento en el idioma ingles regirá legalmente la relación entre usted y nosotros.</span>
<br>
<b style="font-size:8px;">Autorización para recibir llamadas y mensajes de texto a su celular, y comunicaciones electrónicas</b><span style="font-size:6px;">Usted está de acuerdo en aceptar las llamadas, los mensajes de texto, los correeros electrónicos y otras comunicaciones electrónicas que le enviaremos con respecto a su solicitud de préstamo, los pagos de su préstamo, el cobro de su préstamo, y otras comunicaciones importantes sobre su préstamo. Usted entiende que estas llamadas podrían ser marcadas automáticamente por nuestro sistema y posiblemente sea un mensaje pre-grabado. Usted está de acuerdo que tales llamadas y comunicaciones electrónicas no serán consideradas llamadas no solicitadas en cuanto a la ley estatal y federal. Además, usted esta de acuerdo que podremos monitorizar conversaciones telefónicas entre usted y nosotros a fin de asegurar la calidad de nuestro servicio. Al formar este aviso, usted nos autoriza a realizar llamadas y enviar mensajes de texto al número de teléfono celular que nos ha proporcionado para los fines descritos anteriormente y para promociones. Usted reconoce que usted no está obligado a autorizar llamadas o mensajes de texto de promoción para obtener crédito de nosotros.</span>
<br>

<b style="font-size:8px;">•Derecho de optar no recibir mensajes:</b><span style="font-size:6px;">Usted puede optar por no recibir llamadas o mensajes de texto de Pacifica Finance Group llamando a nuestro servicio al cliente (747) 300-1542.</span>
<br>  
<b style="font-size:8px">•Autorización para investigar su empleo:</b><span style="font-size:6px;">Al firmar abajo, usted le autoriza a Pacifica Finance Group llevar a cabo las investigaciones que estime necesarias para verificar su historial de empleo en cualquier momento que usted tenga su saldo restante en su préstamo con nosotros. Si usted tiene un co-deudor, cada co-deudor, al formar a continuación, también nos autoriza a revisar el historial de empleo de esa persona.</span>
<br>
<b style="font-size:8px;">•Política de privacidad:</b><span style="font-size:6px;">Al firmar abajo, usted certifica que ha recibido una copia del documento titulado “Política de Privacidad”.</span>
<br>  

</td>

</tr>

</tbody>
</table>
<h4 style="font-size:8px;">Important Information about Procedures for Opening a New Account.</h4>
 <br>
<span style="font-size:6px;"> To help the government fight the funding of terrorism and money laundering activities, Federal Law requires all financial institutions to obtain, verify, and record information that identifies each person who opens an account. What this means for you: When you open an account, we will ask for your name, address, date of birth, and other information that will allow us to identify you. We will also ask to see your driver’s license or other identifying documents.</span>
<h4 style="font-size:8px;">Información importante sobre los procedimientos para abrir una nueva cuenta.</h4>
 <br>
<span style="font-size:6px;">Para ayudar al gobierno a combatir el financiamiento de terrorismo u el lavado del dinero, la ley Federal requiere que todas las instituciones financieras obtengan, verifiquen, y registren información que identifique a cada persona que abre una cuenta. Esto significa que cuando usted abra una cuenta, le pediremos su nombre, dirección, fecha de nacimiento, i otra información que nos permita identificarlo. También solicitaremos que nos muestre su licencia de conducir u otros documentos identificatorios.</span>
<br><br>
SIGNATURES/FIRMAS:
<br><br>

<table>
<tbody>
<tr>

<td>
Borrower Signature/ Firma del deudor:
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

$file_name = $id."page_6";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>