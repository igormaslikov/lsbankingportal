<?php
session_start();
error_reporting(0);
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
else {
$DBcon->close();
?>

<?php 

   include 'functions.php';
   

if(isset($_POST['btn-submit'])) 
{
    
$comapny_name= $_POST['comapny_name'];
$company_address= $_POST['company_address'];
$comapny_email= $_POST['comapny_email'];
$comapny_phone=$_POST['comapny_phone'];
$comapny_state = $_POST['comapny_state'];

$date = date('Y-m-d H:i:s');

$form_name=basename(__FILE__);

    $sql_role=mysqli_query($con, "select * from access_form where form_name='$form_name'"); 


    while($row_role = mysqli_fetch_array($sql_role)) {

    $form_id=$row_role['id'];
 
}  
     
     user_roles($u_access_id,$form_id);
     

$query  = "INSERT INTO business_group (bg_name,email_id,address1,contact_number1,state,created_by,creation_date)  VALUES ('$comapny_name','$comapny_email','$company_address','$comapny_phone','$comapny_state','$u_id','$date')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
 
?>

<script type="text/javascript">
window.location.href = 'view_all_companies.php';
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

  <div class="row wrapper">

  <form action ="" method="POST" enctype="multipart/form-data">
  
  <h3>Portfolio Information</h3>
  <div class="row">
      
  <div class="col-lg-6" >
      <label for="usr">Portfolio Name</label>
      <input name="comapny_name" type="text" class="form-control" id="usr" placeholder="" value="">
    </div>
  
     <div class="col-lg-6">
      <label for="usr">Portfolio Email</label>
      <input name="comapny_email" type="text" class="form-control"  id="usr" placeholder="" value="">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Portfolio Phone</label>
      <input name="comapny_phone" type="text" class="form-control"  id="usr" placeholder="" value="">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">State</label>
      <input name="comapny_state" type="text" class="form-control"  id="usr" placeholder="" value="">
    </div>
    <div class="col-lg-6">
      <label for="usr">Portfolio Address</label>
      <textarea name="company_address" type="text" class="form-control" id="usr" placeholder="" value=""></textarea>
    </div>
    
    </div>
    
    <br>
    
      <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: #1E90FF;border-color: #1E90FF;">Add this Portfolio</button>
  </form>
  
</div>
</div>

<hr>

</body>
</html>    
<?php 
}
?>