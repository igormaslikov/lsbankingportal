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
$user_name=$userRow['username'];
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
    $f_id=$_GET['f_id'];
    //$page=$_GET['page_id'];
    
    
    $form_name=basename(__FILE__);

//echo $form_name;
 $sql_role=mysqli_query($con, "select * from access_form where form_name ='$form_name'"); 


while($row_role = mysqli_fetch_array($sql_role)) {

 $form_id=$row_role['id'];
 //echo $form_id;
}

 $delete_allowed = user_roles($u_access_id,$form_id);

//echo $delete_allowed;

  if ($delete_allowed==1)
{
    $query = "DELETE FROM access_level_grants WHERE grant_id = '$id'";
    $result = mysqli_query($con, $query);
       if ($result) {
           //echo "<div class='form'><h3> Customer Successfully Deleted.</h3><br/></div>";
       } else {
       echo "<div class='form'><h3> Error in Deleting Data.</h3></div>";
       }
       
       
        $loan_create_id="";
        $transaction_id="";
        $delete_reason="The Access of user  is Deleted by $user_name";
        application_notes_update($fnd_id,$loan_create_id,$u_id,$delete_reason,$transaction_id);
?>

    <script type="text/javascript">
window.location.href = 'edit_form.php?id=<?php echo $f_id;?>';
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