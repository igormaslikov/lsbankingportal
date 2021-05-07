
<?php 
include_once '../dbconnect.php';
include_once '../dbconfig.php';
$sql_fnd=mysqli_query($con, "SELECT DISTINCT  `user_fnd_id` FROM `tbl_loan` WHERE (`contract_date` BETWEEN '2019-01-01' AND '2019-12-31') AND `sign_status` = 1"); 



while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];

$sql_fnd_1=mysqli_query($con, "SELECT COUNT(`user_fnd_id`) as counter FROM `tbl_loan` WHERE (`contract_date` BETWEEN '2019-01-01' AND '2019-12-31') AND `user_fnd_id` = '$user_fnd_id'AND `sign_status` = 1
"); 
$total_loan_fee = 0;
while($row_fnd_1 = mysqli_fetch_array($sql_fnd_1)) {

$fee_1_repeat=$row_fnd_1['counter'];


if($fee_1_repeat==1){
   // echo "Select * FROM `tbl_loan` WHERE (`contract_date` BETWEEN '2019-01-01' AND '2019-12-31') AND `user_fnd_id` = '$user_fnd_id'AND `sign_status` = 1";
    $sql_fnd_1_fee = mysqli_query($con,"Select * FROM `tbl_loan` WHERE (`contract_date` BETWEEN '2019-01-01' AND '2019-12-31') AND `user_fnd_id` = '$user_fnd_id' AND `sign_status` = '1'");
    while($row_fnd_1_fee=mysqli_fetch_array($sql_fnd_1_fee)) {
$ha = "haha";
$userfnd_id=$row_fnd_1_fee['user_fnd_id'];
$loan_status=$row_fnd_1_fee['loan_status'];
$loan_id_fee=$row_fnd_1_fee['loan_id'];
 $amount_of_loan_fee=$row_fnd_1_fee['amount_of_loan'];
 
$query_payment_fee = mysqli_query($con,"SELECT SUM(payoff_amount) AS value_summ FROM loan_transaction where loan_id= '$loan_id_fee'");
while ($row_payment_fee=mysqli_fetch_array($query_payment_fee)){
    $payment_fee = $row_payment_fee['value_summ'];
    
    $payment_fee = number_format((float)$payment_fee, 2, '.', '');
break;
    //echo"<br>FEE:" .$payment_fee;

}

$loan_payment_fee=$payment_fee-$amount_of_loan_fee;
if($loan_payment_fee>0)
{
$total_loan_fee_1+=$loan_payment_fee;
$total_loan_fee_grand+=$loan_payment_fee;
}
}
//echo "FND ID : ".$user_fnd_id." - ".$fee_1_repeat." : Counter:".$total_loan_fee."<br>";
$fee_1 = $total_loan_fee_1;
}






if($fee_1_repeat==2){
   // echo "Select * FROM `tbl_loan` WHERE (`contract_date` BETWEEN '2019-01-01' AND '2019-12-31') AND `user_fnd_id` = '$user_fnd_id'AND `sign_status` = 1";
    $sql_fnd_1_fee = mysqli_query($con,"Select * FROM `tbl_loan` WHERE (`contract_date` BETWEEN '2019-01-01' AND '2019-12-31') AND `user_fnd_id` = '$user_fnd_id' AND `sign_status` = '1'");
    while($row_fnd_1_fee=mysqli_fetch_array($sql_fnd_1_fee)) {
$ha = "haha";
$userfnd_id=$row_fnd_1_fee['user_fnd_id'];
$loan_status=$row_fnd_1_fee['loan_status'];
$loan_id_fee=$row_fnd_1_fee['loan_id'];
 $amount_of_loan_fee=$row_fnd_1_fee['amount_of_loan'];
 
$query_payment_fee = mysqli_query($con,"SELECT SUM(payoff_amount) AS value_summ FROM loan_transaction where loan_id= '$loan_id_fee'");
while ($row_payment_fee=mysqli_fetch_array($query_payment_fee)){
    $payment_fee = $row_payment_fee['value_summ'];
    
    $payment_fee = number_format((float)$payment_fee, 2, '.', '');
break;
    //echo"<br>FEE:" .$payment_fee;

}

$loan_payment_fee=$payment_fee-$amount_of_loan_fee;
if($loan_payment_fee>0)
{
$total_loan_fee_2+=$loan_payment_fee;
$total_loan_fee_grand+=$loan_payment_fee;
}
}
//echo "FND ID : ".$user_fnd_id." - ".$fee_1_repeat." : Counter:".$total_loan_fee."<br>";
$fee_2 = $total_loan_fee_2;
}
    
    
    
    
 

if($fee_1_repeat==3){
   // echo "Select * FROM `tbl_loan` WHERE (`contract_date` BETWEEN '2019-01-01' AND '2019-12-31') AND `user_fnd_id` = '$user_fnd_id'AND `sign_status` = 1";
    $sql_fnd_1_fee = mysqli_query($con,"Select * FROM `tbl_loan` WHERE (`contract_date` BETWEEN '2019-01-01' AND '2019-12-31') AND `user_fnd_id` = '$user_fnd_id' AND `sign_status` = '1'");
    while($row_fnd_1_fee=mysqli_fetch_array($sql_fnd_1_fee)) {
$ha = "haha";
$userfnd_id=$row_fnd_1_fee['user_fnd_id'];
$loan_status=$row_fnd_1_fee['loan_status'];
$loan_id_fee=$row_fnd_1_fee['loan_id'];
 $amount_of_loan_fee=$row_fnd_1_fee['amount_of_loan'];
 
$query_payment_fee = mysqli_query($con,"SELECT SUM(payoff_amount) AS value_summ FROM loan_transaction where loan_id= '$loan_id_fee'");
while ($row_payment_fee=mysqli_fetch_array($query_payment_fee)){
    $payment_fee = $row_payment_fee['value_summ'];
    
    $payment_fee = number_format((float)$payment_fee, 2, '.', '');
break;
    //echo"<br>FEE:" .$payment_fee;

}

$loan_payment_fee=$payment_fee-$amount_of_loan_fee;
if($loan_payment_fee>0)
{
$total_loan_fee_3+=$loan_payment_fee;
$total_loan_fee_grand+=$loan_payment_fee;
}
}
//echo "FND ID : ".$user_fnd_id." - ".$fee_1_repeat." : Counter:".$total_loan_fee."<br>";
$fee_3 = $total_loan_fee_3;
}   
  
  
  
  
  
  

if($fee_1_repeat==4){
   // echo "Select * FROM `tbl_loan` WHERE (`contract_date` BETWEEN '2019-01-01' AND '2019-12-31') AND `user_fnd_id` = '$user_fnd_id'AND `sign_status` = 1";
    $sql_fnd_1_fee = mysqli_query($con,"Select * FROM `tbl_loan` WHERE (`contract_date` BETWEEN '2019-01-01' AND '2019-12-31') AND `user_fnd_id` = '$user_fnd_id' AND `sign_status` = '1'");
    while($row_fnd_1_fee=mysqli_fetch_array($sql_fnd_1_fee)) {
$ha = "haha";
$userfnd_id=$row_fnd_1_fee['user_fnd_id'];
$loan_status=$row_fnd_1_fee['loan_status'];
$loan_id_fee=$row_fnd_1_fee['loan_id'];
 $amount_of_loan_fee=$row_fnd_1_fee['amount_of_loan'];
 
$query_payment_fee = mysqli_query($con,"SELECT SUM(payoff_amount) AS value_summ FROM loan_transaction where loan_id= '$loan_id_fee'");
while ($row_payment_fee=mysqli_fetch_array($query_payment_fee)){
    $payment_fee = $row_payment_fee['value_summ'];
    
    $payment_fee = number_format((float)$payment_fee, 2, '.', '');
break;
    //echo"<br>FEE:" .$payment_fee;

}

$loan_payment_fee=$payment_fee-$amount_of_loan_fee;
if($loan_payment_fee>0)
{
$total_loan_fee_4+=$loan_payment_fee;
$total_loan_fee_grand+=$loan_payment_fee;
}
}
//echo "FND ID : ".$user_fnd_id." - ".$fee_1_repeat." : Counter:".$total_loan_fee."<br>";
$fee_4 = $total_loan_fee_4;
}





if($fee_1_repeat==5){
   // echo "Select * FROM `tbl_loan` WHERE (`contract_date` BETWEEN '2019-01-01' AND '2019-12-31') AND `user_fnd_id` = '$user_fnd_id'AND `sign_status` = 1";
    $sql_fnd_1_fee = mysqli_query($con,"Select * FROM `tbl_loan` WHERE (`contract_date` BETWEEN '2019-01-01' AND '2019-12-31') AND `user_fnd_id` = '$user_fnd_id' AND `sign_status` = '1'");
    while($row_fnd_1_fee=mysqli_fetch_array($sql_fnd_1_fee)) {
$ha = "haha";
$userfnd_id=$row_fnd_1_fee['user_fnd_id'];
$loan_status=$row_fnd_1_fee['loan_status'];
$loan_id_fee=$row_fnd_1_fee['loan_id'];
 $amount_of_loan_fee=$row_fnd_1_fee['amount_of_loan'];
 
$query_payment_fee = mysqli_query($con,"SELECT SUM(payoff_amount) AS value_summ FROM loan_transaction where loan_id= '$loan_id_fee'");
while ($row_payment_fee=mysqli_fetch_array($query_payment_fee)){
    $payment_fee = $row_payment_fee['value_summ'];
    
    $payment_fee = number_format((float)$payment_fee, 2, '.', '');
break;
    //echo"<br>FEE:" .$payment_fee;

}

$loan_payment_fee=$payment_fee-$amount_of_loan_fee;
if($loan_payment_fee>0)
{
$total_loan_fee_5+=$loan_payment_fee;
$total_loan_fee_grand+=$loan_payment_fee;
}
}
//echo "FND ID : ".$user_fnd_id." - ".$fee_1_repeat." : Counter:".$total_loan_fee."<br>";
$fee_5 = $total_loan_fee_5;
}






if($fee_1_repeat==6){
   // echo "Select * FROM `tbl_loan` WHERE (`contract_date` BETWEEN '2019-01-01' AND '2019-12-31') AND `user_fnd_id` = '$user_fnd_id'AND `sign_status` = 1";
    $sql_fnd_1_fee = mysqli_query($con,"Select * FROM `tbl_loan` WHERE (`contract_date` BETWEEN '2019-01-01' AND '2019-12-31') AND `user_fnd_id` = '$user_fnd_id' AND `sign_status` = '1'");
    while($row_fnd_1_fee=mysqli_fetch_array($sql_fnd_1_fee)) {
$ha = "haha";
$userfnd_id=$row_fnd_1_fee['user_fnd_id'];
$loan_status=$row_fnd_1_fee['loan_status'];
$loan_id_fee=$row_fnd_1_fee['loan_id'];
 $amount_of_loan_fee=$row_fnd_1_fee['amount_of_loan'];
 
$query_payment_fee = mysqli_query($con,"SELECT SUM(payoff_amount) AS value_summ FROM loan_transaction where loan_id= '$loan_id_fee'");
while ($row_payment_fee=mysqli_fetch_array($query_payment_fee)){
    $payment_fee = $row_payment_fee['value_summ'];
    
    $payment_fee = number_format((float)$payment_fee, 2, '.', '');
break;
    //echo"<br>FEE:" .$payment_fee;

}

$loan_payment_fee=$payment_fee-$amount_of_loan_fee;
if($loan_payment_fee>0)
{
$total_loan_fee_6+=$loan_payment_fee;

$total_loan_fee_grand+=$loan_payment_fee;
}
}
//echo "FND ID : ".$user_fnd_id." - ".$fee_1_repeat." : Counter:".$total_loan_fee."<br>";
$fee_6 = $total_loan_fee_6;
}









if($fee_1_repeat>6){
   // echo "Select * FROM `tbl_loan` WHERE (`contract_date` BETWEEN '2019-01-01' AND '2019-12-31') AND `user_fnd_id` = '$user_fnd_id'AND `sign_status` = 1";
    $sql_fnd_1_fee = mysqli_query($con,"Select * FROM `tbl_loan` WHERE (`contract_date` BETWEEN '2019-01-01' AND '2019-12-31') AND `user_fnd_id` = '$user_fnd_id' AND `sign_status` = '1'");
    while($row_fnd_1_fee=mysqli_fetch_array($sql_fnd_1_fee)) {
$ha = "haha";
$userfnd_id=$row_fnd_1_fee['user_fnd_id'];
$loan_status=$row_fnd_1_fee['loan_status'];
$loan_id_fee=$row_fnd_1_fee['loan_id'];
 $amount_of_loan_fee=$row_fnd_1_fee['amount_of_loan'];
 
$query_payment_fee = mysqli_query($con,"SELECT SUM(payoff_amount) AS value_summ FROM loan_transaction where loan_id= '$loan_id_fee'");
while ($row_payment_fee=mysqli_fetch_array($query_payment_fee)){
    $payment_fee = $row_payment_fee['value_summ'];
    
    $payment_fee = number_format((float)$payment_fee, 2, '.', '');
break;
    //echo"<br>FEE:" .$payment_fee;

}

$loan_payment_fee=$payment_fee-$amount_of_loan_fee;
if($loan_payment_fee>0)
{
$total_loan_fee_7+=$loan_payment_fee;
$total_loan_fee_grand+=$loan_payment_fee;
}
}
//echo "FND ID : ".$user_fnd_id." - ".$fee_1_repeat." : Counter:".$total_loan_fee."<br>";
$fee_7 = $total_loan_fee_7;
}




}

}

//echo "Grand : ". $total_loan_fee_grand;
?>
<html>
<head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<style type="text/css">
<!--
span.cls_002{font-family:Arial,serif;font-size:8.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_002{font-family:Arial,serif;font-size:8.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_011{font-family:"Segoe UI",serif;font-size:9.9px;color:rgb(33,33,33);font-weight:normal;font-style:normal;text-decoration: underline}
div.cls_011{font-family:"Segoe UI",serif;font-size:9.9px;color:rgb(33,33,33);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_005{font-family:"Segoe UI Bold",serif;font-size:13.8px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_005{font-family:"Segoe UI Bold",serif;font-size:13.8px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_006{font-family:"Segoe UI Bold",serif;font-size:11.8px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_006{font-family:"Segoe UI Bold",serif;font-size:11.8px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_007{font-family:"Segoe UI Bold",serif;font-size:8.9px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_007{font-family:"Segoe UI Bold",serif;font-size:8.9px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_008{font-family:"Segoe UI",serif;font-size:9.1px;color:rgb(51,51,51);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_008{font-family:"Segoe UI",serif;font-size:9.1px;color:rgb(51,51,51);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_004{font-family:"Segoe UI",serif;font-size:9.9px;color:rgb(51,51,51);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_004{font-family:"Segoe UI",serif;font-size:9.9px;color:rgb(51,51,51);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_009{font-family:"Segoe UI",serif;font-size:14.8px;color:rgb(51,51,51);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_009{font-family:"Segoe UI",serif;font-size:14.8px;color:rgb(51,51,51);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_010{font-family:Arial,serif;font-size:9.1px;color:rgb(51,51,51);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_010{font-family:Arial,serif;font-size:9.1px;color:rgb(51,51,51);font-weight:normal;font-style:normal;text-decoration: none}
-->
</style>
<script type="text/javascript" src="28923072-6510-11ea-8b25-0cc47a792c0a_id_28923072-6510-11ea-8b25-0cc47a792c0a_files/wz_jsgraphics.js"></script>
</head>
<body>
<div style="position:absolute;left:50%;margin-left:-306px;top:0px;width:612px;height:792px;border-style:outset;overflow:hidden">
<div style="position:absolute;left:0px;top:0px">
<img src="28923072-6510-11ea-8b25-0cc47a792c0a_id_28923072-6510-11ea-8b25-0cc47a792c0a_files/background1.jpg" width=612 height=792></div>
<div style="position:absolute;left:26.45px;top:14.00px" class="cls_002"><span class="cls_002">3/10/2020</span></div>
<div style="position:absolute;left:298.89px;top:14.00px" class="cls_002"><span class="cls_002">CDDTL Annual Report</span></div>
<div style="position:absolute;left:486.13px;top:52.41px" class="cls_011"><span class="cls_011"> </span><A HREF="https://docqnet.dbo.ca.gov/AnnualReporting/Reports/Home?ent=cms_annualreportcddtlmain&pks=cms_arcddtlid&id=CDDTL%20-%202019%20-%2010DBO-93629">My Reports</A> </div>
<div style="position:absolute;left:491.66px;top:69.76px" class="cls_011"><span class="cls_011"> </span><A HREF="https://docqnet.dbo.ca.gov/profile/">My Profile</A> </div>
<div style="position:absolute;left:154.65px;top:116.41px" class="cls_005"><span class="cls_005">CDDTL ANNUAL REPORT & INDUSTRY SURVEY</span></div>
<div style="position:absolute;left:203.52px;top:135.20px" class="cls_005"><span class="cls_005">FOR THE CALENDAR YEAR 2019</span></div>
<div style="position:absolute;left:257.87px;top:166.80px" class="cls_006"><span class="cls_006">INDUSTRY SURVEY</span></div>
<div style="position:absolute;left:122.76px;top:203.71px" class="cls_007"><span class="cls_007">For licensees engaged in business under the California Deferred Deposit Transaction Law</span></div>
<div style="position:absolute;left:232.94px;top:220.86px" class="cls_008"><span class="cls_008">January 1, 2019 - December 31, 2019</span></div>
<div style="position:absolute;left:36.95px;top:247.01px" class="cls_006"><span class="cls_006">FEES/FINANCE CHARGES</span></div>
<div style="position:absolute;left:31.89px;top:273.55px" class="cls_004"><span class="cls_004">Report fees (finance charges) collected pursuant to Financial Code section 23036 (a). Do not include returned item (NSF) fees</span></div>
<div style="position:absolute;left:31.89px;top:286.55px" class="cls_004"><span class="cls_004">in question numbers 75 through 82.</span></div>
<div style="position:absolute;left:31.89px;top:314.08px" class="cls_008"><span class="cls_008">75. How much in fees did you collect from customers</span></div>
<div style="position:absolute;left:261.60px;top:313.44px" class="cls_009"><span class="cls_009">$</span></div>
<div style="position:absolute;left:350.59px;top:319.14px" class="cls_010"><span class="cls_010"><?php echo $fee_1; ?></span></div>
<div style="position:absolute;left:31.89px;top:327.09px" class="cls_008"><span class="cls_008">who made one deferred deposit transaction in 2019</span></div>
<div style="position:absolute;left:31.89px;top:340.10px" class="cls_008"><span class="cls_008">(exclude returned unpaid item fees)?</span></div>
<div style="position:absolute;left:31.89px;top:357.44px" class="cls_008"><span class="cls_008">76. How much in fees did you collect from customers</span></div>
<div style="position:absolute;left:261.60px;top:356.80px" class="cls_009"><span class="cls_009">$</span></div>
<div style="position:absolute;left:350.59px;top:362.50px" class="cls_010"><span class="cls_010"><?php echo $fee_2; ?></span></div>
<div style="position:absolute;left:31.89px;top:370.45px" class="cls_008"><span class="cls_008">who made two deferred deposit transactions in 2019</span></div>
<div style="position:absolute;left:31.89px;top:383.46px" class="cls_008"><span class="cls_008">(exclude returned unpaid item fees)?</span></div>
<div style="position:absolute;left:31.89px;top:400.80px" class="cls_008"><span class="cls_008">77. How much in fees did you collect from customers</span></div>
<div style="position:absolute;left:261.60px;top:400.16px" class="cls_009"><span class="cls_009">$</span></div>
<div style="position:absolute;left:350.59px;top:405.86px" class="cls_010"><span class="cls_010"><?php echo $fee_3; ?></span></div>
<div style="position:absolute;left:31.89px;top:413.81px" class="cls_008"><span class="cls_008">who made three deferred deposit transactions in</span></div>
<div style="position:absolute;left:31.89px;top:426.82px" class="cls_008"><span class="cls_008">2019 (exclude returned unpaid item fees)?</span></div>
<div style="position:absolute;left:31.89px;top:444.16px" class="cls_008"><span class="cls_008">78. How much in fees did you collect from customers</span></div>
<div style="position:absolute;left:261.60px;top:443.52px" class="cls_009"><span class="cls_009">$</span></div>
<div style="position:absolute;left:350.59px;top:449.22px" class="cls_010"><span class="cls_010"><?php echo $fee_4; ?></span></div>
<div style="position:absolute;left:31.89px;top:457.17px" class="cls_008"><span class="cls_008">who made four deferred deposit transactions in 2019</span></div>
<div style="position:absolute;left:31.89px;top:470.17px" class="cls_008"><span class="cls_008">(exclude returned unpaid item fees)?</span></div>
<div style="position:absolute;left:31.89px;top:487.52px" class="cls_008"><span class="cls_008">79. How much in fees did you collect from customers</span></div>
<div style="position:absolute;left:261.60px;top:486.87px" class="cls_009"><span class="cls_009">$</span></div>
<div style="position:absolute;left:350.59px;top:492.58px" class="cls_010"><span class="cls_010"><?php echo $fee_5; ?></span></div>
<div style="position:absolute;left:31.89px;top:500.53px" class="cls_008"><span class="cls_008">who made five deferred deposit transactions in 2019</span></div>
<div style="position:absolute;left:31.89px;top:513.53px" class="cls_008"><span class="cls_008">(exclude returned unpaid item fees)?</span></div>
<div style="position:absolute;left:31.89px;top:530.88px" class="cls_008"><span class="cls_008">80. How much in fees did you collect from customers</span></div>
<div style="position:absolute;left:261.60px;top:530.23px" class="cls_009"><span class="cls_009">$</span></div>
<div style="position:absolute;left:350.59px;top:535.94px" class="cls_010"><span class="cls_010"><?php echo $fee_6; ?></span></div>
<div style="position:absolute;left:31.89px;top:543.89px" class="cls_008"><span class="cls_008">who made six deferred deposit transactions in 2019</span></div>
<div style="position:absolute;left:31.89px;top:556.89px" class="cls_008"><span class="cls_008">(exclude returned unpaid item fees)?</span></div>
<div style="position:absolute;left:31.89px;top:574.24px" class="cls_008"><span class="cls_008">81. How much in fees did you collect from customers</span></div>
<div style="position:absolute;left:261.60px;top:573.59px" class="cls_009"><span class="cls_009">$</span></div>
<div style="position:absolute;left:350.59px;top:579.30px" class="cls_010"><span class="cls_010"><?php echo $fee_7; ?></span></div>
<div style="position:absolute;left:31.89px;top:587.24px" class="cls_008"><span class="cls_008">who made seven or more deferred deposit</span></div>
<div style="position:absolute;left:31.89px;top:600.25px" class="cls_008"><span class="cls_008">transactions in 2019 (exclude returned unpaid item</span></div>
<div style="position:absolute;left:31.89px;top:613.26px" class="cls_008"><span class="cls_008">fees)?</span></div>
<div style="position:absolute;left:31.89px;top:630.60px" class="cls_008"><span class="cls_008">82. Total fees collected from customers in 2019:</span></div>
<div style="position:absolute;left:263.05px;top:629.96px" class="cls_009"><span class="cls_009">$</span></div>
<div style="position:absolute;left:350.32px;top:635.66px" class="cls_010"><span class="cls_010"><?php echo number_format((float)$total_loan_fee_grand, 2, '.', ''); ?></span></div>
<div style="position:absolute;left:36.95px;top:669.04px" class="cls_006"><span class="cls_006">RETURNED ITEM (NSF) FEES</span></div>
<div style="position:absolute;left:31.89px;top:699.26px" class="cls_008"><span class="cls_008">83. Total number of deferred deposit transactions in</span></div>
<div style="position:absolute;left:453.59px;top:699.98px" class="cls_010"><span class="cls_010">0</span></div>
<div style="position:absolute;left:31.89px;top:712.26px" class="cls_008"><span class="cls_008">which a returned item (NSF) fee was charged to the</span></div>
<div style="position:absolute;left:31.89px;top:725.27px" class="cls_008"><span class="cls_008">customer in 2019:</span></div>
<div style="position:absolute;left:26.45px;top:767.00px" class="cls_002"><span class="cls_002"> </span><A HREF="https://docqnet.dbo.ca.gov/annualreporting/cddtl/questions7597?cms_arcddtlid=cddtl/">https://docqnet.dbo.ca.gov/AnnualReporting/CDDTL/Questions7597?cms_arcddtlid=CDDTL</A> - 2019 - 10DBO-93629</div>
<div style="position:absolute;left:574.41px;top:767.00px" class="cls_002"><span class="cls_002">1/3</span></div>
</div>

</body>
</html>
