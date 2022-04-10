<?php
$id=$_GET['id'];
$url_logo="https://pacificafinancegroup.com/loanportal/signature_commercial_loan/completed/";

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

$img_signed = $row1['initial_pic'];

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
   
   $sql_installment=mysqli_query($con, "select * from tbl_commercial_loan_installments where loan_create_id=$loan_id_bor"); 
while($row_installment = mysqli_fetch_array($sql_installment)) {
$payment_install=$row_installment['payment'];
$payment_date_install=$row_installment['payment_date'];
  $timestampp = strtotime($payment_date_install);
  $payment_date_installl= date("m-d-Y", $timestampp);
 $payment_install=number_format($payment_install, 2);

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

$pdf->SetFont('helvetica', '', 6);

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
	<img src="images/pacifica.jpeg" style="height:400%;clear: both" align="left"/>
</div>
<br><span style="text-align:left;width:100%"><b>5900 S Eastern Ave Suite 114 Commerce, CA 90040</b></span>
 <br><br><br>
Borrower Name/Nombre del Deudor: <span style="text-decoration:underline">'.$f_name.'</span><br><br>
&nbsp;&nbsp;Loan Number/Numero de Prestamo: <span style="text-decoration:underline">'.$loan_id_bor.'</span><br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date/Fecha: <span style="text-decoration:underline">'.$creation_date.'</span>
 <br><br><br>


 <h3 style="text-align:center"><u>Arbitration Agreement / Acuerdo de Arbitraje</u></h3>
<div class="">
<table>
<tbody>
<tr >
<td style="vertical-align:baseline;text-align:justify;width:45%">
<div>
<span>To the right, you will find a Spanish-Language translation of our Arbitration Agreement. An independent third party has certified this translation. While it is our intention to provide an accurate translation, if the Spanish translation differs from the English Document; you understand and agree that the Spanish translation is provided solely as courtesy to you, and that the English Document is the legally binding agreement between you and us.</span>
<br/><br><b>NOTICE OF ARBITRATION AGREEMENT</b><br>
<ul>
  <li style="padding-bottom:0.5em"><span>This agreement provides that either you or we may choose to have any dispute decided by BINDING ARBITRATION instead of court.</li>
  <li style="padding-bottom:0.5em">If either you or we choose to arbitrate, YOU GIVE UP YOUR RIGHT TO GO TO COURT TO ASSERT OR DEFEND YOUR RIGHTS AND YOU WILL HAVE NO RIGHT TO A TRIAL BY JURTYOR BEFORE A JUDGE.</li>
  <li style="padding-bottom:0.5em">You are entitled to a FAIR HEARING, BUT discovery and other rights are MORE LIMITED THAN RULES APPLICABLE IN COURT</li>
  <li style="padding-bottom:0.5em">Arbitrator decisions are enforceable by court order and RIGHTS TO APPEAL ARE MORE LIMITED THAN IN A LAWSUIT DECIDED BY A JUDGE OR JURY.</li>
  <li style="padding-bottom:0.5em">This arbitration agreement and any arbitration under this agreement shall be governed by the Federal Arbitration Act (9 U.S.C & 1, et seq.).</li>
  <li>YOU HAVE THE RIGHT TO “OPT OUT” OF THIS ARBITRATION AGREEMENT by following the procedure outlined in the section entitled “Opt out Procedures”.</span></li>
</ul>

<br>
<b>FOR MORE DETAILS, PLEASE READ CAREFULLY THIS ARBITRATION AGREEMENT CAREFULLY.</b><br><br><span> In this Arbitration Agreement, “you” refers to the borrower(s). “we”, “us”, and “our” refers to Pacifica Finance Group, our successors-in-interest and assigns. This arbitration agreement is incorporated into and is a part of a loan agreement between you and us.</span>
<br><br>

<b>Parties and Matters Subject to Arbitration: </b><span>This Arbitration agreement applies to all claims and disputes between you and us. For purposes of this Arbitration agreement the words “claim” and “dispute” are given the broadest possibly meaning. “Claim” and “dispute” mean any claim, dispute, or controversy in contract, tort, statute, common law, or otherwise relating to your credit application, the loan agreement <br>Between you and us, and any other resulting transaction or relationship with us, our successors or assigns. “Claim,” “dealings,” or “dispute” includes the interpretation and scope of this Arbitration Agreement and whether or not the claim or dispute can be arbitrated. Any claim or dispute involving whether or not the claim or dispute can be arbitrated or the validity of the Class Action Waiver (defined below) shall be for the court, and not the arbitrator to resolve<br>Any claim or dispute is to be arbitrated on an individual basis and not as a class action. You expressly waive any right you may have to arbitrate a class action. This I called the “class Action Waiver.” We waive the right to require you to arbitrate an individual claim if the amount you seek to recover qualifies as a small claim within a small claims court’s jurisdiction under applicable law.</span>
<br>
<br>
<b>Procedure for Arbitration:</b><span>You may choose the American Arbitration Association(www.adr.org), or any other organization to conduct the arbitration, subject to our approval. You may get a copy of the rules of an arbitration organization by contacting the organization or visiting its website. The arbitration hearing shall be conducted in the federal district in which you reside, or such other place convenient to you as required by the rules of the chose arbitration organization. If you demand arbitration first, you will pay the filing fee if the chosen arbitration organization requires it. We will advance and/or pay any other fees and costs required by the rules of the chosen arbitration organization. </span>
<br><br/>

</div>
</td>
<td style="width:10%"></td>
<td style="vertical-align:baseline;text-align:justify;width:45%">
	<span>
		A continuación, usted encontrara la traducción al español del nuestro Acuerdo de Arbitraje. Un tercero independiente ha certificado esta traducción. Aunque nuestra intención es proveerle una traducción exacta, si la traducción al español es destina al documento en ingles, usted entiende y está de acuerdo que esta traducción se brinda simplemente como una cortesía, y que el documento en el idioma ingles regirá legalmente la relación entre usted y nosotros
	</span>
<br>
<br>
<b>NOTIFICACION DE ACUERDO DE ARBITRAJE</b><br>
<ul>
  <li style="padding-bottom:0.5em"><span>Este acuerdo establece que tanto usted como nosotros podemos elegir que se decida una disputa por medio de ARBITRAJE OBLIGATORIO en lugar de un tribunal.</li>
  <li style="padding-bottom:0.5em">Si usted o nosotros optamos por arbitrar, USTED RENUNCIA A TODO DERECHO DE HACER VALER O DEFENDER SUS DERECHOS EN UNA CORTE y NO TENDRA DERECHO A UN JUICIO CON JURADO O ANTE UN JUEZ.</li>
  <li style="padding-bottom:0.5em">Si usted o nosotros optamos por arbitrar, USTED RENUNCIA A TODO DERECHO A PARTICIPAR COMO UN REPRESENTATE O MIEMBRO DE UNA DEMANDA DE GRUPO. CONFORME A ESTE CONTRATO NO HAY DERECHO A LLEVAR UNA ACCION DE GRUP AL ARBITRAJE.</li>
  <li style="padding-bottom:0.5em">Usted tiene derecho de una AUDIENCIA JUSTA, PERO la obtención de pruebas y otros derechos TIENES ALCANCES MAS LIMITADOS QUE LAS REGLAS QUE SE APLICAN EN EL TRIBUNAL.</li>
  <li style="padding-bottom:0.5em">Las decisiones del arbitro pueden hacerse cumplir por orden de la corte y LOS DERECHOS DE APELACION TIENEN ALCANCES MAS LIMITADOS QUE EN UN LITIGIO DECIDIDO POR JURADO O JUEZ.</li>
  <li style="padding-bottom:0.5em">Este acuerdo de arbitraje y todo arbitraje conforme a este acuerdo será regido por la Ley Federal de Arbitraje/The Federal Arbitración Act (9 U.S.C & 1, et seq.).</li>
  <li>USTED TIENE EL DERECHO A EXCLUIRSE DEL PRESENTE ACUERDO DE ARBITRAJE mediante el procedimiento descrito en el párrafo titulado “Procedimiento de Exclusión Voluntaria”.</span></li>
</ul>

<br>
<b>PARA MAS DETALLES POR FAVOR LEA ESTE ACUERDO DE ARBITRAJE CON   CUIDADO.</b><br><br><span>En este acuerdo de arbitraje, “usted” se refiere al solicitante(s) del préstamo. “nosotros”, “nos” y “nuestro(a)” se refiere a Pacifica Finance Group, y nuestros causahabientes y cesionarios. Este acuerdo de arbitraje es incluido y forma parte del contrato de préstamo entre usted y nosotros.</span>
<br>
<br><b>Partes y asuntos sujetos al arbitraje: </b><span>: este acuerdo de arbitraje aplica a toda reclamación y disputa entre usted y nosotros. Para los fines del presente acuerdo de arbitraje, las palabras “reclamación” y “disputa” tendrán el más amplio significado posible. “reclamación” y “disputa” significan toda reclamación o disputa en contacto, respetabilidad objetiva, leyes el derechocomún, o de otra manera en relación con su solicitud de crédito, el contrato de préstamo entre usted y nosotros, y cualquier, otra transacción o relación que resulte con mostros o con nuestros sucesores o cesionarios. “reclamación,” “transacciones” i “disputa” incluye la interpretación y los alcances de este acuerdo de arbitraje de arbitraje y si esta reclamación o dispute se puede arbitrar o no. Toda reclamación o disputa que atañe a si esta reclamación o dispute se puede arbitrar o a la validez de la renuncia de acción de grupo (definido a continuación) tendría que ser resuelto por el tribunal, no por el árbitro.<br>Toda reclamación o disputa se someterá a arbitraje de forma individual y no como una acción de grupo. Usted expresamente renuncia a todo derecho que tenga, de someter a una acción de grupo a arbitraje. A esto se llama la “Renuncia de Acción de Grupo” Renunciamos al derecho de obligarle a someter a arbitraje una reclamación individual si conforme a las leyes vigentes se puede considerar que el monto que usted busca recuperar califica como de cuantía menor dentro de la competencia del juzgado de cuantía menor. Procedimiento para el arbitraje.</span>
<br>

<br><b>Procedimiento para el arbitraje:</b><span>usted puede elegir la asociación americana de arbitraje (www.adr.org), o cualquier otra organización para llevar a cabo el arbitraje, sujeto a nuestra aprobación. Usted puede obtener una copia de las reglas de una organización de arbitraje contactándole o visitando su sitio en internet. La audiencia de arbitraje se llevara a cabo en el distrito federal en donde usted reside o en otro lugar que le convenga según lo que requieras las reglas de la organización de arbitraje elegida. Si usted comienza por exigir el arbitraje, usted pagara los derechos de trámite si la organización de arbitraje elegida lo requiere. Nosotros pagaremos el anticipo y/o cualquier otra tasa o costo requerido por las reglas de la organización de arbitraje elegida.</span>


</td>
</tr>

</tbody>
</table>
</div>
<br><br><br>

<table>
<tbody>
<tr>

<td>
Initials/Iniciales: <img src="https://pacificafinancegroup.com/loanportal/signature_commercial_loan/completed/doc_initials/'.$img_signed.'" alt="" style="height:300%" align="left"/>
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

// $pdf->Output('Case.pdf', 'I');

// $pdf_data = ob_get_contents();

// $file_name = $id."page_9";
// $path="Barcodes/".$file_name.".pdf";
// file_put_contents( $path, $pdf_data );
// $pdf->Output(dirname(__FILE__).'/Case.pdf', 'I');

// $pdf_data = ob_get_contents();
// $file_name = $id."page_9";
// $path = dirname(__FILE__) . "/Barcodes/" . $file_name . ".pdf";
// file_put_contents( $path, $pdf_data );

$file_name =$id. "page_9";
$path=dirname(__FILE__)."/Barcodes/".$file_name.".pdf";
$pdf->Output($path, 'F');
//============================================================+
// END OF FILE
//============================================================+

?>