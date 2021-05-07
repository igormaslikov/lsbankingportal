<?php
$id1 = "case_pdf.php?id=".$_GET['id'];
$id2 = "case_pdf1.php?id=".$_GET['id'];
$id3 = "case_pdf2.php?id=".$_GET['id'];
$id4 = "case_pdf3.php?id=".$_GET['id'];
$id5 = "case_pdf4.php?id=".$_GET['id'];
$id6 = "case_pdf5.php?id=".$_GET['id'];
$id7 = "case_pdf6.php?id=".$_GET['id'];
//echo $id1;
//require_once("case_pdf.php");
include($id2);
include($id3);
include($id4);
include($id5);
include($id6);
include($id7);
//include('merge_pdf.php');

?>

<iframe src="case_pdf.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px; display:none"></iframe>
<iframe src="case_pdf1.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="case_pdf2.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="case_pdf3.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="case_pdf4.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="case_pdf5.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="case_pdf6.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="merge_pdf.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:100%; overflow:hidden"></iframe>