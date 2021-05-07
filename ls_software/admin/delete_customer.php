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
    //$page=$_GET['page_id'];

$form_name=basename(__FILE__);

//echo $form_name;
 $sql_role=mysqli_query($con, "select * from access_form where form_name ='$form_name'"); 


while($row_role = mysqli_fetch_array($sql_role)) {

 $form_id=$row_role['id'];
 //echo $form_id;
}

$sql_loan_status=mysqli_query($con, "select * from tbl_loan where user_fnd_id = '$id'"); 
while($row_loan_status = mysqli_fetch_array($sql_loan_status)) {
$loan_status=$row_loan_status['loan_status'];
}


$delete_allowed = user_roles($u_access_id,$form_id);

//echo $delete_allowed;

   if ($delete_allowed==1 && $loan_status!="Active")
{
    $query = "DELETE FROM fnd_user_profile WHERE user_fnd_id = '$id'";
    $result = mysqli_query($con, $query);
       if ($result) {
           //echo "<div class='form'><h3> Customer Successfully Deleted.</h3><br/></div>";
       } else {
       echo "<div class='form'><h3> Error in Deleting Data.</h3></div>";
       }
       
       $query_submission = "DELETE FROM fnd_user_profile_submission WHERE user_fnd_id = '$id'";
    $result_submission = mysqli_query($con, $query_submission);
       if ($result_submission) {
           //echo "<div class='form'><h3> Customer Successfully Deleted.</h3><br/></div>";
       } else {
       echo "<div class='form'><h3> Error in Deleting Data.</h3></div>";
       }
       
       
        $id=$_GET['id'];
    //$page=$_GET['page_id'];

    $query1 = "DELETE FROM source_income WHERE user_fnd_id = '$id'";
    $result1 = mysqli_query($con, $query1);
       if ($result1) {
           //echo "<div class='form'><h3> Customer Successfully Deleted.</h3><br/></div>";
       } else {
       echo "<div class='form'><h3> Error in Deleting Data.</h3></div>";
       }
       
        $id=$_GET['id'];
    //$page=$_GET['page_id'];

    $query1 = "DELETE FROM binary_questions WHERE user_fnd_id = '$id'";
    $result1 = mysqli_query($con, $query1);
       if ($result1) {
           //echo "<div class='form'><h3> Customer Successfully Deleted.</h3><br/></div>";
       } else {
       echo "<div class='form'><h3> Error in Deleting Data.</h3></div>";
       }
   
     $id=$_GET['id'];
    //$page=$_GET['page_id'];

    $query111 = "DELETE FROM application_notes WHERE user_fnd_id = '$id'";
    $result111 = mysqli_query($con, $query111);
       if ($result111) {
           //echo "<div class='form'><h3> Customer Successfully Deleted.</h3><br/></div>";
       } else {
       echo "<div class='form'><h3> Error in Deleting Data.</h3></div>";
       }
       
       $query1111 = "DELETE FROM tbl_bank_statements WHERE user_fnd_id = '$id'";
    $result1111 = mysqli_query($con, $query1111);
       if ($result1111) {
           //echo "<div class='form'><h3> Customer Successfully Deleted.</h3><br/></div>";
       } else {
       echo "<div class='form'><h3> Error in Deleting Data.</h3></div>";
       }
       
       
	   $delete_customer_string = "status=".$_GET['status']."&keyword=".$_GET['keyword']."&search=".$_GET['search']."&from_date=".$_GET['from_date']."&to_date=".$_GET['to_date']."&page_no=".$_GET['page_no'];

?>

    <script type="text/javascript">
window.location.href = 'view_all_customer_main.php?<?php echo $delete_customer_string; ?>';
</script>
</html>
<?php
}

else{
  echo "<script type='text/javascript'>
window.location.href = 'not_authorize_or_active_loan.php';
</script>";
}
}


?>