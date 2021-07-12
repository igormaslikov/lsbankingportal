<?php
session_start();
include_once 'dbconnect.php';
include_once 'dbconfig.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$u_id=$userRow['user_id'];
//echo $u_id;
$u_access_id = $userRow['access_id'];
if($u_access_id=='0'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
}
else {
$DBcon->close();

?>
 <br><br>
  <br>
<div align="left">
  <a href="schedule_sms.php" style="text-align: center;"> <button class="btn btn-danger" style="color: #fff;background-color: #1E90FF;border-color: #1E90FF;text-align: center;">Schedule SMS</button></a>
  </div>
  <br>
  <iframe src="../marketing_sms/index.php" width="100%" height="860px"></iframe>
  <div class="row">
      
      <div class="col-lg-4">
  <?php


$query = "select * from url_counter where url='dinero' ";
//$query = "select * from decision_login_codes where  id = 564";

//echo $query . "<br>";
$sql=mysqli_query($con, "$query"); 

  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($sql);

while($row = mysqli_fetch_array($sql)) {
    
$counter = $row['url_counter'];
$website = $row['url'];
echo "<h3>Counter for Page ".$website." is : ".$counter."</h3>";

}

?>
</div>
<div class="col-lg-4">

<?php



$query_rapido = "select * from url_counter where url='rapido' ";
//$query = "select * from decision_login_codes where  id = 564";

//echo $query . "<br>";
$sql_rapido=mysqli_query($con, "$query_rapido"); 

  // Return the number of rows in result set
  $rowcount_rapido=mysqli_num_rows($sql_rapido);

while($row_rapido = mysqli_fetch_array($sql_rapido)) {
    
$counter_rapido = $row_rapido['url_counter'];
$website_rapido = $row_rapido['url'];
echo "<h3>Counter for Page ".$website_rapido." is : ".$counter_rapido."</h3>";

}

?>
</div>

<div class="col-lg-4">

<?php

include('dbconnect.php');
include('dbconfig.php');


$query_loan = "select * from url_counter where url='loan' ";
//$query = "select * from decision_login_codes where  id = 564";

//echo $query . "<br>";
$sql_loan=mysqli_query($con, "$query_loan"); 

  // Return the number of rows in result set
  $rowcount_loan=mysqli_num_rows($sql_loan);

while($row_loan = mysqli_fetch_array($sql_loan)) {
    
$counter_loan = $row_loan['url_counter'];
$website_loan = $row_loan['url'];
echo "<h3>Counter for Page ".$website_loan." is : ".$counter_loan."</h3>";

}

?>
</div>
</div>
<div class="row">
<div class="col-lg-4">
<?php



$query_prestamo = "select * from url_counter where url='prestamo' ";
//$query = "select * from decision_login_codes where  id = 564";

//echo $query . "<br>";
$sql_prestamo=mysqli_query($con, "$query_prestamo"); 

  // Return the number of rows in result set
  $rowcount_prestamo=mysqli_num_rows($sql_prestamo);

while($row_prestamo = mysqli_fetch_array($sql_prestamo)) {
    
$counter_prestamo = $row_prestamo['url_counter'];
$website_prestamo = $row_prestamo['url'];
echo "<h3>Counter for Page ".$website_prestamo." is : ".$counter_prestamo."</h3>";

}

?>
</div>
<div class="col-lg-4">
<?php



$query_credito = "select * from url_counter where url='credito' ";
//$query = "select * from decision_login_codes where  id = 564";

//echo $query . "<br>";
$sql_credito=mysqli_query($con, "$query_credito"); 

  // Return the number of rows in result set
  $rowcount_credito=mysqli_num_rows($sql_credito);

while($row_credito = mysqli_fetch_array($sql_credito)) {
    
$counter_credito = $row_credito['url_counter'];
$website_credito = $row_credito['url'];
echo "<h3>Counter for Page ".$website_credito." is : ".$counter_credito."</h3>";

}

?>

</div>



<div class="col-lg-4">
<?php



$query_aplicar = "select * from url_counter where url='aplicar' ";
//$query = "select * from decision_login_codes where  id = 564";

//echo $query . "<br>";
$sql_aplicar=mysqli_query($con, "$query_aplicar"); 

  // Return the number of rows in result set
  $rowcount_aplicar=mysqli_num_rows($sql_aplicar);

while($row_aplicar = mysqli_fetch_array($sql_aplicar)) {
    
$counter_aplicar = $row_aplicar['url_counter'];
$website_aplicar = $row_aplicar['url'];
echo "<h3>Counter for Page ".$website_aplicar." is : ".$counter_aplicar."</h3>";

}

?>

</div>


<div class="col-lg-4">
<?php



$query_payday = "select * from url_counter where url='payday' ";
//$query = "select * from decision_login_codes where  id = 564";

//echo $query . "<br>";
$sql_payday=mysqli_query($con, "$query_payday"); 

  // Return the number of rows in result set
  $rowcount_payday=mysqli_num_rows($sql_payday);

while($row_payday = mysqli_fetch_array($sql_payday)) {
    
$counter_payday = $row_payday['url_counter'];
$website_payday = $row_payday['url'];
echo "<h3>Counter for Page ".$website_payday." is : ".$counter_payday."</h3>";

}

?>

</div>



</div>
<hr>

<div class="row">
      
      <div class="col-lg-6">
  <?php



$query_payday = "select * from url_counter where url='payday_dinero' ";
//$query = "select * from decision_login_codes where  id = 564";

//echo $query . "<br>";
$sql_payday=mysqli_query($con, "$query_payday"); 

  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($sql_payday);

while($row_payday = mysqli_fetch_array($sql_payday)) {
    
$counter_payday = $row_payday['url_counter'];
$website_payday = $row_payday['url'];
echo "<h3>Counter for Page ".$website_payday." is : ".$counter_payday."</h3>";

}

?>
</div>



 <div class="col-lg-6">
  <?php



$query_payday_aplicar = "select * from url_counter where url='payday_aplicar' ";
//$query = "select * from decision_login_codes where  id = 564";

//echo $query . "<br>";
$sql_payday_aplicar=mysqli_query($con, "$query_payday_aplicar"); 

  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($sql_payday_aplicar);

while($row_payday_aplicar = mysqli_fetch_array($sql_payday_aplicar)) {
    
$counter_payday_aplicar = $row_payday_aplicar['url_counter'];
$website_payday_aplicar = $row_payday_aplicar['url'];
echo "<h3>Counter for Page ".$website_payday_aplicar." is : ".$counter_payday_aplicar."</h3>";

}

?>
</div>




 <div class="col-lg-6">
  <?php



$query_payday_prestamo = "select * from url_counter where url='payday_prestamo' ";
//$query = "select * from decision_login_codes where  id = 564";

//echo $query . "<br>";
$sql_payday_prestamo=mysqli_query($con, "$query_payday_prestamo"); 

  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($sql_payday_prestamo);

while($row_payday_prestamo = mysqli_fetch_array($sql_payday_prestamo)) {
    
$counter_payday_prestamo = $row_payday_prestamo['url_counter'];
$website_payday_prestamo = $row_payday_prestamo['url'];
echo "<h3>Counter for Page ".$website_payday_prestamo." is : ".$counter_payday_prestamo."</h3>";

}

?>
</div>



<div class="col-lg-6">
  <?php



$query_payday_credito = "select * from url_counter where url='payday_credito' ";
//$query = "select * from decision_login_codes where  id = 564";

//echo $query . "<br>";
$sql_payday_credito=mysqli_query($con, "$query_payday_credito"); 

  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($sql_payday_credito);

while($row_payday_credito = mysqli_fetch_array($sql_payday_credito)) {
    
$counter_payday_credito = $row_payday_credito['url_counter'];
$website_payday_credito = $row_payday_credito['url'];
echo "<h3>Counter for Page ".$website_payday_credito." is : ".$counter_payday_credito."</h3>";

}

?>
</div>





</div>
<hr>





</body>
</html>



<?php

//****************** pre approved payday loan

$query = "select * from msg_template where msg_name='preapprovedpaydayloan' ";
$sql=mysqli_query($con, "$query"); 
  $rowcount=mysqli_num_rows($sql);
while($row = mysqli_fetch_array($sql)) {
    $msg_name = $row['msg_name'];
    $msg_content= $row['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_name."</h3>";

}


$query_spanish = "select * from msg_template where msg_name='preapprovedpaydayloanspanish' ";
$sql_spanish=mysqli_query($con, "$query_spanish"); 
  $rowcount_spanish=mysqli_num_rows($sql_spanish);
while($row_spanish = mysqli_fetch_array($sql_spanish)) {
    $msg_name_spanish = $row_spanish['msg_name'];
    $msg_content_spanish= $row_spanish['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_name."</h3>";

}
//************* pre approved payday loan END

//****************** approved payday loan Start

$query2 = "select * from msg_template where msg_name='approvedpaydayloan' ";
$sql2=mysqli_query($con, "$query2"); 
  $rowcount2=mysqli_num_rows($sql2);
while($row2 = mysqli_fetch_array($sql2)) {
    $msg_name2 = $row2['msg_name'];
    $msg_content2= $row2['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_name2."</h3>";

}


$query2_spanish = "select * from msg_template where msg_name='approvedpaydayloanspanish' ";
$sql2_spanish=mysqli_query($con, "$query2_spanish"); 
  $rowcount2_spanish=mysqli_num_rows($sql2_spanish);
while($row2_spanish = mysqli_fetch_array($sql2_spanish)) {
    $msg_name2_spanish = $row2_spanish['msg_name'];
    $msg_content2_spanish= $row2_spanish['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_name2."</h3>";

}


//************************ approved payday loan END


//****************** pre approved personal loan Start

$query3 = "select * from msg_template where msg_name='preapprovedpersonalloan' ";
$sql3=mysqli_query($con, "$query3"); 
  $rowcount3=mysqli_num_rows($sql3);
while($row3 = mysqli_fetch_array($sql3)) {
    $msg_name3 = $row3['msg_name'];
    $msg_content3= $row3['msg_content'];
 echo "<br><br><br>";
 
// echo "<h3> is : ".$msg_content."</h3>";

}


$query3_spanish = "select * from msg_template where msg_name='preapprovedpersonalloanspanish' ";
$sql3_spanish=mysqli_query($con, "$query3_spanish"); 
  $rowcount3_spanish=mysqli_num_rows($sql3_spanish);
while($row3_spanish = mysqli_fetch_array($sql3_spanish)) {
    $msg_name3_spanish = $row3_spanish['msg_name'];
    $msg_content3_spanish= $row3_spanish['msg_content'];
 echo "<br><br><br>";
 
// echo "<h3> is : ".$msg_content."</h3>";

}

//****************** pre approved personal loan END

//****************** approved personal loan loan Start

$query4 = "select * from msg_template where msg_name='approvedpersonalloan' ";
$sql4=mysqli_query($con, "$query4"); 
  $rowcount4=mysqli_num_rows($sql4);
while($row4 = mysqli_fetch_array($sql4)) {
    $msg_name4 = $row4['msg_name'];
    $msg_content4= $row4['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_content4."</h3>";

}


$query4_spanish = "select * from msg_template where msg_name='approvedpersonalloanspanish' ";
$sql4_spanish=mysqli_query($con, "$query4_spanish"); 
  $rowcount4_spanish=mysqli_num_rows($sql4_spanish);
while($row4_spanish = mysqli_fetch_array($sql4_spanish)) {
    $msg_name4_spanish = $row4_spanish['msg_name'];
    $msg_content4_spanish= $row4_spanish['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_content4."</h3>";

}

//******************* approved personal loan END

//******************* pre approved commercial loan Start

$query5 = "select * from msg_template where msg_name='preapprovedcommercialloan' ";
$sql5=mysqli_query($con, "$query5"); 
  $rowcount5=mysqli_num_rows($sql5);
while($row5 = mysqli_fetch_array($sql5)) {
    $msg_name5 = $row5['msg_name'];
    $msg_content5= $row5['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_content5."</h3>";

}

$query5_spanish = "select * from msg_template where msg_name='preapprovedcommercialloanspanish' ";
$sql5_spanish=mysqli_query($con, "$query5_spanish"); 
  $rowcount5_spanish=mysqli_num_rows($sql5_spanish);
while($row5_spanish = mysqli_fetch_array($sql5_spanish)) {
    $msg_name5_spanish = $row5_spanish['msg_name'];
    $msg_content5_spanish= $row5_spanish['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_content5."</h3>";

}
//******************* pre approved commercial loan END

//*******************approved commercial loan Start

$query6 = "select * from msg_template where msg_name='approvedcommercialloan' ";
$sql6=mysqli_query($con, "$query6"); 
  $rowcount6=mysqli_num_rows($sql6);
while($row6 = mysqli_fetch_array($sql6)) {
    $msg_name6 = $row6['msg_name'];
    $msg_content6= $row6['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_content6."</h3>";

}

$query6_spanish = "select * from msg_template where msg_name='approvedcommercialloanspanish' ";
$sql6_spanish=mysqli_query($con, "$query6_spanish"); 
  $rowcount6_spanish=mysqli_num_rows($sql6_spanish);
while($row6_spanish = mysqli_fetch_array($sql6_spanish)) {
    $msg_name6_spanish = $row6_spanish['msg_name'];
    $msg_content6_spanish= $row6_spanish['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_content6."</h3>";

}

//*******************approved commercial loan END

//*******************pre approved titleloan Start

$query7 = "select * from msg_template where msg_name='preapprovedtitleloan' ";
$sql7=mysqli_query($con, "$query7"); 
  $rowcount7=mysqli_num_rows($sql7);
while($row7 = mysqli_fetch_array($sql7)) {
    $msg_name7 = $row7['msg_name'];
    $msg_content7= $row7['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_content7."</h3>";

}

$query7_spanish = "select * from msg_template where msg_name='preapprovedtitleloanspanish' ";
$sql7_spanish=mysqli_query($con, "$query7_spanish"); 
    $rowcount7_spanish=mysqli_num_rows($sql7_spanish);
    while($row7_spanish = mysqli_fetch_array($sql7_spanish)) {
    $msg_name7_spanish = $row7_spanish['msg_name'];
    $msg_content7_spanish= $row7_spanish['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_content7."</h3>";

}

//*******************pre approved titleloan END

//*******************approved titleloan Start
$query8 = "select * from msg_template where msg_name='approvedtitleloan' ";
$sql8=mysqli_query($con, "$query8"); 
  $rowcount8=mysqli_num_rows($sql8);
while($row8 = mysqli_fetch_array($sql8)) {
    $msg_name8 = $row8['msg_name'];
    $msg_content8= $row8['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_content8."</h3>";

}

$query8_spanish = "select * from msg_template where msg_name='approvedtitleloanspanish' ";
$sql8_spanish=mysqli_query($con, "$query8_spanish"); 
  $rowcount8_spanish=mysqli_num_rows($sql8_spanish);
while($row8_spanish = mysqli_fetch_array($sql8_spanish)) {
    $msg_name8_spanish = $row8_spanish['msg_name'];
    $msg_content8_spanish= $row8_spanish['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_content8."</h3>";

}

//*******************approved titleloan END

//******************* declined sms Start
$query9 = "select * from msg_template where msg_name='declinedsms' ";
$sql9=mysqli_query($con, "$query9"); 
  $rowcount9=mysqli_num_rows($sql9);
while($row9 = mysqli_fetch_array($sql9)) {
    $msg_name9 = $row9['msg_name'];
    $msg_content9= $row9['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_content8."</h3>";

}

$query9_spanish = "select * from msg_template where msg_name='declinedsmsspanish' ";
$sql9_spanish=mysqli_query($con, "$query9_spanish"); 
  $rowcount9_spanish=mysqli_num_rows($sql9_spanish);
while($row9_spanish = mysqli_fetch_array($sql9_spanish)) {
    $msg_name9_spanish = $row9_spanish['msg_name'];
    $msg_content9_spanish= $row9_spanish['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_content8."</h3>";

}

//******************* declined sms END


?>





<?php 

   
if(isset($_POST['btn-submit'])) 
{
    
$preapprovedpaydayloan= $_POST['preapprovedpaydayloan'];
$approvedpaydayloan= $_POST['approvedpaydayloan'];
$preapprovedpersonalloan= $_POST['preapprovedpersonalloan'];
$approvedpersonalloan=$_POST['approvedpersonalloan'];
$preapprovedcommercialloan= $_POST['preapprovedcommercialloan'];
$approvedcommercialloan= $_POST['approvedcommercialloan'];
$preapprovedtitleloan= $_POST['preapprovedtitleloan'];
$approvedtitleloan=$_POST['approvedtitleloan'];
$declinedsms=$_POST['declinedsms'];


$preapprovedpaydayloanspanish= $_POST['preapprovedpaydayloanspanish'];
$approvedpaydayloanspanish= $_POST['approvedpaydayloanspanish'];
$preapprovedpersonalloanspanish= $_POST['preapprovedpersonalloanspanish'];
$approvedpersonalloanspanish=$_POST['approvedpersonalloanspanish'];
$preapprovedcommercialloanspanish= $_POST['preapprovedcommercialloanspanish'];

$approvedcommercialloanspanish= $_POST['approvedcommercialloanspanish'];

$preapprovedtitleloanspanish= $_POST['preapprovedtitleloanspanish'];
$approvedtitleloanspanish=$_POST['approvedtitleloanspanish'];
$declinedsmsspanish=$_POST['declinedsmsspanish'];


mysqli_query($con,"UPDATE msg_template SET msg_content ='$preapprovedpaydayloan' where msg_name = '$msg_name'");
mysqli_query($con,"UPDATE msg_template SET msg_content ='$approvedpaydayloan' where msg_name = '$msg_name2'");
mysqli_query($con,"UPDATE msg_template SET msg_content ='$preapprovedpersonalloan' where msg_name = '$msg_name3'");
mysqli_query($con,"UPDATE msg_template SET msg_content ='$approvedpersonalloan' where msg_name = '$msg_name4'");
mysqli_query($con,"UPDATE msg_template SET msg_content ='$preapprovedcommercialloan' where msg_name = '$msg_name5'");
mysqli_query($con,"UPDATE msg_template SET msg_content ='$approvedcommercialloan'    where msg_name = '$msg_name6'");
mysqli_query($con,"UPDATE msg_template SET msg_content ='$preapprovedtitleloan'      where msg_name = '$msg_name7'");
mysqli_query($con,"UPDATE msg_template SET msg_content ='$approvedtitleloan'         where msg_name = '$msg_name8'");
mysqli_query($con,"UPDATE msg_template SET msg_content ='$declinedsms'               where msg_name = '$msg_name9'");

mysqli_query($con,"UPDATE msg_template SET msg_content ='$preapprovedpaydayloanspanish' where msg_name = '$msg_name_spanish'");
mysqli_query($con,"UPDATE msg_template SET msg_content ='$approvedpaydayloanspanish' where msg_name = '$msg_name2_spanish'");
mysqli_query($con,"UPDATE msg_template SET msg_content ='$preapprovedpersonalloanspanish' where msg_name = '$msg_name3_spanish'");
mysqli_query($con,"UPDATE msg_template SET msg_content ='$approvedpersonalloanspanish' where msg_name = '$msg_name4_spanish'");
mysqli_query($con,"UPDATE msg_template SET msg_content ='$preapprovedcommercialloanspanish' where msg_name = '$msg_name5_spanish'");
mysqli_query($con,"UPDATE msg_template SET msg_content ='$approvedcommercialloanspanish'    where msg_name = '$msg_name6_spanish'");
mysqli_query($con,"UPDATE msg_template SET msg_content ='$preapprovedtitleloanspanish'      where msg_name = '$msg_name7_spanish'");
mysqli_query($con,"UPDATE msg_template SET msg_content ='$approvedtitleloanspanish'         where msg_name = '$msg_name8_spanish'");
mysqli_query($con,"UPDATE msg_template SET msg_content ='$declinedsmsspanish'               where msg_name = '$msg_name9_spanish'");
        
?>

<script type="text/javascript">
window.location.href = 'sms_settings.php';
</script>
<?php
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['email']; ?></title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="style.css" type="text/css" />
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<style>
.wrapper {
    width: 100%;
    max-width: 1330px;
    margin: 20px auto 100px auto;
    padding: 0;
    position: relative;
}
</style>
</head>

<body>

<?php include('menu.php') ;?>

  <div class ="container wrapper" style="margin-top:100px">

  <div class="row wrapper" style="margin-top: -174px;">

  <form action ="" method="POST" enctype="multipart/form-data">
  
  <h3 style="color:red;">Message Settings</h3>
  
    
   
   
   

<div class="row">
 <div class="col-lg-12">
      <label for="usr">Pre-approved Payday Loan</label>
      <textarea type="text" name="preapprovedpaydayloan"  class="form-control" id="usr"  style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"> <?php echo $msg_content; ?> </textarea>
    </div>
</div>

<div class="row">
 <div class="col-lg-12">
      <label for="usr">Pre-approved Payday Loan Spanish SMS</label>
      <textarea type="text" name="preapprovedpaydayloanspanish"  class="form-control" id="usr"  style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"> <?php echo $msg_content_spanish; ?> </textarea>
    </div>
</div>


<div class="row">
 <div class="col-lg-12">
      <label for="usr">approved Payday Loan</label>
      <textarea type="text" name="approvedpaydayloan"  class="form-control" id="usr"    style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;">  <?php echo $msg_content2; ?> </textarea>
    </div>
</div>

<div class="row">
 <div class="col-lg-12">
      <label for="usr">approved Payday Loan Spanish SMS</label>
      <textarea type="text" name="approvedpaydayloanspanish"  class="form-control" id="usr"    style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;">  <?php echo $msg_content2_spanish; ?> </textarea>
    </div>
</div>


<div class="row">
 <div class="col-lg-12">
      <label for="usr">Pre-approved Personal Loan</label>
      <textarea type="text" name="preapprovedpersonalloan"  class="form-control" id="usr"      style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"> <?php echo $msg_content3; ?> </textarea>
    </div>
</div>

<div class="row">
 <div class="col-lg-12">
      <label for="usr">Pre-approved Personal Loan Spanish SMS</label>
      <textarea type="text" name="preapprovedpersonalloanspanish"  class="form-control" id="usr"      style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"> <?php echo $msg_content3_spanish; ?> </textarea>
    </div>
</div>


<div class="row">
 <div class="col-lg-12">
      <label for="usr">approved Personal Loan</label>
      <textarea type="text" name="approvedpersonalloan"  class="form-control" id="usr"    style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"> <?php echo $msg_content4; ?> </textarea>
    </div>
</div>

<div class="row">
 <div class="col-lg-12">
      <label for="usr">approved Personal Loan Spanish SMS</label>
      <textarea type="text" name="approvedpersonalloanspanish"  class="form-control" id="usr"    style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"> <?php echo $msg_content4_spanish; ?> </textarea>
    </div>
</div>


<div class="row">
 <div class="col-lg-12">
      <label for="usr">Pre-approved Commercial Loan</label>
      <textarea type="text" name="preapprovedcommercialloan"  class="form-control" id="usr"      style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"> <?php echo $msg_content5; ?> </textarea>
    </div>
</div>

<div class="row">
 <div class="col-lg-12">
      <label for="usr">Pre-approved Commercial Loan Spanish SMS</label>
      <textarea type="text" name="preapprovedcommercialloanspanish"  class="form-control" id="usr"      style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"> <?php echo $msg_content5_spanish; ?> </textarea>
    </div>
</div>


<div class="row">
 <div class="col-lg-12">
      <label for="usr">Approved Commercial Loan</label>
      <textarea type="text" name="approvedcommercialloan"  class="form-control" id="usr"    style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"> <?php echo $msg_content6; ?> </textarea>
    </div>
</div>

<div class="row">
 <div class="col-lg-12">
      <label for="usr">Approved Commercial Loan Spanish SMS</label>
      <textarea type="text" name="approvedcommercialloanspanish"  class="form-control" id="usr"    style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"> <?php echo $msg_content6_spanish; ?> </textarea>
    </div>
</div>

<div class="row">
 <div class="col-lg-12">
      <label for="usr">Pre-approved Title Loan</label>
      <textarea type="text" name="preapprovedtitleloan"  class="form-control" id="usr"      style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"> <?php echo $msg_content7; ?> </textarea>
    </div>
</div>

<div class="row">
 <div class="col-lg-12">
      <label for="usr">Pre-approved Title Loan Spanish SMS</label>
      <textarea type="text" name="preapprovedtitleloanspanish"  class="form-control" id="usr"      style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"> <?php echo $msg_content7_spanish; ?> </textarea>
    </div>
</div>


<div class="row">
 <div class="col-lg-12">
      <label for="usr">Approved Title Loan</label>
      <textarea type="text" name="approvedtitleloan"  class="form-control" id="usr"    style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"> <?php echo $msg_content8; ?> </textarea>
    </div>
</div>

<div class="row">
 <div class="col-lg-12">
      <label for="usr">Approved Title Loan Spanish SMS</label>
      <textarea type="text" name="approvedtitleloanspanish"  class="form-control" id="usr"    style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"> <?php echo $msg_content8_spanish; ?> </textarea>
    </div>
</div>


<div class="row">
 <div class="col-lg-12">
      <label for="usr">Declined SMS</label>
      <textarea type="text" name="declinedsms"  class="form-control" id="usr"    style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"> <?php echo $msg_content9; ?> </textarea>
    </div>
</div>

<div class="row">
 <div class="col-lg-12">
      <label for="usr">Declined SMS Spanish</label>
      <textarea type="text" name="declinedsmsspanish"  class="form-control" id="usr"    style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"> <?php echo $msg_content9_spanish; ?> </textarea>
    </div>
</div>

    <br>
    
      <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: #1E90FF;border-color: #1E90FF;"> Update Message</button>
  </form>
  
</div>
</div>

<hr>

<a href="" style="font-weight: bold;">Activity Log</a><br>
  <iframe src="https://mymoneyline.com/lsbankingportal/ls_software/admin/activity_log.php" width="100%" height="900px"></iframe>

</body>
</html>     
<?php
}
?>