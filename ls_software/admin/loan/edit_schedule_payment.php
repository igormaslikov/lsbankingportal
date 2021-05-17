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
 
$sql_fnd=mysqli_query($con, "select * from tbl_loan where loan_id = '$id'"); 

while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];

$loan_create_id=$row_fnd['loan_create_id'];
//echo "FND_ID" .$user_fnd_id;
}


}


?>


<?php



$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];
$last_name=$row['last_name'];
$customer_numbr=$row['mobile_number'];
$customer_full_name= $first_name.' '.$last_name;


}




?>
<?php



$sql=mysqli_query($con, "select * from tbl_loan where loan_id= '$id'"); 

while($row = mysqli_fetch_array($sql)) {

$loan_id=$row['loan_id'];
	$loan_create_id=$row['loan_create_id'];

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


 <?php



$sql_transaction=mysqli_query($con, "select * from loan_transaction where loan_id= '$id'"); 

while($row_transaction = mysqli_fetch_array($sql_transaction)) {

$payment_method=$row_transaction['payment_method'];

$payoff_amount=$row_transaction['payoff_amount'];
$payment_date=$row_transaction['payment_date'];
$info=$row_transaction['info'];
$quick_pay=$row_transaction['quick_pay'];
$type_of_payment=$row_transaction['type_of_payment'];


}

$scheduling_id = $_GET['schedule_id'];
$sql_scheduling=mysqli_query($con, "select * from tbl_loan_schedules where id= '$scheduling_id'"); 
//echo "select * from loan_transaction where id= '$scheduling_id'";
while($row_scheduling = mysqli_fetch_array($sql_scheduling)) {

$schedule_card=$row_scheduling['card'];

$scheduled_schedule_time=$row_scheduling['schedule_time'];
$schedule_amount=$row_scheduling['amount'];
$schedule_payment_date=$row_scheduling['payment_date'];


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
<div class="col-lg-3"><p>Loan Amount: <b style="color:red"> $<?php echo $val.$amount_loan;?></b></p></div>
<div class="col-lg-3"><p>Loan ID:<b style="color:red"> <?php echo $loan_create_id;?> </b> </p></div>
<div class="col-lg-3"><p>User ID:<b style="color:red"> <?php echo $user_fnd_id;?> </b> </p></div>


</div>
      <br>
      
      

      
      
      
      
      <br>
         <div class="container-fluid" style="width:100%; margin:0 auto;">
        <h3>Schedule Payment: </h3>
        <br>

   <form action ="" method="POST" enctype="multipart/form-data">
  <input type="text" name="name_id" value="<?php echo $name_id;?>"  style="display:none;">
  
  <div class="row">
      
      <input type="text" name = "loan_create_id" value="<?php echo $loan_create_id;?>" style="display:none">
      
    
     <div class="col-lg-6">
    <label for='usr'>Card Number</label>
    <select  class="form-control city" name="card">
    <option value='<?php echo $schedule_card;?>'><?php echo $schedule_card;?></option>
  <?php 
      $sql_loan=mysqli_query($con, "select DISTINCT `card_number`,`card_exp_date` from loan_initial_banking where user_fnd_id = '$user_fnd_id' ORDER BY primary_status ASC"); 

while($row_bank_detail_sec = mysqli_fetch_array($sql_loan)) {
     $card=$row_bank_detail_sec['card_number'];
     $card_cvv=$row_bank_detail_sec['cvv'];
    
     $card_exp_date=$row_bank_detail_sec['card_exp_date'];
    
echo "<option value='".$card."'>".$card." - ".$card_exp_date."</option>" ;
}
?>
    
      

     </select>
     </div>
     
     <div class='col-lg-12' id="show-city">
         
    </div>

    <div class="col-lg-4">
      <label for="usr">Schedule Payment Date</label>
      <input type="date" name="schedule_payment" class="form-control" id="usr" placeholder="<?php echo $schedule_payment_date;?>" value="<?php echo $schedule_payment_date;?>">
    </div>
    
    <div class="col-lg-4">
      <label for="usr">Schedule Time</label>
      <select name="schedule_frequency" id="schedule_frequency" class="form-control"  value="">
<option value="<?php echo $scheduled_schedule_time;?>" selected><?php echo $scheduled_schedule_time;?></option>
<option value="01:00">1:00am</option>
<option value="02:00">2:00am</option>
<option value="03:00">3:00am</option>
<option value="04:00">4:00am</option>
<option value="05:00">5:00am</option>
<option value="06:00">6:00am</option>
<option value="07:00">7:00am</option>
<option value="08:00">8:00am</option>
<option value="09:00">9:00am</option>
<option value="10:00">10:00am</option>
<option value="11:00">11:00am</option>
<option value="12:00">12:00pm</option>
<option value="13:00">01:00pm</option>
<option value="14:00">02:00pm</option>
<option value="15:00">03:00pm</option>
<option value="16:00">04:00pm</option>
<option value="17:00">05:00pm</option>
<option value="18:00">06:00pm</option>
<option value="19:00">07:00pm</option>
<option value="20:00">08:00pm</option>
<option value="21:00">09:00pm</option>
<option value="22:00">10:00pm</option>
<option value="23:00">11:00pm</option>
<option value="00:00">12:00am</option>


</select>
    </div>
    
     <div class="col-lg-4">
      <label for="usr">Payment Amount</label>
      <input type="text" name="payment_amount"  class="form-control" id="usr" value="<?php echo $schedule_amount;?>">
    </div>
    
  
    
   
    
    </div>
    
    <br>
    
      <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: blue;border-color: blue;">Update Schedule Payment</button>
  </form>
  
</div>
</div>
</div>
        
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  
  
  <?php 

   error_reporting(0);
  

if(isset($_POST['btn-submit'])) 
{

$schedule_frequency = $_POST['schedule_frequency'];
$payment_amount = $_POST['payment_amount'];
$schedule_payment = $_POST['schedule_payment'];
$card = $_POST['card'];
$loan_create_id = $_POST['loan_create_id'];
mysqli_query($con,"UPDATE `tbl_loan_schedules` SET `payment_date`='$schedule_payment',`schedule_time`='$schedule_frequency',`amount`='$payment_amount',`card`='$card' WHERE `id`='$scheduling_id'");


?>

<script type="text/javascript">
window.location.href = 'schedule_payment.php?id=<?php echo $id ;?>';
</script>


  
  <!-- /#wrapper -->
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
