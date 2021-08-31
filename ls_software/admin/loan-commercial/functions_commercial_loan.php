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

    $sql_loan = mysqli_query($con, "SELECT `type_of_id`, `type_of_card`,`card_number`,`card_exp_date`,`bank_name`,`routing_number`,`account_number`,`cvv_number` FROM `commercial_loan_initial_banking` WHERE `loan_id` ='$loan_create_id'");
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
    $sql_loan = mysqli_query($con, "SELECT `type_of_card`,`card_number`,`card_exp_date`,`bank_name`,`routing_number`,`account_number`,`cvv_number` FROM `commercial_loan_initial_banking` WHERE `loan_id` ='$loan_create_id'");
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

        if($skip_amount >= $installment_paid){
            $skip_amount -= $installment_paid;
            continue;
        }

        if($late_fee_paid != 0){
            $late_fee_paid = $late_fee;
        }

        if($convenience_fee_paid != 0){
            $convenience_fee_paid = $convenience_fee;
        }

        $chargeback_paid = $installment_paid - $skip_amount;
        $skip_amount = 0;

        $action_query = "UPDATE `tbl_commercial_loan_installments` SET `chargeback_amount`='$chargeback_paid', paid_late_fee = pade_late_fee - $late_fee_paid  WHERE `id` = '$installment_id'";
        mysqli_query($con, $action_query);


    }  

    if($other_fee != 0){
        $action_query = "UPDATE `tbl_other_fees` SET `amount_fee_paid`= amount_fee_paid - $other_fee WHERE `tbl_other_fees_id` = '$other_fee_id'";
        mysqli_query($con, $action_query);
    }

    $interest = 0;
    $principal_amount = 0;
    if($transaction_amount != 0){
        $sql_transactions = mysqli_query($con, "SELECT * FROM `commercial_loan_transaction` where loan_create_id= '$loan_id' and transaction_id = $transaction_id");
        while ($row_transaction = mysqli_fetch_array($sql_transactions)) {
            $percent = $chargeback_amount / $transaction_amount;
            $interest = -$row_transaction['interest'] * $percent;
            $principal_amount = -$row_transaction['principal_amount'] * $percent;
        }
        
    }

    $sql_transactions = mysqli_query($con, "SELECT * FROM `commercial_loan_transaction` where loan_create_id= '$loan_id' order by transaction_id desc limit 1");
    while ($row_transaction = mysqli_fetch_array($sql_transactions)) {
        $remaining_balance = $row_transaction['remaining_balance'] + $principal_amount;
        $id = $row_transaction['loan_id'];
        $user_fnd_id = $row_transaction['user_fnd_id'];
    }

    $payment_description = "";
    $late_fee = $late_fee == 0 ? 0 : -$late_fee;
    $convenience_fee = $convenience_fee == 0 ? 0 : -$convenience_fee;
    $other_fee = $other_fee == 0 ? 0 : -$other_fee;
    $due_date = strftime('%Y-%m-%d', strtotime("now"));
    $payment_method = "Chargeback (".$transaction_id.")";

    $query_insert_trans = "INSERT INTO `commercial_loan_transaction`(`loan_id`, `loan_create_id`, `user_fnd_id`, `installment_id`, 
    `payment_amount`, `interest`, `principal_amount`, `remaining_balance`, `late_fee`,
     `convenience_fee` ,`other_fee`,`other_fee_id`, `payment_date`, `payment_description`,`payment_method`, `created_at`, `created_by`) VALUES ('$id','$loan_id','$user_fnd_id','$installment_id',
     '-$chargeback_amount','$interest','$principal_amount','$remaining_balance','$late_fee','$convenience_fee','$other_fee','$other_fee_id',
     '$due_date','$payment_description','$payment_method','$due_date','$u_id')";
    $result_insert_trans = mysqli_query($con, $query_insert_trans);

    $action_query = "UPDATE `commercial_loan_transaction` SET `is_chargeback`='1',  WHERE `transaction_id` = '$transaction_id'";
    mysqli_query($con, $action_query);

    $message = "Chargeback added";

    $articles[] = array(
        'status'         =>  "ok",
        'message'       => $message
    );
    echo json_encode($articles);
   
}

function UpdateOtherFee(){
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

function DeleteOtherFee(){
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

function GetUnpaidOtherFee(){
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
