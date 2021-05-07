<?php
require('fpdf_merge.php');

$merge = new FPDF_Merge();
$merge->add('Barcodes/NqqDaGitpage_4.pdf');
$merge->output();
?>