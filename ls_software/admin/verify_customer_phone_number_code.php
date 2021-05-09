<?php

$id = $_POST['id'];
$number = $_POST['number'];
$code = $_POST['code'];
$v_code = $_POST['v_code'];
error_reporting(0);
session_start();
include_once 'dbconnect.php';
include 'dbconfig.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$DBcon->close();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['email']; ?></title>

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<?php include('menu.php') ;?>
 <?php
$con=mysqli_connect("lsbankingportal.com","dblsuser2021","^%D24L*!Ti5%","dbs57337");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql_t="SELECT amount_of_loan FROM tbl_loan ORDER BY loan_id";

if ($result_t=mysqli_query($con,$sql_t))
  {
  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($result_t);
 // printf($rowcount);
  // Free result set
  $ye=mysqli_free_result($result_t);
  echo $ye;
  }



$query_us = mysqli_query($con,"SELECT SUM(amount_of_loan) AS value_sum FROM tbl_loan");
while ($row_us=mysqli_fetch_array($query_us)){
    $us = $row_us['value_sum'];
    $us=round($us, 2);
   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$us;

}

$query_le = mysqli_query($con,"SELECT SUM(amount_left) AS value_sum FROM tbl_loan");
while ($row_le=mysqli_fetch_array($query_le)){
    $am_le = $row_le['value_sum'];
   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$am_le;

}

$pay_off= $us-$am_le;
$avg_pay_off= $am_le/$rowcount;

$avg_pay=round($avg_pay_off, 2);

$avg_amount=$us/$rowcount;

$avg=round($avg_amount, 2);


$sql=mysqli_query($con, "select * from tbl_loan "); 

while($row = mysqli_fetch_array($sql)) {

$loan_id=$row['loan_id'];

}
//echo "fndid is:".$loan_id;


$sql=mysqli_query($con, "select * from tbl_loan where loan_id='$loan_id'"); 

while($row = mysqli_fetch_array($sql)) {

$userfnd_id=$row['user_fnd_id'];

}
//echo "fndid is:".$userfnd_id;


$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$userfnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];

}

//echo "fname is:".$first_name;

?>


<div class="container" style="margin-top:150px;text-align:center;font-family:Verdana, Geneva, sans-serif;font-size:15px;">



<br>

<!--Deatil Of Users Start -->

<?php

$sql_t="SELECT username,email FROM tbl_users ORDER BY user_id";

if ($result_t=mysqli_query($con,$sql_t))
  {
  // Return the number of rows in result set
  $rowcount_user=mysqli_num_rows($result_t);
 // printf($rowcount_user);
  // Free result set
  $ye=mysqli_free_result($result_t);
  echo $ye;
  }



$sql_t="SELECT bg_name,email_id FROM business_group ORDER BY bg_id";

if ($result_t=mysqli_query($con,$sql_t))
  {
  // Return the number of rows in result set
  $rowcount_company=mysqli_num_rows($result_t);
 // printf($rowcount_company);
  // Free result set
  $ye=mysqli_free_result($result_t);
  echo $ye;
  }



$sql_t="SELECT first_name,email FROM fnd_user_profile ORDER BY user_fnd_id";

if ($result_t=mysqli_query($con,$sql_t))
  {
  // Return the number of rows in result set
  $rowcount_customer=mysqli_num_rows($result_t);
 // printf($rowcount_customer);
  // Free result set
  $ye=mysqli_free_result($result_t);
  echo $ye;
  }

mysqli_close($con);
?> 

<div class="row" >
    <?php 
        if($code==$v_code){
            echo "Mobile Number for  User id ". $id. " has been Verified.";
            

            mysqli_query($con, "UPDATE `fnd_user_profile` SET `mobile_verification_status`=1 WHERE `user_fnd_id` = '$id';");   
        }
        else {
            echo "Code is not matched. Please Verify again.";
        }
    ?>
    <br>
    <a href = "edit_customer.php?id=<?php echo $id; ?>" >Go Back</a>
</div>


<!--Deatil Of Users END -->

<br>

<!--Deatil Of Loans -->


<!--Deatil Of Loans END-->

<br>


</div>

</body>
</html>