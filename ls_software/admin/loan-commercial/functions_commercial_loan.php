<?php
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
        case 'InsertAllBankInformation':
            InsertAllBankInformation();
            break;
        default:
            //function not found, error or something
            break;
    }   

    function UpdateBankInfo(){
        include_once '../dbconfig.php';

        $userId = $_POST['userId'];
        $bankInfoId = $_POST['bankInfoId'];
        $bankName = $_POST['bankName'];
        $accountNumber = $_POST['accountNumber'];
        $routingNumber = $_POST['routingNumber'];
        $status = $_POST['status'] == "true" ? '1' : '0';
        $newBankInfo = $_POST['newBankInfo'];

        $sql = mysqli_query($con, "select count(bank_id) as count from tbl_bank_info where usr_fnd_id= '$userId' and bank_name='$bankName' and account_number='$accountNumber' and routing_number='$routingNumber' and bank_id != '$bankInfoId'");

        while ($row = mysqli_fetch_array($sql)) {
            $count = $row['count'];
        }

        if($count > 0){
            $articles[] = array(
                'status'         =>  "false",
                'message'       => "Bank info exist"
            );
            echo json_encode($articles); 
            return;          
        }

        $action_query = "UPDATE `tbl_bank_info` SET `bank_name` = '$bankName', `account_number` = '$accountNumber', `routing_number` = '$routingNumber', `is_active` = '$status' WHERE `tbl_bank_info`.`bank_id` = '$bankInfoId '";
        $message = "Bank info updated";
        if($newBankInfo == "true"){
            
            $action_query = "INSERT INTO `tbl_bank_info` (`bank_id`, `usr_fnd_id`, `bank_name`, `account_number`, `routing_number`, `is_active`) VALUES (NULL, '$userId', '$bankName', '$accountNumber', '$routingNumber', '$status')";
            $message = "Bank info inserted";
        }
        mysqli_query($con, $action_query);


        $articles[] = array(
            'status'         =>  "ok",
            'message'       => $message
        );
        echo json_encode($articles);
    }

    function DeleteBankInfo(){
        include_once '../dbconfig.php';

        $bankInfoId = $_POST['itemId'];
        $status = "ok";
        $action_query = "DELETE FROM `tbl_bank_info` WHERE `tbl_bank_info`.`bank_id` = '$bankInfoId'";
        $message = "Bank info deleted";
        $result = mysqli_query($con, $action_query);

        if(!$result){
            $status = "fail";
            $message = "Bank info with id $bankInfoId not deleted";
        }

        $articles[] = array(
            'status'         =>  $status,
            'message'       => $message
        );
        echo json_encode($articles);
    }

    function UpdateCardInfo(){
        include_once '../dbconfig.php';

        $userId = $_POST['userId'];
        $cardInfoId = $_POST['cardInfoId'];
        $typeOfCard = $_POST['typeOfCard'];
        $cardNumber = $_POST['cardNumber'];
        $expirationDate = $_POST['expirationDate'];
        $cvv = $_POST['cvv'];
        $status = $_POST['status'] == "true" ? '1' : '0';
        $newCardInfo = $_POST['newCardInfo'];

        $sql = mysqli_query($con, "select count(id) as count from tbl_bank_cards where user_fnd_id= '$userId' and type_of_card='$typeOfCard' and card_number='$cardNumber' and card_exp_date='$expirationDate' and cvv_number='$cvv' and id != '$cardInfoId'");

        while ($row = mysqli_fetch_array($sql)) {
            $count = $row['count'];
        }

        if($count > 0){
            $articles[] = array(
                'status'         =>  "false",
                'message'       => "Card info exist"
            );
            echo json_encode($articles); 
            return;          
        }

        $action_query = "UPDATE `tbl_bank_cards` SET `type_of_card` = '$typeOfCard', `card_number` = '$cardNumber', `card_exp_date` = '$expirationDate',`cvv_number`='$cvv', `is_active` = '$status' WHERE `tbl_bank_cards`.`id` = '$cardInfoId '";
        $message = "Card info updated";
        if($newCardInfo == "true"){
            
            $action_query = "INSERT INTO `tbl_bank_cards` (`id`, `user_fnd_id`, `type_of_card`, `card_number`, `card_exp_date`,`cvv_number`, `is_active`) VALUES (NULL, '$userId', '$typeOfCard', '$cardNumber', '$expirationDate','$cvv', '$status')";
            $message = "Card info inserted";
        }
        mysqli_query($con, $action_query);


        $articles[] = array(
            'status'         =>  "ok",
            'message'       => $message
        );
        echo json_encode($articles);
    }
    function DeleteCardInfo(){
        include_once '../dbconfig.php';

        $bankInfoId = $_POST['itemId'];
        $status = "ok";
        $action_query = "DELETE FROM `tbl_bank_info` WHERE `tbl_bank_info`.`bank_id` = '$bankInfoId'";
        $message = "Bank info deleted";
        $result = mysqli_query($con, $action_query);

        if(!$result){
            $status = "fail";
            $message = "Bank info with id $bankInfoId not deleted";
        }

        $articles[] = array(
            'status'         =>  $status,
            'message'       => $message
        );
        echo json_encode($articles);
    }

    function GetCardInfoTable(){
        include('db.php'); 
        $user_fnd_id = $_POST['userId'];
        $loan_create_id = $_POST['loan_create_id'];

        $sql_loan = mysqli_query($con,"SELECT `type_of_card`,`card_number`,`card_exp_date`,`bank_name`,`routing_number`,`account_number`,`cvv_number` FROM `commercial_loan_initial_banking` WHERE `loan_id` ='$loan_create_id'");
        while ($row_bank_detail = mysqli_fetch_array($sql_loan)){
            $loan_type_of_card = $row_bank_detail['type_of_card'];
            $loan_card_number=$row_bank_detail['card_number'];
            $loan_card_exp_date=$row_bank_detail['card_exp_date'];
            $loan_bank_name = $row_bank_detail['bank_name'];
            $loan_routing_number = $row_bank_detail['routing_number'];
            $loan_account_number= $row_bank_detail['account_number'];
            $loan_cvv_number = $row_bank_detail['cvv_number'];
            break;
        }

         $cardInfo = "
            <table id='tbl_card_info' class='table table-bordered table-striped table-hover'>
            <thead>
                <tr>
                    <th hidden='true'></th>
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
            $type_of_card = $row_bank_detail_sec['type_of_card'];
            $card_number = $row_bank_detail_sec['card_number'];

            $card_exp_date = $row_bank_detail_sec['card_exp_date'];
            $cvv = $row_bank_detail_sec['cvv_number'];
            $is_active = $row_bank_detail_sec['is_active'] == 1 ? "Active" : "Inactive";
            $active = ($type_of_card == $loan_type_of_card && $card_number == $loan_card_number && $card_exp_date == $loan_card_exp_date && $cvv == $loan_cvv_number) ? "table-success" : "";
            $cardInfo.= "<tr id='idCard" . $card_id . "' class='clickable-card-row ".$active."' style='cursor: pointer';>
                <td hidden='true'>" . $card_id . "</td>
                <td>" . $type_of_card . "</td>
                <td>" . $card_number . "</td>
                <td>" . $card_exp_date . "</td>
                <td>" . $cvv . "</td>
                <td>" . $is_active . "</td>

                    </tr>";
        }

        $cardInfo.="</tbody>
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

            include('db.php'); // total page minus 1
            $sql_loan = mysqli_query($con, "select * from tbl_bank_info where usr_fnd_id = '$user_fnd_id' and is_active=1");
            while ($row_bank_detail_sec = mysqli_fetch_array($sql_loan)) {
            $bank_id = $row_bank_detail_sec['bank_id'];
            $bank_name = $row_bank_detail_sec['bank_name'];
            $routing_number = $row_bank_detail_sec['routing_number'];
            $account_number = $row_bank_detail_sec['account_number'];
            $is_active = $row_bank_detail_sec['is_active'] == 1 ? "Active" : "Inactive";
            $active = ($bank_name == $loan_bank_name && $routing_number == $loan_routing_number && $account_number == $loan_account_number) ? "table-success" : "";
            $bankInfo.= "<tr id='idBank" . $bank_id . "' class='clickable-bank-row ".$active."' style='cursor: pointer;'>
                <td hidden='true'>" . $bank_id . "</td>
                <td>" . $bank_name . "</td>
                <td>" . $account_number . "</td>
                <td>" . $routing_number . "</td>
                <td>" . $is_active . "</td>
                </tr>";
            }

        $bankInfo.="</tbody>
        </table> ";

        $articles[] = array(
            'cardTable'         =>  (string)$cardInfo,
            'bankTable'         =>  (string)$bankInfo,
        );
        echo json_encode($articles);

    }

    function InsertAllBankInformation(){
        include('db.php'); 
        $user_fnd_id = $_POST['userId'];
        $sql_loan = mysqli_query($con,"SELECT `type_of_card`,`card_number`,`card_exp_date`,`bank_name`,`routing_number`,`account_number`,`cvv_number` FROM `commercial_loan_initial_banking` WHERE `user_fnd_id` ='$user_fnd_id'");
        while ($row_bank_detail = mysqli_fetch_array($sql_loan)){
            $_POST['cardInfoId'] = "";
            $_POST['typeOfCard'] = $row_bank_detail['type_of_card'];
            $_POST['cardNumber'] = $row_bank_detail['card_number'];
            $_POST['expirationDate'] = $row_bank_detail['card_exp_date'];
            $_POST['cvv'] = $row_bank_detail['cvv_number'];
            $_POST['status'] = "true";
            $_POST['newCardInfo'] = "true";

            $result = UpdateCardInfo();


            $_POST['bankInfoId'] = "";
            $_POST['bankName']=$row_bank_detail['bank_name'];
            $_POST['accountNumber'] = $row_bank_detail['account_number'];
            $_POST['routingNumber'] = $row_bank_detail['routing_number'];
            $_POST['status'] = "true";
            $_POST['newBankInfo'] = "true";

            $result = UpdateBankInfo();
        }
    }