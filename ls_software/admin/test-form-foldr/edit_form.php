<?php
error_reporting(0);
session_start();

include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: ../index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);

$userRow=$query->fetch_array();
$u_id=$userRow['user_id'];
$u_access_id = $userRow['access_id'];
if($u_access_id=='2' || $u_access_id=='4' || $u_access_id=='5'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}
else {
$DBcon->close();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>Welcome - <?php echo $userRow['email']; ?></title>

<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="../bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="../style.css" type="text/css" />

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>


</head>
<body>
    
    
    <?php 
$id=$_GET['id'];
if(isset($_POST['btn-submit-phone'])) {
    
    
$level_of_access=$_POST['level_of_access'];
$select_allowed=$_POST['select_allowed'];
$insert_allowed=$_POST['insert_allowed'];
$update_allowed=$_POST['update_allowed'];
$delete_allowed=$_POST['delete_allowed'];


mysqli_query($con, "Insert into  access_level_grants (role_id,form_id,select_allowed,insert_allowed,update_allowed,delete_allowed) Values ('$level_of_access','$id','$select_allowed','$insert_allowed','$update_allowed','$delete_allowed')");   
   
    ?>
    
    <script type="text/javascript">
window.location.href = 'view_all_form.php';
</script>
<?php
}


?>
<?php 
include 'functions.php';
if(isset($_POST['btn-submit'])) {
    
$form_name_update=$_POST['form_name']; 


    
$update_allowed_validate = user_edit_roles($u_access_id,$id);

if ($update_allowed_validate==1)
{
    mysqli_query($con, "UPDATE access_form SET form_name = '$form_name_update' where id ='$id'");
    
}

else {
   $msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; You are not authorized.
				</div>";
}
    ?>
    
     <script type="text/javascript">
//window.location.href = 'view_all_form.php';
 </script>
<?php
}


?>
    
    
    
    <?php //include('../menu.php') ;?>


  <div class ="container" style="margin-top:100px">





<br>

<?php



$sql=mysqli_query($con, "select * from access_form where id = '$id'"); 


while($row = mysqli_fetch_array($sql)) {

$form_name=$row['form_name'];

}


?>

  <div class="row">
       <?php
		if(isset($msg)){
			echo $msg;
		}
		?>
  <form action ="#" method="POST">
    
     <div class="col-lg-6" >
      <label for="usr"> Form Name </label>
      <input name="form_name" type="text" class="form-control" id="usr" placeholder="" value="<?php echo $form_name;?>">
    </div>
    
    
    
    </div>
    <br>
      <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;">Update Form</button>
  </form>
  
  </div>
   
<hr>
<br>
<div class ="container" style="margin-top:0px">
  <div class="row">
  <table class="table table-striped table-bordered">
<thead>
<tr style="background-color: #F5E09E;color: white">
<th style='width:30px;color:black;'>Role</th>
<th style='width:30px;color:black;'>Select Allowed</th>
<th style='width:30px;color:black;'>Insert Allowed</th>
<th style='width:30px;color:black;'>Update Allowed</th>
<th style='width:30px;color:black;'>Delete Allowed</th>
<th style='width:30px;color:black;'>Action</th>
</tr>
</thead>
<tbody>
  <?php 
  $sql_phone=mysqli_query($con, "select * from access_level_grants where form_id = '$id'"); 


while($row_phone = mysqli_fetch_array($sql_phone)) {
$grant_id = $row_phone['grant_id'];
$role_id=$row_phone['role_id'];
$select_allowed=$row_phone['select_allowed'];
$insert_allowed=$row_phone['insert_allowed'];
$update_allowed=$row_phone['update_allowed'];
$delete_allowed=$row_phone['delete_allowed'];

$sql_access=mysqli_query($con, "select * from access_level where access_id= '$role_id'"); 

while($row_access = mysqli_fetch_array($sql_access)) {

$access_level_name=$row_access['access_level'];

	//	echo "<br><br><br><br><br><br>". $access_level_name;

}

if($select_allowed==1)
{
    $select_allowed="Yes";
}
else{
    $select_allowed="No";
}



if($insert_allowed==1)
{
    $insert_allowed="Yes";
}
else{
    $insert_allowed="No";
}


if($update_allowed==1)
{
    $update_allowed="Yes";
}
else{
    $update_allowed="No";
}

if($delete_allowed==1)
{
    $delete_allowed="Yes";
}
else{
    $delete_allowed="No";
}

echo "<tr>
	 	      
	 		  <td>".$access_level_name."</td>
	 		  <td>".$select_allowed."</td>
	 		  <td>".$insert_allowed."</td>
	 		  <td>".$update_allowed."</td>
	 		  <td>".$delete_allowed."</td>
		   	  <td>
<a class='remove-box' href='delete_access_level.php?id=$grant_id&f_id=$id' title='Delete This Tag'><span class='glyphicon glyphicon-remove' aria-hidden='true' alt='delete'></span></a>

</td>

		   	  </tr>";
}

?>
 
</tbody>
</table> <br>
<form action ="#" method="POST">
    
     <div class="col-lg-3">
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
     
     <div class="col-lg-3" >
      <label for="usr"> Select Allowed </label>
      <select  class="form-control" name="select_allowed">
      <option value="1">Yes</option>
      <option value="0">No</option>
      </select>
    </div>
    
    <div class="col-lg-3" >
      <label for="usr"> Insert Allowed </label>
      <select  class="form-control" name="insert_allowed">
      <option value="1">Yes</option>
      <option value="0">No</option>
      </select>
    </div>
    
     <div class="col-lg-3" >
      <label for="usr"> Update Allowed </label>
      <select  class="form-control" name="update_allowed">
      <option value="1">Yes</option>
      <option value="0">No</option>
      </select>
    </div>
    
    <div class="col-lg-3" >
      <label for="usr"> Delete Allowed </label>
      <select  class="form-control" name="delete_allowed">
      <option value="1">Yes</option>
      <option value="0">No</option>
      </select>
    </div>
     
    
    <br>
    
    </div>
 <br>
      <button name="btn-submit-phone" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;">Add Role</button>
  </form>
  
  
  <br><br>
  
  
</body>
</html>



<?php
}
?>
