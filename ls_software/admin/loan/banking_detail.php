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
$user_name=$userRow['username'];
$u_access_id = $userRow['access_id'];
if($u_access_id=='2' || $u_access_id=='4' || $u_access_id=='5'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}
else {
$DBcon->close();

?>

<?php




 $id=$_GET['id'];
 $bank_id=$_GET['bank_id'];
 
$sql_fnd=mysqli_query($con, "select * from tbl_loan where loan_id = '$id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];
$loan_create_id=$row_fnd['loan_create_id'];
//echo "FND_ID" .$user_fnd_id;
}


$sql_bank_detail=mysqli_query($con, "select * from loan_initial_banking where initial_id = '$bank_id'"); 

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




$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];
$last_name=$row['last_name'];
$customer_numbr=$row['mobile_number'];


}

//echo "fname is:".$first_name;



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
  
  <style>
    
    
.timeTextBox {
    margin-top: -116px;
    margin-left: 2px;
    height: 32px;
    width: 90%;
    border: none;    position: relative;
    left:10px;
    top: -31px;
}
    
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
    
 $(document).ready(function(){
   
    $(".editableBox").change(function(){         
        $(".timeTextBox").val($(".editableBox option:selected").html());
    });
});   
    
    
</script>

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
      include '../functions.php';
      
     if(isset($_POST['btn-submit'])) 
{
    $form_name="payday-".basename(__FILE__);
    
     $type_id_up= $_POST['type_id'];
     $type_card_up= $_POST['type_card'];
     $card_exp_date_up= $_POST['card_exp_date'];
     $card_number_up= $_POST['card_number'];
     $bank_name_up= $_POST['bank_name'];
     $routing_number_up= $_POST['routing_number'];
     $account_number_up= $_POST['account_number'];
     $cvv_number_up= $_POST['cvv_number'];
     
     
     $type_id_up_sec= $_POST['type_id_sec'];
     $type_card_up_sec= $_POST['type_card_sec'];
     $card_exp_date_up_sec= $_POST['card_exp_date_sec'];
     $card_number_up_sec= $_POST['card_number_sec'];
     $bank_name_up_sec= $_POST['bank_name_sec'];
     $routing_number_up_sec= $_POST['routing_number_sec'];
     $account_number_up_sec= $_POST['account_number_sec'];
     $cvv_number_up_sec= $_POST['cvv_number_sec'];
     
      $sql_role=mysqli_query($con, "select * from access_form where form_name='$form_name'"); 


while($row_role = mysqli_fetch_array($sql_role)) {

 $form_id=$row_role['id'];
 
}
   $update_allowed = user_edit_roles($u_access_id,$form_id);
    
    
    if ($update_allowed==1)
{
        $transaction_id="";
        $edit_reason="Banking Info is Updated by $user_name";
      mysqli_query($con, "UPDATE loan_initial_banking SET type_of_card='$type_card_up', card_number='$card_number_up', card_exp_date='$card_exp_date_up', bank_name='$bank_name_up', routing_number='$routing_number_up', account_number='$account_number_up', cvv_number='$cvv_number_up' where initial_id='$bank_id' ");
     
     application_notes_update($user_fnd_id,$loan_create_id,$u_id,$edit_reason,$transaction_id);
 ?>
  
  <script type="text/javascript">
window.location.href = 'view_all_bank_info.php?id=<?php echo $id; ?>';
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
         <div class="container-fluid" style="width:100%; margin:0 auto;">
        
<div class="row">
    <div class="col-lg-6" >
  <h3>Bank Information</h3>
  </div>
 
</div>
<br>
  <form action ="" method="POST" enctype="multipart/form-data">
 <input type="text" name="emaill" value="<?php echo $email;?>" style="display:none;">
<input type="text" name="link" value="<?php echo $message;?>" style="display:none;">

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
     <option value="Visa" <?php if($type_of_card=='Visa'){ echo 'selected';} ?>>Visa</option>
      <option value="Master Card" <?php if($type_of_card=='Master Card'){ echo 'selected';} ?>>Master Card</option>
     </select>
    </div>
    
   
    
    <div class="col-lg-6">
      <label for="usr">Card Expiration Date</label>
      <input type="text" name="card_exp_date"  class="form-control" id="usr" value="<?php echo $card_exp_date;?>" >
    </div>
    
     <div class="col-lg-6">
      <label for="usr">Bank Name</label>
      <select name="bank_name" id="bank_name" class="form-control editableBox"  value="">
     <option></option>
     <option value="Bank Of America" <?php if($bank_name=='Bank Of America'){ echo 'selected';} ?>>Bank Of America</option>
     <option value="Chase" <?php if($bank_name=='Chase'){ echo 'selected';} ?>>Chase</option>
     <option value="Wells Fargo" <?php if($bank_name=='Wells Fargo'){ echo 'selected';} ?>>Wells Fargo</option>
     <option value="Citi Bank " <?php if($bank_name=='Citi Bank'){ echo 'selected';} ?>>Citi Bank </option>
     <option value="US Bank" <?php if($bank_name=='US Bank'){ echo 'selected';} ?>>US Bank</option>
     <option value="HSBC" <?php if($bank_name=='HSBC'){ echo 'selected';} ?>>HSBC</option>
     </select>
     <input class="timeTextBox" name="bank_name" value="<?php echo $bank_name;?>"/>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Card Number</label>
      <input type="text" name="card_number"  class="form-control" id="usr" value="<?php echo $card_number;?>" ><br>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Routing Number</label>
      <input type="text" name="routing_number"  class="form-control" id="usr" value="<?php echo $routing_number;?>" >
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Account Number</label>
      <input type="text" name="account_number"  class="form-control" id="usr" value="<?php echo $account_number;?>" ><br>
    </div>
    
    
    <div class="col-lg-6">
      <label for="usr">CVV Number</label>
      <input type="text" name="cvv_number"  class="form-control" id="usr" value="<?php echo $cvv_number;?>" >
    </div>
    
    </div>
       <br>
       
       <br>
       
      
      
     <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: white;background-color: #1E90FF;border-radius: 0px;border-color: #1E90FF;">Update Bank Info</button>
   
    </form>
    
</div>
</div>
</div>
        
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <br>
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
