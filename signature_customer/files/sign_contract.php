<?php
session_start();
$id1 = "sign_case_pdf.php?t=<?=time();?>&id=".$_GET['id'];
$id2 = "sign_case_pdf1.php?t=<?=time();?>&id=".$_GET['id'];
$id3 = "sign_case_pdf2.php?t=<?=time();?>&id=".$_GET['id'];
$id4 = "sign_case_pdf3.php?t=<?=time();?>&id=".$_GET['id'];
$id5 = "sign_case_pdf4.php?t=<?=time();?>&id=".$_GET['id'];
$id6 = "sign_case_pdf5.php?t=<?=time();?>&id=".$_GET['id'];
$id7 = "sign_case_pdf6.php?t=<?=time();?>&id=".$_GET['id'];
$id8 = "sign_case_pdf7.php?t=<?=time();?>&id=".$_GET['id'];
//echo $id1;
//require_once("case_pdf.php");
// include($id2);
// include($id3);
// include($id4);
// include($id5);
// include($id6);
// include($id7);
//include('merge_pdf.php');

?>

<iframe src="sign_case_pdf.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px; display:none"></iframe>
<iframe src="sign_case_pdf1.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_case_pdf2.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_case_pdf3.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_case_pdf4.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_case_pdf5.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_case_pdf6.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_case_pdf7.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_merge_pdf.php?t=<?=time();?>&id=<?php echo $_GET['id']; ?>" style="width:100%; height:100%; overflow:hidden"></iframe>