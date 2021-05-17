<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

error_reporting(0);
if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$uuu_id=$userRow['user_id'];
//echo "<br><br><br>id is:".$uu_id;

$u_access_id = $userRow['access_id'];
if($u_access_id!='1'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}

$id=$_GET['id'];


$sql=mysqli_query($con, "select * from access_level where access_id= '$id'"); 

while($row = mysqli_fetch_array($sql)) {

$access_level=$row['access_level'];

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
    max-width: 1340px;
    padding: 0;
    position: relative;
}
</style>
</head>
<body>
    
    <?php include('menu.php') ;?>


  <div class ="container wrapper" style="margin-top:70px">

<br><br>
<h4>  Edit This Role: </h4>
  <div class="row wrapper">
      
  <form action ="#" method="POST">
    
   
    <div class="col-lg-6" >
      <label for="usr"> User Role </label>
      <input name="user_role" type="text" class="form-control" id="usr" placeholder="" value="<?php echo $access_level ?>">
    </div>
     
     <br>
      <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;">Update</button>
  
    </div>
   
  </form>
  
  </div>

</body>
</html>

<?php 

    include 'functions.php';
    $form_name=basename(__FILE__);
    
if(isset($_POST['btn-submit'])) {
    
$user_role=$_POST['user_role']; 

$sql_role=mysqli_query($con, "select * from access_form where form_name ='$form_name'"); 


while($row_role = mysqli_fetch_array($sql_role)) {

 $form_id=$row_role['id'];
 //echo $form_id;
}
 $update_allowed_validate = user_edit_roles($u_access_id,$form_id);
 
     if ($update_allowed_validate==1)
{


mysqli_query($con, "UPDATE `access_level` SET `access_level`='$user_role' where access_id ='$id'");   
   
    ?>
    
    <script type="text/javascript">
window.location.href = 'view_all_roles.php';
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

