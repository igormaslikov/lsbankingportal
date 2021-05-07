<?php
session_start();
include_once 'dbconnect.php';
include 'dbconfig.php';
if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$uu_id=$userRow['user_id'];
//echo "<br><br><br>id is:".$uu_id;

$u_access_id = $userRow['access_id'];
if($u_access_id=='0'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}


$id=$_GET['id'];



$sql=mysqli_query($con, "select * from business_group where bg_id= '$id'"); 

while($row = mysqli_fetch_array($sql)) {

$bg_name=$row['bg_name'];
$email_id =$row['email_id'];
$address1 =$row['address1'];
$address2 =$row['address2'];
$contact_number1 =$row['contact_number1'];
$contact_number2=$row['contact_number2'];
$state=$row['state'];
$base_currency=$row['base_currency'];
$creation_date=$row['creation_date'];
$last_update=$row['last_update_by'];
$created_by=$row['created_by'];
$last_update_date=$row['last_update_date'];
}





$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];

}

//echo "fname is:".$first_name;



$sql=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row = mysqli_fetch_array($sql)) {

$username=$row['username'];

}

//echo "fname is:".$username;


$sql=mysqli_query($con, "select * from tbl_users where user_id= '$last_update'"); 

while($row = mysqli_fetch_array($sql)) {

$username_update=$row['username'];

}

//echo "fname is:".$username_update;

?>







<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['email']; ?></title>

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />

<style>

.sidenav {
 width: 220px;
 position: absolute;
 z-index: 1;
 top: 3px;
 left: -44px;
 background: #1E90FF;
 overflow-x: hidden;
 padding: 8px 0;
}
    
    
    .sidenav a {
 padding: 0px 0px 0px 7px;
 text-decoration: none;
 font-size: 15px;
 color: white;
 display: block;
}

.sidenav a:hover {
 color: white;
}
    .wrapper {
    width: 100%;
    max-width: 1260px;
    margin: 20px auto 100px auto;
    padding: 0;
    position: relative;
}
</style>





</head>
<body>

<?php include('menu.php') ;?>

<div class ="container wrapper" style="margin-top:100px">





  <div class="row wrapper">
      
              
      <div class="col-lg-10">
          <div class="row" style="background-color: #F5E09E;padding:20px;">
<div class="col-lg-4"><p> Portfolio Name:<b style="color:"> <?php echo $bg_name;?></b></p></div>
<div class="col-lg-4"><p> Created By:<b style="color:"> <?php echo $username;?> </b> </p></div>
<div class="col-lg-4"><p> Creation Date:<b style="color:"> <?php echo $creation_date;?> </b></p></div>
<div class="col-lg-4"><p>Last Update By: <b style="color:"><?php echo $username_update;?> </b></p></div>
<div class="col-lg-4"><p> Last Update Date: <b style="color:"> <?php echo $last_update_date;?></b></p></div> 
          </div>
          <br><br>
  <form action ="#" method="POST">
    <div class="form-group" >
    <div class="row">
      
<div class="col-lg-6" >
      <label for="usr">Portfolio Name</label>
      <input name="comapny_name" type="text" class="form-control" id="usr" placeholder="" value="<?php echo $bg_name; ?>">
    </div>
  
  <div class="col-lg-6">
      <label for="usr">Portfolio Address </label>
      <input name="company_address1" type="text" class="form-control" id="usr" placeholder="" value="<?php echo $address1; ?>">
    </div>

     <div class="col-lg-6">
      <label for="usr">Portfolio Email</label>
      <input name="comapny_email" type="text" class="form-control"  id="usr" placeholder="" value="<?php echo $email_id; ?>">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Portfolio Phone </label>
      <input name="comapny_phone1" type="text" class="form-control"  id="usr" placeholder="" value="<?php echo $contact_number1; ?>">
    </div>

    <div class="col-lg-6">
      <label for="usr">State</label>
      <input name="comapny_state" type="text" class="form-control"  id="usr" placeholder="" value="<?php echo $state; ?>">
    </div>
    
    </div>

    <br>
        
      <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: white;background-color: #1E90FF;border-radius: 0px;border-color: #1E90FF;">Update</button>
  </form>
  
</div>
</div>

  </div></div>
   
<hr>

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
if(isset($_POST['btn-submit'])) {
    
$comapny_name_update =$_POST['comapny_name'];
$company_address1_update =$_POST['company_address1'];
$company_address2_update =$_POST['company_address2'];
$comapny_email_update = $_POST['comapny_email'];
$comapny_phone1_update =$_POST['comapny_phone1'];
$comapny_phone2_update =$_POST['comapny_phone2'];
$comapny_state_update =$_POST['comapny_state'];
$base_currency_update =$_POST['base_currency'];

$date = date('Y-m-d H:i:s');


  if ($update_allowed_validate==1)
{
   
mysqli_query($con, "UPDATE business_group SET bg_name ='$comapny_name_update' , email_id='$comapny_email_update' , address1='$company_address1_update'  , contact_number1='$comapny_phone1_update', state='$comapny_state_update', last_update_by='$uu_id',last_update_date='$date' where bg_id ='$id'"); 

    ?>
    
    <script type="text/javascript">
window.location.href = 'view_all_companies.php';
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

