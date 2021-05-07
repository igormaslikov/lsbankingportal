<?php
$id1 = "sign_case_pdf.php?id=".$_GET['id'];
$id2 = "sign_case_pdf1.php?id=".$_GET['id'];
$id3 = "sign_case_pdf2.php?id=".$_GET['id'];
$id4 = "sign_case_pdf3.php?id=".$_GET['id'];
$id5 = "sign_case_pdf4.php?id=".$_GET['id'];
$id6 = "sign_case_pdf5.php?id=".$_GET['id'];
$id7 = "sign_case_pdf6.php?id=".$_GET['id'];
$id8 = "sign_case_pdf7.php?id=".$_GET['id'];
$id9 = "sign_case_pdf8.php?id=".$_GET['id'];
$id10 = "sign_case_pdf9.php?id=".$_GET['id'];
$id11 = "sign_case_pdf10.php?id=".$_GET['id'];
$id12 = "sign_case_pdf11.php?id=".$_GET['id'];
$id13 = "sign_case_pdf12.php?id=".$_GET['id'];
$id14 = "sign_case_pdf13.php?id=".$_GET['id'];
$id15 = "sign_case_pdf14.php?id=".$_GET['id'];

//echo $id1;
//require_once("case_pdf.php");
include($id1);
include($id2);
include($id3);
include($id4);
include($id5);
include($id6);
include($id7);
include($id8);
include($id9);
include($id10);
include($id11);
include($id12);
include($id13);
include($id14);
include($id15);
//include('merge_pdf.php');

?>

<iframe src="sign_case_pdf.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px; display:none"></iframe>
<iframe src="sign_case_pdf1.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_case_pdf2.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_case_pdf3.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_case_pdf4.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_case_pdf5.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_case_pdf6.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_case_pdf7.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_case_pdf8.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_case_pdf9.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_case_pdf10.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_case_pdf11.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_case_pdf12.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_case_pdf13.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_case_pdf14.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:1000px;display:none"></iframe>
<iframe src="sign_merge_pdf.php?id=<?php echo $_GET['id']; ?>" style="width:100%; height:100%; overflow:hidden"></iframe>