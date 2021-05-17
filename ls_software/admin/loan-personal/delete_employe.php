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
    $id_src=$_GET['id_src'];
    $id=$_GET['id'];
    
    $sql_fnd=mysqli_query($con, "select * from tbl_personal_loans where p_loan_id = '$id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];
$loan_create_id=$row_fnd['loan_create_id'];
}
    
    $form_name="personal-".basename(__FILE__);
    
    echo "Form: ".$form_name;
    $sql_role=mysqli_query($con, "select * from access_form where form_name='$form_name'"); 


while($row_role = mysqli_fetch_array($sql_role)) {

 $form_id=$row_role['id'];
 
}
    $delete_allowed = user_roles($u_access_id,$form_id);
    
    
    if ($delete_allowed==1)
{
    $transaction_id="";
    $del_reason="Job is Deleted with job ID: $id_src & User ID: $user_fnd_id";

    $query = "DELETE FROM source_income_personal WHERE scr_inc_id = '$id_src'";
    $result = mysqli_query($con, $query);
       if ($result) {
           //echo "<div class='form'><h3> Customer Successfully Deleted.</h3><br/></div>";
       } else {
       echo "<div class='form'><h3> Error in Deleting Data.</h3></div>";
       }
       
     application_notes_update($user_fnd_id,$loan_create_id,$u_id,$del_reason,$transaction_id);  
       
       
?>

   <script type="text/javascript">
window.location.href = 'employer_detail.php?id=<?php echo $id; ?>';
</script>

<?php
}



else{
  echo "<script type='text/javascript'>
window.location.href = '../not_authorize.php';
</script>";
}
}
?>