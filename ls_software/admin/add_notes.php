<?php
session_start();
error_reporting(0);
include_once 'dbconnect.php';
include_once 'dbconfig.php';
include 'functions.php';

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


$loan_id_payoff=$_GET['id'];
 $form_name=basename(__FILE__);  
   
if(isset($_POST['btn-submit'])) 
{



    $sql_role=mysqli_query($con, "select * from access_form where form_name='$form_name'"); 


    while($row_role = mysqli_fetch_array($sql_role)) {

    $form_id=$row_role['id'];
    echo $form_id;
 
}  
     
     user_roles($u_access_id,$form_id);
     
         if ($insert_allowed=='1' || $u_access_id=='1')
{

$laon_notes=$_POST['loan_notes'];
$category=$_POST['category'];
$date = date('Y-m-d H:i:s');

$query_notes  = "INSERT INTO tbl_loan_notes (loan_id,notes,category,created_at,created_by)  VALUES ('$loan_id_payoff','$laon_notes','$category','$date','$u_id')";
        $result = mysqli_query($con, $query_notes);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }  
 
?>

<script type="text/javascript">
window.location.href = 'loan_summary.php?id=<?php  $loan_id_payoff= $_GET['id']; echo $loan_id_payoff ;?>';
</script>
<?php
}



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

<?php //include('menu.php') ;?>

    
  <div class ="container" style="margin-top:100px">

  <div class="row">

  <form action ="" method="POST" enctype="multipart/form-data">

  <div class="row">
      
    <div class="col-lg-6">
      <label for="usr">Loan Notes</label>
      <textarea name="loan_notes" class="form-control" id="usr" placeholder="Loan Notes" value=""></textarea>
    </div>
    
    
    <div class="col-lg-6">
      <label for="usr">Category</label>
      <input type="text" name="category" class="form-control" id="usr" placeholder="Category" value="">
    </div>
    
    </div>
    
    <br>
    
      <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: blue;border-color: blue;">Add New Notes</button>
  </form>
  
</div>
</div>

<hr>


</body>
</html>