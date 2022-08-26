<?php
session_start();
include_once 'dbconnect.php';
include_once 'dbconfig.php';

if (!isset($_SESSION['userSession'])) {
  header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=" . $_SESSION['userSession']);
$userRow = $query->fetch_array();
$u_id = $userRow['user_id'];
//echo $u_id;
$u_access_id = $userRow['access_id'];
if ($u_access_id == '0') {
  echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
}


$fnd_idd = $_GET['id'];
//$name_id = $_POST['keyword'];
//echo "<br><br><br><br><br><br><br><br><br><br>Name Is: $name_id";
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Welcome - <?php echo $userRow['email']; ?></title>

  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">

  <link rel="stylesheet" href="style.css" type="text/css" />

  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
  <script src="../website/js/slick-loader.min.js"></script>
  <link rel="stylesheet" href="../website/css/slick-loader.min.css" />
  <style>
    .wrapper {
      width: 100%;
      max-width: 1330px;
      margin: 20px auto 100px auto;
      padding: 0;
      position: relative;
    }
  </style>
</head>

<body>

  <?php include('menu.php'); ?>

  <div class="container wrapper" style="margin-top:50px">

    <div class="row wrapper">
      <?php

      $id = $_GET['id'];
      $loan_name = $_GET['loan'];
      $previous_loan_create_id = $_GET['loan_create_id'];

      include 'dbconnect.php';
      include 'dbconfig.php';


      $sql_apr = mysqli_query($con, "SELECT MAX(loan_create_id)+1 as next_id from tbl_commercial_loan");
      while ($row_apr = mysqli_fetch_array($sql_apr)) {
        $next_loan_id = $row_apr['next_id'];
      }
      //echo '<script type="text/javascript">alert("Loan ID ' . $loan_create_id . ' is exists. LoanID well be regerated to '.$next_loan_id.')</script>';
      $loan_create_id = $next_loan_id;
      $sql_apr = mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$id'");

      while ($row_apr = mysqli_fetch_array($sql_apr)) {
        $apr_date = $row_apr['apr'];

        $first_name = $row_apr['first_name'];
        $last_name = $row_apr['last_name'];
        $customer_name = $first_name . ' ' . $last_name;
        $email = $row_apr['email'];
        $mobile_number = $row_apr['mobile_number'];
        $address = $row_apr['address'];
        $city = $row_apr['city'];
        $state = $row_apr['state'];
        $zip_code = $row_apr['zip_code'];
        $date_of_birth = $row_apr['date_of_birth'];
        $date_ofbirth = date("m-d-y", strtotime($date_of_birth));
        $ssn = $row_apr['ssn'];



        //echo $apr_date;

      }

      // $sql1 = mysqli_query($con, "SELECT  From business_group WHERE bg_name= '$loan_name'");
      // $row1 = mysqli_num_rows($sql1);

      // while ($row1 = mysqli_fetch_array($sql1)){

      // $portfolio = $row1['bg_name'];
      // }



      ?>
      <h4 style="text-align:center">Creation Of New Installment Loan for Customer : <span style="color:red;font-weight:bold;"><?php echo $customer_name; ?></span> </h4>
      <h4 style="text-align:center">Customer ID : <span style="color:red;font-weight:bold;"><?php echo $id; ?></span> </h4>

      <div class="row wrapper" style="background-color: #F5E09E;color: white;padding:40px;">
        <div class="col-lg-3">
          <p style="color:black;">Customer Name:<b style="color:red"> <?php echo $customer_name; ?></b></p>
        </div>
        <div class="col-lg-3">
          <p style="color:black;">Customer Phone:<b style="color:red"> <?php echo $mobile_number; ?></b></p>
        </div>
        <div class="col-lg-3">
          <p style="color:black;">Customer Email:<b style="color:red"> <?php echo $email; ?></b></p>
        </div>
        <div class="col-lg-3">
          <p style="color:black;">Customer Address: <b style="color:red"> <?php echo $address; ?> </b> </p>
        </div>
        <div class="col-lg-3">
          <p style="color:black;">Customer City:<b style="color:red"> <?php echo $city; ?></b></p>
        </div>
        <div class="col-lg-3">
          <p style="color:black;">Customer State:<b style="color:red"> <?php echo $state; ?></b></p>
        </div>
        <div class="col-lg-3">
          <p style="color:black;">Customer SSN:<b style="color:red"> <?php echo $ssn; ?></b></p>
        </div>
        <div class="col-lg-3">
          <p style="color:black;">Customer DOB:<b style="color:red"> <?php echo $date_ofbirth; ?></b></p>
        </div>
      </div>

      <table>
        <thead>

        </thead>
      </table>

      <form method="POST" enctype="multipart/form-data" onsubmit="return calculate(event)">

        <div class="row">
          <div class="col-lg-3">
            <label for="usr">Portfolio</label>
            <select name="source" id="source" class="form-control" value="" onchange="yesnoCheck(this);">
              <option value="Payday Loans" <?php if ($loan_name == 'Payday Loans') {
                                              echo 'selected';
                                            } ?>>Payday Loans</option>
              <option value="Title Loans" <?php if ($loan_name == 'Title Loans') {
                                            echo 'selected';
                                          } ?>>Title Loans</option>
              <option value="Personal Loans" <?php if ($loan_name == 'Personal Loans') {
                                                echo 'selected';
                                              } ?>>Personal Loans</option>
              <option value="Commercial Loan" <?php if ($loan_name == 'Commercial Loan') {
                                                echo 'selected';
                                              } ?>>Commercial Loan</option>

            </select>
          </div>
          <div class="col-lg-3">
            <label for="usr">Secondary Portfolio</label>
            <select name="p_portfolio" id="p_portfolio" class="form-control" value="">
              <option value="None">None</option>
              <option value="Pacifica Finance Group" >Pacifica Finance Group</option>
            </select>
          </div>
          <div class="col-lg-6">
            <label for="usr"> Loan ID <i id="error_message_id"></i></label>
            <input type="text" name="loan_id" value="<?php echo  $loan_create_id; ?>" onchange="validate_loan_id(event,this)" class="form-control" required/>
            <input type="text" name="previous_loan_id" value="<?php echo  $previous_loan_create_id; ?>" style="display:none" />
          </div>


          <div class="col-lg-6" id="ifNo">
            <label for="usr">Loan Amount</label>
            <input type="number" name="principal" onchange="calculate_minimal_payment(event)" class="form-control" id="usr" placeholder="" value="" Required>
          </div>

          <div class="col-lg-3">
            <label for="usr">Late Fee</label>
            <input type="number" name="late_fee" class="form-control" id="usr" placeholder="" value="">
          </div>

          <div class="col-lg-3">
            <label for="usr">Origination/Contract Fee</label>
            <input type="number" name="origination" class="form-control" id="usr" placeholder="" value="">
          </div>


          <!-- <div class="col-lg-3">
            <label for="usr">Years</label>
            <input type="number" name="years" class="form-control" id="usr" step="any" placeholder="" value="" Required>
          </div> -->





          <div class="col-lg-6">
            <label for="usr">Installment Plan</label>
            <select name="installment_plan" id="installment_plan" onchange="calculate_payment_start_date(event, this)" class="form-control" value="" Required>
              <option value=""></option>
              <option value="Weekly">Weekly</option>
              <option value="Bi-Weekly">Bi-Weekly</option>
              <option value="Monthly">Monthly</option>

            </select>
          </div>

          <div class="col-lg-6">
            <label for="usr">Select State</label>
            <select name="state" id="state" class="form-control" value="">
              <option value=""></option>
              <option value="CA">California</option>
            </select>
          </div>

          <div class="col-lg-6">
            <label for="usr">Total Number of Payments</label>
            <input type="number" name="total_payments" onchange="calculate_minimal_payment(event)" class="form-control" id="usr" placeholder="" value="" Required>
          </div>
          <div class="col-lg-6">
            <label for="usr">Payment</label>
            <input type="number" step="0.01" name="payment" class="form-control" id="usr" placeholder="" value="" Required>
          </div>

          <div class="col-lg-6">
            <label for="usr">Contract Start Date</label>
            <input type="date" name="contract_date" class="form-control" id="usr" placeholder="YYYY/MM/DD" value="<?php $date = date('Y-m-d');
                                                                                                                  echo $date; ?>">
          </div>

          <div class="col-lg-6">
            <label for="payment_start_date">Payment Start Date</label>
            <input type="date" name="payment_start_date" class="form-control" id="payment_start_date" placeholder="YYYY/MM/DD" value="<?php $date = date('Y-m-d');
                                                                                                                                      echo $date; ?>">
          </div>

          <div class="col-lg-6">
            <label for="usr">APR %</label>
            <input type="text" name="apr" class="form-control" id="apr" placeholder="" value="" >
          </div>

          <div class="col-lg-6">
            <label for="usr">Muturity Date</label>
            <input type="input" name="payment_date" class="form-control" id="usr" placeholder="DD/MM/YYYY" readonly>
          </div>
        </div>

        <br>




        <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;">Calculate/Save</button>
      </form>

    </div>
    <div id="tablePayments" class="row wrapper">

    </div>

  </div>
  <hr>

</body>

</html>

<script type="text/javascript">
  function calculate_minimal_payment(e) {
    let principal = document.getElementsByName("principal")[0].value;
    let total_payments = document.getElementsByName("total_payments")[0].value;
    let payment = document.getElementsByName("payment")[0]
    if (principal == "" || total_payments == "") { //
      payment.placeholder = "";

      e.preventDefault();
      e.stopPropagation();
      return;
    }

    let minOnePayment = parseFloat(principal) / parseInt(total_payments);
    payment.placeholder = "Minimal payment is " + minOnePayment;


    e.preventDefault();
    e.stopPropagation();
  }

  function getFormattedDate(date) {
    let year = date.getFullYear();
    let month = (1 + date.getMonth()).toString().padStart(2, '0');
    let day = date.getDate().toString().padStart(2, '0');

    return year + '-' + month + '-' + day;
  }

  function calculate_payment_start_date(e, elem) {
    let contract_date = document.getElementsByName("contract_date")[0].value;
    let payment_start_date = document.getElementsByName("payment_start_date");
    var chooseDate = new Date(contract_date);

    let count_add_days = 0;
    switch (elem.value) {
      case "Weekly":
        payment_start_date[0].value = getFormattedDate(new Date(chooseDate.setDate(chooseDate.getDate() + 7)));
        break;
      case "Bi-Weekly":
        payment_start_date[0].value = getFormattedDate(new Date(chooseDate.setDate(chooseDate.getDate() + 14)));
        break;
      case "Monthly":
        payment_start_date[0].value = getFormattedDate(new Date(chooseDate.setDate(chooseDate.getDate() + 30)));
        break;
    }

    e.preventDefault();
  }



  function recalculateDirectlyLoan(e, elem, balance) {
    directly_loan = document.getElementById("directlyLoanId");
    directly_loan.innerText = balance - elem.value;
    document.getElementById("comInitSetupHref").href = document.getElementById("comInitSetupHref").href.replace("in_hand=" + elem.oldvalue, "in_hand=" + elem.value);
    e.preventDefault();
  }

  function validate_loan_id(e,elem){
    let id = elem.value;
    var url = 'functions_commercial_loan.php';

    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: {
            'func': "ValidateLoanId",
            'id': id
        },
        async: true,
        success: function(data) {
            //var tableCard = data[0].cardTable;
            var valid = data[0].valid;
            var message = "Valid Loand Id"
            if (!valid){
              elem.value = "";
              message = "Loan ID: " + id + " exists in DB"  
            }
            document.getElementById("error_message_id").value = message;
            document.getElementById("error_message_id").innerHTML = message;
            document.getElementById("error_message_id").innerText = message;
            event.preventDefault();

        },
        error: function(err) {
            if (err.responseText == "") {
                alert(err.responseText);
            } else {
                alert(err.responseText);
            }
            window.location.reload();
        }
    });
  }

  function calculate(e) {
    var formData = new FormData(document.querySelector('form'));

    formData.append("fnd_id", <?php echo $fnd_idd; ?>);
    var source = formData.get('source');
    let loan_create_id = formData.get('loan_id');
    let principal_amount = formData.get('principal');
    //let interest = formData.get('interest');
    let years = formData.get('years');
    let late_fee = formData.get('late_fee');
    let installment_plan = formData.get('installment_plan');
    let total_payments = formData.get('total_payments');
    let contract_date = formData.get('contract_date');
    let payment_date = formData.get('payment_date');
    let state_arizona = formData.get('state');
    let payment = formData.get('payment');

    let minOnePayment = parseFloat(principal_amount) / parseInt(total_payments);
    if (payment < minOnePayment) {
      $("#tablePayments")[0].innerHTML = `
                <p style="text-align:center;color:red;font-size:20px">
                  <b>Minimal payment should be more than ` + minOnePayment + `<b>
                </p>
                `;
      e.preventDefault();
      return;
    }

    SlickLoader.enable();

    $.ajax({
      url: 'calculated_commercial_loan.php',
      data: formData,
      contentType: false,
      cache: false,
      processData: false,
      type: 'POST',
      success: function(response) {
        var data = $.parseJSON(response);
        let apr = data[0].apr;
        let table = String(data[0].table);
        let last_payment = data[0].last_payment;
        document.getElementsByName("apr")[0].value = apr;
        document.getElementsByName("payment_date")[0].value = last_payment;
        $("#tablePayments")[0].innerHTML = table;

        SlickLoader.disable();
      },
      error: function(error) {
        SlickLoader.disable();
      }
    });
    //$apr=str_replace("%","","$apr");
    e.preventDefault();
  }
</script>