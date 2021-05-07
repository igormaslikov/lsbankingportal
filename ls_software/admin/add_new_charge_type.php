<?php
session_start();
error_reporting(0);
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

<?php 

   
   include 'functions.php';

if(isset($_POST['btn-submit'])) 
{
    
$loan_id_charge= $_POST['loan_id_charge'];
$charge_amount= $_POST['charge_amount']; 
$charge_date= $_POST['charge_date'];
$charge_type= $_POST['charge_type'];
$charge_info= $_POST['charge_info'];
$application_type= $_POST['application_type'];
$date = date('Y-m-d H:i:s');

$form_name=basename(__FILE__);

    $sql_role=mysqli_query($con, "select * from access_form where form_name='$form_name'"); 


    while($row_role = mysqli_fetch_array($sql_role)) {

    $form_id=$row_role['id'];
 
}  
     
     user_roles($u_access_id,$form_id);
     


$query_charge = "INSERT INTO tbl_charge_type (loan_id,charge_amount,charge_date,charge_type,charge_info,application_type,creation_date,created_by)  VALUES ('$loan_id_charge','$charge_amount','$charge_date','$charge_type','$charge_info','$application_type','$date','$u_id')";
        $result_charge = mysqli_query($con, $query_charge);
        if ($result_charge) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        } 
 
?>

<script type="text/javascript">
window.location.href = 'charge_type.php?id=<?php  $loan_id_charge= $_GET['loan_id_charge']; echo $loan_id_payoff ;?>';
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

</head>

<body>

<?php include('menu.php') ;?>

    
  <div class ="container" style="margin-top:100px">

  <div class="row">

  <form action ="" method="POST" enctype="multipart/form-data">
  <input type="text" name="name_id" value="<?php echo $name_id;?>"  style="display:none;">
  
  <div class="row">
     
     <div class="col-lg-6">
      <label for="usr">Amount</label>
      <input type="text" name="charge_amount" class="form-control" id="usr" placeholder="Charge Amount" value="">
    </div>
    
     <div class="col-lg-6">
      <label for="usr">Charge Date</label>
      <input type="date" name="charge_date" class="form-control" id="usr" placeholder="" value="<?php echo date('Y-m-d');?>">
      
      <input type="text" name="loan_id" class="form-control" id="usr" placeholder="" value="<?php echo $_GET['loan_id']; ?>" style="display:none;">
    </div>


    <div class="col-lg-6">
      <label for="usr">Charge Type</label>
    <select name="charge_type" id="charge_type" class="form-control"  value="">
<option value=""></option>
<option value="NSF Fee">NSF Fee</option>

</select>
    </div>
    
     <div class="col-lg-6">
      <label for="usr">INFO</label>
      <input type="text" name="charge_info" class="form-control" id="usr" placeholder="Charge INFO" value="">
    </div>
    
    
        <div class="col-lg-6">
      <label for="usr">Charge Application Type</label>
    <select name="application_type" id="application_type" class="form-control"  value="">
<option value=""></option>
<option value="Standard">Standard</option>

</select>
    </div>
    
    </div>
    
    <br>
    
      <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: blue;border-color: blue;">Add New Charge</button>
  </form>
  
</div>
</div>

<hr>


</body>
</html>
<?php
}
?>