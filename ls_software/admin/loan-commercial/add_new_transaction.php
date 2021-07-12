<?php

error_reporting(0);

session_start();

include_once '../dbconnect.php';

include_once '../dbconfig.php';

include_once '../functions.php';

if (!isset($_SESSION['userSession'])) {

   header("Location: ../index.php");
}



$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=" . $_SESSION['userSession']);

$userRow = $query->fetch_array();

$u_id = $userRow['user_id'];

$u_access_id = $userRow['access_id'];

if ($u_access_id != '1') {

   echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
} else {

   $DBcon->close();



?>

   <?php

   $id = $_GET['id'];

   $intallment_id = $_GET['intallment_id'];



   $sql = mysqli_query($con, "select * from tbl_commercial_loan where loan_id= '$id'");



   while ($row = mysqli_fetch_array($sql)) {



      $loan_id = $row['loan_id'];

      $user_fnd_id = $row['user_fnd_id'];

      $daily_interest = $row['daily_interest'];

      $amount_loan = $row['principal_amount'];

      $bg_id = $row['bg_id'];

      $next_payment = $row['payment_date'];

      $creation_date = $row['contract_date'];

      $created_by = $row['created_by'];

      $last_update = $row['last_update_by'];

      $last_update_date = $row['last_update_date'];

      $loan_status = $row['loan_status'];

      $last_payment_date = $row['last_payment_date'];
      $late_fee = $row['late_fee'];
      $loan_create_id = $row['loan_create_id'];

      $timestamp = strtotime($creation_date);



      // Creating new date format from that timestamp

      $new_creation_date = date("m-d-Y", $timestamp);
   }









   $sql = mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'");



   while ($row = mysqli_fetch_array($sql)) {



      $first_name = $row['first_name'];

      $last_name = $row['last_name'];

      $customer_numbr = $row['mobile_number'];
   }



   //echo "fname is:".$first_name;











   $sql_user = mysqli_query($con, "select * from tbl_users where user_id= '$created_by'");



   while ($row_user = mysqli_fetch_array($sql_user)) {



      $username = $row_user['username'];
   }



   //echo "fname is:".$username;







   if($intallment_id == null){
      $sql_transaction = mysqli_query($con, "select id from tbl_commercial_loan_installments where loan_create_id='$loan_create_id' and status='0' limit 1");
      while ($row_transaction = mysqli_fetch_array($sql_transaction)){
         $intallment_id = $row_transaction['id'];
      }
   }

   $sql_transaction = mysqli_query($con, "select * from tbl_commercial_loan_installments where id='$intallment_id'");



   while ($row_transaction = mysqli_fetch_array($sql_transaction)) {



      $loan_create_id = $row_transaction['loan_create_id'];

      $payment_amount = $row_transaction['payment'];

      $interest_amount = $row_transaction['interest'];

      $interest_amount = number_format($interest_amount,   2, ".", ",");

      $principal_amount = $row_transaction['principal'];

      $principal_amount = number_format($principal_amount,   2, ".", ",");

      $rem_balance = $row_transaction['balance'];

      $payment_date = $row_transaction['payment_date'];

      $status = $row_transaction['status'];

      $fee_status = $row_transaction['fee_status'];
      $paid_amount = $row_transaction['paid amount'];
   }

   $payment_date_array = explode("-", $payment_date);
   $payment_date = $payment_date_array[2] . "-" . $payment_date_array[0] . "-" . $payment_date_array[1];


   $amount_tobe_paid = $payment_amount - $paid_amount;

   $date = date('Y-m-d');

   $date_now = date_create(date("Y-m-d", strtotime("now")));
   $date_due_date = date_create(date("Y-m-d", strtotime($payment_date)));
   $interval = date_diff( $date_due_date,$date_now);

   $dpd = $interval->format('%r%a');
   $sum_late_fee = $dpd>0 ? $dpd * $late_fee : 0;




   ?>

   <?php

   error_reporting(0);




   if (isset($_POST['btn-submit'])) {







      $interest_amount_f = $_POST['interest_amount'];

      $principal_amount_f = $_POST['principal_amount'];

      $payment_amount_up = $_POST['payment_amount'];

      $payment_amount_up = str_replace("$", "", "$payment_amount_up");

      $pre_interest_amount = $_POST['pre_interest_amount'];

      $pre_installment_amount = $_POST['pre_installment_amount'];

      $to_be_paid_amount = $_POST['to_be_paid_amount'];

      $late_fee = $_POST['late_fee'];

      $paid_date = $_POST['payment_date'];
      $due_date = $_POST['due_date'];

      $payment_description = $_POST['payment_description'];
      $payment_method = $_POST['payment_method'];
      $type_of_payment = $_POST['type_of_payment'];
      $convenience_fee = $_POST['convenience_fee'];

      //    echo "Interest : ".$_POST['interest_amount'];

      $db_totalamountpaid = $to_be_paid_amount;

      $db_interestpaid = 0;

      $db_principlepaid = 0;

      $db_latefeepaid = $late_fee;

      $db_remaininginterest = 0;

      $db_remainingprinciple = 0;





      if ($late_fee > 0) {

         $to_be_paid_amount = $to_be_paid_amount - $late_fee;
      }







      $date = date('Y-m-d');







      if ($to_be_paid_amount >= $interest_amount_f) {

         $db_interestpaid = $interest_amount_f;



         $db_interestpaid1 = $interest_amount_f + $pre_interest_amount;



         $db_remaininginterest = $db_interestpaid - $db_interestpaid1;



         $db_principlepaid = $to_be_paid_amount - $db_interestpaid1;

         //$principal_amount_f = 63.86;

         // $db_principlepaid = 63.86;

         $db_remainingprinciple = (float) $principal_amount_f - (float) $db_principlepaid;
      } else {

         $db_interestpaid = $to_be_paid_amount;

         $db_remaininginterest = $interest_amount_f - $to_be_paid_amount;
      }



      // echo  "AMOUNT PAID :  $db_totalamountpaid <br>

      //        Interest PAID : $db_interestpaid - $db_interestpaid1 <br>

      //        Prinicple PAID : $db_principlepaid ($to_be_paid_amount | $db_interestpaid1)<br>

      //        Late Fee PAID : $db_latefeepaid <br>

      //       Remaining Interest  :  $db_remaininginterest <br>

      //       Remaining Principle :  ($db_remainingprinciple)  - $principal_amount_f | $db_principlepaid<br>";



      $loan_transaction_id = '';

      $status = "Installment is made with Installment ID  $intallment_id";

      $to_be_paid_amount += $paid_amount;
      $sum_interest_amount = 0;
      $sum_principle_amount = 0;
      $query_payment = mysqli_query($con, "Select payment, `id`, `paid amount`, balance, interest, principal from `tbl_commercial_loan_installments` where loan_create_id = '$loan_create_id' and status = 0");
      while ($row_payment = mysqli_fetch_array($query_payment)) {

         if ($to_be_paid_amount == 0) {
            if($type_of_payment == "Payoff"){
               mysqli_query($con, "UPDATE tbl_commercial_loan_installments SET paid_date='$paid_date', status='2', paid_by='$u_id', payment_description='$payment_description' where loan_create_id = '$loan_create_id' and status = 0 ");
               mysqli_query($con, "UPDATE tbl_commercial_loan SET loan_status='Paid' where loan_create_id = '$loan_create_id'");

            }
            break;
         }

         $dpd = 0;
         $intallment_id = $row_payment['id'];
         $payment = $row_payment['payment'];
         $paid_amount = $row_payment['paid amount'];
         $rem_balance = str_replace(",", "", $row_payment['balance']);
         $db_interestpaid = $row_payment['interest'];
         $db_principlepaid = $row_payment['principal'];
         $percent = 1;
         if ($to_be_paid_amount >= $payment) {
            $to_paid = $payment;
            $to_be_paid_amount -= $payment;
            $status = '1';

            //$payment_date_array = explode("-", $due_date);
            //$payment_date = $payment_date_array[2] . "-" . $payment_date_array[0] . "-" . $payment_date_array[1];
            $date_now = date_create(date("Y-m-d", strtotime($paid_date)));
            $date_due_date = date_create($due_date);
            $interval = date_diff( $date_due_date,$date_now);
         
            $dpd = $interval->format('%r%a');

         } else {
            $to_paid = $to_be_paid_amount;
            $status = '0';
            $to_be_paid_amount = 0;
            $percent = $to_paid / $payment;
            $rem_balance += $db_principlepaid;
            $db_interestpaid = $db_interestpaid * $percent;
            $db_principlepaid = $db_principlepaid * $percent;
            $rem_balance =  $rem_balance - number_format($db_principlepaid, 2);
         }

         $db_totalamountpaid = $to_paid;

         $still_pay = $payment - $paid_amount;
         if ($still_pay < $payment) {
            $db_totalamountpaid = $still_pay;
            $percent = $still_pay / $payment;
            $db_interestpaid = $db_interestpaid * $percent;
            $db_principlepaid = $db_principlepaid * $percent;
         }

         $sum_interest_amount += $db_interestpaid;
         $sum_principle_amount += $db_principlepaid;

         mysqli_query($con, "UPDATE tbl_commercial_loan_installments SET paid_date='$paid_date', `paid amount`='$to_paid',`dpd` = $dpd, status=$status, paid_by='$u_id', payment_description='$payment_description'  where id ='$intallment_id'");
      }

      if ($_POST['to_be_paid_amount'] > $payment) {
         $db_totalamountpaid  = $_POST['to_be_paid_amount'];
         $db_interestpaid = $sum_interest_amount;
         $db_principlepaid = $sum_principle_amount;
      }

      $query_insert_trans = "INSERT INTO `commercial_loan_transaction`(`loan_id`, `loan_create_id`, `user_fnd_id`, `installment_id`, `payment_amount`, `interest`, `principal_amount`, `remaining_balance`, `remaining_interest`, `remaining_installment_principal`, `late_fee`, `convenience_fee` , `payment_date`, `payment_description`,`payment_method`, `created_at`, `created_by`) VALUES ('$id','$loan_create_id','$user_fnd_id','$intallment_id','$db_totalamountpaid','$db_interestpaid','$db_principlepaid','$rem_balance','$db_remaininginterest','$db_remainingprinciple','$db_latefeepaid','$convenience_fee','$due_date','$payment_description','$payment_method','$paid_date','$u_id')";

      $result_insert_trans = mysqli_query($con, $query_insert_trans);

      if ($result_insert_trans) {

         // echo "<div class='form'><h3> successfully added in application_status_updates.</h3><br/></div>";



      } else {

         echo "<h3> Error Inserting Data </h3>";
      }




      application_notes_update($user_fnd_id, $loan_create_id, $u_id, $status, $loan_transaction_id);



      //************************************  Email To LsBanking *************************// 







   ?>

      <script type="text/javascript">
         window.location.href = 'view_all_installments.php?id=<?php echo $id; ?>';
      </script>



   <?php

   }

   ?>

   <?php
   if (isset($_POST['btn-submit-repay'])) {
      $to_be_paid_amount = $_POST['to_be_paid_amount'];
      $late_fee = $_POST['late_fee'];

   ?>

      <script type="text/javascript">
         window.location.href = 'add_auth_code.php?id=<?php echo $id; ?>&to_be_paid_amount=<?php echo $to_be_paid_amount; ?>&late_fee=<?php echo $late_fee; ?>';
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

      <!-- Bootstrap core CSS -->

      <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

      <!-- Custom styles for this template -->

      <link href="css/simple-sidebar.css" rel="stylesheet">

      <style>
         table,
         th,
         td {

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

               <div class="col-lg-4">

                  <p>Customer First Name:<b style="color:red"> <?php echo $first_name; ?></b></p>

               </div>

               <div class="col-lg-4">

                  <p>Customer Last Name: <b style="color:red"><?php echo $last_name; ?> </b></p>

               </div>

               <div class="col-lg-4">

                  <p>Customer Phone:<b style="color:red"> <?php echo $customer_numbr; ?> </b> </p>

               </div>

               <div class="col-lg-4">

                  <p>Loan Date:<b style="color:red"> <?php echo $new_creation_date; ?> </b></p>

               </div>

               <div class="col-lg-4">

                  <p>Loan Amount: <b style="color:red"> $<?php echo $val . $amount_loan; ?></b></p>

               </div>

               <div class="col-lg-4">

                  <p>Loan ID:<b style="color:red"> <?php echo $loan_create_id; ?> </b> </p>

               </div>

            </div>

            <br><br>

            <div class="container-fluid" style="width:100%; margin:0 auto;">

               <h3>Make a Payment: </h3>

               <form action="" method="POST" enctype="multipart/form-data">

                  <input type="text" name="name_id" value="<?php echo $name_id; ?>" style="display:none;">
                  <input type="text" name="due_date" value="<?php echo strftime('%Y-%m-%d', strtotime($payment_date)); ?>" style="display:none;">

                  <div class="row">
                     <div class="col-lg-3">
                        <label for="usr">Payment Amount ($):</label>
                        <input type="text" name="payment_amount" class="form-control" id="usr" placeholder="" value="<?php echo $payment_amount; ?>" style="display:none;"><?php echo $payment_amount; ?>

                     </div>
                     <div class="col-lg-3">
                        <label for="usr">Interest Amount ($):</label>
                        <input type="text" name="interest_amount" class="form-control" id="usr" placeholder="" value="<?php echo $interest_amount; ?>" style="display:none;"><?php echo $interest_amount; ?>

                     </div>

                     <div class="col-lg-3">
                        <label for="usr">Principal Amount ($):</label>
                        <input type="text" name="principal_amount" class="form-control" id="usr" placeholder="" value="<?php echo $principal_amount; ?>" style="display:none;"><?php echo $principal_amount; ?>

                     </div>

                     <div class="col-lg-3">
                        <label for="usr">DPD:</label>
                        <input type="text" name="dpd" class="form-control" id="usr" placeholder="" value="<?php echo $dpd; ?>" style="display:none;"><?php echo $dpd; ?>

                     </div>



                     <div class="col-lg-6">
                        <label for="usr">Amount to be Paid ($):</label>
                        <input type="text" name="to_be_paid_amount" class="form-control" id="usr" placeholder="" value="<?php echo $amount_tobe_paid; ?>">

                     </div>

                     <div class="col-lg-3">
                        <label for="usr">Late Fee ($):</label>
                        <input type="text" name="late_fee" class="form-control" id="usr" placeholder="" value="<?php echo $sum_late_fee; ?>" title="<?php echo '(late fee) * (DPD) => ' . $late_fee . ' * ' . $dpd; ?>">

                     </div>

                     <div class="col-lg-3">
                        <label for="usr">Convenience Fee ($):</label>
                        <input type="text" name="convenience_fee" class="form-control" id="usr" placeholder="" value="0">

                     </div>

                     <div class="col-lg-6">

                        <label for="usr">Payment Date:</label>

                        <input type="date" name="payment_date" class="form-control" id="usr" placeholder="<?php echo date('m/d/Y', strtotime("now")); ?>" value="<?php echo strftime('%Y-%m-%d', strtotime("now")) ?>">

                     </div>

                     <div class="col-lg-6">
                        <label for="usr">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="form-control" value="">
                           <option value=""></option>
                           <option value="Cash">Cash</option>
                           <option value="Debit Card">Debit Card</option>
                           <option value="Bank Deposit">Bank Deposit</option>
                           <option value="Money Order">Money Order</option>
                           <option value="ACH">ACH</option>
                           <option value="Zelle">Zelle</option>
                           <option value="Repay">Repay</option>
                           <option value="Chargeback">Chargeback</option>
                        </select>
                     </div>
                     <div class="col-lg-6">
                        <label for="usr">Type Of Payment</label>
                        <select name="type_of_payment" id="type_of_payment" class="form-control" value="">
                           <option value=""></option>
                           <option value="Paydown">Paydown</option>
                           <option value="Payoff">Payoff</option>
                           <option value="Chargeoff">Chargeoff</option>
                           <option value="Settlement">Settlement</option>
                        </select>
                     </div>
                     <div class="col-lg-6">
                        <label for="usr">Payment Description:</label>
                        <textarea name="payment_description" class="form-control" id="usr" placeholder="Payment Description" value=""></textarea>

                     </div>

                  </div>

                  <br>

                  <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: blue;border-color: blue;">Add transaction</button>
                  <button name="btn-submit-repay" class="btn btn-danger" style="background-image: linear-gradient(to bottom,red 0,red 100%);color: #fff;background-color:red;border-color: red;">Pay Via Repay</button>


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