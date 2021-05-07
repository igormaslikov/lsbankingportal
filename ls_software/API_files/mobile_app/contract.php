<?php 

include_once 'dbconfig.php';

$n=8;
function getName($n) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';

	for ($i = 0; $i < $n; $i++) {
		$index = rand(0, strlen($characters) - 1);
		$randomString .= $characters[$index];
	}

	return $randomString;
}

//echo getName($n);

$email_key = getName($n);

echo '{"code" : "'.$email_key.'"}'; 

$fnd_idd = $_GET['id'];
$amount_loan = $_GET['amount_loan'];
$secure_loan = $_GET['secured_loan'];
$contract_date = $_GET['contract_date'];
$payment_date = $_GET['payment_date'];
$u_id = $_GET[''];
$loan_create_id = $_GET['loan_create_id'];
$date = date('Y-m-d H:i:s');

$type_id= $_GET['type'];
$type_card= $_GET['type_card'];
$card_number= $_GET['card_number'];
$bank_name=$_GET['bank_name'];
$routing_number = $_GET['routing_number'];
$account_number = $_GET['account_number'];
$cvv_number = $_GET['cvv_number'];
$expiry_year_card = $_GET['expiry_year_card'];
$expiry_month_card = $_GET['expiry_month_card'];
$card_exp_date = $expiry_year_card. "/".$expiry_month_card;


//echo $type_id;

 $query_userid3 = mysqli_query($con,"Select * from fnd_user_profile where user_fnd_id ='$fnd_idd'");
while ($row_user_id3=mysqli_fetch_array($query_userid3)){
    
    
  
    
    //echo"<br><br><br><br><br><br><br><br> <br><br>User_Key:" .$fnd_id;
    $state_insrt = $row_user_id3['state'];
}

$sql_count_ca = mysqli_query($con,"SELECT * FROM tbl_loan where state='$state_insrt' AND loan_create_id!='' order by loan_create_id ASC");
while ($row_count_ca=mysqli_fetch_array($sql_count_ca)){
    $loan_create_id = $row_count_ca['loan_create_id'];
    
}
$loan_create_id = $loan_create_id+1;
echo ",{\"loan_id\" : \"$loan_create_id\"}";
if ($state_insrt=="CA")
{
 $query3 = mysqli_query($con,"Select loan_fee from tbl_loan_setting_nv where loan_amount ='$amount_loan' AND state='$state_insrt'");
 while ($row3=mysqli_fetch_array($query3)){
                 $amount_loan = $amount_loan;
                 $loan_fee = $row3['loan_fee'];
                 $payoff_amount = $amount_loan+$loan_fee;
                 $payoff_amount = number_format((float)$payoff_amount, 2, '.', '');
                
    
}

}

 if ($state_insrt=="NV")
{
 $query33 = mysqli_query($con,"Select loan_fee from tbl_loan_setting_nv where loan_amount ='$amount_loan' AND state='$state_insrt'");
 while ($row33=mysqli_fetch_array($query33)){
                  $amount_loan= $amount_loan;
                 $loan_fee = $row33['loan_fee'];
                 $payoff_amount = $amount_loan+$loan_fee;
                 $payoff_amount = number_format((float)$payoff_amount, 2, '.', '');
    
}

}


if ($state_insrt=="IL")
{
 $query3 = mysqli_query($con,"Select loan_fee from tbl_loan_setting_nv where loan_amount ='$amount_loan' AND state='$state_insrt'");
 while ($row3=mysqli_fetch_array($query3)){
                 $amount_loan= $amount_loan;
                 $loan_fee = $row3['loan_fee'];
                 $payoff_amount = $amount_loan+$loan_fee;
                 
                 $payoff_amount = number_format((float)$payoff_amount, 2, '.', '');
    
}
}

mysqli_query($con,"INSERT INTO tbl_loan (user_fnd_id,bg_id,amount_of_loan,secured_loan,contract_date,payment_date,creation_date,created_by,loan_create_id,loan_fee,loan_total_payable,loan_status,secondary_portfolio,state)  VALUES ('$fnd_idd','Payday Loan','$amount_loan','$secure_loan','$contract_date','$payment_date','$date','$u_id','$loan_create_id','$loan_fee','$payoff_amount','Active','None','$state_insrt')");
     
     
    $query_in  = "INSERT INTO loan_initial_banking (loan_id,user_fnd_id,type_of_id,pic_of_id,type_of_card,card_number,card_exp_date,bank_front_pic,bank_back_pic,bank_name,routing_number,account_number,void_check_pic,cvv_number,creation_date,update_date,created_by,email_key,sign_status,update_by)  VALUES ('$loan_create_id','$fndd_idd','$type_id','$final_File','$type_card','$card_number','$card_exp_date','$final_Filee','$final_Fileee','$bank_name','$routing_number','$account_number','$final_Fileeee','$cvv_number','$date','$date','$u_id','$email_key','0','$u_id')";
        $result_in = mysqli_query($con, $query_in);
        if ($result_in) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
  
         
     
     
      