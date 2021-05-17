<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';


 $id=$_GET['id'];
 $year="2019";
$sql_fnd=mysqli_query($con, "select DISTINCT user_fnd_id as visitorss
from tbl_loan WHERE `contract_date` BETWEEN '2019-01-01' AND '2019-12-31'"); 



while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['visitorss'];
//echo "visitorss" .$user_fnd_id."<br>";


$query_search = "SELECT * FROM `tbl_loan` where user_fnd_id= '$user_fnd_id'";

if ($result_t=mysqli_query($con,$query_search))
  {
  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($result_t);
 // printf($rowcount);
  // Free result set
  $ye=mysqli_free_result($result_t);
 // echo $rowcount;
  
   
   
   $sql_dup = "SELECT * FROM tbl_repeat_loan_transaction WHERE `user_fnd_id` = '$user_fnd_id'";
        $result_dup = mysqli_query($con, $sql_dup);

       if(mysqli_num_rows($result_dup) > 0)
       {
           mysqli_query($con, "UPDATE tbl_repeat_loan_transaction SET  loan_count='$rowcount'  where user_fnd_id ='$user_fnd_id'");
     }
       else
       {  
  
  
      $query_emp  = "INSERT INTO tbl_repeat_loan_transaction (user_fnd_id,loan_count)  VALUES ('$user_fnd_id','$rowcount')";
        $result_emp = mysqli_query($con, $query_emp);
        if ($result_emp) {
         //echo "<div class='form'><h3> successfully added in tbl_repeat_loan_transaction.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        } 
       }
  
  
  }







}


 
    
    

?>


<?php
$sql_income=mysqli_query($con, "select DISTINCT user_fnd_id as visitorss
from tbl_loan WHERE `contract_date` BETWEEN '2019-01-01' AND '2019-12-31'"); 



$net_10=0;
$net_20=0;
$net_30=0;
$net_40=0;
$net_50=0;
$net_60=0;
$net_70=0;
$net_80=0;
$net_90=0;
$net_100=0;


while($row_income = mysqli_fetch_array($sql_income)) {

$user_fnd_incm=$row_income['visitorss'];
//echo "ID " .$user_fnd_incm."<br>";

$sql_incomee=mysqli_query($con, "select*
from source_income WHERE user_fnd_id='$user_fnd_incm'"); 



while($row_incomee = mysqli_fetch_array($sql_incomee)) {

$user_fnd_incom=$row_incomee['user_fnd_id'];
$net_check_amount=$row_incomee['net_check_amount'];
$pay_period=$row_incomee['pay_period'];
//echo "ID Source " .$net_check_amount."<br>";

 if($pay_period=='Monthly'){
      
      $monthly=$net_check_amount*12;
     
      
  }
  
  else if($pay_period=='Semi Monthly'){
      $semi_monthly=$net_check_amount*24;
      
  }
  
  else if($pay_period=='Weekly'){
      
      $weekly=$net_check_amount*52;
  }
  
  else if($pay_period=='Bi-Weekly'){
      $bi_weekly=$net_check_amount*26;
      
  }
  
  $total_income=$monthly+$semi_monthly+$weekly+$bi_weekly;
 //echo "total_income ".$total_income."<br><br>";
  
  
  
  
  if($total_income<=10000)
  {
      $net_10=$net_10+1;
      
      
  }
  
  else if($total_income>10000 && $total_income <20000){
      
     $net_20=$net_20+1;
  }
  
  else if($total_income>20000 && $total_income <30000){
      
     $net_30=$net_30+1;
  }
  
   else if($total_income>30000 && $total_income <40000){
      
     $net_40=$net_40+1;
  }
  
   else if($total_income>40000 && $total_income <50000){
      
     $net_50=$net_50+1;
  }
  
  
  else if($total_income>50000 && $total_income <60000){
      
     $net_60=$net_60+1;
  }
  
  
  else if($total_income>60000 && $total_income <70000){
      
     $net_70=$net_70+1;
  }
  
  else if($total_income>70000 && $total_income <80000){
      
     $net_80=$net_80+1;
  }
  else if($total_income>80000 && $total_income <90000){
      
     $net_90=$net_90+1;
  }
  
   else if($total_income>90000 && $total_income <100000){
      
     $net_100=$net_100+1;
  }
  
  
  
  
  
}


}

?>


<?php








$query_loan= "SELECT * FROM `tbl_loan`";
if ($result_loan=mysqli_query($con,$query_loan))
  {
  // Return the number of rows in result set
  $rowcount_loan=mysqli_num_rows($result_loan);
 // printf($rowcount);
  // Free result set
  $ye_loan=mysqli_free_result($result_loan);
  //echo $ye_loan;
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

<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<style type="text/css">
<!--
span.cls_002{font-family:Arial,serif;font-size:8.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_002{font-family:Arial,serif;font-size:8.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_016{font-family:"Segoe UI",serif;font-size:9.9px;color:rgb(33,33,33);font-weight:normal;font-style:normal;text-decoration: underline}
div.cls_016{font-family:"Segoe UI",serif;font-size:9.9px;color:rgb(33,33,33);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_005{font-family:"Segoe UI Bold",serif;font-size:13.8px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_005{font-family:"Segoe UI Bold",serif;font-size:13.8px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_006{font-family:"Segoe UI Bold",serif;font-size:10.9px;color:rgb(231,12,77);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_006{font-family:"Segoe UI Bold",serif;font-size:10.9px;color:rgb(231,12,77);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_007{font-family:"Segoe UI Bold",serif;font-size:11.8px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_007{font-family:"Segoe UI Bold",serif;font-size:11.8px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_008{font-family:"Segoe UI Bold",serif;font-size:8.9px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_008{font-family:"Segoe UI Bold",serif;font-size:8.9px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_009{font-family:"Segoe UI",serif;font-size:9.1px;color:rgb(51,51,51);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_009{font-family:"Segoe UI",serif;font-size:9.1px;color:rgb(51,51,51);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_004{font-family:"Segoe UI",serif;font-size:9.9px;color:rgb(51,51,51);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_004{font-family:"Segoe UI",serif;font-size:9.9px;color:rgb(51,51,51);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_010{font-family:Arial,serif;font-size:9.1px;color:rgb(51,51,51);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_010{font-family:Arial,serif;font-size:9.1px;color:rgb(51,51,51);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_011{font-family:Arial,serif;font-size:9.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_011{font-family:Arial,serif;font-size:9.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_012{font-family:Arial,serif;font-size:9.1px;color:rgb(51,51,51);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_012{font-family:Arial,serif;font-size:9.1px;color:rgb(51,51,51);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_013{font-family:"Segoe UI Bold",serif;font-size:9.9px;color:rgb(231,12,77);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_013{font-family:"Segoe UI Bold",serif;font-size:9.9px;color:rgb(231,12,77);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_014{font-family:"Segoe UI Bold",serif;font-size:9.1px;color:rgb(51,51,51);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_014{font-family:"Segoe UI Bold",serif;font-size:9.1px;color:rgb(51,51,51);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_015{font-family:Arial,serif;font-size:9.9px;color:rgb(51,51,51);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_015{font-family:Arial,serif;font-size:9.9px;color:rgb(51,51,51);font-weight:bold;font-style:normal;text-decoration: none}
-->
</style>
<script type="text/javascript" src="pdf1/wz_jsgraphics.js"></script>
</head>

<body>

        
    


  



<div style="position:absolute;left:50%;margin-left:-306px;top:0px;width:612px;height:792px;border-style:outset;overflow:hidden">
<div style="position:absolute;left:0px;top:0px">
<img src="" width=612 height=792></div>
<div style="position:absolute;left:26.45px;top:14.00px" class="cls_002"><span class="cls_002">3/10/2020</span></div>
<div style="position:absolute;left:298.89px;top:14.00px" class="cls_002"><span class="cls_002">CDDTL Annual Report</span></div>
<div style="position:absolute;left:486.13px;top:52.41px" class="cls_016"><span class="cls_016"> </span><A HREF="https://docqnet.dbo.ca.gov/AnnualReporting/Reports/Home?ent=cms_annualreportcddtlmain&pks=cms_arcddtlid&id=CDDTL%20-%202019%20-%2010DBO-93629">My Reports</A> </div>
<div style="position:absolute;left:491.66px;top:69.76px" class="cls_016"><span class="cls_016"> </span><A HREF="https://docqnet.dbo.ca.gov/profile/">My Profile</A> </div>
<div style="position:absolute;left:154.65px;top:116.41px" class="cls_005"><span class="cls_005">CDDTL ANNUAL REPORT & INDUSTRY SURVEY</span></div>
<div style="position:absolute;left:203.52px;top:135.20px" class="cls_005"><span class="cls_005">FOR THE CALENDAR YEAR 2019</span></div>
<div style="position:absolute;left:60.80px;top:168.50px" class="cls_006"><span class="cls_006">* Question #11 must be equal to Question #3 of Annual Report which is 281.</span></div>
<div style="position:absolute;left:60.80px;top:182.95px" class="cls_006"><span class="cls_006">* Question #18 must be equal to Question #3 of Annual Report which is 281.</span></div>
<div style="position:absolute;left:60.80px;top:197.41px" class="cls_006"><span class="cls_006">* Question #25 must be equal to Question #1 of Annual Report which is 1180.</span></div>
<div style="position:absolute;left:60.80px;top:211.86px" class="cls_006"><span class="cls_006">* Question #36 must be equal to Question #3 of Annual Report which is 281.</span></div>
<div style="position:absolute;left:257.87px;top:246.29px" class="cls_007"><span class="cls_007">INDUSTRY SURVEY</span></div>
<div style="position:absolute;left:122.76px;top:283.20px" class="cls_008"><span class="cls_008">For licensees engaged in business under the California Deferred Deposit Transaction Law</span></div>
<div style="position:absolute;left:232.94px;top:300.35px" class="cls_009"><span class="cls_009">January 1, 2019 - December 31, 2019</span></div>
<div style="position:absolute;left:36.95px;top:326.50px" class="cls_007"><span class="cls_007">DEFERRED DEPOSIT TRANSACTIONS</span></div>
<div style="position:absolute;left:49.96px;top:355.93px" class="cls_004"><span class="cls_004">A deferred deposit transaction is a written agreement in which the licensee defers depositing the customer’s personal</span></div>
<div style="position:absolute;left:31.89px;top:368.94px" class="cls_004"><span class="cls_004">check for a fee until a specific date (Financial Code section 23001, subdivision (a)). Each customer should be included in only</span></div>
<div style="position:absolute;left:31.89px;top:381.95px" class="cls_004"><span class="cls_004">one of the categories below. For example, if a customer made four deferred deposit transactions, the customer should be</span></div>
<div style="position:absolute;left:31.89px;top:394.95px" class="cls_004"><span class="cls_004">counted as part of Question 4 only, not Questions 1, 2, and 3.</span></div>
<div style="position:absolute;left:320.13px;top:423.92px;border-style: groove;" class="cls_010"><span class="cls_010">Number of Customers</span></div>





   

   


<div style="position:absolute;left:31.89px;top:449.22px" class="cls_009"><span class="cls_009">
<?php  

for($i=1;$i<11;$i++)
{
    
   $j=$i; 
  $sql_sumary = "SELECT * FROM tbl_repeat_loan_transaction where loan_count='$i'";
 

if ($result_sumary=mysqli_query($con,$sql_sumary))
  {
  // Return the number of rows in result set
  $rowcount_sumary=mysqli_num_rows($result_sumary);
 // printf($rowcount);
  // Free result set
  $ye=mysqli_free_result($result_sumary);
  }
 //echo"Loan : ". $rowcount_sumary."<br>";
 //echo"I : ". $i."<br>";


     echo"$i. Customers who obtained $i deferred deposit"."<br><br>" ; 


}
	
    ?></span></div>
<div style='position:absolute;left:310.54px;top:449.94px;' class='cls_011'>
    
    
    <?php  

for($i=1;$i<11;$i++)
{
    
   $j=$i; 
  $sql_sumary = "SELECT * FROM tbl_repeat_loan_transaction where loan_count='$i'";
 

if ($result_sumary=mysqli_query($con,$sql_sumary))
  {
  // Return the number of rows in result set
  $rowcount_sumary=mysqli_num_rows($result_sumary);
 // printf($rowcount);
  // Free result set
  $ye=mysqli_free_result($result_sumary);
  }
 //echo"Loan : ". $rowcount_sumary."<br>";
 //echo"I : ". $i."<br>";


      echo "<input type='text' value='$rowcount_sumary' style='margin-top:2px;'>"."<br>";


}
	
    ?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    </div>


<div style="position:absolute;left:31.89px;top:735.39px" class="cls_009"><span class="cls_009">deposit transactions:</span></div>
<div style="position:absolute;left:26.45px;top:767.00px" class="cls_002"><span class="cls_002"> </span><A HREF="https://docqnet.dbo.ca.gov/annualreporting/cddtl/questions136/">https://docqnet.dbo.ca.gov/AnnualReporting/CDDTL/Questions136</A> </div>
<div style="position:absolute;left:574.41px;top:767.00px" class="cls_002"><span class="cls_002">1/3</span></div>
</div>
<div style="position:absolute;left:50%;margin-left:-306px;top:802px;width:612px;height:792px;border-style:outset;overflow:hidden">


<div style="position:absolute;left:0px;top:0px">
<img src="" width=612 height=792></div>



<div style="position:absolute;left:26.45px;top:14.00px" class="cls_002"><span class="cls_002">3/10/2020</span></div>
<div style="position:absolute;left:298.89px;top:14.00px" class="cls_002"><span class="cls_002">CDDTL Annual Report</span></div>
<div style="position:absolute;left:31.89px;top:30.80px" class="cls_009"><span class="cls_009">11. Total:</span></div>
<div style="position:absolute;left:444.27px;top:30.80px" class="cls_012"><span class="cls_012">281</span></div>
<div style="position:absolute;left:465.64px;top:30.01px" class="cls_013"><span class="cls_013">* Question #11 must be</span></div>
<div style="position:absolute;left:465.64px;top:43.02px" class="cls_013"><span class="cls_013">equal to Question #3 of</span></div>
<div style="position:absolute;left:465.64px;top:56.03px" class="cls_013"><span class="cls_013">Annual Report which is</span></div>
<div style="position:absolute;left:465.64px;top:69.04px" class="cls_013"><span class="cls_013">281.</span></div>
<div style="position:absolute;left:36.95px;top:95.98px" class="cls_007"><span class="cls_007">CUSTOMER'S AGE</span></div>
<div style="position:absolute;left:49.96px;top:135.52px" class="cls_004"><span class="cls_004">Please provide the number of customers in each category below based on the customer's age reported on the deferred</span></div>
<div style="position:absolute;left:31.89px;top:148.53px" class="cls_004"><span class="cls_004">deposit application(s).</span></div>

<div style="position:absolute;left:320.13px;top:176.78px" class="cls_010"><span class="cls_010">Number of Customers</span></div>


<div style="position:absolute;left:31.89px;top:202.07px" class="cls_009"><span class="cls_009">
    <?php
    // User FND Profile 

$sql_db=mysqli_query($con,"SELECT 

CASE WHEN (DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(date_of_birth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(date_of_birth, '00-%m-%d'))) <= 20 THEN 'Customers age 18-21:'
     WHEN (DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(date_of_birth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(date_of_birth, '00-%m-%d'))) <= 30 THEN 'Customers age 22-31:'
     WHEN (DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(date_of_birth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(date_of_birth, '00-%m-%d'))) <= 40 THEN 'Customers age 32-41:'
     WHEN (DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(date_of_birth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(date_of_birth, '00-%m-%d'))) <= 50 THEN 'Customers age 42-51:' 
     WHEN (DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(date_of_birth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(date_of_birth, '00-%m-%d'))) <= 60 THEN 'Customers age 52-61:'
     WHEN (DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(date_of_birth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(date_of_birth, '00-%m-%d'))) <= 70 THEN 'Customers age 62 or older:'END AS age,
COUNT(*) total
FROM fnd_user_profile
GROUP BY age");

while($row_fnddd = mysqli_fetch_array($sql_db)) {

$customer_age=$row_fnddd['age'];

//echo"AGE ".$user_fnd_idd."<br><br>";

echo $customer_age."<br><br>";



}


//User FND Profile END
    
    ?>
    
    </span></div>
<div style="position:absolute;left:310.54px;top:206.79px" class="cls_011"><span class="cls_011">
    
    
    
    
     <?php
    // User FND Profile 

$sql_db=mysqli_query($con,"SELECT  

CASE WHEN (DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(date_of_birth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(date_of_birth, '00-%m-%d'))) <= 20 THEN 'Customers age 18-21:'
     WHEN (DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(date_of_birth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(date_of_birth, '00-%m-%d'))) <= 30 THEN 'Customers age 22-31:'
     WHEN (DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(date_of_birth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(date_of_birth, '00-%m-%d'))) <= 40 THEN 'Customers age 32-41:'
     WHEN (DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(date_of_birth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(date_of_birth, '00-%m-%d'))) <= 50 THEN 'Customers age 42-51:' 
     WHEN (DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(date_of_birth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(date_of_birth, '00-%m-%d'))) <= 60 THEN 'Customers age 52-61:'
     WHEN (DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(date_of_birth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(date_of_birth, '00-%m-%d'))) <= 70 THEN 'Customers age 62 or older:'END AS age,
COUNT(*) total
FROM fnd_user_profile
GROUP BY age");

while($row_fnddd = mysqli_fetch_array($sql_db)) {

$customr_age=$row_fnddd['total'];

//echo"AGE ".$user_fnd_idd."<br><br>";





}
 $age_18=0;
 $age_28=0;
 $age_38=0;
 $age_48=0;
 $age_58=0;
 $age_68=0;
 $tage_18=0;
 $tage_28=0;
 $tage_38=0;
 $tage_48=0;
 $tage_58=0;
 $tage_68=0;
 
 $sql_fnd=mysqli_query($con, "select DISTINCT user_fnd_id as visitorss
from tbl_loan WHERE `contract_date` BETWEEN '2019-01-01' AND '2019-12-31' AND `sign_status` = 1"); 
while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['visitorss'];
//echo "visitorss" .$user_fnd_id."<br>";
 $sql_age=mysqli_query($con, "SELECT * FROM `fnd_user_profile` WHERE `user_fnd_id` = '$user_fnd_id'"); 
while($row_age = mysqli_fetch_array($sql_age)) {
    
    
     $sql_transactions=mysqli_query($con, "SELECT COUNT(`user_fnd_id`) AS NumberOftrans FROM `loan_transaction` WHERE `user_fnd_id` = '$user_fnd_id'"); 
while($row_transactions = mysqli_fetch_array($sql_transactions)) {

$transactions=$row_transactions['NumberOftrans'];
// echo "Transactions are :  " . $transactions;

}
    
    
    
    
    $dob = $row_age['date_of_birth'];
    $dob = date("m/d/Y", strtotime($dob));
    //$date=date_create("2013-03-15");
    $birthDate = explode("/", $dob);
  //get age from date or birthdate
  $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
    ? ((date("Y") - $birthDate[2]) - 1)
    : (date("Y") - $birthDate[2]));
  //echo "Age is:" . $age."<br>";
  
  
  if($age>18 && $age <22){
      $age_18 = $age_18+1;
      $tage_18 = $tage_18+1;
      
  }
  else if($age>21 && $age <32){
      
      $age_28 = $age_28+1;
      $tage_28 = $tage_28+1;
  }
  else if($age>31 && $age <42){
      
      $age_38 = $age_38+1;
      $tage_38 = $tage_38+1;
  }
  else if($age>41 && $age <52){
      
      $age_48 = $age_48+1;
      $tage_48 = $tage_48+1;
  }
  else if($age>51 && $age <62){
      
      $age_58 = $age_58+1;
      $tage_58 = $tage_58+1;
  }
  else if($age>62){
      
      $age_68 = $age_68+1;
      $tage_68 = $tage_68+1;
  }
  
  
  
  
}



}

echo"<input type='text' value='$age_18' style='margin-top:2px;'>"."<br>"; 
echo"<input type='text' value='$age_28' style='margin-top:2px;'>"."<br>"; 
echo"<input type='text' value='$age_38' style='margin-top:2px;'>"."<br>"; 
echo"<input type='text' value='$age_48' style='margin-top:2px;'>"."<br>"; 
echo"<input type='text' value='$age_58' style='margin-top:2px;'>"."<br>"; 
echo"<input type='text' value='$age_68' style='margin-top:2px;'>"."<br>"; 

//User FND Profile END
    
    ?>
    
    
    
    
    
    
    
    
    
    
    
    
</span></div>



<div style="position:absolute;left:31.89px;top:388.16px" class="cls_009"><span class="cls_009">18. Total:</span></div>
<div style="position:absolute;left:465.64px;top:362.37px" class="cls_013"><span class="cls_013">* Question #18 must be</span></div>
<div style="position:absolute;left:444.27px;top:392.16px" class="cls_012"><span class="cls_012">281</span></div>
<div style="position:absolute;left:465.64px;top:373.38px" class="cls_013"><span class="cls_013">equal to Question #3 of</span></div>
<div style="position:absolute;left:465.64px;top:387.39px" class="cls_013"><span class="cls_013">Annual Report which is</span></div>
<div style="position:absolute;left:465.64px;top:400.40px" class="cls_013"><span class="cls_013">281.</span></div>
<div style="position:absolute;left:49.96px;top:423.86px" class="cls_004"><span class="cls_004">Please provide the number of deferred deposit transactions for each age category below.</span></div>
<div style="position:absolute;left:278.17px;top:452.11px" class="cls_010"><span class="cls_010">Number of Deferred Deposit Transactions</span></div>
<div style="position:absolute;left:31.89px;top:477.40px" class="cls_009"><span class="cls_009">19. Customers' age 18-21:</span></div>
<div style="position:absolute;left:436.00px;top:478.12px" class="cls_011"><span class="cls_011"><?php echo $tage_18;?></span></div>
<div style="position:absolute;left:31.89px;top:503.42px" class="cls_009"><span class="cls_009">20. Customers' age 22-31:</span></div>
<div style="position:absolute;left:453.59px;top:504.14px" class="cls_012"><span class="cls_012"><?php echo $tage_28;?></span></div>
<div style="position:absolute;left:31.89px;top:529.43px" class="cls_009"><span class="cls_009">21. Customers' age 32-41:</span></div>
<div style="position:absolute;left:453.59px;top:530.15px" class="cls_012"><span class="cls_012"><?php echo $tage_38;?></span></div>
<div style="position:absolute;left:31.89px;top:555.45px" class="cls_009"><span class="cls_009">22. Customers' age 42-51:</span></div>
<div style="position:absolute;left:453.59px;top:556.17px" class="cls_012"><span class="cls_012"><?php echo $tage_48;?></span></div>
<div style="position:absolute;left:31.89px;top:581.46px" class="cls_009"><span class="cls_009">23. Customers' age 52-61:</span></div>
<div style="position:absolute;left:453.59px;top:582.19px" class="cls_012"><span class="cls_012"><?php echo $tage_58;?></span></div>
<div style="position:absolute;left:31.89px;top:607.48px" class="cls_009"><span class="cls_009">24. Customers' age 62 or older:</span></div>
<div style="position:absolute;left:453.59px;top:608.20px" class="cls_012"><span class="cls_012"><?php echo $tage_68;?></span></div>
<div style="position:absolute;left:31.89px;top:633.49px" class="cls_009"><span class="cls_009">25. Total:</span></div>
<div style="position:absolute;left:465.64px;top:632.71px" class="cls_013"><span class="cls_013">* Question #25 must be</span></div>
<div style="position:absolute;left:436.72px;top:633.49px" class="cls_012"><span class="cls_012">1,180</span></div>
<div style="position:absolute;left:465.64px;top:645.71px" class="cls_013"><span class="cls_013">equal to Question #1 of</span></div>
<div style="position:absolute;left:465.64px;top:658.72px" class="cls_013"><span class="cls_013">Annual Report which is</span></div>
<div style="position:absolute;left:465.64px;top:671.73px" class="cls_013"><span class="cls_013">1180.</span></div>
<div style="position:absolute;left:36.95px;top:698.67px" class="cls_007"><span class="cls_007">CUSTOMER'S INCOME</span></div>
<div style="position:absolute;left:26.45px;top:767.00px" class="cls_002"><span class="cls_002"> </span><A HREF="https://docqnet.dbo.ca.gov/annualreporting/cddtl/questions136/">https://docqnet.dbo.ca.gov/AnnualReporting/CDDTL/Questions136</A> </div>
<div style="position:absolute;left:574.41px;top:767.00px" class="cls_002"><span class="cls_002">2/3</span></div>
</div>
<div style="position:absolute;left:50%;margin-left:-306px;top:1604px;width:612px;height:792px;border-style:outset;overflow:hidden">
<div style="position:absolute;left:0px;top:0px">
<img src="pdf1//background3.jpg" width=612 height=792></div>
<div style="position:absolute;left:26.45px;top:14.00px" class="cls_002"><span class="cls_002">3/10/2020</span></div>
<div style="position:absolute;left:298.89px;top:14.00px" class="cls_002"><span class="cls_002">CDDTL Annual Report</span></div>
<div style="position:absolute;left:49.96px;top:40.13px" class="cls_004"><span class="cls_004">Please provide the number of customers in each category of customer's income listed below, as reported in deferred</span></div>
<div style="position:absolute;left:31.89px;top:53.14px" class="cls_004"><span class="cls_004">deposit transaction applications during this reporting period.</span></div>



<div style="position:absolute;left:31.89px;top:80.66px" class="cls_009"><span class="cls_009">26. $10,000 or less:</span></div>
<div style="position:absolute;left:443.54px;top:81.39px" class="cls_011"><span class="cls_011"><?php echo $net_10;?></span></div>












<div style="position:absolute;left:31.89px;top:106.68px" class="cls_009"><span class="cls_009">27. $10,001 to $20,000:</span></div>
<div style="position:absolute;left:453.59px;top:107.40px" class="cls_012"><span class="cls_012"><?php echo $net_20;?></span></div>
<div style="position:absolute;left:31.89px;top:132.69px" class="cls_009"><span class="cls_009">28. $20,001 to $30,000:</span></div>
<div style="position:absolute;left:453.59px;top:133.42px" class="cls_012"><span class="cls_012"><?php echo $net_30;?></span></div>
<div style="position:absolute;left:31.89px;top:158.71px" class="cls_009"><span class="cls_009">29. $30,001 to $40,000:</span></div>
<div style="position:absolute;left:453.59px;top:159.43px" class="cls_012"><span class="cls_012"><?php echo $net_40;?></span></div>
<div style="position:absolute;left:31.89px;top:184.73px" class="cls_009"><span class="cls_009">30. $40,001 to $50,000:</span></div>
<div style="position:absolute;left:453.59px;top:185.45px" class="cls_012"><span class="cls_012"><?php echo $net_50;?></span></div>
<div style="position:absolute;left:31.89px;top:210.74px" class="cls_009"><span class="cls_009">31. $50,001 to $60,000:</span></div>
<div style="position:absolute;left:453.59px;top:211.46px" class="cls_012"><span class="cls_012"><?php echo $net_60;?></span></div>
<div style="position:absolute;left:31.89px;top:236.76px" class="cls_009"><span class="cls_009">32. $60,001 to $70,000:</span></div>
<div style="position:absolute;left:453.59px;top:237.48px" class="cls_012"><span class="cls_012"><?php echo $net_70;?></span></div>
<div style="position:absolute;left:31.89px;top:262.77px" class="cls_009"><span class="cls_009">33. $70,001 to $80,000:</span></div>
<div style="position:absolute;left:453.59px;top:263.49px" class="cls_012"><span class="cls_012"><?php echo $net_80;?></span></div>
<div style="position:absolute;left:31.89px;top:288.79px" class="cls_009"><span class="cls_009">34. $80,001 to $90,000:</span></div>
<div style="position:absolute;left:453.59px;top:289.51px" class="cls_012"><span class="cls_012"><?php echo $net_90;?></span></div>
<div style="position:absolute;left:31.89px;top:314.80px" class="cls_009"><span class="cls_009">35. Over $90,000:</span></div>
<div style="position:absolute;left:453.59px;top:315.53px" class="cls_012"><span class="cls_012"><?php echo $net_100;?></span></div>
<div style="position:absolute;left:31.89px;top:340.82px" class="cls_009"><span class="cls_009">36. Total:</span></div>
<div style="position:absolute;left:465.64px;top:340.03px" class="cls_013"><span class="cls_013">* Question #36 must be</span></div>
<div style="position:absolute;left:444.27px;top:340.82px" class="cls_012"><span class="cls_012">281</span></div>
<div style="position:absolute;left:465.64px;top:353.04px" class="cls_013"><span class="cls_013">equal to Question #3 of</span></div>
<div style="position:absolute;left:465.64px;top:366.05px" class="cls_013"><span class="cls_013">Annual Report which is</span></div>
<div style="position:absolute;left:465.64px;top:379.05px" class="cls_013"><span class="cls_013">281.</span></div>
<div style="position:absolute;left:167.98px;top:397.19px" class="cls_014"><span class="cls_014">Please review your responses before proceeding to the next page</span></div>
<div style="position:absolute;left:239.02px;top:419.52px" class="cls_015"><span class="cls_015">&lt; Prev</span></div>
<div style="position:absolute;left:285.95px;top:419.52px" class="cls_015"><span class="cls_015">Save & Continue ></span></div>
<div style="position:absolute;left:26.45px;top:767.00px" class="cls_002"><span class="cls_002"> </span><A HREF="https://docqnet.dbo.ca.gov/annualreporting/cddtl/questions136/">https://docqnet.dbo.ca.gov/AnnualReporting/CDDTL/Questions136</A> </div>
<div style="position:absolute;left:574.41px;top:767.00px" class="cls_002"><span class="cls_002">3/3</span></div>
</div>

</body>
</html>
