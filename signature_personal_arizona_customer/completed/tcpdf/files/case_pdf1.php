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
$creation_date=$row1['creation_date'];
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

if($signed_status>0){
    echo "Contract Already Signed";
}
else {
//echo "ID is".$loan_id;



$sql_loan=mysqli_query($con, "select * from tbl_loan where loan_id= '$loan_id_bor' "); 

while($row_loan = mysqli_fetch_array($sql_loan)) {
    
    
    $amount_of_loan=$row_loan['amount_of_loan'];
    $payment_date=$row_loan['payment_date'];
    // echo "LOAN Amount".$amount_of_loan;
    
   
    
     
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

$f_name=$row2['first_name'];
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
$anual_pr=($apr_total/$dateDiff)*100;
	//echo $anual_pr;
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
 
 
 
 <br><div style="line-height:7px"><h2 style="text-align:center">CONTRATO DE PRÉSTAMO DE PAGO Y DECLARACIÓN DE DIVULGACIÓN</h2>
<span style="text-align:center"> Prestamista: LS Financing, Inc 4645 Van Nuys Blvd # 202 Sherman Oaks, CA 91403</span><br><br>
</div>

Fecha del Contrato:    :  '.$creation_date.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LOAN ID : '.$loan_id_bor.' <br>
Prestatario        : '. $f_name.'<br>
Dirección         : '.$address.'<br>
Código postal: '.$city.' '.$zip.' '.$state.'<br><br>

<table border="1" style="text-align:center">
<tbody>
<tr>
<td  colspan="4"><b style="text-align:center">DECLARACIÓN FEDERAL DE DIVULGACIÓN DE VERDAD EN PRÉSTAMO</b></td>
</tr>
<tr>
<td><b style="text-align:center">TASA DE PORCENTAJE<br>
ANUAL</b> <br>El costo de su crédito
 <br> expresado como tasa annual<br><br><br>$'.$anual_pr.'<br></td>
<td><b style="text-align:center">CARGOS DE
<br>
FINANCIAMIENTO</b><br>El importe en dolares que le<br>
costara el credito.<br><br><br>$'.$payoff.'<br></td>
<td><b style="text-align:center">MONTO FINANCIADO  <br> <br></b>Cantidad de credito provista<br>
a usted o en su nombre.<br><br><br>$'.$amount_of_loan.'<br></td>
<td><b style="text-align:center">TOTAL DE PAGOS <br> </b><br>El monto que Habra pagado
despues de haber efectuado todos
los pagos programados .<br><br><br>$'.$total_amount.'<br></td>
</tr>
</tbody>
</table>
<br><br>
Seguridad<br>
* Su (s) pago (s) con fecha posterior y / o la Autorización de la Cámara de Compensación Automatizada ("ACHA") que, de ser así,
se hacen / forman parte de este Acuerdo, como si se indicara completamente en este documento como garantía del préstamo.<br>
 * Su asignación de salario, si se otorga, también es garantía para este préstamo.<br><br>
 <b>CALENDARIO DE PAGO </b> Su calendario de pago será:<br><br>
 <b><table border="1">
<tbody>
<tr style="text-align:center">
<td>Numero de Pagos</td>
<td>Monto del Pago</td>
<td>Fecha del Pago</td>
</tr>
<tr>
<td><br>1<br></td>
<td><br>'.$total_amount.'<br></td>
<td><br>'.$payment_date.'<br></td>
</tr>
</tbody>
</table></b><br><br>
<b>Pago por adelantado</b><br>Un Consumidor puede cancelar futuras obligaciones de pago en un préstamo de día de pago, sin costos ni cargos financieros, a más
tardar al final del segundo día hábil, inmediatamente después del día en que se ejecutó el préstamo de día de pago. Si paga
anticipadamente, no tendrá derecho a un reembolso de una parte del cargo financiero. Consulte a continuación y / o la segunda
página de este contrato para obtener información adicional sobre la falta de pago, el incumplimiento de pago, cualquier pago
requerido en su totalidad antes de la fecha programada y los reembolsos y multas por pago anticipado.<br><br>
Al firmar este Contrato de préstamo y Declaración de divulgación (este "contrato") y aceptar un préstamo de LS Financing, Inc
("Prestador"), el prestatario abajo firmante ("yo", "usted", "prestatario") esta de acuerdo y acepta los términos y condiciones
establecidas en todas las páginas de este contrato.
<br><br>
<b>ENTIENDO QUE SI AÚN DEBO EN UNO O MÁS PRÉSTAMOS DE DIA DE PAGO DESPUÉS DE 35 DÍAS, SE ME PERMITE
ENTRAR EN UN PLAN DE REPAGO QUE ME DARÁ AL MENOS 55 DÍAS PARA REPAGAR EL PRESTAMOS EN PAGOS SIN
CARGOS DE FINANCIAMIENTO, INTERESES, HONORARIOS O OTROS CARGOS DE CUALQUIER TIPO. <br><br>
ADVERTENCIA: ESTE PRÉSTAMO NO ESTÁ INTENCIONADO A CUMPLIR CON LAS NECESIDADES FINANCIERAS A LARGO
PLAZO. ESTE PRÉSTAMO DEBE SER USADO PARA CUMPLIR CON LAS NECESIDADES DE EFECTIVO A CORTO PLAZO. EL
COSTO DE SU PRÉSTAMO PUEDE SER MAYOR QUE LOS PRÉSTAMOS OFRECIDOS POR OTRAS INSTITUCIONES DE
PRÉSTAMOS. ESTE PRÉSTAMO ESTÁ REGULADO POR EL DEPARTAMENTO DE REGULACIÓN FINANCIERA Y
PROFESIONAL.<br><br>
NO SE PUEDE PROCESADO EN LA CORTE PENAL PARA RECOGER ESTE PRÉSTAMO.
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
<td>&nbsp'.$creation_date.';</td>
<td style=""> <b>Nombre</b> <br>'.$f_name.'<br></td>
<td> <b>Titulo</b><br>'.$loan_id_bor.'</td>
<td>&nbsp;'.$creation_date.'</td>
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