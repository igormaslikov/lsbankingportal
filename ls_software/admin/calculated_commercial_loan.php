<?php
session_start();
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

$fnd_idd = $_POST['fnd_id'];

$source = $_POST['source'];
$loan_create_id = $_POST['loan_id'];
$principal = $_POST['principal'];
$loan_interest = $_POST['interest'];
// $years=$_GET['years'];

$late_fee = $_POST['late_fee'];
$origination = $_POST['origination'];
$installment_plan = $_POST['installment_plan'];
$total_payments = $_POST['total_payments'];
$contract_date = $_POST['contract_date'];
$payment_date = $_POST['payment_date'];
$payment_start_date = $_POST['payment_start_date'];
$state = $_POST['state'];
$payment = $_POST['payment'];

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

$one_payment_interest = (int)$loan_interest / $number_of_payments;

$rate = calc_rate($principal, $total_payments, $payment);
$strRate = strVal($rate);

$rate_per_day = $rate / $num_of_days;
$num_days_from_contract = date_diff(date_create($payment_start_date), date_create($contract_date))->format("%a");

$num_late_days = $num_days_from_contract - $num_of_days; 

$rate_late_days = $rate_per_day * $num_late_days;

//echo "<script type='text/javascript'>document.getElementsByName('interest')[0].value = 2</script>";
//echo $_POST['source'];

list($htmlTble, $last_payment) = print_schedule($principal, $rate, $payment, $rate_late_days);
$articles[] = array(
    'table'         =>  (string)$htmlTble,
    'rate'   =>  (string)$rate,
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


function print_schedule($balance, $rate, $payment, $rate_late_days)
{
    include 'dbconfig.php';
    $loan_create_id = $_POST['loan_id'];
    $installment_plan = $_POST['installment_plan'];
    $payment_date = $_POST['payment_start_date'];
    $total_payments = $_POST['total_payments'];
    $payment_fix = $_POST['payment'];
    //var_dump($_POST);
    $varTable = "";
    $varTable .= '<table border="1 solid #ddd" width="100%">';
    $varTable .= '<colgroup align="right" width="20">';
    $varTable .= '<colgroup align="right" width="115">';
    $varTable .= '<colgroup align="right" width="115">';
    $varTable .= '<colgroup align="right" width="115">';
    $varTable .= '<colgroup align="right" width="115">';
    $varTable .= '<colgroup align="right" width="115">';
    $varTable .= '<colgroup align="right" width="115">';
    $varTable .= '<tr style="background-color: #F5E09E;"><th>#</th><th>DATE</th><th>PAYMENT</th><th>INTEREST</th><th>PRINCIPAL</th><th>BALANCE</th><th>INTEREST PER PAYMENT %</th></tr>';


    $payment_date_weekly = $payment_date;

    mysqli_query($con, "DELETE FROM `tbl_commercial_loan_installments` WHERE `loan_create_id` = '$loan_create_id'");
    $count = 0;
    do {
        $count++;




        // calculate interest on outstanding balance
        $interest = $balance * $rate / 100;
        //$interest = $balance * ($rate+$rate_late_days) / 100;
        if ($count == 1) {
            $interest = $balance * ($rate+$rate_late_days) / 100;
            $rate = $rate + $rate_late_days;
        }
        // what portion of payment applies to principal?
        $principal = $payment - $interest;

        // watch out for balance < payment
        if ($balance < $payment) {
            $principal = $balance;
            $payment   = $interest + $principal;
        } // if

        $tmp_payment = $payment;
        // if ($count == 1) {
        //     $late_fee = $rate_late_days * $balance / 100;
        //     $payment += $late_fee;
        // }
        // reduce balance by principal paid
        $balance = $balance - $principal;

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

        $varTable .= "<tr>";
        $varTable .= "<td>$count</td>";
        $varTable .= "<td>$payment_date</td>";
        $varTable .= "<td>" . number_format($payment,   2, ".", ",") . "</td>";
        $varTable .= "<td>" . number_format($interest,  2, ".", ",") . "</td>";
        $varTable .= "<td>" . number_format($principal, 2, ".", ",") . "</td>";
        $varTable .= "<td>" . number_format($balance,   2, ".", ",") . "</td>";
        $varTable .= "<td>" . number_format($rate,   9, ".", ",") . "</td>";
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


        $payment_week_day = date("l", strtotime("$payment_date"));
        //$payment_p = 
        $query_install1  = "INSERT INTO `tbl_commercial_loan_installments`(`loan_create_id`, `payment`, `interest`, `principal`, `balance`, `payment_date`, `week_day`) VALUES ('$loan_create_id','$payment_p','$interest_p','$principal_p','$balance_p','$payment_date', '$payment_week_day')";
        $result_install1 = mysqli_query($con, $query_install1);
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

        if ($count == 1) {
            $rate = calc_rate($balance,$total_payments-1,$payment_fix);
        }
    } while ($balance > 0);

    $varTable .= "<tr>";
    $varTable .= "<td>&nbsp;</td>";
    $varTable .= "<td><b>" . number_format($totPayment,   2, ".", ",") . "</b></td>";
    $varTable .= "<td><b>" . number_format($totInterest,  2, ".", ",") . "</b></td>";
    $varTable .= "<td><b>" . number_format($totPrincipal, 2, ".", ",") . "</b></td>";
    $varTable .= "<td>&nbsp;</td>";
    $varTable .= "</tr>";
    $varTable .= "</table>";
    $varTable .= "<br>";


    $fnd_idd = $_POST['fnd_id'];
    $source = $_POST['source'];
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

    $varTable .= "<a href = 'commercial_initial_setup.php?fnd_id=$fnd_idd&interest=$totInterest&bg_id=$source&loan_create_id=$loan_create_id&principal_amount=$principal_amount&loan_interest=$loan_interest&years=$years&late_fee=$late_fee&contract_fee=$origination&installment_plan=$installment_plan&total_payments=$total_payments&contract_date=$contract_date&payment_date=$payment_date&state=$state'><button name='' type='submit' class='btn btn-danger' style='background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;'>Create Installment Loan</button></a>";

    return array($varTable, date("m/d/Y", strtotime($payment_date)));
}
?>