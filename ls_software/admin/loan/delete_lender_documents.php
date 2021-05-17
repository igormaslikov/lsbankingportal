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

   include '../functions.php';
    $doc_id=$_GET['doc_id'];
    $id=$_GET['id'];
     $loan_id=$_GET['loan_id'];
    
     $sql_fnd=mysqli_query($con, "select * from tbl_loan where loan_id = '$loan_id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];
$loan_create_id=$row_fnd['loan_create_id'];
}
    
    $form_name="payday-".basename(__FILE__);
    
    echo "Form: ".$form_name;
    $sql_role=mysqli_query($con, "select * from access_form where form_name='$form_name'"); 


while($row_role = mysqli_fetch_array($sql_role)) {

 $form_id=$row_role['id'];
 
}
  $delete_allowed = user_roles($u_access_id,$form_id);
    
    
    if ($delete_allowed==1)
{ 
    $transaction_id="";

$delete_reason="Document is Deleted with Loan ID: $loan_create_id";

    $query = "DELETE FROM  lender_documents WHERE id= '$doc_id' AND  fnd_user_id = '$id' ";
    $result = mysqli_query($con, $query);
       if ($result) {
           //echo "<div class='form'><h3> Customer Successfully Deleted.</h3><br/></div>";
       } else {
       echo "<div class='form'><h3> Error in Deleting Data.</h3></div>";
       }
       application_notes_update($user_fnd_id,$loan_create_id,$u_id,$delete_reason,$transaction_id);
	   ?>

    <script type="text/javascript">
window.location.href = 'user_files.php?id=<?php echo $loan_id;?>';
</script>
</html>
<?php
}



else{
  echo "<script type='text/javascript'>
window.location.href = '../not_authorize.php';
</script>";
}
}
?>