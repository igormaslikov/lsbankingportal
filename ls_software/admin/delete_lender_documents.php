<html>
<?php
error_reporting(0);
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';


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
    $doc_id=$_GET['doc_id'];
    $id=$_GET['id'];
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

    $query = "DELETE FROM  lender_documents WHERE id= '$doc_id' AND  fnd_user_id = '$id' ";
    $result = mysqli_query($con, $query);
       if ($result) {
           //echo "<div class='form'><h3> Customer Successfully Deleted.</h3><br/></div>";
       } else {
       echo "<div class='form'><h3> Error in Deleting Data.</h3></div>";
       }
       
	   $delete_customer_string = "status=".$_GET['status']."&keyword=".$_GET['keyword']."&search=".$_GET['search']."&from_date=".$_GET['from_date']."&to_date=".$_GET['to_date']."&website=".$_GET['website']."&page_no=".$_GET['page_no'];
?>

    <script type="text/javascript">
window.location.href = 'edit_customer.php?id=<?php echo $id; echo "&"; echo $delete_customer_string;?>';
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