<?php
$id=$_GET['id'];
$url_logo="https://pacificafinancegroup.com/loanportal/signature_commercial_loan/completed/";

include 'dbconnect.php';
include 'dbconfig.php';
$iddd=$_GET['id'];
 echo "idddd". $iddd;

//echo "key is".$mail_key;

$sql1=mysqli_query($con, "select * from commercial_loan_initial_banking where email_key='$iddd' "); 

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
$img_signed_co_borrow = $row1['sig_coborrow_pic'];
$result_sig_co_borrow = $url_logo . '/doc_signs_coborrow/' . $img_signed_co_borrow;
}


//echo "ID is".$loan_id;


$sql_loan=mysqli_query($con, "select * from tbl_commercial_loan where loan_create_id= '$loan_id_bor' "); 

while($row_loan = mysqli_fetch_array($sql_loan)) {
    
    
    $principal=$row_loan['amount_of_loan'];
    $principal=number_format($principal, 2);
    $payment_date=$row_loan['payment_date'];
    $interest_rate=$row_loan['loan_interest'];
    $interest_rate=number_format($interest_rate, 2);
    $timestamp = strtotime($payment_date);
    $payment_date= date("m-d-Y", $timestamp);
    
    $creation_date=$row_loan['creation_date'];
    
    $timestamp = strtotime($creation_date);
    $creation_date= date("m-d-Y", $timestamp);
    
	$created_by = $row_loan['created_by'];
    
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

$pdf->SetFont('helvetica', '', 7);

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

 $html = '
 <br>
<div style="display:inline-block">
	<img src="images/Money-Line-Logo.JPG" style="height:400%;clear: both" align="left"/>
</div>
<br><span style="text-align:left;width:100%"><b>4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403</b></span>
 <br><br><br>
Borrower Name/Nombre del Deudor: <span style="text-decoration:underline">'.$f_name.'</span><br><br>
&nbsp;&nbsp;Loan Number/Numero de Prestamo: <span style="text-decoration:underline">'.$loan_id_bor.'</span><br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date/Fecha: <span style="text-decoration:underline">'.$creation_date.'</span>
 <br><br><br>


 <h3 style="text-align:center"><u>Disclosures and Acknowledgements for Customers / Avisos y Authorizaciones para Clientes</u></h3>
<div class="">
<table>
<tbody>
<tr >
<td style="vertical-align:baseline;text-align:justify;width:45%">
<div>
<span>To the right, you will find a Spanish-Language translation of our Arbitration Agreement. An independent third party has certified this translation. While it is our intention to provide an accurate translation, if the Spanish translation differs from the English Document; you understand and agree that the Spanish translation is provided solely as courtesy to you, and that the English Document is the legally binding agreement between you and us.</span>
<br/><br><b>Authorization to be called and to be sent SMS Text Messages to your Mobile Phone, and to Receive Electronic Communications. </b>
<span>You agree that you will accept calls, SMS text messages. Emails and other electronic communications from us regarding your loan application, your loan payments, the collection of your loan account, and other important communications regarding your loan. You understand these calls could be automatically dialed and a recorded message may be played. You agree that such calls and electronic communications will not be unsolicited calls for purposes of state and federal law. You also agree that we may monitor telephone conversations between you and us to assure the quality of your customer service. By signing below, you authorize us to call and send SMS text messages to the mobile phone number you have provided to us for the purposes described above and for marketing purposes. You acknowledge that you are not required to authorize marketing calls or SMS text messages to obtain credit from us.</span>


<br><br>
<b>Right to Opt-Out.</b><span>You may opt out of receiving such calls and/or text messages from LS Financing Inc   by our calling customer service at(888) 540-7232.</span>
<br><br>

<b>Authorizations to Investigate your Employment.</b><span>By signing below, you authorize LS Financing Inc to investigate as it deems necessary your employment history at any time as long you have a remaining balance on your loan with us. If you have a co-applicant, each co-applicant, by signing below, also authorizes us to review                        such person’s employment history.</span>
<br><br>

<b>Privacy Policy.</b><span>By signing below, you acknowledge that you have received a copy of the notice entitled “Privacy Policy.</span>
<br><br>

</div>
</td>
<td style="width:10%"></td>
<td style="vertical-align:baseline;text-align:justify;width:45%">
	<span>A continuación, usted encontrara la traducción al español de nuestro Avisos y Autorizaciones para Clientes. Un tercero independiente ha certificado esta traducción. Aunque nuestra intención es proveerle una traducción exacta, si la traducción al español es destina al documento en ingles, usted entiende y está de acuerdo que esta traducción se brinda simplemente como una cortesía, y que el documento en el idioma ingles regirá legalmente la relación entre usted y nosotros.</span>
<br>
<br>

<b>Autorización para recibir llamadas y mensajes de texto a su celular, y comunicaciones electrónicas.</b><span>Usted está de acuerdo en aceptar las llamadas, los mensajes de texto, los correos electrónicos y otras comunicaciones electrónicas que le enviaremos con respecto a su solicitud de préstamo, los pagos de su préstamo, el cobro de su préstamo, y otras comunicaciones importantes sobre su préstamo. Usted entiende que estas llamadas podrían ser marcadas automáticamente por nuestro sistema y posiblemente sea un mensaje pre-grabado. Usted está de acuerdo que tales llamadas y comunicaciones electrónicas no serán consideradas llamadas no solicitadas en cuanto a la ley estatal y federal. Además, usted esta de acuerdo que podremos monitorizar conversaciones telefónicas entre usted y nosotros a fin de asegurar la calidad de nuestro servicio. Al formar este aviso, usted nos autoriza a realizar llamadas y enviar mensajes de texto al número de teléfono celular que nos ha proporcionado para los fines descritos anteriormente y para promociones. Usted reconoce que usted no está obligado a autorizar llamadas o mensajes de texto de promoción para obtener crédito de nosotros.</span>
<br><br>
<b>Derecho de optar no recibir mensajes.</b><span>Usted puede optar por no recibir llamadas o mensajes de texto de LS Financing Inc  llamando a nuestro servicio al cliente (888) 540-7232.</span>
<br><br>
<b>Autorización para investigar su empleo.</b><span>Al firmar abajo, usted le autoriza a LS Financing Inc llevar a cabo las investigaciones que estime necesarias para verificar su historial de empleo en cualquier momento que usted tenga su saldo restante en su préstamo con nosotros. Si usted tiene un co-deudor, cada co-deudor, al formar a continuación, también nos autoriza a revisar el historial de empleo de esa persona.</span>
<br><br>
<b>Política de privacidad.</b><span>Al firmar abajo, usted certifica que ha recibido una copia del documento titulado “Política de Privacidad”.</span>
<br><br>

</td>
</tr>

</tbody>
</table>
</div>

<div style="text-align: center;">
	<b >Important Information about Procedures for Opening a New Account.</b><br>
</div>
<span style="text-align: left;">To help the government fight the funding of terrorism and money laundering activities, Federal Law requires all financial institutions to obtain, verify, and record information that identifies each person who opens an account. What this means for you: When you open an account, we will ask for your name, address, date of birth, and other information that will allow us to identify you. We will also ask to see your driver’s license or other identifying documents.</span>
<br><br>	

<div style="text-align: center;">
	<b >Información importante sobre los procedimientos para abrir una nueva cuenta.</b><br>
</div>
<span style="text-align: left;">Para ayudar al gobierno a combatir el financiamiento de terrorismo u el lavado del dinero, la ley Federal requiere que todas las instituciones financieras obtengan, verifiquen, y registren información que identifique a cada persona que abre una cuenta. Esto significa que cuando usted abra una cuenta, le pediremos su nombre, dirección, fecha de nacimiento, i otra información que nos permita identificarlo. También solicitaremos que nos muestre su licencia de conducir u otros documentos identificatorios.</span>
<br><br>

<table>
<tbody>
<tr>

<td>
<img src="https://pacificafinancegroup.com/loanportal/signature_commercial_loan/completed/doc_signs/'.$img_signed.'" alt="" style="height:300%" align="left"/><br>
<b>Borrower Signature / Firma de deudor</b>
<br><br>
<img src="https://pacificafinancegroup.com/loanportal/signature_commercial_loan/completed/doc_signs_coborrow/'.$img_signed_co_borrow.'" alt="" style="height:300%" align="left"/><br>
<b>Co-Borrower Signature / Firma de co-deudor</b>
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

// $pdf->Output('Case.pdf', 'I');

// $pdf_data = ob_get_contents();

// $file_name = $id."page_8";
// $path="Barcodes/".$file_name.".pdf";
// file_put_contents( $path, $pdf_data );

// $pdf->Output(dirname(__FILE__).'/Case.pdf', 'I');

// $pdf_data = ob_get_contents();
// $file_name = $id."page_8";
// $path = dirname(__FILE__) . "/Barcodes/" . $file_name . ".pdf";
// file_put_contents( $path, $pdf_data );

$file_name =$id. "page_8";
$path=dirname(__FILE__)."/Barcodes/".$file_name.".pdf";
$pdf->Output($path, 'F');
//============================================================+
// END OF FILE
//============================================================+

?>