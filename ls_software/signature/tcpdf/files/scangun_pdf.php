<?php


nclude_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

ob_start();
//============================================================+
// File name   : example_050.php
// Begin       : 2009-04-09
// Last Update : 2013-05-14
//
// Description : Example 050 for TCPDF class
//               2D Barcodes
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: 2D barcodes.
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Crunch Apple ');
$pdf->SetTitle('2dbarcodefba');
$pdf->SetSubject('');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// NOTE: 2D barcode algorithms must be implemented on 2dbarcode.php class file.

// set font
$pdf->SetFont('helvetica', '', 11);

// add a page
$pdf->AddPage();

// print a message
//$txt = $_GET['text'];
$key1 = $_GET['key'];
$id1 = $_GET['id'];
$des = $_GET['dest'];
$sellername = $_GET['seller'];
$boxweight = $_GET['weight'];
$shipnotes = $_GET['notes'];

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
$style1 = array(
	'border' => false,
	'vpadding' => 'auto',
	'hpadding' => 'auto',
	'fgcolor' => array(0,0,0),
	'bgcolor' => false, //array(255,255,255)
	'module_width' => 1, // width of a single module in points
	'module_height' => 1,
	 '-webkit-transform'=> 'rotate(45deg)',
    '-moz-transform'=>'rotate(45deg)',
    '-o-transform'=>'rotate(45deg)',
    '-ms-transform'=> 'rotate(45deg)',
    'transform'=> 'rotate(45deg)' // height of a single module in points
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


// -------------------------------------------------------------------
// PDF417 (ISO/IEC 15438:2006)

/*

 The $type parameter can be simple 'PDF417' or 'PDF417' followed by a
 number of comma-separated options:

 'PDF417,a,e,t,s,f,o0,o1,o2,o3,o4,o5,o6'

 Possible options are:

 	a  = aspect ratio (width/height);
 	e  = error correction level (0-8);

 	Macro Control Block options:

 	t  = total number of macro segments;
 	s  = macro segment index (0-99998);
 	f  = file ID;
 	o0 = File Name (text);
 	o1 = Segment Count (numeric);
 	o2 = Time Stamp (numeric);
 	o3 = Sender (text);
 	o4 = Addressee (text);
 	o5 = File Size (numeric);
 	o6 = Checksum (numeric).

 Parameters t, s and f are required for a Macro Control Block, all other parametrs are optional.
 To use a comma character ',' on text options, replace it with the character 255: "\xff".

*/


   $sql=mysqli_query($con, "select * from tbl_shipments where shipment_key = '$key1'"); 
   
while($row = mysqli_fetch_array($sql)) {
$shipment_id=$row[0];
$Shipment_key1=$row[1];
$Shipmentt_ID=$row[2];
$Destination1=$row[3];
$Seller_Name1 =$row[4];
$Box_Weight1=$row[5];
$shipment_notes1=$row[6];
$quantity = $row[7];
$box_number = $row[10];

//$data_shipment = "Shipment Key : " .$Shipment_key1;
$data_shipment  = "Shipment ID :" .$Shipmentt_ID;
$data_shipment .= " - BOX ID :" .$box_number;
$data_shipment .= " - Box Weight:" .$Box_Weight1;
$data_shipment .= " - TOTAL UNITS:" .$quantity ;
}


$pdf->Text(15, 100, "SHIPMENT ID : ".$Shipmentt_ID." | BOX NUMBER: " . $box_number);
$pdf->Text(15, 105, "WEIGHT : ". $Box_Weight1. " | TOTAL UNITS : ". $quantity );
$pdf->Text(8, 109, "________________________________________________________________________________________________");


$pdf->Ln();
$html = '<h1>FBA </h1>';
$html_underline = '<b style="text-decoration:underline">PLEASE LEAVE THIS LABEL UNCOVERED.</b>';
$pdf->writeHTML($html,15,113);
$pdf->writeHTML($html_underline,15,119);
//$pdf->Text(15, 119, $html_underline);

$pdf->Text(15, 128, "SHIP FROM:");
$pdf->Text(15, 132, $Seller_Name1);
$pdf->Text(15, 136, "3022 US 1 / 158 HWY");
$pdf->Text(15, 139, "HENDERSON , NC 27537");
$pdf->Text(115, 128, "SHIP TO:");

$pdf->Text(115, 135, "AMAZON");
$pdf->Text(115, 139, $Destination1);



$i=180;

$sqlitems=mysqli_query($con,"select * from tbl_shipments_items where shipment_key='$key1' AND status='1'");
$barcode_items = "AMZN,PO:".$Shipmentt_ID;
while($row = mysqli_fetch_array($sqlitems)) {
$item_id=$row['0'];
$item_shipment_key=$row['1'];
$item_Shipment_ID=$row['2'];
$item_id_type=$row['4'];
$item_Identifier=$row['5'];
$item_Items=$row['6'];
$item_Expiration_Date=$row['7'];
$item_Quantity=$row['9'];
$item_Box_Quantity=$row['9'];
$month= substr($item_Expiration_Date, 0, 2);
$year= substr($item_Expiration_Date, 6, 2);
$date= substr($item_Expiration_Date, 3, 2);

$barcode_items .= ",".$item_id_type.":".$item_Identifier . ",QTY:" . $item_Quantity.","; 
if ($item_Expiration_Date == "") {
}
else {
	$barcode_items .= "EXP:".$year.$month.$date;
}

//$i = $i + 7;
//$pdf->Text(15, $i, "ITEM: ".$item_Identifier . "(".$item_Quantity.")");

}

$barcode_items = rtrim($barcode_items,',');
$barcode_items = str_replace(",,",",",$barcode_items);


//$pdf->Text(15, 169, $barcode_items );
$pdf->Ln();

$pdf->write2DBarcode($barcode_items, 'PDF417', 10, 10, 1000, 90, $style);


// CODE 128 AUTO
$pdf->write1DBarcode($Shipmentt_ID."U".str_pad($box_number,6,"0",STR_PAD_LEFT), 'C128', '', '', '', 35, 0.8, $style, 'N');

$pdf->Ln();

$pdf->Text(65, 177, $Shipmentt_ID."U".str_pad($box_number,6,"0",STR_PAD_LEFT));

$pdf->write2DBarcode($Shipmentt_ID."U".str_pad($box_number,6,"0",STR_PAD_LEFT), 'PDF417', 90, 180, 300, 80, $style1);

//$pdf->Text(90, 237, "FBA".$Shipmentt_ID."CU".str_pad($box_number,6,"0",STR_PAD_LEFT));

// Printing data of all barcodes:

//$pdf->Text(15, 247,"1st PDF417 Barcode data : ". $data_shipment);

//$pdf->Text(15, 257,"C17 and PDF417 Barcode : ".$barcode_items);

//End

$sqlitems=mysqli_query($con,"select * from tbl_shipments_items where shipment_key='$key1' AND status='1'");
$barcode_items = "";
while($row = mysqli_fetch_array($sqlitems)) {
$item_id=$row['0'];
$item_shipment_key=$row['1'];
$item_Shipment_ID=$row['2'];
$item_id_type=$row['4'];
$item_Identifier=$row['5'];
$item_Items=$row['6'];
$item_Expiration_Date=$row['7'];
$item_Quantity=$row['9'];
$item_Box_Quantity=$row['9'];


$barcode_items .= $item_Identifier . ":  " . $item_Quantity."/n"; 

$i = $i + 7;
$pdf->Text(15, $i, $item_Identifier . "(".$item_Quantity.")");

}

// -------------------------------------------------------------------
// DATAMATRIX (ISO/IEC 16022:2006)


// -------------------------------------------------------------------


// ---------------------------------------------------------

//Close and output PDF document


$pdf->Output('Scangun.pdf', 'I');

$pdf_data = ob_get_contents();

$path="Barcodes/$Shipment_key1.pdf";
file_put_contents( $path, $pdf_data );

//============================================================+
// END OF FILE
//============================================================+



?>