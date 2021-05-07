<?php
session_start();
include_once 'dbconnect.php';
include 'dbconfig.php';
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

//echo "id is::".$id;

$sql=mysqli_query($con, "select * from tbl_users where user_id= '$id'"); 


while($row = mysqli_fetch_array($sql)) {

$access_id=$row['access_id'];
$status =$row['status'];
$created_at=$row['created_at'];
$created_by=$row['created_by'];
$update_by=$row['last_update_by'];
$update_date=$row['last_update_date'];
$auth_code=$row['auth_code'];
//$name=$row['username'];
}
//echo "accessid id::".$access_id;
 $email=$email;


$sql=mysqli_query($con, "select * from access_level where access_id= '$access_id'"); 

while($row = mysqli_fetch_array($sql)) {

$access_level=$row['access_level'];

}


$sql=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row = mysqli_fetch_array($sql)) {

$name=$row['username'];
}
//echo $name;
 $email=$email;


$sql=mysqli_query($con, "select * from tbl_users where user_id= '$update_by'"); 


while($row = mysqli_fetch_array($sql)) {


$name_update=$row['username'];
}
//echo $name;
 $email=$email;

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


<div class="row wrapper" style="background-color: #F5E09E;color: black;padding:20px;">

<div class="col-lg-4"><p> Status:<b style="color:red"> <?php echo $status;?></b></p></div>
<div class="col-lg-4"><p> Created By:<b style="color:red"> <?php echo $name;?> </b> </p></div>
<div class="col-lg-4"><p> Creation Date:<b style="color:red"> <?php echo $created_at;?> </b></p></div>
<div class="col-lg-4"><p>Last Update By: <b style="color:red"><?php echo $name_update;?> </b></p></div>
<div class="col-lg-4"><p> Last Update Date: <b style="color:red"> <?php echo $update_date;?></b></p></div>

</div>
<hr>
  <div class="row wrapper">
      
  <form action ="#" method="POST">
    
    <div class="col-lg-6">
    <label for="usr">Select User Status</label>
    <select  class="form-control" name="status" value="<?php echo $status; ?>">
    <option value="Active" <?php if($status=='Active'){ echo 'selected';} ?>>Active</option>
    <option value="Inactive" <?php if($status=='Inactive'){ echo 'selected';} ?>>Inactive</option>

     </select>
     </div>
    
     <div class="col-lg-6">
    <label for="usr">Select Level Of Access</label>
    <select  class="form-control" name="level_of_access">
    
  <?php  
$sql_access = mysqli_query($con, "SELECT access_id,access_level From access_level");
$row_access = mysqli_num_rows($sql_access);
while ($row_access = mysqli_fetch_array($sql_access)){
    $row_access_level = $row_access['access_level'];
echo "<option value='". $row_access['access_id']."'" ;
if($access_level==$row_access_level){ echo 'selected';} 

echo ">".$row_access['access_level'] ."</option>" ;
}
?>
    
    

     </select>
     </div>
     
      <div class="col-lg-6">
    <label for="usr">Code For Repay API</label>
   <input name="auth_code" type="text" class="form-control" id="usr"  onKeyPress="if(this.value.length==5) return false;" placeholder="" value="<?php echo $auth_code;?>">
     </div>
     
     <div class="col-lg-6" style="margin-top:20px">
<input name ="user_id" style="display:none" value=" <?php echo $user_id ?>">
      <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;">Update</button>
  </div>
    </div>
   
  </form>
  
  </div>

</body>
</html>

<?php 

if(isset($_POST['btn-submit'])) {
    
$status_update=$_POST['status']; 
$access_level_update=$_POST['level_of_access'];
$auth_code_up=$_POST['auth_code'];
$date = date('Y-m-d H:i:s');    

mysqli_query($con, "UPDATE tbl_users SET status ='$status_update',access_id='$access_level_update',last_update_by='$uuu_id',last_update_date='$date',auth_code='$auth_code_up' where user_id ='$id'");   
   
    ?>
    
    <script type="text/javascript">
window.location.href = 'view_all_user.php';
</script>
<?php
}


?>

