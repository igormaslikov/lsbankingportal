<?php

 include('dbconfig.php');
 include('dbconnect.php');

$customer_fname=$_GET['customer_fname'];
$customer_lname=$_GET['customer_lname'];
$customer_tel=$_GET['customer_tel'];
$customer_email=$_GET['customer_email'];
$customer_ssn=$_GET['customer_ssn'];
$customer_month=$_GET['customer_month'];
$customer_date=$_GET['customer_date'];
$customer_year=$_GET['customer_year'];
$customer_dob= $customer_month .'/'. $customer_date .'/'. $customer_year;

$dobb=   $customer_year .'-'.$customer_month .'-'. $customer_date;

$customer_street_num=$_GET['customer_street_num'];
$customer_cardinal=$_GET['customer_cardinal'];
$customer_street_name=$_GET['customer_street_name'];
$customer_type=$_GET['customer_type'];
$customer_unit=$_GET['customer_unit'];

$address = $customer_street_num .','. $customer_cardinal .','. $customer_street_name .','. $customer_type .','. $customer_unit;
  
$customer_city=$_GET['customer_city'];
$customer_state=$_GET['customer_state'];
$customer_zip=$_GET['customer_zip'];

$type_loan=$_GET['type_loan'];
$customer_accept=$_GET['customer_accept'];
$app_status = "New Application";
$web_site = "lsprestamos";
echo $web_site;
echo $app_status;
$date = date('Y-m-d H:i:s');


          // DB INSERTION STARTS
          
$query  = "INSERT INTO fnd_user_profile (first_name,last_name,email,mobile_number,address,city,state,zip_code,date_of_birth,ssn,creation_date,application_status,website)  VALUES ('$customer_fname','$customer_lname','$customer_email','$customer_tel','$address','$customer_city','$customer_state','$customer_zip','$dobb','$customer_ssn','$date','$app_status','$web_site')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
      
      
      $query34  = "INSERT INTO tbl_loan (type_of_loan)  VALUES ('$type_loan')";
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

?>