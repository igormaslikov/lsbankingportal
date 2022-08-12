<?php
error_reporting(0);
session_start();
include_once '../dbconnect.php';
include_once '../dbconfig.php';
if (!isset($_SESSION['userSession'])) {
  header("Location: ../index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=" . $_SESSION['userSession']);
$userRow = $query->fetch_array();
$u_id = $userRow['user_id'];
$u_access_id = $userRow['access_id'];
if ($u_access_id == '2' || $u_access_id == '4' || $u_access_id == '5') {
  echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
} else {
  $DBcon->close();

?>

  <?php


  $id = $_GET['id'];
  $sql_fnd = mysqli_query($con, "select * from tbl_loan where loan_id = '$id'");

  while ($row_fnd = mysqli_fetch_array($sql_fnd)) {

    $user_fnd_id = $row_fnd['user_fnd_id'];
    $loan_create_id = $row_fnd['loan_create_id'];
    $payoff = $row_fnd['loan_total_payable'];
    $loan_status = $row_fnd['loan_status'];
  }



  $query_payment = mysqli_query($con, "SELECT SUM(payoff_amount) AS value_sum FROM loan_transaction where loan_id= '$id'");
  while ($row_payment = mysqli_fetch_array($query_payment)) {
    $payment = $row_payment['value_sum'];

    $payment = number_format((float)$payment, 2, '.', '');

    // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$us;

  }

  ?>

  <?php



  $sql = mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'");

  while ($row = mysqli_fetch_array($sql)) {

    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $customer_numbr = $row['mobile_number'];
  }

  //echo "fname is:".$first_name;

  ?>




  <?php



  $sql = mysqli_query($con, "select * from tbl_loan where user_fnd_id= '$user_fnd_id' AND loan_id = '$id'");

  while ($row = mysqli_fetch_array($sql)) {

    $loan_id = $row['loan_id'];
    //echo "fndid is:".$fnd_id;
    $amount_loan = $row['amount_of_loan'];

    if ($amount_loan != '0') {

      $val = "$";
    }

    //echo "Amount is:".$amount_loan;

    $amount_left = $row['loan_total_payable'];
    $bg_id = $row['bg_id'];
    $next_payment = $row['payment_date'];
    $payment_tenure = $row['payment_tenure'];
    $escrow = $row['escrow'];
    $primary_port = $row['primary_portfolio'];
    $creation_date = $row['contract_date'];
    $created_by = $row['created_by'];
    $last_update = $row['last_update_by'];
    $last_update_date = $row['last_update_date'];

    $timestamp = strtotime($creation_date);

    // Creating new date format from that timestamp
    $new_creation_date = date("m-d-Y", $timestamp);

    $fee = $row['loan_fee'];
    $payoff = $amount_loan + $fee;
    $payoff = number_format("$payoff", 2);
  }

  ?>

  <?php



  $sql_user = mysqli_query($con, "select * from tbl_users where user_id= '$created_by'");

  while ($row_user = mysqli_fetch_array($sql_user)) {

    $username = $row_user['username'];
  }

  //echo "fname is:".$username;

  ?>



  <?php



  $sql_user = mysqli_query($con, "select * from tbl_loan_notes where loan_id= '$id'");

  while ($row_user = mysqli_fetch_array($sql_user)) {

    $loan_notes = $row_user['notes'];
  }

  //echo "fname is:".$loan_notes;



  $sql_t = "SELECT loan_id FROM tbl_loan  where sign_status='1' AND user_fnd_id= '$user_fnd_id' where $if_optima_loan_id ORDER BY loan_id";

  if ($result_t = mysqli_query($con, $sql_t)) {
    // Return the number of rows in result set
    $rowcount = mysqli_num_rows($result_t);
    // printf($rowcount);
    // Free result set
    $ye = mysqli_free_result($result_t);
    echo $ye;
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
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

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

          <div class="col-lg-4">
            <p>Customer First Name:<b style="color:red"> <?php echo $first_name; ?></b></p>
          </div>
          <div class="col-lg-4">
            <p>Customer Last Name: <b style="color:red"><?php echo $last_name; ?> </b></p>
          </div>
          <div class="col-lg-4">
            <p>Customer Phone:<b style="color:red"> <?php echo $customer_numbr; ?> </b> </p>
          </div>
          <div class="col-lg-3">
            <p>Loan Date:<b style="color:red"> <?php echo $new_creation_date; ?> </b></p>
          </div>
          <div class="col-lg-3">
            <p>Loan Amount: <b style="color:red"> <?php echo $val . $amount_loan; ?></b></p>
          </div>
          <div class="col-lg-3">
            <p>Loan ID:<b style="color:red"> <?php echo $loan_create_id; ?> </b> </p>
          </div>
          <div class="col-lg-3">
            <p>User ID:<b style="color:red"> <?php echo $user_fnd_id; ?> </b> </p>
          </div>

        </div>
        <br><br>

        <div class="container-fluid" style="width:100%; margin:0 auto;">
          <div class="row">
            <div class="col-lg-6">
              <h3>Loan History: <span style="color:red"><?php echo $rowcount; ?></span></h3>

            </div>

            <div class="col-lg-6" align="right">
              <?php
              if ($payment >= $payoff or  $loan_status == 'Paid') {
                echo "<a href='renew_loan.php?id=$id' <button name='btn' type='submit' class='btn btn-danger' style='background-image: linear-gradient(to bottom,#95c500 0,#639a0a 100%);
    color: #fff;
    background-color: #2a8206;
    border-color: #112f01;'>Renew Loan</button></a>";
              }
              ?>
            </div>
          </div>
          <br>
          <table class="table table-striped table-bordered">
            <thead>
              <tr style="background-color: #F5E09E;color: black;">
                <th style='width:10%;'>Loan ID(Card#)</th>
                <th style='width:10%;'>Account Status</th>
                <th style='width:14%;'>Customer</th>
                <th style='width:10%;'>Phone</th>
                <th style='width:10%;'>Loan Amount</th>
                <th style='width:6%;'>Fee</th>
                <th style='width:10%;'>Payoff Amount</th>
                <th style='width:12%;'>Loan Date</th>
                <th style='width:10%;'>Payment Date</th>
                <th style='width:20%;'>Last Payment Date</th>
                <th style='width:5%;'>DPD</th>
              </tr>
            </thead>
            <tbody>


              <?php


              $id = $_GET['id'];

              $sql_fnd = mysqli_query($con, "select * from tbl_loan where loan_id = '$id'");

              while ($row_fnd = mysqli_fetch_array($sql_fnd)) {



                $user_fnd_id = $row_fnd['user_fnd_id'];
                //echo "FND_ID" .$user_fnd_id;
              }

              $sql_loan_his = mysqli_query($con, "select * from tbl_loan where user_fnd_id = '$user_fnd_id' AND sign_status='1' ");

              while ($row_loan_his = mysqli_fetch_array($sql_loan_his)) {


                $loan_id = $row_loan_his['loan_id'];
                $loan_status = $row_loan_his['loan_status'];
                $loan_create_id = $row_loan_his['loan_create_id'];
                $amount_of_loan = $row_loan_his['amount_of_loan'];
                $fee = $row_loan_his['loan_fee'];
                $payoff = $amount_of_loan + $fee;
                $payoff = number_format("$payoff", 2);
                $contract_date_db = $row_loan_his['contract_date'];
                $payment_date_db = $row_loan_his['payment_date'];
                $last_payment_date = $row_loan_his['last_payment_date'];

                $start = strtotime($payment_date_db);
                $end = strtotime($last_payment_date);

                $days_between = ceil(abs($end - $start) / 86400);

                //echo "this".$days_between."<br>";



                $now = time();
                $your_date = strtotime($payment_date_db);


                $datediff = $now - $your_date;

                $days_past = round($datediff / (60 * 60 * 24));

                if ($days_past < 0) {
                  $days_past = str_replace("-", "", "$days_past");
                }
                $timestamp = strtotime($contract_date_db);
                $contract_date = date("m-d-Y", $timestamp);

                $timestamp = strtotime($payment_date_db);
                $payment_date = date("m-d-Y", $timestamp);




                if ($amount_of_loan != '0') {
                  $varibl = "$";
                }

                if ($last_payment_date == "") {

                  $query_payment = mysqli_query($con, "SELECT * FROM loan_transaction where loan_id= '$loan_id' AND payoff_amount>1");
                  while ($row_payment = mysqli_fetch_array($query_payment)) {
                    $last_payment_date = $row_payment['payment_date'];
                  }
                }

                
                $timestamp = strtotime($last_payment_date);
                $last_payment_date1 = date("m-d-Y", $timestamp);

                if ($last_payment_date == '01-01-1970' || $last_payment_date == "") {
                  $last_payment_date = $date_current = date('Y-m-d');
                  $last_payment_date1 = "";
                }

                $date1 = date_create($payment_date_db);
                $date2 = date_create($last_payment_date);

                if ($date1 == false) {
                  $last_payment_date_array = explode("-", $payment_date);
                  $ld = strtotime($last_payment_date_array[2] . "-" . $last_payment_date_array[0] . "-" . $last_payment_date_array[1]);
                  $date1 = date_create(date("Y-m-d", $ld));
                }

                if ($date2 == false) {
                  $last_payment_date_array = explode("-", $last_payment_date);
                  $ld = strtotime($last_payment_date_array[2] . "-" . $last_payment_date_array[0] . "-" . $last_payment_date_array[1]);
                  $date2 = date_create(date("Y-m-d", $ld));
                }
                //difference between two dates
                $diff = date_diff($date1, $date2);

                //count days
                $days_between = $diff->format("%r%a");



                //$user_fnd_id = $row_loan_his['user_fnd_id'];
                $sql_doc = mysqli_query($con, "select * from fnd_user_profile where user_fnd_id = '$user_fnd_id'");

                while ($row_doc = mysqli_fetch_array($sql_doc)) {

                  $first_name = $row_doc['first_name'];
                  $last_name = $row_doc['last_name'];
                  $name = $first_name . ' ' . $last_name;
                  $mobile_number = $row_doc['mobile_number'];
                }

                //get emailkey by loanid
                $sql_fnd = mysqli_query($con, "select lib.email_key,lib.card_number,lib.user_fnd_id, tl.loan_id from loan_initial_banking lib LEFT JOIN tbl_loan tl on tl.loan_create_id = lib.loan_id where lib.loan_id = '$loan_create_id' and lib.email_key <> '' order by lib.initial_id DESC");


                $email_keys = array();
                $cards = array();
                $loan_ids = array();

                while ($row_fnd = mysqli_fetch_array($sql_fnd)) {
                  //$email_key=$row_fnd['email_key'];
                  array_push($cards, $row_fnd['card_number']);
                  array_push($email_keys, $row_fnd['email_key']);
                  array_push($loan_ids, $row_fnd['loan_id']);
                  //$card_number=$row_fnd['card_number'];
                  //$user_fnd_id=$row_fnd['user_fnd_id'];
                  //echo "FND_ID" .$user_fnd_id;
                }
                $arrlength = count($email_keys);

                echo "<tr><td style='text-align:left;'>";
                for ($x = 0; $x < $arrlength; $x++) {
                  $rest = substr($cards[$x], -4);
                  echo "<div style='display:flex;'><div style='margin: auto auto auto 0'><a href='loan_summary.php?id=$loan_ids[$x]' title='Go to Loan Summary'>$loan_create_id($rest)</a></div>";
                  echo "<div><a target='_blank' href='https://www.ofsca.com/loanportal/signature_customer/files/sign_contract.php?id=$email_keys[$x]'><span class='glyphicon glyphicon-file' title='Contract' aria-hidden='true' alt='Contract'></span></a></div></div>";
                }

                echo "</td>
        <td>$loan_status</td>
        <td>$name</td>
        <td>$mobile_number</td>
        <td>$varibl$amount_of_loan</td>
        <td>$varibl$fee</td>
        <td>$varibl$payoff</td>
        <td>$contract_date</td>
        <td>$payment_date</td>
        <td>$last_payment_date1</td>
        <td>";

                if ($last_payment_date == '') {

                  echo  "$days_past";
                } else {
                  echo "$days_between";
                }

                echo "</td>
        </tr>";
              }

              ?>

            </tbody>
          </table>



          <br /><br />

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