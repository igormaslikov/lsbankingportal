<html>
    
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LS Financing Admin Login</title>
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="../bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="../style.css" type="text/css" />

</head>
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

<?php


   include 'functions.php';
    $id=$_GET['id'];
    
    
    $delete_allowed_validate = user_roles($u_access_id,$id);

if ($delete_allowed_validate==1)
{
    
     $query = "DELETE FROM access_form WHERE id = '$id'";
    $result = mysqli_query($con, $query);
       if ($result) {
           //echo "<div class='form'><h3> Customer Successfully Deleted.</h3><br/></div>";
       } else {
       echo "<div class='form'><h3> Error in Deleting Data.</h3></div>";
       }  
    
    
}

else{
  echo "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; You are not authorized.
				</div>";
}
   
?>

    <script type="text/javascript">
window.location.href = 'view_all_form.php';
</script>
</html>
<?php
}
?>