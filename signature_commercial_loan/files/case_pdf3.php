<?php
$id = $_GET['id'];
$url_logo = "https://mymoneyline.com/lsbankingportal/signature_commercial_loan/completed/";

include 'dbconnect.php';
include 'dbconfig.php';
$iddd = $_GET['id'];
echo "idddd" . $iddd;

//echo "key is".$mail_key;

$sql1 = mysqli_query($con, "select * from commercial_loan_initial_banking where email_key='$iddd' ");

while ($row1 = mysqli_fetch_array($sql1)) {

  $mail_key = $row1['email_key'];
  $signed_status = $row1['sign_status'];

  $creation_datee = $row1['creation_date'];

  $timestamp = strtotime($creation_datee);
  $creation_date = date("m-d-Y", $timestamp);


  $fnd_id = $row1['user_fnd_id'];
  $loan_id_bor = $row1['loan_id'];

  $img_signed = $row1['signed_pic'];

  $result_sig = $url_logo . '/doc_signs/' . $img_signed;
}


//echo "ID is".$loan_id;





$sql2 = mysqli_query($con, "select * from fnd_user_profile where user_fnd_id='$fnd_id' ");
while ($row2 = mysqli_fetch_array($sql2)) {
  $ff_name = $row2['first_name'];
  $l_name = $row2['last_name'];
  $f_name = $ff_name . ' ' . $l_name;
  $address = $row2['address'];
  $city = $row2['city'];
  $state = $row2['state'];
  $zip = $row2['zip_code'];
  $mobile_number = $row2['mobile_number'];
  $address = $row2['address'];
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

$business_name = "";
$sql2 = mysqli_query($con, "select business_name from tbl_business_info where user_fnd_id='$fnd_id' ");
while ($row2 = mysqli_fetch_array($sql2)) {
  $business_name = $row2['business_name'];
}

$business_name = $business_name == "" ? "_______________":$business_name;

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

$pdf->SetFont('helvetica', '', 10);

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

  $html = '<br><br><img src="images/Money-Line-Logo.JPG" style="height:400%" align="left"/><br>
  Borrower Name/Nombre del Deudor: <span style="text-decoration:underline">'.$f_name.'</span><br>
Loan Number/Numero de Prestamo: <span style="text-decoration:underline">'.$loan_id_bor.'</span><br><br>

<b>Confesi??n de fallo: </b>El Prestatario por el presente autoriza irrevocablemente y faculta a cualquier abogado para comparecer ante cualquier tribunal de registro y confesar el juicio contra el Prestatario por el monto impago de este Pagare de Prestamo Comercial   como lo demuestra cualquier declaraci??n jurada firmada por un funcionario del Prestamista que establezca el monto adeudado, honorarios del abogado m??s los costos de la demanda, y para liberar todos los errores y renunciar a todos los derechos de apelaci??n. Si se ha completado una copia de este Pagare de Prestamo Comercial, verificada por una declaraci??n jurada, en el procedimiento, no ser?? necesario presentar el original como una orden judicial. El prestatario renuncia al derecho a cualquier suspensi??n de la ejecuci??n y al beneficio de todas las leyes de exenci??n vigentes ahora o en el futuro. No se considerar?? que un solo ejercicio de la orden y el poder para confesar el juicio anterior agote el poder, ya sea que cualquier ejercicio sea considerado o no por un tribunal como inv??lido, anulable o nulo; pero el poder continuar?? sin disminuir y puede ejercerse de vez en cuando, ya que el Prestamista puede elegir hasta que todos los montos adeudados en este Pagare de Prestamo Comercial hayan sido pagados en su totalidad. Por la presente, el Prestatario renuncia y libera todos y cada uno de los reclamos o causas de acci??n que el Prestatario pueda tener contra cualquier Abogado que act??e bajo los t??rminos de autoridad que el Prestatario ha otorgado en el presente documento que surjan o est??n relacionados con la confesi??n de juicio en virtud del presente.
<br>

<b>Ley vigente : </b>Este Pagare de Prestamo Commercial se regir?? por la ley del prestamista de California aplicable al prestamista y, en la medida en que no est?? precedida por la ley federal, sin tener en cuenta sus disposiciones sobre conflictos de leyes. Este Pagare de Prestamo Commercial ha sido aceptado por el prestatario y el prestamista en el Estado de California.
<br>
<b>Elecci??n del lugar : </b>Si hay una demanda, el prestatario acepta la solicitud del prestamista de someterse a la jurisdicci??n de los tribunales del condado de Los ??ngeles, estado de California o, si es necesario, ante los tribunales del distrito central de California. Cualquier demanda presentada a continuaci??n se archivar?? en el Palacio de Justicia de Van Nuys, o en la Divisi??n Oeste del Distrito Central de California, seg??n corresponda.
<br>


<b>Colateral : </b>Todo el inventario presente y futuro de ese negocio conocido como <span style="text-decoration:underline">'.$business_name.'</span>, as?? como todas las cuentas por cobrar.
<br>
<b>Garant??a personal : </b>Este contrato tiene una garant??a personal del prestatario y el co-prestatario en caso de que el negocio mencionado anteriormente cierre o sea vendido a otra persona otras personas.
<br>
<b>Pago en el lugar : </b>El prestamista queda autorizado para cobrar los pagos adeudados bajo este Pagare de Prestamo Commercial en la direcci??n f??sica del prestatario, siendo: <span style="text-decoration:underline">' . $address . '  ' . $city . ' ' . $state . ' ' . $zip . '</span> .
<br>

<b>Inter??s sucesor : </b>Los t??rminos de este Pagare de Prestamo Commercial ser??n vinculantes para el prestatario y el prestamista, y para sus herederos, representantes personales y sucesores, y redundar??n en beneficio de los mismos. 
<br>

<b>Disposiciones Generales : </b>: El prestamista puede retrasar o renunciar a la aplicaci??n de cualquiera de sus derechos o recursos bajo este Pagare de Prestamo Commercial sin perderlos. Ante cualquier cambio en los t??rminos de este Pagare de Prestamo Commercial, y a menos que se indique expresamente lo contrario por escrito, ninguna parte que firme este Pagare de Prestamo Commercial, ya sea como fabricante, garante, fabricante de alojamiento o endosante, quedar?? eximida de responsabilidad. Todas estas partes acuerdan que el Prestador puede renovar o extender (repetidamente y por cualquier per??odo de tiempo) este pr??stamo o liberar a cualquier parte o garante; y tomar cualquier otra acci??n que el prestador considere necesaria sin el consentimiento o aviso de nadie. Todas estas partes tambi??n acuerdan que el prestamista puede modificar este pr??stamo sin el consentimiento o aviso de cualquier otra persona que sera la parte con la que se realiza la modificaci??n. Las obligaciones bajo este Pagare de Prestamo Commercial son conjuntas y varias. 
<br>


<b><span style="font-size: 9px">
ANTES DE FIRMAR ESTE PAGARE DE PRESTAMO COMERCIAL, EL PRESTATARIO LEA Y COMPRENDE TODAS LAS DISPOSICIONES DE ESTE PAGARE DE PRESTAMO COMERCIAL, INCLUIDAS LAS DISPOSICIONES DE TASA DE INTER??S, EL PRESTATARIO ACUERDA LOS T??RMINOS DE ESTE PAGARE DE PRESTAMO COMERCIAL.
<br>
EL PRESTATARIO RECONOCE EL RECIBO DE UNA COPIA COMPLETA DE ESTE PAGARE DE PRESTAMO COMERCIAL PROMISORIA.


</span>
</b>
<br><br>

Firma del Prestatario : _________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fecha :'.$creation_date.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<br><br>
Firma del Co-Prestatario : _________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fecha :'.$creation_date.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<br><br>
Nombre del Prestamista   : <span style="text-decoration:underline">MY MONEY LINE</span>
<br><br>
Firma Autorizada del Prestamista :<span style="text-decoration:underline">MY MONEY LINE</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fecha :'.$creation_date.'

';

$pdf->writeHTML($html,25,30); 


 
$data_shipment  = ":";



$pdf->Ln();
$html = '<h1>LSBANKING </h1>';
$html_underline = '<b style="text-decoration:underline">PLEASE LEAVE THIS LABEL UNCOVERED.</b>';
// ---------------------------------------------------------

//Close and output PDF document

// $pdf->Output(dirname(__FILE__).'/Case.pdf', 'I');

// $pdf_data = ob_get_contents();
// $file_name = $id."page_4";
// $path = dirname(__FILE__) . "/Barcodes/" . $file_name . ".pdf";
// file_put_contents( $path, $pdf_data );

$file_name =$id. "page_4";
$path=dirname(__FILE__)."/Barcodes/".$file_name.".pdf";
$pdf->Output($path, 'F');

//============================================================+
// END OF FILE
//============================================================+

?>