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


$sql_loan=mysqli_query($con, "select * from tbl_loan where loan_create_id= '$loan_id_bor' "); 

while($row_loan = mysqli_fetch_array($sql_loan)) {
    
    
    $amount_of_loan=$row_loan['amount_of_loan'];
    $amount_of_loan=number_format($amount_of_loan, 2);
    $payment_date=$row_loan['payment_date'];
    
    $timestamp = strtotime($payment_date);
    $payment_date= date("m-d-Y", $timestamp);
    
    $creation_date=$row_loan['contract_date'];
    
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

$pdf->SetFont('helvetica', '', 9.5);

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
 
 
 
 <br><div style="line-height:7px"><h2 style="text-align:center">CONTRATO DE PR??STAMO DE PAGO Y DECLARACI??N DE DIVULGACI??N</h2>
<span style="text-align:center"> Prestamista: LS Financing, Inc 4645 Van Nuys Blvd # 202 Sherman Oaks, CA 91403</span><br><br>
</div>

Fecha del Contrato:    :  '.$creation_date.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LOAN ID : '.$loan_id_bor.' <br>
Prestatario        : '. $f_name.'<br>
Direcci??n         : '.$address.'<br>
C??digo postal: '.$city.' '.$zip.' '.$state.'<br><br>

<table border="1" style="text-align:center">
<tbody>
<tr>
<td  colspan="4"><b style="text-align:center">DECLARACI??N FEDERAL DE DIVULGACI??N DE VERDAD EN PR??STAMO</b></td>
</tr>
<tr>
<td><b style="text-align:center">TASA DE PORCENTAJE<br>
ANUAL</b> <br>El costo de su cr??dito
 <br> expresado como tasa annual<br><br><br>'.$anual_pr.'%<br></td>
<td><b style="text-align:center">CARGOS DE
<br>
FINANCIAMIENTO</b><br>El importe en dolares que le<br>
costara el credito.<br><br><br>$'.$loan_fee.'<br></td>
<td><b style="text-align:center">MONTO FINANCIADO  <br> <br></b>Cantidad de credito provista<br>
a usted o en su nombre.<br><br><br>$'.$amount_of_loan.'<br></td>
<td><b style="text-align:center">TOTAL DE PAGOS <br> </b><br>El monto que Habra pagado
despues de haber efectuado todos
los pagos programados .<br>$'.$loan_payable.'<br></td>
</tr>
</tbody>
</table>
<br><br>
Seguridad<br>
* Su (s) pago (s) con fecha posterior y / o la Autorizaci??n de la C??mara de Compensaci??n Automatizada ("ACHA") que, de ser as??,
se hacen / forman parte de este Acuerdo, como si se indicara completamente en este documento como garant??a del pr??stamo.<br>
 * Su asignaci??n de salario, si se otorga, tambi??n es garant??a para este pr??stamo.<br><br>
 <b>CALENDARIO DE PAGO </b> Su calendario de pago ser??:<br><br>
 <b><table border="1">
<tbody>
<tr style="text-align:center">
<td>Numero de Pagos</td>
<td>Monto del Pago</td>
<td>Fecha del Pago</td>
</tr>
<tr>
<td align="center"><br>1<br></td>
<td align="center"><br>$'.$loan_payable.'<br></td>
<td align="center"><br>'.$payment_date.'<br></td>
</tr>
</tbody>
</table></b><br><br>
<b>Pago por adelantado</b><br>Un Consumidor puede cancelar futuras obligaciones de pago en un pr??stamo de d??a de pago, sin costos ni cargos financieros, a m??s
tardar al final del segundo d??a h??bil, inmediatamente despu??s del d??a en que se ejecut?? el pr??stamo de d??a de pago. Si paga
anticipadamente, no tendr?? derecho a un reembolso de una parte del cargo financiero. Consulte a continuaci??n y / o la segunda
p??gina de este contrato para obtener informaci??n adicional sobre la falta de pago, el incumplimiento de pago, cualquier pago
requerido en su totalidad antes de la fecha programada y los reembolsos y multas por pago anticipado.<br><br>
Al firmar este Contrato de pr??stamo y Declaraci??n de divulgaci??n (este "contrato") y aceptar un pr??stamo de LS Financing, Inc
("Prestador"), el prestatario abajo firmante ("yo", "usted", "prestatario") esta de acuerdo y acepta los t??rminos y condiciones
establecidas en todas las p??ginas de este contrato.
<br><br>
<b>ENTIENDO QUE SI A??N DEBO EN UNO O M??S PR??STAMOS DE DIA DE PAGO DESPU??S DE 35 D??AS, SE ME PERMITE
ENTRAR EN UN PLAN DE REPAGO QUE ME DAR?? AL MENOS 55 D??AS PARA REPAGAR EL PRESTAMOS EN PAGOS SIN
CARGOS DE FINANCIAMIENTO, INTERESES, HONORARIOS O OTROS CARGOS DE CUALQUIER TIPO. <br><br>
ADVERTENCIA: ESTE PR??STAMO NO EST?? INTENCIONADO A CUMPLIR CON LAS NECESIDADES FINANCIERAS A LARGO
PLAZO. ESTE PR??STAMO DEBE SER USADO PARA CUMPLIR CON LAS NECESIDADES DE EFECTIVO A CORTO PLAZO. EL
COSTO DE SU PR??STAMO PUEDE SER MAYOR QUE LOS PR??STAMOS OFRECIDOS POR OTRAS INSTITUCIONES DE
PR??STAMOS. ESTE PR??STAMO EST?? REGULADO POR EL DEPARTAMENTO DE REGULACI??N FINANCIERA Y
PROFESIONAL.<br><br>
NO SE PUEDE PROCESADO EN LA CORTE PENAL PARA RECOGER ESTE PR??STAMO.
</b>
<br><br>

<table border="1">
<tbody>
<tr>
<td> Firma del Prestatario</td>
<td> Fecha</td>
<td colspan="2"> Prestamista: LS Financing, Inc</td>
<td> Fecha</td>
</tr>
<tr>
<td>&nbsp;</td>
<td align="center">'.$creation_date.'</td>
<td align="center"> <b>Nombre</b> <br>'.$username.'<br></td>
<td align="center"> <b>Titulo</b><br>Agente de pr??stamo</td>
<td>'.$creation_date.'</td>
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

$file_name = $id."page_2";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>