<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';


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


$query = "select * from msg_template where msg_name='past_due' ";
$sql=mysqli_query($con, "$query"); 
  $rowcount=mysqli_num_rows($sql);
while($row = mysqli_fetch_array($sql)) {
    $msg_name = $row['msg_name'];
    $msg_content= $row['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_name."</h3>";

}



?>


<?php

$query2 = "select * from msg_template where msg_name='collections' ";
$sql2=mysqli_query($con, "$query2"); 
  $rowcount2=mysqli_num_rows($sql2);
while($row2 = mysqli_fetch_array($sql2)) {
    $msg_name2 = $row2['msg_name'];
    $msg_content2= $row2['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_name2."</h3>";

}



?>



<?php

$query3 = "select * from msg_template where msg_name='chargeoff' ";
$sql3=mysqli_query($con, "$query3"); 
  $rowcount3=mysqli_num_rows($sql3);
while($row3 = mysqli_fetch_array($sql3)) {
    $msg_name3 = $row3['msg_name'];
    $msg_content3= $row3['msg_content'];
 echo "<br><br><br>";
 
// echo "<h3> is : ".$msg_content."</h3>";

}



?>



<?php

$query4 = "select * from msg_template where msg_name='closed_account' ";
$sql4=mysqli_query($con, "$query4"); 
  $rowcount4=mysqli_num_rows($sql4);
while($row4 = mysqli_fetch_array($sql4)) {
    $msg_name4 = $row4['msg_name'];
    $msg_content4= $row4['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_content4."</h3>";

}



?>

<?php

$query5 = "select * from msg_template where msg_name='chargeback' ";
$sql5=mysqli_query($con, "$query5"); 
  $rowcount5=mysqli_num_rows($sql5);
while($row5 = mysqli_fetch_array($sql5)) {
    $msg_name5 = $row5['msg_name'];
    $msg_content5= $row5['msg_content'];
 //echo "<br><br><br>";
 
 //echo "<h3> is : ".$msg_content5."</h3>";

}





if(isset($_POST['btn-submit'])) 
{
    
$past_due= $_POST['past_due'];

$collections= $_POST['collections'];

$chargeoff= $_POST['chargeoff'];
$closed_account=$_POST['closed_account'];


$chargeback= $_POST['chargeback'];



mysqli_query($con,"UPDATE msg_template SET msg_content ='$past_due' where msg_name = '$msg_name'");


mysqli_query($con,"UPDATE msg_template SET msg_content ='$collections' where msg_name = '$msg_name2'");

mysqli_query($con,"UPDATE msg_template SET msg_content ='$chargeoff' where msg_name = '$msg_name3'");


mysqli_query($con,"UPDATE msg_template SET msg_content ='$closed_account' where msg_name = '$msg_name4'");


mysqli_query($con,"UPDATE msg_template SET msg_content ='$chargeback' where msg_name = '$msg_name5'");



        
?>

<script type="text/javascript">
window.location.href = 'loan_status_sms_settings.php';
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
<br><br><br><br><br><br><br>

  <div class ="container wrapper" style="margin-top:100px">

  <div class="row wrapper" style="margin-top: -174px;">

  <form action ="" method="POST" enctype="multipart/form-data">
  
  <h3 style="color:red;">Message Settings</h3>
  
    
   
   
   

<div class="row">
 <div class="col-lg-12">
      <label for="usr">Past Due Loan Status</label>
      <textarea type="text" name="past_due"  class="form-control" id="usr"  style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"><?php echo $msg_content; ?></textarea>
    </div>
</div>


<div class="row">
 <div class="col-lg-12">
      <label for="usr">Collections Loan Status</label>
      <textarea type="text" name="collections"  class="form-control" id="usr"    style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"><?php echo $msg_content2; ?></textarea>
    </div>
</div>


<div class="row">
 <div class="col-lg-12">
      <label for="usr">Chargeoff Loan Status</label>
      <textarea type="text" name="chargeoff"  class="form-control" id="usr"      style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"><?php echo $msg_content3; ?></textarea>
    </div>
</div>


<div class="row">
 <div class="col-lg-12">
      <label for="usr">Closed Account Loan Status</label>
      <textarea type="text" name="closed_account"  class="form-control" id="usr"    style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"><?php echo $msg_content4; ?></textarea>
    </div>
</div>

<div class="row">
 <div class="col-lg-12">
      <label for="usr">Chargeback Loan Status</label>
      <textarea type="text" name="chargeback"  class="form-control" id="usr"    style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"><?php echo $msg_content5; ?></textarea>
    </div>
</div>

    <br>
    
      <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: #1E90FF;border-color: #1E90FF;"> Update Message</button>
  </form>
  
</div>
</div>

<hr>

</body>
</html>     