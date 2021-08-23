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

    if (isset($_GET['late_fee'])) {
        $late_fee = $_GET['late_fee'];
    }



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
        $address = $row['address'];
        $zip_code = $row['zip_code'];
    }



    //echo "fname is:".$first_name;











    $sql_user = mysqli_query($con, "select * from tbl_users where user_id= '$created_by'");



    while ($row_user = mysqli_fetch_array($sql_user)) {



        $username = $row_user['username'];
    }

    if ($intallment_id == null) {
        $sql_transaction = mysqli_query($con, "select id from tbl_commercial_loan_installments where loan_create_id='$loan_create_id' and status='0' order by id asc limit 1");
        while ($row_transaction = mysqli_fetch_array($sql_transaction)) {
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
    $interval = date_diff($date_due_date, $date_now);

    $dpd = $interval->format('%r%a');
    // $sum_late_fee = $dpd > 0 ? $dpd * $late_fee : 0;
    $sum_late_fee = $dpd >= 10 ? $late_fee : 0;

    if (isset($_GET['late_fee'])) {
        $amount_tobe_paid = 0;
        $sum_late_fee = $_GET['late_fee'];
    }





    ?>

    <?php

    error_reporting(0);


    $error_message = isset($_GET["error_message"]) ? $_GET["error_message"] : "";

    if (isset($_POST['btn-submit'])) {

        $interest_amount_f = $_POST['interest_amount'];

        $principal_amount_f = $_POST['principal_amount'];

        $payment_amount_up = $_POST['payment_amount'];

        $payment_amount_up = str_replace("$", "", "$payment_amount_up");

        $pre_interest_amount = $_POST['pre_interest_amount'];

        $pre_installment_amount = $_POST['pre_installment_amount'];

        $to_be_paid_amount = $_POST['to_be_paid_amount'];

        $late_fee = $_POST['late_fee'];
        $contract_late_fee = $_POST['contract_late_fee'];

        $paid_date = $_POST['payment_date'];
        $due_date = $_POST['due_date'];

        $payment_description = $_POST['payment_description'];
        $payment_method = $_POST['payment_method'];
        $type_of_payment = $_POST['type_of_payment'];
        $convenience_fee = $_POST['convenience_fee'];

        $type_of_description = $_POST['type_of_description'];
        $other_fee = $type_of_description == "" ? 0 : $_POST['other_fee'];


        $db_totalamountpaid = $to_be_paid_amount;

        $db_interestpaid = 0;

        $db_principlepaid = 0;

        $db_latefeepaid = $late_fee;

        $db_remaininginterest = 0;

        $db_remainingprinciple = 0;

        $date = date('Y-m-d');

        if ($to_be_paid_amount >= $interest_amount_f) {

            $db_interestpaid = $interest_amount_f;



            $db_interestpaid1 = $interest_amount_f + $pre_interest_amount;



            $db_remaininginterest = $db_interestpaid - $db_interestpaid1;



            $db_principlepaid = $to_be_paid_amount - $db_interestpaid1;


            $db_remainingprinciple = (float) $principal_amount_f - (float) $db_principlepaid;
        } else {

            $db_interestpaid = $to_be_paid_amount;

            $db_remaininginterest = $interest_amount_f - $to_be_paid_amount;
        }

        $loan_transaction_id = '';

        $status = "Installment is made with Installment ID  $intallment_id";

        if ($to_be_paid_amount == 0) {
            $query_payment = mysqli_query($con, "Select remaining_balance from commercial_loan_transaction where loan_create_id = '$loan_create_id' order by transaction_id desc limit 1");
            while ($row = mysqli_fetch_array($query_payment)) {
                $rem_balance  = $row['remaining_balance'];
            }
        }

        $to_be_paid_amount += $paid_amount;
        if (isset($_GET['late_fee'])) {
            $to_be_paid_amount = 0;
        }

        $sum_interest_amount = 0;
        $sum_principle_amount = 0;
        $late_fee_is_paid = FALSE;


        //**************************Get card info if exists *///

        if (isset($_POST['bankExists']) && isset($_POST['cardExists'])) {

            $bankName = $_POST['bankName'];
            $accountNumber = $_POST['accountNumber'];
            $routingNumber = $_POST['routingNumber'];
            $accountType = $_POST['accountType'];
            $bankType = $_POST['bankType'];
            $typeOfID = $_POST['typeOfID'];
            $typeOfCard = $_POST['typeOfCard'];
            $cardNumber = $_POST['cardNumber'];
            $expDate = $_POST['expDate'];
            $cvv = $_POST['cvv'];
        }

        //************************************************************* */

        //******************Repay payment**************** */

        $continue = true;
        if ($payment_method == "Repay") {

            //********************************************* GET BASE URL 

            $sql_payment_api = mysqli_query($con, "select * from payment_api_urls where name='test_url2'");

            while ($row_payment_api = mysqli_fetch_array($sql_payment_api)) {

                $url_payment_api = $row_payment_api['url'];
                $app_token_payment = $row_payment_api['token'];
            }

            //********************************************     

            //*********************************************** GET Form ID API ***********************************
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "$url_payment_api/checkout",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                    "payment_method": "card",
                    "Source": "LS Financing"
                    }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    "Authorization: $app_token_payment"
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            //echo $response;

            $data = json_decode($response, true);
            $checkout_form_id = $data['checkout_form_id'];
            //echo "checkout_form_id: $checkout_form_id.<br><hr>";
            //************************************************ GET Form ID API END ***********************************

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "$url_payment_api/checkout-forms/$checkout_form_id/paytoken",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                    "amount": "' . $amount . '",
                    "customer_id": "' . $loan_create_id . '",
                    "transaction_type": "sale"
                    
                    }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    "Authorization: $app_token_payment"
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            //echo $response;


            $data_paytoken = json_decode($response, true);
            $paytoken = $data_paytoken['paytoken'];
            //echo "paytoken: $paytoken.<br><hr><br>";
            //*********************************************************************** Pay Token API END

            $full_name = $first_name . ' ' . $last_name;
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "$url_payment_api/checkout-forms/$checkout_form_id/token-payment",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                    "amount": "' . $to_be_paid_amount . '",
                    "customer_id": "' . $loan_create_id . '",
                    "transaction_type": "sale",
                    "paytoken": "' . $paytoken . '",
                    "cardholder_name": "' . $full_name . '",
                    "card_number": "' . $cardNumber . '",
                    "card_cvc": "' . $cvv . '",
                    "card_expiration": "' . str_replace("/", "", $expDate) . '",
                    "Source": "LS Financing",
                    "PaymentChannel": "web",
                    "convenience_fee": "0",
                    "waive_conv_fee": false,
                    "address_street": "' . $address . '",
                    "address_zip": "' . $zip_code . '",
                    "ChannelUser":"info@lsbanking.com"
                    }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $data_paywithcard = json_decode($response, true);

            $status = $data_paywithcard['status'];



            if ($status == 'error') {
                //$response = str_replace("[", "", "$response");
                //$response = str_replace("]", "", "$response");
                // echo "This: ".$response."<br>";
                $data = json_decode($response, true);
                $status = $data['status'];
                $errors = $data['errors'];
                $error_messages = "";
                foreach ($errors as $error) {
                    $error_messages .= $error['description'];
                }
                //$displayerror = $data['errors']['name'];
                //$error_description = $data['errors']['description'];
                $payment_error = "$status: $error_messages";
                $query_insert_trans = "INSERT INTO `commercial_loan_transaction`(`loan_id`, `loan_create_id`, `user_fnd_id`, `installment_id`, `payment_amount`, `interest`, `principal_amount`, `remaining_balance`, `remaining_interest`, `remaining_installment_principal`, `late_fee`, `convenience_fee` ,`other_fee`,`other_fee_id`, `payment_date`, `payment_description`,`payment_method`, `created_at`, `created_by`) VALUES ('$id','$loan_create_id','$user_fnd_id','$intallment_id','$db_totalamountpaid','$db_interestpaid','$db_principlepaid','$rem_balance','$db_remaininginterest','$db_remainingprinciple','$db_latefeepaid','$convenience_fee','$other_fee','$other_fee_id','$due_date','$payment_description','$payment_method','$paid_date','$u_id')";
                $result_insert_trans = mysqli_query($con, $query_insert_trans);
                $transaction_id = mysqli_insert_id($con);
                mysqli_query($con, "UPDATE commercial_loan_transaction SET payment_amount=0, interest = 0, principal_amount = 0, late_fee=0, convenience_fee = 0, other_fee = 0, other_fee_id = 0 where transaction_id ='$transaction_id'");

                //TODO return to the same page with error

                ?>
                    <script>
                        window.location.href = 'add_new_transaction.php?id=<?php echo $id; ?>&error_message=<?php echo $payment_error; ?>';
                    </script>
                <?php
                exit;
            }
            $merchant_id = $data_paywithcard['merchant_id'];
            $repay_transaction_id = $data_paywithcard['pn_ref'];
            $auth_code = $data_paywithcard['auth_code'];
            $trx_status = $data_paywithcard['trx_status'];
            $result_text = $data_paywithcard['resp_msg'];

            $zip = $data_paywithcard['zip'];

            //$amount=$data_paywithcard['requested_auth_amount'];
            //$amount = number_format((float)$amount, 2, '.', '');
            $card_bin = $data_paywithcard['card_bin'];

            $exp_date = $data_paywithcard['exp_date'];

            $card_last_four = $data_paywithcard['payment_method_detail']['card_last_four'];

            $name_on_card = $data_paywithcard['name_on_card'];
            $customer_id = $data_paywithcard['customer_id'];
            $payment_channel = "web";
            $merchant_name = $data_paywithcard['merchant_name'];
            $date = $data_paywithcard['date'];
            $trans_type_id = $data_paywithcard['trans_type_id'];
            $query_in  = "INSERT INTO `tbl_pay_with_card` (`user_fnd_id`,`loan_create_id`,`merchant_id`, `transaction_id`, `auth_code`, `trx_status`, `result_text`, `zip_code`, `amount`, `card_bin`, `card_exp`, `card_last_four`, `name_on_card`, `customer_id`, `payment_channel`, `source`, `transaction_type`, `transaction_date`)  VALUES ('$user_fnd_id','$loan_create_id','$merchant_id','$repay_transaction_id','$auth_code','$trx_status','$result_text','$zip','$amount','$card_bin','$exp_date','$card_last_four','$name_on_card','$customer_id','$payment_channel','$merchant_name','$trans_type_id','$new_date')";
            $result = mysqli_query($con, $query_in);
        }



        //*********************************************** */

        $query_payment = mysqli_query($con, "Select payment, `id`, `paid amount`, balance, interest, principal, paid_late_fee from `tbl_commercial_loan_installments` where loan_create_id = '$loan_create_id' and status = 0 order by id asc");
        while ($row_payment = mysqli_fetch_array($query_payment)) {
            if ($to_be_paid_amount == 0) {

                if ($type_of_payment == "Payoff") {
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
                $interval = date_diff($date_due_date, $date_now);

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

            $paid_late_fee = 0;
            if (!$late_fee_is_paid) {
                $late_fee_is_paid = TRUE;
                $paid_late_fee = $late_fee + $row_payment['paid_late_fee'];
            }

            mysqli_query($con, "UPDATE tbl_commercial_loan_installments SET `paid_late_fee` = '$paid_late_fee', paid_date='$paid_date', `paid amount`='$to_paid',`dpd` = $dpd, status=$status, paid_by='$u_id', payment_description='$payment_description'  where id ='$intallment_id'");
        }

        if (isset($payment) && ($_POST['to_be_paid_amount'] > $payment)) {
            $db_totalamountpaid  = $_POST['to_be_paid_amount'];
            $db_interestpaid = $sum_interest_amount;
            $db_principlepaid = $sum_principle_amount;
        }

        if (isset($_GET['late_fee'])) {
            $intallment_id = $_GET['intallment_id'];
            $query_payment = mysqli_query($con, "Select paid_late_fee from `tbl_commercial_loan_installments` where id = '$intallment_id'");
            while ($row_payment = mysqli_fetch_array($query_payment)) {
                $paid_late_fee = $row_payment['paid_late_fee'];
            }

            $paid_late_fee += $late_fee;
            mysqli_query($con, "UPDATE tbl_commercial_loan_installments SET `paid_late_fee` = '$paid_late_fee' where id ='$intallment_id'");
        }

        $other_fee_id = 0;
        if ($type_of_description != "") {
            $other_fee_id = str_replace(array("(", ")"), array("", ""), end(explode(" ", $type_of_description)));
            mysqli_query($con, "UPDATE tbl_other_fees SET amount_fee_paid = amount_fee_paid + $other_fee where tbl_other_fees_id = $other_fee_id");
        }

        $query_insert_trans = "INSERT INTO `commercial_loan_transaction`(`loan_id`, `loan_create_id`, `user_fnd_id`, `installment_id`, `payment_amount`, `interest`, `principal_amount`, `remaining_balance`, `remaining_interest`, `remaining_installment_principal`, `late_fee`, `convenience_fee` ,`other_fee`,`other_fee_id`, `payment_date`, `payment_description`,`payment_method`, `created_at`, `created_by`) VALUES ('$id','$loan_create_id','$user_fnd_id','$intallment_id','$db_totalamountpaid','$db_interestpaid','$db_principlepaid','$rem_balance','$db_remaininginterest','$db_remainingprinciple','$db_latefeepaid','$convenience_fee','$other_fee','$other_fee_id','$due_date','$payment_description','$payment_method','$paid_date','$u_id')";
        $result_insert_trans = mysqli_query($con, $query_insert_trans);

        if ($result_insert_trans) {
            if (isset($_POST['bankExists']) && isset($_POST['cardExists'])) {
                $transaction_id = mysqli_insert_id($con);
                $query_transaction = "INSERT INTO `commercial_loan_transaction_cards_info` (`card_info_id`,`type_of_id`, `type_of_card`, `card_number`, `card_exp_date`, `cvv_number`, `bank_name`, `account_number`, `routing_number`, `account_type`, `bank_type`) VALUES ('','$typeOfID', '$typeOfCard', '$cardNumber', '$expDate', '$cvv', '$bankName', '$accountNumber', '$routingNumber', '$accountType', '$bankType')";
                $result = mysqli_query($con, $query_transaction);
                $card_info_id = mysqli_insert_id($con);

                mysqli_query($con, "UPDATE commercial_loan_transaction SET card_info='$card_info_id' where transaction_id ='$transaction_id'");
            }
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
            window.location.href =
                'add_auth_code.php?id=<?php echo $id; ?>&to_be_paid_amount=<?php echo $to_be_paid_amount; ?>&late_fee=<?php echo $late_fee; ?>';
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

                    <div class="col-lg-4">
                        <p>User ID: <b style="color:red" id="userId"><?php echo $user_fnd_id; ?></b> </p>
                    </div>

                </div>

                <br><br>

                <div class="container-fluid" style="width:100%; margin:0 auto;">

                    <h3>Make a Payment: </h3>

                    <form id="transactionFormId" action="" method="POST" enctype="multipart/form-data">

                        <input type="text" name="name_id" id="idUserId" value="<?php echo $user_fnd_id; ?>" style="display:none;">
                        <input type="text" name="loan_id" id="loanId" value="<?php echo $loan_create_id; ?>" style="display:none;">
                        <input type="text" name="contract_late_fee" id="contractLateFeeId" value="<?php echo $late_fee; ?>" style="display:none;">
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

                            <div class="col-lg-2">
                                <label for="usr">Late Fee ($):</label>
                                <input type="text" name="late_fee" class="form-control" id="usr" placeholder="" value="<?php echo $sum_late_fee; ?>">

                            </div>

                            <div class="col-lg-2">
                                <label for="usr">Convenience Fee ($):</label>
                                <input type="text" name="convenience_fee" class="form-control" id="usr" placeholder="" value="0">

                            </div>
                            <div class="col-lg-2">
                                <label style="width:100%" for="other_fee_id">Other Fee ($):</label>
                                <select name="type_of_description" id="lblTypeOfDescription" onchange="GetUnpaidOtherFee(this,event)" style="width:70%">
                                    <option value=""></option>
                                    <?php
                                    $sql_loan = mysqli_query($con, "select * from tbl_other_fees tof inner join tbl_lists tl on tof.kind_fee = tl.tbl_lists_id where loan_created_id='$loan_create_id' and user_fnd_id = '$user_fnd_id' and amount_fee_paid != amount_fee");

                                    while ($row_loan = mysqli_fetch_array($sql_loan)) {
                                        $row_item = $row_loan['item'];
                                        $id = $row_loan['tbl_other_fees_id'];
                                        echo "<option value='$row_item ($id)'>$row_item ($id)</option>";
                                    }
                                    ?>
                                </select>
                                <input type="text" name="other_fee" class="form-control" id="other_fee_id" placeholder="" value="0" style="width:25%; display:inline!important;">


                            </div>
                            <div class="col-lg-6">

                                <label for="usr">Payment Date:</label>

                                <input type="date" name="payment_date" class="form-control" id="usr" placeholder="<?php echo date('m/d/Y', strtotime("now")); ?>" value="<?php echo strftime('%Y-%m-%d', strtotime("now")) ?>">

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
                                <label for="usr">Payment Method</label>
                                <select name="payment_method" id="payment_method" class="form-control" value="" onchange="payment_method_info(this,event)">
                                    <option value=""></option>
                                    <option value="Cash">Cash</option>
                                    <option value="Debit Card">Debit Card</option>
                                    <option value="Bank Deposit">Bank Deposit</option>
                                    <option value="Money Order">Money Order</option>
                                    <option value="ACH">ACH</option>
                                    <option value="Zelle">Zelle</option>
                                    <option value="Repay">Repay</option>
                                </select>
                            </div>
                            <div id="paymentOptionId" hidden>
                                <div id="bankOptionId"></div>
                                <div id="cardOptionId"></div>
                            </div>
                            <div class="col-lg-6">
                                <label for="payment_description">Payment Description:</label>
                                <textarea name="payment_description" class="form-control" id="payment_description" placeholder="Payment Description" value=""></textarea>

                            </div>
                            <div class="col-lg-12" style="padding-top: 20px;">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div id="bankTableId"></div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div id="cardTableId"></div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <br>

                        <button id="btnAddTransaction" name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: blue;border-color: blue;">Add transaction</button>
                        <button name="btn-submit-repay" class="btn btn-danger" hidden style="background-image: linear-gradient(to bottom,red 0,red 100%);color: #fff;background-color:red;border-color: red;">Pay
                            Via Repay</button>


                    </form>
                    <div>
                        <h2 style="padding-top: 5%;text-align: center;color:red" id="error"><?php echo $error_message; ?></h2>
                    </div>
                </div>

            </div>



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

            function GetUnpaidOtherFee(elem, event) {
                let id = elem.value.split(' ').slice(-1)[0].replace('(', '').replace(')', '');
                var url = 'functions_commercial_loan.php';

                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'func': "GetUnpaidOtherFee",
                        'id': id
                    },
                    async: true,
                    success: function(data) {
                        //var tableCard = data[0].cardTable;
                        var unpaidFee = data[0].nonpaid;
                        document.getElementById("other_fee_id").value = unpaidFee;
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

            function payment_method_info(elem, event) {
                let method = elem.value;
                switch (method) {
                    case "Repay":
                    case "Debit Card":
                        var url = 'functions_commercial_loan.php';
                        // projectName = "SPVL"

                        $.ajax({
                            url: url,
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                'func': "GetBankInfoTable",
                                'userId': document.getElementById("idUserId").getAttribute("value"),
                                'loan_create_id': document.getElementById("loanId").getAttribute("value")
                            },
                            async: true,
                            success: function(data) {
                                //var tableCard = data[0].cardTable;
                                var tableBank = data[0].bankTable;
                                // document.getElementById("bankTableId").outerHTML = tableBank;
                                // document.getElementById("cardTableId").outerHTML = tableCard;
                                document.getElementById("bankTableId").innerHTML = tableBank;
                                document.getElementById("bankTableId").innerHTML.reload;
                                // document.getElementById("cardTableId").innerHTML = tableCard;
                                // document.getElementById("cardTableId").innerHTML.reload;
                                $('#tbl_bank_info').on('click', '.clickable-bank-row', function(event) {
                                    if ($(this).hasClass('table-success')) {
                                        $(this).removeClass('table-success');
                                    } else {
                                        $(this).addClass('table-success').siblings().removeClass(
                                            'table-success');
                                    }

                                    getCardInfoTable(event);
                                    //getDebitCardInformation(event);

                                });

                                getCardInfoTable(event);

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
                        break;
                    default:
                        document.getElementById("bankOptionId").innerHTML = "";
                        document.getElementById("cardOptionId").innerHTML = "";
                        document.getElementById("cardTableId").innerHTML = "";
                        document.getElementById("bankTableId").innerHTML = "";
                        document.getElementById('btnAddTransaction').disabled = false;
                        break;

                }

            }


            function getCardInfoTable(e) {
                var selected_data_bank = $("#tbl_bank_info tr.table-success td");
                var paymentElem = document.getElementById("bankOptionId");
                paymentElem.innerHTML = "";
                var bankExists = selected_data_bank.length > 0;
                paymentElem.innerHTML += "<input type='text' name='bankExists' value='" + bankExists +
                    "' style='display:none;'>";
                if (!bankExists) {
                    document.getElementById('btnAddTransaction').disabled = true;
                    document.getElementById("cardTableId").innerHTML = "";
                    e.preventDefault();
                    return;
                }

                var bankId = selected_data_bank[0].innerText;
                paymentElem.innerHTML += "<input type='text' name='bankName' value='" + selected_data_bank[1].innerText +
                    "' style='display:none;'>";
                paymentElem.innerHTML += "<input type='text' name='accountNumber' value='" + selected_data_bank[2].innerText +
                    "' style='display:none;'>";
                paymentElem.innerHTML += "<input type='text' name='routingNumber' value='" + selected_data_bank[3].innerText +
                    "' style='display:none;'>";
                paymentElem.innerHTML += "<input type='text' name='accountType' value='" + selected_data_bank[4].innerText +
                    "' style='display:none;'>";
                paymentElem.innerHTML += "<input type='text' name='bankType' value='" + selected_data_bank[5].innerText +
                    "' style='display:none;'>";

                var url = 'functions_commercial_loan.php';
                // projectName = "SPVL"

                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'func': "GetCardInfoByBankId",
                        'userId': document.getElementById("idUserId").getAttribute("value"),
                        'loan_create_id': document.getElementById("loanId").getAttribute("value"),
                        'bankId': bankId
                    },
                    async: true,
                    success: function(data) {
                        //var tableCard = data[0].cardTable;
                        var tableCard = data[0].cardTable;
                        document.getElementById("cardTableId").innerHTML = tableCard;
                        document.getElementById("cardTableId").innerHTML.reload;
                        // var selected_data = $("#tbl_bank_info tr.success td");

                        $('#tbl_card_info').on('click', '.clickable-card-row', function(event) {
                            if ($(this).hasClass('table-success')) {
                                $(this).removeClass('table-success');
                            } else {
                                $(this).addClass('table-success').siblings().removeClass('table-success');
                            }

                            getCardInformation(event);
                            //change_bank_info(event);

                        });

                        getCardInformation(event);

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

            function getCardInformation(e) {
                var selected_data_card = $("#tbl_card_info tr.table-success td");
                var paymentElem = document.getElementById("cardOptionId");
                paymentElem.innerHTML = "";
                var cardExists = selected_data_card.length > 0;
                paymentElem.innerHTML += "<input type='text' name='cardExists' value='" + cardExists +
                    "' style='display:none;'>";
                if (!cardExists) {
                    document.getElementById('btnAddTransaction').disabled = true;
                    e.preventDefault();
                    return;
                }

                document.getElementById('btnAddTransaction').disabled = false;
                paymentElem.innerHTML += "<input type='text' name='typeOfID' value='" + selected_data_card[1].innerText +
                    "' style='display:none;'>";
                paymentElem.innerHTML += "<input type='text' name='typeOfCard' value='" + selected_data_card[2].innerText +
                    "' style='display:none;'>";
                paymentElem.innerHTML += "<input type='text' name='cardNumber' value='" + selected_data_card[3].innerText +
                    "' style='display:none;'>";
                paymentElem.innerHTML += "<input type='text' name='expDate' value='" + selected_data_card[4].innerText +
                    "' style='display:none;'>";
                paymentElem.innerHTML += "<input type='text' name='cvv' value='" + selected_data_card[5].innerText +
                    "' style='display:none;'>";
            }

            function getDebitCardInformation(e) {
                var selected_data_bank = $("#tbl_bank_info tr.table-success td");
                var paymentElem = document.getElementById("paymentOptionId");


                var selected_data_card = $("#tbl_card_info tr.table-success td");

                paymentElem.innerHTML = "";
                var bankExists = selected_data_bank.length > 0;
                var cardExists = selected_data_card.length > 0;
                paymentElem.innerHTML += "<input type='text' name='bankExists' value='" + bankExists +
                    "' style='display:none;'>";
                paymentElem.innerHTML += "<input type='text' name='cardExists' value='" + cardExists +
                    "' style='display:none;'>";
                if (!bankExists || !cardExists) {
                    document.getElementById('btnAddTransaction').disabled = true;
                    e.preventDefault();
                    return;
                }
                document.getElementById('btnAddTransaction').disabled = false;
                paymentElem.innerHTML += "<input type='text' name='bankName' value='" + selected_data_bank[1].innerText +
                    "' style='display:none;'>";
                paymentElem.innerHTML += "<input type='text' name='accountNumber' value='" + selected_data_bank[2].innerText +
                    "' style='display:none;'>";
                paymentElem.innerHTML += "<input type='text' name='routingNumber' value='" + selected_data_bank[3].innerText +
                    "' style='display:none;'>";
                paymentElem.innerHTML += "<input type='text' name='typeOfID' value='" + selected_data_card[1].innerText +
                    "' style='display:none;'>";
                paymentElem.innerHTML += "<input type='text' name='typeOfCard' value='" + selected_data_card[2].innerText +
                    "' style='display:none;'>";
                paymentElem.innerHTML += "<input type='text' name='cardNumber' value='" + selected_data_card[3].innerText +
                    "' style='display:none;'>";
                paymentElem.innerHTML += "<input type='text' name='expDate' value='" + selected_data_card[4].innerText +
                    "' style='display:none;'>";
                paymentElem.innerHTML += "<input type='text' name='cvv' value='" + selected_data_card[5].innerText +
                    "' style='display:none;'>";

            }
        </script>

    <?php

}

    ?>

    </body>

    </html>