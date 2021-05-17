<html>
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

    $id=$_GET['id'];
    $f_id=$_GET['f_id'];
    //$page=$_GET['page_id'];

    $query = "DELETE FROM access_level_grants WHERE grant_id = '$id'";
    $result = mysqli_query($con, $query);
       if ($result) {
           //echo "<div class='form'><h3> Customer Successfully Deleted.</h3><br/></div>";
       } else {
       echo "<div class='form'><h3> Error in Deleting Data.</h3></div>";
       }
?>

    <script type="text/javascript">
window.location.href = 'edit_form.php?id=<?php echo $f_id;?>';
</script>
</html>
<?php
}
?>