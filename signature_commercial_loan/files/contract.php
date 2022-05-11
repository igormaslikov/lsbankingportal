<?php
// $id1 = "case_pdf.php?id=".$_GET['id'];
// $id2 = "case_pdf1.php?id=".$_GET['id'];
// $id3 = "case_pdf2.php?id=".$_GET['id'];
// $id4 = "case_pdf3.php?id=".$_GET['id'];
// $id5 = "case_pdf4.php?id=".$_GET['id'];
// $id6 = "case_pdf5.php?id=".$_GET['id'];
// $id7 = "case_pdf6.php?id=".$_GET['id'];
// $id8 = "case_pdf7.php?id=".$_GET['id'];
// $id9 = "case_pdf8.php?id=".$_GET['id'];
// $id10 = "case_pdf9.php?id=".$_GET['id'];
// $id11 = "case_pdf10.php?id=".$_GET['id'];
// $id12 = "case_pdf11.php?id=".$_GET['id'];
// $id13 = "case_pdf12.php?id=".$_GET['id'];
// $id14 = "case_pdf13.php?id=".$_GET['id'];
// $id15 = dirname(__FILE__)."\case_pdf14.php?id=".$_GET['id'];

//echo $id1;
//require_once("case_pdf.php");
// include($id1);
// include($id2);
// include($id3);
// include($id4);
// include($id5);
// include($id6);
// include($id7);
// include($id8);
// include($id9);
// include($id10);
// include($id11);
// include($id12);
// include($id13);
// include($id14);
//include($id15);
//include('merge_pdf.php');
$dirMerge = 'Barcodes/'.$_GET['id'];
?>

<iframe src="case_pdf.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px; display:none"></iframe>
<iframe src="case_pdf1.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="case_pdf2.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="case_pdf3.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="case_pdf4.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="case_pdf5.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="case_pdf6.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="case_pdf7.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="case_pdf8.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="case_pdf9.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="case_pdf10.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="case_pdf11.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="case_pdf12.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="case_pdf13.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="case_pdf14.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="case_pdf15.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="merge_pdf.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:100%; overflow:hidden"></iframe>