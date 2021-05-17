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
if($u_access_id=='2' || $u_access_id=='4' || $u_access_id=='5'){
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

<h4>  Add New Form:</h4>

  <div class="row wrapper">

  <form action ="#" method="POST">
  
    <div class="col-lg-6" >
      <label for="usr"> Form Name </label>
      <input name="form_name" type="text" class="form-control" id="usr" placeholder="" value="">
    </div>
    
    <div class="col-lg-6" >
      <label for="usr"> Form Description </label>
      <input name="form_description" type="text" class="form-control" id="usr" placeholder="" value="">
    </div>
  <br><br><br><br>
<div class="col-lg-6" >
      <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: #1E90FF;border-color: #1E90FF;">Add this Form</button>
  </div>
  </form>
  
</div>
</div>

  </div></div>
   
<hr>

</body>
</html>     

<?php 


if(isset($_POST['btn-submit'])) {
 
$form_name = $_POST['form_name'];
$form_description=$_POST['form_description'];
 
$query  = "INSERT INTO `access_form` (`form_name`,`form_description`) VALUES ('$form_name','$form_description')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }

    ?>
    
    <script type="text/javascript">
window.location.href = 'view_all_form.php';
</script>
<?php
}

?>

<?php
}
?>