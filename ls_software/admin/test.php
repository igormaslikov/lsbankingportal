<?php

use setasign\Fpdi\Fpdi;
require_once('fpdf/fpdf.php');
require_once('fpdi/src/autoload.php');

$pdf =new Fpdi();


$pagecount = $pdf->setSourceFile("Optima- Business Contract14.pdf");
$tpl = $pdf->importPage(1);
$pdf->AddPage();
$pdf->useTemplate($tpl);

$pdf->SetXY(50,10);
//Select Arial italic 8
$pdf->SetFont('Arial','I',8);
//Print centered cell with a text in it
$pdf->Cell(10, 10, "Hello World 222", 0, 0, 'C');


$pdf->SetXY(50,15);
//Select Arial italic 8
$pdf->SetFont('Arial','I',8);
//Print centered cell with a text in it
$pdf->Cell(10, 10, "Igor 52", 0, 0, 'C');


$pdf->SetXY(200,300);
//Select Arial italic 8
$pdf->SetFont('Arial','I',8);
//Print centered cell with a text in it

$image = imagecreatefrompng('../../signature_commercial_loan/completed/doc_signs/00f12f71eb9ab2128b002c11f1799a85.png');
imagealphablending($image, true);
$transparentcolour = imagecolorallocatealpha($image, 255,255,255,127);
imagecolortransparent($image, $transparentcolour);
imagepng($image, "image.png");


$tpl = $pdf->importPage(2);
$pdf->AddPage();
$pdf->useTemplate($tpl);

$pdf->Image("image.png", 180,250, -200);

$pdf->Output("F","doc.pdf");
// include_once 'dbconnect.php';
// include 'dbconfig.php';

// $date_last_7days = date('Y-m-d',time()-(7*86400)); 
// echo "Fnd ID: $date_last_7days<br>";

// $sql=$con->query("select * from loan_transaction where created_at >='$date_last_7days'"); 

// while($row = $sql->fetch_array()) {
// $mobile_verification = $row['user_fnd_id'];
// $loan_create_id = $row['loan_create_id'];



// echo "Fnd ID: $mobile_verification: $loan_create_id<br>";




// }

?>