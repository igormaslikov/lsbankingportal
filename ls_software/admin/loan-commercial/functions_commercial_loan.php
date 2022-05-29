<?php

session_start();

include_once '../dbconnect.php';
include('db.php');
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
    $func = $_POST['func']; //remember to escape it

    switch ($func) {
        case 'UpdateBankInfo':
            UpdateBankInfo();
            break;
        case 'DeleteBankInfo':
            DeleteBankInfo();
            break;
        case 'UpdateCardInfo':
            UpdateCardInfo();
            break;
        case 'DeleteCardInfo':
            DeleteCardInfo();
            break;
        case 'GetCardInfoTable':
            GetCardInfoTable();
            break;
        case 'GetBankInfoTable':
            GetBankInfoTable();
            break;
        case 'GetCardInfoByBankId':
            GetCardInfoByBankId();
            break;
        case 'GetBankInfoByUserId':
            GetBankInfoByUserId();
            break;
        case 'InsertAllBankInformation':
            InsertAllBankInformation();
            break;
        case 'UpdateOtherFee':
            UpdateOtherFee();
            break;
        case 'DeleteOtherFee':
            DeleteOtherFee();
            break;
        case 'GetUnpaidOtherFee':
            GetUnpaidOtherFee();
            break;
        case 'SetChargeback':
            SetChargeback();
            break;
        case 'UpdateTransaction':
            UpdateTransaction();
            break;
        case 'UpdateChargebackTransaction':
            UpdateChargebackTransaction();
            break;
        case 'DeleteChargebackTransaction':
            DeleteChargebackTransaction();
            break;
        case 'DeleteTransaction':
            DeleteTransaction();
            break;
        case 'GetEditTransactionModal':
            GetEditTransactionModal();
            break;
        case 'CalculateInstallmetsPerDiem':
            CalculateInstallmetsPerDiem();
            break;
        default:
            //function not found, error or something
            break;
    }
}

function UpdateBankInfo()
{
    global $con;

    $userId = $_POST['userId'];
    $bankInfoId = $_POST['bankInfoId'];
    $bankName = $_POST['bankName'];
    $accountNumber = $_POST['accountNumber'];
    $routingNumber = $_POST['routingNumber'];
    $accountType = $_POST['accountType'];
    $bankType = $_POST['bankType'];
    $status = $_POST['status'] == "true" ? '1' : '0';
    $newBankInfo = $_POST['newBankInfo'];

    $sql = mysqli_query($con, "select count(bank_id) as count from tbl_bank_info where usr_fnd_id= '$userId' and bank_name='$bankName' and account_number='$accountNumber' and routing_number='$routingNumber' and bank_id != '$bankInfoId'");

    while ($row = mysqli_fetch_array($sql)) {
        $count = $row['count'];
    }

    if ($count > 0) {
        $articles[] = array(
            'status'         =>  "false",
            'message'       => "Bank info exist"
        );
        echo json_encode($articles);
        return;
    }

    $action_query = "UPDATE `tbl_bank_info` SET `bank_name` = '$bankName', `account_number` = '$accountNumber', `routing_number` = '$routingNumber',`account_type` = '$accountType',`bank_type` = '$bankType', `is_active` = '$status' WHERE `tbl_bank_info`.`bank_id` = '$bankInfoId '";
    $message = "Bank info updated";
    if ($newBankInfo == "true") {

        $action_query = "INSERT INTO `tbl_bank_info` (`bank_id`, `usr_fnd_id`, `bank_name`, `account_number`, `routing_number`,`account_type`,`bank_type`, `is_active`) VALUES (NULL, '$userId', '$bankName', '$accountNumber', '$routingNumber', '$accountType','$bankType','$status')";
        $message = "Bank info inserted";
    }
    mysqli_query($con, $action_query);


    $articles[] = array(
        'status'         =>  "ok",
        'message'       => $message
    );
    echo json_encode($articles);
}

function DeleteBankInfo()
{
    global $con;

    $bankInfoId = $_POST['itemId'];
    $status = "ok";
    $action_query = "DELETE FROM `tbl_bank_info` WHERE `tbl_bank_info`.`bank_id` = '$bankInfoId'";
    $message = "Bank info deleted";
    $result = mysqli_query($con, $action_query);

    if (!$result) {
        $status = "fail";
        $message = "Bank info with id $bankInfoId not deleted";
    }

    $articles[] = array(
        'status'         =>  $status,
        'message'       => $message
    );
    echo json_encode($articles);
}

function UpdateCardInfo()
{
    global $con;

    $userId = $_POST['userId'];
    $cardInfoId = $_POST['cardInfoId'];
    $bankId = $_POST['bankId'];
    $typeOfID = $_POST['typeOfID'];
    $typeOfCard = $_POST['typeOfCard'];
    $cardNumber = $_POST['cardNumber'];
    $expirationDate = $_POST['expirationDate'];
    $cvv = $_POST['cvv'];
    $status = $_POST['status'] == "true" ? '1' : '0';
    $newCardInfo = $_POST['newCardInfo'];

    $sql = mysqli_query($con, "select count(id) as count from tbl_bank_cards where user_fnd_id= '$userId' and type_of_id='$typeOfID' and type_of_card='$typeOfCard' and card_number='$cardNumber' and card_exp_date='$expirationDate' and cvv_number='$cvv' and id != '$cardInfoId'");

    while ($row = mysqli_fetch_array($sql)) {
        $count = $row['count'];
    }

    if ($count > 0) {
        $articles[] = array(
            'status'         =>  "false",
            'message'       => "Card info exist"
        );
        echo json_encode($articles);
        return;
    }

    $action_query = "UPDATE `tbl_bank_cards` SET `bank_id`='$bankId', `type_of_id` = '$typeOfID',`type_of_card` = '$typeOfCard', `card_number` = '$cardNumber', `card_exp_date` = '$expirationDate',`cvv_number`='$cvv', `is_active` = '$status' WHERE `tbl_bank_cards`.`id` = '$cardInfoId '";
    $message = "Card info updated";
    if ($newCardInfo == "true") {

        $action_query = "INSERT INTO `tbl_bank_cards` (`id`,`bank_id`, `user_fnd_id`,`type_of_id`, `type_of_card`, `card_number`, `card_exp_date`,`cvv_number`, `is_active`) VALUES (NULL,'$bankId', '$userId', '$typeOfID', '$typeOfCard', '$cardNumber', '$expirationDate','$cvv', '$status')";
        $message = "Card info inserted";
    }
    mysqli_query($con, $action_query);


    $articles[] = array(
        'status'         =>  "ok",
        'message'       => $message
    );
    echo json_encode($articles);
}
function DeleteCardInfo()
{
    global $con;

    $bankInfoId = $_POST['itemId'];
    $status = "ok";
    $action_query = "DELETE FROM `tbl_bank_info` WHERE `tbl_bank_info`.`bank_id` = '$bankInfoId'";
    $message = "Bank info deleted";
    $result = mysqli_query($con, $action_query);

    if (!$result) {
        $status = "fail";
        $message = "Bank info with id $bankInfoId not deleted";
    }

    $articles[] = array(
        'status'         =>  $status,
        'message'       => $message
    );
    echo json_encode($articles);
}

function GetCardInfoTable()
{
    global $con;
    $user_fnd_id = $_POST['userId'];
    $loan_create_id = $_POST['loan_create_id'];

    $sql_loan = mysqli_query($con, "SELECT `type_of_id`,`type_of_card`,`card_number`,`card_exp_date`,`bank_name`,`routing_number`,`account_number`,`cvv_number` FROM `commercial_loan_initial_banking` WHERE `loan_id` ='$loan_create_id'");
    while ($row_bank_detail = mysqli_fetch_array($sql_loan)) {
        $loan_type_of_id = $row_bank_detail['type_of_id'];
        $loan_type_of_card = $row_bank_detail['type_of_card'];
        $loan_card_number = $row_bank_detail['card_number'];
        $loan_card_exp_date = $row_bank_detail['card_exp_date'];
        $loan_bank_name = $row_bank_detail['bank_name'];
        $loan_routing_number = $row_bank_detail['routing_number'];
        $loan_account_number = $row_bank_detail['account_number'];
        $loan_cvv_number = $row_bank_detail['cvv_number'];
        break;
    }

    $cardInfo = "
            <table id='tbl_card_info' class='table table-bordered table-striped table-hover'>
            <thead>
                <tr>
                    <th hidden='true'></th>
                    <th>Type of ID</th>
                    <th>Type of Card</th>
                    <th>Card Number</th>
                    <th>Expiration Date</th>
                    <th>CVV</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>";

    // total page minus 1

    $sql_loan = mysqli_query($con, "select * from tbl_bank_cards where user_fnd_id = '$user_fnd_id' and is_active=1");

    while ($row_bank_detail_sec = mysqli_fetch_array($sql_loan)) {
        $card_id = $row_bank_detail_sec['id'];
        $type_of_id = $row_bank_detail_sec['type_of_id'];
        $type_of_card = $row_bank_detail_sec['type_of_card'];
        $card_number = $row_bank_detail_sec['card_number'];

        $card_exp_date = $row_bank_detail_sec['card_exp_date'];
        $cvv = $row_bank_detail_sec['cvv_number'];
        $is_active = $row_bank_detail_sec['is_active'] == 1 ? "Active" : "Inactive";
        $active = ($type_of_id == $loan_type_of_id && $type_of_card == $loan_type_of_card && $card_number == $loan_card_number && $card_exp_date == $loan_card_exp_date && $cvv == $loan_cvv_number) ? "table-success" : "";
        $cardInfo .= "<tr id='idCard" . $card_id . "' class='clickable-card-row " . $active . "' style='cursor: pointer';>
                <td hidden='true'>" . $card_id . "</td>
                <td>" . $type_of_id . "</td>
                <td>" . $type_of_card . "</td>
                <td>" . $card_number . "</td>
                <td>" . $card_exp_date . "</td>
                <td>" . $cvv . "</td>
                <td>" . $is_active . "</td>

                    </tr>";
    }

    $cardInfo .= "</tbody>
        </table> ";


    $bankInfo = "
            <table id='tbl_bank_info' class='table table-bordered table-striped table-hover'>
            <thead>
                <tr>
                    <th hidden='true'></th>
                    <th>Bank Name</th>
                    <th>Account Number</th>
                    <th>Routing Number</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>";
    // total page minus 1
    $sql_loan = mysqli_query($con, "select * from tbl_bank_info where usr_fnd_id = '$user_fnd_id' and is_active=1");
    while ($row_bank_detail_sec = mysqli_fetch_array($sql_loan)) {
        $bank_id = $row_bank_detail_sec['bank_id'];
        $bank_name = $row_bank_detail_sec['bank_name'];
        $routing_number = $row_bank_detail_sec['routing_number'];
        $account_number = $row_bank_detail_sec['account_number'];
        $is_active = $row_bank_detail_sec['is_active'] == 1 ? "Active" : "Inactive";
        $active = ($bank_name == $loan_bank_name && $routing_number == $loan_routing_number && $account_number == $loan_account_number) ? "table-success" : "";
        $bankInfo .= "<tr id='idBank" . $bank_id . "' class='clickable-bank-row " . $active . "' style='cursor: pointer;'>
                <td hidden='true'>" . $bank_id . "</td>
                <td>" . $bank_name . "</td>
                <td>" . $account_number . "</td>
                <td>" . $routing_number . "</td>
                <td>" . $is_active . "</td>
                </tr>";
    }

    $bankInfo .= "</tbody>
        </table> ";

    $articles[] = array(
        'cardTable'         =>  (string)$cardInfo,
        'bankTable'         =>  (string)$bankInfo,
    );
    echo json_encode($articles);
}

function GetCardInfoByBankId()
{
    global $con;
    $user_fnd_id = $_POST['userId'];
    $loan_create_id = $_POST['loan_create_id'];
    $bankId = $_POST['bankId'];

    $loan_type_of_id = "";
    $loan_type_of_card = "";
    $loan_card_number = "";
    $loan_card_exp_date = "";
    $loan_cvv_number = "";

    $query = "SELECT `type_of_id`, `type_of_card`,`card_number`,`card_exp_date`,`bank_name`,`routing_number`,`account_number`,`cvv_number` FROM `commercial_loan_initial_banking` WHERE `loan_id` ='$loan_create_id'";
    if (isset($_POST['is_card']) && $_POST['is_card'] == "true") {
        $transaction_id = $_POST['transaction_id'];
        $query = "select * from commercial_loan_transaction clt left join commercial_loan_transaction_cards_info cltci on clt.card_info = cltci.card_info_id  where transaction_id='$transaction_id'";
    }

    $sql_loan = mysqli_query($con, $query);
    while ($row_bank_detail = mysqli_fetch_array($sql_loan)) {
        $loan_type_of_id = $row_bank_detail['type_of_id'];
        $loan_type_of_card = $row_bank_detail['type_of_card'];
        $loan_card_number = $row_bank_detail['card_number'];
        $loan_card_exp_date = $row_bank_detail['card_exp_date'];
        $loan_cvv_number = $row_bank_detail['cvv_number'];
        break;
    }

    $cardInfo = "
        <table id='tbl_card_info' class='table table-bordered table-striped table-hover'>
        <thead>
            <tr>
                <th hidden='true'></th>
                <th>Type of ID</th>
                <th>Type of Card</th>
                <th>Card Number</th>
                <th>Expiration Date</th>
                <th>CVV</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>";

    // total page minus 1

    $sql_loan = mysqli_query($con, "select * from tbl_bank_cards where user_fnd_id = '$user_fnd_id' and is_active=1 and bank_id='$bankId'");

    while ($row_bank_detail_sec = mysqli_fetch_array($sql_loan)) {
        $card_id = $row_bank_detail_sec['id'];
        $type_of_id = $row_bank_detail_sec['type_of_id'];
        $type_of_card = $row_bank_detail_sec['type_of_card'];
        $card_number = $row_bank_detail_sec['card_number'];

        $card_exp_date = $row_bank_detail_sec['card_exp_date'];
        $cvv = $row_bank_detail_sec['cvv_number'];
        $is_active = $row_bank_detail_sec['is_active'] == 1 ? "Active" : "Inactive";
        $active = ($type_of_id == $loan_type_of_id && $type_of_card == $loan_type_of_card && $card_number == $loan_card_number && $card_exp_date == $loan_card_exp_date && $cvv == $loan_cvv_number) ? "table-success" : "";
        $cardInfo .= "<tr id='idCard" . $card_id . "' class='clickable-card-row " . $active . "' style='cursor: pointer';>
                        <td hidden='true'>" . $card_id . "</td>
                        <td>" . $type_of_id . "</td>
                        <td>" . $type_of_card . "</td>
                        <td>" . $card_number . "</td>
                        <td>" . $card_exp_date . "</td>
                        <td>" . $cvv . "</td>
                        <td>" . $is_active . "</td>

                    </tr>";
    }

    $cardInfo .= "</tbody>
        </table> ";

    $articles[] = array(
        'cardTable'         =>  (string)$cardInfo
    );
    echo json_encode($articles);
}

function GetBankInfoTable()
{
    global $con;
    $user_fnd_id = $_POST['userId'];
    $loan_create_id = $_POST['loan_create_id'];
    $query = "SELECT `type_of_card`,`card_number`,`card_exp_date`,`bank_name`,`routing_number`,`account_number`,`cvv_number` FROM `commercial_loan_initial_banking` WHERE `loan_id` ='$loan_create_id'";
    if (isset($_POST['is_card']) && $_POST['is_card'] == "true") {
        $transaction_id = $_POST['transaction_id'];
        $query = "select * from commercial_loan_transaction clt left join commercial_loan_transaction_cards_info cltci on clt.card_info = cltci.card_info_id  where transaction_id='$transaction_id'";
    }

    $sql_loan = mysqli_query($con, $query);
    $loan_bank_name = "";
    $loan_routing_number = "";
    $loan_account_number = "";
    while ($row_bank_detail = mysqli_fetch_array($sql_loan)) {
        $loan_type_of_card = $row_bank_detail['type_of_card'];
        $loan_card_number = $row_bank_detail['card_number'];
        $loan_card_exp_date = $row_bank_detail['card_exp_date'];
        $loan_bank_name = $row_bank_detail['bank_name'];
        $loan_routing_number = $row_bank_detail['routing_number'];
        $loan_account_number = $row_bank_detail['account_number'];
        $loan_cvv_number = $row_bank_detail['cvv_number'];
        break;
    }




    $bankInfo = "
            <table id='tbl_bank_info' class='table table-bordered table-striped table-hover'>
            <thead>
                <tr>
                    <th hidden='true'></th>
                    <th>Bank Name</th>
                    <th>Account Number</th>
                    <th>Routing Number</th>
                    <th>Account Type</th>
                    <th>Bank Type</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>";
    // total page minus 1
    $sql_loan = mysqli_query($con, "select * from tbl_bank_info where usr_fnd_id = '$user_fnd_id' and is_active=1");
    while ($row_bank_detail_sec = mysqli_fetch_array($sql_loan)) {
        $bank_id = $row_bank_detail_sec['bank_id'];
        $bank_name = $row_bank_detail_sec['bank_name'];
        $routing_number = $row_bank_detail_sec['routing_number'];
        $account_number = $row_bank_detail_sec['account_number'];
        $account_type = $row_bank_detail_sec['account_type'];
        $bank_type = $row_bank_detail_sec['bank_type'];
        $is_active = $row_bank_detail_sec['is_active'] == 1 ? "Active" : "Inactive";
        $active = ($bank_name == $loan_bank_name && $routing_number == $loan_routing_number && $account_number == $loan_account_number) ? "table-success" : "";
        $bankInfo .= "<tr id='idBank" . $bank_id . "' class='clickable-bank-row " . $active . "' style='cursor: pointer;'>
                <td hidden='true'>" . $bank_id . "</td>
                <td>" . $bank_name . "</td>
                <td>" . $account_number . "</td>
                <td>" . $routing_number . "</td>
                <td>" . $account_type . "</td>
                <td>" . $bank_type . "</td>
                <td>" . $is_active . "</td>
                </tr>";
    }

    $bankInfo .= "</tbody>
        </table> ";

    $articles[] = array(
        'bankTable'         =>  (string)$bankInfo
    );
    echo json_encode($articles);
}


function GetBankInfoByUserId()
{
    global $con;
    $userId = $_POST['userId'];
    $cardInfoId = $_POST['cardInfoId'];

    $bankInfo = "
        <table id='bankInfoTableModal'>
        <thead>
            <tr>
                <th></th>
                <th>Bank Name</th>
                <th>Account Number</th>
                <th>Routing Number</th>
            </tr>
        </thead>
        <tbody>";

    $sql_loan = mysqli_query($con, "select * from tbl_bank_info where usr_fnd_id = '$userId' and is_active=1");
    while ($row_bank_detail_sec = mysqli_fetch_array($sql_loan)) {
        $bank_id = $row_bank_detail_sec['bank_id'];
        $bank_name = $row_bank_detail_sec['bank_name'];
        $routing_number = $row_bank_detail_sec['routing_number'];
        $account_number = $row_bank_detail_sec['account_number'];
        $bankInfo .= "<tr id='idBank" . $bank_id . "'>
            <td><input type='radio' name='bank' id='rbtn_" . $bank_id . "'></td>
            <td>" . $bank_name . "</td>
            <td>" . $account_number . "</td>
            <td>" . $routing_number . "</td>
            </tr>";
    }

    $bankInfo .= "</tbody>
    </table> ";

    $articles[] = array(
        'bankTable'         =>  (string)$bankInfo,
    );
    echo json_encode($articles);
}

function InsertAllBankInformation()
{
    global $con;
    $user_fnd_id = $_POST['userId'];
    $sql_loan = mysqli_query($con, "SELECT `type_of_card`,`card_number`,`card_exp_date`,`bank_name`,`routing_number`,`account_number`,`cvv_number` FROM `commercial_loan_initial_banking` WHERE `user_fnd_id` ='$user_fnd_id'");
    while ($row_bank_detail = mysqli_fetch_array($sql_loan)) {
        $_POST['cardInfoId'] = "";
        $_POST['typeOfCard'] = $row_bank_detail['type_of_card'];
        $_POST['cardNumber'] = $row_bank_detail['card_number'];
        $_POST['expirationDate'] = $row_bank_detail['card_exp_date'];
        $_POST['cvv'] = $row_bank_detail['cvv_number'];
        $_POST['status'] = "true";
        $_POST['newCardInfo'] = "true";

        $result = UpdateCardInfo();


        $_POST['bankInfoId'] = "";
        $_POST['bankName'] = $row_bank_detail['bank_name'];
        $_POST['accountNumber'] = $row_bank_detail['account_number'];
        $_POST['routingNumber'] = $row_bank_detail['routing_number'];
        $_POST['status'] = "true";
        $_POST['newBankInfo'] = "true";

        $result = UpdateBankInfo();
    }
}

function SetChargeback()
{
    global $con;
    $u_id = $_POST["u_id"];
    $id = $_POST['id'];
    $loan_id = $_POST['loanId'];
    $transaction_id = $_POST['transactionId'];
    $chargeback_amount = $_POST['chargebackAmount'];
    $late_fee = $_POST['lateFee'];
    $convenience_fee = $_POST['convenienceFee'];
    $other_fee = $_POST['otherFee'];
    $other_fee_id = $_POST['otherFeeId'];
    $transaction_amount = $_POST['transactionAmount'];

    $skip_amount = $transaction_amount - $chargeback_amount;

    $installment_id = 0;
    $sql_chargeback = mysqli_query($con, "SELECT * FROM `tbl_commercial_loan_chargeback` where transaction_id='$transaction_id' and loan_create_id = '$loan_id'");
    while ($row_chargeback = mysqli_fetch_array($sql_chargeback)) {
        $installment_id = $row_chargeback['installment_id'];
        $installment_paid = $row_chargeback['installment_paid'];
        $late_fee_paid = $row_chargeback['late_fee_paid'];
        $convenience_fee_paid = $row_chargeback['convenience_fee_paid'];
        $other_fee_id_paid = $row_chargeback['other_fee_id'];
        $other_fee_paid = $row_chargeback['other_fee_paid'];

        if ($skip_amount >= $installment_paid) {
            $skip_amount -= $installment_paid;
            continue;
        }

        if ($late_fee_paid != "0") {
            $late_fee_paid = $late_fee == "" ? 0 : $late_fee;
        }

        if ($convenience_fee_paid != "0") {
            $convenience_fee_paid = $convenience_fee == "" ? 0 : $convenience_fee;
        }

        $chargeback_paid = $installment_paid - $skip_amount;
        $skip_amount = 0;

        $action_query = "UPDATE `tbl_commercial_loan_installments` SET `chargeback_amount`=`chargeback_amount`+'$chargeback_paid',`paid amount`=`paid amount`-$chargeback_paid, paid_late_fee = paid_late_fee - $late_fee_paid,`status` = 0 WHERE `id` = '$installment_id'";
        mysqli_query($con, $action_query);
    }

    if ($other_fee != 0) {
        $action_query = "UPDATE `tbl_other_fees` SET `amount_fee_paid`= amount_fee_paid - $other_fee WHERE `tbl_other_fees_id` = '$other_fee_id'";
        mysqli_query($con, $action_query);
    }

    $interest = 0;
    $principal_amount = 0;
    if ($transaction_amount != 0) {
        $sql_transactions = mysqli_query($con, "SELECT * FROM `commercial_loan_transaction` where loan_create_id= '$loan_id' and transaction_id = $transaction_id");
        while ($row_transaction = mysqli_fetch_array($sql_transactions)) {
            $percent = $chargeback_amount / $transaction_amount;
            $interest = -$row_transaction['interest'] * $percent;
            $principal_amount = number_format(-$row_transaction['principal_amount'] * $percent, 2);
        }
    }

    $sql_transactions = mysqli_query($con, "SELECT * FROM `commercial_loan_transaction` where loan_create_id= '$loan_id' order by transaction_id desc limit 1");
    while ($row_transaction = mysqli_fetch_array($sql_transactions)) {
        $remaining_balance = $row_transaction['remaining_balance'] - $principal_amount;
        $id = $row_transaction['loan_id'];
        $user_fnd_id = $row_transaction['user_fnd_id'];
    }

    $payment_description = "";
    $late_fee = $late_fee == 0 ? 0 : -$late_fee;
    $convenience_fee = $convenience_fee == 0 ? 0 : -$convenience_fee;
    $other_fee = $other_fee == 0 ? 0 : -$other_fee;
    $due_date = strftime('%Y-%m-%d', strtotime("now"));
    $payment_method = "Chargeback (" . $transaction_id . ")";

    $query_insert_trans = "INSERT INTO `commercial_loan_transaction`(`loan_id`, `loan_create_id`, `user_fnd_id`, `installment_id`, 
    `payment_amount`, `interest`, `principal_amount`, `remaining_balance`, `late_fee`,
     `convenience_fee` ,`other_fee`,`other_fee_id`, `payment_date`, `payment_description`,`payment_method`, `created_at`, `created_by`) VALUES ('$id','$loan_id','$user_fnd_id','$installment_id',
     '-$chargeback_amount','$interest','$principal_amount','$remaining_balance','$late_fee','$convenience_fee','$other_fee','$other_fee_id',
     '$due_date','$payment_description','$payment_method','$due_date','$u_id')";
    $result_insert_trans = mysqli_query($con, $query_insert_trans);

    $action_query = "UPDATE `commercial_loan_transaction` SET `is_chargeback`=1 WHERE `transaction_id` = '$transaction_id'";
    mysqli_query($con, $action_query);


    mysqli_query($con, "INSERT INTO tbl_lists (kind, item) select 'Other Fee', 'Chargeback Fee' where not exists( select * from tbl_lists where kind='Other Fee' and item='Chargeback Fee')");

    $sql = mysqli_query($con, "select tbl_lists_id from tbl_lists where kind='Other Fee' and item='Chargeback Fee'");

    while ($row = mysqli_fetch_array($sql)) {
        $kind = $row['tbl_lists_id'];
    }

    $action_query = "UPDATE `tbl_other_fees` SET `amount_fee`=`amount_fee` + 15 WHERE `loan_created_id` = '$loan_id' AND `kind_fee` = $kind AND `user_fnd_id` = '$user_fnd_id'";
    $update_result = mysqli_query($con, $action_query);

    if (if_insert($con)) {
        $action_query = "INSERT INTO `tbl_other_fees` (`tbl_other_fees_id`, `kind_fee`, `user_fnd_id`, `loan_created_id`, `amount_fee`, `amount_fee_paid`) VALUES (NULL, '$kind', '$user_fnd_id', '$loan_id', 15, 0)";
        mysqli_query($con, $action_query);
        $other_fee_transaction = mysqli_insert_id($con);
    }

    $action_query = "UPDATE `commercial_loan_transaction` SET `chargeback_fee`=15, `chargeback_fee_id` = (SELECT tbl_other_fees_id from tbl_other_fees  WHERE `loan_created_id` = '$loan_id' AND `kind_fee` = $kind AND `user_fnd_id` = '$user_fnd_id') WHERE `transaction_id` = '$transaction_id'";
    mysqli_query($con, $action_query);

    $message = "Chargeback added";

    $articles[] = array(
        'status'         =>  "ok",
        'message'       => $message
    );
    echo json_encode($articles);
}

function UpdateOtherFee()
{
    global $con;
    $userId = $_POST['userId'];
    $loanId = $_POST['loanId'];
    $otherFeeId = $_POST['otherFeeId'];
    $description = $_POST['description'];
    $amountFee = $_POST['amountFee'];
    $newOtherFee = $_POST['newOtherFee'];

    mysqli_query($con, "INSERT INTO tbl_lists (kind, item) select 'Other Fee', '$description' where not exists( select * from tbl_lists where kind='Other Fee' and item='$description')");

    $sql = mysqli_query($con, "select tbl_lists_id from tbl_lists where kind='Other Fee' and item='$description'");

    while ($row = mysqli_fetch_array($sql)) {
        $kind = $row['tbl_lists_id'];
    }

    // if ($count > 0) {
    //     $articles[] = array(
    //         'status'         =>  "false",
    //         'message'       => "Bank info exist"
    //     );
    //     echo json_encode($articles);
    //     return;
    // }

    $action_query = "UPDATE `tbl_other_fees` SET `kind_fee` = '$kind', `amount_fee` = '$amountFee', `user_fnd_id` = '$userId',`loan_created_id` = '$loanId' WHERE `tbl_other_fees_id` = '$otherFeeId'";
    $message = "Other fee updated";
    if ($newOtherFee == "true") {

        $action_query = "INSERT INTO `tbl_other_fees` (`tbl_other_fees_id`, `kind_fee`, `user_fnd_id`, `loan_created_id`, `amount_fee`, `amount_fee_paid`) VALUES (NULL, '$kind', '$userId', '$loanId', '$amountFee', 0)";
        $message = "Other fee inserted";
    }
    mysqli_query($con, $action_query);


    $articles[] = array(
        'status'         =>  "ok",
        'message'       => $message
    );
    echo json_encode($articles);
}

function DeleteOtherFee()
{
    global $con;

    $other_fee_id = $_POST['itemId'];
    $status = "ok";
    $action_query = "DELETE FROM `tbl_other_fees` WHERE `tbl_other_fees`.`tbl_other_fees_id` = '$other_fee_id'";
    $message = "Other fee deleted";
    $result = mysqli_query($con, $action_query);

    if (!$result) {
        $status = "fail";
        $message = "Other fee with id $other_fee_id not deleted";
    }

    $articles[] = array(
        'status'         =>  $status,
        'message'       => $message
    );
    echo json_encode($articles);
}

function GetUnpaidOtherFee()
{
    global $con;

    $id = $_POST["id"];

    $sql = mysqli_query($con, "SELECT (amount_fee - amount_fee_paid) as nonpaid from tbl_other_fees where tbl_other_fees_id = '$id'");

    $nonpaid = 0;
    while ($row = mysqli_fetch_array($sql)) {
        $nonpaid = $row['nonpaid'];
    }

    $articles[] = array(
        'status'         =>  "ok",
        'nonpaid'       => $nonpaid
    );
    echo json_encode($articles);
}

function UpdateTransaction()
{
    global $con;
    $u_id = $_POST["u_id"];
    $user_fnd_id = $_POST["user_fnd_id"];
    $loan_id = $_POST['loan_id'];
    $transaction_id = $_POST['transaction_id'];

    $to_be_paid_amount = $_POST['to_be_paid_amount'];
    $other_fee = $_POST['other_fee'];
    $late_fee = $_POST['late_fee'];
    $convenience_fee = $_POST['convenience_fee'];
    $type_of_description = $_POST['type_of_description'];
    $payment_method = $_POST['payment_method'];
    $payment_description = $_POST['payment_description'];

    $sql_loan = mysqli_query($con, "select * from commercial_loan_transaction clt left join commercial_loan_transaction_cards_info cltci on clt.card_info = cltci.card_info_id left join tbl_other_fees tof on other_fee_id = tof.tbl_other_fees_id left join tbl_lists tl on tof.kind_fee = tl.tbl_lists_id  where transaction_id='$transaction_id'");
    while ($row_loan = mysqli_fetch_array($sql_loan)) {
        $payment_amount = $row_loan['payment_amount'];
        $interest = $row_loan['interest'];
        $principal_amount = $row_loan['principal_amount'];
        $remaining_balance = $row_loan['remaining_balance'];
        $prev_late_fee = $row_loan['late_fee'];
        $prev_convenience_fee = $row_loan['convenience_fee'];
        $prev_other_fee = $row_loan['other_fee'];
        $prev_other_fee_id = $row_loan['other_fee_id'];
        $prev_payment_method = $row_loan['payment_method'];
        $card_info = $row_loan['card_info'];
        $prev_payment_description = $row_loan['payment_description'];
        $item = $row_loan['item'];
        $bank_name = $row_loan['bank_name'];
        $account_number = $row_loan['account_number'];
        $routing_number = $row_loan['routing_number'];
        $account_type = $row_loan['account_type'];
        $bank_type = $row_loan['bank_type'];
        $type_of_id = $row_loan['type_of_id'];
        $type_of_card = $row_loan['type_of_card'];
        $card_number = $row_loan['card_number'];
        $card_exp_date = $row_loan['card_exp_date'];
        $cvv_number = $row_loan['cvv_number'];
    }

    if ($late_fee == "") {
        $late_fee = $prev_late_fee;
    }
    if ($convenience_fee == "") {
        $convenience_fee = $prev_convenience_fee;
    }
    if ($type_of_description == "") {
        if ($other_fee == "0") {
            $other_fee_id = 0;
            $other_fee = 0;
        } else {
            $other_fee = $prev_other_fee;
            $other_fee_id =  $prev_other_fee_id;
            $type_of_description = "$item ($other_fee_id)";
        }
    }
    if ($payment_description == "") {
        $payment_description =  $prev_payment_description;
    }

    if ($payment_method == "") {
        $payment_method = $prev_payment_method;
    } else {
        if ($card_info != 0) {
            mysqli_query($con, "DELETE FROM commercial_loan_transaction_cards_info where card_info_id='$card_info'");
        }
    }


    if ($to_be_paid_amount == "") {
        $to_be_paid_amount = $payment_amount;
    }

    $db_totalamountpaid = $to_be_paid_amount;
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

    /******
     * * Increase paid amount and paid late fee from installments and other fee amount form other fees related to tbl_commercial_loan_chargeback table
     */
    $sql_chargeback = mysqli_query($con, "SELECT * FROM `tbl_commercial_loan_chargeback` where transaction_id='$transaction_id' and loan_create_id = '$loan_id'");
    while ($row_chargeback = mysqli_fetch_array($sql_chargeback)) {
        $installment_id = $row_chargeback['installment_id'];
        $installment_paid = $row_chargeback['installment_paid'];
        $late_fee_paid = $row_chargeback['late_fee_paid'];
        $convenience_fee_paid = $row_chargeback['convenience_fee_paid'];
        $other_fee_id_paid = $row_chargeback['other_fee_id'];
        $other_fee_paid = $row_chargeback['other_fee_paid'];
        mysqli_query($con, "UPDATE tbl_commercial_loan_installments SET status = 0, `paid amount`=`paid amount` -  $installment_paid, paid_late_fee = paid_late_fee - $late_fee_paid  where id = $installment_id");
        mysqli_query($con, "UPDATE tbl_other_fees SET amount_fee_paid = amount_fee_paid - $other_fee_paid  where tbl_other_fees_id = $other_fee_id_paid");
    }

    mysqli_query($con, "DELETE FROM tbl_commercial_loan_chargeback where transaction_id='$transaction_id' and loan_create_id = '$loan_id'");


    $if_empty_payment = $to_be_paid_amount == 0;

    if ($if_empty_payment) {
        $query_payment = mysqli_query($con, "Select remaining_balance from commercial_loan_transaction where loan_create_id = '$loan_id' order by transaction_id desc limit 2");
        $count = 0;
        while ($row = mysqli_fetch_array($query_payment)) {
            $count++;
            $rem_balance  = $row['remaining_balance'];
        }

        if ($count == 1) {
            $sql_loan = mysqli_query($con, "SELECT * FROM `tbl_commercial_loan` where loan_create_id = '$loan_id'");
            while ($row_loan = mysqli_fetch_array($sql_loan)) {
                $rem_balance = $row_loan["amount_of_loan"];
            }
        }
    }

    $sum_interest_amount = 0;
    $sum_principle_amount = 0;
    $late_fee_is_paid = FALSE;
    $continue = true;
    $installment_dict = [];

    $query_payment = mysqli_query($con, "Select payment, `id`, `paid amount`, balance, interest, principal, paid_late_fee from `tbl_commercial_loan_installments` where loan_create_id = '$loan_id' and status = 0 order by id asc");
    while ($row_payment = mysqli_fetch_array($query_payment)) {
        if ($to_be_paid_amount == 0) {
            break;
        }

        $intallment_id = $row_payment['id'];
        $payment = $row_payment['payment'];
        $paid_amount = $row_payment['paid amount'];
        $rem_balance = str_replace(",", "", $row_payment['balance']);
        $db_interestpaid = $row_payment['interest'];
        $db_principlepaid = $row_payment['principal'];
        $percent = 1;
        if ($to_be_paid_amount + $paid_amount >= $payment) {
            $to_paid = $payment - $paid_amount;
            $to_be_paid_amount -= $to_paid;
            $status = '1';
        } else {
            $to_paid = $to_be_paid_amount;
            $status = '0';
            $to_be_paid_amount = 0;
            $percent_balance = ($to_paid + $paid_amount) / $payment;
            $rem_balance += $db_principlepaid;
            $principal_balance = $db_principlepaid * $percent_balance;
            $rem_balance =  $rem_balance - number_format($principal_balance, 2);
        }

        $percent = $to_paid / $payment;
        $db_interestpaid = $db_interestpaid * $percent;
        $db_principlepaid = $db_principlepaid * $percent;

        $sum_interest_amount += $db_interestpaid;
        $sum_principle_amount += $db_principlepaid;

        $paid_late_fee = 0;
        if (!$late_fee_is_paid) {
            $late_fee_is_paid = TRUE;
            $paid_late_fee = $late_fee + $row_payment['paid_late_fee'];
        }

        mysqli_query($con, "UPDATE tbl_commercial_loan_installments SET `paid_late_fee` = '$paid_late_fee', `paid amount`= `paid amount` + '$to_paid',status=$status, payment_description='$payment_description'  where id ='$intallment_id'");

        $installment_dict[$intallment_id] = $to_paid;
    }

    if (isset($payment)) {
        $db_interestpaid = $sum_interest_amount;
        $db_principlepaid = $sum_principle_amount;
    }

    if ($type_of_description != "") {
        $other_fee_id = str_replace(array("(", ")"), array("", ""), end(explode(" ", $type_of_description)));
        mysqli_query($con, "UPDATE tbl_other_fees SET amount_fee_paid = amount_fee_paid + $other_fee where tbl_other_fees_id = $other_fee_id");
    }

    mysqli_query($con, "UPDATE commercial_loan_transaction SET `payment_amount` = $db_totalamountpaid, `interest` = $db_interestpaid, `principal_amount` = $db_principlepaid, `remaining_balance` = $rem_balance, `late_fee` = $late_fee, `convenience_fee` = $convenience_fee ,`other_fee` = $other_fee,`other_fee_id`=$other_fee_id,`payment_description` = '$payment_description',`payment_method` = '$payment_method' where transaction_id=$transaction_id");



    if (isset($_POST['bankExists']) && isset($_POST['cardExists'])) {
        $query_transaction = "INSERT INTO `commercial_loan_transaction_cards_info` (`card_info_id`,`type_of_id`, `type_of_card`, `card_number`, `card_exp_date`, `cvv_number`, `bank_name`, `account_number`, `routing_number`, `account_type`, `bank_type`) VALUES ('','$typeOfID', '$typeOfCard', '$cardNumber', '$expDate', '$cvv', '$bankName', '$accountNumber', '$routingNumber', '$accountType', '$bankType')";
        $result = mysqli_query($con, $query_transaction);
        $card_info_id = mysqli_insert_id($con);

        mysqli_query($con, "UPDATE commercial_loan_transaction SET card_info='$card_info_id' where transaction_id ='$transaction_id'");
    }

    if ($if_empty_payment) {
        $installment_dict[0] = 0;
    }

    foreach ($installment_dict as $installment_id => $paid_amount) {
        $query_insert_chargeback = "INSERT INTO `tbl_commercial_loan_chargeback` (`id`, `loan_create_id`, `transaction_id`, `installment_id`, `installment_paid`, `late_fee_paid`, `convenience_fee_paid`, `other_fee_id`, `other_fee_paid`) VALUES (NULL, $loan_id, $transaction_id, $installment_id,  $paid_amount, $late_fee, $convenience_fee, $other_fee_id,  $other_fee)";
        $result_insert_chargeback = mysqli_query($con, $query_insert_chargeback);
        $late_fee = 0;
        $convenience_fee = 0;
        $other_fee_id = 0;
        $other_fee = 0;
    }




    /******
     * 
     * * FLOW
     * //TODO: unpaid relevant installments
     * //TODO: decrease 'paid_late_fee' to previous value
     * //TODO: decrease other fees from 'tbl_other_fees'
     * //TODO: update relevant transaction
     * //TODO: update card_info
     * TODO: delete relevant chargeback
     */




    /**
     * * Chargeback
     * TODO: recalculate interest, principal and balance according to new payment amount
     * TODO: recalculate late fee, convenience fee, other fee
     * TODO: recalculate relevant installment paid amount, paid late fee, chargeback amount



     */
    $message = "Transaction updated";

    $articles[] = array(
        'status'         =>  "ok",
        'message'       => $message
    );
    echo json_encode($articles);
}

function UpdateChargebackTransaction()
{
    global $con;
    $u_id = $_POST["u_id"];
    $user_fnd_id = $_POST["user_fnd_id"];
    $loan_id = $_POST['loan_id'];
    $chargeback_transaction_id = $_POST['transaction_id'];

    $to_be_paid_amount = $_POST['to_be_paid_amount'];
    $other_fee = $_POST['other_fee'];
    $late_fee = $_POST['late_fee'];
    $convenience_fee = $_POST['convenience_fee'];
    $type_of_description = $_POST['type_of_description'];
    $payment_method = $_POST['payment_method'];
    $payment_description = $_POST['payment_description'];

    // * original transaction
    $sql_loan = mysqli_query($con, "select * from commercial_loan_transaction clt left join commercial_loan_transaction_cards_info cltci on clt.card_info = cltci.card_info_id left join tbl_other_fees tof on other_fee_id = tof.tbl_other_fees_id left join tbl_lists tl on tof.kind_fee = tl.tbl_lists_id  where transaction_id='$chargeback_transaction_id'");
    while ($row_loan = mysqli_fetch_array($sql_loan)) {
        $payment_amount = $row_loan['payment_amount'];
        $late_fee_chargeback = $row_loan['late_fee'];
        $convenience_fee_chargeback = $row_loan['convenience_fee'];
        $other_fee_chargeback = $row_loan['other_fee'];
        $other_fee_id = $row_loan['other_fee_id'];
        $item = $row_loan['item'];
    }

    $tmp = explode(" ", $payment_method);
    $last =  end($tmp);
    $transaction_id = str_replace(array("(", ")"), array("", ""), $last);

    $sql_chargeback = mysqli_query($con, "SELECT sum(`installment_paid`) as transaction_amount FROM `tbl_commercial_loan_chargeback` where transaction_id='$transaction_id' and loan_create_id = '$loan_id'");
    while ($row_chargeback = mysqli_fetch_array($sql_chargeback)) {
        $transaction_amount = $row_chargeback['transaction_amount'];
    }

    $skip_amount = $transaction_amount + $payment_amount; // * payment_amount - negative number

    $sql_chargeback = mysqli_query($con, "SELECT * FROM `tbl_commercial_loan_chargeback` where transaction_id='$transaction_id' and loan_create_id = '$loan_id'");
    while ($row_chargeback = mysqli_fetch_array($sql_chargeback)) {
        $installment_id = $row_chargeback['installment_id'];
        $installment_paid = $row_chargeback['installment_paid'];
        $late_fee_paid = $row_chargeback['late_fee_paid'];
        $convenience_fee_paid = $row_chargeback['convenience_fee_paid'];
        $other_fee_id_paid = $row_chargeback['other_fee_id'];
        $other_fee_paid = $row_chargeback['other_fee_paid'];

        if ($skip_amount >= $installment_paid) {
            $skip_amount -= $installment_paid;
            continue;
        }

        if ($late_fee_paid != "0") {
            $late_fee_paid = $late_fee_chargeback;
        }

        if ($convenience_fee_paid != "0") {
            $convenience_fee_paid = $convenience_fee_chargeback;
        }

        $chargeback_paid = $installment_paid - $skip_amount;
        $skip_amount = 0;
        $action_query = "UPDATE `tbl_commercial_loan_installments` SET `chargeback_amount`=`chargeback_amount`-'$chargeback_paid',`paid amount`=`paid amount`+$chargeback_paid, paid_late_fee = paid_late_fee - $late_fee_paid, status = (select if(payment=`paid amount`+$chargeback_paid,1,0) from (select * from `tbl_commercial_loan_installments`) as t where id = '$installment_id') WHERE `id` = '$installment_id'";
        mysqli_query($con, $action_query);
    }

    if ($other_fee_chargeback != 0) {
        $action_query = "UPDATE `tbl_other_fees` SET `amount_fee_paid`= amount_fee_paid - $other_fee_chargeback WHERE `tbl_other_fees_id` = '$other_fee_id'";
        mysqli_query($con, $action_query);
    }





    // * Update chargeback transaction with installments


    if ($to_be_paid_amount == "") {
        $to_be_paid_amount = -$payment_amount;
    }

    if ($late_fee == "") {
        $late_fee = -$late_fee_chargeback;
    }

    if ($convenience_fee == "") {
        $convenience_fee = -$convenience_fee_chargeback;
    }

    if ($other_fee == "") {
        $other_fee = -$other_fee_chargeback;
    }

    $skip_amount = $transaction_amount - $to_be_paid_amount;

    $installment_id = 0;
    $sql_chargeback = mysqli_query($con, "SELECT * FROM `tbl_commercial_loan_chargeback` where transaction_id='$transaction_id' and loan_create_id = '$loan_id'");
    while ($row_chargeback = mysqli_fetch_array($sql_chargeback)) {
        $installment_id = $row_chargeback['installment_id'];
        $installment_paid = $row_chargeback['installment_paid'];
        $late_fee_paid = $row_chargeback['late_fee_paid'];
        $convenience_fee_paid = $row_chargeback['convenience_fee_paid'];
        $other_fee_id_paid = $row_chargeback['other_fee_id'];
        $other_fee_paid = $row_chargeback['other_fee_paid'];

        if ($skip_amount >= $installment_paid) {
            $skip_amount -= $installment_paid;
            continue;
        }

        if ($late_fee_paid != 0) {
            $late_fee_paid = $late_fee;
        }

        if ($convenience_fee_paid != 0) {
            $convenience_fee_paid = $convenience_fee;
        }

        $chargeback_paid = $installment_paid - $skip_amount;
        $skip_amount = 0;

        $action_query = "UPDATE `tbl_commercial_loan_installments` SET `chargeback_amount`=`chargeback_amount`+'$chargeback_paid',`paid amount`=`paid amount`-$chargeback_paid, paid_late_fee = paid_late_fee - $late_fee_paid,`status` = 0 WHERE `id` = '$installment_id'";
        mysqli_query($con, $action_query);
    }

    if ($other_fee != 0) {
        $action_query = "UPDATE `tbl_other_fees` SET `amount_fee_paid`= amount_fee_paid - $other_fee WHERE `tbl_other_fees_id` = '$other_fee_id'";
        mysqli_query($con, $action_query);
    }

    $interest = 0;
    $principal_amount = 0;
    if ($transaction_amount != 0) {
        $sql_transactions = mysqli_query($con, "SELECT * FROM `commercial_loan_transaction` where loan_create_id= '$loan_id' and transaction_id = $transaction_id");
        while ($row_transaction = mysqli_fetch_array($sql_transactions)) {
            $percent = $to_be_paid_amount / $transaction_amount;
            $interest = -$row_transaction['interest'] * $percent;
            $principal_amount = number_format(-$row_transaction['principal_amount'] * $percent, 2);
        }
    }

    $sql_transactions = mysqli_query($con, "SELECT * FROM `commercial_loan_transaction` where loan_create_id= '$loan_id' and transaction_id != '$chargeback_transaction_id' order by transaction_id desc limit 1");
    while ($row_transaction = mysqli_fetch_array($sql_transactions)) {
        $remaining_balance = $row_transaction['remaining_balance'] - $principal_amount;
        $id = $row_transaction['loan_id'];
        $user_fnd_id = $row_transaction['user_fnd_id'];
    }


    $payment_description = "";
    $late_fee = $late_fee == 0 ? 0 : -$late_fee;
    $convenience_fee = $convenience_fee == 0 ? 0 : -$convenience_fee;
    $other_fee = $other_fee == 0 ? 0 : -$other_fee;

    $action_query = "UPDATE `commercial_loan_transaction` SET `payment_amount` = '-$to_be_paid_amount', `interest` = '$interest', `principal_amount` ='$principal_amount', `remaining_balance` = '$remaining_balance', `late_fee` = '$late_fee',
    `convenience_fee` = '$convenience_fee' ,`other_fee` = '$other_fee',`payment_description` = '$payment_description' WHERE `transaction_id` = '$chargeback_transaction_id'";
    mysqli_query($con, $action_query);

    $message = "Chargeback transaction updated";

    $articles[] = array(
        'status'         =>  "ok",
        'message'       => $message
    );
    echo json_encode($articles);
}

function DeleteChargebackTransaction()
{
    global $con;
    $chargeback_transaction_id = $_POST["transactionId"];

    // * original transaction
    $sql_loan = mysqli_query($con, "select * from commercial_loan_transaction clt left join commercial_loan_transaction_cards_info cltci on clt.card_info = cltci.card_info_id left join tbl_other_fees tof on other_fee_id = tof.tbl_other_fees_id left join tbl_lists tl on tof.kind_fee = tl.tbl_lists_id  where transaction_id='$chargeback_transaction_id'");
    while ($row_loan = mysqli_fetch_array($sql_loan)) {
        $payment_amount = $row_loan['payment_amount'];
        $late_fee_chargeback = $row_loan['late_fee'];
        $convenience_fee_chargeback = $row_loan['convenience_fee'];
        $other_fee_chargeback = $row_loan['other_fee'];
        $other_fee_id = $row_loan['other_fee_id'];
        $item = $row_loan['item'];
        $payment_method = $row_loan['payment_method'];
        $loan_id = $row_loan['loan_create_id'];
    }

    $tmp = explode(" ", $payment_method);
    $last =  end($tmp);
    $transaction_id = str_replace(array("(", ")"), array("", ""), $last);

    $sql_chargeback = mysqli_query($con, "SELECT sum(`installment_paid`) as transaction_amount FROM `tbl_commercial_loan_chargeback` where transaction_id='$transaction_id' and loan_create_id = '$loan_id'");
    while ($row_chargeback = mysqli_fetch_array($sql_chargeback)) {
        $transaction_amount = $row_chargeback['transaction_amount'];
    }

    $skip_amount = $transaction_amount + $payment_amount; // * payment_amount - negative number

    $sql_chargeback = mysqli_query($con, "SELECT * FROM `tbl_commercial_loan_chargeback` where transaction_id='$transaction_id' and loan_create_id = '$loan_id'");
    while ($row_chargeback = mysqli_fetch_array($sql_chargeback)) {
        $installment_id = $row_chargeback['installment_id'];
        $installment_paid = $row_chargeback['installment_paid'];
        $late_fee_paid = $row_chargeback['late_fee_paid'];
        $convenience_fee_paid = $row_chargeback['convenience_fee_paid'];
        $other_fee_id_paid = $row_chargeback['other_fee_id'];
        $other_fee_paid = $row_chargeback['other_fee_paid'];

        if ($skip_amount >= $installment_paid) {
            $skip_amount -= $installment_paid;
            continue;
        }

        if ($late_fee_paid != "0") {
            $late_fee_paid = $late_fee_chargeback;
        }

        if ($convenience_fee_paid != "0") {
            $convenience_fee_paid = $convenience_fee_chargeback;
        }

        $chargeback_paid = $installment_paid - $skip_amount;
        $skip_amount = 0;
        $action_query = "UPDATE `tbl_commercial_loan_installments` SET `chargeback_amount`=`chargeback_amount`-'$chargeback_paid',`paid amount`=`paid amount`+$chargeback_paid, paid_late_fee = paid_late_fee - $late_fee_paid, status = (select if(payment=`paid amount`+$chargeback_paid,1,0) from (select * from `tbl_commercial_loan_installments`) as t where id = '$installment_id') WHERE `id` = '$installment_id'";
        mysqli_query($con, $action_query);
    }

    if ($other_fee_chargeback != 0) {
        $action_query = "UPDATE `tbl_other_fees` SET `amount_fee_paid`= amount_fee_paid - $other_fee_chargeback WHERE `tbl_other_fees_id` = '$other_fee_id'";
        mysqli_query($con, $action_query);
    }

    $sql_other_fees = mysqli_query($con, "SELECT * FROM `tbl_other_fees` where kind_fee = (select tbl_lists_id from tbl_lists where kind='Other Fee' and item='Chargeback Fee' ) AND loan_created_id = '$loan_id'");
    while ($row_fees = mysqli_fetch_array($sql_other_fees)) {
        $amount_fee = $row_fees['amount_fee'];
        $amount_fee_paid = $row_fees['amount_fee_paid'];
        $tbl_other_fees_id = $row_fees['tbl_other_fees_id'];

        $action_query = "UPDATE `tbl_other_fees` SET `amount_fee`= amount_fee - 15 WHERE `tbl_other_fees_id` = '$tbl_other_fees_id'";
        if ($amount_fee <= 15) {
            $action_query = "DELETE FROM `tbl_other_fees` WHERE `tbl_other_fees_id` = '$tbl_other_fees_id'";
        }

        mysqli_query($con, $action_query);
    }


    $action_query = "UPDATE `commercial_loan_transaction` SET `is_chargeback`=0 WHERE `transaction_id` = '$transaction_id'";
    mysqli_query($con, $action_query);

    mysqli_query($con, "DELETE FROM commercial_loan_transaction where transaction_id='$chargeback_transaction_id' and loan_create_id = '$loan_id'");

    $message = "Chargeback transaction deleted";

    $articles[] = array(
        'status'         =>  "ok",
        'message'       => $message
    );
    echo json_encode($articles);
}

function DeleteTransaction()
{
    global $con;
    $transaction_id = $_POST['transactionId'];

    $sql_loan = mysqli_query($con, "select * from commercial_loan_transaction clt left join commercial_loan_transaction_cards_info cltci on clt.card_info = cltci.card_info_id left join tbl_other_fees tof on other_fee_id = tof.tbl_other_fees_id left join tbl_lists tl on tof.kind_fee = tl.tbl_lists_id  where transaction_id='$transaction_id'");
    while ($row_loan = mysqli_fetch_array($sql_loan)) {
        $loan_create_id = $row_loan['loan_create_id'];
        $payment_amount = $row_loan['payment_amount'];
        $interest = $row_loan['interest'];
        $principal_amount = $row_loan['principal_amount'];
        $remaining_balance = $row_loan['remaining_balance'];
        $prev_late_fee = $row_loan['late_fee'];
        $prev_convenience_fee = $row_loan['convenience_fee'];
        $prev_other_fee = $row_loan['other_fee'];
        $prev_other_fee_id = $row_loan['other_fee_id'];
        $payment_method = $row_loan['payment_method'];
        $card_info = $row_loan['card_info'];
        $prev_payment_description = $row_loan['payment_description'];
        $item = $row_loan['item'];
        $bank_name = $row_loan['bank_name'];
        $account_number = $row_loan['account_number'];
        $routing_number = $row_loan['routing_number'];
        $account_type = $row_loan['account_type'];
        $bank_type = $row_loan['bank_type'];
        $type_of_id = $row_loan['type_of_id'];
        $type_of_card = $row_loan['type_of_card'];
        $card_number = $row_loan['card_number'];
        $card_exp_date = $row_loan['card_exp_date'];
        $cvv_number = $row_loan['cvv_number'];
    }

    $sql_chargeback = mysqli_query($con, "SELECT * FROM `tbl_commercial_loan_chargeback` where transaction_id='$transaction_id' and loan_create_id = '$loan_create_id'");
    while ($row_chargeback = mysqli_fetch_array($sql_chargeback)) {
        $installment_id = $row_chargeback['installment_id'];
        $installment_paid = $row_chargeback['installment_paid'];
        $late_fee_paid = $row_chargeback['late_fee_paid'];
        $convenience_fee_paid = $row_chargeback['convenience_fee_paid'];
        $other_fee_id_paid = $row_chargeback['other_fee_id'];
        $other_fee_paid = $row_chargeback['other_fee_paid'];
        mysqli_query($con, "UPDATE tbl_commercial_loan_installments SET status = 0, `paid amount`=`paid amount` -  $installment_paid, paid_late_fee = paid_late_fee - $late_fee_paid, dpd = 0 where id = $installment_id");
        mysqli_query($con, "UPDATE tbl_other_fees SET amount_fee_paid = amount_fee_paid - $other_fee_paid  where tbl_other_fees_id = $other_fee_id_paid");
    }

    mysqli_query($con, "DELETE FROM tbl_commercial_loan_chargeback where transaction_id='$transaction_id' and loan_create_id = '$loan_create_id'");

    mysqli_query($con, "DELETE FROM commercial_loan_transaction where transaction_id='$transaction_id' and loan_create_id = '$loan_create_id'");

    if ($card_info != 0) {
        mysqli_query($con, "DELETE FROM commercial_loan_transaction_cards_info where card_info_id='$card_info'");
    }

    if ($payment_method == "Repay") {
        /**
         * TODO: disable repay transaction via Repay API
         */
        $sql_repay = mysqli_query($con, "SELECT * FROM `tbl_pay_with_card` where loan_transaction_id='$transaction_id' and loan_create_id = '$loan_create_id'");
        while ($row_repay = mysqli_fetch_array($sql_repay)) {
            $repay_transaction_id = $row_repay['transaction_id'];
            $amount = $row_repay['amount'];
        }

        $sql_payment_api = mysqli_query($con, "select * from payment_api_urls where name='live_url2'");

        while ($row_payment_api = mysqli_fetch_array($sql_payment_api)) {

            $url_payment_api = $row_payment_api['url'];
            $app_token_payment = $row_payment_api['token'];
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "$url_payment_api/checkout/merchant/api/v1/refund/$repay_transaction_id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "amount": "' . $amount . '"
                }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                "Authorization: $app_token_payment"
            ),
        ));
    }

    $status = "ok";
    $message = "Transaction with id $transaction_id deleted";
    $articles[] = array(
        'status'         =>  $status,
        'message'       => $message
    );
    echo json_encode($articles);
}

function GetEditTransactionModal()
{
    global $con;
    $u_id = $_POST["u_id"];
    $user_fnd_id = $_POST["user_fnd_id"];
    $loan_id = $_POST['loanId'];
    $transaction_id = $_POST['transactionId'];

    $sql_loan = mysqli_query($con, "select * from commercial_loan_transaction clt left join commercial_loan_transaction_cards_info cltci on clt.card_info = cltci.card_info_id left join tbl_other_fees tof on other_fee_id = tof.tbl_other_fees_id left join tbl_lists tl on tof.kind_fee = tl.tbl_lists_id  where transaction_id='$transaction_id'");

    while ($row_loan = mysqli_fetch_array($sql_loan)) {
        $payment_amount = $row_loan['payment_amount'];
        $interest = $row_loan['interest'];
        $principal_amount = $row_loan['principal_amount'];
        $remaining_balance = $row_loan['remaining_balance'];
        $late_fee = $row_loan['late_fee'];
        $convenience_fee = $row_loan['convenience_fee'];
        $other_fee = $row_loan['other_fee'];
        $other_fee_id = $row_loan['other_fee_id'];
        $payment_method = $row_loan['payment_method'];
        $card_info = $row_loan['card_info'];
        $payment_description = $row_loan['payment_description'];
        $item = $row_loan['item'];
        $bank_name = $row_loan['bank_name'];
        $account_number = $row_loan['account_number'];
        $routing_number = $row_loan['routing_number'];
        $account_type = $row_loan['account_type'];
        $bank_type = $row_loan['bank_type'];
        $type_of_id = $row_loan['type_of_id'];
        $type_of_card = $row_loan['type_of_card'];
        $card_number = $row_loan['card_number'];
        $card_exp_date = $row_loan['card_exp_date'];
        $cvv_number = $row_loan['cvv_number'];
    }


    $other_fee_description = "";
    if ($other_fee_id != 0) {
        $other_fee_description = " - $item($other_fee_id)";
    }
    $card_info = '';
    if ($bank_name != null) {
        $card_info = '
        <div class="row">
            <div class="col-lg-2">
                <span><b>Bank Name:</b> ' . $bank_name . ' </span>
            </div>
            <div class="col-lg-2">
                <span><b>Account Number:</b> ' . $account_number . ' </span>
            </div>
            <div class="col-lg-2">
                <span><b>Routing Number:</b> ' . $routing_number . ' </span>
            </div>
            <div class="col-lg-2">
                <span><b>Account Type:</b> ' . $account_type . ' </span>
            </div>
            <div class="col-lg-2">
                <span><b>Bank Type:</b> ' . $bank_type . ' </span>
            </div>
            <div class="col-lg-2">
                <span><b>Type Of ID:</b> ' . $type_of_id . ' </span>
            </div>
            <div class="col-lg-2">
                <span><b>Type Of Card:</b> ' . $type_of_card . ' </span>
            </div>
            <div class="col-lg-2">
                <span><b>Card Number:</b> ' . $card_number . ' </span>
            </div>
            <div class="col-lg-2">
                <span><b>Expiration Date:</b> ' . $card_exp_date . ' </span>
            </div>
            <div class="col-lg-2">
                <span><b>CVV:</b> ' . $cvv_number . ' </span>
            </div>
        </div>      
    ';
    }

    $payment_definition = array("placeholder" => "", "disabled" => "", "max" => "");
    $late_fee_definition = array("placeholder" => "", "disabled" => "", "max" => "");
    $convenience_fee_definition = array("placeholder" => "", "disabled" => "", "max" => "");
    $other_fee_definition = array("placeholder" => "", "disabled" => "", "max" => "");


    $is_chargback_payment = stripos($payment_method, 'Chargeback', 0) === 0;
    $payment_method_disabled = $is_chargback_payment ? "style='pointer-events: none;background-color:#E9ECEF'" : "";
    $select_other_fee = "";
    $other_fee_description_disabled = "";
    $payment_method_chargeback = "";
    if ($is_chargback_payment) {
        $tmp = explode(" ", $payment_method);
        $last =  end($tmp);
        $chargeback_transaction_id = str_replace(array("(", ")"), array("", ""), $last);
        $sql_loan = mysqli_query($con, "select * from commercial_loan_transaction clt left join commercial_loan_transaction_cards_info cltci on clt.card_info = cltci.card_info_id left join tbl_other_fees tof on other_fee_id = tof.tbl_other_fees_id left join tbl_lists tl on tof.kind_fee = tl.tbl_lists_id  where transaction_id='$chargeback_transaction_id'");
        while ($row_loan = mysqli_fetch_array($sql_loan)) {
            $payment_amount_chargeback = $row_loan['payment_amount'];
            $late_fee_chargeback = $row_loan['late_fee'];
            $convenience_fee_chargeback = $row_loan['convenience_fee'];
            $other_fee_chargeback = $row_loan['other_fee'];
            $other_fee_id_chargeback = $row_loan['other_fee_id'];
            $item_chargeback = $row_loan['item'];
        }


        $payment_definition["placeholder"] = "0 - $payment_amount_chargeback";
        $late_fee_definition["placeholder"] = "0 - $late_fee_chargeback";
        $convenience_fee_definition["placeholder"] = "0 - $convenience_fee_chargeback";
        $other_fee_definition["placeholder"] = "0 - $other_fee_chargeback";

        $payment_definition["disabled"] = $payment_amount_chargeback == 0 ? "style='pointer-events: none;background-color:#E9ECEF'" : "";
        $late_fee_definition["disabled"] = $late_fee_chargeback == 0 ? "style='pointer-events: none;background-color:#E9ECEF'" : "";
        $convenience_fee_definition["disabled"] = $convenience_fee_chargeback == 0 ? "style='pointer-events: none;background-color:#E9ECEF'" : "";
        $other_fee_definition["disabled"] =  $other_fee_chargeback == 0 ? "pointer-events: none;background-color:#E9ECEF" : "";

        $payment_definition["max"] = "max = '$payment_amount_chargeback'";
        $late_fee_definition["max"] = "max = '$late_fee_chargeback'";
        $convenience_fee_definition["max"] = "max = '$convenience_fee_chargeback'";
        $other_fee_definition["max"] = "max = '$other_fee_chargeback'";

        $select_other_fee = $other_fee_id_chargeback == 0 ? "" : "$item_chargeback ($other_fee_id_chargeback)";
        $other_fee_description_disabled = "pointer-events: none;background-color:#E9ECEF";
        $payment_method_chargeback = $payment_method;
    }


    $editModal = '
        <div class="row">
            <div class="col-lg-2">
                <span><b>Payment:</b> ' . $payment_amount . '</span>
            </div>
            <div class="col-lg-2">
                <span><b>Late Fee:</b> ' . $late_fee . '</span>
            </div>
            <div class="col-lg-2">
                <span><b>Convenience Fee:</b> ' . $convenience_fee . '</span>
            </div>
            <div class="col-lg-2">
                <span><b>Other Fee ' . $other_fee_description . ':</b> ' . $other_fee . '</span>
            </div>
            <div class="col-lg-2">
                <span><b>Payment Method:</b> ' . $payment_method . '</span>
            </div>
        </div>
        ' . $card_info . '
        <div class="row" style="border-bottom: 1px solid black; padding-bottom:5px">

        </div>
        <div class="row">
            <div class="col-lg-6">
                <label for="usr">Amount to be Paid ($):</label>
                <input type="text" name="to_be_paid_amount" class="form-control" id="usr" placeholder="' . $payment_definition["placeholder"] . '" value="" oninput="oniputChange(this)" ' . $payment_definition["disabled"] . ' ' . $payment_definition["max"] . '>

            </div>

            <div class="col-lg-2">
                <label for="usr">Late Fee ($):</label>
                <input type="text" name="late_fee" class="form-control" id="usr" placeholder="' . $late_fee_definition["placeholder"] . '" value="" oninput="oniputChange(this)" ' . $late_fee_definition["disabled"] . ' ' . $late_fee_definition["max"] . '>

            </div>

            <div class="col-lg-2">
                <label for="usr">Convenience Fee ($):</label>
                <input type="text" name="convenience_fee" class="form-control" id="usr" placeholder="' . $convenience_fee_definition["placeholder"] . '" value="" oninput="oniputChange(this)" ' . $convenience_fee_definition["disabled"] . ' ' . $convenience_fee_definition["max"] . '>

            </div>

            <div class="col-lg-2">
                <label style="width:100%" for="other_fee_id">Other Fee ($):</label>
                <select name="type_of_description" id="lblTypeOfDescription" onchange="GetUnpaidOtherFee(this,event)" style="width:65%;' . $other_fee_description_disabled . '"  value="' . $select_other_fee . '">
                    <option value="' . $select_other_fee . '">' . $select_other_fee . '</option>';

    $sql_loan = mysqli_query($con, "select * from tbl_other_fees tof inner join tbl_lists tl on tof.kind_fee = tl.tbl_lists_id where loan_created_id='$loan_id' and user_fnd_id = '$user_fnd_id' and (amount_fee_paid != amount_fee or tbl_other_fees_id = $other_fee_id)");

    while ($row_loan = mysqli_fetch_array($sql_loan)) {
        $row_item = $row_loan['item'];
        $id = $row_loan['tbl_other_fees_id'];
        $editModal .= "<option value='$row_item ($id)'>$row_item ($id)</option>";
    }

    $editModal .= '</select>
                <input type="text" name="other_fee" class="form-control" id="other_fee_id" placeholder="' . $other_fee_definition["placeholder"] . '" value="" style="width:30%; display:inline!important;' . $other_fee_definition["disabled"] . '" oninput="oniputChange(this)"  ' . $other_fee_definition["max"] . '>


            </div>

            <div class="col-lg-6">
                <label for="usr">Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-control" onchange="payment_method_info(this,event)" ' . $payment_method_disabled . ' value="' . $payment_method_chargeback . '">
                    <option value="' . $payment_method_chargeback . '">' . $payment_method_chargeback . '</option>
                    <option value="Cash">Cash</option>
                    <option value="Debit Card">Debit Card</option>
                    <option value="Bank Deposit">Bank Deposit</option>
                    <option value="Money Order">Money Order</option>
                    <option value="ACH">ACH</option>
                    <option value="Zelle">Zelle</option>
                    <option value="Repay Portal">Repay Portal</option>
                </select>
            </div>
            <div id="paymentOptionId" hidden>
                <div id="bankOptionId"></div>
                <div id="cardOptionId"></div>
            </div>
            <div class="col-lg-6">
                <label for="payment_description">Payment Description:</label>
                <textarea name="payment_description" class="form-control" id="payment_description" placeholder="Payment Description" value="' . $payment_description . '"></textarea>

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
    
    ';

    $formEditModal = '<form id="transactionFormId" method="POST" enctype="multipart/form-data" onsubmit="return updateTransaction(event)">' . $editModal . '</form>';


    $articles[] = array(
        'editModal'       => (string)$formEditModal
    );
    echo json_encode($articles);
}

function if_insert($con)
{
    $matched = explode(": ", explode('  ', $con->info)[0])[1]; // Rows matched
    $changed = explode(": ", explode('  ', $con->info)[1])[1]; // Changed

    return $matched == 0;
};

function CalculateInstallmetsPerDiem()
{
    global $con;
    $loan_create_id = $_POST["loan_create_id"];
    $number_payment = isset($_POST["number_payment"]) ? $_POST["number_payment"] : -1;

    $default = isset($_POST["default_installment"]) ? json_decode($_POST["default_installment"]) : False;
    $transactions = isset($_POST["transactions"]) ? json_decode($_POST["transactions"]) : False;

    $query_loan = mysqli_query($con, "SELECT * from `tbl_commercial_loan` where `loan_create_id` = $loan_create_id");
    while ($loan = mysqli_fetch_array($query_loan)) {
        $apr = $loan['apr'];
        $amount_loan = $loan['amount_of_loan'];
        $loan_interest = $loan['loan_interest'];
        $total_payments = $loan['total_payments'];
        $creation_date = $loan['creation_date'];
        $installment_plan = $loan['installment_plan'];
    }

    switch ($installment_plan) {
        case "Weekly":
            $num_of_days = 7;
            #payment_start_date[0].value = getFormattedDate(new Date(chooseDate.setDate(chooseDate.getDate() + 7)));
            break;
        case "Bi-Weekly":
            $num_of_days = 14;
            #payment_start_date[0].value = getFormattedDate(new Date(chooseDate.setDate(chooseDate.getDate() + 14)));
            break;
        case "Monthly":
            $num_of_days = 30;
            #payment_start_date[0].value = getFormattedDate(new Date(chooseDate.setDate(chooseDate.getDate() + 30)));
            break;
    }


    $payoff = round((float)($amount_loan + $loan_interest), 2);
    $payment = round((float)($payoff / $total_payments), 2);

    $installmentInfo = "
        <table class='table table-striped table-bordered' id='installmentTableModalid'>
        <thead>
            <tr>
                <th>#</th>
                <th>Due Date</th>
                <th>Payment Date</th>
                <th>Days</th>
                <th>Per Diem</th>
                <th>Payment Amount</th>
                <th>Interest</th>
                <th>Principal</th>
                <th>Balance</th>
                <th>Status</th>
                <th>Fee Added</th>
                <th>Fee Paid</th>
                <th>Fee Unpaid</th>
                <th>Fee Description</th>
            </tr>
        </thead>
        <tbody>";
    if ($default or $transactions) {
        mysqli_query($con, "DELETE FROM `tbl_commercial_loan_installmets_calculated` WHERE `loan_create_id` = '$loan_create_id'");
    }
    $total_payment = 0;

    $total_interest = 0;
    $total_principal = 0;
    $total_balance = 0;
    if ($transactions) {
        $result = mysqli_query($con, "select * from tbl_commercial_loan_installments where loan_create_id='$loan_create_id' order by id");
        $i = 1;
        while ($row = mysqli_fetch_array($result)) {
            $due_date_real = $row['payment_date'];
            $payment_date = $row['paid_date'];
            $days_from_last_payment = $row['days'];
            $per_diem = $row['per_diem'];
            $loan_payment_amount = $row['payment'];
            $interest = $row['interest'];
            $principal = $row['principal'];
            $balance = $row['balance'];
            $status = $row['status'];
            $total_payment += $loan_payment_amount;

            $total_interest += $interest;
            $total_principal += $principal;
            $string_red_rejected = '';

            if ($status == '1') {
                $count_row = 0;
                $installment_status = "Paid";
                $string_red_rejected = 'style="color:green;font-weight:bold"';
                // $a = "<a href='add_new_transaction.php?intallment_id=$intallment_id&id=$id' class='disabled'>Paid</a>";
                $a = "";
                // if ($dpd >= 10 && $paid_late_fee < $late_fee) {
                //     $still_pay_fee = $late_fee - $paid_late_fee;
                //     $string_red_rejected = 'style="color:purple;font-weight:bold"';
                //     $a = "<a href='add_new_transaction.php?intallment_id=$intallment_id&id=$id&late_fee=$still_pay_fee'>PayFee</a>";
                // } else if ($chargeback_amount > 0) {
                //     $string_red_rejected = 'style="color:deeppink;font-weight:bold"';
                // }
            } else if ($status == '2') {
                $installment_status = "Settlement";
                $a = "";
            } else if ($status == '3') {
                $installment_status = "Paid Ref";
                $string_red_rejected = 'style="color:limegreen;font-weight:bold"';
                $a = "";
            } else if ($status == '4') {
                $installment_status = "Credit";
                $string_red_rejected = 'style="color:coral;font-weight:bold"';
                $a = "";
            } else {
                $installment_status = "Unpaid";
                $a = "";
                // $a = "<a href='add_new_transaction.php?intallment_id=$intallment_id&id=$id' $en_action>PayNow</a>";
            }

            $fee_added = 0;
            $fee_unpaid = 0;
            $fee_paid = 0;
            $fee_description = "";


            $due_date_real_array = explode("-", $due_date_real);
            $due_date_real = $due_date_real_array[2] . "-" . $due_date_real_array[0] . "-" . $due_date_real_array[1];
            if ($payment_date == null) {
                $payment_date = $due_date_real;
            }

            $installmentInfo .= "<tr id='idInstallment_" . $i . "_" . $loan_create_id . "' ".$string_red_rejected.">
            <td>" . $i . "</td>
            <td>" . $due_date_real . "</td>
            <td><input type='date' style='width:100%;height:100%' value='" . $payment_date . "' onchange=recalculate_installments_date(event,this,'" . $i . "')></td>
            <td>" . $days_from_last_payment . "</td>
            <td>" . number_format($per_diem,   2, ".", ",") . "</td>
            <td><input type='text' style='width:100%;height:100%' value='" . number_format($loan_payment_amount,   2, ".", ",") . "' onchange=recalculate_installments_payment(event,this,'" . $i . "')></td>
            <td>" . number_format($interest,   2, ".", ",") . "</td>
            <td>" . number_format($principal,   2, ".", ",") . "</td>
            <td>" . number_format($balance,   2, ".", ",") . "</td>
            <td>" . $installment_status . "</td>
            <td>" . $fee_added . "</td>
            <td>" . $fee_paid . "</td>
            <td>" . $fee_unpaid . "</td>
            <td>" . $fee_description . "</td>
            </tr>";

            $query_install = "INSERT INTO `tbl_commercial_loan_installmets_calculated` (`number_of_payment`, `loan_create_id`, `due_date`, `payment_date`, `days`, `per_diem`, `payment_amount`, `interest`, `principal`, `balance`, `status`)
            VALUES ('$i', '$loan_create_id', '$due_date_real', '$payment_date','$days_from_last_payment', '$per_diem', '$loan_payment_amount', '$interest', '$principal', '$balance', '$status')";
            $result_install = mysqli_query($con, $query_install);
            $i++;
        }
        $total_balance = $balance;


    }
    $add_to_interest = 0;
    $status="0";
    $installment_status = "Unpaid";
    for ($i = 1; $i <= (int)$total_payments and !$transactions; $i++) {

       
        if ($i == 1) {
            $balance = $amount_loan;
            #$open_date = date_create(date("Y-m-d", strtotime($creation_date)));
            $previous_payment_date = $creation_date;
            $previous_due_date = $creation_date;
        }

        $due_date_real = strtotime("+" . $num_of_days . " days", strtotime($previous_due_date));
        $due_date_real = date("Y-m-d", $due_date_real);

        if (isset($_POST["payment_date_updated"]) and $_POST["payment_date_updated"] == "" and $number_payment != null && $number_payment == $i) {
            $installmentInfo .= "<tr id='idInstallment_" . $i . "_" . $loan_create_id . "'>
            <td>" . $i . "</td>
            <td>" . $due_date_real . "</td>
            <td><input type='date' style='width:100%;height:100%' value='" . $_POST["payment_date_updated"] . "' onchange=recalculate_installments_date(event,this,'" . $i . "')></td>
            <td>0</td>
            <td>" . number_format(0,   2, ".", ",") . "</td>
            <td><input type='text' style='width:100%;height:100%' value='" . number_format(0,   2, ".", ",") . "' onchange=recalculate_installments_payment(event,this,'" . $i . "')></td>
            <td>" . number_format(0,   2, ".", ",") . "</td>
            <td>" . number_format(0,   2, ".", ",") . "</td>
            <td>" . number_format(0,   2, ".", ",") . "</td>
            <td>" . $installment_status . "</td>
            </tr>";
            $action_query = "UPDATE `tbl_commercial_loan_installmets_calculated` SET `due_date`= '$due_date_real', `payment_date` = null, `days` = '0', `per_diem` = '0', `payment_amount` = '0', `interest` = '0', `principal` = '0', `balance` = '0' WHERE  loan_create_id='$loan_create_id' and number_of_payment = '$i'";
            mysqli_query($con, $action_query);
            $previous_due_date = $due_date_real;
            continue;
        }

        $loan_payment_date = null;
        $loan_payment_amount = $payment;
        $result = mysqli_query($con, "select * from tbl_commercial_loan_installmets_calculated where loan_create_id='$loan_create_id' and number_of_payment='$i'");
        while ($row = mysqli_fetch_array($result)) {
            $loan_payment_date = $row['payment_date'];
            $loan_due_date = $row['due_date'];
            $loan_payment_amount = $row['payment_amount'];
            $loan_balance = $row['balance'];
        }

        if (!$default and $loan_payment_date == null) {
            $installmentInfo .= "<tr id='idInstallment_" . $i . "_" . $loan_create_id . "'>
            <td>" . $i . "</td>
            <td>" . $due_date_real . "</td>
            <td><input type='date' style='width:100%;height:100%' value='' onchange=recalculate_installments_date(event,this,'" . $i . "')></td>
            <td>0</td>
            <td>" . number_format(0,   2, ".", ",") . "</td>
            <td><input type='text' style='width:100%;height:100%' value='" . number_format(0,   2, ".", ",") . "' onchange=recalculate_installments_payment(event,this,'" . $i . "')></td>
            <td>" . number_format(0,   2, ".", ",") . "</td>
            <td>" . number_format(0,   2, ".", ",") . "</td>
            <td>" . number_format(0,   2, ".", ",") . "</td>
            <td>" . $installment_status. "</td>
            </tr>";
            $action_query = "UPDATE `tbl_commercial_loan_installmets_calculated` SET `due_date`= '$due_date_real', `payment_date` = null, `days` = '0', `per_diem` = '0', `payment_amount` = '0', `interest` = '0', `principal` = '0', `balance` = '0' WHERE  loan_create_id='$loan_create_id' and number_of_payment = '$i'";
            mysqli_query($con, $action_query);
            $previous_due_date = $due_date_real;
            continue;
        }

        if ($number_payment != null && $number_payment == $i) {
            $loan_payment_date  = isset($_POST["payment_date_updated"]) ? $_POST["payment_date_updated"] : $loan_payment_date;
            $loan_payment_amount = isset($_POST["payment_amount"]) ? $_POST["payment_amount"] : $loan_payment_amount;
        }

        if ((isset($_POST["payment_date_updated"]) or isset($_POST["payment_amount"])) and $loan_balance == 0) {
            $loan_payment_amount = $payment;
        }

        $due_date = $loan_payment_date;


        if ($default) {
            $due_date = strtotime("+" . $num_of_days . " days", strtotime($previous_due_date));
            $due_date = date("Y-m-d", $due_date);
        }

        $payment_date = $due_date;


        $days_from_last_payment = date_diff(date_create(date("Y-m-d", strtotime($previous_payment_date))), date_create($payment_date))->format('%r%a');

        $per_diem = $balance * $apr / 36500;

        $interest = $days_from_last_payment * $per_diem + $add_to_interest;

        $principal = $loan_payment_amount - $interest;

        $add_to_interest = 0;
        if ($principal < 0) {
            $add_to_interest = abs($principal);
            $principal = 0;
        }

        $balance = $balance - $principal;

        if ($balance < 0) {
            $loan_payment_amount = $loan_payment_amount + $balance;
            $principal = $loan_payment_amount - $interest;
            $balance = 0;
        }




        $installmentInfo .= "<tr id='idInstallment_" . $i . "_" . $loan_create_id . "'>
        <td>" . $i . "</td>
        <td>" . $due_date_real . "</td>
        <td><input type='date' style='width:100%;height:100%' value='" . $payment_date . "' onchange=recalculate_installments_date(event,this,'" . $i . "')></td>
        <td>" . $days_from_last_payment . "</td>
        <td>" . number_format($per_diem,   2, ".", ",") . "</td>
        <td><input type='text' style='width:100%;height:100%' value='" . number_format($loan_payment_amount,   2, ".", ",") . "' onchange=recalculate_installments_payment(event,this,'" . $i . "')></td>
        <td>" . number_format($interest,   2, ".", ",") . "</td>
        <td>" . number_format($principal,   2, ".", ",") . "</td>
        <td>" . number_format($balance,   2, ".", ",") . "</td>
        <td>" . $installment_status . "</td>
        </tr>";
        $total_payment += $loan_payment_amount;

        $total_interest += $interest;
        $total_principal += $principal;

        if ($default) {
            $query_install = "INSERT INTO `tbl_commercial_loan_installmets_calculated` (`number_of_payment`, `loan_create_id`, `due_date`, `payment_date`, `days`, `per_diem`, `payment_amount`, `interest`, `principal`, `balance`)
            VALUES ('$i', '$loan_create_id', '$due_date_real', '$payment_date','$days_from_last_payment', '$per_diem', '$loan_payment_amount', '$interest', '$principal', '$balance')";
            $result_install = mysqli_query($con, $query_install);
        }

        if ($number_payment != -1) {
            $action_query = "UPDATE `tbl_commercial_loan_installmets_calculated` SET `due_date`= '$due_date_real', `payment_date` = '$payment_date', `days` = '$days_from_last_payment', `per_diem` = '$per_diem', `payment_amount` = '$loan_payment_amount', `interest` = '$interest', `principal` = '$principal', `balance` = '$balance' WHERE  loan_create_id='$loan_create_id' and number_of_payment = '$i'";
            mysqli_query($con, $action_query);
        }

        $previous_balance =  $balance;
        $previous_due_date = $due_date_real;
        $previous_payment_date = $payment_date;
    }

    $installmentInfo .= "<tr>
	 	      
    <td colspan='5'>Total</td>
    <td>$" . number_format($total_payment,   2, ".", ",") . "</td>
    <td>$" . number_format($total_interest,   2, ".", ",") . "</td>
    <td>$" . number_format($total_principal,   2, ".", ",") . "</td>
    <td>$" . number_format($total_balance,   2, ".", ",") . "</td>
    
    </tr>";

    $installmentInfo .= "</tbody>
    </table> ";

    $articles[] = array(
        'installmentInfo'         =>  (string)$installmentInfo,
    );
    echo json_encode($articles);
    // $paid_date = $installment['paid_date'];
    // $status = $installment['status'];
    // $payment_date = $installment['payment_date'];
    // $payment =  $installment['payment'];
    // $intallment_id = $installment['id'];

    // $payment_date_array = explode("-", $payment_date);
    // $payment_date = $payment_date_array[2] . "-" . $payment_date_array[0] . "-" . $payment_date_array[1];

    // $date_due_date = date_create(date("Y-m-d", strtotime($payment_date)));
    // #$previous_payment_date = $date_due_date;

    // $balance = $previous_balance;

    // if($index_installment == 1){
    //     $balance = $amount_loan ;
    //     $open_date = date_create(date("Y-m-d", strtotime($creation_date)));
    //     $previous_payment_date = $open_date;
    // }

    // if ($paid_date != null){
    //     $date_due_date  = date_create(date("Y-m-d",strtotime($paid_date)));
    // }

    // $days_from_last_payment = date_diff( $previous_payment_date, $date_due_date )->format('%r%a');

    // $per_diem = round($balance * $apr / 36500, 2);
    // $interest = round($days_from_last_payment * $per_diem,2);
    // $principal = $payment - $interest;
    // $balance = $balance - $principal;

    // $previous_balance =  $balance;

    // $previous_payment_date = $date_due_date;
    // mysqli_query($con, "UPDATE tbl_commercial_loan_installments SET `interest` = '$interest', `principal`= $principal, `balance`= '$balance' where id ='$intallment_id'");
}






    // $previous_payment_date = null;
    // $previous_balance =  null;
    
    // //$apr
    // $query_all_installments = mysqli_query($con, "SELECT * from `tbl_commercial_loan_installments` where `loan_create_id` = $loan_create_id order by id asc");
    // $index_installment = 1;
    // while ($installment = mysqli_fetch_array($query_all_installments)){
    //     $paid_date = $installment['paid_date'];
    //     $status = $installment['status'];
    //     $payment_date = $installment['payment_date'];
    //     $payment =  $installment['payment'];
    //     $intallment_id = $installment['id'];

    //     $payment_date_array = explode("-", $payment_date);
    //     $payment_date = $payment_date_array[2] . "-" . $payment_date_array[0] . "-" . $payment_date_array[1];

    //     $date_due_date = date_create(date("Y-m-d", strtotime($payment_date)));
    //     #$previous_payment_date = $date_due_date;

    //     $balance = $previous_balance;

    //     if($index_installment == 1){
    //         $balance = $amount_loan ;
    //         $open_date = date_create(date("Y-m-d", strtotime($creation_date)));
    //         $previous_payment_date = $open_date;
    //     }
        
    //     if ($paid_date != null){
    //         $date_due_date  = date_create(date("Y-m-d",strtotime($paid_date)));
    //     }

    //     $days_from_last_payment = date_diff( $previous_payment_date, $date_due_date )->format('%r%a');

    //     $per_diem = round($balance * $apr / 36500, 2);
    //     $interest = round($days_from_last_payment * $per_diem,2);
    //     $principal = $payment - $interest;
    //     $balance = $balance - $principal;

    //     $previous_balance =  $balance;
        
    //     $previous_payment_date = $date_due_date;
    //     mysqli_query($con, "UPDATE tbl_commercial_loan_installments SET `interest` = '$interest', `principal`= $principal, `balance`= '$balance' where id ='$intallment_id'");
    //     $index_installment++;
    // }