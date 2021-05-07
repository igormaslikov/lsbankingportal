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

$cr_date=$_GET['date'];
//echo $cr_date;



if(isset($_POST['btn-submit'])) 
{
    
$fb_value= $_POST['facebook_value'];
$goo_value= $_POST['google_value'];

$query_facebook  = "INSERT INTO tbl_fb (fb_value,creation_date)  VALUES ('$fb_value','$cr_date')";
        $result_facebook = mysqli_query($con, $query_facebook);
        if ($result_facebook) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
        
        
        $query_google  = "INSERT INTO tbl_google (gogl_value,creation_date)  VALUES ('$goo_value','$cr_date')";
        $result_google = mysqli_query($con, $query_google);
        if ($result_google) {
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



$sql_fb=mysqli_query($con, "select * from tbl_fb where creation_date= '$cr_date'"); 

while($row_fbb = mysqli_fetch_array($sql_fb)) {
    
$fb=$row_fbb['fb_value'];

}

$sq_datel=mysqli_query($con, "SELECT * FROM tbl_loan WHERE creation_date like '$cr_date'"); 

    if ($result_loan_day = $sq_datel){
        $row_count_loan_dayy = mysqli_num_rows($result_loan_day);
    
        //echo $row_count_loan_dayy."<br>";
    }
        

$sq_datell=mysqli_query($con, "SELECT * FROM fnd_user_profile  WHERE creation_date like '$cr_date'"); 

    if ($result_lead_day = $sq_datell){
        $row_count_lead_dayy = mysqli_num_rows($result_lead_day);
    
        //echo $row_count_loan_dayy."<br>";
    }




$sql_gogl=mysqli_query($con, "select * from tbl_google where creation_date= '$cr_date'"); 

while($row_gogl = mysqli_fetch_array($sql_gogl)) {
    
$gogl=$row_gogl['gogl_value'];

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
  
  <h3>Manage Marketing</h3>
  <div class="row">
      
  <div class="col-lg-6" >
      <label for="usr">Faceook Value</label>
      <input name="facebook_value" type="number" step="any" class="form-control" id="usr" placeholder="" value="<?php echo $fb; ?>">
    </div>
  
     <div class="col-lg-6">
      <label for="usr">Google Value</label>
      <input name="google_value" type="number" step="any" class="form-control"  id="usr" placeholder="" value="<?php echo $gogl; ?>">
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Total Loans</label>
      <input name="total_loans" type="text" class="form-control"  id="usr" placeholder="" value="<?php echo $row_count_loan_dayy; ?>" disabled>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Total Leads</label>
      <input name="total_leads" type="text" class="form-control"  id="usr" placeholder="" value="<?php echo $row_count_lead_dayy; ?>" disabled>
    </div>
    
    </div>
    
    <br>
    
      <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: #1E90FF;border-color: #1E90FF;">Update</button>
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
}
?>

