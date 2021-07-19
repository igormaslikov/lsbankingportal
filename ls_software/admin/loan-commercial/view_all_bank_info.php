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





  $id = $_GET['id'];
  $sql_fnd = mysqli_query($con, "select * from tbl_commercial_loan where loan_id = '$id'");

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

  $sql = mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'");

  while ($row = mysqli_fetch_array($sql)) {

    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $customer_numbr = $row['mobile_number'];
  }



  $sql_loan = mysqli_query($con, "select * from tbl_commercial_loan where loan_id= '$id'");

  while ($row_loan = mysqli_fetch_array($sql_loan)) {

    $loan_id = $row_loan['loan_id'];
    //echo "fndid is:".$fnd_id;
    $amount_loan = $row_loan['amount_of_loan'];

    if ($amount_loan != '0') {

      $val = "$";
    }

    //echo "Amount is:".$amount_loan;

    $amount_left = $row_loan['loan_total_payable'];

    $payment_tenure = $row_loan['payment_tenure'];
    $escrow = $row_loan['escrow'];
    $primary_port = $row_loan['primary_portfolio'];
    $creation_date = $row_loan['contract_date'];
    $created_by = $row_loan['created_by'];
    $last_update = $row_loan['last_update_by'];
    $last_update_date = $row_loan['last_update_date'];

    $timestamp = strtotime($creation_date);

    // Creating new date format from that timestamp
    $new_creation_date = date("m-d-Y", $timestamp);
  }




  $sql_user = mysqli_query($con, "select * from tbl_users where user_id= '$created_by'");

  while ($row_user = mysqli_fetch_array($sql_user)) {

    $username = $row_user['username'];
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
    <link rel="stylesheet" href="../../website/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.3.1/dt-1.10.25/b-1.7.1/sl-1.3.3/datatables.min.css" />
    <link rel="stylesheet" href="css/bankInfoStyle.css">
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
            <p>Money Amount: <b style="color:red"> <?php echo $val . $amount_loan; ?></b></p>
          </div>
          <div class="col-lg-3">
            <p>Loan ID:<b style="color:red"> <?php echo $loan_create_id; ?> </b> </p>
          </div>
          <div class="col-lg-3" id="idUserId" value="<?php echo $user_fnd_id; ?>">
            <p>User ID:<b style="color:red"> <?php echo $user_fnd_id; ?> </b> </p>
          </div>

        </div>
        <br><br>

        <!-- <div class="container-fluid">
          <div class="row">
            <div class="col-lg-4">
              <h3>All Banks Info</h3>

            </div>

            <div class="col-lg-4">


            </div>

            <div class="col-lg-4" align="right">
              <a href="add_secondary_bank.php?id=<?php echo $id; ?>"> <button name="btn" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,red 0,red 100%);
                  color: #fff;
                  background-color: red;
                  border-color: red;">Add Secondary Bank</button></a>

            </div>

          </div>
          <br>
          <table class="table table-striped table-bordered">
            <thead>
              <tr style="background-color: #F5E09E;color: black;">
                <th style='width:16%;'>Type of Card</th>
                <th style='width:16%;color:black;'>Card Number</th>
                <th style='width:16%;color:black;'>Bank Name</th>
                <th style='width:18%;color:black;'>Account Number</th>
                <th style='width:15%;color:black;'>Routing Number</th>
                <th style='width:17%;color:black;'>Action</th>
              </tr>
            </thead>
            <tbody>


              <?php
              include('db.php');
              $count = 1;
              if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
                $page_no = $_GET['page_no'];
                $count = $count + (25 * ($page_no - 1));
              } else {
                $page_no = 1;
              }

              $total_records_per_page = 25;
              $offset = ($page_no - 1) * $total_records_per_page;
              $previous_page = $page_no - 1;
              $next_page = $page_no + 1;
              $adjacents = "2";

              $result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM commercial_loan_initial_banking where user_fnd_id = '$user_fnd_id'");
              $total_records = mysqli_fetch_array($result_count);
              $total_records = $total_records['total_records'];
              $total_no_of_pages = ceil($total_records / $total_records_per_page);
              $second_last = $total_no_of_pages - 1; // total page minus 1

              $sql_loan = mysqli_query($con, "select * from commercial_loan_initial_banking where user_fnd_id = '$user_fnd_id'");

              while ($row_bank_detail_sec = mysqli_fetch_array($sql_loan)) {
                $initial_id = $row_bank_detail_sec['per_initial_id'];
                $type_of_id_sec = $row_bank_detail_sec['type_of_id'];
                $id_photo_sec = $row_bank_detail_sec['pic_of_id'];
                $type_of_card_sec = $row_bank_detail_sec['type_of_card'];

                $card_number_sec = $row_bank_detail_sec['card_number'];
                $card_exp_date_sec = $row_bank_detail_sec['card_exp_date'];
                $bank_front_sec = $row_bank_detail_sec['bank_front_pic'];

                $bank_back_sec = $row_bank_detail_sec['bank_back_pic'];
                $bank_name_sec = $row_bank_detail_sec['bank_name'];
                $routing_number_sec = $row_bank_detail_sec['routing_number'];

                $account_number_sec = $row_bank_detail_sec['account_number'];
                $void_img_sec = $row_bank_detail_sec['void_check_pic'];
                $cvv_number_sec = $row_bank_detail_sec['cvv_number'];
                $primary_status = $row_bank_detail_sec['primary_status'];




                echo "<tr>
	 	      
                          <td>" . $type_of_card_sec . "</td>
                          <td>" . $card_number_sec . "</td>
                          <td>" . $bank_name_sec . "</td>
                          <td>" . $account_number_sec . "</td>
                          <td>" . $routing_number_sec . "</td>
                          <td><a href='banking_detail.php?bank_id=$initial_id&fnd_id=$user_fnd_id&id=$id' title='Edit This User'>Edit</a> - 

                  <a class='remove-box' href='delete_bank_info.php?bank_id=$initial_id&fnd_id=$user_fnd_id&id=$id' title='Delete This User'>Delete</a>

                  </td>
                            

                            </tr>";
              }

              ?>

            </tbody>
          </table>
        </div> -->

        <div class="container-fluid">
          <!-- <div class="row">
            <div class="col-lg-12">
              <h3>All Banks Info</h3>

            </div>
          </div>
          <br> -->
          <h2>Bank Information</h2>
          <br>
          <!-- Nav pills -->
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#home">Loans</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#menu1">Banks</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#menu2">Cards</a>
            </li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div id="home" class="container tab-pane active"><br>
              <div>
                <table id="tbl_loans_info" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th hidden="true"></th>
                      <th>Loan ID</th>
                      <th>Type of Card</th>
                      <th>Card Number</th>
                      <th>Expiration Date</th>
                      <th>Bank Name</th>
                      <th>Account Number</th>
                      <th>Routing Number</th>
                      <th class="no-sort" style="width:2%"></th>
                    </tr>
                  </thead>
                  <tbody>


                    <?php
                    include('db.php'); // total page minus 1

                    $sql_loan = mysqli_query($con, "select * from commercial_loan_initial_banking where user_fnd_id = '$user_fnd_id'");

                    while ($row_bank_detail_sec = mysqli_fetch_array($sql_loan)) {
                      $initial_id = $row_bank_detail_sec['per_initial_id'];
                      $loan_id = $row_bank_detail_sec['loan_id'];
                      $type_of_id_sec = $row_bank_detail_sec['type_of_id'];
                      $id_photo_sec = $row_bank_detail_sec['pic_of_id'];
                      $type_of_card_sec = $row_bank_detail_sec['type_of_card'];

                      $card_number_sec = $row_bank_detail_sec['card_number'];
                      $card_exp_date_sec = $row_bank_detail_sec['card_exp_date'];
                      $bank_front_sec = $row_bank_detail_sec['bank_front_pic'];

                      $bank_back_sec = $row_bank_detail_sec['bank_back_pic'];
                      $bank_name_sec = $row_bank_detail_sec['bank_name'];
                      $routing_number_sec = $row_bank_detail_sec['routing_number'];

                      $account_number_sec = $row_bank_detail_sec['account_number'];
                      $void_img_sec = $row_bank_detail_sec['void_check_pic'];
                      $cvv_number_sec = $row_bank_detail_sec['cvv_number'];
                      $primary_status = $row_bank_detail_sec['primary_status'];




                      echo "<tr id='idInitial" . $initial_id . "'>
                          <td hidden='true'>" . $initial_id . "</td>
                          <td>" . $loan_id . "</td>
                          <td>" . $type_of_card_sec . "</td>
                          <td>" . $card_number_sec . "</td>
                          <td>" . $card_exp_date_sec . "</td>
                          <td>" . $bank_name_sec . "</td>
                          <td>" . $account_number_sec . "</td>
                          <td>" . $routing_number_sec . "</td>
                          <td style='padding-left:0; padding-right:0'></td>
                            </tr>";
                    }

                    ?>
                    <!-- <td><a href='banking_detail.php?bank_id=$initial_id&fnd_id=$user_fnd_id&id=$id' title='Edit This User'>Edit</a> - 

<a class='remove-box' href='delete_bank_info.php?bank_id=$initial_id&fnd_id=$user_fnd_id&id=$id' title='Delete This User'>Delete</a>

</td> -->
                  </tbody>
                </table>
              </div>
            </div>
            <div id="menu1" class="container tab-pane fade"><br>
              <div>
                <table id="tbl_bank_info" class="display table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th hidden="true"></th>
                      <th>Bank Name</th>
                      <th>Account Number</th>
                      <th>Routing Number</th>
                      <th>Status</th>
                      <th class="no-sort"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    include('db.php'); // total page minus 1
                    $sql_loan = mysqli_query($con, "select * from tbl_bank_info where usr_fnd_id = '$user_fnd_id'");
                    while ($row_bank_detail_sec = mysqli_fetch_array($sql_loan)) {
                      $bank_id = $row_bank_detail_sec['bank_id'];
                      $bank_name = $row_bank_detail_sec['bank_name'];
                      $routing_number = $row_bank_detail_sec['routing_number'];
                      $account_number = $row_bank_detail_sec['account_number'];
                      $is_active = $row_bank_detail_sec['is_active'] == 1 ? "Active" : "Inactive";
                      echo "<tr id='idBank" . $bank_id . "'>
                            <td hidden='true'>" . $bank_id . "</td>
                            <td>" . $bank_name . "</td>
                            <td>" . $account_number . "</td>
                            <td>" . $routing_number . "</td>
                            <td>" . $is_active . "</td>
                            <td style='padding-left:0; padding-right:0'></td>
                              </tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div id="menu2" class="container tab-pane fade"><br>
              <table id="tbl_card_info" class="display table table-bordered table-striped">
                <thead>
                  <tr>
                    <th hidden="true"></th>
                    <th>Type of Card</th>
                    <th>Card Number</th>
                    <th>Expiration Date</th>
                    <th>CVV</th>
                    <th>Status</th>
                    <th class="no-sort" style="width:2%"></th>
                  </tr>
                </thead>
                <tbody>


                  <?php
                  include('db.php'); // total page minus 1

                  $sql_loan = mysqli_query($con, "select * from tbl_bank_cards where user_fnd_id = '$user_fnd_id'");

                  while ($row_bank_detail_sec = mysqli_fetch_array($sql_loan)) {
                    $card_id = $row_bank_detail_sec['id'];
                    $type_of_card = $row_bank_detail_sec['type_of_card'];
                    $card_number = $row_bank_detail_sec['card_number'];

                    $card_exp_date = $row_bank_detail_sec['card_exp_date'];
                    $cvv = $row_bank_detail_sec['cvv_number'];
                    $is_active = $row_bank_detail_sec['is_active'] == 1 ? "Active" : "Inactive";



                    echo "<tr id='idCard" . $card_id . "'>
                          <td hidden='true'>" . $card_id . "</td>
                          <td>" . $type_of_card . "</td>
                          <td>" . $card_number . "</td>
                          <td>" . $card_exp_date . "</td>
                          <td>" . $cvv . "</td>
                          <td>" . $is_active . "</td>

                          <td style='padding-left:0; padding-right:0'></td>

                            </tr>";
                  }

                  ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
      <!-- /#page-content-wrapper -->
      <!-- <td><a href='banking_detail.php?bank_id=$initial_id&fnd_id=$user_fnd_id&id=$id' title='Edit This User'>Edit</a> - 

<a class='remove-box' href='delete_bank_info.php?bank_id=$initial_id&fnd_id=$user_fnd_id&id=$id' title='Delete This User'>Delete</a>
</td> -->
      <!--Delete Modal -->
      <div id="deleteModal" class="modal " role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <div display="none"><i id="idInformation"></i></div>

              <h4 id="deleteTitle" class="modal-title">Delete Bank Info</h4>
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
              <div display="none"><i id="lblBankInfoId"></i></div>
              <div display="none"><i id="lblUserId"></i></div>
            </div>
            <div class="modal-body" style="margin-left:15px">
              <div class="row">
                <div class="col-md-5 col-sm-5 col-lg-5"><label style="text-align:left">Bank Name<mark class="red">*</mark></label></div>
                <div class="col-md-5 col-sm-5 col-lg-5">
                  <!-- <input type="text" style="color:black"  id="lblBankName" /> -->
                  <input list="bank_names" name="bank_names" id="lblBankName" style="width:100%">
                  <datalist id="bank_names">
                    <option value="Bank Of America"></option>
                    <option value="Chase"></option>
                    <option value="Wells Fargo"></option>
                    <option value="Citi Bank "> </option>
                    <option value="US Bank"></option>
                    <option value="HSBC"></option>
                  </datalist>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 col-sm-5 col-lg-5"><label style="text-align:left">Account Number<mark class="red">*</mark></label></div>
                <div class="col-md-5 col-sm-5 col-lg-5"><input type="text" style="color:black" id="lblAccountNumber" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 col-sm-5 col-lg-5"><label style="text-align:left">Rounting Number<mark class="red">*</mark></label></div>
                <div class="col-md-5 col-sm-5 col-lg-5"><input type="text" style="color:black" id="lblRoutingNumber" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 col-sm-5 col-lg-5"><label style="text-align:left">Status</label></div>
                <div class="col-md-5 col-sm-5 col-lg-5">
                  <div id="lstGroups" style=" margin-top:-1px; z-index:1; width: 148px;">
                    <div><input id="idisActiveBankInfo" type="checkbox"><label>Active</label></div>
                  </div>
                </div>
              </div>
              <div class="row" id="error_row">
                <div class="col-md-12 col-sm-12 col-lg-12" style="justify-content: center; display: flex">
                  <label style="text-align: center; color: red" id="lblError"></label>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <label id="newBankInfo" hidden>true</label>
              <button type="button" class="reset" id="btnInsertUpdateBankInfo" onclick="updateBankInfo()">Update</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="type_alert_card" tabindex="-1" aria-labelledby="type_alert_card" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-close-div">
              <div class="cancel modal_close text-center" data-dismiss="modal">
                <i class="fa fa-times"></i>
              </div>
            </div>
            <div class="modal-header">
              <h5 class="modal-title text-center" id="type_alert_title_card"></h5>
              <div display="none"><i id="lblCardInfoId"></i></div>
              <div display="none"><i id="lblUserId"></i></div>
            </div>
            <div class="modal-body" style="margin-left:15px">
              <div class="row">
                <div class="col-md-5 col-sm-5 col-lg-5"><label style="text-align:left">Type of Card<mark class="red">*</mark></label></div>
                <div class="col-md-5 col-sm-5 col-lg-5">
                  <input list="type_of_cards" name="type_of_cards" id="lblTypeOfCard" style="width:100%">
                  <datalist id="type_of_cards">
                    <option value="Visa"></option>
                    <option value="Master Card"></option>
                  </datalist>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 col-sm-5 col-lg-5"><label style="text-align:left">Card Number<mark class="red">*</mark></label></div>
                <div class="col-md-5 col-sm-5 col-lg-5"><input type="text" style="color:black" id="lblCardNumber" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 col-sm-5 col-lg-5"><label style="text-align:left">Expiration Date<mark class="red">*</mark></label></div>
                <div class="col-md-3 col-sm-3 col-lg-3">
                  <input list="months" name="month" id="lblMonth" placeholder="MM" style="width:100%">
                  <datalist id="months">
                    <?php
                    for ($i = 1; $i <= 12; $i++) {
                      $month = sprintf("%02d", $i);
                      echo "<option value='$month'>";
                    }
                    ?>
                  </datalist>
                </div>
                <div class="col-md-3 col-sm-3 col-lg-3">
                  <input list="years" name="year" id="lblYear" placeholder="YY" style="width:100%">
                  <datalist id="years">
                    <?php
                    $current_year = date('y');
                    $next_10_years = $current_year + 10;
                    for ($i = $current_year; $i <= $next_10_years; $i++) {
                      $year = sprintf("%02d", $i);
                      echo "<option value='$year'>";
                    }
                    ?>
                  </datalist>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 col-sm-5 col-lg-5"><label style="text-align:left">CVV<mark class="red">*</mark></label></div>
                <div class="col-md-5 col-sm-5 col-lg-5"><input type="text" style="color:black" id="lblCVV" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 col-sm-5 col-lg-5"><label style="text-align:left">Status</label></div>
                <div class="col-md-5 col-sm-5 col-lg-5">
                  <div id="lstGroups" style=" margin-top:-1px; z-index:1; width: 148px;">
                    <div><input id="idisActiveCardInfo" type="checkbox"><label>Active</label></div>
                  </div>
                </div>
              </div>
              <div class="row" id="error_row_card">
                <div class="col-md-12 col-sm-12 col-lg-12" style="justify-content: center; display: flex">
                  <label style="text-align: center; color: red" id="lblError"></label>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <label id="newCardInfo" hidden>true</label>
              <button type="button" class="reset" id="btnInsertUpdateCardInfo" onclick="updateCardInfo()">Update</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.3.1/dt-1.10.25/b-1.7.1/sl-1.3.3/datatables.min.js"></script>
    <script type="text/javascript" src="js/bankInfoScript.js"></script>
    <script type="text/javascript" src="js/cardInfoScript.js"></script>
    <script type="text/javascript" src="js/loansInfoScript.js"></script>
    <script type="text/javascript" src="js/sharedScript.js"></script>

    <!-- Menu Toggle Script -->
    <script>
      $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
      });
      var deleteMod = null;
      var bankInfoModal = null;
      var cardInfoModal = null;
      $(document).ready(function() {
        deleteMod = new bootstrap.Modal(document.getElementById('deleteModal'), {
          keyboard: false
        });
        bankInfoModal = new bootstrap.Modal(document.getElementById('type_alert'), {
          keyboard: false
        });
        cardInfoModal = new bootstrap.Modal(document.getElementById('type_alert_card'), {
          keyboard: false
        });
      });
    </script>
  <?php
}
  ?>
  </body>

  </html>