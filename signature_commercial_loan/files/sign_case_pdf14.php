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
<h1 style="text-align:center"> <span style="text-decoration:underline">PRIVACY NOTICE</span><br>
Pacifica Finance Group</h1>
 
 
 <table style="width: 100%;" border="1">
<tbody>
<tr>
<td style="width: 15.8733%; text-align:center; background-color:black;color:white"><br><br>FACTS<br></td>
<td style="width: 83.1267%; text-align:center"><br><br>WHAT DOES Pacifica Finance Group DO WITH YOUR PERSONAL INFORMATION?<br></td>
</tr>
<tr>
<td style="width: 15.8733%;text-align:center; background-color:grey;color:white"><br><br><br><br>WHY ?<br></td>
<td style="width: 83.1267%;"><br><br>Financial Companies choose how they share your personal information. Federal law gives consumers the right to limit some
but not all sharing. Federal law also requires us to tell you how we collect, share, and protect your personal
information. Please read this notice carefully to understand what we do. <br><br></td>
</tr>
<tr>
<td style="width: 15.8733%;text-align:center; background-color:grey;color:white"><br><br><br><br><br>WHAT ?<br></td>
<td style="width: 83.1267%;"><br><br>The types of personal information we collect and share depend on the product or service you have with us. This information
can include:<br><br>
• Social Security number and income<br>
• Account balances and payment history<br>
• Credit history and credit scores <br><br></td>
</tr>
<tr>
<td style="width: 15.8733%;text-align:center; background-color:grey;color:white"><br><br><br><br>HOW ? <br></td>
<td style="width: 83.1267%;"><br><br>All financial companies need to share customer’s personal information to run their everyday business.<br>
In the section below, we list the reasons financial companies can share their customers’ personal information; the
reasons Pacifica Finance Group chooses to share; and whether you can limit this sharing. 
<br><br></td>
</tr>
</tbody>
</table>
 
<br><br>
<table style="width: 100%;" border="1">
<tbody>
<tr>
<td style="width: 60%; text-align:left; color:white; background-color:grey "><b>Reason we can share your personal information</b></td>
<td style="width: 20.1019%; text-align:center;background-color:grey; color:white"><b>Does Pacifica Finance Group
Share?</b></td>
<td style="width: 20.8981%; text-align:center;background-color:grey; color:white"><b>Can you limit this
sharing?</b></td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>For our everyday business purposes –</b><br>
such as to process your transactions, maintain your account(s), respond to court
orders and legal investigations, prevent or mitigate fraud, engage in corporate
transactions, or report to credit bureaus<br></td>
<td style="width: 20.1019%;text-align:center"><br><br> Yes &nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> No&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>For our marketing purposes –</b> <br>
to offer our products and services to you<br>&nbsp;</td>
<td style="width: 20.1019%;text-align:center"><br><br> No&nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> We Dont Share&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>For joint marketing with other financial companies</b> <br>&nbsp;</td>
<td style="width: 20.1019%;text-align:center"><br><br> No&nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> We dont share&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>For our affiliates’ everyday business purposes –</b> <br>
information about your transactions and experiences<br><br>&nbsp;</td>
<td style="width: 20.1019%;text-align:center"><br><br> No&nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> We dont share&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>For our affiliates’ everyday business purposes –</b> <br>
information about your creditworthiness<br><br>&nbsp;</td>
<td style="width: 20.1019%;text-align:center"><br><br> No&nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> We dont share&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><br><b>For our affiliates to market to you</b> <br>&nbsp;</td>
<td style="width: 20.1019%;text-align:center"><br><br>No &nbsp;</td>
<td style="width: 20.8981%;text-align:center"><br><br> We dont share&nbsp;</td>
</tr>
<tr>
<td style="width: 60%;"><br><b>For non-affiliates to market to you</b> <br>&nbsp;</td>
<td style="width: 20.1019%;text-align:center"><br>NO</td>
<td style="width: 20.8981%;text-align:center"><br> We dont share</td>
</tr>
<tr>
<td style="width: 60%;"><br><b>Questions ? </b> &nbsp;</td>
<td colspan = "2" style="width: 20.1019%;">Please Call (888) 540-7232</td>
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

// $file_name = $id."page_14";
// $path="Barcodes/".$file_name.".pdf";
// file_put_contents( $path, $pdf_data );
// $pdf->Output(dirname(__FILE__).'/Case.pdf', 'I');

// $pdf_data = ob_get_contents();
// $file_name = $id."page_15";
// $path = dirname(__FILE__) . "/Barcodes/" . $file_name . ".pdf";
// file_put_contents( $path, $pdf_data );

$file_name =$id. "page_15";
$path=dirname(__FILE__)."/Barcodes/".$file_name.".pdf";
$pdf->Output($path, 'F');

//============================================================+
// END OF FILE
//============================================================+

?>