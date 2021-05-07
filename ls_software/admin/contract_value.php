<?php
 include_once 'dbconnect.php';
 include_once 'dbconfig.php';
$handle = @fopen("asim.txt", "r"); //read line one by one
$values='';

    $access_id="0100011";
    $sql_id="Select * from  tbl_personal_loan_installments where loan_create_id='$access_id'";
  $result_id=mysqli_query($con,$sql_id);
  while ($row_id = mysqli_fetch_array($result_id)){
    $id = $row_id['id'];
    echo "$id;<br><hr>";
}
  
  while (!feof($handle)) 
{
    $buffer = fgets($handle, 4096); 
    list($payment,$principal,$interest,$balance)=explode("|",$buffer);
    $balance=str_replace(' ','',$balance);
   
    
    
//echo "Payment".$role_id."---".$payment."-".$principal."-"."-".$interest."-".$balance."<br>";


//UPDATE `tbl_personal_loan_installments` SET `payment`='170.52',`interest`='170.52',`principal`='0.00',`balance`='2576.00' WHERE `id`='369'
 
  $sql="UPDATE `tbl_personal_loan_installments` SET `payment`='$payment',`interest`='$interest',`principal`='$principal',`balance`='$balance' where `id`='$role_id'";
  //$result=mysqli_query($con,$sql); 
  echo "$sql;<br>";
     
}





?>