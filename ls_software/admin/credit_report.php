<?php
session_start();
include_once 'dbconnect.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$u_id=$userRow['user_id'];
$u_name=$userRow['username'];

$u_access_id = $userRow['access_id'];
if($u_access_id=='0'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}
else {
$DBcon->close();
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['email']; ?></title>

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />

</head>
<body>

<?php include('menu.php') ;?>


<?php

$id=$_GET['id'];

   include 'dbconnect.php';
   include 'dbconfig.php';


$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$id'"); 

while($row = mysqli_fetch_array($sql)) {
$mobile_verification = $row['mobile_verification_status'];
$first_name=$row['first_name'];

//$middle_name =$row['middle_name'];
$last_name =$row['last_name'];
$customer_phone =$row['mobile_number'];
$customer_email =$row['email'];
$address=$row['address'];
$cityy=$row['city'];
$statee=$row['state'];
$zipp=$row['zip_code'];
$dob=$row['date_of_birth'];
$ssn=$row['ssn'];
$creation_date=$row['creation_date'];
$creationdate=date("m-d-y", strtotime($creation_date) );
$last_update=$row['last_update_by'];
$created_by=$row['created_by'];
$last_update_date=$row['last_update_date'];
$last_updatedate=date("m-d-Y H:i:s", strtotime($last_update_date) );
$fnd_dl_code = $row['dl_code'];

$appli_status=$row['application_status'];
$loan_amount=$row['amount_of_loan'];
$source_lead=$row['source_of_lead'];
$declined_reason=$row['declined_reason'];
$decision_logic_status = $row['decision_logic_status'];
$id_photo = $row['id_photo'];
$bank_front = $row['bank_front'];
$bank_back = $row['bank_back'];
$personal_loan_term = $row['personal_loan'];
$void_img = $row['void_img'];
$apr = $row['apr'];

$web = $row['website'];
}

echo"<br><br>";


$id=$_GET['id'];
$id=$_GET['id'];
//echo "Name is: $id_fname";
include 'dbconnect.php';
include 'dbconfig.php';
$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$id'"); 
while($row = mysqli_fetch_array($sql)) {
    
    $user_fnd_id=$row['user_fnd_id'];
    
$mobile_verification = $row['mobile_verification_status'];
$first_name=$row['first_name'];
//$middle_name =$row['middle_name'];
$last_name =$row['last_name'];
$customer_phone =$row['mobile_number'];
$customer_email =$row['email'];
$address=$row['address'];
$cityy=$row['city'];
$statee=$row['state'];
$zipp=$row['zip_code'];
$dob=$row['date_of_birth'];
$ssn=$row['ssn'];
$creation_date=$row['creation_date'];
$creationdate=date("m-d-y", strtotime($creation_date) );
$last_update=$row['last_update_by'];
$created_by=$row['created_by'];
$last_update_date=$row['last_update_date'];
$last_updatedate=date("m-d-Y H:i:s", strtotime($last_update_date) );
$fnd_dl_code = $row['dl_code'];
$appli_status=$row['application_status'];
$loan_amount=$row['amount_of_loan'];
$source_lead=$row['source_of_lead'];
$declined_reason=$row['declined_reason'];
$decision_logic_status = $row['decision_logic_status'];
$id_photo = $row['id_photo'];
$bank_front = $row['bank_front'];
$bank_back = $row['bank_back'];
$personal_loan_term = $row['personal_loan'];
$void_img = $row['void_img'];
$apr = $row['apr'];
$web = $row['website'];
}


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


$ssn_ex = str_replace('-', '', $ssn);
$customer_phone_ex = str_replace('-', '', $customer_phone);
  $code= substr($ssn, 0, 1);
   
   if ($code !== '9' )
   {
       
     
     $password='Admin$$1234';

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://us-api.experian.com/oauth2/v1/token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "username=usharif&password=$password&client_id=AGCcWbXoZpApAuI7yBkfbZm4RmpsyppV&client_secret=WxaKtiQYy9i6ZPTP",
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
  //echo "<br><br><br>";echo"Response". $response."<br><br>";
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
 //echo "<br><br><br>";echo"Response". $response."<br><br>";
}
//$response = "[".$response. "]";

$quoteJson = json_decode($response);

$score= $quoteJson->creditProfile[0]->riskModel[0]->score;
$firstName= $quoteJson->creditProfile[0]->consumerIdentity->name[0]->firstName;
$surname= $quoteJson->creditProfile[0]->consumerIdentity->name[0]->surname;
//$ssn= $quoteJson->creditProfile[0]->ssn[0]->number;


 mysqli_query ($con , "UPDATE `fnd_user_profile` SET `experian_credit_score`='$score' where `user_fnd_id` = '$id'");
$name=$firstName.' '.$surname;

// HTML START

?>
<div style="width:70%; position:relative; margin:auto;"> 
<img src="http://lsbankingportal.com/ls_software/website/images/Money-Line-Logo.JPG"> <hr><br>
<?php 
$id=$_GET['id'];
   include 'dbconnect.php';
   include 'dbconfig.php';
   
   $sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$id'"); 
while($row = mysqli_fetch_array($sql)) {
    
    $user_fnd_id=$row['user_fnd_id'];
    
}
   
 echo $first_name ." " . $last_name."<br>";
 echo "SSN : " . $ssn. "<br>";
 echo "Address : ". $address ." ". $cityy ." ".$statee.  " ". $zipp . " ";
 
 echo  "<br><br>";
foreach($quoteJson as $mydata) {                                                                                                  
   // echo $mydata->name . "<br>";                                                                                                          
    foreach($mydata[0]->addressInformation as $key => $value)                                                                                       
    {  
        $subscriber_code= $value->lastReportingSubscriberCode;
    $address=  $streetPrefix.' '.$streetName.' '.$streetSuffix; 
 

   } 
}
    echo '<b style="text-align:center">----------------SCORE SUMMARY----------------</b><br><br>';
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





 $query_credit  = "INSERT INTO tbl_credit_report (credit_report_key,user_fnd_id,score,vantage_factor)  VALUES ('$credit_key','$user_fnd_id','$score','$vantage_factor')";
        $result_credit = mysqli_query($con, $query_credit);
        if ($result_credit) {
            //echo "<div class='form'><h3> successfully added in tbl_credit_report.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
//********************************************** Credit Report INsert Query *******************************************//


$credit_report_key = $credit_key;





echo '<table  style="width: 100%; text-align:center" >
	<tbody>
		<tr>
			<td>VANTAGE FACTOR : '. $vantage_factor. '</td>
			<td>  =  '.$score.'</td> 
			<td> SCORE FACTORS : ';

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
echo ' </td>
		</tr>
	</tbody>
</table>';

   
        
       // modelIndicator
   
   
    echo '<br><br><b style="text-align:center">----------------TRADES SUMMARY----------------</b><br><br>'; 
    ?>
    <table style="width: 100%; border:none" >
<tr>
<td style="width: 23%;">
<p>&nbsp;SUBSCRIBER</p>
<p>SUB#&nbsp; &nbsp; &nbsp;KOB TYP TRM</p>
<p>ACCOUNT #</p>
</td>
<td style="width: 18.3719%;">
<p>&nbsp;OPEN</p>
<p>ECOA BALDATE</p>
<p>LAST PD</p>
</td>
<td style="width: 10%;">
<p>&nbsp;AMT-TYP1</p>
<p>BALANCE&nbsp;</p>
<p>MONTH PAY</p>
</td>
<td style="width: 15%;">
<p>&nbsp;AMT-TYP2</p>
<p>PYMT LEVEL</p>
<p>PAST DUE</p>
</td>
<td style="width: 17%;">
<p>&nbsp;ACCTCOND</p>
<p>MOS REV</p>
<p>MAXIMUM</p>
</td>
<td style="width: 21%;">
<p>PYMT STATUS&nbsp;</p>
<p>PYMT HISTORY</p>
<p>BY MONTH</p>
</td>
</tr>



<?php
   
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
        echo '
<tr>
<td style="width: 23%;">
<p>*'.$subscriber_name.'</p>
<p>'.$subscriberCode.'&nbsp; &nbsp; &nbsp;'.$kob.' '. $accout_type.' '.$enhancedTerms.'</p>
<p>'.$accountNumber.'</p>
</td>
<td style="width: 18.3719%;">
<p>&nbsp;'.$openDate.'</p>
<p>'.$ecoa.' '.$balance_date.'</p>
<p>'.$lastPaymentDate.'</p>
</td>
<td style="width: 10%;">
<p>$'.$amount1.'</p>
<p>$'.$balanceamount.'&nbsp;</p>
<p> </p>
</td>
<td style="width: 15%;">
<p>$'.$amount2.'</p>
    <p>'.$paymentleveldate.'</p>
<p>$'.$amountPastDue.'</p>
</td>
<td style="width: 17%;">
<p>'.$account_condition.'</p>
<p>('.$monthsHistory.')</p>
<p>'.$max.'</p>
</td>
<td style="width: 21%;">
<p></p>
<p>'.$history.'</p>
</td>
</tr>';
    
 
 
 
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
    
   
echo '</table>';
   
    echo '<br><br><b style="text-align:center">----------------INQUIRIES  SUMMARY----------------</b><br><br>';  
  
echo '<table style="width:100%" >
	<tbody>
		<tr>
			<td>Subscriber Name </td>
			<td>Subscriber Code  </td>
			<td>Terms</td>
			<td>type </td>
			<td>kob </td>
			<td>date </td>
			<td>amount</td>
		</tr>
		
	';
	
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
        
        
        
        echo '<tr>
			<td>'.$subscriberName.' </td>
			<td>'.$subscriber_code.' </td>
			<td>'.$terms1. '</td>
			<td>'.$type1.' </td>
			<td>'.$kob1.' </td>
			<td> '.$date_inq.'</td>
			<td>'.$amount_inq.' </td>
		</tr>';
 
 
 
 
 $date_current = date('Y-m-d H:i:s');
 
  
  $query_inq  = "INSERT INTO  tbl_credit_report_inqueries (credit_report_key,subscriberName,subscriber_code,terms1,type1,kob1,date_inq,amount_inq)  VALUES ('$credit_report_key','$subscriberName','$subscriber_code','$terms1','$type1','$kob1','$date_inq','$amount_inq')";
        $result_inq = mysqli_query($con, $query_inq);
        if ($result_inq) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
        
    }
 echo '   </tbody>
</table>
';
    
    echo '<br><br><b style="text-align:center">----------------MESSAGES----------------</b><br><br>';
  
      foreach($mydata[0]->informationalMessage as $key => $value)                                                                                       
    {
       $messageNumber= $value->messageNumber;
        $messageText= $value->messageText;
        
     echo 'MSG' .$messageNumber.'  - '.  $messageText;
     
     
     $date_current = date('Y-m-d H:i:s');
 
  
  $query_msg  = "INSERT INTO tbl_credit_report_msgs (credit_report_key,messageNumber,messageText)  VALUES ('$credit_report_key','$messageNumber','$messageText')";
        $result_msg = mysqli_query($con, $query_msg);
        if ($result_msg) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
    }
   
      
  

  
   
?>





</div>
<?php

}





?>
<!--
<iframe src="http://lsbankingportal.com/signature_customer/credit_report/credit_report.php?id=<?php echo $id;?>"  width="100%" height="800"></iframe>
-->
</body>
</html>