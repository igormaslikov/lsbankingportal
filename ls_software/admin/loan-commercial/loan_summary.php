<?php
error_reporting(0);
session_start();
include_once '../dbconnect.php';

if (!isset($_SESSION['userSession'])) {
  header("Location: ../index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=" . $_SESSION['userSession']);
$userRow = $query->fetch_array();
$u_id = $userRow['user_id'];
$u_name = $userRow['username'];

$u_access_id = $userRow['access_id'];
if ($u_access_id == '2' || $u_access_id == '4' || $u_access_id == '5') {
  echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
} else {
  $DBcon->close();

?>


  <?php
  include_once '../dbconnect.php';
  include_once '../dbconfig.php';
  $id = $_GET['id'];
  $sql_fnd = mysqli_query($con, "select * from tbl_commercial_loan where loan_id = '$id'");

  while ($row_fnd = mysqli_fetch_array($sql_fnd)) {

    $user_fnd_id = $row_fnd['user_fnd_id'];
    $loan_create_id = $row_fnd['loan_create_id'];
    $amount_of_loan = $row_fnd['amount_of_loan'];
    $loan_interest = $row_fnd['loan_interest'];
    $loan_status = $row_fnd['loan_status'];
  }



  $settlement_amount = 0;
  $query_payment = mysqli_query($con, "SELECT SUM(payment) AS sum_payment, SUM(`paid amount`) AS sum_paid_amount FROM tbl_commercial_loan_installments where loan_create_id= '$loan_create_id' and status=2");
  while ($row_payment = mysqli_fetch_array($query_payment)) {
    $sum_payment = $row_payment['sum_payment'];
    $sum_paid_amount = $row_payment['sum_paid_amount'];
    $settlement_amount = $sum_payment - $sum_paid_amount;

    $settlement_amount = number_format((float)$settlement_amount, 2, '.', '');
  }

  $sql = mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'");

  while ($row = mysqli_fetch_array($sql)) {

    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $customer_numbr = $row['mobile_number'];
    $chat_key = $row['chat_key'];
  }

  //echo "fname is:".$first_name;


  $sql = mysqli_query($con, "select * from tbl_commercial_loan where loan_id= '$id'");

  while ($row = mysqli_fetch_array($sql)) {

    $loan_id = $row['loan_id'];
    //echo "fndid is:".$fnd_id;
    $amount_loan = $row['principal_amount'];
    $amount_loan = number_format((float)$amount_loan, 2, '.', '');
    $apr = $row['apr'];

    if ($amount_loan != '0') {

      $val = "$";
    }

    //echo "Amount is:".$amount_loan;

    $amount_left = $row['loan_total_payable'];
    $bg_id = $row['bg_id'];
    $payment_date = $row['payment_date'];
    $payment_tenure = $row['payment_tenure'];
    $escrow = $row['escrow'];
    $primary_port = $row['primary_portfolio'];
    $creation_date = $row['contract_date'];
    $created_by = $row['created_by'];
    $last_update = $row['last_update_by'];
    $last_update_date = $row['last_update_date'];
    $last_payment_date = $row['last_payment_date'];

    $timestamp = strtotime($last_payment_date);
    $last_payment_date = date("m-d-Y", $timestamp);


    $timestamp = strtotime($creation_date);

    // Creating new date format from that timestamp
    $new_creation_date = date("m-d-Y", $timestamp);


    $loan_status = $row['loan_status'];
    $primary_port = $row['secondary_portfolio'];
    $other_fees = $row['other_fees'];
    $late_fee = $row['late_fee'];
  }

  $query_payment = mysqli_query($con, "Select payment, `paid amount`, payment_date, chargeback_amount from `tbl_commercial_loan_installments` where loan_create_id = '$loan_create_id' and status = 0 order by id asc limit 1 ");
  while ($row_payment = mysqli_fetch_array($query_payment)) {
    $due_date = $row_payment['payment_date'];
    $payment = $row_payment['payment'];
    $paid_amount = $row_payment['paid amount'];
    $chargeback_amount = $row_payment['chargeback_amount'];
  }

  $balance_due = $payment - $paid_amount;

  $date_now = date_create(date("Y-m-d", strtotime("now")));
  $due_date_array = explode("-", $due_date);
  $date_due_date = date_create(date("Y-m-d", strtotime($due_date_array[2] . "-" . $due_date_array[0] . "-" . $due_date_array[1])));
  $interval = date_diff($date_due_date, $date_now);

  $payment = 0;
  $query_payment = mysqli_query($con, "SELECT SUM(payment_amount) AS value_sum FROM commercial_loan_transaction where loan_id= '$id'");
  while ($row_payment = mysqli_fetch_array($query_payment)) {
    $payment = $row_payment['value_sum'];
  }

  $payoff = number_format(((float)($amount_of_loan + $loan_interest - $payment)), 2, '.', ',');

  $dpd =  $interval->format('%r%a');
  $disableButton = "";
  if ($loan_status == "Paid") {
    $payoff = 0;
    $dpd = 0;
    $balance_due = 0;
    $disableButton = "hidden";
  }


  $sql_user = mysqli_query($con, "select * from tbl_users where user_id= '$created_by'");

  while ($row_user = mysqli_fetch_array($sql_user)) {

    $username = $row_user['username'];
  }

  $unpaid_late_fee = 0;
  $query_payment = mysqli_query($con, "SELECT sum($late_fee - paid_late_fee) as unpaid FROM `tbl_commercial_loan_installments` WHERE `dpd` >= 10 and loan_create_id = '$loan_create_id' and ($late_fee - paid_late_fee) > 0 ");
  while ($row_payment = mysqli_fetch_array($query_payment)) {
    $unpaid_late_fee = $row_payment['unpaid'] == null ? 0 : $row_payment['unpaid'];
  }

  $unpaid_other_fee = 0;
  $query_payment = mysqli_query($con, "SELECT sum(amount_fee - amount_fee_paid) as unpaid FROM `tbl_other_fees` WHERE loan_created_id = $loan_create_id ");
  while ($row_payment = mysqli_fetch_array($query_payment)) {
    $unpaid_other_fee = $row_payment['unpaid'] == null ? 0 : $row_payment['unpaid'];
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
    <link href="../bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="../../website/css/font-awesome.min.css">


    <!-- Bootstrap core CSS -->
    <!-- Custom styles for this template -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/b-1.7.1/sl-1.3.3/datatables.min.css" />
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.3.1/dt-1.10.25/b-1.7.1/sl-1.3.3/datatables.min.css" /> -->

    <script type="module" src="../../website/js/x-frame-bypass.js"></script>
    <style>
      .tooltip-inner {
        max-width: 300px;
        width: 300px;
        /* background-color:gray;
        color:white; */
      }

      .lock{
        pointer-events: none;
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
            <p>Loan Type:<b style="color:red">Commercial</b></p>
          </div>
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
            <p>Loan Amount: <b style="color:red"> <?php echo $val . $amount_loan; ?></b></p>
          </div>
          <div class="col-lg-4">
            <p>Loan ID: <b style="color:red" id="loanId"><?php echo $loan_create_id; ?></b> </p>
          </div>
          <div class="col-lg-4">
            <p>User ID: <b style="color:red" id="userId"><?php echo $user_fnd_id; ?></b> </p>
          </div>


        </div>
        <br><br>


        <div class="container-fluid">
          <h3>Loan Summary:</h3>
          <!-- <a href=../../../../signature_customer/loan/case_pdf.php?id=<?php //echo $id;
                                                                            ?> target='_blank' style="margin-left: 900px;"> <img src="https://img.icons8.com/color/48/000000/pdf.png"></a><br>-->
          <br>
          <div class="col-lg-12">
            <form action="#" method="POST">
              <div class="form-group">
                <div class="row">

                  <div class="col-lg-8">
                    <div class="row">
                      <div class="col-lg-6">
                        <label for="usr">Account Status</label>
                        <select name="account_status" id="app_status" class="form-control" value="" style="padding: 6px 15px;">
                          <option value="">Account Status</option>
                          <option value="Active" <?php if ($loan_status == 'Active') {
                                                    echo 'selected';
                                                  } ?>>Active</option>
                          <option value="Paid" <?php if ($loan_status == 'Paid') {
                                                  echo 'selected';
                                                } ?>>Paid</option>
                          <option value="Past Due" <?php if ($loan_status == 'Past Due') {
                                                      echo 'selected';
                                                    } ?>>Past Due</option>
                          <option value="Promise to Pay" <?php if ($loan_status == 'Promise to Pay') {
                                                            echo 'selected';
                                                          } ?>>Promise to Pay</option>
                          <option value="Payment Plan" <?php if ($loan_status == 'Payment Plan') {
                                                          echo 'selected';
                                                        } ?>>Payment Plan</option>
                          <option value="Collections" <?php if ($loan_status == 'Collections') {
                                                        echo 'selected';
                                                      } ?>>Collections</option>
                          <option value="Chargeoff" <?php if ($loan_status == 'Chargeoff') {
                                                      echo 'selected';
                                                    } ?>>Chargeoff</option>
                          <option value="Closed Account" <?php if ($loan_status == 'Closed Account') {
                                                            echo 'selected';
                                                          } ?>>Closed Account</option>
                          <option value="Chargeback" <?php if ($loan_status == 'Chargeback') {
                                                        echo 'selected';
                                                      } ?>>Chargeback</option>
                          <option value="Bankruptcy" <?php if ($loan_status == 'Bankruptcy') {
                                                        echo 'selected';
                                                      } ?>>Bankruptcy</option>
                        </select>
                      </div>
                      <div class="col-lg-6">
                        <label for="usr">Secondary Portfolio</label>
                        <select name="p_portfolio" id="p_portfolio" class="form-control" value="<?php echo $primary_port; ?>">
                          <option value="None" <?php if ($primary_port == 'None') {
                                                  echo 'selected';
                                                } ?>>None</option>
                          <option value="Money Line" <?php if ($primary_port == 'Money Line') {
                                                        echo 'selected';
                                                      } ?>>Money Line</option>
                          <option value="Kenneth" <?php if ($primary_port == 'Kenneth') {
                                                    echo 'selected';
                                                  } ?>>Kenneth</option>
                        </select>
                      </div>
                      <div class="col-lg-6">
                        <label for="usr">Loan Amount</label>
                        <input type="text" name="amount_loan" class="form-control lock" id="usr" placeholder="Amount Of Loan" value="<?php echo $val . $amount_loan; ?>">
                      </div>
                      <div class="col-lg-3">
                        <label for="usr">Payoff Amount</label>
                        <input type="text" name="amount_left" class="form-control lock" id="usr" placeholder="Amount Left" value="<?php echo $val . $payoff; ?>">
                      </div>
                      <div class="col-lg-3">
                        <label for="usr">Settlement Amount</label>
                        <input type="text" name="settlement_amount" class="form-control lock" id="usr" placeholder="Settlement Left" value="<?php echo $val . $settlement_amount; ?>">
                      </div>
                      <div class="col-lg-6">
                        <label for="usr">Due Date</label>
                        <input type="text" name="next_payment_date" class="form-control lock" id="usr" placeholder="MM/DD/YYYY" value="<?php echo $due_date; ?>">
                      </div>

                      <div class="col-lg-2">
                        <label for="usr">Days Past Due</label>
                        <input type="text" name="days_past_due" class="form-control lock" id="usr" placeholder="" value="<?php echo $dpd; ?>">
                      </div>
                      <div class="col-lg-2">
                        <label for="other_fees_unpaid">Other Fees Unpaid</label>
                        <input type="text" name="other_fees_unpaid" class="form-control lock" id="other_fees_unpaid" placeholder="" value="<?php echo $val . $unpaid_other_fee; ?>">
                      </div>
                      <div class="col-lg-2">
                        <label for="late_fee_unpaid">Late Fees Unpaid</label>
                        <input type="text" name="late_fee_unpaid" class="form-control lock" id="late_fee_unpaid" placeholder="" value="<?php echo $val . $unpaid_late_fee; ?>">
                      </div>
                      <div class="col-lg-6">
                        <label for="usr">Contract APR</label>
                        <input type="text" name="apr" class="form-control lock" id="usr" placeholder="" value="<?php echo $apr; ?>">
                      </div>
                      <div class="col-lg-3">
                        <label for="usr">Balance Due</label>
                        <input type="text" name="blns" class="form-control lock" id="usr" placeholder="" value="<?php echo $val . $balance_due; ?>">
                      </div>
                      <div class="col-lg-3">
                        <label for="usr">Chargeback Amount</label>
                        <input type="text" name="chargeback" class="form-control lock" id="usr" placeholder="" value="<?php echo $val . $chargeback_amount; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <table id="tblOtherFeesId">
                      <thead>
                        <tr>
                          <th colspan="5" style="text-align:center">Other Fees</th>

                        </tr>
                        <tr>
                          <th>ID</th>
                          <th>Description</th>
                          <th>Amount Fee</th>
                          <th>Paid</th>
                          <th class="no-sort"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql_loan = mysqli_query($con, "select * from tbl_other_fees tof inner join tbl_lists tl on tof.kind_fee = tl.tbl_lists_id where loan_created_id='$loan_create_id' and user_fnd_id = '$user_fnd_id'");

                        while ($row_loan = mysqli_fetch_array($sql_loan)) {
                          $other_fee_id = $row_loan['tbl_other_fees_id'];
                          $row_item_fee = $row_loan['item'];
                          $amount_fee = $row_loan['amount_fee'];
                          $amount_fee_paid = $row_loan['amount_fee_paid'];

                          $background_color = "";
                          if ($amount_fee_paid == $amount_fee) {
                            $background_color = "background-color: lightgreen !important";
                          }
                          echo "
                            <tr style='$background_color'>
                              <td>$other_fee_id</td>
                              <td>$row_item_fee</td>
                              <td>$amount_fee</td>
                              <td>$amount_fee_paid</td>
                              <td style='padding-left:0; padding-right:5px'></td>
                            </tr>
                          ";
                        }


                        ?>
                      </tbody>
                    </table>
                  </div>

                </div>

                <br>


                <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: white;background-color: #1E90FF;border-radius: 0px;border-color: #1E90FF;">Update</button>
                <button name="btn" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,red 0,red 100%);color: #fff;background-color:red;border-color: red;" <?php echo $disableButton; ?>><a href="add_new_transaction.php?id=<?php echo $id; ?>" style="color:white">Make a
                    Payment</a></button>
                <button name="btn" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,red 0,red 100%);color: #fff;background-color:red;border-color: red;" <?php echo $disableButton; ?>><a href="schedule_payment.php?id=<?php echo $id; ?>" style="color:white">Schedule
                    Payment</a></button>

                <?php
                if ($payment > 0) {
                  $loan_type = "Commercial Loan";
                  $name_button = $loan_status == 'Paid' ? "Renew" : "Refinance";
                  $current_loan_id = $loan_status == 'Paid' ? "" : "&loan_create_id=$loan_create_id";
                  echo "<a href='../add_commercial_loan.php?id=$user_fnd_id&loan=$loan_type$current_loan_id' target=_blank <button name='btn' type='submit' class='btn btn-danger' style='background-image: linear-gradient(to bottom,#95c500 0,#639a0a 100%);
    color: #fff;
    background-color: #2a8206;
    border-color: #112f01;'>" . $name_button . " Loan</button></a>";
                }
                ?>
            </form>



          </div>
        </div>

      </div>

      <br>


      <br><br>
      <div class="container-fluid" style="width:100%; margin:0 auto;">
        <table id="example" class="display">
          <thead>
            <tr>
              <th rowspan="3">Transaction ID</th>
              <th rowspan="3">Loan ID</th>
              <th rowspan="3">Payment</th>
              <th rowspan="3">Interest</th>
              <th rowspan="3">Principal</th>
              <th rowspan="3">Balance</th>
              <th colspan="4" style="text-align:center">Fees</th>
              <th rowspan="3">Due Date</th>
              <th rowspan="3">Payment Date</th>
              <th rowspan="3">Payment Method</th>
              <th rowspan="3">User Name</th>
              <th rowspan="3">DPD</th>
              <th rowspan="3">Action</th>
            </tr>
            <tr>
              <th rowspan="2">Late</th>
              <th rowspan="2">Convenience</th>
              <th colspan="2" style="text-align:center">Other</th>
              <!-- <th colspan="2" style="text-align:center">Chargeback</th> -->
            </tr>
            <tr>
              <th>Amount</th>
              <th>Description</th>
              <!-- <th>Amount</th>
              <th>Description</th> -->
            </tr>
          </thead>
          <tbody>


            <?php
            include('db.php');
            $result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM `commercial_loan_transaction` where loan_id='$id'");
            $total_records = mysqli_fetch_array($result_count);
            $total_records = $total_records['total_records'];
            $total_no_of_pages = ceil($total_records / $total_records_per_page);
            $second_last = $total_no_of_pages - 1; // total page minus 1

            $sql_loan = mysqli_query($con, "select * from commercial_loan_transaction clt LEFT join tbl_other_fees tof on clt.other_fee_id = tof.tbl_other_fees_id LEFT JOIN tbl_lists tl on tof.kind_fee = tl.tbl_lists_id where loan_id='$id' order by transaction_id desc");
            $count = 0;
            while ($row_loan = mysqli_fetch_array($sql_loan)) {
              $count++;
              $transaction_id = $row_loan['transaction_id'];
              $loan_create_id = $row_loan['loan_create_id'];
              $payment_amount = $row_loan['payment_amount'];
              $interest_amount = $row_loan['interest'];
              $principal_amount = $row_loan['principal_amount'];
              $remaining_balance = $row_loan['remaining_balance'];
              $payment_description = $row_loan['payment_description'];
              $payment_method = $row_loan['payment_method'];
              $payment_date = $row_loan['payment_date'];
              $created_at = $row_loan['created_at'];
              $created_by_get_db_activity = $row_loan['created_by'];
              $late_fee = $row_loan['late_fee'];
              $convenience_fee = $row_loan['convenience_fee'];
              $other_fee = $row_loan['other_fee'];
              $description = $row_loan['item'] == null ? "" : $row_loan['item'] . " (" . $row_loan['other_fee_id'] . ")";
              $chargeback_fee = $row_loan['chargeback_fee'];
              $chargeback_fee_id = $row_loan['chargeback_fee_id'];
              $description_chargeback = "";
              if($chargeback_fee_id != 0){
                $sql_loan_chargeback = mysqli_query($con, "select * from commercial_loan_transaction clt LEFT join tbl_other_fees tof on clt.chargeback_fee_id = tof.tbl_other_fees_id LEFT JOIN tbl_lists tl on tof.kind_fee = tl.tbl_lists_id where transaction_id='$transaction_id'");
                while ($row_chargeback = mysqli_fetch_array($sql_loan_chargeback)) {
                  $description_chargeback = $row_chargeback['item'] == null ? "" : $row_loan['item'] . " (" . $row_loan['chargeback_fee_id'] . ")";
                }
              }
              $other_fee = $row_loan['other_fee'];
              $card_info = $row_loan['card_info'];
              $is_chargeback = $row_loan['is_chargeback'];

              $card_info_tooltip = "";
              $tooltip = "";
              $start_mark = "";
              $end_mark = "";
              if ($card_info != 0) {
                $query_card_info = mysqli_query($con, "SELECT * FROM commercial_loan_transaction_cards_info where card_info_id= '$card_info'");
                while ($row_card_info = mysqli_fetch_array($query_card_info)) {
                  $type_of_id = $row_card_info['type_of_id'];
                  $type_of_card = $row_card_info['type_of_card'];
                  $card_number = $row_card_info['card_number'];
                  $card_exp_date = $row_card_info['card_exp_date'];
                  $cvv_number = $row_card_info['cvv_number'];
                  $bank_name = $row_card_info['bank_name'];
                  $account_number = $row_card_info['account_number'];
                  $routing_number = $row_card_info['routing_number'];
                  $account_type = $row_card_info['account_type'];
                  $bank_type = $row_card_info['bank_type'];
                  $start_mark = "<mark>";
                  $end_mark = "</mark>";
                  $card_info_tooltip = "
                  style='cursor:pointer;' 
                  data-toggle='tooltip' data-html='true' title=\"
                    <div style='width: 300px;'>
                        <div class='row flex-nowrap'>
                          <div class='col-6'>Bank Name</div>
                          <div class='col-6'>" . $bank_name . "</div>
                        </div>
                        <div class='row flex-nowrap'>
                          <div class='col-6'>Account Number</div>
                          <div class='col-6'>" . $account_number . "</div>
                        </div>
                        <div class='row flex-nowrap'>
                          <div class='col-6'>Routing Number</div>
                          <div class='col-6'>" . $routing_number . "</div>
                        </div>
                        <div class='row flex-nowrap'>
                          <div class='col-6'>Account Type</div>
                          <div class='col-6'>" . $account_type . "</div>
                        </div>
                        <div class='row flex-nowrap'>
                          <div class='col-6'>Bank Type</div>
                          <div class='col-6'>" . $bank_type . "</div>
                        </div>      
                          <div class='row flex-nowrap'>
                          <div class='col-6'>Type Of ID</div>
                          <div class='col-6'>" . $type_of_id . "</div>
                        </div>                  
                        <div class='row flex-nowrap'>
                          <div class='col-6'>Type Of Card</div>
                          <div class='col-6'>" . $type_of_card . "</div>
                        </div>
                        <div class='row flex-nowrap'>
                          <div class='col-6'>Card Number</div>
                          <div class='col-6'>" . $card_number . "</div>
                        </div>
                        <div class='row flex-nowrap'>
                          <div class='col-6'>Expiration Date</div>
                          <div class='col-6'>" . $card_exp_date . "</div>
                        </div>
                        <div class='row flex-nowrap'>
                          <div class='col-6'>CVV</div>
                          <div class='col-6'>" . $cvv_number . "</div>
                        </div>
                    </div>\"
                  
                  ";
                  break;
                  // echo"<br>User_Key:" .$payment;

                }
              }
              $convenience_fee = $convenience_fee == "" ? 0 : $convenience_fee;

              $query_balnce = mysqli_query($con, "SELECT * FROM tbl_commercial_loan where loan_create_id= '$loan_create_id'");
              while ($row_balnce = mysqli_fetch_array($query_balnce)) {
                $amount_of_loan = $row_balnce['amount_of_loan'];

                $amount_of_loan = number_format((float)$amount_of_loan, 2, '.', '');
                break;
                // echo"<br>User_Key:" .$payment;

              }

              $total_payment += $payment_amount;
              $total_interest += $interest_amount;
              $total_principal += $principal_amount;
              $total_balnce = $amount_of_loan - $total_principal;

              $sql_activity_by_user = mysqli_query($con, "select * from tbl_users where user_id= '$created_by_get_db_activity'");
              $final_activity_by_user = '';
              while ($row_sql_activity_by_user = mysqli_fetch_array($sql_activity_by_user)) {
                $final_activity_by_user = $row_sql_activity_by_user['username'];
              }

              $timestamp = strtotime($payment_date);
              $payment_date_f = date("m-d-Y", $timestamp);

              $timestamp = strtotime($created_at);
              $created_at_f = date("m-d-Y", $timestamp);

              $interval = date_diff(date_create($payment_date), date_create($created_at));
              $dpd = $interval->format('%r%a');

              $row_color = $is_chargeback ? "color:orange" : "";
              if (strpos($payment_method, "Chargeback") !== false) {
                $row_color = "color:red";
              }
              $chargeBack = ($is_chargeback == '0' && ($payment_method == "Debit Card" || $payment_method == "Repay Portal")) ? " <div><i class='fa fa-arrow-circle-o-left' id='btnChargeBackId' style='cursor: pointer'></i></div>" : "";
              $edit_button = $payment_method == "Repay" ? "" : "<div style='display:flex;justify-content:space-between; align-items:center'><div><i id='editBtnTransaction' class='fa fa-pencil-square' style='color:orange; cursor:pointer'></i></div>";
              $delete_button = "<div><i id='removeBtnTransaction' class='fa fa-trash' style='color:red;cursor:pointer'></i></div>";
              $action = $count == 1 ? "$edit_button" . "$delete_button" . "$chargeBack" . "</div>" : $chargeBack;
              echo "<tr style='$row_color'>
              <td>" . $transaction_id . "</td>
              <td>" . $loan_create_id . "</td>
              <td>$" . number_format($payment_amount,   2, ".", ",") . "</td>
              <td>$" . number_format($interest_amount,   2, ".", ",") . "</td>
              <td>$" . number_format($principal_amount,   2, ".", ",") . "</td>
              <td>$" . $remaining_balance . "</td>
              <td>$" . $late_fee . "</td>
              <td>$" . $convenience_fee . "</td>
              <td>$" . $other_fee . "</td>
              <td>" . $description . "</td>
              <td>" . $payment_date_f . "</td>
              <td>" . $created_at_f . "</td>
              <td " . $card_info_tooltip . ">" . $start_mark . $payment_method . $end_mark . "</td>
              <td>" . $final_activity_by_user . "</td>
              <td>" . $dpd . "</td>
              <td>" . $action . "</td>
		   	  </tr>";
            }

            // echo "<tr style='background-color:red;font-weight:bold'>

            // <td>Total</td>
            // <td>$" . number_format($total_payment, 2, ".", ",") . "</td>
            //  <td>$" . number_format($total_interest, 2, ".", ",") . "</td>
            //  <td>$" . number_format($total_principal, 2, ".", ",") . "</td>
            //  <td>$" . number_format($total_balnce, 2, ".", ",") . "</td>
            //    </tr>";
            ?>

          </tbody>
        </table>



        <br /><br />

      </div>

      <h3 style="color:red;">Conversation <span style="float:right;"> </span> </h3>
      <iframe src="../sms-chat/index.php?chat_key=<?php echo $chat_key; ?>&admin_name=<?php echo $u_name; ?>" height="500px" width="100%" id="conversation"></iframe>

      <div id="deleteModal" class="modal " role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <div display="none"><i id="idInformation"></i></div>

              <h4 id="deleteTitle" class="modal-title">Delete Other Fee</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="box-body">
                <label for="chkDel">Are you sure?</label>
              </div>

            </div>
            <div class="modal-footer">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input1" onchange="showDeleteBtn()" id="chkDel">
                <button type="button" name="" id="btnDel" disabled onclick="deleteItem()" class="btn btn-danger">Delete</button>
              </div>

            </div>
          </div>
        </div>
      </div>

      <!-- /#page-content-wrapper -->
      <div class="modal fade" id="type_alert" tabindex="-1" aria-labelledby="type_alert" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-close-div">
              <div class="cancel modal_close text-center" data-dismiss="modal">
                <i class="fa fa-times"></i>
              </div>
            </div>
            <div class="modal-header">
              <h5 class="modal-title text-center" id="type_alert_title"></h5>
              <div display="none"><i id="lblUid" value="<?php echo $u_id; ?>"></i></div>
              <div display="none"><i id="lblId" value="<?php echo $id; ?>"></i></div>
              <div display="none"><i id="lblLoanId"></i></div>
              <div display="none"><i id="lblTransactionId"></i></div>
              <div display="none"><i id="lblTransactionAmount"></i></div>
              <div display="none"><i id="lblOtherFeeId"></i></div>
            </div>
            <div class="modal-body" style="margin-left:15px">
              <div class="row">
                <div class="col-md-5 col-sm-5 col-lg-5"><label style="text-align:left">Chargeback
                    Amount<mark class="red">*</mark></label></div>
                <div class="col-md-5 col-sm-5 col-lg-5"><input type="text" style="color:black" id="lblChargeback" oninput=oniputChange(this) />
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 col-sm-5 col-lg-5"><label style="text-align:left">Late Fee<mark class="red">*</mark></label></div>
                <div class="col-md-5 col-sm-5 col-lg-5"><input type="text" style="color:black" id="lblLateFee" oninput=oniputChange(this) />
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 col-sm-5 col-lg-5"><label style="text-align:left">Convenience Fee<mark class="red">*</mark></label></div>
                <div class="col-md-5 col-sm-5 col-lg-5"><input type="text" style="color:black" id="lblCovenienceFee" oninput=oniputChange(this) />
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 col-sm-5 col-lg-5"><label style="text-align:left">Other Fee<mark class="red">*</mark></label></div>
                <div class="col-md-5 col-sm-5 col-lg-5"><input type="text" style="color:black" id="lblOtherFee" oninput=oniputChange(this) />
                </div>
              </div>
              <div class="row" id="error_row">
                <div class="col-md-12 col-sm-12 col-lg-12" style="justify-content: center; display: flex">
                  <label style="text-align: center; color: red" id="lblError"></label>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="reset" id="btnInsertUpdateBankInfo" onclick="updateChargeback()">Chargeback</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="transaction_edit_modal" tabindex="-1" aria-labelledby="transaction_edit_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 85% !important;">
          <div class="modal-content">
            <div class="modal-close-div">
              <div class="cancel modal_close text-center" data-dismiss="modal">
                <i class="fa fa-times"></i>
              </div>
            </div>
            <div class="modal-header">
              <h5 class="modal-title text-center" id="transaction_edit_modal_title"></h5>
              <div display="none"><i id="lblUidTransaction" value="<?php echo $u_id; ?>"></i></div>
              <div display="none"><i id="lblIdTransaction" value="<?php echo $id; ?>"></i></div>
              <div display="none"><i id="lblLoanIdTransaction"></i></div>
              <div display="none"><i id="lblTransactionIdTransaction"></i></div>
              <div display="none"><i id="lblTransactionAmountTransaction"></i></div>
              <div display="none"><i id="lblOtherFeeIdTransaction"></i></div>
              <div display="none"><i id="is_card"></i></div>
            </div>
            <div class="modal-body" id="transaction_modal_body_id" style="margin-left:15px">

            </div>
            <div class="modal-footer">
              <button type="submit" class="reset" id="btnUpdateTransaction" onclick="updateTransaction(event)">Update</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="type_alert_fee" tabindex="-1" aria-labelledby="type_alert_fee" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-close-div">
              <div class="cancel modal_close text-center" data-dismiss="modal">
                <i class="fa fa-times"></i>
              </div>
            </div>
            <div class="modal-header">
              <h5 class="modal-title text-center" id="type_alert_fee_title"></h5>
              <div style="display:none"><i id="lblOtherFeeId"></i></div>
              <div style="display:none"><i id="lblLoanId"><?php echo $loan_create_id; ?></i></div>
              <div style="display:none"><i id="lblUserId"><?php echo $user_fnd_id; ?> </i></div>
            </div>
            <div class="modal-body" style="margin-left:15px">

              <div class="row">
                <div class="col-md-5 col-sm-5 col-lg-5"><label style="text-align:left">Fee
                    Amount<mark class="red">*</mark></label></div>
                <div class="col-md-5 col-sm-5 col-lg-5"><input type="text" style="color:black" id="lblAmountFee" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 col-sm-5 col-lg-5"><label style="text-align:left">Description<mark class="red">*</mark></label></div>
                <div class="col-md-5 col-sm-5 col-lg-5">
                  <input list="type_of_descriptions" name="type_of_description" id="lblTypeOfDescription" style="width:100%">
                  <datalist id="type_of_descriptions">
                    <?php
                    $sql_loan = mysqli_query($con, "select * from tbl_lists where kind='Other Fee'");

                    while ($row_loan = mysqli_fetch_array($sql_loan)) {
                      $row_item = $row_loan['item'];
                      echo "
                        <option value='$row_item'></option>";
                    }
                    ?>
                  </datalist>
                </div>
              </div>
              <div class="row" id="error_row">
                <div class="col-md-12 col-sm-12 col-lg-12" style="justify-content: center; display: flex">
                  <label style="text-align: center; color: red" id="lblError"></label>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <label id="newOtherFee" hidden>true</label>
              <button type="button" class="reset" id="btnInsertUpdateOtherFee" onclick="updateOtherFee(event)">Add</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
      var $modal = $('#transaction_edit_modal');
      $modal.find('.modal-content')
        .resizable({
          minWidth: 625,
          minHeight: 300,
          handles: 'n, e, s, w, ne, sw, se, nw',
        })
        .draggable({
          handle: '.modal-header'
        });
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/b-1.7.1/sl-1.3.3/datatables.min.js"></script>
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.3.1/dt-1.10.25/b-1.7.1/sl-1.3.3/datatables.min.js"></script> -->


    <script src="https://cdn.datatables.net/rowgroup/1.1.3/js/dataTables.rowGroup.min.js"></script>
    <script src="js/otherFeesScript.js"></script>
    <script src="js/chargebackScript.js"></script>

    <!-- Menu Toggle Script -->
    <script>
      // jQuery.fn.dataTable.Api.register('sum()', function() {
      //   return this.flatten().reduce(function(a, b) {
      //     if (typeof a === 'string') {
      //       a = a.replace(/[^\d.-]/g, '') * 1;
      //     }
      //     if (typeof b === 'string') {
      //       b = b.replace(/[^\d.-]/g, '') * 1;
      //     }

      //     return a + b;
      //   }, 0);
      // });

      $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
      });

      var amount = '<?php echo $amount_loan; ?>';
      var chargebackModal = null;
      var editTransactionModal = null;
      var table;

      function round(x, n) {
        var exp = Math.pow(10, n);
        return Math.floor(x * exp + 0.5) / exp;
      }

      function deleteItem() {
        var type = document.getElementById("idInformation").value;
        switch (type) {
          case "fees":
            deleteFee();
            break;
          case "transaction":
            deleteTransaction();
            break;
        }
      }
    </script>

    <?php
    if (isset($_POST['btn-submit'])) {
      $calculation_type = $_POST['calculation_type'];

      $account_status = $_POST['account_status'];
      $portfolio = $_POST['p_portfolio'];
      $amount_loan_up = $_POST['amount_loan'];
      $amount_left_up = $_POST['amount_left'];
      $next_payment_date_up = $_POST['next_payment_date'];
      $next_payment = $_POST['p_tenure'];
      $days_past_due = $_POST['days_past_due'];
      $apr_up = $_POST['apr'];
      $amount_loan_up = str_replace("$", "", "$amount_loan_up");
      $amount_left_up = str_replace("$", "", "$amount_left_up");

      mysqli_query($con, "UPDATE tbl_commercial_loan SET loan_status = '$account_status', secondary_portfolio='$portfolio' where user_fnd_id ='$user_fnd_id' AND loan_id='$id'");


      $date_update = date('Y-m-d H:i:s');
      $loan_account_statuss = "Account Status Updated to: " . $_POST['account_status'];
      $query_insert_activity = "Insert into application_status_updates (application_id, loan_create_id, user_id, status, creation_date) Values ('$user_fnd_id', '$loan_create_id', '$u_id', '$loan_account_statuss', '$date_update')";
      mysqli_query($con, $query_insert_activity);


    ?>
      <script type="text/javascript">
        window.location.href = 'loan_summary.php?id=<?php echo $id; ?>';
      </script>


  <?php
    }
  }
  ?>
  </body>

  </html>