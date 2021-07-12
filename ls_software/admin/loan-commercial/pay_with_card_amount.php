<?php
error_reporting(0);
session_start();
include_once '../dbconnect.php';
include_once '../dbconfig.php';
include_once '../functions.php';
if (!isset($_SESSION['userSession'])) {
	header("Location: ../index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$u_id=$userRow['user_id'];
$auth_code=$userRow['auth_code'];
$u_access_id = $userRow['access_id'];
if($u_access_id=='2' || $u_access_id=='4' || $u_access_id=='5'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}
else {
$DBcon->close();






 $id=$_GET['id'];
 $to_be_paid_amount = $_GET['to_be_paid_amount'];
$late_fee = $_GET['late_fee'];
$sql_fnd=mysqli_query($con, "select * from tbl_commercial_loan where loan_id = '$id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];

$loan_create_id=$row_fnd['loan_create_id'];
//echo "FND_ID" .$user_fnd_id;
}


}





$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];
$last_name=$row['last_name'];
$customer_numbr=$row['mobile_number'];
$address=$row['address'];
$zipcode=$row['zip_code'];

}

//echo "fname is:".$first_name;


$sql=mysqli_query($con, "select * from tbl_commercial_loan where loan_id= '$id'"); 

while($row = mysqli_fetch_array($sql)) {

$loan_id=$row['loan_id'];
	$loan_create_id=$row['loan_create_id'];

//echo "fndid is:".$fnd_id;
$amount_loan=$row['amount_of_loan'];



//echo "Amount is:".$amount_loan;

$loan_total_payable =$row['loan_total_payable'];
$bg_id=$row['bg_id'];
$next_payment =$row['payment_date'];
$payment_tenure =$row['payment_tenure'];
$escrow=$row['escrow'];
$primary_port=$row['primary_portfolio'];
$creation_date=$row['contract_date'];
$created_by=$row['created_by'];
$last_update=$row['last_update_by'];
$last_update_date=$row['last_update_date'];
$loan_status=$row['loan_status'];
 $timestamp = strtotime($creation_date);
 
// Creating new date format from that timestamp
$new_creation_date= date("m-d-Y", $timestamp);
}




$sql_user=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row_user = mysqli_fetch_array($sql_user)) {

$username=$row_user['username'];

}

//echo "fname is:".$username;


$sql_transaction=mysqli_query($con, "select * from commercial_loan_transaction where loan_id= '$id'"); 

while($row_transaction = mysqli_fetch_array($sql_transaction)) {

$payment_method=$row_transaction['payment_method'];

$payoff_amount=$row_transaction['payoff_amount'];
$payment_date=$row_transaction['payment_date'];
$info=$row_transaction['info'];
$quick_pay=$row_transaction['quick_pay'];
$type_of_payment=$row_transaction['type_of_payment'];


}

$query_payment = mysqli_query($con,"SELECT SUM(payoff_amount) AS value_sum FROM loan_transaction where loan_id= '$id'");
while ($row_payment=mysqli_fetch_array($query_payment)){
    $payment = $row_payment['value_sum'];
    
    $payment = number_format((float)$payment, 2, '.', '');
break;
   // echo"<br>User_Key:" .$payment;

}
    $balns_due =$loan_total_payable-$payment;
    $balns_due= number_format("$balns_due",2);
    $balns_due = $to_be_paid_amount + $late_fee;


//echo "fname is:".$username;

 

   
  if(isset($_POST['btn-paynow'])) 
{

$amount_to_pay= $_POST['amount']; 
$card_number=$_POST['city']; 
$cvv_number=$_POST['cvv']; 
$exp_date=$_POST['exp']; 
$address=$_POST['address']; 
$zip_code=$_POST['zip'];  
 ?>

      <script type='text/javascript'>
window.location.href = 'pay_with_card_api.php?id=<?php echo $id;?>&amount_to_pay=<?php echo $amount_to_pay;?>&card_number=<?php echo $card_number;?>&address=<?php echo $address;?>&zip_code=<?php echo $zip_code;?>&cvv_number=<?php echo $cvv_number;?>&exp_date=<?php echo $exp_date;?>';
</script>
  <?php
}
?> 
      
      
      
      
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <!-- Bootstrap core CSS -->
 
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/simple-sidebar.css" rel="stylesheet">

<style>
table,th, td {
  border: 1px solid black;
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
<div class="col-lg-3"><p>Loan Amount: <b style="color:red"> $<?php echo $val.$amount_loan;?></b></p></div>
<div class="col-lg-3"><p>Loan ID:<b style="color:red"> <?php echo $loan_create_id;?> </b> </p></div>
<div class="col-lg-3"><p>User ID:<b style="color:red"> <?php echo $user_fnd_id;?> </b> </p></div>

</div>
      <br><br>
         <div class="container-fluid" style="width:100%; margin:0 auto;">

   <form action ="" method="POST" enctype="multipart/form-data">
  <input type="text" name="auth_codee" value="<?php echo $auth_code;?>"  style="display:none;">
  
  <div class="row">
      
    
          <div class='col-lg-6'>
      <label for='usr'>Payment Amount</label>
      <input type='text' name='amount' class='form-control' id='usr' placeholder='Amount Here' value='<?php echo $balns_due;?>' required>
    </div>
    
    <div class="col-lg-6">
    <label for='usr'>Card Number</label>
    <select  class="form-control city" name="city">
    <option value=''>Select Card</option>
  <?php 
      $sql_loan=mysqli_query($con, "select DISTINCT `card_number`,`card_exp_date` from commercial_loan_initial_banking where user_fnd_id = '$user_fnd_id' ORDER BY initial_id DESC"); 

while($row_bank_detail_sec = mysqli_fetch_array($sql_loan)) {
     $card=$row_bank_detail_sec['card_number'];
     $card_exp=$row_bank_detail_sec['card_exp_date'];
    
echo "<option value='".$card."'>".$card. " - ".$card_exp."</option>" ;
}
?>
    
      

     </select>
     </div>
     
     <div class='col-lg-12' id="show-city">
         
    </div>
     
     <div class='col-lg-6'>
      <label for='usr'>Address</label>
      <input type='text' name='address' class='form-control' id='usr' placeholder='Address Here' value='<?php echo $address;?>' >
    </div>
    
    <div class='col-lg-6'>
      <label for='usr'>Zip Code</label>
      <input type='text' name='zip' class='form-control' id='usr' placeholder='Zip Code' value='<?php echo $zipcode;?>' >
    </div>
    
    
    </div>
    
    <br>
    <button name='btn-paynow' type='submit' class='btn btn-danger' style='color: #fff;background-color: blue;border-color: blue;'>Paynow</button>

  </form>
  
</div>
</div>
</div>
        
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  
 
  


   <!---jQuery ajax load rcords using select box --->
<script type="text/javascript">
  $(document).ready(function(){
      $(".city").on("change", function(){
        var cityname = $(this).val();
        if (cityname !== "") {
          $.ajax({
            url : "load_data.php",
            type:"POST",
            cache:false,
            data:{cityname:cityname},
            success:function(data){
              $("#show-city").html(data);
            }
          });
        }else{
          $("#show-city").html(" ");
        }
      })
  });
</script>


  
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
 
</body>

</html>
