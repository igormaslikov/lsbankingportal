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
<span style="font-size:8px;">If there is any money left over (surplus) we will pay it to you unless we must pay it to someone else who has a subordinate lien or encumbrance of the vehicle as permitted by law. If a balance remains due us, you promise to pay it when we make demand. After we accelerate the unpaid Principal balance you will pay interest on what you still owe us at the rate of Finance Charge shown in this Agreement until you pay us all that you owe or until judgment is entered in our favor. Our remedies are cumulative and our taking any actions will not deem a waiver of or prohibition against us taking any other action.</span>
<br>

<b style="font-size:8px;">â€¢Extensions or Deferrals:</b><span style="font-size:8px;">We may agree from time to time to extended or defer payments or amounts you owe us. If we do so, such extension or deferral does not mean we must or will extend or defer any other payment and does not affect your liability for what you owe. We reserve the right to charge a fee of $50.00 for deferments or extensions.</span>
<br>
<b style="font-size:8px;">â€¢Default:</b><span style="font-size:8px;">If you fail to make your payment, you will be in default of this Agreement. You will also be in default of this Agreement if: (1) you gave us false information in connection with this loan: (2) you fail to keep your promises or fulfill your obligations under this Agreement; (3) you die and there is no surviving co-borrower; (4) you become insolvent or file a petition for bankruptcy or a petition in bankruptcy is filled against you; or (5) the vehicle is stolen, damaged, destroyed, impounded, seized, confiscated or forfeited.</span>
<br>

<b style="font-size:8px;">â€¢Power of Attorney:</b><span style="font-size:8px;">Until you have paid us all that you owe us. You hereby appoint us, and any one of our designated officers or employees, as your Attorney-in-fact, with full power of substitution, to sign in your name any and all applications for certificate of ownership to secure our lien in the vehicle, and any affidavits or the certificate of ownership to transfer and convey the title or our interest in the vehicle.</span>
<br>
<b style="font-size:8px;">â€¢Regulation B:</b><span style="font-size:8px;">By providing us your wireless cell or telephone number, you expressly consent to receiving telephone calls and text messages from us concerning you loan, including calls to collect what you owe. Live calls may be made by one of our employees; calls may also be made by a prerecorded autodialed voice or text message. Your consent covers all types of calls. We do not charge you such calls. Your wireless carrier will charge you for our incoming calls and text messages according to your plan.</span>
<br>
<b style="font-size:8px;">â€¢Confidentiality:</b><span style="font-size:8px;">We will report your payment history with the Lender to reporting agencies and others who may lawfully receive that information. By signing this Agreement, you waive the confidentiality under the provisions of California Vehicle Code Section 1808.21. You also authorize us to obtain from the California Department of Motor Vehicles you current residence address at any time during the term of your loan until we are paid in full.</span>
<br>
<b style="font-size:8px;">â€¢Governing Law:</b><span style="font-size:8px;">This loan is governed by California Law. This loan is not subject to Californiaâ€™s usury limit, Cal. Const. art XV, Section 1. If the Total Loan Amount is a bona fide principal amount of more then $2,500.00. This loan is not subject to the rate limitations in the California Finance Lenders Law. This loan is made pursuant to the California Finance Lenders Law, Division 9 (commencing with Section 22000) of the Financial Code.</span>
<br>

</td>


<td>
<span style="font-size:7px;">Si queda algÃºn dinero (excedente), se lo pagaremos a menos que tengamos que pagarlo a otra persona que tenga un gravamen subordinado o gravamen del vehÃ­culo segÃºn lo permita la ley. Si nos queda un saldo pendiente, usted promete pagarlo cuando hagamos la demanda. DespuÃ©s de que aceleremos el saldo de capital impago, pagarÃ¡ intereses sobre lo que aÃºn nos debe al tipo de cargo financiero que se muestra en este Acuerdo hasta que nos pague todo lo que debe o hasta que se dicte un fallo a nuestro favor. Nuestros recursos son acumulativos y si tomamos cualquier medida, no consideraremos una renuncia o prohibiciÃ³n en contra de que tomemos ninguna otra medida.</span>
<br>

<b style="font-size:8px;">â€¢Extensiones o Aplazamientos:</b><span style="font-size:7px;">De vez en cuando, podemos acordar extender o diferir los pagos o montos que nos debe. Si lo hacemos, dicha prÃ³rroga o aplazamiento no significa que debamos extender o diferiremos cualquier otro pago y no afecta su responsabilidad por lo que debe. Nos reservamos el derecho de cobrar una tarifa de $ 50.00 por aplazamientos o extensiones.</span>
<br>
<b style="font-size:8px;">â€¢Valor Predeterminado:</b><span style="font-size:7px;">Si no realiza su pago, estarÃ¡ en incumplimiento de este Acuerdo. TambiÃ©n estarÃ¡ en incumplimiento de este Acuerdo si: (1) nos proporcionÃ³ informaciÃ³n falsa en relaciÃ³n con este prÃ©stamo: (2) no cumple con sus promesas o no cumple con sus obligaciones en virtud de este Acuerdo; (3) usted muere y no hay coprestatario sobreviviente; (4) usted se declara insolvente o presenta una peticiÃ³n de quiebra o se llena una peticiÃ³n de quiebra en su contra; o (5) el vehÃ­culo es robado, daÃ±ado, destruido, incautado, incautado, confiscado o perdido.</span>
<br>

<b style="font-size:8px;">â€¢Poder Notarial:</b><span style="font-size:7px;">Hasta que nos haya pagado todo lo que nos debe. Por la presente, nos designa a nosotros, y a cualquiera de nuestros funcionarios o empleados designados, como su apoderado, con pleno poder de sustituciÃ³n, para firmar a su nombre todas y cada una de las solicitudes de certificado de propiedad para asegurar nuestro derecho de retenciÃ³n en el vehÃ­culo, y cualquier declaraciÃ³n jurada o el certificado de propiedad para transferir y transmitir el tÃ­tulo o nuestro interÃ©s en el vehÃ­culo.</span>
<br>
<b style="font-size:8px;">â€¢RegulaciÃ³n B:</b><span style="font-size:7px;">al proporcionarnos su telÃ©fono celular o nÃºmero de telÃ©fono inalÃ¡mbrico, usted acepta expresamente recibir nuestras llamadas telefÃ³nicas y mensajes de texto con respecto a su prÃ©stamo, incluidas las llamadas para cobrar lo que debe. Las llamadas en vivo pueden ser realizadas por uno de nuestros empleados; Las llamadas tambiÃ©n pueden realizarse mediante un mensaje de voz o de texto marcado previamente pregrabado. Su consentimiento cubre todo tipo de llamadas. No le cobramos tales llamadas. Su proveedor de servicios inalÃ¡mbricos le cobrarÃ¡ por nuestras llamadas entrantes y mensajes de texto de acuerdo con su plan.</span>
<br>
<b style="font-size:8px;">â€¢Confidencialidad:</b><span style="font-size:7px;">Informaremos su historial de pagos con el prestamista a las agencias informantes y a otras personas que legalmente puedan recibir esa informaciÃ³n. Al firmar este Acuerdo, renuncia a la confidencialidad segÃºn las disposiciones de la SecciÃ³n 1808.21 del CÃ³digo de VehÃ­culos de California. TambiÃ©n nos autoriza a obtener del Departamento de VehÃ­culos Motorizados de California su direcciÃ³n de residencia actual en cualquier momento durante el plazo de su prÃ©stamo hasta que se nos pague la totalidad.</span>
<br>
<b style="font-size:8px;">â€¢Ley vigente:</b><span style="font-size:7px;">este prÃ©stamo se rige por la ley de California. Este prÃ©stamo no estÃ¡ sujeto al lÃ­mite de usura de California, Cal. Const. art XV, SecciÃ³n 1. Si el Monto total del prÃ©stamo es un monto principal de buena fe de mÃ¡s de $ 2,500.00. Este prÃ©stamo no estÃ¡ sujeto a las limitaciones de la tasa en la Ley de prestamistas financieros de California. Este prÃ©stamo se otorga de conformidad con la Ley de prestamistas financieros de California, DivisiÃ³n 9 (a partir de la SecciÃ³n 22000) del CÃ³digo financiero.</span>
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

$file_name = $id."page_5";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>