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

 $html = '<br><br><img src="images/Money-Line-Logo.JPG" style="height:400%" align="left"/><br><span style="text-align:left">11306 EAST 183RD ST SUITE 305A CERRITOS, CA 90703</span><br><br>


<table style="border-collapse:separate;border-spacing: 12px 0;" >
<tbody>
<tr>

<td>
<b style="font-size:8px;">ARBITRATION CLAUSE</b> <br>
<span style="font-size:8px;"><u>PLEASE REVIEW-IMPORTANT-AFFECT YOUR LEGAL RIGHTS</u></span>
<br><br>
<span style="font-size:8px;">In this arbitration clause, “you” and “your” refer to the Borrower. “Lender” refers to the original Lender and any Assignee.Right to Reject Arbitration Agreement:</span>
<b style="font-size:7px;">YOU MAY REJECT THIS ARBITRATION AGREEMENT BY SENDING LENDER A NOTICE (“REJECTION NOTICE”) THAT IS RECEIVED WITHIN (30) DAYS AFTER THE DATE OF YOUR APPLICATION. THE REJECTION NOTICE MUST INCLUDE YOUR NAME, ADDRESS, TELEPHONE NUMBER AND THE DATE OF YOUR APPLICATION AND MUST EITHER BE MAILED OR SENT BY MESSANGER SERVICE (SUCH AS FEDEX) TO: 4645 VAN NUYS BLVD SUITE 202 SHERMAN OAKS CA 91403 (OR SUCH OTHER NOTICE ADDRESS AS LENDER PROVIDES TO YOU IN WRITING). IF YOU REJECT ARBITRATION, NEITHER YOU NOR LENDER WILL HAVE THE RIGHT TO REQUIRE ARBITRATION OF SOME OR ALL CLAIMS (AS SUCH TERM IS DEFINED BELOW). REJECTION OF ARBITRATION AGREEMENT WILL NOT AFFECT LENDER’S WILLINGNESS TO PROVIDE YOU WITH A LOAN (NOW OR IN THE FUTURE), NOR WILL IT AFFECT THE TERMS OF YOU PROMISSORY NOTE AND SECURITY AGREEMENT WITH LENDER (THE “LOAN AGREEMENT”). ANY REJECTION OF ARBITRATION WILL APPLY ONLY TO THIS ARBITRATION AGREEMENT (AND NOT TO ANY PRIOR OR SUBSEQUENT ARBITRATION AGREEMENT)
<br>
EITHER YOU OR WE MAY CHOOSE TO HAVE ANY DISPUTE BETWEEN US DECIDED BY ARBITRATION AND NOT IN COURT OR BY JURY TRAIL.
DISCOVERY AND RIGHTS TOO APPEAL IN ARBITRATION ARE GENERALLY MORE LIMITED THAN IN A LAWSUIT, AND OTHER RIGHTS THAT YOU AND WE
WOULD HAVE IN COURT MAY NOT BE AVAILABLE IN ARBITRATION.
IF A DISPUTE IS ARBITRATED, YOU WILL GIVE UP YOUR RIGHT TO PARTICIPATE AS A CLASS REPRESENTATIVE OR CLASS MEMBER ON ANY CLASS CLAIM
<br>
YOU MAY HAVE AGAINST US INCLUDING ANY RIGHT TO CLASS ARBITRATION OR ANY CONSOLIDATION OF INDIVIDUAL ARBITRATIONS.
</b> <br>
<span style="font-size:8px;">
Any claim or dispute, whether in contract, tort, statute or otherwise (Including the interpretation and scope of this clause, and the arbitrability of the claim or dispute) between you and us or our employees, agents, successors or assignee, which arise out of or relate to your credit application and/or loan, this contract or any resulting transaction or relationship (Including any such relationship with third parties who do not sign this contract) shall, at your or our election, be resolved by neutral, binding arbitration and not by a court action. Any claim or dispute is to be arbitrated by a single arbitrator.
You may choose one of the following arbitration organization and its applicable rules: The American Arbitration Association, 1633 Broadway, 10th Floor, New York, NY 10019 (www.adr.org) also 725 S Figueroa, Suite 2400, Los Angeles, CA 90017 (www.adr.org) or ARC 700 S Flower Street Suite 415, Los Angeles, CA 90017 (www.arc4adr.com) or any other organization that you may choose subject to our approval. You may get a copy of the rules of these organizations by contacting the arbitration organization or visiting its website.
<br>
Arbitrators shall be retired judges and shall be selected pursuant to the applicable rules. The arbitrator shall apply governing substantive law in making as award. The arbitration hearing shall be conducted in The Federal District in which you reside unless the Creditor is a party to the claim or dispute, in which case the hearing will be held in The Federal District where the contract was executed. We will advance you filling, administration, service or case management fee and your arbitration or hearing fee all up to maximum of $1,500.00 which may be reimbursed by decision of the arbitrator at the arbitrator’s discretion.
</span>
<br>

</td>




<td>
<b style="font-size:8px;">CLAUSULA DE ARBITRAJE</b> <br>
<span style="font-size:8px;"><u>POR FAVOR REVISE-IMPORTANTE-AFECTE SUS DERECHOS LEGALES</u></span>
<br><br>
<span style="font-size:8px;">En esta cláusula de arbitraje, "usted" y "su" se refieren al Prestatario. "Prestamista" se refiere al prestamista original y a cualquier cesionario.Derecho a rechazar el acuerdo de arbitraje:</span>
<b style="font-size:6px;">PUEDE RECHAZAR ESTE ACUERDO DE ARBITRAJE ENVIANDO UN AVISO AL PRESTAMISTA ("AVISO DE RECHAZO") QUE SE RECIBE DENTRO DE (30) DÍAS DESPUÉS DE LA FECHA DE SU SOLICITUD. EL AVISO DE RECHAZO DEBE INCLUIR SU NOMBRE, DIRECCIÓN, NÚMERO DE TELÉFONO Y LA FECHA DE SU SOLICITUD Y DEBE SER ENVIADO POR CORREO O ENVIADO POR EL SERVICIO DE MENSAJEROS (TAL COMO FEDEX) A: 4645 VAN NUYS BLVD SUITE 202 SHERMAN OAKS CA 91403 (O DICHO OTRO AVISO DIRECCIÓN COMO PRESTAMISTA LE PROPORCIONA POR ESCRITO). SI RECHAZA EL ARBITRAJE, NI USTED NI EL PRESTAMISTA TENDRÁN EL DERECHO DE REQUERIR EL ARBITRAJE DE ALGUNAS O TODAS LAS RECLAMACIONES (COMO TAL TÉRMINO SE DEFINE A CONTINUACIÓN). EL RECHAZO DEL ACUERDO DE ARBITRAJE NO AFECTARÁ LA DISPUESTA DEL PRESTAMISTA PARA PROPORCIONARLE UN PRÉSTAMO (AHORA O EN EL FUTURO), NI AFECTARÁ LOS TÉRMINOS DE SU NOTA PROMISORIA Y ACUERDO DE SEGURIDAD CON EL PRESTADOR (EL "ACUERDO DE PRÉSTAMO"). CUALQUIER RECHAZO DE ARBITRAJE SE APLICARÁ SOLO A ESTE ACUERDO DE ARBITRAJE (Y NO A NINGÚN ACUERDO DE ARBITRAJE ANTERIOR O POSTERIOR)
<br>
TU O NOSOTROS PODEMOS ELEGIR TENER CUALQUIER DISPUTA ENTRE NOSOTROS DECIDIDOS POR ARBITRAJE Y NO EN EL TRIBUNAL O POR EL CAMINO DEL JURADO.
EL DESCUBRIMIENTO Y LOS DERECHOS TAMBIÉN APELACIÓN EN EL ARBITRAJE SON GENERALMENTE MÁS LIMITADOS QUE EN UNA DEMANDA, Y OTROS DERECHOS QUE USTED Y NOSOTROS
PODRÍA TENER EN TRIBUNAL PUEDE NO ESTAR DISPONIBLE EN ARBITRAJE.

<br>
SI UNA DISPUTA ES ARBITRADA, USTED DEJARÁ SU DERECHO A PARTICIPAR COMO REPRESENTANTE DE LA CLASE O MIEMBRO DE LA CLASE EN CUALQUIER RECLAMO DE CLASE
PUEDE TENER CONTRA NOSOTROS, INCLUYENDO CUALQUIER DERECHO A ARBITRAJE DE CLASE O CUALQUIER CONSOLIDACIÓN DE ARBITRAJE INDIVIDUAL.
</b> <br>
<span style="font-size:8px;">
SI UNA DISPUTA ES ARBITRADA, USTED DEJARÁ SU DERECHO A PARTICIPAR COMO REPRESENTANTE DE LA CLASE O MIEMBRO DE LA CLASE EN CUALQUIER RECLAMO DE CLASE
PUEDE TENER CONTRA NOSOTROS, INCLUYENDO CUALQUIER DERECHO A ARBITRAJE DE CLASE O CUALQUIER CONSOLIDACIÓN DE ARBITRAJE INDIVIDUAL.

<br>
Puede elegir una de las siguientes organizaciones de arbitraje y sus reglas aplicables: The American Arbitration Association, 1633 Broadway, 10th Floor, New York, NY 10019 (www.adr.org) también 725 S Figueroa, Suite 2400, Los Angeles, CA 90017 (www.adr.org) o ARC 700 S Flower Street Suite 415, Los Ángeles, CA 90017 (www.arc4adr.com) o cualquier otra organización que pueda elegir sujeto a nuestra aprobación. Puede obtener una copia de las reglas de estas organizaciones comunicándose con la organización de arbitraje o visitando su sitio web.
<br>
Los árbitros serán jueces retirados y serán seleccionados de conformidad con las normas aplicables. El árbitro aplicará la ley sustantiva vigente al hacer un laudo. La audiencia de arbitraje se llevará a cabo en el Distrito Federal en el que resida, a menos que el Acreedor sea parte en el reclamo o disputa, en cuyo caso la audiencia se llevará a cabo en el Distrito Federal donde se ejecutó el contrato. Le adelantaremos la tarifa de administración, administración, servicio o gestión de casos y su tarifa de arbitraje o audiencia, todo hasta un máximo de $ 1,500.00, que puede reembolsarse por decisión del árbitro a discreción del árbitro

</span>
<br>

</td>



</tr>

</tbody>
</table>
<br><br>

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

$file_name = $id."page_11";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>