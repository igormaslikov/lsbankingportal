<?php
session_start();
// This endpoint returns JSON via AJAX from add_commercial_loan.php.
// Any PHP Notice/Warning echo would corrupt the JSON on the client side
// (`$.parseJSON` rejects "<br /><b>Warning..."), so silence display but
// keep a log so we can diagnose the 500s.
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'C:/temp/ofsca/calc_errors.log');

// Last-resort shutdown handler: if a fatal error slips through we still
// respond with valid JSON instead of a 500 with a half-written body.
register_shutdown_function(function() {
    $err = error_get_last();
    if ($err && in_array($err['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR])) {
        if (!headers_sent()) {
            http_response_code(500);
            header('Content-Type: application/json');
        }
        $out = [[
            'table'        => '<div style="padding:20px;border:1px solid #d9534f;background:#f8d7da;color:#721c24;border-radius:4px;">'
                            . '<strong>Calculation failed:</strong> ' . htmlspecialchars($err['message'])
                            . ' <br><small>' . htmlspecialchars($err['file']) . ':' . (int)$err['line'] . '</small></div>',
            'apr'          => '',
            'last_payment' => '',
        ]];
        echo json_encode($out);
    }
});

include 'dbconnect.php';
include 'dbconfig.php';


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

//var_dump($_POST);

//echo $_POST['source'];

// PHP 8 is strict about string arithmetic. Cast all POST numerics to float/int
// at the boundary so downstream code (calc_apr, print_schedule, etc.) can use `+ - * /` safely.
$fnd_idd            = (int)  ($_POST['fnd_id']             ?? 0);
$source             =         ($_POST['source']             ?? '');
$loan_create_id     =         ($_POST['loan_id']            ?? '');
$principal          = (float)($_POST['principal']          ?? 0);
$late_fee           = (float)($_POST['late_fee']           ?? 0);
$origination        = (float)($_POST['origination']        ?? 0);
$installment_plan   =         ($_POST['installment_plan']   ?? '');
$total_payments     = (int)  ($_POST['total_payments']     ?? 0);
$contract_date      =         ($_POST['contract_date']      ?? '');
$payment_date       =         ($_POST['payment_date']       ?? '');
$payment_start_date =         ($_POST['payment_start_date'] ?? '');
$state              =         ($_POST['state']              ?? '');
$payment            = (float)($_POST['payment']            ?? 0);
$apr                =         ($_POST['apr']                ?? '');

if ($installment_plan == 'Weekly') {
    $number_of_payments = 52;
    $num_of_days = 7;
} else if ($installment_plan == 'Bi-Weekly') {
    $number_of_payments = 26;
    $num_of_days = 14;
} else if ($installment_plan == 'Monthly') {
    $number_of_payments = 12;
    $num_of_days = date_diff(date_create(date('Y-m-d', strtotime("$contract_date +1 month"))), date_create($contract_date))->format("%a");
}

#$one_payment_interest = (int)$loan_interest / $number_of_payments;

// $rate = calc_rate($principal, $total_payments, $payment);
// $strRate = strVal($rate);

// $rate_per_day = $rate / $num_of_days;
$num_days_from_contract = date_diff(date_create($payment_start_date), date_create($contract_date))->format("%a");

$num_late_days = $num_days_from_contract - $num_of_days;


if($apr == ""){
    $apr =  calc_apr($principal,$total_payments, $payment, $num_days_from_contract ,$num_of_days);
}



//echo "<script type='text/javascript'>document.getElementsByName('interest')[0].value = 2</script>";
//echo $_POST['source'];

list($htmlTble, $last_payment) = print_schedule($principal, $apr, $payment, $num_of_days, $num_late_days);
$articles[] = array(
    'table'         =>  (string)$htmlTble,
    'apr'   =>  (string)$apr,
    'last_payment' => (string)$last_payment
);
echo json_encode($articles);
?>

<?php
function calc_rate($pv, $payno, $pmt)
{
    //echo "calc start\n";
    // now try and guess the value using the binary chop technique
    $GuessHigh   = (float)100;    // maximum value
    $GuessMiddle = (float)2.5;    // first guess
    $GuessLow    = (float)0;      // minimum value
    $GuessPMT    = (float)0;      // result of test calculation
    $index = 50;
    $int = $GuessMiddle;
    do {
        $index -= 1;
        // use current value for GuessMiddle as the interest rate,
        // and set level of accurracy to 6 decimal places
        $GuessPMT = (float)calc_payment($pv, $payno, $GuessMiddle, 6);
        //echo $GuessPMT;
        if ($GuessPMT > $pmt) {    // guess is too high
            $GuessHigh   = $GuessMiddle;
            $GuessMiddle = $GuessMiddle + $GuessLow;
            $GuessMiddle = $GuessMiddle / 2;
        } // if

        if ($GuessPMT < $pmt) {    // guess is too low
            $GuessLow    = $GuessMiddle;
            $GuessMiddle = $GuessMiddle + $GuessHigh;
            $GuessMiddle = $GuessMiddle / 2;
        } // if
        //echo $GuessPMT."\n".$pmt."</br>";
        if ($GuessMiddle == $GuessHigh) break;
        if ($GuessMiddle == $GuessLow) break;

        $int = number_format($GuessMiddle, 9, ".", "");    // round it to 9 decimal places
        if ($int == 0) {
            echo "<p class='error'>Interest rate has reached zero - calculation error</p>";
            exit;
        } // if

    } while ($GuessPMT != $pmt);
    //echo $int;
    return $int;
} // calc_rate =======================================================================


function get_updated_balance($apr,$pv, $payno, $pmt,$first_days_installment, $days_per_installment){
    $balance = $pv;
    for ($i=0; $i < $payno; $i++) { 
        $per_diem = $balance * $apr / 36500;
        $days = $days_per_installment;
        if ($i == 0){
            $days = $first_days_installment;
        }

        $interest = $per_diem * $days;
        $principal = $pmt - $interest;
        $balance = $balance - $principal;
    }
    return $balance;
}

function calc_apr($pv, $payno, $pmt,$first_days_installment, $days_per_installment)
{
    //echo "calc start\n";
    $GuessHigh = (float)1000;
    $GuessApr= (float)100;
    $GuessLow = (float)0;

    $balance = 0;
    do{

        $balance = get_updated_balance($GuessApr, $pv, $payno, $pmt,$first_days_installment, $days_per_installment);
        
        if ($balance > 0) {
            $GuessHigh  = $GuessApr;
            $GuessApr = $GuessApr + $GuessLow;
            $GuessApr = $GuessApr / 2;           
        }

        if ($balance < 0){
            $GuessLow    = $GuessApr;
            $GuessApr = $GuessApr + $GuessHigh;
            $GuessApr = $GuessApr / 2; 
        }

        $balance = number_format($balance, 9, ".", ""); 

    }while ($balance != 0);

    return $GuessApr;
} // calc_rate =======================================================================

function calc_payment($pv, $payno, $int, $accuracy)
{
    // now do the calculation using this formula:

    //******************************************
    //            INT * ((1 + INT) ** PAYNO)
    // PMT = PV * --------------------------
    //             ((1 + INT) ** PAYNO) - 1
    //******************************************

    $int    = $int / 100;    // convert to a percentage
    $value1 = $int * pow((1 + $int), $payno);
    $value2 = pow((1 + $int), $payno) - 1;
    $pmt    = $pv * ($value1 / $value2);
    // $accuracy specifies the number of decimal places required in the result
    $pmt    = number_format($pmt, $accuracy, ".", "");

    return $pmt;
} // calc_payment ====================================================================


function print_schedule($balance, $apr, $payment, $num_of_days, $num_late_days)
{
    include 'dbconfig.php';
    // PHP 8 rejects string + string. Cast everything numeric up front.
    $balance          = (float)$balance;
    $apr              = (float)$apr;
    $payment          = (float)$payment;
    $num_of_days      = (int)$num_of_days;
    $num_late_days    = (int)$num_late_days;

    $loan_create_id   = $_POST['loan_id']            ?? '';
    $installment_plan = $_POST['installment_plan']   ?? '';
    $payment_date     = $_POST['payment_start_date'] ?? '';
    $total_payments   = (int)  ($_POST['total_payments'] ?? 0);
    $payment_fix      = (float)($_POST['payment']        ?? 0);
    $fnd_id           = (int)  ($_POST['fnd_id']         ?? 0);
    $contract_fee     = (float)($_POST['origination']    ?? 0);


    // $sql_installment = $con->query("SELECT loan_id, loan_create_id FROM tbl_commercial_loan WHERE user_fnd_id = $fnd_id order by loan_id desc limit 1");
    // $count = 0;
    // while ($row_installment = $sql_installment->fetch_array()) {
    //     $previous_loan_id = $row_installment['loan_create_id'];
    //     $count++;
    // }

    $in_hand = 0;
    $prev_loan_id = "";
    $late_fee  = 0;
    $unpaid_late_fee = 0;
    $unpaid_other_fee = 0;

    if (isset($_POST['previous_loan_id']) && $_POST['previous_loan_id'] != "") {
        $previous_loan_id = $_POST['previous_loan_id'];
        $sql = $con->query("select late_fee,amount_of_loan,loan_interest from tbl_commercial_loan where loan_create_id= '$previous_loan_id'");

        while ($row = $sql->fetch_array()) {
            $late_fee = $row['late_fee'];
            $amount_of_loan = $row['amount_of_loan'];
            $loan_interest = $row['loan_interest'];
        }

        $loan_payment = 0;
        $query_payment = $con->query("SELECT SUM(TRY_CAST(payment_amount AS DECIMAL(18,2))) AS value_sum FROM commercial_loan_transaction where loan_create_id= '$previous_loan_id'");
        while ($row_payment = $query_payment->fetch_array()) {
          $loan_payment = $row_payment['value_sum'];
        }
      
        $in_hand = str_replace(',','',number_format(((float)($amount_of_loan + $loan_interest - $loan_payment)), 2, '.', ','));

        // $sql_installment = $con->query("SELECT SUM(payment) as unpaid, SUM(paid amount) as paid  FROM tbl_commercial_loan_installments where loan_create_id= '$previous_loan_id' and status = 0 order by id desc");
        // while ($row_installment = $sql_installment->fetch_array()) {
        //     $in_hand = $row_installment['unpaid'] - $row_installment['paid'];
        // }


        $unpaid_late_fee = 0;
        $query_payment = $con->query("SELECT sum($late_fee - paid_late_fee) as unpaid FROM tbl_commercial_loan_installments WHERE dpd >= 10 and loan_create_id = '$previous_loan_id' and ($late_fee - paid_late_fee) > 0 ");
        while ($row_payment = $query_payment->fetch_array()) {
          $unpaid_late_fee = $row_payment['unpaid'] == null ? 0 : $row_payment['unpaid'];
        }
      
        $unpaid_other_fee = 0;
        $query_payment = $con->query("SELECT sum(amount_fee - amount_fee_paid) as unpaid FROM tbl_other_fees WHERE loan_created_id = $previous_loan_id ");
        while ($row_payment = $query_payment->fetch_array()) {
          $unpaid_other_fee = $row_payment['unpaid'] == null ? 0 : $row_payment['unpaid'];
        }

        // $sql_installment = $con->query("SELECT SUM(late_fee) as sum_late_fee FROM commercial_loan_transaction where loan_create_id= '$previous_loan_id'");
        // $sum_late_fee = 0;
        // while ($row_installment = $sql_installment->fetch_array()) {
        //     $sum_late_fee = $row_installment['sum_late_fee'];
        // }
        
        $in_hand += $unpaid_late_fee + $unpaid_other_fee;
        $prev_loan_id = "&prev_loan_id=".$previous_loan_id;
        //$in_hand = number_format($in_hand,   2, ".", ",");
    }



    //var_dump($_POST);
    $varTable = "";

    // Scoped CSS for the calc result card + schedule.
    $varTable .= '<style>
      .calc-result { margin: 8px 0 30px; font-family: inherit; }
      .calc-itemization, .calc-schedule { background:#fff; border:1px solid #e4e4e4; border-radius:4px; margin-bottom: 22px; overflow: hidden; }
      .calc-title { background:#fafafa; padding: 10px 16px; font-weight:600; color:#333; border-bottom:1px solid #e4e4e4; }
      .calc-itemization table { width:100%; border-collapse: collapse; margin:0; border:0; }
      .calc-itemization td { padding: 10px 16px; border:0; border-bottom:1px solid #f0f0f0; font-size: 14px; color:#333; background:#fff; }
      .calc-itemization tr:last-child td { background:#f7f7f7; font-weight:600; border-bottom:0; }
      .calc-itemization .calc-op { width:40px; text-align:center; color:#999; font-weight:normal; font-size:14px; }
      .calc-itemization .calc-value { text-align:right; font-family: Consolas, monospace; color:#222; width: 170px; }
      .calc-itemization input[type=number] { width: 110px; padding: 3px 8px; border:1px solid #ccc; border-radius:3px; font-family:Consolas,monospace; text-align:right; }
      .calc-aside { background:#fffbec; padding: 8px 16px; font-size:12px; color:#8a7200; border-top:1px dashed #e8dfb0; }
      .calc-aside span { display:inline-block; margin-right:28px; }
      .calc-aside b { color:#4a3d00; }
      .calc-schedule table { width:100%; border-collapse: collapse; margin:0; border:0; }
      .calc-schedule th { background:#f5f5f5; color:#333; font-weight:600; font-size:11px; text-transform:uppercase; letter-spacing:.4px; padding: 10px 12px; border:0; border-bottom:1px solid #ddd; text-align:left; }
      .calc-schedule td { padding: 8px 12px; border:0; border-bottom:1px solid #f0f0f0; font-size:13px; color:#333; background:#fff; }
      .calc-schedule th.right, .calc-schedule td.right { text-align:right; font-family: Consolas, monospace; }
      .calc-schedule tr.total td { background:#f7f7f7; font-weight:600; border-top: 2px solid #ddd; border-bottom:0; }
      .calc-actions { text-align:right; }
      .calc-actions .btn-create {
          display:inline-block; background:#1E90FF; border:1px solid #1E90FF; color:#fff;
          font-weight:600; padding:10px 26px; font-size:14px; border-radius:4px;
          text-decoration:none; cursor:pointer;
      }
      .calc-actions .btn-create:hover { background:#1976c2; border-color:#1976c2; color:#fff; text-decoration:none; }
    </style>';

    $amount_direct_str  = number_format((float)$balance - (float)$in_hand, 2, '.', ',');
    $amount_fin_str     = number_format((float)$balance, 2, '.', ',');
    $contract_fee_str   = number_format((float)$contract_fee, 2, '.', ',');
    $principal_str      = number_format((float)$balance + (float)$contract_fee, 2, '.', ',');
    $unpaid_late_str    = number_format((float)$unpaid_late_fee, 2, '.', ',');
    $unpaid_other_str   = number_format((float)$unpaid_other_fee, 2, '.', ',');

    $varTable .= '<div class="calc-result">';
    $varTable .= '<div class="calc-itemization">
      <div class="calc-title">Itemization of the Amount Financed</div>
      <table>
        <tr>
          <td>Amount given to you directly</td>
          <td class="calc-op"></td>
          <td class="calc-value">$<i id="directlyLoanId">' . $amount_direct_str . '</i></td>
        </tr>
        <tr>
          <td>Amount paid on your existing loan with us</td>
          <td class="calc-op">+</td>
          <td class="calc-value">$<input id="ammountOffId" type="number" step="0.01" onfocus="this.oldvalue = this.value;" value="' . $in_hand . '" oninput="recalculateDirectlyLoan(event,this,' . $balance . '); this.oldvalue = this.value;"></td>
        </tr>
        <tr>
          <td>Amount Financed</td>
          <td class="calc-op">=</td>
          <td class="calc-value">$' . $amount_fin_str . '</td>
        </tr>
        <tr>
          <td>Prepaid Finance Charge (Administrative Fee)</td>
          <td class="calc-op">+</td>
          <td class="calc-value">$' . $contract_fee_str . '</td>
        </tr>
        <tr>
          <td><strong>Principal</strong></td>
          <td class="calc-op">=</td>
          <td class="calc-value"><strong>$' . $principal_str . '</strong></td>
        </tr>
      </table>
      <div class="calc-aside">
        <span>Unpaid late fee: <b>$' . $unpaid_late_str . '</b></span>
        <span>Unpaid other fees: <b>$' . $unpaid_other_str . '</b></span>
      </div>
    </div>';

    $varTable .= '<div class="calc-schedule">';
    $varTable .= '<div class="calc-title">Payment Schedule</div>';
    $varTable .= '<table>';
    $varTable .= '<thead><tr>
        <th style="width:40px">#</th>
        <th>Date</th>
        <th class="right">Per Diem</th>
        <th class="right">Payment</th>
        <th class="right">Interest</th>
        <th class="right">Principal</th>
        <th class="right">Balance</th>
      </tr></thead><tbody>';


    $payment_date_weekly = $payment_date;

    $con->query("DELETE FROM tbl_commercial_loan_installments WHERE loan_create_id = '$loan_create_id'");
    $count = 0;
    $balance_p = 1;
    do {
        $count++;
        if ($count > $total_payments){
            break;
        }
        $per_diem = $balance * $apr / 36500;
        $days = $num_of_days;
        if ($count == 1){
            $days = $num_of_days + $num_late_days;
        }

        $interest = $per_diem * $days;
        // $principal = $pmt - $interest;
        // $balance = $balance - $principal;
       

        // calculate interest on outstanding balance
        // $interest = $balance * $rate / 100;
        // $per_diem = $interest / $num_of_days; #TODO set number of days
        // //$interest = $balance * ($rate+$rate_late_days) / 100;
        // $apr = 365 * 100 * $per_diem / $balance;
        // if ($count == 1) {
        //     $interest = $balance * ($rate + $rate_late_days) / 100;
        //     $rate = $rate + $rate_late_days;
        //     $per_diem = $interest / ($num_of_days + $num_late_days);
        //     $apr = 365 * 100 * $per_diem / $balance;
        // }
       
        // what portion of payment applies to principal?
        $principal = $payment - $interest;

        // watch out for balance < payment
        // if ($balance < $payment) {
        //     $principal = $balance;
        //     $payment   = $interest + $principal;
        // } // if

        $tmp_payment = $payment;
        // if ($count == 1) {
        //     $late_fee = $rate_late_days * $balance / 100;
        //     $payment += $late_fee;
        // }
        // reduce balance by principal paid
        $balance = $balance - $principal;
        // if ($balance < 0){
        //     break;
        // }
        // watch for rounding error that leaves a tiny balance
        
        if ($balance < 0) {
            $principal = $principal + $balance;
            $interest  = $interest - $balance;
            $balance   = 0;
        } // if

        if ($count > 1) {
            if ($installment_plan == 'Weekly') {
                $payment_date_weekly = date("Y-m-d", strtotime("$payment_date_weekly +7 day"));
            }

            if ($installment_plan == 'Bi-Weekly') {
                $payment_date_weekly = date("Y-m-d", strtotime("$payment_date_weekly +14 day"));
            }

            if ($installment_plan == 'Monthly') {
                $payment_date_weekly = date("Y-m-d", strtotime("$payment_date_weekly +1 month"));
            }
            $payment_date = $payment_date_weekly;
        }

        $payment_date = date("m-d-Y", strtotime($payment_date));

        
        $varTable .= "<tr>";
        $varTable .= "<td>$count</td>";
        $varTable .= "<td>$payment_date</td>";
        $varTable .= "<td class='right'>" . number_format($per_diem,   2, ".", ",") . "</td>";
        $varTable .= "<td class='right'>" . number_format($payment,   2, ".", ",") . "</td>";
        $varTable .= "<td class='right'>" . number_format($interest,  2, ".", ",") . "</td>";
        $varTable .= "<td class='right'>" . number_format($principal, 2, ".", ",") . "</td>";
        $varTable .= "<td class='right'>" . number_format($balance,   2, ".", ",") . "</td>";
        $varTable .= "</tr>";

        $payment_p = number_format($payment,   2, ".", ",");
        $interest_p = number_format($interest,  2, ".", ",");
        $principal_p = number_format($principal, 2, ".", ",");
        $balance_p = number_format($balance,   2, ".", ",");

        // if($installment_plan=='Weekly')
        // {
        //     $dt = $payment_date;
        //     $payment_date_weekly= date( "Y-m-d", strtotime( "$dt +7 day" ) );
        // }

        // if($installment_plan=='Bi-Weekly')
        // {
        //     $dt = $payment_date;
        //     $payment_date_weekly= date( "Y-m-d", strtotime( "$dt +14 day" ) );
        // }

        // if($installment_plan=='Monthly')
        // {
        //     $dt = $payment_date;
        //     $payment_date_weekly= date( "Y-m-d", strtotime( "$dt +30 day" ) );
        // }


        $payment_week_day = date("l", strtotime("$payment_date_weekly"));
        //$payment_p = 
        $query_install1  = "INSERT INTO `tbl_commercial_loan_installments`(`number_of_payment`,`loan_create_id`, `payment`, `interest`, `principal`, `balance`, `payment_date`,`per_diem`,`days`, `week_day`) VALUES ('$count','$loan_create_id','$payment_p','$interest','$principal','$balance','$payment_date','$per_diem','$num_of_days','$payment_week_day')";
        $result_install1 = $con->query($query_install1);
        if ($result_install1) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
            $varTable .= "<h3> Error Inserting Data tbl_commercial_loan_installments</h3>";
        }

        @$totPayment   = $totPayment + $payment;
        @$totInterest  = $totInterest + $interest;
        @$totPrincipal = $totPrincipal + $principal;

        if ($payment < $interest) {
            $varTable .= "</table>";
            $varTable .= "<p>Payment < Interest amount - rate is too high, or payment is too low</p>";
            exit;
        } // if

        $payment = $tmp_payment;

        // if ($count == 1) {
        //     $rate = calc_rate($balance, $total_payments - 1, $payment_fix);
        // }
    } while ($balance_p > 0);

    $varTable .= '<tr class="total">';
    $varTable .= '<td colspan="3" style="text-align:right">Totals</td>';
    $varTable .= "<td class='right'>" . number_format($totPayment,   2, ".", ",") . "</td>";
    $varTable .= "<td class='right'>" . number_format($totInterest,  2, ".", ",") . "</td>";
    $varTable .= "<td class='right'>" . number_format($totPrincipal, 2, ".", ",") . "</td>";
    $varTable .= "<td></td>";
    $varTable .= "</tr>";
    $varTable .= "</tbody></table>";
    $varTable .= "</div>"; // .calc-schedule


    $fnd_idd = $_POST['fnd_id'];
    $source = $_POST['source'];
    $portfolio_type = $_POST['portfolio_type'];
    $secondary_portfolio = $_POST['p_portfolio'];
    $contract_template = $_POST['contract_template'] ?? 'unsecured_2024_09_01';
    $loan_create_id = $_POST['loan_id'];
    $principal_amount = $_POST['principal'];
    $loan_interest = $totInterest;
    $years = 2;
    $late_fee = $_POST['late_fee'];
    $origination = $_POST['origination'];
    $installment_plan = $_POST['installment_plan'];
    $total_payments = $_POST['total_payments'];
    $contract_date = $_POST['contract_date'];
    $state = $_POST['state'];
    $first_payment = $_POST['first_payment'];
    $last_payment = $_POST['last_payment'];
    

    $varTable .= '<div class="calc-actions">
      <a id="comInitSetupHref" class="btn-create" href="commercial_initial_setup.php?fnd_id=' . urlencode((string)$fnd_idd) . '&interest=' . urlencode((string)$totInterest) . '&anual_pr=' . urlencode((string)$apr) . '&bg_id=' . urlencode((string)$source) . '&portfolio_type=' . urlencode((string)$portfolio_type) . '&secondary_portfolio=' . urlencode((string)$secondary_portfolio) . '&loan_create_id=' . urlencode((string)$loan_create_id) . $prev_loan_id . '&principal_amount=' . urlencode((string)$principal_amount) . '&loan_interest=' . urlencode((string)$loan_interest) . '&years=' . urlencode((string)$years) . '&late_fee=' . urlencode((string)$late_fee) . '&contract_fee=' . urlencode((string)$origination) . '&installment_plan=' . urlencode((string)$installment_plan) . '&total_payments=' . urlencode((string)$total_payments) . '&contract_date=' . urlencode((string)$contract_date) . '&payment_date=' . urlencode((string)$payment_date) . '&state=' . urlencode((string)$state) . '&in_hand=' . urlencode((string)$in_hand) . '&first_payment=' . urlencode((string)$first_payment) . '&last_payment=' . urlencode((string)$last_payment) . '&contract_template=' . urlencode((string)$contract_template) . '">
        <span class="glyphicon glyphicon-ok"></span> Create Installment Loan
      </a>
    </div>';
    $varTable .= '</div>'; // .calc-result

    // $varTable .= "<a id='comInitSetupHref' href = 'commercial_initial_setup.php?fnd_id=$fnd_idd&interest=$totInterest&anual_pr=$apr&bg_id=$source&secondary_portfolio=$secondary_portfolio&loan_create_id=$loan_create_id$prev_loan_id&principal_amount=$principal_amount&loan_interest=$loan_interest&years=$years&late_fee=$late_fee&contract_fee=$origination&installment_plan=$installment_plan&total_payments=$total_payments&contract_date=$contract_date&payment_date=$payment_date&state=$state&in_hand=$in_hand&first_payment=$first_payment&last_payment=$last_payment'><button name='' type='submit' class='btn btn-danger' style='background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;'>Create Installment Loan</button></a>";

    $last_payment_date_array = explode("-", $payment_date);

    $ld = strtotime($last_payment_date_array[2] . "-" . $last_payment_date_array[0] . "-" . $last_payment_date_array[1]);
    return array($varTable, date("m/d/Y", $ld));
}
?>