<?php
date_default_timezone_set('America/Los_Angeles');
 
 include($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
 include('../../admin/functions.php');




$customer_fname=$_GET['p_fname'];
$customer_lname=$_GET['p_lname'];
$customer_tel=$_GET['p_phone'];
$customer_email=$_GET['p_email'];

$customer_fname = str_replace("-"," ","$customer_fname");
$customer_lname = str_replace("-"," ","$customer_lname");


$statement1= $_GET['statement1'];
$statement2= $_GET['statement2'];
$statement3= $_GET['statement3'];

echo "statement1".$statement1."<br>";
echo "statement2".$statement2."<br>";
echo "statement3".$statement3."<br>";


			  
              $sql_fnd=mysqli_query($con, "select * from fnd_user_profile where email = '$customer_email' AND mobile_number = '$customer_tel'"); 

            while($row_fnd_id = mysqli_fetch_array($sql_fnd)) {
            $user_fnd_iddd = $row_fnd_id['user_fnd_id'];
            }
            
            
          $rowcount_funded=mysqli_num_rows($sql_fnd);

if($rowcount_funded>0){


    $loan_create_id="";
    $user_id="";
    $status="Document Uploded of User ID:  $user_fnd_iddd.";
    $loan_transaction_id="";
   
        $query_bank_statement  = "INSERT INTO `tbl_bank_statements`(`user_fnd_id`, `statement1`, `statement2`, `statement3`)  VALUES ('$user_fnd_iddd','$statement1','$statement2','$statement3')";
        $result_bank_statement = mysqli_query($con, $query_bank_statement);
        if ($result_bank_statement) {
            echo "<div class='form'><h3> New successfully added.</h3><br/></div>";
        } else {
        //echo "<h3> Error Inserting Data tbl_loan </h3>";
        }  

         mysqli_query($con,"UPDATE `fnd_user_profile` SET `document_status`= '1' WHERE user_fnd_id= '$user_fnd_iddd' ");
         
        application_notes_update($user_fnd_iddd,$loan_create_id,$user_id,$status,$loan_transaction_id);
    
   

}




else {

    
	echo "Record does not exists";



}
?>