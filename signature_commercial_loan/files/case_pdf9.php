<?php
$id=$_GET['id'];
$url_logo="http://lsbankingportal.com/signature_commercial_loan/completed/";

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

 $html = '
 <br><br>
<div style="display:inline-block">
	<img src="images/Money-Line-Logo.JPG" style="height:10%;clear: both" align="left"/>
</div>
<br><span style="text-align:left;width:100%"><b>4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403</b></span>
 <br><br><br>
Borrower Name/Nombre del Deudor: <span style="text-decoration:underline">'.$f_name.'</span><br><br>
&nbsp;&nbsp;Loan Number/Numero de Prestamo: <span style="text-decoration:underline">'.$loan_id_bor.'</span><br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date/Fecha: <span style="text-decoration:underline">'.$creation_date.'</span>
 <br><br><br>

<table>
<tbody>

<td style="text-align:justify;width:45%">

<b style="font-size:8px;">Interpretation of this Arbitration Agreement:</b><span style="font-size:6px;">if any art of this Arbitration Agreement other than the Class Action Waiver is found by a court or arbitrator to be unenforceable, the remainder shall be enforceable. If the Class Action Waiver is found by court or arbitrator to be unenforceable, the remainder of this arbitration agreement shall be unenforceable. This arbitration agreement shall survive the termination of any contractual agreement between you and us, whether by default or repayment in full.</span>
<br>
<b style="font-size:8px;">Statues of Limitations:</b><span style="font-size:6px;">All Statues of limitations that are applicable to any claim or dispute shall apply to any arbitration between you and us.</span>
<br>

<b style="font-size:8px;">Attorney’s Fees:</b><span style="font-size:6px;">the arbitrator may, but is not required to, award reasonable attorney’s fees to the prevailing party if allowed by statue or applicable law.</span>
<br>
<b style="font-size:8px;">Appeal Procedure:</b><span style="font-size:6px;">The arbitrator’s award shall be final and binding on all parties. There shall be limited right to appeal to the extent allowed by the Federal Arbitration Act. The amount we pay may be reimbursed in whole or in part by decision of the arbitration of the arbitrator rinds that any of your claims is frivolous.</span>
<br>

<b style="font-size:8px;">Small Claims Court:</b><span style="font-size:6px;">not withstanding any other provision of this Arbitration Agreement, either you or we shall retain the right to seek adjudication in Small Claims Court of any matter within its jurisdiction. Any matter not within the Small Claims Courts jurisdiction shall be resolved by arbitration as provided above. Any appeal from a Small Claims Court judgment shall be conducted, at the appellant’s option, either (a) in accordance with the provisions of sections 116.710-116.795 of the California Code of Civil Procedure, or (b0) in accordance with the Section of this Arbitration Agreement entitled “Appeal Procedure”.</span>
<br>
<b style="font-size:8px;">Counterparts:</b><span style="font-size:6px;">This Arbitration Agreement may be executed in counterparts, each of which shall be deemed to be an original but all of which together shall be deemed to be one instrument.</span>
<br>
<b style="font-size:8px;">Opt Out Procedure:</b><span style="font-size:6px;">YOU MAY CHOOSE TO OPT OUT OF THIS ARBITRATION AGREEMENT BY COMPLYING WITH THE FOLLOWING PROCESS. IF YOU DO NOT WISH TO BE SUBJET TO THIS ARBITRATION AGREEMENT, THEN YOU MUST NOTIFY US IN WRITING POSTMARKED WITHIN 60 CALENDER DAYS OF THE DATE OF THIS ARBITRATION AFREEMENT AT THE FOLLOWING ADDRESS: LS FINANCING, INC ATTN: ARBITRATION OPT OUT, 4645 VAN NUYS BOULEVARD SUITE 202, SHERMAN OAKS, CA 91403. YOUR WRITTEN NOTICE MUST INCLUDE YOUR NAME, ADDRESS, PHONE NUMBER, THE DATE OF THE LOAN AGREEMENT, THE DATE OF THIS ARBITRATION AGREEMENT AND A STATEMENT WTHAT YOU WISH TO OPT OUT OF THE ARBITRATION AGREEMENT. YOUR WRITTEN NOTICE MAY NOT BE SENT WITH ANY OTHER CORRESPONDENCE INDICATING YOUR DESIRE TO OPT OUT OF THIS ARBITRATION AGREEMENT IN ANY MANNER OTHER THAN AS PROVIDED HEREIN IN INSUFFICENT NOTIVE. YOUR DECISION TO OPT OUT OFTHIS ARBITRATION AGREEMENT WILL NOT AFFECT YOUR OTHER RIGHTS RESPONSIBILITIES UNDER THE LOAN AGREEMENT. YOUR DECISION TO OPT OUT OF THIS ARBITRATION AGREEMENT APPLIES ONLY TO THIS ARBITRATION AGREEMENT AND NOT TO ANY PRIOR OR SUBSEQUENT ARBITRATION AGREEMENTS TO WHICH YOU AND WE HAVE AGREED.</span>
<br><br><br><br><br><br><br><br>
 ________________________<br>
 Borrower Signature / Firma de deudor
<br><br>
_________________________<br>
Co-Borrower Signature / Firma de co-deudor

</td>
<td style="width:10%"></td>

<td style="vertical-align:baseline;text-align:justify;width:45%">

<b style="font-size:8px;">Idioma del arbitraje:</b><span style="font-size:6px;">Usted puede elegir que el arbitraje se lleve a cabo en español o en ingles. Si opta para que el arbitraje se conduzca en español, usted conviene en utilizar un foro de arbitraje que acepte proporcionar formas en español y un árbitro(s) que pueda (n) llevar a cabo el proceso de arbitraje en dicho idioma. Usted entiende que esto podría limitar sus opciones de foros de arbitraje, ya que no todos dichos foros en estado unidos ofrecen sus servicios en español.</span>
<br>
<b style="font-size:8px;">Interpretación de este acuerdo de arbitraje:</b><span style="font-size:6px;">Si un tribunal o un árbitro determina que cualquier porción de este acuerdo de arbitraje es inejecutable, aparte de la renuncia de acción de grupo, el resto si será ejecutable. Si un tribunal o árbitro determina que la renuncia de acción de grupo es inejecutable, el resto de este acuerdo de arbitraje no será ejecutable. Este acuerdo de arbitraje continuara en vigor tras el término de todo acuerdo contractual entre usted y nosotros, ya sea por incumplimiento o por reembolso total.</span>
<br>

<b style="font-size:8px;">Leyes de prescripción:</b><span style="font-size:6px;">Todas las leyes de prescripción aplicables a cualquier reclamación o disputa se aplicaran en todo arbitraje entre usted y nosotros.</span>
<br>
<b style="font-size:8px;">Honorarios de abogados:</b><span style="font-size:6px;">El arbitrio podrá otorgar honorarios razonables de abogados a la parte favorecida si así lo permiten las leyes vigentes pero no tendrá la obligación de hacerlo.</span>
<br>

<b style="font-size:8px;">Procedimiento de apelación:</b><span style="font-size:6px;">El fallo del árbitro será final y obligatorio para todas las partes. Habrá un derecho limitado para apelación en la medida permitida por la Ley Federal de Arbitraje. El monto que paguemos podrá ser reembolsado en su totalidad o en parte por decisión del árbitro si el árbitro determina que alguna de sus reclamaciones es frívola.</span>
<br>
<b style="font-size:8px;">Juzgado de Cuantía Menor:</b><span style="font-size:6px;">No obstante cualquier otra disposición de este acuerdo de arbitraje, las dos partes conservaran el derecho de buscar una resolución definitiva en in juzgado e cuantía menor sobre cualquier asunto dentro de su competencia. Cualquier asunto que no está dentro de la competencia del juzgado de cuantía menor será resuelto por el arbitraje, tal y como se ha dispuesto anteriormente. Toda apelación de una sentencia de un juzgado de Cuantía Menor se realizara a elección el apélate ya sea (a) de conformidad con las secciones 116.710 a 116.795 del código de procedimientos civiles de california, o (b) de conformidad con la sección de este acuerdo de arbitraje titulada “Procedimiento de Apelación”.</span>
<br>
<b style="font-size:8px;">Contrapartes:</b><span style="font-size:6px;">Este acuerdo de Arbitraje podrá ejecutarse en contrapartes, cada una de las cuales se considerara como original pero todas en conjunto se consideran un solo instrumento.</span>
<br>

<b style="font-size:8px;">Procedimiento de exclusion voluntario:</b><span style="font-size:6px;">USTED PUEDE EXCLUIRSE DEL PRESENTE ACUERDO DE ARBITRAJE SI CUMPLE CON EL SIGUIENTE PROCESO.SI USTED NO DESEA ESTAR SUJETO AL PRESENTE ACUERDO DE ARBITRAJE, ENTONCES DEBERA DE NOTIFICAR A NOSOTROS POR ESCRITO. EL SOBREW DEBERA LLEBAR EL SELLO DE CORREOS CON FECHA DENTRO DE LOS SESENTA (60) DIAS CALENDARIOS A LA FECHA DEL PRESENTE ACUERDO DE ARBITRAJE EN LA SIGUIENTE DIRECCION:LS FINANCING, INC ATTN: ARBITRATION OPT OUT, 4645 VAN NUYS BOULEVARD SUITE 202, SHERMAN OAKS, CA 91403. SU NOTIFICACION POR ESCRITO DEBERA INCLUIR SU NOMBRE, DOMICILIO, NUMERO TELEFONICO, LA FECHA DEL CONTRATO DE PRESTAMO, LA FECHA DE ESTE ACUERDO DE ARBITRAJE. SU NOTIFICACION POR ESCRITO NO PUEDE ENVIARSE JUNTO CON OTRA CORRESPONDENCIA. EL INDICAR SU DESEO DE SER EXCLUIDO DEL PRESENTE ACUERDO DE ARBITRAJE EN CUALQUIER MANERA DISTINTA A LA ESTIPULADA EN EL PRESENTE SE CONSIDERARA NOTIFICACION INSUFICIENTE. SU DECISION DE EXCLUIRSE DE; ACUERDO DE ARBITRAJE NO AFECTARA SUS OTROS DERECHOS O RESPONABILIDADES CONFORME AL CONTRATO DE PRESTAMO. SU DECISION DE EXCLUIRSE DEL ACUERDO DE ARRBITRAJE SOLO SE APLICA AL PRESENTE ACUERDO DE ARBITRAJE Y NO A NINGUN ACUERDODE ARBITAJE PREVIO O POSTERIOR ACORDADO ENTRE USTED Y NOSOTROS.</span>



</td>


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

// $file_name = $id."page_10";
// $path="Barcodes/".$file_name.".pdf";
// file_put_contents( $path, $pdf_data );

$file_name =$id. "page_10";
$path=dirname(__FILE__)."/Barcodes/".$file_name.".pdf";
$pdf->Output($path, 'FI');
//============================================================+
// END OF FILE
//============================================================+

?>