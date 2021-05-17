<?php
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
    margin: 20px auto 100px auto;
    padding: 0;
    position: relative;
}
</style>
</head>

<body>

<?php include('menu.php') ;?>

    
  <div class ="container wrapper" style="margin-top:100px">

<h4>  Add New User:</h4>

  <div class="row wrapper">

  <form action ="#" method="POST">
  
  <div class="col-lg-6" >
      <label for="usr"> User Name </label>
      <input name="user_name" type="text" class="form-control" id="usr" placeholder="" value="">
    </div>
  
  <!-- <input name="id_type" type="text" class="form-control" id="usr" placeholder="" value="<?php echo $id_type;?>">-->

  <div class="col-lg-6">
      <label for="usr"> User Email </label>
      <input name="user_email" type="text" class="form-control" id="usr" placeholder="" value="">
    </div>

    <div class="col-lg-6">
      <label for="usr"> User Password </label>
      <input name="user_password" type="password" class="form-control"  id="usr" placeholder="" value="">
    </div>
    
     
<div class="col-lg-6">
      <label for="usr"> Portfolio/Companies </label>
     <select name="c_id" class="form-control">
        
       
        <?php
   


$sql1 = mysqli_query($con, "SELECT bg_id,bg_name From business_group");
$row1 = mysqli_num_rows($sql1);
while ($row1 = mysqli_fetch_array($sql1)){
echo "<option value='". $row1['bg_id'] ."'>" .$row1['bg_name'] ."</option>" ;
}

?>
 
        </select>
    </div>
    
    
     <div class="col-lg-6">
      <label for="usr"> Level Of Access</label>
<select name="level_access" class="form-control">

 <?php
   

$sql_access = mysqli_query($con, "SELECT access_id,access_level From access_level");
$row_access = mysqli_num_rows($sql_access);
while ($row_access = mysqli_fetch_array($sql_access)){
echo "<option value='". $row_access['access_id'] ."'>" .$row_access['access_level'] ."</option>" ;
}

?>

</select>
    </div>
    
    </div>
<br>
      <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: #1E90FF;border-color: #1E90FF;">Add this User</button>
  </form>
  
</div>
</div>

  </div></div>
   
<hr>

</body>
</html>     

<?php 

$created_by= $userRow['user_id'];

if(isset($_POST['btn-submit'])) {
 
$user_name = $_POST['user_name'];
$user_email= $_POST['user_email'];
$user_password= $_POST['user_password'];
$phone = $_POST['phone'];
$address= $_POST['address'];
$c_id= $_POST['c_id'];
$level_access=$_POST['level_access'];
$hashed_password = password_hash($user_password, PASSWORD_DEFAULT); 
$date = date('Y-m-d H:i:s');
 
$query  = "INSERT INTO tbl_users (bg_id,access_id,username,email,password,phone,address,status,created_by,created_at)  VALUES ('$c_id','$level_access','$user_name','$user_email','$hashed_password','$phone','$address','Active','$created_by','$date')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }

    ?>
    
    <script type="text/javascript">
window.location.href = 'view_all_user.php';
</script>
<?php
}

?>

<?php
}
?>