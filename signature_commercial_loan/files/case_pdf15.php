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

 $html = '
<h1 style="text-align:center"> <span style="text-decoration:underline">AVISO DE PRIVACIDAD</span><br>
Pacifica Finance Group</h1>
 
 
 <table style="width: 100%;" border="1">
<tbody>
<tr>
<td style="width: 15.8733%; text-align:center; background-color:black;color:white"><br><br>HECHOS<br></td>
<td style="width: 83.1267%; text-align:center"><br><br>QUE HACE Pacifica Finance Group CON SU INFORMACION PERSONAL?<br></td>
</tr>
<tr>
<td style="width: 15.8733%;text-align:center; background-color:grey;color:white"><br><br><br><br>Porque?<br></td>
<td style="width: 83.1267%;"><br><br>Las Empresas Financieras eligen la manera en que comparten su informacion personal. Las Leyes Federales dan a los consumidores el derecho a limitar como comparten la informacion, pero no se puede limitar todo. Las Leyes Federales tambien nops obligan a informales sobre la manera en que tomamos, compartimos y protegemos sus datos personales. Por favor lea esta notificacion cuidadosamente para entender lo que hacemos.<br><br></td>
</tr>
<tr>
<td style="width: 15.8733%;text-align:center; background-color:grey;color:white"><br><br><br><br><br>Que?<br></td>
<td style="width: 83.1267%;"><br><br>Los tipos de datos personales que tomamos y compartimos dependen del producto o servicio que tenga con nosotros. Estos
datos pueden incluir:<br><br>
• Numero de Seguro Social y Ingresos<br>
• Saldos de cuentas e historial de pagos<br>
• Historial de credito<br><br></td>
</tr>
<tr>
<td style="width: 15.8733%;text-align:center; background-color:grey;color:white"><br><br><br><br>Como ? <br></td>
<td style="width: 83.1267%;"><br><br>Todas las Empresas Financieras necesitan compartir la informacion personal de sus clientes para llevar a cabo sus actividades
diarias. En la Seccion siguiente describimos las razones por las que las Empresas Financieras pueden compartir la informacion
personal de sus clientes; las razones por las cuales Pacifica Finance Group elige compartir dicha informacion y si usted puede limitar
que se comparten dicha informacion. 
<br><br></td>
</tr>
</tbody>
</table>
 
<br><br>
<table style="width: 100%;" border="1">
<tbody>
<tr>
<td style="width: 60%; text-align:left; color:white; background-color:grey "><b>Razones por las que compartimos su informacion personal</b></td>
<td style="width: 20.1019%; text-align:center;background-color:grey; color:white"><b>Pacifica Finance Group
Comparte?</b></td>
<td style="width: 20.8981%; text-align:center;background-color:grey; color:white"><b>Usted puede limitar?</b></td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>Para nuestras actividades diarias –</b><br>
tales como procesar sus operaciones, mantener su(s) cuenta(s), responder
requisitos judiciales e investigaciones legales o reportar a agencias de credito.<br></td>
<td style="width: 20.1019%;text-align:center"><br><br> Yes &nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> No&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>Para nuestras actividades comerciales –</b> <br>
para ofrecerle nuestros productos y servicios<br></td>
<td style="width: 20.1019%;text-align:center"><br><br> Yes &nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> No&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>Para comercializacion conjunta con otras empresas financieras–</b> <br></td>
<td style="width: 20.1019%;text-align:center"><br><br> No&nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> No Compartimos&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>Para las actividades diarias de nuestros afiliados –</b> <br>informacion acerca de sus operaciones y experiencias&nbsp;</td>
<td style="width: 20.1019%;text-align:center"><br><br> No&nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> No Compartimos&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>Para las actividades diarias de nuestros afiliados –</b> <br>informacion sobre su solvencia<br></td>
<td style="width: 20.1019%;text-align:center"><br><br> No&nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> No Compartimos&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>Para que nuetros afiliados lleven a cabo actividades comerciales –</b> <br>&nbsp;</td>
<td style="width: 20.1019%;text-align:center"><br><br> No&nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> No Compartimos&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>Para que las empresas no afiliadas lleven a cabo actividades comerciales</b> <br>&nbsp;</td>
<td style="width: 20.1019%;text-align:center"><br><br>No &nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> No Compartimos&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><b>Preguntas ? </b> &nbsp;</td>
<td colspan = "2" style="width: 20.1019%;">Llamenos al (323) 797-5398</td>
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

//$pdf_data = ob_get_contents();
// $pdf->Output(dirname(__FILE__).'/Case.pdf', 'I');

// $pdf_data = ob_get_contents();
// $file_name = $id."page_16";
// $path = dirname(__FILE__) . "/Barcodes/" . $file_name . ".pdf";
// file_put_contents( $path, $pdf_data );

$file_name =$id. "page_16";
$path=dirname(__FILE__)."/Barcodes/".$file_name.".pdf";
$pdf->Output($path, 'F');
//file_put_contents( $path, $pdf_data );



//============================================================+
// END OF FILE
//============================================================+

?>