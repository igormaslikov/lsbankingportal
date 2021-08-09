<?php

require('fpdf_merge.php');

ob_start();
$merge = new FPDF_Merge();
$j="";
for($i=1;$i<=16;$i++){
$new = "Barcodes/".$_GET['id']."page_".$i.".pdf";

// if (!file_exists($new)) {
//     echo "not exists";
//     exit();
// }
$merge->add($new);

}

$merge->output();
$pdf_data = generate_pdf();

$pdf_data = ob_get_contents();
$path='Barcodes/umer.pdf';
file_put_contents( $path, $pdf_data );
?>