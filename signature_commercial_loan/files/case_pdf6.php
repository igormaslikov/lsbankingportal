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


 <table>
	<tbody>
	<tr>
		<td style="vertical-align:baseline;text-align:justify; width:45%">
			<ul>
				<li style="margin-bottom:10px"><b>Arbitration:</b><span>. You acknowledge that you have read, understand and agree to the terms contained in the Arbitration Agreement you are signing in connection with this Agreement, by entering into the Arbitration Agreement you waive certain rights, including the right to go to court, to have a dispute heard by a jury, and to participate as part of a class o claimants relating to any claim against or dispute with us or a related third party.</span></li>
				<li style="margin-bottom:10px"><b>Notices:</b><span>We will send all notices to you at the address shown above. You understand and agree that you have a responsibility under California Civil Code Section 1788.21 to notify us of any change in your name, address, or employment within a reasonable time after such change occurs.</span></li>
				<li style="margin-bottom:10px"><b>Presentations and Warranties:</b><span>You represent and warrant to us that (a) all the information you provided to us in your credit application is true and correct (b) you have the legal capacity to enter into this Agreement; and (c) n persona has acted as a broker or finder for this transaction.</span></li>
				<li style="margin-bottom:10px"><b>Returned Payment Charge; Collection Costs:</b><span>You understand and agree that if, a payment check is returned unpaid for any reason, and you will pay us a returned payment charge of $25. You agree to pay us any court fees we incur in enforcing this Agreement.</span></li>
				<li style="margin-bottom:10px"><b>Credit Reporting:</b><span>You agree that we may make inquiries concerning your credit history and standing. We may report information concerning your performance under this Agreement to credit reporting agencies. Late payments, missed payments, or other defaults on your account may be reflected in your credit report. </span></li>
				<li style="margin-bottom:10px"><b>Right to Rescind the Loan. :</b><span>You may rescind your loan and cancel this Agreement by notifying us by the end of the business day following the day you sign this Agreement. if you rescind the loan, you must return to us the money that we lend you.</span></li>
			</ul>
		</td>
		<td style="width:10%"></td>
	
	
		<td style="vertical-align:baseline;text-align:justify;width:45%">
			<ul>
				<li style="margin-bottom:10px"><b>Arbitraje:</b><span>Usted confirma que ha leído, comprendido y convenido a los términos y condiciones contenidos en el acuerdo de arbitraje que firma en relación con este contrato. Al firmar el acuerdo de arbitraje usted renuncia a ciertos derechos, inclusive el derecho de acudir a un tribual solicitar que una disputa sea escuchada por un jurado y formar parte de un grupo de reclamantes en relación con cualquier reclamación o disputa contra nosotros u otra parte relacionada.</span></li>
				<li style="margin-bottom:10px"><b>Avisos:</b><span>Le enviaremos todos los avisos al domicilio indicada arriba. Usted comprende y conviene que tiene una responsabilidad conforme a la sección 1788.21 del código civil de California, de notificarnos de cualquier cambio de nombre, domicilio, o empleo dentro de un plaza razonable después de que ocurra dicho cambio.</span></li>
				<li style="margin-bottom:10px"><b>Declaraciones y garantías:</b><span>Usted nos declara y garantiza que (a) toda la información que nos ha proporcionado en su solicitud de crédito es veraz y correcta; (b) tiene la capacidad legal para firmar este contrato; y (c) ninguna persona ha actuado como corredor o fundir de esta transacción.</span></li>
				<li style="margin-bottom:10px"><b>Cargo por Cheque Devuelto, costos de Cobranza:</b><span>Usted comprende y conviene que si un cheque de pago es devuelto sin pagar, por la razón que sea, usted nos pagara un cargo por cheque devuelto de $25. Usted conviene en pagarnos todos los cargos de corte en que incurramos para la ejecución de este contrato.</span></li>
				<li style="margin-bottom:10px"><b>Informes crediticios:</b><span>Usted conviene que podremos realizar ciertas consultas sobre su historial de crédito y solvencia crediticia. Podremos proporcionar a agencias de informes crediticios información sobre su desempeño según este contrato. Retraso en los pagos, pagos incumplidos, y otros incumplimientos en esta obligación pueden ser reflejados en su informe e crédito.</span></li>
				<li style="margin-bottom:10px"><b>Derecho a rescindir el préstamo:</b><span>Usted puede rescindir su préstamo y cancelar este contrato notificándonos a más tardar al final del día hábil posterior al día en que usted formo este contrato. En caso de que rescinda el préstamo, deberá devolvernos todo el dinero del préstamo que haya recibido.</span></li>
			</ul>	
		</td>
	</tr>
	
	</tbody>
	</table>
	<br><br><br>
	<span> By signing below, you acknowledge that (1) you have read and received copy of this Agreement; (2) you agree to the terms of this Agreement; (3) no person has acted as a broke in connection with the Agreement; (4) there are no other oral or written agreements or promises between you and us.
	 Al firmar abajo, usted certifica que (1) ha leído y recibido una copia de este contrato; (2) está de acuerdo con los términos y condiciones de este Contrato; (3) nadie ha sido intermediario en relación con este Contrato; (4) no hay otros acuerdos o promesas orales o escritas entre usted y nosotros.
	 </span>
	 <br><br>
	
	SIGNATURES/FIRMAS:
	<br><br>
	
	<table>
	<tbody>
	<tr>
	
	<td style="width:35%">
	_______________________________________<br>
	Borrower Signature/ Firma del deudor:
	</td>
	<td style="width:15%">
		______________<br>
		Date/Fecha:
	</td>
	<td style="width:35%">
	_______________________________________<br>
	Co-Borrower Signature / Firma de co-deudor:
	</td>
	<td style="width:15%">
		______________<br>
		Date/Fecha:
	</td>
	</tr>
	
	</tbody>
	</table>
	<br><br>
	<b>LS Financing, Inc</b>
	<p style="font-size:6px;">California Finance Lender License: 60DBO-88277<br>
	Numero De Licencia Del Prestamista Financiero de California: 60DBO-88277 <br><br>
	THIS LOAN IS MADE PURSUANT TO THE CALIFORNIA FINANCE LENDERS LAW, DIVISION 9 (COMMENCING WITH SECTION 22000) OF THE FINANCIAL CODE BY LS Financing, Inc UNDER A CALIFORNIA FINANCE LENDER’S LICENSE. THAT LICENSE IS ADMINSITERED BY THE CALIFORNIA DEPARTMENT OF BUSINESS OVERSIGHT. FOR INFORMATION OR COMPLAINTS, CONTACT THE DEPARTMENT OF BUSINESS OVERSIGHT AT 1-866-275-2677 OR www.dbo.ca.gov
	 <br><br>
	ESTE PRESTAMO ES REALIZADO EN CONFORMIDAD CON LA LEY DE PRESTAMISTAS FINANCIEROS DE CALIFORNIA, DIVISION 9 (COMENZANDO CON LA SECCION 22000) DEL CODIGO FINANCIERO POR LS Financing, Inc CONFORME A UNA LICENCIA DE PRESTAMISTA FINANCIERO DEL ESTADO DE CALIFORNIA. DICHA LICENCIA ES ADMINISTRADA POR EL DEPARTAMENTO DE SUPERVISION DE EMPRESAS DEL ESTADA DE CALIFORNIA. PARA OBTENER INFORMACION O PRESENTAR QUEJAS, COMUNIQUESE CON EL DEPARTAMENTO DE SUPERVISION DE EMPRESAS AL 1-866-275-2677 O EN www.dbo.ca.gov
	</p>
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

// $file_name = $id."page_7";
// $path="Barcodes/".$file_name.".pdf";
// file_put_contents( $path, $pdf_data );

// $pdf->Output(dirname(__FILE__).'/Case.pdf', 'I');

// $pdf_data = ob_get_contents();
// $file_name = $id."page_7";
// $path = dirname(__FILE__) . "/Barcodes/" . $file_name . ".pdf";
// file_put_contents( $path, $pdf_data );

$file_name =$id. "page_7";
$path=dirname(__FILE__)."/Barcodes/".$file_name.".pdf";
$pdf->Output($path, 'F');
//============================================================+
// END OF FILE
//============================================================+

?>