<?php
$date=date_create("2013-03-15");
echo date_format($date,"Y/m/d H:i:s");
?><?php
include_once '../dbconnect.php';
include_once '../dbconfig.php';
  //date in mm/dd/yyyy format; or it can be in other formats as well

 $id=$_GET['id'];
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
//echo "Transactions are :  " . $transactions;

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

//echo "Transactions : " . $tage_18. "<br>";
//echo "Transactions : " . $tage_28. "<br>";
//echo "Transactions : " . $tage_38. "<br>";
//echo "Transactions : " . $tage_48. "<br>";
//echo "Transactions : " . $tage_58. "<br>";
//echo "Transactions : " . $tage_68. "<br>";


$sql_fndddddddddd=mysqli_query($con, "SELECT user_fnd_id, COUNT(user_fnd_id) FROM source_income GROUP BY user_fnd_id HAVING COUNT(user_fnd_id)> 1;"); 
while($row_fnddddddddddddddd = mysqli_fetch_array($sql_fndddddddddd)) {

$user_fnnnnnnnnnnnnnnd_id=$row_fnddddddddddddddd['user_fnd_id'];
echo "user_fnnnnnnnnnnnnnnd_id : " . $user_fnnnnnnnnnnnnnnd_id. "<br>";
}


$monthly="";
$semi_monthly="semi";
$weekly="";
$bi_weekly="";

$total_income=$monthly.$semi_monthly.$weekly.$bi_weekly;
echo "total_income : " . $total_income. "<br>";

