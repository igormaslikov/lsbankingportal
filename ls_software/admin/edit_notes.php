<?php
session_start();
include_once 'dbconnect.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$uu_id=$userRow['user_id'];
//$username=$userRow['username'];
//echo "<br><br><br>id is:".$uu_id;

$u_access_id = $userRow['access_id'];
if($u_access_id=='0'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}


$id_loan=$_GET['id'];



$sql_loan_type=mysqli_query($con, "select * from tbl_loan_notes where loan_id='$id_loan'"); 

while($row_loan_type = mysqli_fetch_array($sql_loan_type)) {

$loan_id=$row_loan_type['loan_id'];
//echo $loan_id;
$loan_type=$row_loan_type['notes'];
$category_loan=$row_loan_type['category'];
$creation_date=$row_loan_type['created_at'];
$created_by=$row_loan_type['created_by'];
$last_update_date=$row_loan_type['updated_at'];
$last_update=$row_loan_type['updated_by'];

}



$id=$_GET['id'];



$sql=mysqli_query($con, "select * from tbl_loan where loan_id= '$id'"); 

while($row = mysqli_fetch_array($sql)) {

$fnd_id=$row['user_fnd_id'];
//echo "fndis is:".$fnd_id;
$amount_loan=$row['amount_of_loan'];
$amount_left =$row['amount_left'];
$bg_id=$row['bg_id'];
$next_payment =$row['next_payment_date'];
$payment_tenure =$row['payment_tenure'];
$escrow=$row['escrow'];
$primary_port=$row['primary_portfolio'];

}



$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];

}

//echo "fname is:".$first_name;



$sql=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row = mysqli_fetch_array($sql)) {

$username=$row['username'];

}



$sql=mysqli_query($con, "select * from tbl_users where user_id= '$last_update'"); 

while($row = mysqli_fetch_array($sql)) {

$username_update=$row['username'];

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


<style>

.sidenav {
 width: 220px;
 position: absolute;
 z-index: 1;
 top: 20px;
 left: -33px;
 background: #1E90FF;
 overflow-x: hidden;
 padding: 8px 0;
}
    
    
    .sidenav a {
 padding: 0px 0px 0px 7px;
 text-decoration: none;
 font-size: 15px;
 color: white;
 display: block;
}

.sidenav a:hover {
 color: white;
}
    
</style>


</head>
<body>

<?php include('menu.php') ;?>


<div class ="container" style="margin-top:100px">
    <div class="row">
         
        <div class="col-lg-2">
           
           <div class="sidenav">
 <a href="loan_summary.php?id=<?php echo $id; ?>">Loan Summary</a>
 <hr>
 <a href="loan_notes.php?id=<?php echo $id; ?>">Loan Notes</a>
 <hr>
 <a href="loan_payments.php?id=<?php echo $id; ?>">Loan Payments</a>
 <hr>
 <a href="edit_loan.php?id=<?php echo $id; ?>">Loan Settings</a>
 <br>

</div>
            
            </div>
        <div class="col-lg-10">
            
        
<br>

<div class="row" style="background-color:#FFA500;padding:20px;">

<div class="col-lg-4"><p> Customer Name:<b style="color:red"> <?php echo $first_name;?></b></p></div>
<div class="col-lg-4"><p> Created By:<b style="color:red"> <?php echo $username;?> </b> </p></div>
<div class="col-lg-4"><p> Creation Date:<b style="color:red"> <?php echo $creation_date;?> </b></p></div>
<div class="col-lg-4"><p> Last Update By: <b style="color:red"><?php echo $username_update;?> </b></p></div>
<div class="col-lg-4"><p> Last Update Date: <b style="color:red"> <?php echo $last_update_date;?></b></p></div>

</div>

<br>

  <div class="row">
      <div class="col-lg-12">
  <form action ="#" method="POST">
    <div class="form-group" >
    <div class="row">

    <br><br>
     <div class="col-lg-6">
      <label for="usr">Loan Notes</label>
      <textarea  name="next_payment" class="form-control" id="usr" placeholder="" value=""> <?php echo $loan_type; ?> </textarea>
    </div>
    
     <div class="col-lg-6">
      <label for="usr">Category</label>
      <textarea  name="category" class="form-control" id="usr" placeholder="" value=""> <?php echo $category_loan; ?> </textarea>
    </div>
    
    </div>

    <br>
        
      <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: white;background-color: #1E90FF;border-radius: 0px;border-color: #1E90FF;">Update</button>
  </form>
  
</div>
</div>

  </div></div>
   </div>
    </div>
<hr>

</body>
</html>

<?php 

if(isset($_POST['btn-submit'])) {
    
$notes_update = $_POST['next_payment'];
$category_update=$_POST['category'];
$date = date('Y-m-d H:i:s');

 mysqli_query($con, "UPDATE tbl_loan_notes SET  notes ='$notes_update' , category='$category_update' , updated_at ='$date' , updated_by ='$uu_id' where loan_id ='$loan_id'"); 
    
    ?>


 <script type="text/javascript">
window.location.href = 'loan_summary.php?id=<?php  $loan_id_payoff= $_GET['id']; echo $loan_id_payoff ;?>';
</script>   

<?php
}

?>


