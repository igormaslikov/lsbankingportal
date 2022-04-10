<?php
date_default_timezone_set('America/Los_Angeles');
 include('dbconfig.php');
 include('dbconnect.php');

$customer_fname=$_GET['p_fname'];
$customer_lname=$_GET['p_lname'];
$customer_tel=$_GET['p_phone'];
$customer_email=$_GET['p_email'];
$customer_ssn=$_GET['p_ssn'];
$customer_month=$_GET['p_month'];
$customer_date=$_GET['p_date'];
$customer_year=$_GET['p_year'];
$customer_dob= $customer_month .'/'. $customer_date .'/'. $customer_year;

$dobb=   $customer_year .'-'.$customer_month .'-'. $customer_date;

$customer_street_num=$_GET['p_street_numbr'];
$customer_cardinal=$_GET['p_pre_cr'];
$customer_street_name=$_GET['p_street_name'];
$customer_type=$_GET['p_street_type'];
$customer_unit=$_GET['p_unit'];

if(empty($customer_unit))
{
    $customer_unit=" ";
}

$address = $customer_street_num .' '. $customer_cardinal .' '. $customer_street_name .' '. $customer_type .' '. $customer_unit;
  
$customer_city=$_GET['p_city'];
$customer_state=$_GET['p_state'];
$customer_zip=$_GET['p_zip'];


$emp_name=$_GET['p_emp_name'];
$emp_phone=$_GET['emp_mobile'];
$emp_amount=$_GET['p_net_amount'];

$p_dirct_yes=$_GET['p_dirct_yes'];
$p_dirct_no=$_GET['p_dirct_no'];
$direct_deposit= $p_dirct_yes .$p_dirct_no;


$emp_payfre=$_GET['emp_payfre'];

$p_l_month=$_GET['p_l_month'];
$p_l_date=$_GET['p_l_date'];
$p_l_year=$_GET['p_l_year'];
$l_paydate= $p_l_year  .'/'.  $p_l_month .'/'. $p_l_date;

$last_paydate=   $p_l_year .'-'. $p_l_month .'-'. $p_l_date  ;


$p_n_month=$_GET['p_n_month'];
$p_n_date=$_GET['p_n_date'];
$p_n_year=$_GET['p_n_year'];
$next_paydate=  $p_n_year .'/'. $p_n_month .'/'. $p_n_date;

$nxt_paydate=  $p_n_year .'-'. $p_n_month .'-'. $p_n_date; 


$type_loan=$_GET['p_type_loan'];
$customer_accept=$_GET['p_customer_accept'];
$app_status = "New Application";
$web_site = "lsbanking_pdl";
echo $web_site;
echo $app_status;
$date = date('Y-m-d H:i:s');
$time_created = date("g:i a");

// if application is already funded start

$query_check_funded = "select * from fnd_user_profile where  ((email = '$customer_email' ) OR (mobile_number = '$customer_tel') OR (ssn = '$customer_ssn' )) AND (application_status = 'Funded')";
//echo $query_check . "<br>";
$sql_check_funded=mysqli_query($con, "$query_check_funded"); 

  // Return the number of rows in result set
  $rowcount_funded=mysqli_num_rows($sql_check_funded);
//  echo "Row Count is : " . $rowcount. "<br>";
if ($rowcount_funded>0){
    
    
    
    
     $message = "Hola ".$customer_fname.", 
   You are a customer already,if you want another payday loan please contact us directly. You DO NOT have apply again.";
  $curl = curl_init();

curl_setopt_array($curl, array(
 CURLOPT_URL => "https://api.twilio.com/2010-04-01/Accounts/ACf81a1660d5933a77a5db881fbbadadd8/Messages.json",
 CURLOPT_RETURNTRANSFER => true,
 CURLOPT_ENCODING => "",
 CURLOPT_MAXREDIRS => 10,
 CURLOPT_TIMEOUT => 30,
 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
 CURLOPT_CUSTOMREQUEST => "POST",
 CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"To\"\r\n\r\n.$customer_tel.\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"From\"\r\n\r\n(213) 340-0716\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"Body\"\r\n\r\n$message\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
 CURLOPT_HTTPHEADER => array(
    "authorization: Basic QUNmODFhMTY2MGQ1OTMzYTc3YTVkYjg4MWZiYmFkYWRkODo0MzM0M2FkZTVhNjE2ZmJiYWMxYzg0YzkyODNlNDExZA==",
   "cache-control: no-cache",
   "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
 ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
 echo "cURL Error #:" . $err;
} else {
 // echo $response;
}
    
    
    
    // MAIL TO FUNCTION FOR FUNDED APPLICATIONS START
    
    
    
    	$to_email = $customer_email;
$subject = 'Your are Already Customer';
$fname=$customer_fname;
  $lname= $customer_lname;
  $message = "Hola ".$fname." ".$lname.", 

You are a customer already,if you want another payday loan please contact us directly. You DO NOT have apply again.";
 
$headers = 'From: info@lsbanking.com';
mail($to_email,$subject,$message,$headers);
    
 // MAIL TO FUNCTION FOR FUNDED APPLICATIONS END  
 
 
 
 
 // MAIL TO Alejandra FOR FUNDED APPLICATIONS START
    
    
    
$email_alejandra= "alejandra@lsbanking.com";
$subject_alejandra = 'Notification Already Customer';
$fname_alejandra = $customer_fname;
$lname_alejandra = $customer_lname;
  $message_alejandra = "Hola Admin, 

This is $fname_alejandra $lname_alejandra already customer with this email:$customer_email,and application status is FUNDED Applied again.";
 
$headers_alejandra = 'From: info@lsbanking.com';
mail($email_alejandra,$subject_alejandra,$message_alejandra,$headers_alejandra);
    
 // MAIL TO Alejandra FOR FUNDED APPLICATIONS END 
 
 
 
 
 
  // MAIL TO Mayte FOR FUNDED APPLICATIONS START
    
    
    
$email_mayte= "mayte@lsbanking.com";
$subject_mayte = 'Notification Already Customer';
$fname_mayte = $customer_fname;
$lname_mayte = $customer_lname;
  $message_mayte = "Hola Admin, 

This is $fname_mayte $lname_mayte already customer with this email:$customer_email,and application status is FUNDED Applied again.";
 
$headers_mayte = 'From: info@lsbanking.com';
mail($email_mayte,$subject_mayte,$message_mayte,$headers_mayte);
    
 // MAIL TO Mayte FOR FUNDED APPLICATIONS END
 
 
 // MAIL TO Denice FOR FUNDED APPLICATIONS START
    
    
    
$email_denice= "denice@lsbanking.com";
$subject_denice = 'Notification Already Customer';
$fname_denice= $customer_fname;
$lname_denice= $customer_lname;
  $message_denice = "Hola Admin, 

This is $fname_denice $lname_denice already customer with this email:$customer_email,and application status is FUNDED Applied again.";
 
$headers_denice = 'From: info@lsbanking.com';
mail($email_denice,$subject_denice,$message_denice,$headers_denice);
    
 // MAIL TO Denice FOR FUNDED APPLICATIONS END
   
     

    	echo '<meta http-equiv="Refresh" content="1; url=https://www.lsbanking.com/already-customer-payday-loans/">';

}
// if application is already funded end
else {


// To check whether user is declined in 90 day period
$date_decline = date('Y-m-d', strtotime('-90 days'));
echo $date_decline;
$query_check = "select * from fnd_user_profile where  ( (email = '$customer_email' AND email !='') OR (mobile_number = '$customer_tel' AND mobile_number != '') OR (ssn = '$customer_ssn' AND ssn !='') ) AND (application_status = 'Declined' OR application_status = 'Rejected By Customer') AND (creation_date BETWEEN '$date_decline'AND '$date')";
echo $query_check . "<br>";
$sql_check=mysqli_query($con, "$query_check"); 

  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($sql_check);
//  echo "Row Count is : " . $rowcount. "<br>";
if ($rowcount>0){
    
    
	echo "record exists";
	
	  $sql_fnd=mysqli_query($con, "select * from fnd_user_profile where email = '$customer_email'"); 

while($row_fnd_id = mysqli_fetch_array($sql_fnd)) {
$user_fnd_id = $row_fnd_id['user_fnd_id'];

}

$query_fnd_id  = "INSERT INTO fnd_user_profile_submission (user_fnd_id)  VALUES ('$user_fnd_id')";
        $result_fnd = mysqli_query($con, $query_fnd_id);
        if ($result_fnd) {
            echo "<div class='form'><h3> New successfully added.</h3><br/></div>";
        } else {
        //echo "<h3> Error Inserting Data tbl_loan </h3>";
        } 
	echo '<meta http-equiv="Refresh" content="1; url=https://www.lsbanking.com/error-payday-loans/">';
		//declined email
	
	$to_email = $customer_email;
$subject = 'Application Declined';
$fname=$customer_fname;
  $lname= $customer_lname;
  $message = "Hola ".$fname." ".$lname.", 

Gracias por aplicar con Pacifica Finance Group, lamentamos informarle que su aplicación ha sido declinada, usted no ha cumplido con los criterios correpondientes para extenderle un préstamo en estos momentos. Puede volver a aplicar después de 90 días.";
 
$headers = 'From: info@lsbanking.com';
mail($to_email,$subject,$message,$headers);
	
	//declined email end
	
	//Decline SMS
	
	$phone= $customer_tel;
  $fname=$customer_fname;
  $lname= $customer_lname;
  $message = "Hola ".$fname." ".$lname.", 

Gracias por aplicar con Pacifica Finance Group, lamentamos informarle que su aplicación ha sido declinada, usted no ha cumplido con los criterios correpondientes para extenderle un préstamo en estos momentos. Puede volver a aplicar después de 90 días.";
  $curl = curl_init();

curl_setopt_array($curl, array(
 CURLOPT_URL => "https://api.twilio.com/2010-04-01/Accounts/ACf81a1660d5933a77a5db881fbbadadd8/Messages.json",
 CURLOPT_RETURNTRANSFER => true,
 CURLOPT_ENCODING => "",
 CURLOPT_MAXREDIRS => 10,
 CURLOPT_TIMEOUT => 30,
 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
 CURLOPT_CUSTOMREQUEST => "POST",
 CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"To\"\r\n\r\n.$phone.\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"From\"\r\n\r\n(213) 340-0716\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"Body\"\r\n\r\n.$message.\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
 CURLOPT_HTTPHEADER => array(
    "authorization: Basic QUNmODFhMTY2MGQ1OTMzYTc3YTVkYjg4MWZiYmFkYWRkODo0MzM0M2FkZTVhNjE2ZmJiYWMxYzg0YzkyODNlNDExZA==",
   "cache-control: no-cache",
   "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
 ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
 echo "cURL Error #:" . $err;
} else {
 // echo $response;
}
	
	//Decline SMS End
	
}
else {
    
    
    // Duplicate applications check start
    
    $query_check_d = "select * from fnd_user_profile where  (email = '$customer_email' AND application_status ='New Application') ";
echo $query_check_d . "<br>";
$sql_check_d=mysqli_query($con, "$query_check_d"); 

  // Return the number of rows in result set
  $rowcount_d=mysqli_num_rows($sql_check_d);
//  echo "Row Count is : " . $rowcount. "<br>";
if ($rowcount_d>0){
    echo "record duplications";
    
   
    
    
    
	echo '<meta http-equiv="Refresh" content="1; url=https://www.lsbanking.com/error-payday-loans/">';
}

else {
    
    //duplicate applications check end
    
	echo "record does not exists";

          // DB INSERTION STARTS
          
$query  = "INSERT INTO fnd_user_profile (first_name,last_name,email,mobile_number,address,city,state,zip_code,date_of_birth,ssn,creation_date,application_status,website,created_time_)  VALUES ('$customer_fname','$customer_lname','$customer_email','$customer_tel','$address','$customer_city','$customer_state','$customer_zip','$dobb','$customer_ssn','$date','$app_status','$web_site','$time_created')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
        
        $sql_fnd_id=mysqli_query($con, "select * from fnd_user_profile where email = '$customer_email' AND mobile_number='$customer_tel'"); 

while($row_fnd_idd = mysqli_fetch_array($sql_fnd_id)) {
$user_fnd_idd = $row_fnd_idd['user_fnd_id'];

}

$query_fnd_idd  = "INSERT INTO fnd_user_profile_submission (user_fnd_id)  VALUES ('$user_fnd_idd')";
        $result_fndd = mysqli_query($con, $query_fnd_idd);
        if ($result_fndd) {
            echo "<div class='form'><h3> Duplicated successfully added.</h3><br/></div>";
        } else {
        //echo "<h3> Error Inserting Data tbl_loan </h3>";
        } 
        
        
        
        
$sql_source_fndid=mysqli_query($con, "select * from fnd_user_profile where email= '$customer_email' AND ssn= '$customer_ssn' AND mobile_number= '$customer_tel'"); 

while($row_sql_source_fndid = mysqli_fetch_array($sql_source_fndid)) {

$user_fnd_id=$row_sql_source_fndid['user_fnd_id'];
}
		$query_employment_entry = "INSERT INTO source_income(user_fnd_id,employer_name,work_phone_no,net_check_amount,direct_deposit,pay_period,last_pay_date,next_pay_date) VALUES ('$user_fnd_id','$emp_name','$emp_phone','$emp_amount','$direct_deposit','$emp_payfre','$last_paydate','$nxt_paydate')";
		
		
       mysqli_query($con,$query_employment_entry);
	   
      $query34  = "INSERT INTO tbl_loan (user_fnd_id,type_of_loan)  VALUES ('$user_fnd_id','$type_loan')";
        $result34 = mysqli_query($con, $query34);
        if ($result34) {
            //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        } 


          
          
          
          // DB INSERTION ENDS



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://app.echecktrac.com/echecktrac/isf/client/register?loginToken=LSFAO&locationCode=101",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "<REQUEST>   \n<AUTHENTICATION userName=\"website\" password=\"website202\" loginToken=\"LSFAO\" locationCode=\"101\"/>  \n<PROSPECT status=\"New\" adSource=\"foo\" yearsAtAddress=\"1.0\" userName=\"\" password=\"\" emailAddress=\"$customer_email\">    \n<PERSON SSN=\"$customer_ssn\" firstName=\"$customer_fname\" lastName=\"$customer_lname\" sex=\"M\" DOB=\"$customer_dob\" DLState=\"$customer_state\" DLNumber=\"1234\"/>    \n<ADDRESS streetDir=\"$customer_cardinal\" streetType=\"$customer_type\" streetNo=\"$customer_street_num\" streetName=\"$customer_street_name\" unit=\"$customer_unit\" zip=\"$customer_zip\"/>     \n<PHONE type=\"home\" number=\"$customer_tel\"/>    \n</PROSPECT> \n</REQUEST> ",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: text/xml",
    "postman-token: 1ef12a79-02a2-eefd-5812-b7fcf87fd85a"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
}
}}
?>