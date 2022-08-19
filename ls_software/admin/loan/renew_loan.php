<?php
session_start();
if (!isset($_POST['btn-submit']) && isset($_REQUEST['card_number'])) {
  header("Content-type: application/json");
  //var_dump($_REQUEST);
  include_once '../dbconnect.php';
  include_once '../dbconfig.php';
  $loan_id = $_POST['loanId'];
  $card_number = $_POST['card_number'];
  $sql_bank_detail = mysqli_query($con, "select distinct card_exp_date, cvv_number, type_of_card, bank_name from loan_initial_banking where user_fnd_id = (SELECT user_fnd_id from tbl_loan WHERE loan_id = '$loan_id') and card_number='$card_number'");
  // $type_of_card = '';
  // $renew_year = '';
  // $rerenew_month = '';
  // $cvv_number = '';
  while ($row_bank_detail = mysqli_fetch_array($sql_bank_detail)) {

    $type_of_card = $row_bank_detail['type_of_card'];

    $card_exp_date = $row_bank_detail['card_exp_date'];
    if (date('m/Y', strtotime($card_exp_date)) != date('m/Y', 0)) {
      $card_exp_date = date('m/y', strtotime($card_exp_date));
    }
    $renew_year = str_replace(substr($card_exp_date, 0, 3), '', $card_exp_date);
    $renew_month = str_replace(substr($card_exp_date, 2, 3), '', $card_exp_date);

    $cvv_number = $row_bank_detail['cvv_number'];
    $bank_name = $row_bank_detail['bank_name'];
    break;
  }

  $articles[] = array(
    'type_of_card'         =>  (string)$type_of_card,
    'year'   =>  (string)$renew_year,
    'month' => (string)$renew_month,
    'cvv' => (string)$cvv_number,
    'bank_name' => (string)$bank_name
  );
  echo json_encode($articles);
  die;
  // connection should be on this page  
}
?>

<?php
error_reporting(0);
session_start();
include_once '../dbconnect.php';
include_once '../dbconfig.php';

// if (!isset($_SESSION['userSession'])) {
//   header("Location: ../index.php");
// }

// $query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=" . $_SESSION['userSession']);
// $userRow = $query->fetch_array();
// $u_id = $userRow['user_id'];
// $u_access_id = $userRow['access_id'];
// if ($u_access_id == '2' || $u_access_id == '4' || $u_access_id == '5') {
//   echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
  if(False){
} else {
  $DBcon->close();

?>

  <?php


  $id = $_GET['id'];
  $sql_fnd = mysqli_query($con, "select * from tbl_loan where loan_id = '$id'");

  while ($row_fnd = mysqli_fetch_array($sql_fnd)) {

    $user_fnd_id = $row_fnd['user_fnd_id'];
    //echo "FND_ID" .$user_fnd_id;
  }

  ?>

  <?php



  $sql = mysqli_query($con, "select * from tbl_loan where loan_id= '$id'");

  while ($row = mysqli_fetch_array($sql)) {

    $loan_id = $row['loan_id'];
    $loan_create_id = $row['loan_create_id'];
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

  ?>

  <?php




  $sql_fnd = mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$user_fnd_id'");

  while ($row_fnd = mysqli_fetch_array($sql_fnd)) {

    $first_name = $row_fnd['first_name'];
    $last_name = $row_fnd['last_name'];
    $full_name = $first_name . ' ' . $last_name;
    $email = $row_fnd['email'];
    $mobile_number = $row_fnd['mobile_number'];
    $address = $row_fnd['address'];
    $cityy = $row_fnd['city'];
    $statee = $row_fnd['state'];
    $zipp = $row_fnd['zip_code'];

    $date_of_birth_db = $row_fnd['date_of_birth'];

    $date_of_birth = date('Y-m-d', strtotime($date_of_birth_db));

    $ssn = $row_fnd['ssn'];
    $id_photo = $row_fnd['customer_img'];

    $fnd_dl_code = $row_fnd['dl_code'];
    $decision_logic_status = $row_fnd['decision_logic_status'];
  }

  $sql_bank_detail = mysqli_query($con, "select * from loan_initial_banking where user_fnd_id = '$user_fnd_id' AND loan_id= '$loan_create_id'");

  while ($row_bank_detail = mysqli_fetch_array($sql_bank_detail)) {

    $type_of_id = $row_bank_detail['type_of_id'];
    $id_photo = $row_bank_detail['pic_of_id'];
    $type_of_card = $row_bank_detail['type_of_card'];

    $card_number = $row_bank_detail['card_number'];
    $card_exp_date = $row_bank_detail['card_exp_date'];
    $bank_front = $row_bank_detail['bank_front_pic'];

    $bank_back = $row_bank_detail['bank_back_pic'];
    $bank_name = $row_bank_detail['bank_name'];
    $routing_number = $row_bank_detail['routing_number'];

    $account_number = $row_bank_detail['account_number'];
    $void_img = $row_bank_detail['void_check_pic'];
    $cvv_number = $row_bank_detail['cvv_number'];
  }


  ?>


  <!-----------------------------Decision Logic API Starts------------------------------------------------------------>

  <?php

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://integration.decisionlogic.com/integration-v2.asmx",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">\r\n  <soap:Body>\r\n    <GetMultipleReportDetailsFromRequestCode7 xmlns=\"https://integration.decisionlogic.com\">\r\n      <serviceKey>DN2YYREQ9DPQ</serviceKey>\r\n      <requestCode>$fnd_dl_code</requestCode>\r\n    </GetMultipleReportDetailsFromRequestCode7>\r\n  </soap:Body>\r\n</soap:Envelope>",
    CURLOPT_HTTPHEADER => array(
      "cache-control: no-cache",
      "content-type: text/xml; charset=utf-8",
      "host: integration.decisionlogic.com",
      "postman-token: 656d6424-254f-0521-fabb-3e0fe463fc5d",
      "soapaction: https://integration.decisionlogic.com/GetMultipleReportDetailsFromRequestCode7"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    //echo $response;
  }



  $dom = new DOMDocument();
  $dom->loadXML($response);
  $hotels = $dom->getElementsByTagName('ReportDetail5');

  foreach ($hotels as $hotel) {
    $DL_available_overdraft = $hotel->getElementsByTagName('TotalCount')->item(4)->nodeValue;
    $DL_available_balance = $hotel->getElementsByTagName('AvailableBalance')->item(0)->nodeValue;
    $DL_totalamount = $hotel->getElementsByTagName('TotalAmount')->item(0)->nodeValue;
    $DL_totalamount_loan = $hotel->getElementsByTagName('TotalAmount')->item(3)->nodeValue;
    $DL_as_date = $hotel->getElementsByTagName('AsOfDate')->item(0)->nodeValue;
    $DL_current_balance = $hotel->getElementsByTagName('CurrentBalance')->item(0)->nodeValue;
    $DL_average_balance = $hotel->getElementsByTagName('AverageBalance')->item(0)->nodeValue;

    $DL_deposits_credit = $hotel->getElementsByTagName('TotalCredits')->item(0)->nodeValue;
    $DL_avg_balance_last_month = $hotel->getElementsByTagName('AverageBalanceRecent')->item(0)->nodeValue;

    $DL_withdrawals = $hotel->getElementsByTagName('TotalDebits')->item(0)->nodeValue;
    break;
  }
  ?>






  <!-----------------------------Decision Logic API END--------------------------------------------------------------->










  <!DOCTYPE html>
  <html lang="en">

  <head>

    <style>
      .buttonHolder {
        text-align: left;
        margin-left: 15px;
      }

      table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
      }

      td,
      th {
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

    <style>
      .timeTextBox {
        margin-top: -116px;
        margin-left: 2px;
        height: 32px;
        width: 90%;
        border: none;
        position: relative;
        left: 10px;
        top: -31px;
      }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script>
      $(document).ready(function() {

        $(".editableBox").change(function() {
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

          <div class="col-lg-4">
            <p>Customer First Name:<b style="color:red"> <?php echo $first_name; ?></b></p>
          </div>
          <div class="col-lg-4">
            <p>Customer Last Name: <b style="color:red"><?php echo $last_name; ?> </b></p>
          </div>
          <div class="col-lg-4">
            <p>Customer Phone:<b style="color:red"> <?php echo $mobile_number; ?> </b> </p>
          </div>
          <div class="col-lg-4">
            <p>Loan Date:<b style="color:red"> <?php echo $new_creation_date; ?> </b></p>
          </div>
          <div class="col-lg-4">
            <p>Money Amount: <b style="color:red"> <?php echo $val . $amount_loan . $variable; ?></b></p>
          </div>
          <div class="col-lg-4">
            <p>Created By:<b style="color:red"> <?php echo $username; ?> </b> </p>
          </div>


        </div>

        <br><br>

        <div class="container-fluid">

          <h3>Renewal Loan Details: </h3><br>

          <div class="col-lg-12">

            <form action="" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <div class="row">
                  <div class="col-lg-6">
                    <label for="usr">First Name</label>
                    <input type="text" name="full_name" class="form-control" id="usr" placeholder="Full Name" value="<?php echo $first_name; ?>">
                  </div>

                  <div class="col-lg-6">
                    <label for="usr">Last Name</label>
                    <input type="text" name="last_name" class="form-control" id="usr" placeholder="Full Name" value="<?php echo $last_name; ?>">
                  </div>

                  <div class="col-lg-6">
                    <label for="usr">Phone Number</label>
                    <input type="text" name="ph_numbr" class="form-control" id="usr" placeholder="Phone Number" value="<?php echo $mobile_number; ?>">
                  </div>

                  <div class="col-lg-6">
                    <label for="usr">Email Address</label>
                    <input type="text" name="email" class="form-control" id="usr" placeholder="Email Address" value="<?php echo $email; ?>">
                  </div>

                  <div class="col-lg-6">
                    <label for="usr">Address</label>
                    <input type="text" name="p_address" class="form-control" id="usr" placeholder="Primary Address" value="<?php echo $address; ?>">
                  </div>

                  <div class="col-lg-2">
                    <label for="usr">City</label>
                    <input type="text" name="city" class="form-control" id="usr" value="<?php echo $cityy; ?>">
                  </div>

                  <div class="col-lg-2">
                    <label for="usr">State</label>
                    <input type="text" name="state" class="form-control" id="usr" value="<?php echo $statee; ?>">
                  </div>

                  <div class="col-lg-2">
                    <label for="usr">Zip Code</label>
                    <input type="text" name="zip" class="form-control" id="usr" value="<?php echo $zipp; ?>">
                  </div>

                  <div class="col-lg-6">
                    <label for="usr">Date of Birth</label>
                    <input type="date" name="dob" class="form-control" id="usr" placeholder="Date of Birth" value="<?php echo $date_of_birth; ?>">
                  </div>

                  <div class="col-lg-6">
                    <label for="usr">SSN</label>
                    <input type="text" name="ssn" class="form-control" id="usr" placeholder="SSN" value="<?php echo $ssn; ?>">
                  </div>







                  <div class="col-lg-6">
                    <label for="usr">Type of ID & Number</label>
                    <select name="type_id" id="type_id" class="form-control" value="">
                      <option></option>
                      <option value="Drivers License" <?php if ($type_of_id == 'Drivers License') {
                                                        echo 'selected';
                                                      } ?>>Drivers License</option>
                      <option value="State Personal ID" <?php if ($type_of_id == 'State Personal ID') {
                                                          echo 'selected';
                                                        } ?>>State Personal ID</option>
                      <option value="Matricula Consular ID" <?php if ($type_of_id == 'Matricula Consular ID') {
                                                              echo 'selected';
                                                            } ?>>Matricula Consular ID</option>
                      <option value="Tribal ID" <?php if ($type_of_id == 'Tribal ID') {
                                                  echo 'selected';
                                                } ?>>Tribal ID</option>
                      <option value="Passport" <?php if ($type_of_id == 'Passport') {
                                                  echo 'selected';
                                                } ?>>Passport</option>
                      <option value="Military ID" <?php if ($type_of_id == 'Military ID') {
                                                    echo 'selected';
                                                  } ?>>Military ID</option>
                      <option value="Other" <?php if ($type_of_id == 'Other') {
                                              echo 'selected';
                                            } ?>>Other</option>
                    </select>
                  </div>
                </div>
                <br>
                <hr>
                <div class="row">
                  <div class="col-lg-6">
                    <span style="font-weight:bold">Banking Information: </span><br>
                  </div>

                  <div class="col-lg-6">
                  </div>

                  <div class="col-lg-6">
                    <label for="usr">Type of ID</label>
                    <select name="type_id" id="type_id" class="form-control" value="">
                      <option></option>
                      <option value="Drivers License" <?php if ($type_of_id == 'Drivers License') {
                                                        echo 'selected';
                                                      } ?>>Drivers License</option>
                      <option value="State Personal ID" <?php if ($type_of_id == 'State Personal ID') {
                                                          echo 'selected';
                                                        } ?>>State Personal ID</option>
                      <option value="Matricula Consular ID" <?php if ($type_of_id == 'Matricula Consular ID') {
                                                              echo 'selected';
                                                            } ?>>Matricula Consular ID</option>
                      <option value="Tribal ID" <?php if ($type_of_id == 'Tribal ID') {
                                                  echo 'selected';
                                                } ?>>Tribal ID</option>
                      <option value="Passport" <?php if ($type_of_id == 'Passport') {
                                                  echo 'selected';
                                                } ?>>Passport</option>
                      <option value="Military ID" <?php if ($type_of_id == 'Military ID') {
                                                    echo 'selected';
                                                  } ?>>Military ID</option>
                      <option value="Other" <?php if ($type_of_id == 'Other') {
                                              echo 'selected';
                                            } ?>>Other</option>
                    </select>
                  </div>

                  <div class="col-lg-6">
                    <label for="type_card">Type of Card</label>
                    <input type="text" name="type_card" class="form-control" id="type_card" value="<?php echo $type_of_card; ?>" readonly>
                    <!-- <select name="type_card" id="type_card" class="form-control"  value="" readonly>
     <option></option>
     <option value="Visa" <?php if ($type_of_card == 'Visa') {
                            echo 'selected';
                          } ?>>Visa</option>
      <option value="Master Card" <?php if ($type_of_card == 'Master Card') {
                                    echo 'selected';
                                  } ?>>Master Card</option>
     </select> -->
                  </div>



                  <div class="col-lg-6">
                    <label for="card_exp_date">Card Expiration Date</label>
                    <input type="text" name="card_exp_date" class="form-control" id="card_exp_date" value="<?php echo $card_exp_date; ?>">
                  </div>

                  <div class="col-lg-6">
                    <label for="card_number">Card Number</label>
                    <select name="card_number" id="card_number" class="form-control" value="" required>
                      <?php
                      $sql_card_details = mysqli_query($con, "SELECT DISTINCT card_number FROM `loan_initial_banking` WHERE user_fnd_id = '$user_fnd_id'");

                      while ($row_bank_detail = mysqli_fetch_array($sql_card_details)) {

                        $card_number_from_list = $row_bank_detail['card_number'];
                        $selected = "";
                        if ($card_number_from_list == $card_number) {
                          $selected = "selected";
                        }

                        echo "<option value='$card_number_from_list' $selected>$card_number_from_list</option>";
                      }

                      ?>
                    </select><br>
                  </div>


                  <div class="col-lg-6">
                    <label for="bank_name">Bank Name</label>
                    <!-- <select name="bank_name" id="bank_name" class="form-control"  value="" >
     <option></option>
     <option value="Bank Of America" <?php if ($bank_name == 'Bank Of America') {
                                        echo 'selected';
                                      } ?>>Bank Of America</option>
     <option value="Chase" <?php if ($bank_name == 'Chase') {
                              echo 'selected';
                            } ?>>Chase</option>
     <option value="Wells Fargo" <?php if ($bank_name == 'Wells Fargo') {
                                    echo 'selected';
                                  } ?>>Wells Fargo</option>
     <option value="Citi Bank " <?php if ($bank_name == 'Citi Bank') {
                                  echo 'selected';
                                } ?>>Citi Bank </option>
     <option value="US Bank" <?php if ($bank_name == 'US Bank') {
                                echo 'selected';
                              } ?>>US Bank</option>
     <option value="HSBC" <?php if ($bank_name == 'HSBC') {
                            echo 'selected';
                          } ?>>HSBC</option>
     </select> -->
                    <input type="text" class="form-control" name="bank_name" id="bank_name" value="<?php echo $bank_name; ?>" readonly />
                  </div>

                  <div class="col-lg-6">
                    <label for="usr">Routing Number</label>
                    <input type="text" name="routing_number" class="form-control" id="usr" value="<?php echo $routing_number; ?>">
                  </div>

                  <div class="col-lg-6">
                    <label for="usr">Account Number</label>
                    <input type="text" name="account_number" class="form-control" id="usr" value="<?php echo $account_number; ?>"><br>
                  </div>


                  <div class="col-lg-6">
                    <label for="cvv_number">CVV Number</label>
                    <input type="text" name="cvv_number" class="form-control" id="cvv_number" value="<?php echo $cvv_number; ?>" readonly>
                  </div>

                </div>
                <br>
                <hr>

                <div class="row">
                  <div class="col-lg-6">
                    <?php

                    echo "<h3>Decision Logic Details($fnd_dl_code)</h3>";
                    ?>
                  </div>
                  <div class="col-lg-6">
                    <br><b style="font-size: 20px;">
                      <?php if ($decision_logic_status == 1) {
                        echo
                        '<span class="glyphicon glyphicon-ok-circle" aria-hidden="true" alt="Verified">
</span>  
<span style = "color:green; text-align:left">Decision Logic Verified</span>';
                      }
                      ?>
                    </b>
                  </div>

                  <div class="col-lg-6">
                    <label for="usr">DL Code</label>
                    <input type="text" name="dl_code" class="form-control" id="usr" value="<?php echo $fnd_dl_code; ?>" disabled>
                  </div>

                </div>
              </div>
              <div class="row">

                <table>
                  <tr>
                    <th></th>
                    <th></th>
                  </tr>
                  <tr>
                    <td>
                      <span style="color:red">Available Balance :</span><b> $<?php echo  number_format((float)$DL_available_balance, 2, '.', ''); ?></b>
                    </td>

                    <td>

                      <span style="color:red">As of Date</span> : <b> <?php echo $DL_as_date; ?></b>

                    </td>
                  </tr>

                  <tr>
                    <td>
                      <span style="color:red">Current Balance</span> : <b> $<?php echo  number_format((float)$DL_current_balance, 2, '.', ''); ?></b>
                    </td>

                    <td>

                      <span style="color:red">Average Balance</span> : <b> $<?php echo  number_format((float)$DL_average_balance, 2, '.', ''); ?></b>


                    </td>
                  </tr>
                  <tr>
                    <td>

                      <span style="color:red"> Total Amount PAYROLL</span> :<b> $<?php echo  number_format((float)$DL_totalamount, 2, '.', ''); ?></b>


                    </td>
                    <td>


                      <span style="color:red"> Over Draft (ov)</span> : <b><?php echo  $DL_available_overdraft; ?></b>

                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span style="color:red">Deposits/Credits</span> : <b> $<?php echo  number_format((float)$DL_deposits_credit, 2, '.', ''); ?></b>
                    </td>
                    <td>
                      <span style="color:red">Avg Bal Latest Month</span> : <b> $<?php echo  number_format((float)$DL_avg_balance_last_month, 2, '.', ''); ?></b>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span style="color:red">Withdrawals/Debits</span> : <b> $<?php echo  number_format((float)$DL_withdrawals, 2, '.', ''); ?></b>
                    </td>
                    <td></td>
                  </tr>

                </table>




              </div>

          </div>
          <br><br>
          <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: white;background-color: #1E90FF;border-radius: 0px;border-color: #1E90FF;">Update Information</button>
          <a href="../add_new_loan.php?id=<?php echo $user_fnd_id; ?>&loan_amount=<?php echo $loan_amount; ?>&name=<?php echo $first_name; ?>&ssn=<?php echo $ssn; ?>&loan_id=<?php echo $loan_create_id; ?>&renew_status=<?php echo "1"; ?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%); 
    color: #fff;
    background-color: #2a8206;
    border-color: #112f01;" target="_blank">Create a Loan</button> </a>
          </form>
        </div>
      </div>
    </div>
    <!-- /#page-content-wrapper -->

    </div>
    <?php
    if (isset($_POST['btn-submit'])) {


      $first_name_update = $_POST['full_name'];
      $last_name_update = $_POST['last_name'];
      $phone_number_update = $_POST['ph_numbr'];
      $email_update = $_POST['email'];
      $address_update = $_POST['p_address'];
      $city_update = $_POST['city'];
      $state_update = $_POST['state'];
      $zip_update = $_POST['zip'];

      $dob_update = $_POST['dob'];
      $ssn_update = $_POST['ssn'];

      $type_id_up = $_POST['type_id'];
      $type_card_up = $_POST['type_card'];
      $card_number_up = $_POST['card_number'];
      $card_exp_date_up = $_POST['card_exp_date'];
      $bank_name_up = $_POST['bank_name'];
      $routing_number_up = $_POST['routing_number'];
      $account_number_up = $_POST['account_number'];
      $cvv_number_up = $_POST['cvv_number'];


      $date = date('Y-m-d H:i:s');




      mysqli_query($con, "UPDATE fnd_user_profile SET first_name ='$first_name_update', last_name='$last_name_update', mobile_number='$phone_number_update', email='$email_update', address='$address_update', city='$city_update', state='$state_update', zip_code='$zip_update', date_of_birth='$dob_update', ssn='$ssn_update' where user_fnd_id ='$user_fnd_id'");


      mysqli_query($con, "UPDATE loan_initial_banking SET type_of_id='$type_id_up', type_of_card='$type_card_up', card_number='$card_number_up', card_exp_date='$card_exp_date_up', bank_name='$bank_name_up', routing_number='$routing_number_up', account_number='$account_number_up', cvv_number='$cvv_number_up' where user_fnd_id ='$user_fnd_id'  AND loan_id= '$loan_create_id'");

    ?>
      <script type="text/javascript">
        window.location.href = 'renew_loan.php?id=<?php echo $id; ?>';
      </script>
    <?php
    }
    ?>
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

  <script type="text/javascript">
    $(document).ready(function() {
      $('#card_number').change(function() {
        $.post(window.location.pathname, {
          card_number: $(this).val(),
          loanId: <?php echo $_GET['id']; ?>
        }, function(response) {
          let type_of_card = response[0].type_of_card;
          let year = response[0].year;
          let month = response[0].month;
          let cvv = response[0].cvv;
          let bank_name = response[0].bank_name;

          $("#type_card").val(type_of_card);
          $("#card_exp_date").val(month + '/' + year);
          $("#cvv_number").val(cvv);
          $("#bank_name").val(bank_name);
        });
      });
    });
  </script>