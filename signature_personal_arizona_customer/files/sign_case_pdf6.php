<?php
$id=$_GET['id'];
?>


<?php
$url_logo="https://ofsca.com/loanportal/signature_personal_arizona_customer/completed/";
include 'dbconnect.php';
include 'dbconfig.php';
$iddd=$_GET['id'];
// echo "idddd". $iddd;

//echo "key is".$mail_key;

$sql1=$con->query("select * from personal_loan_initial_banking where email_key='$iddd' "); 

while($row1 = $sql1->fetch_array()) {

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


//echo "ID is".$loan_id;



$sql_loan=$con->query("select * from tbl_personal_loans where loan_id= '$loan_id_bor' "); 

while($row_loan = $sql_loan->fetch_array()) {
    
    
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




$sql2=$con->query("select * from fnd_user_profile where user_fnd_id='$fnd_id' "); 

while($row2 = $sql2->fetch_array()) {

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

$pdf->SetFont('helvetica', '', 9);

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
Borrower Name/Nombre del Deudor: <span style="text-decoration:underline">'.$f_name.'</span><br>
Loan Number/Numero de Prestamo: <span style="text-decoration:underline">'.$loan_id_bor.'</span><br>
Date/Fecha: <span style="text-decoration:underline">'.$creation_date.'</span>
 <h3 style="text-align:center"><u>Arbitration Agreement / Acuerdo de Arbitraje</u></h3>
<table>
<tbody>
<tr>
<td><span style="font-size:7px;">To the right, you will find a Spanish-Language translation of our Arbitration Agreement. An independent third party has certified this translation. While it is our intention to provide an accurate translation, if the Spanish translation differs from the English Document; you understand and agree that the Spanish translation is provided solely as courtesy to you, and that the English Document is the legally binding agreement between you and us.</span>
<br>
<b style="font-size:7px;">NOTICE OF ARBITRATION AGREEMENT</b><br><span style="font-size:6px;">â€¢	This agreement provides that either you or we may choose to have any dispute decided by BINDING ARBITRATION instead of court.
<br>
â€¢	If either you or we choose to arbitrate, YOU GIVE UP YOUR RIGHT TO GO TO COURT TO ASSERT OR DEFEND YOUR RIGHTS AND YOU WILL HAVE NO RIGHT TO A TRIAL BY JURTYOR BEFORE A JUDGE.
<br>
â€¢	You are entitled to a FAIR HEARING, BUT discovery and other rights are MORE LIMITED THAN RULES APPLICABLE IN COURT
<br>
â€¢	Arbitrator decisions are enforceable by court order and RIGHTS TO APPEAL ARE MORE LIMITED THAN IN A LAWSUIT DECIDED BY A JUDGE OR JURY.
<br>
â€¢	This arbitration agreement and any arbitration under this agreement shall be governed by the Federal Arbitration Act (9 U.S.C & 1, et seq.).
<br>
â€¢	YOU HAVE THE RIGHT TO â€œOPT OUTâ€ OF THIS ARBITRATION AGREEMENT by following the procedure outlined in the section entitled â€œOpt out Proceduresâ€.</span>
<br>
<b style="font-size:5px;">FOR MORE DETAILS, PLEASE READ CAREFULLY THIS ARBITRATION AGREEMENT CAREFULLY.</b><br><span style="font-size:5px;"> In this Arbitration Agreement, â€œyouâ€ refers to the borrower(s). â€œweâ€, â€œusâ€, and â€œourâ€ refers to Optima Financial Solutions Inc, our successors-in-interest and assigns. This arbitration agreement is incorporated into and is a part of a loan agreement between you and us.</span>
<br>

<b style="font-size:7px;">Parties and Matters Subject to Arbitration: </b><span style="font-size:6px;">This Arbitration agreement applies to all claims and disputes between you and us. For purposes of this Arbitration agreement the words â€œclaimâ€ and â€œdisputeâ€ are given the broadest possibly meaning. â€œClaimâ€ and â€œdisputeâ€ mean any claim, dispute, or controversy in contract, tort, statute, common law, or otherwise relating to your credit application, the loan agreement <br>Between you and us, and any other resulting transaction or relationship with us, our successors or assigns. â€œClaim,â€ â€œdealings,â€ or â€œdisputeâ€ includes the interpretation and scope of this Arbitration Agreement and whether or not the claim or dispute can be arbitrated. Any claim or dispute involving whether or not the claim or dispute can be arbitrated or the validity of the Class Action Waiver (defined below) shall be for the court, and not the arbitrator to resolve<br>Any claim or dispute is to be arbitrated on an individual basis and not as a class action. You expressly waive any right you may have to arbitrate a class action. This I called the â€œclass Action Waiver.â€ We waive the right to require you to arbitrate an individual claim if the amount you seek to recover qualifies as a small claim within a small claims courtâ€™s jurisdiction under applicable law.</span>
<br>

<b style="font-size:7px;">Procedure for Arbitration:</b><span style="font-size:6px;">You may choose the American Arbitration Association(www.adr.org), or any other organization to conduct the arbitration, subject to our approval. You may get a copy of the rules of an arbitration organization by contacting the organization or visiting its website. The arbitration hearing shall be conducted in the federal district in which you reside, or such other place convenient to you as required by the rules of the chose arbitration organization. If you demand arbitration first, you will pay the filing fee if the chosen arbitration organization requires it. We will advance and/or pay any other fees and costs required by the rules of the chosen arbitration organization. </span>
<br><br>

Initials/Iniciales: '."<img src='$sign_image_url' style='height:130%;width:35%;margin-bottom:-20%;' />".'
</td>
<td></td>


<td><span style="font-size:6px;">A continuaciÃ³n, usted encontrara la traducciÃ³n al espaÃ±ol del nuestro Acuerdo de Arbitraje. Un tercero independiente ha certificado esta traducciÃ³n. Aunque nuestra intenciÃ³n es proveerle una traducciÃ³n exacta, si la traducciÃ³n al espaÃ±ol es destina al documento en ingles, usted entiende y estÃ¡ de acuerdo que esta traducciÃ³n se brinda simplemente como una cortesÃ­a, y que el documento en el idioma ingles regirÃ¡ legalmente la relaciÃ³n entre usted y nosotros</span>
<br>
<b style="font-size:7px;">NOTIFICACION DE ACUERDO DE ARBITRAJE</b><br><span style="font-size:6px;">â€¢	Este acuerdo establece que tanto usted como nosotros podemos elegir que se decida una disputa por medio de ARBITRAJE OBLIGATORIO en lugar de un tribunal.
<br>
â€¢	Si usted o nosotros optamos por arbitrar, USTED RENUNCIA A TODO DERECHO DE HACER VALER O DEFENDER SUS DERECHOS EN UNA CORTE y NO TENDRA DERECHO A UN JUICIO CON JURADO O ANTE UN JUEZ.
<br>
â€¢	Si usted o nosotros optamos por arbitrar, USTED RENUNCIA A TODO DERECHO A PARTICIPAR COMO UN REPRESENTATE O MIEMBRO DE UNA DEMANDA DE GRUPO. CONFORME A ESTE CONTRATO NO HAY DERECHO A LLEVAR UNA ACCION DE GRUP AL ARBITRAJE.
<br>
â€¢	Usted tiene derecho de una AUDIENCIA JUSTA, PERO la obtenciÃ³n de pruebas y otros derechos TIENES ALCANCES MAS LIMITADOS QUE LAS REGLAS QUE SE APLICAN EN EL TRIBUNAL.
<br>â€¢	Las decisiones del arbitro pueden hacerse cumplir por orden de la corte y LOS DERECHOS DE APELACION TIENEN ALCANCES MAS LIMITADOS QUE EN UN LITIGIO DECIDIDO POR JURADO O JUEZ.
<br>â€¢	Este acuerdo de arbitraje y todo arbitraje conforme a este acuerdo serÃ¡ regido por la Ley Federal de Arbitraje/The Federal ArbitraciÃ³n Act (9 U.S.C & 1, et seq.).
<br>â€¢	USTED TIENE EL DERECHO A EXCLUIRSE DEL PRESENTE ACUERDO DE ARBITRAJE mediante el procedimiento descrito en el pÃ¡rrafo titulado â€œProcedimiento de ExclusiÃ³n Voluntariaâ€.</span>
<br>
<b style="font-size:7px;">PARA MAS DETALLES POR FAVOR LEA ESTE ACUERDO DE ARBITRAJE CON   CUIDADO.</b><br><span style="font-size:6px;">En este acuerdo de arbitraje, â€œustedâ€ se refiere al solicitante(s) del prÃ©stamo. â€œnosotrosâ€, â€œnosâ€ y â€œnuestro(a)â€ se refiere a Optima Financial Solutions Inc, y nuestros causahabientes y cesionarios. Este acuerdo de arbitraje es incluido y forma parte del contrato de prÃ©stamo entre usted y nosotros.</span>
<br>
<b style="font-size:7px;">Partes y asuntos sujetos al arbitraje: </b><span style="font-size:6px;">: este acuerdo de arbitraje aplica a toda reclamaciÃ³n y disputa entre usted y nosotros. Para los fines del presente acuerdo de arbitraje, las palabras â€œreclamaciÃ³nâ€ y â€œdisputaâ€ tendrÃ¡n el mÃ¡s amplio significado posible. â€œreclamaciÃ³nâ€ y â€œdisputaâ€ significan toda reclamaciÃ³n o disputa en contacto, respetabilidad objetiva, leyes el derechocomÃºn, o de otra manera en relaciÃ³n con su solicitud de crÃ©dito, el contrato de prÃ©stamo entre usted y nosotros, y cualquier, otra transacciÃ³n o relaciÃ³n que resulte con mostros o con nuestros sucesores o cesionarios. â€œreclamaciÃ³n,â€ â€œtransaccionesâ€ i â€œdisputaâ€ incluye la interpretaciÃ³n y los alcances de este acuerdo de arbitraje de arbitraje y si esta reclamaciÃ³n o dispute se puede arbitrar o no. Toda reclamaciÃ³n o disputa que ataÃ±e a si esta reclamaciÃ³n o dispute se puede arbitrar o a la validez de la renuncia de acciÃ³n de grupo (definido a continuaciÃ³n) tendrÃ­a que ser resuelto por el tribunal, no por el Ã¡rbitro.<br>Toda reclamaciÃ³n o disputa se someterÃ¡ a arbitraje de forma individual y no como una acciÃ³n de grupo. Usted expresamente renuncia a todo derecho que tenga, de someter a una acciÃ³n de grupo a arbitraje. A esto se llama la â€œRenuncia de AcciÃ³n de Grupoâ€ Renunciamos al derecho de obligarle a someter a arbitraje una reclamaciÃ³n individual si conforme a las leyes vigentes se puede considerar que el monto que usted busca recuperar califica como de cuantÃ­a menor dentro de la competencia del juzgado de cuantÃ­a menor. Procedimiento para el arbitraje.</span>

<b style="font-size:7px;">Procedimiento para el arbitraje:</b><span style="font-size:6px;">usted puede elegir la asociaciÃ³n americana de arbitraje (www.adr.org), o cualquier otra organizaciÃ³n para llevar a cabo el arbitraje, sujeto a nuestra aprobaciÃ³n. Usted puede obtener una copia de las reglas de una organizaciÃ³n de arbitraje contactÃ¡ndole o visitando su sitio en internet. La audiencia de arbitraje se llevara a cabo en el distrito.</span>


</td>
</tr>

</tbody>
</table>
';

$sign_image_url= "https://ofsca.com/loanportal/signature_personal_arizona_customer/completed/doc_signs/".$img_signed;

$img = file_get_contents($sign_image_url);

$pdf->writeHTML($html,25,30); 

$pdf->Image('@' . $img, 15, 258, '30', '', 'JPG', '', 'T', false, 40, '', false, false, 0, false, false, false); 


 
$data_shipment  = ":";



$pdf->Ln();
$html = '<h1>LSBANKING </h1>';
$html_underline = '<b style="text-decoration:underline">PLEASE LEAVE THIS LABEL UNCOVERED.</b>';
// ---------------------------------------------------------

//Close and output PDF document

$pdf->Output('Case.pdf', 'I');

$pdf_data = ob_get_contents();

$file_name =$id. "page_7";
$path="Barcodes/".$file_name.".pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+

?>