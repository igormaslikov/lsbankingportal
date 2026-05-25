<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
error_reporting(0);
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


$fnd_idd = $_GET['id'] ?? '';
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
    /* ==== Layer-B scoped styles for add_commercial_loan ==== */
    section.wrapper, .container.wrapper { padding: 0 20px 40px; max-width: 1400px; margin: 0 auto; }
    .container.wrapper { margin-top: 100px !important; }

    /* Page toolbar */
    .acl-toolbar {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 16px; padding-bottom: 10px; border-bottom: 1px solid #eee;
    }
    .acl-page-title { font-size: 22px; font-weight: 600; color: #333; margin: 0; }
    .acl-page-title small { color: #888; font-weight: normal; }

    /* Customer summary card (replaces the yellow #F5E09E banner) */
    .acl-summary {
        background: #fff;
        border: 1px solid #e4e4e4;
        border-left: 4px solid #1E90FF;
        border-radius: 4px;
        padding: 14px 20px;
        margin-bottom: 18px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04);
    }
    .acl-summary p { margin: 4px 0; color: #555; font-size: 13px; }
    .acl-summary strong { display: block; color: #888; font-size: 11px; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 2px; font-weight: 600; }
    .acl-summary b { color: #222; font-weight: 600; }

    /* Panels */
    .acl-panel { margin-bottom: 14px; }
    .acl-panel .panel-heading { padding: 10px 15px; background-color: #fafafa; font-weight: 600; }
    .acl-required-hint { font-size: 11px; color: #888; font-weight: normal; }
    .acl-panel .panel-body { padding: 16px; }

    /* Form fields — min-height ensures uneven help-text heights don't break grid wrap */
    .acl-field { margin-bottom: 14px; min-height: 76px; }
    .acl-field label {
        font-size: 12px; color: #555; font-weight: 600;
        text-transform: uppercase; letter-spacing: .3px; margin-bottom: 4px;
        display: block;
    }
    .acl-req { color: #d9534f; margin-left: 2px; }
    .acl-help { font-size: 11px; color: #888; margin-top: 4px; display: block; }

    /* Action bar */
    .acl-action-bar {
        margin-top: 18px; padding: 14px 18px;
        background: #fafafa;
        border: 1px solid #e4e4e4;
        border-radius: 4px;
        text-align: right;
    }
    .acl-action-bar .btn { margin-left: 6px; }
    .acl-action-bar .btn-calc {
        background: #1E90FF; border-color: #1E90FF; color: #fff;
        font-weight: 600; padding: 8px 22px;
    }
    .acl-action-bar .btn-calc:hover { background: #1976c2; border-color: #1976c2; color: #fff; }

    /* Neutralize global dark .row:hover from css/style1.css */
    section.wrapper .row, section.wrapper .row:hover,
    .container.wrapper .row, .container.wrapper .row:hover {
        background-color: transparent !important;
        height: auto !important;
        border-top: 0 !important;
        transition: none !important;
    }

    /* Payment schedule container */
    #tablePayments { margin-top: 20px; }

    /* Error message next to the loan ID field */
    #error_message_id { font-size: 12px; font-style: normal; margin-left: 6px; }
  </style>
</head>

<body>

  <?php include('menu.php'); ?>

  <div class="container wrapper">

    <!-- PHP data block: unchanged from original -->
    <?php
    $id = $_GET['id'] ?? '';
    $loan_name = $_GET['loan'] ?? '';
    $previous_loan_create_id = $_GET['loan_create_id'] ?? '';

    include 'dbconnect.php';
    include 'dbconfig.php';
    $portfolio_type = "OF1";

    // SQL Server: SUBSTRING(col, start, length) and CAST(... AS INT). MySQL's
    // SUBSTRING(col FROM N) and CAST AS UNSIGNED are not valid in T-SQL.
    $query_string = "SELECT CONCAT('$portfolio_type','-',(MAX(CAST(SUBSTRING(loan_create_id, 5, LEN(loan_create_id)) AS INT))+1)) as next_id from tbl_commercial_loan where portfolio_type = '$portfolio_type'";
    $default_loan_id = $portfolio_type . "-10001";
    if ($portfolio_type == "OF1") {
        $count_non_portfolio = 0;
        $sql_count_non_portfolio = $con->query("SELECT COUNT(loan_id) as cnt from tbl_commercial_loan WHERE portfolio_type = '$portfolio_type'");
        while ($row_apr = $sql_count_non_portfolio->fetch_array()) {
            $count_non_portfolio = $row_apr['cnt'];
        }
        if ($count_non_portfolio == 0) {
            $query_string = "SELECT CONCAT('$portfolio_type','-',(MAX(CAST(SUBSTRING(loan_create_id, 3, LEN(loan_create_id)) AS INT))+1)) as next_id from tbl_commercial_loan where portfolio_type = ''";
        }
    }
    $next_loan_id = NULL;
    $sql_apr = $con->query($query_string);
    while ($row_apr = $sql_apr->fetch_array()) {
        $next_loan_id = $row_apr['next_id'];
    }
    // SQL Server CONCAT() treats NULL as empty string; "OF3-" can come back
    // when there are no existing rows. Fall back unless result ends in digits.
    $loan_create_id = (empty($next_loan_id) || !preg_match('/-\d+$/', $next_loan_id))
        ? $default_loan_id
        : $next_loan_id;

    $sql_apr = $con->query("select * from fnd_user_profile where user_fnd_id= '$id'");
    while ($row_apr = $sql_apr->fetch_array()) {
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
    }
    ?>

    <!-- Page toolbar -->
    <div class="acl-toolbar">
      <h3 class="acl-page-title">
        <span class="glyphicon glyphicon-plus-sign"></span>
        Create Commercial Loan
        <small>&nbsp;·&nbsp;<?php echo htmlspecialchars((string)$customer_name); ?> (#<?php echo htmlspecialchars((string)$id); ?>)</small>
      </h3>
      <a href="edit_customer.php?id=<?php echo urlencode((string)$id); ?>" class="btn btn-default">
        <span class="glyphicon glyphicon-arrow-left"></span> Back to customer
      </a>
    </div>

    <!-- Customer summary card (replaces the yellow #F5E09E banner) -->
    <div class="acl-summary">
      <div class="row">
        <div class="col-md-3"><p><strong>Name</strong><b><?php echo htmlspecialchars((string)$customer_name); ?></b></p></div>
        <div class="col-md-3"><p><strong>Phone</strong><b><?php echo htmlspecialchars((string)$mobile_number); ?></b></p></div>
        <div class="col-md-3"><p><strong>Email</strong><b><?php echo htmlspecialchars((string)$email); ?></b></p></div>
        <div class="col-md-3"><p><strong>DOB</strong><b><?php echo htmlspecialchars((string)$date_ofbirth); ?></b></p></div>
        <div class="col-md-6"><p><strong>Address</strong><b><?php echo htmlspecialchars((string)($address . ', ' . $city . ' ' . $state . ' ' . $zip_code)); ?></b></p></div>
        <div class="col-md-3"><p><strong>State</strong><b><?php echo htmlspecialchars((string)$state); ?></b></p></div>
        <div class="col-md-3"><p><strong>SSN</strong><b><?php echo htmlspecialchars((string)$ssn); ?></b></p></div>
      </div>
    </div>

    <form method="POST" enctype="multipart/form-data" onsubmit="return calculate(event)">

      <!-- Loan Setup -->
      <div class="panel panel-default acl-panel">
        <div class="panel-heading">
          Loan Setup
          <span class="acl-required-hint pull-right"><span class="acl-req">*</span> required</span>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-3 acl-field">
              <label>Portfolio <span class="acl-req">*</span></label>
              <select name="source" id="source" class="form-control" onchange="yesnoCheck(this);" required>
                <option value="Payday Loans"    <?php if ($loan_name == 'Payday Loans')    echo 'selected'; ?>>Payday Loans</option>
                <option value="Title Loans"     <?php if ($loan_name == 'Title Loans')     echo 'selected'; ?>>Title Loans</option>
                <option value="Personal Loans"  <?php if ($loan_name == 'Personal Loans')  echo 'selected'; ?>>Personal Loans</option>
                <option value="Commercial Loan" <?php if ($loan_name == 'Commercial Loan') echo 'selected'; ?>>Commercial Loan</option>
              </select>
            </div>
            <div class="col-md-2 acl-field">
              <label>Portfolio Type <span class="acl-req">*</span></label>
              <select name="portfolio_type" id="portfolio_type" class="form-control" onchange="get_loan_create_id(event,this)" required>
                <option value="OF1" <?php if ($portfolio_type == 'OF1') echo 'selected'; ?>>OF1</option>
                <option value="OF2" <?php if ($portfolio_type == 'OF2') echo 'selected'; ?>>OF2</option>
                <option value="OF3" <?php if ($portfolio_type == 'OF3') echo 'selected'; ?>>OF3</option>
                <option value="OF4" <?php if ($portfolio_type == 'OF4') echo 'selected'; ?>>OF4</option>
              </select>
            </div>
            <div class="col-md-3 acl-field">
              <label>Secondary Portfolio</label>
              <select name="p_portfolio" id="p_portfolio" class="form-control">
                <option value="None">None</option>
                <option value="Optima Financial Solutions Inc">Optima Financial Solutions Inc</option>
              </select>
            </div>
            <div class="col-md-3 acl-field">
              <label>Contract Template <span class="acl-req">*</span></label>
              <select name="contract_template" id="contract_template" class="form-control" required>
                <option value="unsecured_2024_09_01" selected>Unsecured (9.1.2024)</option>
                <option value="secured">Secured</option>
              </select>
              <span class="acl-help">Drives which contract PDF is generated.</span>
            </div>
            <div class="col-md-4 acl-field">
              <label>Loan ID <span class="acl-req">*</span> <i id="error_message_id"></i></label>
              <input type="text" name="loan_id" id="loan_id" value="<?php echo htmlspecialchars((string)$loan_create_id); ?>" onchange="validate_loan_id(event,this)" class="form-control" required/>
              <input type="hidden" name="previous_loan_id" value="<?php echo htmlspecialchars((string)$previous_loan_create_id); ?>">
              <span class="acl-help">Auto-generated from the portfolio type. Edit carefully.</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Amounts & Fees -->
      <div class="panel panel-default acl-panel">
        <div class="panel-heading">Amounts &amp; Fees</div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4 acl-field" id="ifNo">
              <label>Loan Amount <span class="acl-req">*</span></label>
              <input type="number" step="0.01" name="principal" onchange="calculate_minimal_payment(event)" class="form-control" placeholder="e.g. 10000.00" required>
            </div>
            <div class="col-md-4 acl-field">
              <label>Late Fee</label>
              <input type="number" step="0.01" name="late_fee" class="form-control" placeholder="e.g. 25.00">
            </div>
            <div class="col-md-4 acl-field">
              <label>Origination / Contract Fee</label>
              <input type="number" step="0.01" name="origination" class="form-control" placeholder="e.g. 250.00">
            </div>
          </div>
        </div>
      </div>

      <!-- Payment Schedule -->
      <div class="panel panel-default acl-panel">
        <div class="panel-heading">Payment Schedule</div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-3 acl-field">
              <label>Installment Plan <span class="acl-req">*</span></label>
              <select name="installment_plan" id="installment_plan" onchange="calculate_payment_start_date(event, this)" class="form-control" required>
                <option value=""></option>
                <option value="Weekly">Weekly</option>
                <option value="Bi-Weekly">Bi-Weekly</option>
                <option value="Monthly">Monthly</option>
              </select>
            </div>
            <div class="col-md-3 acl-field">
              <label>State</label>
              <select name="state" id="state" class="form-control">
                <option value=""></option>
                <option value="CA">California</option>
              </select>
            </div>
            <div class="col-md-3 acl-field">
              <label>Total # of Payments <span class="acl-req">*</span></label>
              <input type="number" name="total_payments" onchange="calculate_minimal_payment(event)" class="form-control" placeholder="e.g. 26" required>
            </div>
            <div class="col-md-3 acl-field">
              <label>Payment Amount <span class="acl-req">*</span></label>
              <input type="number" step="0.01" name="payment" class="form-control" placeholder="Minimal payment shown after amount is set" required>
            </div>
          </div>
        </div>
      </div>

      <!-- Dates & Calculated Results -->
      <div class="panel panel-default acl-panel">
        <div class="panel-heading">Dates &amp; Calculated Results</div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-3 acl-field">
              <label>Contract Start Date</label>
              <input type="date" name="contract_date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="col-md-3 acl-field">
              <label>Payment Start Date</label>
              <input type="date" name="payment_start_date" id="payment_start_date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
              <span class="acl-help">Auto-calculated from Contract Start + plan.</span>
            </div>
            <div class="col-md-3 acl-field">
              <label>APR %</label>
              <input type="text" name="apr" class="form-control" id="apr" readonly placeholder="filled by Calculate">
            </div>
            <div class="col-md-3 acl-field">
              <label>Maturity Date</label>
              <input type="text" name="payment_date" class="form-control" readonly placeholder="filled by Calculate">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 acl-field">
              <label>First Payment <span class="acl-req">*</span></label>
              <input type="text" name="first_payment" class="form-control" id="first_payment" required>
            </div>
            <div class="col-md-6 acl-field">
              <label>Last Payment <span class="acl-req">*</span></label>
              <input type="text" name="last_payment" class="form-control" id="last_payment" required>
            </div>
          </div>
        </div>
      </div>

      <div class="acl-action-bar">
        <a href="edit_customer.php?id=<?php echo urlencode((string)$id); ?>" class="btn btn-default">Cancel</a>
        <button name="btn-submit" type="submit" class="btn btn-calc">
          <span class="glyphicon glyphicon-calculator"></span> Calculate Schedule
        </button>
      </div>
    </form>
  </div>

  <div class="container wrapper">
    <div id="tablePayments"></div>
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

  function get_loan_create_id(e, elem){
    let portfolio_type_value = elem.value;
    var url = 'loan-commercial/functions_commercial_loan.php';

    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: {
            'func': "GetLoanCreateId",
            'portfolio_type': portfolio_type_value
        },
        async: true,
        success: function(data) {
            var loan_create_id = data[0].loan_create_id
            document.getElementById("loan_id").value = loan_create_id;
            document.getElementById("loan_id").innerHTML = loan_create_id;
            document.getElementById("loan_id").innerText = loan_create_id;
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


  function validate_loan_id(e,elem){
    let id = elem.value;
    var url = 'loan-commercial/functions_commercial_loan.php';

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
            var message = ": " + id + " is valid";
            var color = "green";
            if (!valid){
              elem.value = "";
              message = ": " + id + " exists in DB";
              color = "red";
            }
            document.getElementById("error_message_id").style.color = color;
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
      $("#tablePayments")[0].innerHTML =
        '<p style="text-align:center;color:red;font-size:20px">' +
          '<b>Minimal payment should be more than ' + minOnePayment + '</b>' +
        '</p>';
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