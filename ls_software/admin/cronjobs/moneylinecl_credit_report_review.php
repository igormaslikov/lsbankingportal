<?php
include('../dbconnect.php');
include('../dbconfig.php');
date_default_timezone_set('America/Los_Angeles');

$query = "SELECT * FROM fnd_user_profile WHERE `date_time_current` < (NOW() - INTERVAL 15 MINUTE) AND `application_status` = 'Decision Logic Completed'  AND decision_logic_status = '1' AND website = 'mymoneyline_cl' AND experian_api_limit < 1 ORDER By user_fnd_id DESC LIMIT 1";

//echo $query . "<br>";
$sql=mysqli_query($con, "$query"); 

  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($sql);
  echo "Row Count is : " . $rowcount. "<br>";
  
while($row = mysqli_fetch_array($sql)) {
$application_id = $row['user_fnd_id'];
//echo $application_id;
$first_name=$row['first_name'];
$last_name =$row['last_name'];
$customer_phone =$row['mobile_number'];
$customer_email =$row['email'];
$address=$row['address'];
$cityy=$row['city'];
$statee=$row['state'];
$zipp=$row['zip_code'];
$dob=$row['date_of_birth'];
$ssn=$row['ssn'];
 //echo $ssn;

$ssn_re =str_replace(" ", "",$ssn) ;
$ssn_ex = str_replace('-', '', $ssn_re);
$customer_phone_re =str_replace(" ", "",$customer_phone) ;
$customer_phone_ex = str_replace('-', '', $customer_phone_re);

$first_name = str_replace(" ", "",$first_name) ;
$first_name = str_replace("á", "a",$first_name) ;
$first_name = str_replace("ñ", "n",$first_name) ;
$first_name = str_replace("í", "i",$first_name) ;
$first_name = str_replace("Á", "A",$first_name) ;
$first_name = str_replace("ó", "o",$first_name) ;
$first_name = str_replace("ú", "u",$first_name) ;
$first_name = str_replace("é", "e",$first_name) ;
$first_name = str_replace(".", " ",$first_name) ;

$last_name =str_replace(" ", "",$last_name) ;
$last_name = str_replace("á", "a",$last_name) ;
$last_name = str_replace("ñ", "n",$last_name) ;
$last_name = str_replace("í", "i",$last_name) ;
$last_name = str_replace("Á", "A",$last_name) ;
$last_name = str_replace("ó", "o",$last_name) ;
$last_name = str_replace("ú", "u",$last_name) ;
$last_name = str_replace("é", "e",$last_name) ;
$last_name = str_replace(".", " ",$last_name) ;

$customer_email = str_replace(" ", "",$customer_email) ;
$cityy =str_replace(" ", "",$cityy) ;
$zipp = str_replace(" ", "",$zipp) ;


mysqli_query ($con , "UPDATE `fnd_user_profile` SET  `experian_api_limit`='1'  where `user_fnd_id` = '$application_id'");

     $code= substr($ssn, 0, 1);
   
   if ($code !== '9' )
   {
    
    
     $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://us-api.experian.com/oauth2/v1/token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "username=lsexpapi&password=@Lsfinancing202&client_id=AGCcWbXoZpApAuI7yBkfbZm4RmpsyppV&client_secret=WxaKtiQYy9i6ZPTP",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/x-www-form-urlencoded",
    "postman-token: fe79edfd-337d-4d82-2208-65314fe1e0d1"
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

$data=json_decode($response, true);
$access_token=$data['access_token'];

//echo $access_token;

//******************************TOKEN END************************//

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://us-api.experian.com/consumerservices/credit-profile/v2/credit-report",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\r\n\r\n    \"consumerPii\": {\r\n\r\n        \"primaryApplicant\": {\r\n\r\n            \"name\": {\r\n\r\n                \"lastName\": \"$last_name\",\r\n\r\n                \"firstName\": \"$first_name\"\r\n\r\n            },\r\n\r\n            \"ssn\": {\r\n\r\n                \"ssn\": \"$ssn_ex\"\r\n\r\n            },\r\n\r\n            \"currentAddress\": {\r\n\r\n                \"line1\": \"$address\",\r\n\r\n                \"city\": \"$cityy\",\r\n\r\n                \"state\": \"$statee\",\r\n\r\n                \"zipCode\": \"$zipp\"\r\n\r\n            },\r\n\r\n            \"phone\": [\r\n\r\n                {\r\n\r\n                    \"number\": \"$customer_phone_ex\"\r\n\r\n                }\r\n\r\n            ]\r\n\r\n        }\r\n\r\n    },\r\n\r\n    \"requestor\": {\r\n\r\n        \"subscriberCode\": \"1984405\" \r\n\r\n    },\r\n\r\n    \"addOns\": {\r\n\r\n        \"riskModels\": {\r\n\r\n            \"modelIndicator\": [\r\n\r\n                \"V4\"\r\n\r\n            ],\r\n\r\n            \"scorePercentile\": \"N\"\r\n\r\n        },\r\n\r\n        \"mla\": \"\",\r\n\r\n        \"ofacmsg\": \"Y\",\r\n\r\n        \"fraudShield\": \"N\",\r\n\r\n        \"paymentHistory84\": \"N\"\r\n\r\n    },\r\n\r\n    \"permissiblePurpose\": {\r\n\r\n        \"type\": \"\",\r\n\r\n        \"terms\": \"\",\r\n\r\n        \"abbreviatedAmount\": \"\"\r\n\r\n    }\r\n\r\n}\r\n\r\n ",
  CURLOPT_HTTPHEADER => array(
    "authorization: Bearer $access_token",
    "cache-control: no-cache",
    "content-type: application/json"
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
//$response = "[".$response. "]";

$quoteJson = json_decode($response);

$score= $quoteJson->creditProfile[0]->riskModel[0]->score;  
   
 $score = (int)$score;
 //$score= substr($score, -3);
 $score = (int)$score;
 $score = str_replace(" ","",$score);
    echo  $score. "<hr>"; 
    if($score<500)
    {
          mysqli_query ($con , "UPDATE `fnd_user_profile` SET `application_status`='Review For Payday' where `user_fnd_id` = '$application_id'");
          mysqli_query ($con , "UPDATE `fnd_user_profile` SET `experian_credit_score`='$score' where `user_fnd_id` = '$application_id'");
          mysqli_query ($con , "UPDATE `fnd_user_profile` SET  `experian_api_limit`='1'  where `user_fnd_id` = '$application_id'");
    echo "<br>hello1<br>";
    
    $date_update= date('Y-m-d H:i:s');
    $query_insert_activity = "Insert into application_status_updates (application_id, status, creation_date) Values ($application_id, ' Automatic App :  Status Changed -Review For Payday- Via Experian API Credit Report ', '$date_update')";
    mysqli_query ($con , $query_insert_activity);
    
    }
    
    if($score>500)
    {
          mysqli_query ($con , "UPDATE `fnd_user_profile` SET `application_status`='Final Review For Personal Loan' where `user_fnd_id` = '$application_id'");
          mysqli_query ($con , "UPDATE `fnd_user_profile` SET `experian_credit_score`='$score' where `user_fnd_id` = '$application_id'");
          mysqli_query ($con , "UPDATE `fnd_user_profile` SET  `experian_api_limit`='1'  where `user_fnd_id` = '$application_id'");
    
    echo "<br>hello132<br>";
    $date_update= date('Y-m-d H:i:s');
    $query_insert_activity = "Insert into application_status_updates (application_id, status, creation_date) Values ($application_id, ' Automatic App :  Status Changed -Final Review For Personal Loan- Via Experian API Credit Report ', '$date_update')";
        mysqli_query ($con , $query_insert_activity);
    }
    
  //************************************* Credit Report Query *******************
    
    
    
    
    
    foreach($quoteJson as $mydata) {                                                                                                  
   // echo $mydata->name . "<br>";                                                                                                          
    foreach($mydata[0]->addressInformation as $key => $value)                                                                                       
    {  
        $subscriber_code= $value->lastReportingSubscriberCode;
    $address=  $streetPrefix.' '.$streetName.' '.$streetSuffix; 
 

   } 
}

$score= $quoteJson->creditProfile[0]->riskModel[0]->score;
$score = ltrim($score, '0');
$vantage_factor =  $quoteJson->creditProfile[0]->riskModel[0]->modelIndicator;

//********************************************** Credit Report INsert Query *******************************************//

    function generateRandomString($length = 25) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
      $credit_key = generateRandomString();;
    // echo $credit_key;





 $query_credit  = "INSERT INTO tbl_credit_report (credit_report_key,user_fnd_id,score,vantage_factor)  VALUES ('$credit_key','$application_id','$score','$vantage_factor')";
        $result_credit = mysqli_query($con, $query_credit);
      if ($result_credit) {
         //echo "<div class='form'><h3> successfully added in tbl_credit_report.</h3><br/></div>";
        } else {
       echo "<h3> Error Inserting Data </h3>";
       }
//********************************************** Credit Report INsert Query *******************************************//


$credit_report_key = $credit_key;



    
    
    //******************************* Score Factors  ************************************
    
    
    foreach($mydata[0]->riskModel[0]->scoreFactors as $key => $value)                                                                                       
    {
        $score_code= $value->code;

        echo " ".$score_code . " ";



$query_credit  = "INSERT INTO tbl_credit_report_scorefactor (credit_report_key,score_code)  VALUES ('$credit_report_key','$score_code')";
        $result_credit = mysqli_query($con, $query_credit);
        if ($result_credit) {
            //echo "<div class='form'><h3> successfully added in tbl_credit_report.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }

}
    
    
    
    
    
    
    //******************************************** TradeLine ******************
    
    
    
      $accountType= '';
        $amount1= '';
        $amount2= '';
        $balance_date= '';
        $chunks = '';
        $balance_date = '';
        $balance_date = '';
        $ecoa= '';
        $enhancedPaymentHistory84 = '';
        $enhancedTerms = '';
        //echo $ecoa. "<br>";
        $subscriberCode = '';
        $kob= '';
        $balanceamount = '';
        $subscriber_name = '';
        $accountNumber = '';
        $openDate = '';
        $chunks = '';
        $openDate = '';
        $openDate = '';
        $lastPaymentDate = '';
        $chunks = '';
        $lastPaymentDate = '';
        $lastPaymentDate = '';
        $amount1= '';
        $amount2= '';
        $amountPastDue = '';
        $paymentleveldate = '';
        $chunks = '';
        $paymentleveldate = '';
        $paymentleveldate = '';
        $monthsHistory = '';
        $max = '';
        $max_1 = '';
        $chunks = '';
        $max_1 = implode('-',$chunks);
        $max = '';;
        $history = '';
        $accout_type = '';
        $account_condition = '';
   
   
   
     
    foreach($mydata[0]->tradeline as $key => $value)                                                                                       
    {
        $accountType= $value->accountType;
        $amount1= $value->amount1;
        $amount2= $value->amount2;
        $balance_date= $value->balanceDate;
        $chunks = str_split($balance_date, 2);
        $balance_date = implode('-',$chunks);
        $balance_date = str_replace ('20-','20',$balance_date);
        $ecoa= $value->ecoa;
        $enhancedPaymentHistory84 = $value->enhancedPaymentData->enhancedPaymentHistory84;
        $enhancedTerms = $value->enhancedPaymentData->enhancedTerms;
        //echo $ecoa. "<br>";
        $subscriberCode = $value->subscriberCode;
        $kob= $value->kob;
        $balanceamount = ltrim($value->balanceAmount, '0');
        $subscriber_name = $value->subscriberName;
        $accountNumber = $value->accountNumber;
        $openDate = $value->openDate;
        $chunks = str_split($openDate, 2);
        $openDate = implode('-',$chunks);
        $openDate = str_replace ('20-','20',$openDate);
        $lastPaymentDate = $value->lastPaymentDate;
        $chunks = str_split($lastPaymentDate, 2);
        $lastPaymentDate = implode('-',$chunks);
        $lastPaymentDate = str_replace ('20-','20',$lastPaymentDate);
        $amount1=ltrim($value->amount1, '0');
        $amount2=ltrim($value->amount2, '0');
        $amountPastDue = ltrim($value->amountPastDue, '0');
        $paymentleveldate = $value->paymentLevelDate;
        $chunks = str_split($paymentleveldate, 2);
        $paymentleveldate = implode('-',$chunks);
        $paymentleveldate = str_replace ('20-','20',$paymentleveldate);
        $monthsHistory = $value->monthsHistory;
        $max = $value->maxDelinquencyDate;
        $max_1 = substr($max, 0, 4);
        $chunks = str_split($max_1, 2);
        $max_1 = implode('-',$chunks);
        $max = $max_1 . "/" . $value->amount1Qualifier;
        $history = substr($value->enhancedPaymentData->enhancedPaymentHistory84, 0, 25);
        $accout_type = $value->accountType;
        $account_condition = $value->enhancedPaymentData->enhancedAccountCondition;
       
 
 
 
  //********************* Tradeline INSERT QUerY  Start ****************************// 
  
 
    
  $query_tradeline  = "INSERT INTO tbl_credit_report_tradeline (credit_report_key,subscriber_name,subscriberCode,kob,accout_type,enhancedTerms,accountNumber,openDate,ecoa,balance_date,lastPaymentDate,amount1,balanceamount,amount2,paymentleveldate,amountPastDue,account_condition,monthsHistory,max,history)  VALUES ('$credit_report_key','$subscriber_name','$subscriberCode','$kob','$accout_type','$enhancedTerms','$accountNumber','$openDate','$ecoa','$balance_date','$lastPaymentDate','$amount1','$balanceamount','$amount2','$paymentleveldate','$amountPastDue','$account_condition','$monthsHistory','$max','$history')";
        $result_tradeline = mysqli_query($con, $query_tradeline);
        if ($result_tradeline) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
  

 
  
  //********************* Tradeline INSERT QUerY END ****************************//        
        
    }
    
    
    
    
    
    //****************************** Inqueries  ***********************************
    
      $subscriberName= '';
        $date_inq= '';
        $kob1='';
        $subscriber_code='';
        $terms1= '';
        $type1= '';
        $amount_inq = '';
    foreach($mydata[0]->inquiry as $key => $value)                                                                                       
    {
        $subscriberName= $value->subscriberName;
        $date_inq= $value->date;
        $kob1= $value->kob;
        $subscriber_code= $value->subscriberCode;
        $terms1= $value->terms;
        $type1= $value->type;
        $amount_inq = $value->amount;


      //********************* Inqueries INSERT QUerY Start ****************************// 
 
  
        $query_inq  = "INSERT INTO  tbl_credit_report_inqueries (credit_report_key,subscriberName,subscriber_code,terms1,type1,kob1,date_inq,amount_inq)  VALUES ('$credit_report_key','$subscriberName','$subscriber_code','$terms1','$type1','$kob1','$date_inq','$amount_inq')";
        $result_inq = mysqli_query($con, $query_inq);
        if ($result_inq) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
        
        //********************* Inqueries INSERT QUerY END ****************************//
        
    }
 
    
    
    
    
    
    
    
    
    //****************************** MSGS foreach ************************************//
    
      foreach($mydata[0]->informationalMessage as $key => $value)                                                                                       
    {
       $messageNumber= $value->messageNumber;
        $messageText= $value->messageText;
        
     echo 'MSG' .$messageNumber.'  - '.  $messageText;
     
     //********************* Msgs INSERT QUerY Start ****************************//
     
     
  $query_msg  = "INSERT INTO tbl_credit_report_msgs (credit_report_key,messageNumber,messageText)  VALUES ('$credit_report_key','$messageNumber','$messageText')";
        $result_msg = mysqli_query($con, $query_msg);
        if ($result_msg) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
        
        //********************* Msgs INSERT QUerY END ****************************//
    }
       
    
    
    
    
    
    
    
    
    
    
    
   }
   
   else{
       
       mysqli_query ($con , "UPDATE `fnd_user_profile` SET `application_status`='Credit Report Needed'  where `user_fnd_id` = '$application_id'");
         $date_update= date('Y-m-d H:i:s');
    $query_insert_activity = "Insert into application_status_updates (application_id, status, creation_date) Values ($application_id, ' Automatic App :  Status Changed (Credit Report Needed) On The Bases Of SSN ', '$date_update')";
    mysqli_query ($con , $query_insert_activity);
   }
    
    
    
    
}
    
    
    
    
    


