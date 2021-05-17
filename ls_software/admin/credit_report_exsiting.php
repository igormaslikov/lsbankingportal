<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

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

$key= $_GET['key'];
$id = $_GET['id'];
$id_credit= "2";

   include $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';
   


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
$decision_logic_status=$row['decision_logic_status'];
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
include $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

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

 
$score= $quoteJson->creditProfile[0]->riskModel[0]->score;
$firstName= $quoteJson->creditProfile[0]->consumerIdentity->name[0]->firstName;
$surname= $quoteJson->creditProfile[0]->consumerIdentity->name[0]->surname;
//$ssn= $quoteJson->creditProfile[0]->ssn[0]->number;


 
// HTML START

?>
<div style="width:70%; position:relative; margin:auto;"> 
<img src="https://lsbankingportal.com/ls_software/website/images/Money-Line-Logo.JPG"> <hr><br>
<?php 

$id_credit= "2";

   include $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';
   
   
   $sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$id'"); 
while($row = mysqli_fetch_array($sql)) {
    
    $user_fnd_id=$row['user_fnd_id'];
    
}
   
 echo $first_name ." " . $last_name."<br>";
 echo "SSN : " . $ssn. "<br>";
 echo "Address : ". $address ." ". $cityy ." ".$statee.  " ". $zipp . " ";
 
 echo  "<br><br>";
 

 $sql_key=mysqli_query($con, "select * from tbl_credit_report where credit_report_key= '$key'"); 
while($row_key = mysqli_fetch_array($sql_key)) {
    
   

    



    echo '<b style="text-align:center">----------------SCORE SUMMARY----------------</b><br><br>';

$score=$row_key['score'];
$score = ltrim($score, '0');
$vantage_factor =  $row_key['vantage_factor'];

echo '<table  style="width: 100%; text-align:center" >
	<tbody>
		<tr>
			<td>VANTAGE FACTOR : '. $vantage_factor. '</td>
			<td>  =  '.$score.'</td>';
}

   
			echo '<td> SCORE FACTORS : ';
			
 $sql_fact=mysqli_query($con, "select * from tbl_credit_report_scorefactor where credit_report_key= '$key'"); 
while($row_fact = mysqli_fetch_array($sql_fact)) {
    

        $score_code= $row_fact['score_code'];

echo " ".$score_code . " ";


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
   
    
   
   
   
     
    $sql_trade=mysqli_query($con, "select * from tbl_credit_report_tradeline where credit_report_key= '$key'"); 
while($row_trade = mysqli_fetch_array($sql_trade)) {
    
        $subscriber_name = $row_trade['subscriber_name'];
        $subscriberCode = $row_trade['subscriberCode'];
        $kob= $row_trade['kob'];
        $accountType= $row_trade['accout_type'];
        $enhancedTerms = $row_trade['enhancedTerms'];
        $accountNumber = $row_trade['accountNumber'];
        $openDate = $row_trade['openDate'];
        $chunks = str_split($openDate, 2);
        $openDate = implode('-',$chunks);
        $openDate = str_replace ('20-','20',$openDate);
        $ecoa= $row_trade['ecoa'];
        $balance_date= $row_trade['balance_date'];
        $chunks = str_split($balance_date, 2);
        $balance_date = implode('-',$chunks);
        $balance_date = str_replace ('20-','20',$balance_date);
        $lastPaymentDate = $row_trade['lastPaymentDate'];
        $chunks = str_split($lastPaymentDate, 2);
        $lastPaymentDate = implode('-',$chunks);
        $lastPaymentDate = str_replace ('20-','20',$lastPaymentDate);
        $amount1= $row_trade['amount1'];
        $amount1=ltrim($value->amount1, '0');
        $balanceamount = $row_trade['balanceamount'];
        $amount2= $row_trade['amount2'];
        $paymentleveldate = $row_trade['paymentleveldate'];
        $chunks = str_split($paymentleveldate, 2);
        $paymentleveldate = implode('-',$chunks);
        $paymentleveldate = str_replace ('20-','20',$paymentleveldate);
         $amountPastDue = $row_trade['amountPastDue'];
         $account_condition = $row_trade['account_condition'];
         $monthsHistory = $row_trade['monthsHistory'];
         $max = $row_trade['max'];
         $history = $row_trade['history'];
         
        $enhancedPaymentHistory84 = $value->enhancedPaymentData->enhancedPaymentHistory84;
       
        //echo $ecoa. "<br>";
       
       
        
       
       
     
        
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
     $sql_inquery=mysqli_query($con, "select * from tbl_credit_report_inqueries where credit_report_key= '$key'"); 
while($row_inquery = mysqli_fetch_array($sql_inquery)) {
    
        $subscriberName= $row_inquery['subscriberName'];
        $subscriber_code= $row_inquery['subscriber_code'];
        $terms1= $row_inquery['terms1'];
        $type1= $row_inquery['type1'];
        $kob1= $row_inquery['kob1'];
        $date_inq= $row_inquery['date_inq'];
        $amount_inq = $row_inquery['amount_inq'];
        
        
        
        echo '<tr>
			<td>'.$subscriberName.' </td>
			<td>'.$subscriber_code.' </td>
			<td>'.$terms1. '</td>
			<td>'.$type1.' </td>
			<td>'.$kob1.' </td>
			<td> '.$date_inq.'</td>
			<td>'.$amount_inq.' </td>
		</tr>';
 
 
 
 
 
        
    }
 echo '   </tbody>
</table>
';
    
    echo '<br><br><b style="text-align:center">----------------MESSAGES----------------</b><br><br>';
    $sql_msg=mysqli_query($con, "select * from tbl_credit_report_msgs where credit_report_key= '$key'"); 
while($row_msg = mysqli_fetch_array($sql_msg)) {
    
       $messageNumber= $row_msg['messageNumber'];
        $messageText= $row_msg['messageText'];
        
     echo 'MSG' .$messageNumber.'  - '.  $messageText;

 
  
    }
   
      
  

  
   
?>





</div>

<!--
<iframe src="http://lsbankingportal.com/signature_customer/credit_report/credit_report.php?id=<?php echo $id;?>"  width="100%" height="800"></iframe>
-->
</body>
</html>