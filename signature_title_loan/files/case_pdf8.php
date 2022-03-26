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
<span style="font-size:8px;">(10) Another creditor tries to take the vehicle through legal process; or 
<br>
(11) I die, am convicted of a crime involving fraud or dishonesty or am found by a court with jurisdiction to do so to be incapacitated.

</span>
<br>
<b style="font-size:8px;">J.	YOUR RIGHTS IF I AM IN DEFAULT OF THIS AGREEMENT:</b><span style="font-size:8px;">I am in Default with this Agreement; F the Lender may enforce your rights according to law. The Lender may also do the things specifically mentioned in this Agreement. As permitted by applicable law and subject to any required notice. The Lender may do one of these things and at the same time or later do another. Some of the things the Lender may do are the.
<br>
<b style="font-size:8px;">(1) Acceleration: </b> If permitted by applicable law, any sums you advance will be payable by me, as you alone may direct. 
<br>
<b style="font-size:8px;">(2) Repossession: </b> The Lender can repossess the vehicle, unless prohibited by law. The Lender can do this, have a qualified person do it or have a government official (by replevin) do it. I agree that the Lender or its representatives can peaceably come on to my property to do this. Subject to the notice and inventory requirements provided by applicable law, you may take any personal property found in the vehicle but will return these things to me if I ask. If I want these things back, I agree to reclaim them within 60 days. If I do not reclaim my things within the time for doing so, I give up claim to them. I agree that the Lender may use my license plates to transport the vehicle to a place for storage. 
<br>

<b style="font-size:8px;">(3) Voluntary Delivery: </b> The Lender can ask me to return the vehicle at reasonable convenient place. I agree to give the Lender the vehicle if asked to. 
<br>
<b style="font-size:8px;">(4) Delay in Enforcement: </b>The Lender can delay in doing any of these things without losing any rights. 
<br>

</span>
<br>

<b style="font-size:8px;">K. SOME THINGS I SHOULD KNOW IF THE LENDER REPOSSESS THE VEHICLE:</b><span style="font-size:8px;">If the Lender repossess without using a governmental official:
<br>
<b style="font-size:8px;">(1) Notice: </b>The Lender will send a notice that tells me how to buy back (Redeem) the vehicle. Subject to the limitations of California Law, I may also have the right to reinstate the Agreement by paying only the delinquent installments, satisfying all liens that I have allowed to be placed on the vehicle, or obtaining insurance as the case may be and by paying your costs of repossession as described below. The notice the lender sends me will tell me other information required by law. 
<br>
<b style="font-size:8px;">(2) Redemption: </b>I have the right to buy back (Redeem) the vehicle at any time. 
<br>

<b style="font-size:8px;">(3) Sale: </b>If do not redeem, the Lender will sell the vehicle. The money received at sale will be used to pay costs and expenses I owe and then to pay the amount I owe on the Agreement. 
<br>
<b style="font-size:8px;">(4) Surplus or Deficiency: </b> if there is money left, you will pay it to the Borrower. If there is not enough money from the sale to pay what I owe, Borrower and Co-signer agree to pay what is still owed to you. 
<br>
<b style="font-size:8px;">(5)	Expenses: </b> if there is money left, you will pay it to the Borrower. If there is not enough money from the sale to pay what I owe, Borrower and Co-signer agree to pay what is still owed to you. 


</span>

</td>





<td>
<span style="font-size:8px;">(10) Otro acreedor intenta llevar el vehículo a través de un proceso legal; o 
<br>
(11) Muero, me condenan por un delito de fraude o deshonestidad o un tribunal con jurisdicción me declara que lo hace  estar incapacitado.

</span>
<br>
<b style="font-size:8px;">J. SUS DERECHOS SI ESTOY POR DEFECTO ESTE ACUERDO:</b><span style="font-size:8px;">Estoy en incumplimiento con este Acuerdo; F el prestamista puede hacer valer sus derechos de acuerdo con la ley. El prestamista también puede hacer las cosas específicamente mencionadas en este Acuerdo. Según lo permitido por la ley aplicable y sujeto a cualquier aviso requerido. El prestamista puede hacer una de estas cosas y al mismo tiempo o más tarde hacer otra. Algunas de las cosas que el prestamista puede hacer son las siguientes:
<br>
<b style="font-size:8px;">(1) Aceleración: </b> El Prestamista puede exigir que le pague el saldo completo impago del Acuerdo, todos los Cargos financieros impagos y otro dinero adeudado. Estoy de acuerdo en que pagaré este dinero al prestamista en un solo pago inmediatamente después de recibir su demanda. 
<br>
<b style="font-size:8px;">(2) Recuperación: </b> El prestamista puede recuperar el vehículo, a menos que lo prohíba la ley. El prestamista puede hacer esto, que lo haga una persona calificada o que lo haga un funcionario del gobierno (por reposición). Estoy de acuerdo en que el prestamista o sus representantes pueden venir pacíficamente a mi propiedad para hacer esto. Sujeto a los requisitos de notificación e inventario provistos por la ley aplicable, puede tomar cualquier propiedad personal que se encuentre en el vehículo, pero me lo devolverá si lo solicito. Si quiero recuperar estas cosas, acepto reclamarlas dentro de los 60 días. Si no reclamo mis cosas dentro del tiempo para hacerlo, renuncio a reclamarlas. Acepto que el Prestamista pueda usar mis placas de matrícula para transportar el vehículo a un lugar de almacenamiento. 
<br>

<b style="font-size:8px;">(3) Entrega Voluntaria: </b> El prestamista puede pedirme que devuelva el vehículo en un lugar conveniente y razonable. Estoy de acuerdo en darle al prestamista el vehículo si me lo piden. 
<br>
<b style="font-size:8px;">(4) Retraso en la Ejecución: </b>El prestamista puede demorar en hacer cualquiera de estas cosas sin perder ningún derecho. 


</span>
<br>
<b style="font-size:8px;">K. ALGUNAS COSAS QUE DEBO SABER SI EL PRESTADOR RECONOCE EL VEHÍCULO:</b><span style="font-size:8px;">Si el prestamista toma posesión sin usar un funcionario gubernamental:
<br>
<b style="font-size:8px;">(1) Aviso: </b>El prestamista me enviará un aviso que me indicará cómo volver a comprar (canjear) el vehículo. Sujeto a las limitaciones de la Ley de California, también puedo tener el derecho de restablecer el Acuerdo pagando solo las cuotas morosas, cumpliendo todos los gravámenes que he permitido que se coloquen en el vehículo u obteniendo un seguro según sea el caso y pagando sus costos de recuperación como se describe a continuación. El aviso que me envía el prestamista me informará otra información requerida por la ley. 
<br>
<b style="font-size:8px;">(2) Canje: </b>Tengo derecho a comprar (Canjear) el vehículo en cualquier momento. 
<br>

<b style="font-size:8px;">(3) Venta: </b>si no canjea, el prestamista venderá el vehículo. El dinero recibido en la venta se usará para pagar los costos y gastos que debo y luego para pagar la cantidad que debo en el Acuerdo. 
<br>
<b style="font-size:8px;">(4) Excedente o Deficiencia: </b>Si queda dinero, se lo pagará al Prestatario. Si no hay suficiente dinero de la venta para pagar lo que debo, el Prestatario y el Co-firmante acuerdan pagar lo que aún se le debe. 
<br>
<b style="font-size:8px;">(5) Gastos: </b>Estoy de acuerdo en pagar las tarifas reales y necesarias para recuperar el vehículo y los costos de almacenamiento, reparación, preparación para la venta y venta del vehículo según lo permita la ley. 


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

$file_name = $id."page_9";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>