<?php
$id=$_GET['id'];
$url_logo="http://lsbankingportal.com/signature_commercial_loan/completed/";

include $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

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
 
 $sql_loan_settings=mysqli_query($con, "select * from tbl_loan_setting where loan_amount= '$amount_of_loan'"); 

while($row_loan_settings = mysqli_fetch_array($sql_loan_settings)) {

$loan_fee=$row_loan_settings['loan_fee'];
$loan_payable=$row_loan_settings['payoff_amount'];
}
 
   $calculation = (($loan_fee/$amount_of_loan)/($datediff/365) * 10000) / 100;
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
   
   $sql_installment=mysqli_query($con, "select * from tbl_commercial_loan_installments where loan_create_id=$loan_id_bor"); 
while($row_installment = mysqli_fetch_array($sql_installment)) {
$payment_install=$row_installment['payment'];
$payment_date_install=$row_installment['payment_date'];
  $timestampp = strtotime($payment_date_install);
  $payment_date_installl= date("m-d-Y", $timestampp);
 $payment_install=number_format($payment_install, 2);

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

  $html = '<br><br><img src="images/Money-Line-Logo.JPG" style="height:400%" align="left"/><br><span style="text-align:left">4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403</span><br><br>
 
<b>Honorarios de abogados; Gastos: </b>El prestamista puede pagar aquí o pagar a otra persona para que le ayude a cobrar este Pagare de Prestamo Comercial si el prestatario no paga. El prestatario le pagará al prestamista ese monto. Esto incluye, sujeto a cualquier límite bajo la ley aplicable, los honorarios del abogado del prestamista y los gastos legales del prestamista, ya sea que exista o no una demanda, incluidos los honorarios del abogado, los gastos por procedimientos de bancarrota (incluidos los esfuerzos para modificar o desocupar una suspensión o mandato judicial), y apelaciones. El prestatario también pagará los costos judiciales, además de todas las demás sumas previstas por la ley.
<br>

<b>Ley vigente : </b>Este Pagare de Prestamo Commercial se regirá por la ley del prestamista de California aplicable al prestamista y, en la medida en que no esté precedida por la ley federal, sin tener en cuenta sus disposiciones sobre conflictos de leyes. Este Pagare de Prestamo Commercial ha sido aceptado por el prestatario y el prestamista en el Estado de California.
<br>
<b>Elección del lugar : </b>Si hay una demanda, el prestatario acepta la solicitud del prestamista de someterse a la jurisdicción de los tribunales del condado de Los Ángeles, estado de California o, si es necesario, ante los tribunales del distrito central de California. Cualquier demanda presentada a continuación se archivará en el Palacio de Justicia de Van Nuys, o en la División Oeste del Distrito Central de California, según corresponda.
<br>


<b>Colateral : </b>Todo el inventario presente y futuro de ese negocio conocido como __________________________________________, así como todas las cuentas por cobrar.
<br>
<b>Garantía personal : </b>Este contrato tiene una garantía personal del prestatario y el co-prestatario en caso de que el negocio mencionado anteriormente cierre o sea vendido a otra persona otras personas.
<br>
<b>Pago en el lugar : </b>El prestamista queda autorizado para cobrar los pagos adeudados bajo este Pagare de Prestamo Commercial en la dirección física del prestatario, siendo: ____________________________________________________.
<br>

<b>Interés sucesor : </b>Los términos de este Pagare de Prestamo Commercial serán vinculantes para el prestatario y el prestamista, y para sus herederos, representantes personales y sucesores, y redundarán en beneficio de los mismos. 
<br><br>

<b>Disposiciones Generales : </b>: El prestamista puede retrasar o renunciar a la aplicación de cualquiera de sus derechos o recursos bajo este Pagare de Prestamo Commercial sin perderlos. Ante cualquier cambio en los términos de este Pagare de Prestamo Commercial, y a menos que se indique expresamente lo contrario por escrito, ninguna parte que firme este Pagare de Prestamo Commercial, ya sea como fabricante, garante, fabricante de alojamiento o endosante, quedará eximida de responsabilidad. Todas estas partes acuerdan que el Prestador puede renovar o extender (repetidamente y por cualquier período de tiempo) este préstamo o liberar a cualquier parte o garante; y tomar cualquier otra acción que el prestador considere necesaria sin el consentimiento o aviso de nadie. Todas estas partes también acuerdan que el prestamista puede modificar este préstamo sin el consentimiento o aviso de cualquier otra persona que sera la parte con la que se realiza la modificación. Las obligaciones bajo este Pagare de Prestamo Commercial son conjuntas y varias. 
<br><br>


<b>
PRIOR TO SIGNING THIS COMMERCIAL LOAN PROMISSORY NOTE, BORROWER READ AND UNDERSTOOD ALL THE PROVISIONS OF THIS COMMERCIAL LOAN PROMISSORY NOTE, INCLUDING THE INTEREST RATE PROVISIONS, BORROWER AGREES TO THE TERMS OF THE NOTE.
BORROWER ACKNOWLEDGES RECEIPT OF A COMPLETED COPY OF THIS COMMERCIAL LOAN PROMISSORY NOTE

</b>
<br><br>
Firma del Prestatario  :  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fecha: '.$payment_date_installl.'
<br><br>

Firma del Co-Prestatario :  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fecha : 
<br><br>

Firma Autorizada del Prestamista : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fecha : 



';

$sign_image_url= "http://lsbankingportal.com/signature_commercial_loan/completed/doc_signs/".$img_signed;

$img = file_get_contents($sign_image_url);

$pdf->writeHTML($html,25,30); 

$pdf->Image('@' . $img, 50, 207, '30', '', 'JPG', '', 'T', false, 40, '', false, false, 0, false, false, false);
 
$data_shipment  = ":";



$pdf->Ln();
$html = '<h1>LSBANKING </h1>';
$html_underline = '<b style="text-decoration:underline">PLEASE LEAVE THIS LABEL UNCOVERED.</b>';
// ---------------------------------------------------------

//Close and output PDF document

$pdf->Output('Case.pdf', 'I');

$pdf_data = ob_get_contents();

$file_name = $id."page_4";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>