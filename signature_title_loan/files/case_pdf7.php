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
<span style="font-size:8px;">In the event of any loss or damage to the vehicle, I will immediately notify the Lender in writing and file a proof of loss with the insurer. The Lender may file proof of loss on my behalf if I fall or refuse to do so. The Lender may endorse my name to any check, draft or other instrument the Lender receives in payment of an insurance loss or return insurance premiums. The Lender may apply any insurance proceeds you receive to repair or replace the vehicle if, it is economically feasible, and I am not them in default under this Agreement.</span>
<br><br>
<b style="font-size:8px;">H.LENDER’S RIGHT IF I BREAK MY PROMISES ABOUT THE SECURITY INTEREST, VEHICLE OR INSURANCE:</b><span style="font-size:8px;">If I fail to pay the filing fees, taxes or amount necessary to keep the vehicle in good condition and repair you may if you choose advance the sums necessary to protect your interest.<br> If I fail to keep in force the required insurance and/or fail to provide evidence of such insurance to you, you may notify me that I should purchase the required insurance at my expense. If I fail to purchase the insurance within the time stated in the and/or fail to provide evidence of such insurance to you, you may purchase coverage under Lender’s Collateral Protection Policy to protect your interest in the balance due under this Agreement, to the extent permitted by applicable law, and charge me the cost of the premiums and any other amounts you incur in purchasing the insurance. THE INSURANCE YOU PURCHASE MAY BE SIGNIFICANTLY MORE EXPENSIVE AND PROVIDE ME LESS COVERAGE THAN INSURANCE I COULD PURCHASE MYSELF.
<br>
If permitted by applicable law, any sums you advance will be payable by me, as you alone may direct. 
<br>
If you advance any amounts on my behalf, it will not cure my default. The rights stated in this section are in addition to your rights stated in other sections of this Agreement for my failure to keep my promises to you.
<br>
You may charge reasonable compensation for the services which you provide in obtaining any required insurance on my behalf. The required insurance may be obtained through a licensed insurance agency affiliated with you. This agency will receive a fee for providing the required insurance. In addition, an affiliate may be responsible for some or all the underlying insurance risks and may receive compensation for assuming such risks.
</span>
<br>
<b style="font-size:8px;">I.DEFAULT:</b><span style="font-size:8px;">I will be in “Default” on this agreement if any one or more of the following things happen<br>
(1)	I do not make any payments on or before the day it is due;<br>
(2)	I do not keep any promise made in this Agreement;<br>
(3)	I do not keep any promises I made in another contract, not, loan or agreement with the Lender;<br>
(4)	I committed any forgery on connection with Agreement;<br>
(5)	The vehicle is lost, stolen, destroyed or damaged beyond economical repair and not fixed or found within 
reasonable time;<br>
(6)	I take the vehicle outside the United States without the written consent the Lender;<br>
(7)	I file bankruptcy or insolvency proceedings or anyone file bankruptcy or insolvency proceedings against me;<br>
(8)	I do something that cause the vehicle to be subject to	 confiscation by government authorities;<br>
(9)	I use the vehicle or allow someone else to use it in a way that causes it not to be covered by insurance;<br>


</span>
</td>


<td>
<span style="font-size:8px;">En caso de pérdida o daño al vehículo, notificaré inmediatamente al prestamista por escrito y presentaré un comprobante de pérdida al asegurador. El prestamista puede presentar una prueba de pérdida en mi nombre si me caigo o me niego a hacerlo. El Prestamista puede endosar mi nombre a cualquier cheque, giro u otro instrumento que el Prestamista reciba para pagar una pérdida de seguro o devolver las primas del seguro. El Prestamista puede aplicar cualquier producto del seguro que reciba para reparar o reemplazar el vehículo si es económicamente factible y no estoy en incumplimiento de conformidad con este Acuerdo.</span>
<br><br>
<b style="font-size:8px;">H.DERECHO DEL PRESTAMISTA SI ROMPIO MIS PROMESAS SOBRE EL INTERÉS DE SEGURIDAD, EL VEHÍCULO O EL SEGURO:</b><span style="font-size:8px;">Si no pago las tarifas de presentación, los impuestos o la cantidad necesaria para mantener el vehículo en buenas condiciones y repararlo, si elige adelantar las sumas necesarias para proteger su interesar.<br> Si no mantengo en vigencia el seguro requerido y / o no le proporciono evidencia de dicho seguro, puede notificarme que debo comprar el seguro requerido a mi cargo. Si no compro el seguro dentro del tiempo establecido en el documento y / o no le proporciono evidencia de dicho seguro, puede comprar cobertura bajo la Política de protección colateral del prestamista para proteger su interés en el saldo adeudado en virtud de este Acuerdo, en la medida permitido por la ley aplicable y cobrarme el costo de las primas y cualquier otro monto en el que incurra al comprar el seguro. EL SEGURO QUE COMPRA PUEDE SER SIGNIFICATIVAMENTE MÁS CARO Y PROPORCIONARME MENOS COBERTURA QUE EL SEGURO PODRÍA COMPRARME MISMO.
<br>
Si lo permite la ley aplicable, cualquier cantidad que adelante será pagadera por mí, como usted solo puede ordenar. 
<br>
Si adelantas cualquier cantidad en mi nombre, no se subsanará mi incumplimiento. Los derechos establecidos en esta sección son adicionales a los derechos establecidos en otras secciones de este Acuerdo por mi incumplimiento de mis promesas.
<br>
Puede cobrar una compensación razonable por los servicios que proporciona al obtener cualquier seguro requerido en mi nombre. El seguro requerido se puede obtener a través de una agencia de seguros con licencia afiliada a usted. Esta agencia recibirá una tarifa por proporcionar el seguro requerido. Además, un afiliado puede ser responsable de algunos o todos los riesgos de seguro subyacentes y puede recibir una compensación por asumir dichos riesgos.
</span>
<br>
<b style="font-size:8px;">I.PREDETERMINADO:</b><span style="font-size:8px;">Estaré en "Predeterminado" en este acuerdo si ocurre una o más de las siguientes cosas:<br>
(1)  No hago ningún pago el día de vencimiento o antes;<br>
(2)  No cumplo ninguna promesa hecha en este Acuerdo;<br>
(3)  No cumplo ninguna promesa que hice en otro contrato, no en un préstamo o acuerdo con el Prestador;<br>
(4) Cometí cualquier falsificación en relación con el Acuerdo;<br>
(5) El vehículo se pierde, se lo roban, se destruye o se daña más allá de una reparación económica y no se repara ni se encuentra dentro tiempo razonable;<br>
(6) Tomo el vehículo fuera de los Estados Unidos sin el consentimiento por escrito del prestamista;<br>
(7) Presento un procedimiento de quiebra o insolvencia o cualquier persona presenta un procedimiento de quiebra o insolvencia en mi contra;<br>
(8) Hago algo que hace que el vehículo esté sujeto a confiscación por parte de las autoridades gubernamentales;<br>
(9) Uso el vehículo o permito que otra persona lo use de manera que no esté cubierto por el seguro;


</span>
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

$file_name = $id."page_8";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>