<html>
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
$u_access_id = $userRow['access_id'];
if($u_access_id=='0'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}
else {
$DBcon->close();

?>

<?php
     include 'functions.php';
    $id=$_GET['id'];
    $form_name=basename(__FILE__);
    
     $sql_role=$con->query("select * from access_form where form_name ='$form_name'"); 


while($row_role = $sql_role->fetch_array()) {

 $form_id=$row_role['id'];
}

 $delete_allowed = user_roles($u_access_id,$form_id);


  if ($delete_allowed==1)
{
    

    $query = "DELETE FROM access_level WHERE access_id = '$id'";
    $result = $con->query($query);
       if ($result) {
           //echo "<div class='form'><h3> Customer Successfully Deleted.</h3><br/></div>";
       } else {
       echo "<div class='form'><h3> Error in Deleting Data.</h3></div>";
       }
?>

    <script type="text/javascript">
window.location.href = 'view_all_roles.php';
</script>
</html>
<?php
}

else{
  echo "<script type='text/javascript'>
window.location.href = 'not_authorize.php';
</script>";
}
}
?>