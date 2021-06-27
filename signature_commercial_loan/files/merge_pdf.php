<?php

require('fpdf_merge.php');

ob_start();
$merge = new FPDF_Merge();
$j="";
for($i=1;$i<=16;$i++){
$new = "Barcodes/".$_GET['id']."page_".$i.".pdf";
$merge->add($new);

}

$merge->output();
$pdf_data = generate_pdf();

$pdf_data = ob_get_contents();
$path='Barcodes/umer.pdf';
file_put_contents( $path, $pdf_data );

// $dirMerge = __DIR__.'/Barcodes/'.$_GET['id'];

// if (!file_exists($dirMerge)) {
//     mkdir($dirMerge, 0777, true);
// }
//  // $merge->output(__DIR__."/test.pdf");
// $merge->output($dirMerge."/contract.pdf");
?>