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

<br><br><br><br>
<table style="border-collapse:separate;border-spacing: 12px 0;" >
<tbody>
<tr>

<td>
<span style="font-size:8px;">

Each party shall be responsible for its own Attorney, expert and other fees, unless awarded by the arbitrator under applicable law. If the chosen arbitration organization’s rules conflict with this cause, then, the provisions of this cause shall control. The arbitrator’s award shall be final and binding on all parties, except that in the event the arbitrator’s award for a party is $0 or against a party is in excess of $100.000 or includes an award of injunctive relief against a party, that party may request a new arbitration under the rules of the arbitration organization by a three-arbitrator panel. The appealing party requesting new arbitration shall be responsible for the filling fee and other arbitration costs subject to a final determination by the arbitrators of a fair apportionment of cost. Any arbitration under this Arbitration Clause shall be governed by Federal Arbitration Act (9 U.S.C. 1 et. Seq.) and not by any state law concerning arbitration.<br>
You and Lender retain any rights to self-help remedies, such as repossession, you and Lender retain the right to seek remedies in small claims court for disputes or claims within the court’s jurisdiction, unless such action is transferred, removed or appealed to a different court. Neither you nor Lender waive the right to arbitrate by using self-help remedies or filling suit. Any court having jurisdiction may enter judgment on the arbitrator’s award. This clause shall survive any termination, payoff or transfer of this contract. If any part of this arbitration clause is deemed or found to be unenforceable for any reason, the reminder shall remain enforceable. If a waiver of class actions rights is deemed or found to be unenforceable for any reason in a case in which class action allegations have been made; the remainder of this arbitration clause shall be enforceable.


</span>


<br><br><br><br><br>

<span style="font-size:8px;">Borrower’s Signature / Firma del Prestatario:</span>
<br><br>
X____________________________________      
<br><br>
<span style="font-size:8px;">Co-Borrower’s Signature / Firma del Co-Prestatario:</span>
<br><br>
X_____________________________________





</td>





<td>
<span style="font-size:8px;">Cada parte será responsable de su propio abogado, experto y otros honorarios, a menos que el árbitro lo otorgue de conformidad con la ley aplicable. Si las reglas de la organización de arbitraje elegida entran en conflicto con esta causa, las disposiciones de esta causa prevalecerán. El laudo del árbitro será definitivo y vinculante para todas las partes, excepto que en el caso de que el laudo del árbitro para una parte sea de $ 0 o contra una parte sea superior a $ 100,000 o incluya una adjudicación de medidas cautelares contra una parte, esa parte puede solicitar un nuevo arbitraje bajo las reglas de la organización de arbitraje por un panel de tres árbitros. La parte apelante que solicite un nuevo arbitraje será responsable de la tarifa de tramitación y otros costos de arbitraje sujetos a una determinación final por parte de los árbitros de una distribución equitativa del costo. Cualquier arbitraje bajo esta Cláusula de Arbitraje se regirá por la Ley Federal de Arbitraje (9 U.S.C.1 y siguientes) y no por ninguna ley estatal sobre arbitraje.<br>
Usted y el Prestamista conservan cualquier derecho a remedios de autoayuda, como la recuperación, usted y el Prestamista se reservan el derecho de buscar remedios en el tribunal de reclamos menores por disputas o reclamos dentro de la jurisdicción del tribunal, a menos que dicha acción sea transferida, eliminada o apelada a otra Corte. Ni usted ni el prestamista renunciar al derecho de arbitraje mediante el uso de remedios de autoayuda o llenar el traje. Cualquier tribunal que tenga jurisdicción puede emitir un fallo sobre el laudo del árbitro. Esta cláusula sobrevivirá a cualquier terminación, pago o transferencia de este contrato. Si alguna parte de esta cláusula de arbitraje se considera o se considera que no se puede hacer cumplir por algún motivo, el recordatorio seguirá siendo ejecutable. Si se considera o se considera que una renuncia a los derechos de las acciones de clase es inaplicable por cualquier motivo en un caso en el que se han realizado acusaciones de acción de clase; El resto de esta cláusula de arbitraje será exigible.


</span>

<br><br><br>
<span style="font-size:8px;">Date/Fecha:</span>
<br><br>
      
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

$file_name = $id."page_12";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>