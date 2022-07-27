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
 $user_fnd_id=$_GET['fnd_id'];
 $bank_id=$_GET['bank_id'];
$sql_fnd=mysqli_query($con, "select * from tbl_loan where loan_id = '$id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];
$loan_create_id=$row_fnd['loan_create_id'];
//echo "FND_ID" .$user_fnd_id;
}


$sql_bank_detail=mysqli_query($con, "select * from loan_initial_banking where user_fnd_id = '$user_fnd_id' AND initial_id='$bank_id'"); 

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
  
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
    
 $(document).ready(function(){
   
    $(".editableBox").change(function(){         
        $(".timeTextBox").val($(".editableBox option:selected").html());
    });
});   
    
    
</script>


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
    
    
    $type_card= $_POST['type_card'];
    $expiry_year_card = $_POST['expiry_year_card'];
    $expiry_month_card = $_POST['expiry_month_card'];
    $card_exp_date = $expiry_month_card. "/".$expiry_year_card;
     $card_number= $_POST['card_number'];
    
     $bank_name= $_POST['bank_name'];
     $routing_number= $_POST['routing_number'];
     $account_number= $_POST['account_number'];
     $cvv_number= $_POST['cvv_number'];
       $date = date('Y-m-d H:i:s'); 
     $query_in  = "INSERT INTO `tbl_bank_cards` (`bank_id`, `loan_id`, `loan_create_id`, `user_fnd_id`, `type_of_card`, `card_number`, `card_exp_date`, `routing_number`, `account_number`, `cvv_number`, `created_by`)  VALUES ('$bank_id','$id','$loan_create_id','$user_fnd_id','$type_card','$card_number','$card_exp_date','$routing_number','$account_number','$cvv_number','$u_id')";
        $result_in = mysqli_query($con, $query_in);
        if ($result_in) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
    
     $sql_access=mysqli_query($con, "select * from tbl_users where user_id= '$u_id'"); 

while($row_access = mysqli_fetch_array($sql_access)) {

$username=$row_access['username'];

	//	echo "<br><br><br><br><br><br>". $access_level_name;

}

      $bank_account_statuss= "Secondary Bank Card is Created by $username";
      $transaction_id="";
     
     application_notes_update($user_fnd_id,$loan_create_id,$u_id,$bank_account_statuss,$transaction_id);
    
 ?>
  
  <script type="text/javascript">
window.location.href = 'view_all_bank_info.php?id=<?php echo $id; ?>';
</script> 
  
<?php
}
?>
         <div class="container-fluid" style="width:100%; margin:0 auto;">
        

  <form action ="" method="POST" enctype="multipart/form-data">
 <input type="text" name="emaill" value="<?php echo $email;?>" style="display:none;">
<input type="text" name="link" value="<?php echo $message;?>" style="display:none;">
<div class="row">
    <div class="col-lg-6" >
  <h3> Add Secondary Bank Card</h3>
  </div>
</div>
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
      <label for="usr">Type of Card*</label>
      <select name="type_card" id="type_card" class="form-control"  value="" required>
     <option></option>
     <option value="Visa">Visa</option>
      <option value="Master Card">Master Card</option>
     </select>
    </div>
    
   
    
    <div class="col-lg-6">
      <label for="usr">Card Expiration Date*</label>
      <div class="row">
      <div class="col-lg-6">
      <select style="width:60%" name="expiry_month_card" id="expiry_month_card" class="form-control"  value="" required>
     <option>Select Month</option>
     <option value="01">01</option>
     <option value="02">02</option>
     <option value="03">03</option>
     <option value="04">04</option>
     <option value="05">05</option>
     <option value="06">06</option>
     <option value="07">07</option>
     <option value="08">08</option>
     <option value="09">09</option>
     <option value="10">10</option>
     <option value="11">11</option>
     <option value="12">12</option>
     </select>
     </div>
     <div class="col-lg-6">
      <select  style="width:50%" name="expiry_year_card" id="expiry_year_card" class="form-control"  value="" required>
     <option>Select Year</option>
     <option value="20">20</option>
     <option value="21">21</option>
     <option value="22">22</option>
     <option value="23">23</option>
     <option value="24">24</option>
     <option value="25">25</option>
     <option value="26">26</option>
     <option value="27">27</option>
     <option value="28">28</option>
     <option value="29">29</option>
     <option value="30">30</option>
     </select>
      </div>
     
    </div>
    </div>
    <div class="col-lg-6">
      <label for="usr">Card Number*</label>
      <input type="text" name="card_number"  class="form-control" id="usr" value="" required><br>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Routing Number*</label>
      <input type="text" name="routing_number"  class="form-control" id="usr" value="<?php echo $routing_number;?>" required>
    </div>
    
    <div class="col-lg-6">
      <label for="usr">Account Number*</label>
      <input type="text" name="account_number"  class="form-control" id="usr" value="<?php echo $account_number;?>" required>
    </div>
    
    
    <div class="col-lg-6">
      <label for="usr">CVV Number*</label>
      <input type="text" name="cvv_number"  class="form-control" id="usr" value="" required>
    </div>
    
    </div>
       <br> 
       
      
      <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: white;background-color: #1E90FF;border-radius: 0px;border-color: #1E90FF;">Add Secondary Card Info</button>
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
