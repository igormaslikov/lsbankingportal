<?php
$id=$_GET['id'];
?>


<?php

$url_logo="https://mymoneyline.com/lsbankingportal/signature_customer/completed/";
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
    $loan_fee=$row_loan['loan_fee'];
    $loan_payable=$amount_of_loan+$loan_fee;
    $loan_payable=number_format($loan_payable, 2);
    $payment_date=$row_loan['payment_date'];
    $payment_date_db=$row_loan['payment_date'];
    $timestamp = strtotime($payment_date);
    $payment_date= date("m-d-Y", $timestamp);
    
    $creation_date=$row_loan['contract_date'];
    $creation_date_db=$row_loan['contract_date'];
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

$start = strtotime($creation_date_db);
$end = strtotime($payment_date_db);
$days_between = ceil(abs($end - $start) / 86400);


 
//$calculation = $loan_fee/$amount_of_loan;
//$calculation_1 = $datediff/365;
//$calculation_1 = $calculation_1*10000;
//$calculation_1  = $calculation_1/100;

  //$calculation = round($calculation, 2);

	

    
 	$created_by = $row_loan['created_by'];
    
 }
 
 
 
   $calculation = $loan_fee/$amount_of_loan*365/$days_between*100;
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
 <h1 style="text-align:center">CONTRATO DE PR??STAMO DE PAGO Y DECLARACI??N DE DIVULGACI??N</h1>
 
 <table border="0" style="text-align:left">
 <tbody>
 <tr>
 <td>
    <b>Loan ID :</b> '.$loan_id_bor.' <br>
    <b>Fecha del Contrato   :</b>  '.$creation_date.' <br>
    <b>Prestatario        :</b> '. $f_name.'<br>
    <b>Direcci??n         :</b> '.$address.'<br>
    <b>C??digo postal:</b> '.$city.' '.$state.' '.$zip.'<br><br>
 </td>
 <td>
 <b>Prestamista :</b> MoneyLine <br>
 <b>Direccion        :</b> 4645 Van Nuys Blvd #202 Sherman Oaks, CA 914035<br>
 <b>Telefono         :</b> 888-540-7232<br>
 <b>Licencia del Prestatario:</b> 10DBO-93629<br><br>
 </td>
  </tr>
 </tbody>
 </table>
  

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

<b>Desgloce del Monto Financiado</b><br><hr >
 <table border="0" style="padding-top:10px;padding-bottom:10px">
 <tbody>
 <tr>
    <td style="text-align:center"><b>Monto Financiado.</b></td>
    <td style="text-align:center"><b>Monto dado directamente a usted.</b></td>
    <td style="text-align:center"><b>Monto Refinanciado.</b></td>
 </tr>
 <tr>
    <td style="text-align:center">$<u>'.$amount_of_loan.'</u></td>
    <td style="text-align:center">$<u>'.$amount_of_loan.'</u></td>
    <td style="text-align:center">$<u>0</u></td>
 </tr>
 </tbody>
 </table>

<br>

 <b>CALENDARIO DE PAGO </b> Su calendario de pago ser??:<br>
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
</table></b>

<div style="font-size:8px">
<b>Garant??a:</b>Su(s) pago(s) posfechado(s) y/o la Autorizaci??n de la C??mara de Compensaci??n Automatizada ("ACHA"), que si se adjunta(n), forma(n)
parte de este Acuerdo, como si estuviera(n) completamente establecido(s) en el mismo, constituye(n) una garant??a para el pr??stamo. La cesi??n de su
salario, si se ha dado, tambi??n es garant??a de este pr??stamo.<br>
<b>Pago anticipado:</b> Un Consumidor puede cancelar sus obligaciones de pagos futuros en un pr??stamo de d??a de pago, sin costo o cargos financieros, a m??s
tardar al final del segundo d??a h??bil, inmediatamente posterior al d??a en que se ejecut?? el pr??stamo de d??a de pago. Si se cancela antes de tiempo, no
tendr?? derecho a la devoluci??n de una parte del cargo de financiaci??n.<br>
<b>Cargo por cheque sin fondos:</b> El Prestatario pagar?? un cargo al Prestamista de $ 15.00 si el Prestatario realiza un pago del pr??stamo del d??a de pago y el
cheque o el cargo preautorizado con el que el Prestatario paga es posteriormente devuelto por no suficientes fondos.
<br>
<b>Pago Diferido:</b>El cliente no puede ser procesado en una acci??n penal en relaci??n con una transacci??n de dep??sito diferido para un cheque devuelto o
ser amenazado con persecuci??n. Money Line no puede aceptar ninguna garant??a en relaci??n con una transacci??n de dep??sito diferido. Money Line 
no puede hacer una transacci??n de dep??sito diferido contingente en la compra de otro producto o servicio. El cheque del Prestatario forma parte
de una transacci??n de dep??sito diferido realizada de conformidad con el art??culo 23035 del C??digo Financiero y no est?? sujeto a las disposiciones del
art??culo 1719 del C??digo Civil. No se podr?? exigir al Prestatario el pago de da??os y perjuicios triples si este cheque no se hace efectivo
<br>
<b>Reclamos e inquietudes:</b>El prestatario puede llamar al n??mero de tel??fono gratuito del Departamento de Protecci??n e Innovaci??n Financiera: 866-275-
2677 para presentar quejas e inquietudes.
<br>
<u><b>Money Line con Licencia # 10DBO-93629 est?? autorizada por el Departamento de Protecci??n e Innovaci??n Financiera de acuerdo con la Ley de
Transacciones de Dep??sito Diferido de California. Los pr??stamos de California que no sean de dep??sito diferido se emiten de acuerdo con la Ley de
Financiaci??n de California.</b></u>
<br>

ENTIENDO QUE SI A??N DEBO EN UNO O M??S PR??STAMOS DE DIA DE PAGO DESPU??S DE 35 D??AS, SE ME PERMITE
ENTRAR EN UN PLAN DE REPAGO QUE ME DAR?? AL MENOS 55 D??AS PARA REPAGAR EL PRESTAMOS EN PAGOS SIN
CARGOS DE FINANCIAMIENTO, INTERESES, HONORARIOS O OTROS CARGOS DE CUALQUIER TIPO. <br>
<b>ADVERTENCIA:</b> ESTE PR??STAMO NO EST?? INTENCIONADO A CUMPLIR CON LAS NECESIDADES FINANCIERAS A LARGO
PLAZO. ESTE PR??STAMO DEBE SER USADO PARA CUMPLIR CON LAS NECESIDADES DE EFECTIVO A CORTO PLAZO. EL
COSTO DE SU PR??STAMO PUEDE SER MAYOR QUE LOS PR??STAMOS OFRECIDOS POR OTRAS INSTITUCIONES DE
PR??STAMOS. ESTE PR??STAMO EST?? REGULADO POR EL DEPARTAMENTO DE REGULACI??N FINANCIERA Y
PROFESIONAL.<br>
Al firmar este Contrato de Pr??stamo y Declaraci??n de Divulgaci??n (este "contrato") y aceptar un pr??stamo de LS Financing, Inc ("Prestamista") el
prestatario abajo firmante ("Yo", "usted", "prestatario") est?? de acuerdo y acepta los t??rminos y condiciones establecidos en todas las p??ginas de este
contrato
</div>
<br>

<table border="1">
<tbody>
<tr>
<td> Firma del Prestatario</td>
<td> Fecha</td>
<td colspan="2"> Prestamista: MoneyLine</td>
<td> Fecha</td>
</tr>
<tr>
<td><img src="../completed/doc_signs/'.$img_signed.'" height="300%" alt=""></td>
<td align="center">'.$creation_date.'</td>
<td align="center"> <b>Nombre</b> <br>'.$username.'<br></td>
<td align="center"> <b>Titulo</b><br>Agente de pr??stamo</td>
<td>'.$creation_date.'</td>
</tr>
</tbody>
</table>
 

';
// $sign_image_url= "https://mymoneyline.com/lsbankingportal/signature_customer/completed/doc_signs/".$img_signed;

// $img = file_get_contents($sign_image_url);

$pdf->writeHTML($html,25,30); 

// $pdf->Image('@' . $img, 15, 257, '30', '', 'JPG', '', 'T', false, 40, '', false, false, 0, false, false, false);
 
$data_shipment  = ":";



$pdf->Ln();
$html = '<h1>LSBANKING </h1>';
$html_underline = '<b style="text-decoration:underline">PLEASE LEAVE THIS LABEL UNCOVERED.</b>';
// ---------------------------------------------------------

//Close and output PDF document

//$pdf->Output('Case.pdf', 'I');

//$pdf_data = ob_get_contents();

// $file_name = $id."page_2";
// $path="Barcodes/".$file_name.".pdf";
// file_put_contents( $path, $pdf_data );
$file_name = $id."page_2";
$path=dirname(__FILE__)."/Barcodes/".$file_name.".pdf";
$pdf->Output($path,'F');
//============================================================+
// END OF FILE
//============================================================+

?>