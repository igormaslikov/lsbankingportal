<?php
date_default_timezone_set('America/Los_Angeles');

 include($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');
 
 
 $date = date('Y-m-d H:i:s');
 $time_created = date("g:i a");
$txt_file    = file_get_contents('clientlist.2021.02.16.txt');
$rows        = explode("\n", $txt_file);
array_shift($rows);

foreach($rows as $row => $data)
{
    //get row data
      $row_data = explode(',', $data);

        $locationCode= $row_data[0];
        $region =      $row_data[1];
        $district =    $row_data[2];
        $ssn =         $row_data[3];
        $firstName = $row_data[4];
        $middleName =      $row_data[5];
        $lastName =    $row_data[6];
        $address =         $row_data[7];
        $city = $row_data[8];
        $state = $row_data[9];
        $zip = $row_data[10];
        $status = $row_data[11];
        $homePhone = $row_data[12];
        $workPhone = $row_data[13];
        $email = $row_data[14];
        
       
        
        
        $totalFeesCollected = $row_data[15];
        $advanceCount = $row_data[16];
        $totalAdvancePrincipal = $row_data[17];
        $firstAdvanceDate = $row_data[18];
        $lastAdvanceDate = $row_data[19];
        $lastPaymentDate = $row_data[20];
        $amountDue = $row_data[21];
        $nsfAmountDue = $row_data[22];
        $accountnum = $row_data[23];
        $routingnumber = $row_data[24];
        $cellPhone = $row_data[25];
        $driversLicenseNumber = $row_data[26];
        $driversLicenseState = $row_data[27];
        $textingOption = $row_data[28];
        $refinanceCount = $row_data[29];
        $salary = $row_data[30];
        $payFrequency = $row_data[31];
        $dateOfBirth = $row_data[32];
        $customerId = $row_data[33];
        $payDate = $row_data[34];


        $ssn=str_replace('"',"","$ssn");
        $firstName=str_replace('"',"","$firstName");
        $lastName=str_replace('"',"","$lastName");
        $address=str_replace('"',"","$address");
        $city=str_replace('"',"","$city");
        $state=str_replace('"',"","$state");
        $zip=str_replace('"',"","$zip");
        $homePhone=str_replace('"',"","$homePhone");
        $homePhone = str_replace(" ","","$homePhone");
        $homePhone = str_replace("(","","$homePhone");
        $homePhone = str_replace(")","","$homePhone");
        $homePhone = str_replace("-","","$homePhone");
        $homePhone = preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $homePhone);
        $email=str_replace('"',"","$email");
        $dateOfBirth=str_replace('"',"","$dateOfBirth");


    //display data
    // echo 'Row ' . $row . ' locationCode: ' . $locationCode . '<br />';
    // echo 'Row ' . $row . ' region: ' . $region . '<br />';
    // echo 'Row ' . $row . ' district: ' . $district . '<br />';
      echo 'Row ' . $row . ' Phone: ' . $homePhone . '<br />';

 
 $sql_fnd=mysqli_query($con, "select * from tbl_echeck_customer where mobile_number = '$homePhone'"); 
 $rowcount_funded=mysqli_num_rows($sql_fnd);

if($rowcount_funded>0)
{
   echo "Exist" ;
}
else
{

$query  = "INSERT INTO tbl_echeck_customer (first_name,last_name,email,mobile_number,address,city,state,zip_code,date_of_birth,ssn,creation_date,application_status,created_time_,application_date)  VALUES ('$firstName','$lastName','$email','$homePhone','$address','$city','$state','$zip','$dateOfBirth','$ssn','$date','New Application','$time_created','$date')";
        $result = mysqli_query($con, $query);
        if ($result) {
            echo "<div class='form'><h3> successfully added in tbl_echeck_customer.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data Fnd </h3>";
        }


}




    // //display images
    // $row_images = explode(',', $info[$row]['images']);

    // foreach($row_images as $row_image)
    // {
    //     echo ' - ' . $row_image . '<br />';
    // }

    echo '<br />';
}
?>