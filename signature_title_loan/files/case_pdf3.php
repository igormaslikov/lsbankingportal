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

 $html = '<br><br><img src="images/Money-Line-Logo.JPG" style="height:400%" align="left"/><br><span style="text-align:left">4645 Van Nuys Boulevard Suite 202 Sherman Oaks, CA 91403</span><br><br>


<table style="border-collapse:separate;border-spacing: 12px 0;" >
<tbody>
<tr>
<td>
<span style="font-size:8px;">You agree to keep the vehicle in good working condition and make all necessary repairs. Although we are not obligated to do so. If we pay any liens, fees, maintenance or taxes in connection with the vehicle or advance any other amount to protect our interest in the vehicle, you will reimburse us, at our option within 5 days of our demand or we may add the amount of any such liens, fees, maintenance, taxes or other charges to the Principal balance. Such amounts will accrue finance charges at the rate set forth above. Unless you have paid us such amounts prior to maturity, they will be due date at the maturity of this Agreement</span>
<br>

<b style="font-size:8px;">???Insurance:</b><span style="font-size:8px;">you agree to keep the vehicle insured in our favor with a policy and insurance provider satisfactory to us, with comprehensive, fire, theft and collision coverage, insuring the vehicle in an amount sufficient to cover the value of the vehicle, and providing for a deductible of not more than $1,000. You may obtain the insurance from any insurer or broker you choose that is acceptable to us. You agree to obtain and deliver to us a loss payable endorsement on such insurance. You agree that we may (1) contact your insurance agent to verify coverage or to have us added as a loss payee, (2) make any claim under your insurance policy for physical damage or loss to the vehicle. (3) cancel the insurance if you default in your obligations under this Agreement and we take possession of the vehicle and/or (4) receive any payment for loss or damage or return premium and apply amounts we receive at our option too replacement of the vehicle or to what you owe this Agreement, including indebtedness not yet due. If you fail to maintain such insurance, we may at our option obtain such insurance to protect our interest in the vehicle. The insurance we purchase does not cover your interests. You understand that the insurance premiums may be higher if we must purchase such insurance than if you had purchased the insurance yourself. Whether the vehicle is insured, you must pay us all that you owe us if the vehicle is lost, stolen, damaged or destroyed.</span>
<br>
<b style="font-size:8px;">???Remedies:</b><span style="font-size:8px;">If you are in default we may: (1) declare all that you owe us to be immediately due and payable; (2) file suit against you for all unpaid sums you owe under this agreement; (3) take immediate possession of the vehicle where we may find it provided we do so peacefully; and (4) exercise any other legal or equitable remedy. If we take possession of the vehicle, any accessories, equipment or replacement part will stay with the vehicle. If any of your personal items are in the vehicle when we take possession, they will be stored for you at your expense. California law provides for a period of 60 days to hold your items. If you do not ask for these items back within that time, we may dispose of them as permitted by law. Our remedies under (1) and (2) above are subject to any right you may have to reinstate the Agreement or redeem the vehicle by paying what you owe in full as provided in the California Finance Lenders Law and the California Uniform Commercial Code. Upon taking possession of the vehicle, subject to any right you may have to reinstate or redeem, we still sell the vehicle at a public or private sale. We will give you notice of the sales as required by law. We will add the costs of retaking, holding, preparing for sale and disposing of the vehicle to what you owe as permitted by law. The proceeds of sale will be applied first to these costs, and the remainder will be applied to unpaid sums you owe under this Agreement. If we must pursue collection or hire an Attorney to collect what you owe us, you will reimburse us our reasonable collection costs and Attorney???s fee when we demand.</span>
<br>

</td>

<td>
<span style="font-size:8px;">Usted acepta mantener el veh??culo en buenas condiciones de funcionamiento y hacer todas las reparaciones necesarias. Aunque no estamos obligados a hacerlo. Si pagamos grav??menes, tarifas, mantenimiento o impuestos en relaci??n con el veh??culo o adelantamos cualquier otro monto para proteger nuestro inter??s en el veh??culo, nos reembolsar??, a nuestra opci??n, dentro de los 5 d??as de nuestra demanda o podemos agregar el monto de tales grav??menes, tarifas, mantenimiento, impuestos u otros cargos al saldo del Principal. Dichos montos acumular??n cargos financieros a la tasa establecida anteriormente. A menos que nos haya pagado dichos montos antes del vencimiento, se vencer??n al vencimiento de este Acuerdo.</span>
<br>

<b style="font-size:8px;">???Seguro:</b><span style="font-size:7px;">Usted acepta mantener el veh??culo asegurado a nuestro favor con una p??liza y un proveedor de seguros satisfactorios para nosotros, con cobertura integral de incendio, robo y colisi??n, asegurando el veh??culo en una cantidad suficiente para cubrir el valor del veh??culo y proporcionando un deducible de no m??s de $ 1,000. Puede obtener el seguro de cualquier asegurador o corredor que elija que sea aceptable para nosotros. Usted acepta obtener y entregarnos un endoso de p??rdida pagadero de dicho seguro. Usted acepta que podemos (1) contactar a su agente de seguros para verificar la cobertura o que se nos agregue como beneficiario de p??rdidas, (2) presentar cualquier reclamo bajo su p??liza de seguro por da??os f??sicos o p??rdida del veh??culo. (3) cancele el seguro si usted no cumple con sus obligaciones bajo este Acuerdo y tomamos posesi??n del veh??culo y / o (4) recibimos cualquier pago por p??rdida o da??o o devolvemos la prima y aplicamos los montos que recibimos a nuestra opci??n tambi??n como reemplazo del veh??culo o a lo que debe este Acuerdo, incluido el endeudamiento a??n no adeudado. Si no lo lograsto mantener dicho seguro, podemos, a nuestra discreci??n, obtener dicho seguro para proteger nuestro inter??s en el veh??culo. El seguro que compramos no cubre sus intereses. Usted comprende que las primas del seguro pueden ser m??s altas si debemos comprar dicho seguro que si usted mismo lo hubiera comprado. Ya sea que el veh??culo est?? asegurado, debe pagarnos todo lo que nos debe si el veh??culo se pierde, es robado, da??ado o destruido.</span>
<br>
<b style="font-size:8px;">???Remedios:</b><span style="font-size:7px;">Si est?? en incumplimiento, podemos: (1) declarar que todo lo que nos debe se debe y debe pagar inmediatamente; (2) entablar una demanda contra usted por todas las sumas impagas que adeuda en virtud de este acuerdo; (3) tomar posesi??n inmediata del veh??culo donde podamos encontrarlo siempre que lo hagamos pac??ficamente; y (4) ejercer cualquier otro recurso legal o equitativo. Si tomamos posesi??n del veh??culo, cualquier accesorio, equipo o pieza de reemplazo permanecer?? con el veh??culo. Si alguno de sus art??culos personales est?? en el veh??culo cuando tomamos posesi??n, se guardar??n para usted a su cargo. La ley de California establece un per??odo de 60 d??as para guardar sus art??culos. Si no solicita estos art??culos dentro de ese plazo, podemos deshacernos de ellos seg??n lo permita la ley. Nuestros recursos en virtud de (1) y (2) anteriores est??n sujetos a cualquier derecho que tenga para restablecer el Acuerdo o canjear el veh??culo mediante el pago total de lo que debe seg??n lo dispuesto en la Ley de prestamistas financieros de California y el C??digo Comercial Uniforme de California. Al tomar posesi??n del veh??culo, sujeto a cualquier derecho que tenga que restablecer o canjear, todav??a vendemos el veh??culo en una venta p??blica o privada. Le avisaremos de las ventas seg??n lo exija la ley. Agregaremos los costos de retomar, mantener, preparar para la venta y deshacerse del veh??culo a lo que debe seg??n lo permitido por la ley. El producto de la venta se aplicar?? primero a estos costos, y el resto se aplicar?? a las sumas impagas que adeuda en virtud de este Acuerdo. Si debemos continuar con el cobro o contratar a un abogado para cobrar lo que nos debe, nos reembolsar?? nuestros costos razonables de cobro y los honorarios del abogado cuando lo solicitemos.</span>
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

$file_name = $id."page_4";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>