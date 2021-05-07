<?php
error_reporting(0);
session_start();
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
$day_budget=$_GET['date'];
//echo $day_budget;
$budget_month=$_GET['month'];

$budget_year=$_GET['year'];



//echo $budget_year;


   
 

if(isset($_POST['btn-submit'])) 
{
    
$monthly_budget= $_POST['monthly_budget'];
//$date_bu = $budget_year.'-'.$budget_month.'-'.$day_buget;

//echo "date is:".$date_bu;

$query_budget  = "INSERT INTO tbl_budget (budget_amount,creation_date)  VALUES ('$monthly_budget','$day_budget')";
        $result_budget = mysqli_query($con, $query_budget);
        if ($result_budget) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
        
?>

<script type="text/javascript">
window.location.href = 'marketing.php';
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
  
  <h3>Manage Budget</h3>
  <div class="row">
      
  <div class="col-lg-6" >
      <label for="usr">Monthly Budget</label>
      <input name="monthly_budget" type="number" step="any" class="form-control" id="usr" placeholder="" value="">
    </div>
    
    </div>
    
    <br>
    
      <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: #1E90FF;border-color: #1E90FF;">Add Budget</button>
  </form>
  
</div>
</div>

<hr>

</body>
</html>    

<?php 
 
if(isset($_POST['btn-submit'])) 
{
   
$fb_update= $_POST['facebook_value'];
$goo_update= $_POST['google_value'];

mysqli_query($con, "UPDATE tbl_fb SET fb_value ='$fb_update' where creation_date ='$cr_date'"); 

mysqli_query($con, "UPDATE tbl_google SET gogl_value ='$goo_update' where creation_date ='$cr_date'"); 

    ?>
    
    <script type="text/javascript">
window.location.href = 'marketing.php';
</script>
<?php
}

?>

<?php 
}
?>