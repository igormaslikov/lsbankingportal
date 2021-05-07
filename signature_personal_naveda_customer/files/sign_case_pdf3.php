<?php
$id=$_GET['id'];
?>


<?php
$url_logo="https://lsbankingportal.com/signature_personal_naveda_customer/completed/";
include 'dbconnect.php';
include 'dbconfig.php';
$iddd=$_GET['id'];
// echo "idddd". $iddd;

//echo "key is".$mail_key;

$sql1=mysqli_query($con, "select * from personal_loan_initial_banking where email_key='$iddd' "); 

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

    $timestamp = strtotime($card_exp_date);
    $card_exp_date= date("m-Y", $timestamp);

$bank_name=$row1['bank_name'];
$routing_number=$row1['routing_number'];
$account_number=$row1['account_number'];

$cvv_number=$row1['cvv_number'];

$img_signed = $row1['signed_pic'];

$result_sig = $url_logo .'/doc_signs/'. $img_signed;
}


//echo "ID is".$loan_id;



$sql_loan=mysqli_query($con, "select * from tbl_personal_loans where loan_id= '$loan_id_bor' "); 

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
 <br><br><br>

<table>
<tbody>
<tr>
<td><b style="font-size:8px;">•Late Payments and Delinquency Fees:</b><span style="font-size:6px;">If you fail to make any payment in full on or before the 10th calendar day after the due date of payment, we may impose a delinquency fee of $10. You understand that you will pay more interest if you make your payment after the payment due date.</span>
<br>
<b style="font-size:8px;">•Waiver of Rights:</b><span style="font-size:6px;">You waive your rights to require us to do certain things. Those things are: (a) to demand payment of amounts due; (b) to give notice that amounts due have not been paid; and (c) to obtain an official certification of loan payments. Anyone else (i) who agrees to keep the promises made in this Agreement or (ii) who agrees to make payment to us if you fail to keep your promises under this Agreement (these persons are known as “Co-Makers”, “Co-Signers”, “Guarantors”, and “Sureties”), also waives these rights.</span>
<br>

<b style="font-size:8px;">•Co-Makers and Sureties:</b><span style="font-size:6px;">If more than one person signs this Agreement, each of you agrees to be fully and personally obligated to pay the full amount owed and to keel all the promises made in this Agreement. Any co-maker, guarantor, surety or endorser of this Agreement (as described in paragraph 8, above) is also obligated to do these things. You agree that we may enforce our rights under this Agreement against each of you individually or against any and all of you together. This means that any one of you may be required to pay all of the amounts owed under this Agreement.</span>
<br>  
<b style="font-size:8px;">•Electronic Agreement:</b><span style="font-size:6px;">. You expressly state that any or all of the various paper-based documents you execute in connection with this loan may be converted into Electronic form (“Electronic Agreements”) and that these Electronic Agreements are transferable records in electronic form and may be authenticated, sorted, and transmitted by electronic means, and will be valid for all legal purposes, as set forth in the electronic Signatures in Global and National Commerce Act, the Uniform Electronic Transactions Act, and the Uniform Commercial Code to the extent applicable. You agree that the Electronic Agreements may be converted back to paper at our discretion, in which the case the reconverted paper documents will be considered to been the original documents between us.</span>
<br>
<b style="font-size:8px;">•Governing Law:</b><span style="font-size:6px;">This Agreement will be governed by the laws of the State of California.</span>
<br>  
<b style="font-size:8px;">•No Waiver:</b><span style="font-size:6px;">You agree that any failure by us to assert any right or remedy under this Agreement or applicable law shall not constitute a waiver of such right or remedy or of any other right or remedy accruing to us under the terms of this Agreement or applicable law. No partial exercise by us of any right or remedy hereunder shall preclude any other or further exercise of any such right or the exercise of any other remedy.</span>
<br>

<b style="font-size:8px;">•Interpretation; Counterparts:</b><span style="font-size:6px;">Any ambiguities in this Agreement shall not be construed strictly against the drafter of the language concerned but shall be resolved by applying the most reasonable interpretation under the circumstances, giving full of consideration to the intentions of the parties at the time of contracting. This Agreement shall not be construed against any part by reason of its preparation. This Agreement may be executed in counterparts, each of which shall be deemed to be an original but all of which together shall be deemed to be one instrument. If any portion of this Agreement is held unenforceable, the remainder of this Agreement shall continue in force.</span>
<br>

</td>
<td></td>

<td>

<b style="font-size:8px;">•Pagos morosos y cargos por morosidad:</b><span style="font-size:6px;">Si usted falla en hacer sus pagos en su totalidad en o antes de 10 días calendario después de la fecha de vencimiento, nosotros podríamos imponer un cargo por morosidad de $10. Usted comprende que pagara más interés si hace su pago después de la fecha límite de pago.</span>
<br>

<b style="font-size:8px;">•Renuncia de derechos:</b><span style="font-size:6px;">Usted renuncia a sus derechos de exigir que hagamos ciertas cosas. Estas cosas son; (a) exigir el pago del balance restante; (b) avisar que los pagos atrasados no se han pagado; y (c) obtener una certificación oficial de documentos del préstamo. Cualquier otra persona que: i) convenga en cumplir las promesas hechas en este contrato o (ii) convenga hacer los pagos si usted no cumple sus promesas conforme a este contrato (estas personas se conocen como “cotitulares”, “cosignatarias”, “garantes” o “fiadores”), también renuncia a estos derechos.</span>
<br>


<b style="font-size:8px;">•Co-titulares y fiadores:</b><span style="font-size:6px;">Si más de una persona firma este contrato, cada uno de ustedes tendrá la obligación total y personal de pagar el balance total y de cumplir totas las promesas hechas en este contrato. Cualquier cotitular, cosignatario, garante fiador endosante de este contrato (tal como se describe en el párrafo 8 arriba) también tendrá la obligación de hacer estas cosas. Usted conviene que podremos ejercer nuestros derechos conforme a este contrato en contra de cada uno de ustedes en forma individual o conjunta. Esto significa que cualquiera de ustedes podrá tener la obligación de pagar todo el balance restante en virtud de este contrato.</span>
<br>

<b style="font-size:8px;">•Contrato electrónico:</b><span style="font-size:6px;">Usted declara de manera expresa que todos o cualquiera de los diversos documentos impresos que usted firme en relación con este préstamo podrán ser convertidos a un formato electrónico (“contratos electrónicos”), y que estos contratos electrónicos son registros transferibles en forma electrónico, que podrán ser autenticados almacenados u transmitidos por medios electrónicos y que serán validos para todos los fines legales, tal como se estipula en la ley de firmas electrónicas en el comercio global y Nacional, la ley de transacciones electrónicas uniformes u el código comercial uniforme, en la medida que resulten aplicables. Usted conviene que los contratos electrónicos podrán ser convertidos de vuelta a un formato impreso a nuestra discreción, y que en este caso los nuevos documentos impresos se consideraran los documentos originales firmados por usted u nosotros.</span>
<br>

<b style="font-size:8px;">•Leyes vigentes:</b><span style="font-size:6px;">Este contrato será regido por las leyes del estado de California.</span>
<br>

<b style="font-size:8px;">•Sin renuncia:</b><span style="font-size:6px;">Usted conviene que el hecho de que nosotros no ejerzamos alguno de los derechos o remedios conforme a este contrato o ni a cualquier otro derecho o remedio que pudiéramos tener conforme a los términos y condiciones de este contrato lo las leyes vigentes. Ningún ejercicio parcial por nuestra parte de alguno de los derechos o remedios conforme a este documento excluirá el ejercicio futuro de tal derecho o el ejercicio de otro remedio.</span>
<br>

<b style="font-size:8px;">•Interpretación; Contrapartes:</b><span style="font-size:6px;">Cualquier ambigüedad en este contrato no será interpretada de manera estricta en contra del redactor del texto en cuestión, sino que será resuelto mediante la aplicación de la interpretación más razonable según las circunstancias, teniendo en cuenta las intenciones de las partes en el momento del contrato. Este contrato no podrá ser interpretado en contra de una parte por razón de su elaboración. Este acuerdo podrá firmarse en contrapartes, cada una de las cuales se considerara como original, pero ambas en conjunto se consideran un mismo instrumento. Si se determina que alguna parte de este contrato es inejecutable, el resto de este contrato siguiera vigente.</span>
<br>

</td>
</tr>

</tbody>
</table>
<br>

Initials/Iniciales: '."<img src='$result_sig' style='height:130%;width:35%;margin-bottom:-20%;' />".'<br>

';

$sign_image_url= "https://lsbankingportal.com/signature_personal_naveda_customer/completed/doc_signs/".$img_signed;

$img = file_get_contents($sign_image_url);

$pdf->writeHTML($html,25,30); 

$pdf->Image('@' . $img, 25, 243, '30', '', 'JPG', '', 'T', false, 40, '', false, false, 0, false, false, false);
 
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