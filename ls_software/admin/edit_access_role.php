<?php
error_reporting(0);
session_start();

include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);

$userRow=$query->fetch_array();
$u_id=$userRow['user_id'];
$u_access_id = $userRow['access_id'];
if($u_access_id=='0'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}
else {
$DBcon->close();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

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




<br>

<?php

$id=$_GET['f_id'];
$access_id=$_GET['id'];
include $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

$sql=mysqli_query($con, "select * from access_level_grants where grant_id = '$access_id'"); 


while($row = mysqli_fetch_array($sql)) {

$role_id=$row['role_id'];
$select_allowed=$row['select_allowed'];
$insert_allowed=$row['insert_allowed'];
$update_allowed=$row['update_allowed'];
$delete_allowed=$row['delete_allowed'];
}


$sql_access = mysqli_query($con, "SELECT * From access_level where access_id='$role_id'");
$row_access = mysqli_num_rows($sql_access);
while ($row_access = mysqli_fetch_array($sql_access)){
    $row_access_level = $row_access['access_level'];
    
}

?>

  
  
  </div>
   
<div class ="container" style="margin-top:0px">
  <div class="row">
  
<form action ="#" method="POST">

     <div class="col-lg-3">
    <label for="usr">Select Level Of Access</label>
    <select  class="form-control" name="level_of_access">

      <option value="1" <?php if($row_access_level=='Admin'){ echo 'selected';} ?>>Admin</option>
      <option value="3" <?php if($row_access_level=='Loan Officer'){ echo 'selected';} ?>>Loan Officer</option>
     </select>
     </div>
    
    <div class="col-lg-3" >
      <label for="usr"> Insert Allowed </label>
      <select  class="form-control" name="insert_allowed">
      <option value="1" <?php if($insert_allowed=='1'){ echo 'selected';} ?>>Yes</option>
      <option value="0" <?php if($insert_allowed=='0'){ echo 'selected';} ?>>No</option>
      </select>
    </div>
    
     <div class="col-lg-3" >
      <label for="usr"> Update Allowed </label>
      <select  class="form-control" name="update_allowed">
      <option value="1" <?php if($update_allowed=='1'){ echo 'selected';} ?>>Yes</option>
      <option value="0" <?php if($update_allowed=='0'){ echo 'selected';} ?>>No</option>
      </select>
    </div>
    
    <div class="col-lg-3" >
      <label for="usr"> Delete Allowed </label>
      <select  class="form-control" name="delete_allowed">
      <option value="1" <?php if($delete_allowed=='0'){ echo 'selected';} ?>>Yes</option>
      <option value="0" <?php if($delete_allowed=='0'){ echo 'selected';} ?>>No</option>
      </select>
    </div>
     
    
    <br>
    
    </div>
 <br>
      <button name="btn-submit-phone" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;">Update Role</button>
  </form>
  
  
  <br><br>
  
  
</body>
</html>

<?php 
include 'functions.php';
    $form_name=basename(__FILE__);
    


 $sql_role=mysqli_query($con, "select * from access_form where form_name ='$form_name'"); 


while($row_role = mysqli_fetch_array($sql_role)) {

 $form_id=$row_role['id'];
 //echo $form_id;
}
 $update_allowed_validate = user_edit_roles($u_access_id,$form_id);
 

if(isset($_POST['btn-submit-phone'])) {
    
    

    
$level_of_access_update=$_POST['level_of_access']; 
$select_allowed_update=$_POST['select_allowed']; 
$insert_allowed_update=$_POST['insert_allowed']; 
$update_allowed_update=$_POST['update_allowed']; 
$delete_allowed_update=$_POST['delete_allowed']; 
    if ($update_allowed_validate==1)
{
mysqli_query($con, "UPDATE access_level_grants SET role_id = '$level_of_access_update', select_allowed='$select_allowed_update', insert_allowed='$insert_allowed_update', update_allowed='$update_allowed_update', delete_allowed='$delete_allowed_update' where grant_id ='$access_id'");   
   
    ?>
    
    <script type="text/javascript">
window.location.href = 'edit_form.php?id=<?php echo $id;?>';
</script>
<?php
}

else{
  echo "<script type='text/javascript'>
window.location.href = 'not_authorize.php';
</script>";
}
}


?>

<?php
}
?>
