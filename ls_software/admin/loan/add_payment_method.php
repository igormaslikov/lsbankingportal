<?php
error_reporting(0);
session_start();
include_once '../dbconnect.php';
include_once '../dbconfig.php';
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
 
$sql_fnd=mysqli_query($con, "select * from tbl_loan where loan_id = '$id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];
$loan_create_id=$row_fnd['loan_create_id'];
//echo "FND_ID" .$user_fnd_id;
}


$sql_bank_detail=mysqli_query($con, "select * from loan_initial_banking where user_fnd_id = '$user_fnd_id'"); 

while($row_bank_detail = mysqli_fetch_array($sql_bank_detail)) {

$type_of_id=$row_bank_detail['type_of_id'];
$id_photo=$row_bank_detail['pic_of_id'];
$type_of_card=$row_bank_detail['type_of_card'];

$card_number=$row_bank_detail['card_number'];
$card_exp_date=$row_bank_detail['card_exp_date'];
$bank_front=$row_bank_detail['bank_front_pic'];

$bank_back=$row_bank_detail['bank_back_pic'];
$bank_name=$row_bank_detail['bank_name'];
$routing_number=$row_bank_detail['routing_number'];

$account_number=$row_bank_detail['account_number'];
$void_img=$row_bank_detail['void_check_pic'];
$cvv_number=$row_bank_detail['cvv_number'];

}


?>


<?php


$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];
$last_name=$row['last_name'];
$customer_numbr=$row['mobile_number'];


}

//echo "fname is:".$first_name;

?>
<?php


$sql=mysqli_query($con, "select * from tbl_loan where loan_id= '$id'"); 

while($row = mysqli_fetch_array($sql)) {

$loan_id=$row['loan_id'];
//echo "fndid is:".$fnd_id;
$amount_loan=$row['amount_of_loan'];

//echo "Amount is:".$amount_loan;

$amount_left =$row['loan_total_payable'];
$bg_id=$row['bg_id'];
$next_payment =$row['payment_date'];
$payment_tenure =$row['payment_tenure'];
$escrow=$row['escrow'];
$primary_port=$row['primary_portfolio'];
$creation_date=$row['contract_date'];
$created_by=$row['created_by'];
$last_update=$row['last_update_by'];
$last_update_date=$row['last_update_date'];

 $timestamp = strtotime($creation_date);
 
// Creating new date format from that timestamp
$new_creation_date= date("m-d-Y", $timestamp);
}

?>

 <?php



$sql_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$username=$row_user['username'];

}

//echo "fname is:".$username;

?> 
      
      
      
      
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">


  <!-- Bootstrap core CSS -->
 
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/simple-sidebar.css" rel="stylesheet">

</head>

<body>
    

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading"> </div>
      <div class="list-group list-group-flush">
 
        <?php include('vertical_menu.php'); ?>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
          <?php include('horizontal_menu.php'); ?>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

       
      </nav>
  <br>

<div class="row container-fluid" style="background-color: #F5E09E;color:black;padding:20px;">

<div class="col-lg-4"><p>Customer First Name:<b style="color:red"> <?php echo $first_name;?></b></p></div>
<div class="col-lg-4"><p>Customer Last Name: <b style="color:red"><?php echo $last_name;?> </b></p></div>
<div class="col-lg-4"><p>Customer Phone:<b style="color:red"> <?php echo $customer_numbr;?> </b> </p></div>
<div class="col-lg-3"><p>Loan Date:<b style="color:red"> <?php echo $new_creation_date;?> </b></p></div>
<div class="col-lg-3"><p>Loan Amount: <b style="color:red">$<?php echo $amount_loan;?></b></p></div>
<div class="col-lg-3"><p>Loan ID:<b style="color:red"> <?php echo $loan_create_id;?> </b> </p></div>
<div class="col-lg-3"><p>User ID:<b style="color:red"> <?php echo $user_fnd_id;?> </b> </p></div>

</div>
      <br><br>
      
      <?php
      
      
     if(isset($_POST['btn-submit'])) 
{
    
    
     $type_id_up= $_POST['type_id'];
     $type_card_up= $_POST['type_card'];
     $card_exp_date_up= $_POST['card_exp_date'];
     $card_number_up= $_POST['card_number'];
    
     $bank_name_up= $_POST['bank_name'];
     $routing_number_up= $_POST['routing_number'];
     $account_number_up= $_POST['account_number'];
     $cvv_number_up= $_POST['cvv_number'];
        
        
       
 
     
   $query  = "INSERT INTO tbl_payment_method (user_fnd_id,card_type,card_exp_date,card_number,bank_name,routing_number,account_number,cvv,created_by)  VALUES ('$user_fnd_id','$type_card_up','$card_exp_date_up','$card_number_up','$bank_name_up','$routing_number_up','$account_number_up','$cvv_number_up','$u_id')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }   
      
}
      ?>
         <div class="container-fluid" style="width:100%; margin:0 auto;">
        

  <form action ="" method="POST" enctype="multipart/form-data">
 <input type="text" name="emaill" value="<?php echo $email;?>" style="display:none;">
<input type="text" name="link" value="<?php echo $message;?>" style="display:none;">

  <h3>Add Payment Method</h3>
  <br>
  <div class="row">
      
 <!--<div class="col-lg-6">-->
 <!--     <label for="usr">Type of ID</label>-->
 <!--     <select name="type_id" id="type_id" class="form-control"  value="" >-->
 <!--    <option></option>-->
 <!--    <option value="Drivers License" >Drivers License</option>-->
 <!--     <option value="State Personal ID" >State Personal ID</option>-->
 <!--     <option value="Matricula Consular ID" >Matricula Consular ID</option>-->
 <!--     <option value="Tribal ID" >Tribal ID</option>-->
 <!--     <option value="Passport" >Passport</option>-->
 <!--     <option value="Military ID">Military ID</option>-->
 <!--     <option value="Other">Other</option>-->
 <!--    </select>-->
 <!--   </div> -->
  
     <div class="col-lg-6">
      <label for="usr">Type of Card</label>
      <select name="type_card" id="type_card" class="form-control"  value="" >
     <option></option>
     <option value="Visa">Visa</option>
      <option value="Master Card">Master Card</option>
     </select>
    </div>
    
   
    
    <div class="col-lg-6">
      <label for="usr">Card Expiration Date</label>
      <input type="date" name="card_exp_date"  class="form-control" id="usr" value="" >
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Card Number</label>
      <input type="text" name="card_number"  class="form-control" id="usr" value="" ><br>
    </div>
    
   
    <div class="col-lg-6">
      <label for="usr">Bank Name</label>
      <select name="bank_name" id="bank_name" class="form-control"  value="" >
     <option></option>
     <option value="Bank Of America">Bank Of America</option>
     <option value="Chase">Chase</option>
     <option value="Wells Fargo">Wells Fargo</option>
     <option value="Citi Bank ">Citi Bank </option>
     <option value="US Bank">US Bank</option>
     <option value="HSBC">HSBC</option>
     </select><br>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Routing Number</label>
      <input type="text" name="routing_number"  class="form-control" id="usr" value="" >
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Account Number</label>
      <input type="text" name="account_number"  class="form-control" id="usr" value="" ><br>
    </div>
    
    
    <div class="col-lg-6">
      <label for="usr">CVV Number</label>
      <input type="text" name="cvv_number"  class="form-control" id="usr" value="" >
    </div>
    
    </div>
       <br> 
       
      
      <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: white;background-color: #1E90FF;border-radius: 0px;border-color: #1E90FF;">Add Method</button>
    </form>

</div>
</div>
</div>
        
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  
  <!-- /#wrapper -->

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
  <?php
  
}
?>
</body>

</html>
