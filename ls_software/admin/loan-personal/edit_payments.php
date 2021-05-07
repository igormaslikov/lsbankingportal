<?php

error_reporting(0);

session_start();

include_once '../dbconnect.php';



if (!isset($_SESSION['userSession'])) {

	header("Location: ../index.php");

}



$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);

$userRow=$query->fetch_array();

$u_id=$userRow['user_id'];

$u_access_id = $userRow['access_id'];

if($u_access_id!='1'){

    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";

 

}

else {

$DBcon->close();



?>



<?php

include '../dbconnect.php';

include '../dbconfig.php';

$id_transaction=$_GET['t_id'];

$id=$_GET['id'];



$sql_trnsaction=mysqli_query($con, "select * from personal_loan_transaction where transaction_id='$id_transaction'"); 



while($row_trnsaction = mysqli_fetch_array($sql_trnsaction)) {



$transaction_id=$row_trnsaction['transaction_id'];

$loan_create_id=$row_trnsaction['loan_create_id'];

$installment_id=$row_trnsaction['installment_id'];

$payment_amount=$row_trnsaction['payment_amount'];

$interest=$row_trnsaction['interest'];

$principal_amount=$row_trnsaction['principal_amount'];

$remaining_balance=$row_trnsaction['remaining_balance'];

$installment_late_fees=$row_trnsaction['late_fee'];

$payment_date=$row_trnsaction['payment_date'];



$timestamp = strtotime($payment_date);

 

// Creating new date format from that timestamp

$payment_date= date("m-d-Y", $timestamp);



}





$sql_install=mysqli_query($con, "select * from tbl_personal_loan_installments where id='$installment_id'"); 



while($row_install = mysqli_fetch_array($sql_install)) {

    $payment_description=$row_install['payment_description'];

}







$sql=mysqli_query($con, "select * from tbl_personal_loans where loan_create_id= '$loan_create_id'"); 



while($row = mysqli_fetch_array($sql)) {

    

   

   $loan_id=$row['loan_id']; 

    

$user_fnd_id=$row['user_fnd_id'];



}



?>





<?php





include '../dbconnect.php';

include '../dbconfig.php';



$sql_fnd=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'"); 



while($row_fnd = mysqli_fetch_array($sql_fnd)) {

    

$first_name=$row_fnd['first_name'];

$last_name=$row_fnd['last_name'];

$full_name= $first_name.' '.$last_name;

$email=$row_fnd['email'];

$mobile_number=$row_fnd['mobile_number'];

$address=$row_fnd['address'];

$date_of_birth=$row_fnd['date_of_birth'];

$ssn=$row_fnd['ssn']; 

$id_photo=$row_fnd['customer_img'];





}







$sql=mysqli_query($con, "select * from tbl_personal_loans where loan_create_id= '$loan_create_id'"); 



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

$creation_date=$row['creation_date'];

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















?> 









<!DOCTYPE html>

<html lang="en">



<head>



<style>

.buttonHolder{ text-align: left; 

    margin-left: 15px;

}

table {

  font-family: arial, sans-serif;

  border-collapse: collapse;

  width: 100%;

}



td, th {

  border: 1px solid #dddddd;

  text-align: left;

  padding: 8px;

  

  

}



tr:nth-child(even) {

  background-color: #dddddd;

}

</style>



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

        <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>



        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

          <span class="navbar-toggler-icon"></span>

        </button>



       

      </nav>

   <br>

   <div class="row container-fluid" style="background-color: #F5E09E;color:black;padding:20px;">



<div class="col-lg-4"><p>Customer First Name:<b style="color:red"> <?php echo $first_name;?></b></p></div>

<div class="col-lg-4"><p>Customer Last Name: <b style="color:red"><?php echo $last_name;?> </b></p></div>

<div class="col-lg-4"><p>Customer Phone:<b style="color:red"> <?php echo $mobile_number;?> </b> </p></div>

<div class="col-lg-4"><p>Loan Date:<b style="color:red"> <?php echo $new_creation_date;?> </b></p></div>

<div class="col-lg-4"><p>Loan Amount: <b style="color:red"> $<?php echo $val.$amount_loan;?></b></p></div>

<div class="col-lg-4"><p>Lona ID:<b style="color:red"> <?php echo $loan_create_id;?> </b> </p></div>





</div>

 <br>

      <div class="container-fluid">

        

        <div class="row"> 

         <div class="col-lg-6">

<h3>Payments</h3>



</div>

         

          <div class="col-lg-6" align="right">

<a href="view_all_payments.php?id=<?php echo $loan_create_id?>"> <button name="btn-submit" type="submit" class="btn btn-danger" style="background-color: #1E90FF;color: white;border-color: #1E90FF;">View All Payments</button></a>





</div>

</div>

    <br>

 <form action ="" method="POST" enctype="multipart/form-data">

                  <input type="text" name="loan_cr_id" value="<?php echo $loan_create_id;?>" style="display:none">

                  <input type="text" name="install_id" value="<?php echo $installment_id;?>"  style="display:none">

                  <div class="row">

                     <div class="col-lg-6">

                        <label for="usr">Interest Amount ($):</label>

                     </div>

                     <div class="col-lg-6">

                        <input type="text" name="interest_amount" class="form-control" id="usr" placeholder="" value="<?php echo $interest;?>">

                     </div>

                     <div class="col-lg-6">

                        <label for="usr">Principal Amount ($):</label>

                     </div>

                     <div class="col-lg-6">

                        <input type="text" name="principal_amount" class="form-control" id="usr" placeholder="" value="<?php echo $principal_amount;?>">

                     </div>

                     <div class="col-lg-6">

                        <label for="usr">Balance ($):</label>

                     </div>

                     <div class="col-lg-6">

                        <input type="text" name="balance_amount" class="form-control" id="usr" placeholder="" value="<?php echo $remaining_balance;?>">

                     </div>

                    

                     <div class="col-lg-6">

                        <label for="usr">Late Fee ($):</label>

                     </div>

                     <div class="col-lg-6">

                        <input type="text" name="late_fee" class="form-control" id="usr" placeholder="" value="<?php echo $installment_late_fees;?>" >

                     </div>

                     <div class="col-lg-6">

                        <label for="usr">Payment Date:</label>

                     </div>

                     <div class="col-lg-6">

                        <input type="date" name="payment_date" class="form-control" id="usr" placeholder="" value="<?php echo $payment_date;?>">

                     </div>

                     <div class="col-lg-6">

                        <label for="usr">Payment Description:</label>

                     </div>

                     <div class="col-lg-6">

                        <textarea name="payment_description" class="form-control" id="usr" placeholder="Payment Description" value=""><?php echo $payment_description;?></textarea>

                     </div>

                     

                     <div class="col-lg-6">

                        <label for="usr">Edit Reason*:</label>

                     </div>

                     <div class="col-lg-6">

                        <textarea name="edit_reason" class="form-control" id="usr" placeholder="Edit Reason" value="" required></textarea>

                     </div>

                  </div>

                  <br>

                  <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: blue;border-color: blue;">Update Payment</button>

               </form>



        

        </div>

    </div>

    

   <?php

      

     if(isset($_POST['btn-submit'])) 

{

    

    include '../dbconnect.php';

    include '../dbconfig.php';

    include '../functions.php'; 

     $loan_create_id_up= $_POST['loan_cr_id'];

     $installment_id_up= $_POST['install_id'];

     

     $interest_amount_up= $_POST['interest_amount'];

     $principal_amount_up= $_POST['principal_amount'];

     $balance_amount= $_POST['balance_amount'];

     $late_fee= $_POST['late_fee'];

     $payment_date_up= $_POST['payment_date'];

     $payment_description_up= $_POST['payment_description'];

     

     

     $amount_upp=str_replace("$","","$amount_up");

     

      $form_name="personal-".basename(__FILE__);

     

      $sql_role=mysqli_query($con, "select * from access_form where form_name='$form_name'"); 





while($row_role = mysqli_fetch_array($sql_role)) {



 $form_id=$row_role['id'];

 

}

   $update_allowed = user_edit_roles($u_access_id,$form_id);

    

    

    if ($update_allowed==1)

{

     

     

     $edit_reason= "Payment Edit Reason: ". $_POST['edit_reason']." with Personal loan ID $loan_create_id_up And Payment ID $transaction_id";

    mysqli_query($con, "UPDATE personal_loan_transaction SET interest='$interest_amount_up', principal_amount='$principal_amount_up', remaining_balance='$balance_amount', late_fee='$late_fee', payment_date='$payment_date_up' where id='$transaction_id'");

     

    mysqli_query($con, "UPDATE tbl_personal_loan_installments SET payment_description='$payment_description_up' where id='$installment_id_up'");

      

   //******************************************************* Application Notes ****************************************

   

   $date= date('Y-m-d H:i:s'); 



   

$query_app  = "INSERT INTO application_status_updates (application_id,loan_create_id,user_id,status,creation_date,loan_transaction_id)  VALUES ('$user_fnd_id','$loan_create_id','$u_id','$edit_reason','$date','$transaction_id')";

        $result_app = mysqli_query($con, $query_app);

        if ($result_app) {

            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";

        } else {

        echo "<h3> Error Inserting Data </h3>";

        } 

   

   

   

   

   //******************************************************* Application Notes END ****************************************

   

   

   

      



      ?>  

    

 <script type="text/javascript">

window.location.href = 'view_all_payments.php?id=<?php echo $id; ?>';

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

