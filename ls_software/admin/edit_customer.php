<?php
session_start();
include_once 'dbconnect.php';
include_once 'dbconfig.php';
include_once 'functions.php';

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


if (!isset($_SESSION['userSession'])) {
  header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=" . $_SESSION['userSession']);
$userRow = $query->fetch_array();
$u_id = $userRow['user_id'];
$u_name = $userRow['username'];

$u_access_id = $userRow['access_id'];
if ($u_access_id == '0') {
  echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
}


$id = $_GET['id'];

//************************************* UPDATE BOLD STATUS FOR APPLICATION **********************
mysqli_query($con, "UPDATE `fnd_user_profile` SET `bold_status`= '1' WHERE `user_fnd_id` = '$id'");

//************************************* UPDATE BOLD STATUS FOR APPLICATION **********************

$sql = mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$id'");

while ($row = mysqli_fetch_array($sql)) {
  $mobile_verification = $row['mobile_verification_status'];
  $first_name = $row['first_name'];
  //$middle_name =$row['middle_name'];
  $last_name = $row['last_name'];
  $customer_phone = $row['mobile_number'];
  $customer_email = $row['email'];
  $address = $row['address'];
  $cityy = $row['city'];
  $statee = $row['state'];
  $zipp = $row['zip_code'];
  $dob = $row['date_of_birth'];
  $new_dob = date('Y-m-d', strtotime($dob));

  $chat_key = $row['chat_key'];
  $lang = $row['lang'];
  // Create Chat Conversation 
  //echo "<br><br><br><br><br><br>";
  if ($chat_key == '0') {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://conversations.twilio.com/v1/Conversations",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"FriendlyName\"\r\n\r\n$first_name - $customer_phone \r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
      CURLOPT_HTTPHEADER => array(
        "authorization: Basic QUM1ZTE4Yjg1MTk3ZGI2ZTMyZDE5OTViZjNiNDBlMDQ1YjpiOGI0NmI0Njg5MDQ3OWJjZjI1YTlmYjIwNjdlMWMxZQ==",
        "cache-control: no-cache",
        "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
        "postman-token: db9e9458-6930-de4c-b46d-dd06b16dc1c3"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      // echo $response."<hr>";
    }
    $response = json_decode($response, TRUE);
    $twilio_sid = $response['sid'];
    $chat_key = $twilio_sid;
    mysqli_query($con, "UPDATE `fnd_user_profile` SET `chat_key`= '$twilio_sid' WHERE `user_fnd_id` = '$id'");
    $twilio_sender = str_replace("-", "", $customer_phone);
    $twilio_sender = "+1$twilio_sender";

    //echo "MessagingBinding.Address=$twilio_sender&MessagingBinding.ProxyAddress=+18886951203 - $twilio_sender https://conversations.twilio.com/v1/Conversations/$twilio_sid/Participants<br>";



    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://conversations.twilio.com/v1/Conversations/$twilio_sid/Participants",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"MessagingBinding.Address\"\r\n\r\n$twilio_sender\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"MessagingBinding.ProxyAddress\"\r\n\r\n+18886951203\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
      CURLOPT_HTTPHEADER => array(
        "authorization: Basic QUM1ZTE4Yjg1MTk3ZGI2ZTMyZDE5OTViZjNiNDBlMDQ1YjpiOGI0NmI0Njg5MDQ3OWJjZjI1YTlmYjIwNjdlMWMxZQ==",
        "cache-control: no-cache",
        "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
        "postman-token: 56f79e61-628f-ea75-95f8-4554ec0e8197"
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


  // END Chat Conversation 





  $ssn = $row['ssn'];
  $member_military = $row['member_military'];
  $creation_date = $row['creation_date'];
  $app_date_date = $row['application_date'];
  $creationdate = date("m-d-y", strtotime($creation_date));
  $applicationdate = date("m-d-y", strtotime($app_date_date));
  $last_update = $row['last_update_by'];
  $created_by = $row['created_by'];
  $last_update_date = $row['last_update_date'];
  $last_updatedate = date("m-d-Y H:i:s", strtotime($last_update_date));
  $fnd_dl_code = $row['dl_code'];

  $appli_status = $row['application_status'];
  $loan_amount = $row['amount_of_loan'];
  $source_lead = $row['source_of_lead'];
  $declined_reason = $row['declined_reason'];
  $decision_logic_status = $row['decision_logic_status'];
  $id_photo = $row['id_photo'];
  $bank_front = $row['bank_front'];
  $bank_back = $row['bank_back'];
  $personal_loan_term = $row['personal_loan'];
  $void_img = $row['void_img'];
  $apr = $row['apr'];


  $web = $row['website'];
  $credit_score = $row['experian_credit_score'];

  $title_loan_amount_db = $row['title_loan_amount'];
  $loan_request_amount = $row['loan_request_amount'];
  $payback_period = $row['payback_period'];
  $loan_type = $row['loan_type'];

  $co_borrow_full_name = $row['co_borrow_full_name'];
  $co_borrow_phone = $row['co_borrow_phone'];
  $co_borrow_address = $row['co_borrow_address'];
  $co_borrow_state = $row['co_borrow_state'];
  $co_borrow_city = $row['co_borrow_city'];
  $co_borrow_zip = $row['co_borrow_zip'];
}

$sql_loan = mysqli_query($con, "select * from tbl_loan where user_fnd_id= '$id'");

while ($row_loan = mysqli_fetch_array($sql_loan)) {
  $loan_id = $row_loan['loan_id'];
  $amount_of_loan = $row_loan['amount_of_loan'];
}




$sql = mysqli_query($con, "select * from tbl_users where user_id= '$created_by'");

while ($row = mysqli_fetch_array($sql)) {

  $name = $row['username'];
}
//echo $name;


$sql = mysqli_query($con, "select * from tbl_users where user_id= '$last_update'");

while ($row = mysqli_fetch_array($sql)) {

  $name_update = $row['username'];
}
//echo $name;





$sql_source = mysqli_query($con, "select * from source_income where user_fnd_id= '$id' ");

while ($row_source = mysqli_fetch_array($sql_source)) {

  $emp_name = $row_source['employer_name'];
  $emp_phone = $row_source['work_phone_no'];
  $net_check_amount = $row_source['net_check_amount'];
  $direct_deposit = $row_source['direct_deposit'];
  $how_paid = $row_source['pay_period'];

  $last_pay_date = $row_source['last_pay_date'];
  $next_pay_date = $row_source['next_pay_date'];
  $business_type = $row_source['business_type'];
  $business_create_date = $row_source['business_create'];
  $date = "$last_pay_date";

  //******************** Correct the date formte of  last_pay_date && next_pay_date ******************

  if ($last_pay_date != "" && $next_pay_date != "") {
    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date)) {
      $new_last_pay_date = $last_pay_date;
    } else {
      $new_date = date_create_from_format('m-d-Y', $last_pay_date);
      $new_last_pay_date = $new_date->format('Y-m-d');
    }




    $new_next_date = "$next_pay_date";

    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $new_next_date)) {
      $new_next_pay_date = $next_pay_date;
    } else {
      $new_nextdate = date_create_from_format('m-d-Y', $next_pay_date);
      $new_next_pay_date = $new_nextdate->format('Y-m-d');
    }
  } else {

    $new_last_pay_date = $last_pay_date;
    $new_next_pay_date = $next_pay_date;
  }

  //******************** Correct the date formte of  last_pay_date && next_pay_date END ******************
  $address_b = $row_source['address_b'];
  $city_b = $row_source['city_b'];
  $state_b = $row_source['state_b'];
  $zip_b = $row_source['zip_b'];

  $income_month = $row_source['how_tell_ur_income'];
  $mon_income = $row_source['monthly_income'];
}



$sql_business_query = mysqli_query($con, "select * from tbl_business_info where user_fnd_id= '$id'");

while ($row_business_source = mysqli_fetch_array($sql_business_query)) {

  $business_name = $row_business_source['business_name'];
  $business_phone = $row_business_source['business_phone'];
  $business_address = $row_business_source['business_address'];
  $business_state = $row_business_source['business_state'];
  $business_city = $row_business_source['business_city'];
  $business_zip = $row_business_source['business_zip'];
  $gross_amount = $row_business_source['monthly_gross_amount'];
  $business_direct_deposit = $row_business_source['direct_deposit'];
  $how_paid_business = $row_business_source['how_paid'];
  $business_docs = $row_business_source['business_docs'];
}





$sql_vehicle_query = mysqli_query($con, "select * from tbl_vehicle_info where user_fnd_id= '$id'");

while ($row_vehicle_source = mysqli_fetch_array($sql_vehicle_query)) {

  $vehicle_year = $row_vehicle_source['vehicle_year'];
  $vehicle_make = $row_vehicle_source['vehicle_made'];
  $vehicle_model = $row_vehicle_source['vehicle_model'];
  $vehicle_miles = $row_vehicle_source['vehicle_miles'];
  $vehicle_kbb = $row_vehicle_source['vehicle_kbb'];
  $vehicle_ltv = $row_vehicle_source['vehicle_ltv'];
}








$sql_bq = mysqli_query($con, "select * from binary_questions where user_fnd_id= '$id'");

while ($row_bq = mysqli_fetch_array($sql_bq)) {

  $mode_payment = $row_bq['bq_answer'];
}


$sql_emp = "SELECT employer_name FROM source_income where user_fnd_id = '$id' ";

if ($result_emp = mysqli_query($con, $sql_emp)) {
  // Return the number of rows in result set
  $rowcount_emp = mysqli_num_rows($result_emp);
  // printf($rowcount_customer);
  // Free result set
  $ye = mysqli_free_result($result_emp);
  // echo "<br>".$rowcount_emp;
}



$sql_app_notes = mysqli_query($con, "select * from application_notes where user_fnd_id= '$id'");

while ($row_app_notes = mysqli_fetch_array($sql_app_notes)) {

  $app_notes = $row_app_notes['app_notes'];
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
  <style>
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    td,
    th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
    }
  </style>
</head>

<body>

  <?php include('menu.php'); ?>
  <section class="wrapper">

    <div class="container wrapper" style="margin-top:70px">

      <div class="row wrapper1" style="background-color: #F5E09E;color: black;padding:20px; width:100%;max-width: 3330px;">

        <div class="col-lg-4">
          <p> Application ID :<b style="color:red"> <?php echo $id; ?></b></p>
        </div>
        <div class="col-lg-4">
          <p> Customer Name:<b style="color:red"> <?php echo $first_name; ?></b></p>
        </div>
        <div class="col-lg-4">
          <p> Creation Date:<b style="color:red"> <?php echo $creationdate; ?> </b></p>
        </div>
        <div class="col-lg-4">
          <p> Application Date:<b style="color:red"> <?php echo $applicationdate; ?> </b></p>
        </div>
        <div class="col-lg-4">
          <p>Last Update By: <b style="color:red"><?php echo $name_update; ?> </b></p>
        </div>
        <div class="col-lg-4">
          <p> Last Update Date: <b style="color:red"> <?php echo $last_updatedate; ?></b></p>
        </div>

      </div>

      <hr>

      <div class="row">
        <div class="col-lg-12">
          <form action="#" method="POST">
            <div class="form-group">



              <div class="row">

                <div class="col-lg-9">
                  <h3 style="color:red;">Personal Information <?php
                                                              if ($credit_score > 10) {
                                                                echo "<span style='float:right;'> (Score - " . ltrim($credit_score, '0') . ") </span>";
                                                              } ?> </h3>
                </div>


                <div class="col-lg-3"> <br><b style="font-size: 20px;"><?php if ($decision_logic_status == 1) {
                                                                          echo '<span class="glyphicon glyphicon-ok-circle" aria-hidden="true" alt="Verified"></span>  <span style = "color:green; text-align:left">Decision Logic Verified</span>';
                                                                        } ?></b></div>
              </div>
              <div class="row">

                <div class="col-lg-6">
                  <label for="usr">First Name</label>
                  <input name="first_name" type="text" class="form-control" id="usr" value="<?php echo $first_name; ?>">
                </div>

                <div class="col-lg-6">
                  <label for="usr">Last Name</label>
                  <input name="last_name" type="text" class="form-control" id="usr" placeholder="" value="<?php echo $last_name; ?>">
                </div>

                <div class="col-lg-6">
                  <label for="usr">Phone Number -
                    <?php
                    if ($mobile_verification > 0) {
                    ?>

                      <span class="glyphicon glyphicon-ok-circle" aria-hidden="true" alt="Verified"></span>
                    <?php
                    } else {
                      //    echo $mobile_verification;
                    ?>
                      <a href="verify_customer_phone_number.php?number=<?php echo $customer_phone; ?>&id=<?php echo
                                                                                                          $id; ?>">Verify Number Now</a>

                    <?php
                    }
                    ?>


                  </label>
                  <input name="phone_number" type="tel" class="form-control" id="usr" placeholder="Format:123-456-7890" value="<?php echo $customer_phone; ?>" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                </div>

                <div class="col-lg-6">
                  <label for="usr">Email</label>
                  <input name="email" type="text" class="form-control" id="usr" placeholder="" value="<?php echo $customer_email; ?>">
                </div>

                <div class="col-lg-6">
                  <label for="usr">Address</label>
                  <input type="text" name="address" class="form-control" id="usr" value="<?php echo $address; ?>">
                </div>

                <div class="col-lg-3">
                  <label for="usr">City</label>
                  <input type="text" name="city_cus" class="form-control" id="usr" value="<?php echo $cityy; ?>">
                </div>

                <div class="col-lg-1">
                  <label for="usr">State</label>
                  <input type="text" name="state_cus" class="form-control" id="usr" value="<?php echo $statee; ?>">
                </div>

                <div class="col-lg-2">
                  <label for="usr">Zip Code</label>
                  <input type="text" name="zip_cus" class="form-control" id="usr" value="<?php echo $zipp; ?>">
                </div>

                <div class="col-lg-4">

                  <label for="usr">DOB</label>
                  <input type="date" name="dob" class="form-control" id="usr" value="<?php echo $new_dob; ?>">
                </div>

                <div class="col-lg-4">
                  <label for="usr">SSN/ITIN</label>
                  <input type="text" name="ssn" class="form-control" id="usr" value="<?php echo $ssn; ?>">
                </div>


                <div class="col-lg-4">
                  <label for="usr">DL Code</label>
                  <input type="text" name="dl_code" class="form-control" id="usr" value="<?php echo $fnd_dl_code; ?>">
                </div>

                <div class="col-lg-2">
                  <label for="usr"> Member Military</label>
                  <select name="member_military" id="member_military" class="form-control">
                    <option></option>
                    <option value=1 <?php if ($member_military == 1) {
                                          echo 'selected';
                                        } ?>>Yes</option>
                    <option value=0 <?php if ($member_military == 0) {
                                          echo 'selected';
                                        } ?>>No</option>

                  </select>
                </div>
              </div>


              <h3 style="color:red;">Co-Borrow Info</h3>
              <div class="row">

                <div class="col-lg-4">
                  <label for="usr">Full Name</label>
                  <input type="text" name="co_borrow_full_name" class="form-control" id="usr" value="<?php echo $co_borrow_full_name; ?>">
                </div>

                <div class="col-lg-4">
                  <label for="usr">Phone Number</label>
                  <input type="tel" name="co_borrow_phone" class="form-control" id="usr" placeholder="Format:123-456-7890" value="<?php echo $co_borrow_phone; ?>" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                </div>

                
                <div class="col-lg-4">
                  <label for="usr">Address</label>
                  <input type="text" name="co_borrow_address" class="form-control" id="usr" value="<?php echo $co_borrow_address; ?>">
                </div>

                
                <div class="col-lg-4">
                  <label for="usr">State</label>
                  <input type="text" name="co_borrow_state" class="form-control" id="usr" value="<?php echo $co_borrow_state; ?>">
                </div>

                                
                <div class="col-lg-4">
                  <label for="usr">City</label>
                  <input type="text" name="co_borrow_city" class="form-control" id="usr" value="<?php echo $co_borrow_city; ?>">
                </div>
                                                
                <div class="col-lg-4">
                  <label for="usr">Zip</label>
                  <input type="text" name="co_borrow_zip" class="form-control" id="usr" value="<?php echo $co_borrow_zip; ?>">
                </div>


              </div>


              <h3 style="color:red;">Employment Info</h3>
              <div class="row">

                <div class="col-lg-4">
                  <label for="usr">Employer Name</label>
                  <input type="text" name="employer_name" class="form-control" id="usr" value="<?php echo $emp_name; ?>">
                </div>

                <div class="col-lg-4">
                  <label for="usr">Work Phone Number</label>
                  <input type="tel" name="work_phone" class="form-control" id="usr" placeholder="Format:123-456-7890" value="<?php echo $emp_phone; ?>" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                </div>

                <div class="col-lg-4">
                  <label for="usr">Work Address</label>
                  <input type="text" name="address_b" class="form-control" id="usr" placeholder="" value="<?php echo $address_b; ?>">
                </div>

                <div class="col-lg-4">
                  <label for="usr">City</label>
                  <input type="text" name="city_b" class="form-control" id="usr" placeholder="" value="<?php echo $city_b; ?>">
                </div>

                <div class="col-lg-4">
                  <label for="usr">State</label>
                  <input type="text" name="state_b" class="form-control" id="usr" placeholder="" value="<?php echo $state_b; ?>">
                </div>

                <div class="col-lg-4">
                  <label for="usr">Zip Code</label>
                  <input type="text" name="zip_b" class="form-control" id="usr" placeholder="" value="<?php echo $zip_b; ?>">
                </div>

                <div class="col-lg-2">
                  <label for="usr">Monthly Income</label>
                  <input type="text" name="net_amount" class="form-control" id="usr" placeholder="" value="<?php echo $net_check_amount; ?>">
                </div>

                <div class="col-lg-2">
                  <label for="usr"> Direct Deposit</label>
                  <select name="payment" id="payment" class="form-control">
                    <option></option>
                    <option value="Yes" <?php if ($direct_deposit == 'Yes') {
                                          echo 'selected';
                                        } ?>>Yes</option>
                    <option value="No" <?php if ($direct_deposit == 'No') {
                                          echo 'selected';
                                        } ?>>No</option>

                  </select>
                </div>



                <div class="col-lg-4">
                  <label for="usr">Payment Frequency</label>
                  <select name="get_paid" id="get_paid" class="form-control">
                    <option></option>
                    <option value="Weekly" <?php if ($how_paid == 'Weekly') {
                                              echo 'selected';
                                            } ?>>Weekly</option>
                    <option value="Bi-Weekly" <?php if ($how_paid == 'Bi-Weekly') {
                                                echo 'selected';
                                              } ?>>Bi-Weekly</option>
                    <option value="Semi Monthly" <?php if ($how_paid == 'Semi Monthly') {
                                                    echo 'selected';
                                                  } ?>>Semi Monthly</option>
                    <option value="Monthly" <?php if ($how_paid == 'Monthly') {
                                              echo 'selected';
                                            } ?>>Monthly</option>

                  </select>

                </div>

                <div class="col-lg-4">
                  <label for="usr">Last Paycheck Date</label>
                  <input type="date" name="last_check" class="form-control" id="usr" value="<?php echo $new_last_pay_date; ?>">
                </div>

                <div class="col-lg-4">

                  <label for="usr">Next Paycheck Date</label>
                  <input type="date" name="next_check" class="form-control" id="usr" value="<?php echo $new_next_pay_date; ?>">
                </div>


              </div>
              <hr>
              <h3 style="color:red;">Business Info</h3>
              <div class="row">

                <div class="col-lg-4">
                  <label for="usr">Business Name</label>
                  <input type="text" name="business_name" class="form-control" id="usr" value="<?php echo $business_name; ?>">
                </div>

                <div class="col-lg-4">
                  <label for="usr">Business Phone Number</label>
                  <input type="tel" name="business_phone" class="form-control" id="usr" placeholder="Format:123-456-7890" value="<?php echo $business_phone; ?>" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                </div>

                
                <div class="col-lg-4">
                  <label for="usr">Business Address</label>
                  <input type="text" name="business_address" class="form-control" id="usr" value="<?php echo $business_address; ?>">
                </div>

                
                <div class="col-lg-4">
                  <label for="usr">Business State</label>
                  <input type="text" name="business_state" class="form-control" id="usr" value="<?php echo $business_state; ?>">
                </div>

                                
                <div class="col-lg-4">
                  <label for="usr">Business City</label>
                  <input type="text" name="business_city" class="form-control" id="usr" value="<?php echo $business_city; ?>">
                </div>
                                                
                <div class="col-lg-4">
                  <label for="usr">Business Zip</label>
                  <input type="text" name="business_zip" class="form-control" id="usr" value="<?php echo $business_zip; ?>">
                </div>

                <div class="col-lg-4">

                  <label for="usr">Business Type</label>
                  <input type="text" name="business_type" class="form-control" id="usr" value="<?php echo $business_type; ?>">
                </div>


                <div class="col-lg-4">

                  <label for="usr">Business Create</label>
                  <input type="text" name="business_create" class="form-control" id="usr" value="<?php echo $business_create_date; ?>">
                </div>
                <div class="col-lg-4">
                  <label for="usr">Monthly Gross Amount</label>
                  <input type="text" name="gross_amount" class="form-control" id="usr" placeholder="" value="<?php echo $gross_amount; ?>">
                </div>

                <div class="col-lg-4">
                  <label for="usr"> Direct Deposit</label>
                  <select name="business_direct_deposit" id="payment" class="form-control">
                    <option></option>
                    <option value="Yes" <?php if ($business_direct_deposit == 'Yes') {
                                          echo 'selected';
                                        } ?>>Yes</option>
                    <option value="No" <?php if ($business_direct_deposit == 'No') {
                                          echo 'selected';
                                        } ?>>No</option>

                  </select>
                </div>



                <div class="col-lg-4">
                  <label for="usr">Payment Frequency</label>
                  <select name="business_get_paid" id="get_paid" class="form-control">
                    <option></option>
                    <option value="Weekly" <?php if ($how_paid_business == 'Weekly') {
                                              echo 'selected';
                                            } ?>>Weekly</option>
                    <option value="Bi-Weekly" <?php if ($how_paid_business == 'Bi-Weekly') {
                                                echo 'selected';
                                              } ?>>Bi-Weekly</option>
                    <option value="Semi Monthly" <?php if ($how_paid_business == 'Semi Monthly') {
                                                    echo 'selected';
                                                  } ?>>Semi Monthly</option>
                    <option value="Monthly" <?php if ($how_paid_business == 'Monthly') {
                                              echo 'selected';
                                            } ?>>Monthly</option>

                  </select>

                </div>

                <div class="col-lg-4">
                  <label for="usr">Business Documentation</label>
                  <select name="business_docs" id="payment" class="form-control">
                    <option></option>
                    <option value="Business License" <?php if ($business_docs == 'Business License') {
                                                        echo 'selected';
                                                      } ?>>Business License</option>
                    <option value="Sellers Permit" <?php if ($business_docs == 'Sellers Permit') {
                                                      echo 'selected';
                                                    } ?>>Sellers Permit</option>
                    <option value="DBA" <?php if ($business_docs == 'DBA') {
                                          echo 'selected';
                                        } ?>>DBA</option>

                  </select>
                </div>


              </div>
              <hr>


              <!--************************************* Bank Info ****************************************************************************************-->


              <h3 style="color:red;">Bank Info</h3>


              <div class="row">



                <table class="table table-striped table-bordered">
                  <thead>
                    <tr style="background-color: #F5E09E;color: black;">
                      <th style='width:16%;color:black;'>Bank Name</th>
                      <th style='width:18%;color:black;'>Account Number</th>
                      <th style='width:8%;'>Type of Card</th>
                      <th style='width:8%;color:black;'>Exp Date</th>
                      <th style='width:16%;color:black;'>Card Number</th>
                      <th style='width:15%;color:black;'>Routing Number</th>
                      <th style='width:9%;color:black;'>CVV Number</th>
                      <th style='width:8%;color:black;'>Action</th>
                    </tr>
                  </thead>
                  <tbody>


                    <?php
                    include('db.php');
                    $count = 1;
                    if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
                      $page_no = $_GET['page_no'];
                      $count = $count + (25 * ($page_no - 1));
                    } else {
                      $page_no = 1;
                    }

                    $total_records_per_page = 25;
                    $offset = ($page_no - 1) * $total_records_per_page;
                    $previous_page = $page_no - 1;
                    $next_page = $page_no + 1;
                    $adjacents = "2";

                    $result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM loan_initial_banking where user_fnd_id = '$id'");
                    $total_records = mysqli_fetch_array($result_count);
                    $total_records = $total_records['total_records'];
                    $total_no_of_pages = ceil($total_records / $total_records_per_page);
                    $second_last = $total_no_of_pages - 1; // total page minus 1

                    $sql_loan = mysqli_query($con, "select * from loan_initial_banking where user_fnd_id = '$id'");

                    while ($row_bank_detail_sec = mysqli_fetch_array($sql_loan)) {
                      $initial_id = $row_bank_detail_sec['initial_id'];
                      $type_of_id_sec = $row_bank_detail_sec['type_of_id'];
                      $id_photo_sec = $row_bank_detail_sec['pic_of_id'];
                      $type_of_card_sec = $row_bank_detail_sec['type_of_card'];

                      $card_number_sec = $row_bank_detail_sec['card_number'];
                      $card_exp_date_sec = $row_bank_detail_sec['card_exp_date'];
                      $bank_front_sec = $row_bank_detail_sec['bank_front_pic'];

                      $bank_back_sec = $row_bank_detail_sec['bank_back_pic'];
                      $bank_name_sec = $row_bank_detail_sec['bank_name'];
                      $routing_number_sec = $row_bank_detail_sec['routing_number'];

                      $account_number_sec = $row_bank_detail_sec['account_number'];
                      $void_img_sec = $row_bank_detail_sec['void_check_pic'];
                      $cvv_number_sec = $row_bank_detail_sec['cvv_number'];
                      $primary_status = $row_bank_detail_sec['primary_status'];




                      echo "<tr>
	 	       <td>" . $bank_name_sec . "</td>
	 		  <td>" . $account_number_sec . "</td>
			  <td>" . $type_of_card_sec . "</td>
			  <td>" . $card_exp_date_sec . "</td>
	 		  <td>" . $card_number_sec . "</td>
	 		  <td>" . $routing_number_sec . "</td>
			  <td>" . $cvv_number_sec . "</td>
	 		  <td><a href='edit_bank_info.php?id=$initial_id&fnd_id=$id' title='Edit This User'><span class='glyphicon glyphicon-edit' aria-hidden='true' alt='edit'></span></a>

<a class='remove-box' href='delete_bank_info.php?id=$initial_id&fnd_id=$id' title='Delete This User'><span class='glyphicon glyphicon-remove' aria-hidden='true' alt='delete'></span></a> - 

<a href='loan/add_secondary_card.php?bank_id=$initial_id&fnd_id=$id&id=$loan_id' title='Edit This User'>Add Another Card</a> - <a href='loan/view_all_card_info.php?bank_id=$initial_id&fnd_id=$id&id=$loan_id' title='Edit This User'>View All Cards</a>
</td>
		   	  

		   	  </tr>";
                    }

                    ?>

                  </tbody>
                </table>

              </div>

              <hr>

              <!--*********************************************** Bank Info End ***********************************************************************************-->


              <!-- *************************************************************************** Bank Statement  ******************************************************************** -->
              <h3 style="color:red;">Submited Bank Statements</h3>
              <?php



              $bank_statement = mysqli_query($con, "SELECT * FROM tbl_bank_statements where user_fnd_id = '$id' ");
              while ($row_bank_statement = mysqli_fetch_array($bank_statement)) {
                $statement1 = $row_bank_statement['statement1'];
                $statement2 = $row_bank_statement['statement2'];
                $statement3 = $row_bank_statement['statement3'];

                if ($statement1 != "") {
                  echo "Bank Satement - " . '<a target = "_blank" href = "' . $statement1 . '">View Now</a>' . "<br>";
                }
                if ($statement2 != "") {
                  echo "Bank Satement - " . '<a target = "_blank" href = "' . $statement2 . '">View Now</a>' . "<br>";
                }
                if ($statement3 != "") {
                  echo "Bank Satement - " . '<a target = "_blank" href = "' . $statement3 . '">View Now</a>' . "<br>";
                }
              }


              ?>

              <!--************************************************************* Bank Statement END ***********************************************************************************-->
              <hr>

              <h3 style="color:red;">Vehicle Info</h3>
              <div class="row">

                <div class="col-lg-4">
                  <label for="usr">Vehicle Year</label>
                  <input type="text" name="vehicle_year" class="form-control" id="usr" value="<?php echo $vehicle_year; ?>">
                </div>

                <div class="col-lg-4">
                  <label for="usr">Vehicle Make</label>
                  <input type="text" name="vehicle_make" class="form-control" id="usr" placeholder="" value="<?php echo $vehicle_make; ?>">
                </div>

                <div class="col-lg-4">
                  <label for="usr">Vehicle Model</label>
                  <input type="text" name="vehicle_model" class="form-control" id="usr" placeholder="" value="<?php echo $vehicle_model; ?>">
                </div>

                <div class="col-lg-4">
                  <label for="usr">Vehicle Miles</label>
                  <input type="text" name="vehicle_miles" class="form-control" id="usr" placeholder="" value="<?php echo $vehicle_miles; ?>">
                </div>

                <div class="col-lg-4">
                  <label for="usr">Vehicle KBB</label>
                  <input type="text" name="vehicle_kbb" class="form-control" id="usr" placeholder="" value="<?php echo $vehicle_kbb; ?>">
                </div>

                <div class="col-lg-4">
                  <label for="usr">Vehicle LTV</label>
                  <input type="text" name="vehicle_ltv" class="form-control" id="usr" placeholder="" value="<?php echo $vehicle_ltv; ?>">
                </div>


              </div>
              <hr>
              <h3 style="color:red">Application Status</h3>
              <div class="row">

                <div class="col-lg-6">
                  <label for="usr"> Any Application Status</label>
                  <select name="app_status" id="app_status" class="form-control">
                    <option></option>
                    <option value="All Application" <?php if ($appli_status == 'All Application') {
                                                      echo 'selected';
                                                    } ?>>All Application</option>
                    <option value="New Application" <?php if ($appli_status == 'New Application') {
                                                      echo 'selected';
                                                    } ?>>New Application</option>
                    <option value="Declined" <?php if ($appli_status == 'Declined') {
                                                echo 'selected';
                                              } ?>>Declined</option>
                    <option value="Funded" <?php if ($appli_status == 'Funded') {
                                              echo 'selected';
                                            } ?>>Funded</option>
                    <option value="No Answer" <?php if ($appli_status == 'No Answer') {
                                                echo 'selected';
                                              } ?>>No Answer</option>
                    <option value="Rejected By Customer" <?php if ($appli_status == 'Rejected By Customer') {
                                                            echo 'selected';
                                                          } ?>>Rejected By Customer</option>
                    <option value="Approved Payday CA" <?php if ($appli_status == 'Approved Payday CA') {
                                                          echo 'selected';
                                                        } ?>>Approved Payday CA</option>
                    <option value="Review Payday CA" <?php if ($appli_status == 'Review Payday CA') {
                                                        echo 'selected';
                                                      } ?>>Review Payday CA</option>
                    <option value="DL/Bank Payday CA" <?php if ($appli_status == 'DL/Bank Payday CA') {
                                                        echo 'selected';
                                                      } ?>>DL/Bank Payday CA</option>



                    <!--<option value="New Application" <?php if ($appli_status == 'New Application') {
                                                          echo 'selected';
                                                        } ?>>New Application</option>-->
                    <!--<option value="Ready for review"<?php if ($appli_status == 'Ready for review') {
                                                          echo 'selected';
                                                        } ?>>Ready for review</option>-->
                    <!--<option value="Info Needed"<?php if ($appli_status == 'Info Needed') {
                                                      echo 'selected';
                                                    } ?>>Info Needed</option>-->
                    <!--<option value="Approved Payday NV"<?php if ($appli_status == 'Approved Payday NV') {
                                                            echo 'selected';
                                                          } ?>>Approved Payday NV</option>-->
                    <!--<option value="Approved Commercial CA"<?php if ($appli_status == 'Approved Commercial CA') {
                                                                echo 'selected';
                                                              } ?>>Approved Commercial CA</option>-->
                    <!--<option value="DL/Bank Needed"<?php if ($appli_status == 'DL/Bank Needed') {
                                                        echo 'selected';
                                                      } ?>>DL/Bank Needed</option>-->
                    <!--<option value="Review Payday NV"<?php if ($appli_status == 'Review Payday NV') {
                                                          echo 'selected';
                                                        } ?>>Review Payday NV</option>-->
                    <!--<option value="Review Commercial CA"<?php if ($appli_status == 'Review Commercial CA') {
                                                              echo 'selected';
                                                            } ?>>Review Commercial CA</option>-->
                    <!--<option value="Credit Report Completed" <?php if ($appli_status == 'Credit Report Completed') {
                                                                  echo 'selected';
                                                                } ?>>Credit Report Completed</option>-->
                    <!--<option value="Decision Logic Completed" <?php if ($appli_status == 'Decision Logic Completed') {
                                                                    echo 'selected';
                                                                  } ?>>Decision Logic Completed</option>-->
                    <!--<option value="Credit Report Needed" <?php if ($appli_status == 'Credit Report Needed') {
                                                                echo 'selected';
                                                              } ?>>Credit Report Needed</option>-->
                    <!--<option value="Bank Information Needed" <?php if ($appli_status == 'Bank Information Needed') {
                                                                  echo 'selected';
                                                                } ?>>Bank Information Needed</option>-->
                    <!--<option value="Final Review For Personal Loan" <?php if ($appli_status == 'Final Review For Personal Loan') {
                                                                          echo 'selected';
                                                                        } ?>>Final Review For Personal Loan</option>-->
                    <!--<option value="No Decision Logic For Payday" <?php if ($appli_status == 'No Decision Logic For Payday') {
                                                                        echo 'selected';
                                                                      } ?>>No Decision Logic For Payday</option>-->
                    <!--<option value="Review For Payday" <?php if ($appli_status == 'Review For Payday') {
                                                            echo 'selected';
                                                          } ?>>Review For Payday</option>-->
                    <!--<option value="Approved Payday Loan" <?php if ($appli_status == 'Approved Payday Loan') {
                                                                echo 'selected';
                                                              } ?>>Approved Payday Loan</option>-->
                    <!--<option value="Approved Personal Loan" <?php if ($appli_status == 'Approved Personal Loan') {
                                                                  echo 'selected';
                                                                } ?>>Approved Personal Loan</option>-->
                    <!--<option value="Approved Title Loan" <?php if ($appli_status == 'Approved Title Loan') {
                                                              echo 'selected';
                                                            } ?>>Approved Title Loan</option>-->
                    <!--<option value="Interview Completed" <?php if ($appli_status == 'Interview Completed') {
                                                              echo 'selected';
                                                            } ?>>Interview Completed</option>-->
                    <!--<option value="Pending Documents" <?php if ($appli_status == 'Pending Documents') {
                                                            echo 'selected';
                                                          } ?>>Pending Documents</option>-->
                  </select>
                </div>


                <div class="col-lg-6">
                  <label for="usr">Application Type</label>
                  <select name="loan_type" id="loan_type" class="form-control">
                    <option value="payday" <?php if ($loan_type == 'payday') {
                                              echo 'selected';
                                            } ?>>payday</option>
                    <option value="installment" <?php if ($loan_type == 'installment') {
                                                  echo 'selected';
                                                } ?>>installment</option>
                    <option value="commercial" <?php if ($loan_type == 'commercial') {
                                                  echo 'selected';
                                                } ?>>commercial</option>
                  </select>
                </div>



                <div class="col-lg-6">
                  <label for="usr"> Payday Loan Amount</label>
                  <select name="amount_loan" id="amount_loan" class="form-control">
                    <option></option>
                    <option value="Needs Review" <?php if ($loan_amount == 'Needs Review') {
                                                    echo 'selected';
                                                  } ?>>Needs Review</option>
                    <option value="25" <?php if ($loan_amount == '25') {
                                          echo 'selected';
                                        } ?>>25</option>
                    <option value="50" <?php if ($loan_amount == '50') {
                                          echo 'selected';
                                        } ?>>50</option>
                    <option value="75" <?php if ($loan_amount == '75') {
                                          echo 'selected';
                                        } ?>>75</option>
                    <option value="100" <?php if ($loan_amount == '100') {
                                          echo 'selected';
                                        } ?>>100</option>
                    <option value="125" <?php if ($loan_amount == '125') {
                                          echo 'selected';
                                        } ?>>125</option>
                    <option value="150" <?php if ($loan_amount == '150') {
                                          echo 'selected';
                                        } ?>>150</option>
                    <option value="175" <?php if ($loan_amount == '175') {
                                          echo 'selected';
                                        } ?>>175</option>
                    <option value="200" <?php if ($loan_amount == '200') {
                                          echo 'selected';
                                        } ?>>200</option>
                    <option value="225" <?php if ($loan_amount == '225') {
                                          echo 'selected';
                                        } ?>>225</option>
                    <option value="250" <?php if ($loan_amount == '250') {
                                          echo 'selected';
                                        } ?>>250</option>
                    <option value="255" <?php if ($loan_amount == '255') {
                                          echo 'selected';
                                        } ?>>255</option>
                  </select>
                </div>

                <div class="col-lg-6" style="display:none">
                  <label for="usr"> Source of Lead</label>
                  <select name="source_of_lead" id="source_of_lead" class="form-control">
                    <option></option>
                    <option value="Facebook" <?php if ($source_lead == 'Facebook') {
                                                echo 'selected';
                                              } ?>>Facebook</option>
                    <option value="Google" <?php if ($source_lead == 'Google') {
                                              echo 'selected';
                                            } ?>>Google</option>
                    <option value="Instagram" <?php if ($source_lead == 'Instagram') {
                                                echo 'selected';
                                              } ?>>Instagram</option>
                    <option value="Banner" <?php if ($source_lead == 'Banner') {
                                              echo 'selected';
                                            } ?>>Banner</option>
                    <option value="Radio" <?php if ($source_lead == 'Radio') {
                                            echo 'selected';
                                          } ?>>Radio</option>
                    <option value="Referred by Customer" <?php if ($source_lead == 'Referred by Customer') {
                                                            echo 'selected';
                                                          } ?>>Referred by Customer</option>
                    <option value="Repeat Customer" <?php if ($source_lead == 'Repeat Customer') {
                                                      echo 'selected';
                                                    } ?>>Repeat Customer</option>
                  </select>
                </div>

                <div class="col-lg-6">
                  <label for="usr"> Declined Reason</label>
                  <select name="decline_reason" id="decline_reason" class="form-control">
                    <option></option>




                    <option value="No Credit" <?php if ($declined_reason == 'No Credit') {
                                                echo 'selected';
                                              } ?>>No Credit</option>
                    <option value="Low Credit" <?php if ($declined_reason == 'Low Credit') {
                                                  echo 'selected';
                                                } ?>>Low Credit</option>
                    <option value="New Credit" <?php if ($declined_reason == 'New Credit') {
                                                  echo 'selected';
                                                } ?>>New Credit</option>
                    <option value="Bad Credit" <?php if ($declined_reason == 'Bad Credit') {
                                                  echo 'selected';
                                                } ?>>Bad Credit</option>
                    <option value="Too Many Loans" <?php if ($declined_reason == 'Too Many Loans') {
                                                      echo 'selected';
                                                    } ?>>Too Many Loans</option>
                    <option value="Too Many NSF Fees" <?php if ($declined_reason == 'Too Many NSF Fees') {
                                                        echo 'selected';
                                                      } ?>>Too Many NSF Fees</option>
                    <option value="No Bank Account" <?php if ($declined_reason == 'No Bank Account') {
                                                      echo 'selected';
                                                    } ?>>No Bank Account</option>
                    <option value="New Bank Account" <?php if ($declined_reason == 'New Bank Account') {
                                                        echo 'selected';
                                                      } ?>>New Bank Account</option>
                    <option value="Low Income" <?php if ($declined_reason == 'Low Income') {
                                                  echo 'selected';
                                                } ?>>Low Income</option>
                    <option value="Unemployed/Retired/SSI" <?php if ($declined_reason == 'Unemployed/Retired/SSI') {
                                                              echo 'selected';
                                                            } ?>>Unemployed/Retired/SSI</option>
                    <option value="Chargeoff Loans" <?php if ($declined_reason == 'Chargeoff Loans') {
                                                      echo 'selected';
                                                    } ?>>Chargeoff Loans</option>
                    <option value="Bankruptcy" <?php if ($declined_reason == 'Bankruptcy') {
                                                  echo 'selected';
                                                } ?>>Bankruptcy</option>
                    <option value="SMS Blocked" <?php if ($declined_reason == 'SMS Blocked') {
                                                  echo 'selected';
                                                } ?>>SMS Blocked</option>
                    <option value="Repeat Application" <?php if ($declined_reason == 'Repeat Application') {
                                                          echo 'selected';
                                                        } ?>>Repeat Application</option>
                    <option value="Declined by Customer" <?php if ($declined_reason == 'Declined by Customer') {
                                                            echo 'selected';
                                                          } ?>>Declined by Customer</option>
                    <option value="Incomplete Paperwork" <?php if ($declined_reason == 'Incomplete Paperwork') {
                                                            echo 'selected';
                                                          } ?>>Incomplete Paperwork</option>
                    <option value="No Answer" <?php if ($declined_reason == 'No Answer') {
                                                echo 'selected';
                                              } ?>>No Answer</option>
                    <option value="Low Vehicle Value" <?php if ($declined_reason == 'Low Vehicle Value') {
                                                        echo 'selected';
                                                      } ?>>Low Vehicle Value</option>
                    <option value="Account Overdraft" <?php if ($declined_reason == 'Account Overdraft') {
                                                        echo 'selected';
                                                      } ?>>Account Overdraft</option>
                  </select>
                </div>


                <div class="col-lg-6">
                  <label for="usr"> Commercial Loan Amount</label>
                  <select name="personal_loan" id="personal_loan" class="form-control">
                    <option></option>
                    <option value="Needs Review" <?php if ($personal_loan_term == 'Needs Review') {
                                                    echo 'selected';
                                                  } ?>>Needs Review</option>
                    <option value="5005.00" <?php if ($personal_loan_term == '5005.00') {
                                              echo 'selected';
                                            } ?>>5005.00</option>
                    <option value="6005.00" <?php if ($personal_loan_term == '6005.00') {
                                              echo 'selected';
                                            } ?>>6005.00</option>
                    <option value="7005.00" <?php if ($personal_loan_term == '7005.00') {
                                              echo 'selected';
                                            } ?>>7005.00</option>
                    <option value="8005.00" <?php if ($personal_loan_term == '8005.00') {
                                              echo 'selected';
                                            } ?>>8005.00</option>
                  </select>
                </div>

                <?php
                if ($web == 'lspaydayloans' || $web == 'lsbanking_pdl') {
                  echo '
       <div class="col-lg-6">
        <label for="usr">APR</label>
        
 <input type="text" name="apr"  class="form-control" id="usr" value="' . $apr . '">
    
    </div>';
                }
                ?>

                <div class="col-lg-6">
                  <label for="usr">Title Loan Amount</label>
                  <input type="text" name="title_loan_amount" class="form-control" id="usr" placeholder="" value="<?php echo $title_loan_amount_db; ?>">
                </div>

                <div class="col-lg-6">
                  <label for="usr">Requested Loan Amount</label>
                  <input type="text" name="requested_loan_amount" class="form-control" id="usr" placeholder="" value="<?php echo $loan_request_amount; ?>">
                </div>



                <div class="col-lg-6">
                  <label for="usr">Payback Period</label>
                  <select name="payback_period" id="payback_period" class="form-control">
                    <option></option>
                    <option value="1-3 Months" <?php if ($payback_period == '1-3 Months') {
                                                  echo 'selected';
                                                } ?>>1-3 Months</option>
                    <option value="3-6 Months" <?php if ($payback_period == '3-6 Months') {
                                                  echo 'selected';
                                                } ?>>3-6 Months</option>
                    <option value="6-12 Months" <?php if ($payback_period == '6-12 Months') {
                                                  echo 'selected';
                                                } ?>>6-12 Months</option>
                    <option value="1-2 Years" <?php if ($payback_period == '1-2 Years') {
                                                echo 'selected';
                                              } ?>>1-2 Years</option>
                  </select>
                </div>

              </div>


              <?php

              $result_status = mysqli_query($con, "SELECT * FROM application_status_updates where application_id = '$id'  ORDER BY id desc limit 30");

              echo '<br><table style="width:100%;padding:10px" class="table table-striped table-bordered">' . "
<tr>
<th>Date</th>
<th>Change</th>
<th>User</th>
</tr>";

              while ($row_status = mysqli_fetch_array($result_status)) {
                $created_by_get_db_activity = $row_status['user_id'];
                $sql_activity_by_user = mysqli_query($con, "select * from tbl_users where user_id= '$created_by_get_db_activity'");
                $final_activity_by_user = '';
                while ($row_sql_activity_by_user = mysqli_fetch_array($sql_activity_by_user)) {
                  $final_activity_by_user = $row_sql_activity_by_user['username'];
                }



                echo "<tr>";
                echo "<td>" . $row_status['creation_date'] . "</td>";
                echo "<td>Activity Status/SMS : " . $row_status['status'] . "</td>";
                echo "<td>" . $final_activity_by_user . "</td>";
                echo "</tr>";
              }

              echo "</table><a href='view_all_logs.php?fnd_id=$id' <button name='newloan' type='submit' class='btn btn-danger' style='background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;height: 35px; width:10%'>View All Logs</button> </a>
 
<br><br>";


              ?>

              <?php

              $cu_id = $_GET['id'];
              //echo $cu_id;
              ?>
              <span class="wrapper">
                <button name="btn-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#95c500 0,#639a0a 100%);color: #fff;background-color: #2a8206;border-color: #112f01;height: 35;width:7%">Update</button>

                <a href="sms_pre_payday_loan.php?id=<?php echo $cu_id; ?>&f_name=<?php echo $first_name; ?>&phone=<?php echo $customer_phone; ?>&lang=<?php echo $lang; ?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;height: 35px; width:15%">Pre-Approved Payday Loan</button> </a>

                <a href="sms_payday_approved.php?id=<?php echo $cu_id; ?>&f_name=<?php echo $first_name; ?>&phone=<?php echo $customer_phone; ?>&lang=<?php echo $lang; ?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;height: 35px; width:15%">Approved Payday Loan</button> </a>

                <a href="sms_pre_personal.php?id=<?php echo $cu_id; ?>&f_name=<?php echo $first_name; ?>&phone=<?php echo $customer_phone; ?>&lang=<?php echo $lang; ?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;height: 35px; width:15%">Pre-Approved Personal Loan</button> </a>

                <a href="sms_personal_approved.php?id=<?php echo $cu_id; ?>&f_name=<?php echo $first_name; ?>&phone=<?php echo $customer_phone; ?>&lang=<?php echo $lang; ?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;height: 35px; width:19%">Approved Personal Loan</button> </a>



                <a href="all_loans_bridge.php?fnd_id=<?php echo $cu_id; ?>&f_name=<?php echo $first_name; ?>&cu_ssn=<?php echo $ssn; ?>&next_pay_date=<?php echo $next_pay_date; ?>&loan_amount=<?php echo $loan_amount; ?>&state=<?php echo $statee; ?>&loan_type=<?php echo $loan_type; ?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#95c500 0,#639a0a 100%); 
    color: #fff;
    background-color: #2a8206;
    border-color: #112f01;height: 35px; width:14%">Create a Loan</button> </a>
                <a href="sms_decline_application.php?id=<?php echo $cu_id; ?>&f_name=<?php echo $first_name; ?>&l_name=<?php echo $last_name; ?>&phone=<?php echo $customer_phone; ?>&lang=<?php echo $lang; ?>&loan_type=<?php echo $loan_type; ?>" <button name="newloan" type="" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#e60000 0,#ff0000 100%); width:13%;
    color: #fff;
    background-color: #ff1e1e;
    border-color: #ad0404;height: 35px;">Declined SMS</button> </a>
                <br>
                <br>
                <a href="sms_pre_approved_commercial_loan.php?id=<?php echo $cu_id; ?>&f_name=<?php echo $first_name; ?>&phone=<?php echo $customer_phone; ?>&lang=<?php echo $lang; ?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;height: 35px; width:19%">Pre-Approved Commercial Loan</button> </a>

                <a href="sms_approved_commercial_loan.php?id=<?php echo $cu_id; ?>&f_name=<?php echo $first_name; ?>&phone=<?php echo $customer_phone; ?>&lang=<?php echo $lang; ?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;height: 35px; width:19%">Approved Commercial Loan</button> </a>

                <a href="?id=<?php echo $cu_id; ?>&f_name=<?php echo $first_name; ?>&phone=<?php echo $customer_phone; ?>&lang=<?php echo $lang; ?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;height: 35px; width:19%">Pre-Approved Title Loan</button> </a>

                <a href="?id=<?php echo $cu_id; ?>&f_name=<?php echo $first_name; ?>&phone=<?php echo $customer_phone; ?>&lang=<?php echo $lang; ?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;height: 35px; width:19%">Approved Title Loan</button> </a>

                <a href="customer_all_loans.php?id=<?php echo $cu_id; ?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#95c500 0,#639a0a 100%);
    color: #fff;
    background-color: #2a8206;
    border-color: #112f01;height: 35px;width:22%">Customer's LS Loans History</button> </a>




              </span>
              <br>



              <div class="row">
                <div class="col-lg-4">
                  <h4>ID PHOTO :</h4><?php if ($id_photo != "") { ?><a href="../dl_client_files/photo_id/<?php echo $id_photo; ?>" target="_blank"><img style="width:95%" src="../dl_client_files/photo_id/<?php echo $id_photo; ?>" /> <?php } ?></a>
                </div>
                <div class="col-lg-4">
                  <h4>BANK CARD FRONT :</h4><?php if ($bank_front != "") { ?><a href="../dl_client_files/bank_front_image/<?php echo $bank_front; ?>" target="_blank"><img style="width:95%" src="../dl_client_files/bank_front_image/<?php echo $bank_front; ?>" /><?php } ?></a>
                </div>
                <div class="col-lg-4">
                  <h4>BANK CARD BACK :</h4><?php if ($bank_back != "") { ?><a href="../dl_client_files/bank_back_image/<?php echo $bank_back; ?>" target="_blank"><img style="width:95%" src="../dl_client_files/bank_back_image/<?php echo $bank_back; ?>" /><?php } ?></a>
                </div>

                <div class="col-lg-4">
                  <h4>Void Check/Account Number Screenshot :</h4><?php if ($void_img != "") { ?><a href="../dl_client_files/void_img/<?php echo $void_img; ?>" target="_blank"><img style="width:95%" src="../dl_client_files/void_img/<?php echo $void_img; ?>" /><?php } ?></a>
                </div>
              </div>





          </form>
          <form action="" method="POST">

            <div class="row">
              <div class="col-lg-12">
                <label for="usr">Notes</label>
                <textarea type="text" name="app_notes" class="form-control" id="usr" style="margin: 0px -17px 0px 0px; height: 126px; width: 100%;"><?php echo $app_notes; ?></textarea>
              </div>
            </div>

            <button name="btn-notes-submit" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#95c500 0,#639a0a 100%);
    color: #fff;
    background-color: #2a8206;
    border-color: #112f01;">Add Notes</button>

          </form>

          <hr><br>
          <?php
          // decision login api start

          $finalDL_code = $fnd_dl_code;
          $decision_login_code = mysqli_query($con, "SELECT * FROM decision_login_codes where email ='$customer_email' ");
          while ($row_decision_login_code = mysqli_fetch_array($decision_login_code)) {
            $finalDL_code = $fnd_dl_code;
          }
          echo "<hr>";
          echo "<b>Decision Logic Details (" . $finalDL_code . ")</b><br>";


          $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => "https://integration.decisionlogic.com/integration-v2.asmx",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">\r\n  <soap:Body>\r\n    <GetMultipleReportDetailsFromRequestCode7 xmlns=\"https://integration.decisionlogic.com\">\r\n      <serviceKey>DN2YYREQ9DPQ</serviceKey>\r\n      <requestCode>$finalDL_code</requestCode>\r\n    </GetMultipleReportDetailsFromRequestCode7>\r\n  </soap:Body>\r\n</soap:Envelope>",
            CURLOPT_HTTPHEADER => array(
              "cache-control: no-cache",
              "content-type: text/xml; charset=utf-8",
              "host: integration.decisionlogic.com",
              "postman-token: 656d6424-254f-0521-fabb-3e0fe463fc5d",
              "soapaction: https://integration.decisionlogic.com/GetMultipleReportDetailsFromRequestCode7"
            ),
          ));

          $response = curl_exec($curl);
          $err = curl_error($curl);

          curl_close($curl);

          if ($err) {
            echo "cURL Error #:" . $err;
          } else {
            //echo $response;
          }



          $dom = new DOMDocument();
          $dom->loadXML($response);
          $hotels = $dom->getElementsByTagName('ReportDetail5');

          foreach ($hotels as $hotel) {
            $DL_available_overdraft = $hotel->getElementsByTagName('TotalCount')->item(4)->nodeValue;
            $DL_available_balance = $hotel->getElementsByTagName('AvailableBalance')->item(0)->nodeValue;
            $DL_totalamount = $hotel->getElementsByTagName('TotalAmount')->item(0)->nodeValue;
            $DL_totalamount_loan = $hotel->getElementsByTagName('TotalAmount')->item(3)->nodeValue;
            $DL_as_date = $hotel->getElementsByTagName('AsOfDate')->item(0)->nodeValue;
            $DL_current_balance = $hotel->getElementsByTagName('CurrentBalance')->item(0)->nodeValue;
            $DL_average_balance = $hotel->getElementsByTagName('AverageBalance')->item(0)->nodeValue;

            $DL_deposits_credit = $hotel->getElementsByTagName('TotalCredits')->item(0)->nodeValue;
            $DL_avg_balance_last_month = $hotel->getElementsByTagName('AverageBalanceRecent')->item(0)->nodeValue;

            $DL_withdrawals = $hotel->getElementsByTagName('TotalDebits')->item(0)->nodeValue;
            break;
          }
          ?>


          <div class="row">


            <div class="col-lg-6">
              <span style="color:red">Available Balance :</span><b> $<?php echo  number_format((float)$DL_available_balance, 2, '.', ''); ?></b>
            </div>


            <div class="col-lg-6">
              <span style="color:red">As of Date</span> : <b> <?php echo $DL_as_date; ?></b>
            </div>

            <div class="col-lg-6">
              <span style="color:red">Current Balance</span> : <b> $<?php echo  number_format((float)$DL_current_balance, 2, '.', ''); ?></b>
            </div>

            <div class="col-lg-6">
              <span style="color:red">Average Balance</span> : <b> $<?php echo  number_format((float)$DL_average_balance, 2, '.', ''); ?></b>
            </div>
            <div class="col-lg-6">
              <span style="color:red"> Total Amount PAYROLL</span> :<b> $<?php echo  number_format((float)$DL_totalamount, 2, '.', ''); ?></b>
            </div>
            <div class="col-lg-6">
              <span style="color:red"> Over Draft (ov)</span> : <b><?php echo  $DL_available_overdraft; ?></b>
            </div>


            <div class="col-lg-6">
              <span style="color:red">Deposits/Credits</span> : <b> $<?php echo  number_format((float)$DL_deposits_credit, 2, '.', ''); ?></b>
            </div>

            <div class="col-lg-6">
              <span style="color:red">Avg Bal Latest Month</span> : <b> $<?php echo  number_format((float)$DL_avg_balance_last_month, 2, '.', ''); ?></b>
            </div>

            <div class="col-lg-6">
              <span style="color:red">Withdrawals/Debits</span> : <b> $<?php echo  number_format((float)$DL_withdrawals, 2, '.', ''); ?></b>
            </div>


          </div>

          <?php
          // decision login api start
          ?>
          <br>
          <hr>
          <br>




          <?php
          if ($loan_type == 'commercial') {
            $credit_report = mysqli_query($con, "SELECT * FROM  tbl_credit_report where user_fnd_id = '$id'  AND score>0 ");

            echo '<br><table style="width:100%;padding:10px" class="table table-striped table-bordered">' . "
<tr>
<th>Details Of Credit Report - </th><th>";
            if ($loan_type == 'commercial') {
              echo ' - <a style="color:red; text-align:right" href="credit_report.php?id=' . $id . '" target="_blank"><b  alt="Regenrate Credit Report">Run New Experian Credit Report
</b></a>';
            }
            echo '</th>
</tr>';


            while ($row_credit_report = mysqli_fetch_array($credit_report)) {
              $credit_report_id = $row_credit_report['id'];
              $credit_report_key = $row_credit_report['credit_report_key'];
              $user_fnd_id_cr = $row_credit_report['user_fnd_id'];
              $creation_date_cr = $row_credit_report['creation_date'];
              $score = $row_credit_report['score'];
              // PDF POPUP Code

              // PDF POPUP END CODE
              echo "<tr>";
              echo '<td><a href="credit_report_exsiting.php?id=' . $user_fnd_id_cr . '&key=' . $credit_report_key . '">' . $creation_date_cr . '   ' . "[Score - " . ltrim($score, '0') . "]</a></td>";
              echo "</tr>";
            }
            echo "</table><br>";
          }
          ?>

          <?php
          //************************************** PayRoll  Decision Logic API Start *****************************************
          echo "<hr>";
          echo "<h3 style='text-align:center'>Decision Logic Payroll Details (" . $finalDL_code . ")</h3><br>";
          echo "<span style='font-weight: bold;'>Type Of Transaction</span>";
          echo "	  <span style='font-weight: bold; margin-left:3.5%'>Payroll Description:Standard Employment Income</span>";

          $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => "https://integration.decisionlogic.com/integration-v2.asmx",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">\r\n  <soap:Body>\r\n    <GetMultipleReportDetailsFromRequestCode7 xmlns=\"https://integration.decisionlogic.com\">\r\n      <serviceKey>DN2YYREQ9DPQ</serviceKey>\r\n      <requestCode>$finalDL_code</requestCode>\r\n    </GetMultipleReportDetailsFromRequestCode7>\r\n  </soap:Body>\r\n</soap:Envelope>",
            CURLOPT_HTTPHEADER => array(
              "cache-control: no-cache",
              "content-type: text/xml; charset=utf-8",
              "host: integration.decisionlogic.com",
              "postman-token: 656d6424-254f-0521-fabb-3e0fe463fc5d",
              "soapaction: https://integration.decisionlogic.com/GetMultipleReportDetailsFromRequestCode7"
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



          $dom = new DOMDocument();
          $dom->loadXML($response);
          $hotels = $dom->getElementsByTagName('TransactionSummary5');

          echo "<table>
  <tr>
    <th>Date</th>
    <th>Description</th>
    <th>Amount</th>
  </tr>";

          foreach ($hotels as $hotel) {

            $TypeCode = $hotel->getElementsByTagName('TypeCodes')->item(0)->nodeValue;
            $Amount = $hotel->getElementsByTagName('Amount')->item(0)->nodeValue;
            $Description = $hotel->getElementsByTagName('Description')->item(0)->nodeValue;
            $TransactionDate = $hotel->getElementsByTagName('TransactionDate')->item(0)->nodeValue;

            $payroll_date = date('m/d/Y', strtotime($TransactionDate));

            //echo" ".$TypeCode.' '.$Amount."<br>";


            if ($TypeCode == "py,dp") {

              echo "
 <tr>
    <td>$payroll_date</td>
    <td>$Description</td>
    <td>$$Amount</td>
  </tr>
 ";
            }
          }

          echo "</table>";

          //************************************** PayRoll  Decision Logic API End ***************************************** 

          ?>
          <hr>
          <?php

          $lender_documents = mysqli_query($con, "SELECT * FROM lender_documents where fnd_user_id = '$id' ");

          echo '<br><table style="width:100%;padding:10px" class="table table-striped table-bordered">' . "
<tr>
<th>Date</th>
<th>File Name</th>
<th>Created By</th>
</tr>";

          while ($row_lender_documents = mysqli_fetch_array($lender_documents)) {
            $doc_id = $row_lender_documents['id'];
            $created_by_get_db = $row_lender_documents['created_by'];
            $sql_lender_by_user = mysqli_query($con, "select * from tbl_users where user_id= '$created_by_get_db'");
            $final_lender_by_user = '';
            while ($row_sql_lender_by_user = mysqli_fetch_array($sql_lender_by_user)) {
              $final_lender_by_user = $row_sql_lender_by_user['username'];
            }
            // PDF POPUP Code

            // PDF POPUP END CODE
            echo "<tr>";
            echo "<td>" . $row_lender_documents['date_created'] . "</td>";
            echo "<td>" . $row_lender_documents['file_name'] . ' - <a  onclick="myFunction_lenderdocuments()" target = "frame_lender" href = "uploads_lender_documents/' . $row_lender_documents['file_name'] . '">View Now</a>' . " - <a class='remove-box' href='delete_lender_documents.php?id=$id&doc_id=$doc_id' title='Delete This Document'><span class='glyphicon glyphicon-remove' aria-hidden='true' alt='delete'></span></a>" .

              "</td>";
            echo "<td>" . $final_lender_by_user . "</td>";
            echo "</tr>";
          }
          echo "</table><br>";


          ?>

          <div id="frame_lender" style="display:none; color:red">

            <b onclick="myFunction_lenderdocuments()">Close (X)</b>
            <iframe name="frame_lender" style=" width:100%; height: 700px">
            </iframe>
          </div>
          <script>
            function myFunction_lenderdocuments() {
              var x = document.getElementById("frame_lender");
              if (x.style.display === "none") {
                x.style.display = "block";
              } else {
                x.style.display = "none";
              }
            }
          </script>
          <div class="row">
            <div class="col-lg-12">
              <label for="usr">Lender Documents </label>
            </div>
          </div>

          <form action="" method="post" enctype="multipart/form-data">

            <input type="file" name="lender_documents" class="btn btn-danger" id="lender_documents">
            <input type="submit" value="Upload File" class="btn btn-danger" name="submit_lender_documents">
          </form>


        </div>
      </div>

    </div>
    </div>
  </section>
  <hr>
  <script type="text/javascript">
    $('.remove-box').on('click', function() {
      var x = confirm('Are you sure you want to delete?');
      if (x)
        return true;
      else
        return false;

    });
  </script>
</body>

</html>

<?php
if (isset($_POST['submit_lender_documents'])) {
  include 'dbconnect.php';
  include 'dbconfig.php';
  $date = date('Y-m-d H:i:s');
  $target_dir = "uploads_lender_documents/";
  $target_file = $target_dir . $id . "-" . basename($_FILES["lender_documents"]["name"]);
  $target_file_db = $id . "-" . basename($_FILES["lender_documents"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["lender_documents"]["tmp_name"], $target_file)) {

      echo "The file " . basename($_FILES["lender_documents"]["name"]) . " has been uploaded.";
      $insert_query_lender_docs = "INSERT Into lender_documents(fnd_user_id, file_name, date_created, created_by) VALUES ('$id','$target_file_db','$date','$u_id')";
      mysqli_query($con, $insert_query_lender_docs);

      echo '<meta http-equiv="refresh" content="0">';
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}


if (isset($_POST['btn-notes-submit'])) {



  $date = date('Y-m-d H:i:s');
  $app_notes_update = "Notes Updated : " . $_POST['app_notes'];
  $query_update_status = "INSERT INTO `application_status_updates`( `application_id`, `user_id`, `status`, `creation_date`) VALUES ('$id','$u_id','$app_notes_update','$date')";
  echo   $query_update_status;
  $result_status_update = mysqli_query($con, $query_update_status);
  if ($result_status_update) {
    // echo "<div class='form'><h3> successfully added in application_status_updates.</h3><br/></div>";

  } else {
    echo "<h3> Error Inserting Data </h3>";
  }
  echo '<meta http-equiv="refresh" content="0">';
}
if (isset($_POST['btn-submit'])) {


  $first_name_update = $_POST['first_name'];
  $last_name__update = $_POST['last_name'];
  $phone_number_update = $_POST['phone_number'];
  $email_update = $_POST['email'];
  $monthly_income_update = $_POST['monthly_income'];
  $payment_update = $_POST['payment'];
  $address_update = $_POST['address'];
  $city_update = $_POST['city_cus'];
  $state_update = $_POST['state_cus'];
  $zip_update = $_POST['zip_cus'];
  $dob_update = $_POST['dob'];
  $ssn_update = $_POST['ssn'];
  $member_military_update = $_POST['member_military'];
  $dl_code_update = $_POST['dl_code'];

  $co_borrow_full_name_update = $_POST['co_borrow_full_name'];
  $co_borrow_phone_update = $_POST['co_borrow_phone'];
  $co_borrow_address_update = $_POST['co_borrow_address'];
  $co_borrow_state_update = $_POST['co_borrow_state'];
  $co_borrow_city_update = $_POST['co_borrow_city'];
  $co_borrow_zip_update = $_POST['co_borrow_zip'];


  $employer_name_update = $_POST['employer_name'];
  $work_phone_update = $_POST['work_phone'];
  $direct_deposit_update = $_POST['payment'];
  $net_amount_update = $_POST['net_amount'];
  $pay_fre_update = $_POST['get_paid'];
  $last_date_update = $_POST['last_check'];
  $next_date_update = $_POST['next_check'];
  $business_type_up = $_POST['business_type'];
  $business_create_up = $_POST['business_create'];
  $business_name_update = $_POST['business_name'];
  $business_phone_update = $_POST['business_phone'];
  $business_address_update = $_POST['business_address'];
  $business_state_update = $_POST['business_state'];
  $business_city_update = $_POST['business_city'];
  $business_zip_update = $_POST['business_zip'];
  $gross_amount_update = $_POST['gross_amount'];
  $business_direct_deposit_update = $_POST['business_direct_deposit'];
  $business_get_paid_update = $_POST['business_get_paid'];
  $business_docs_update = $_POST['business_docs'];
  $address_b = $_POST['address_b'];
  $city_b = $_POST['city_b'];
  $state_b = $_POST['state_b'];
  $zip_b = $_POST['zip_b'];


  $vehicle_year_update = $_POST['vehicle_year'];
  $vehicle_make_update = $_POST['vehicle_make'];
  $vehicle_model_update = $_POST['vehicle_model'];
  $vehicle_miles_update = $_POST['vehicle_miles'];
  $vehicle_kbb_update = $_POST['vehicle_kbb'];
  $vehicle_ltv_update = $_POST['vehicle_ltv'];






  $app_status_update = $_POST['app_status'];
  $loan_type_update = $_POST['loan_type'];
  $source_lead_update = $_POST['source_of_lead'];
  $amount_loan_update = $_POST['amount_loan'];
  $decline_reason_update = $_POST['decline_reason'];
  $app_notes_update = "Notes Updated : " . $_POST['app_notes'];
  $date = date('Y-m-d H:i:s');
  $personal_loan = $_POST['personal_loan'];

  $update_apr = $_POST['apr'];
  $title_loan_amount = $_POST['title_loan_amount'];
  $payback_period_update = $_POST['payback_period'];
  $requested_loan_amount_update = $_POST['requested_loan_amount'];

  $form_name = basename(__FILE__);

  $sql_role = mysqli_query($con, "select * from access_form where form_name ='$form_name'");


  while ($row_role = mysqli_fetch_array($sql_role)) {

    $form_id = $row_role['id'];
    //echo $form_id;
  }
  $update_allowed_validate = user_edit_roles($u_access_id, $form_id);

  if ($update_allowed_validate == 1) {

    //************************************ ADMIN SMS Starts ****************//

    // Declined SMS Sent  start

    if ($app_status_update == 'Declined') {
      $message = "Hola " . $first_name_update . " " . $last_name__update . ",Gracias por aplicar con Optima Financial Solutions Inc, lamentamos informarle que su aplicación ha sido declinada, usted no ha cumplido con los criterios correpondientes para extenderle un préstamo en estos momentos. Puede volver a aplicar después de 90 días.";
      send_sms($phone_number_update, $message);
    }


    // Declined SMS Sent END


    // Approved Personal Loan SMS Start

    if ($app_status_update == 'Approved Personal Loan') {
      // $phone12 = "+12138840085";
      $phone121 = "+12138840085";
      $message = "Approved PL " . $first_name_update . " " . $last_name__update . " " . $phone_number_update . " term " . $personal_loan . "";
      send_sms($phone121, $message);




      /************************************  Email To Denice *************************

$to_denice = "denice@lsbanking.com";

$subject_denice = "Approved Personal Loan";
$message_denice = "Approved Personal Loan ".$first_name_update." ".$last_name__update.", has been approved ".$phone_number_update." and loan term is ".$personal_loan.". ";
$headers_denice = "From: info@ofsca.com";

mail($to_denice,$subject_denice,$message_denice,$headers_denice);


       ************************************  Email To Mayte *************************/

      $to_mayte = "mayte@lsbanking.com";

      $subject_mayte = "Approved Personal Loan";
      $message_mayte = "Approved Personal Loan " . $first_name_update . " " . $last_name__update . ", has been approved " . $phone_number_update . " and loan term is " . $personal_loan . ". ";
      $headers_mayte = "From: info@ofsca.com";

      //mail($to_mayte,$subject_mayte,$message_mayte,$headers_mayte);

      admin_leads_email_notification($subject_mayte, $message_mayte);
    }

    // Approved Personal Loan SMS End





    // Review For Payday SMS Start

    if ($app_status_update == 'Review For Payday') {
      $phone_re_for_payday = "+18187316919";
      $message_re_for_payday = "Review For Payday " . $first_name_update . " " . $last_name__update;
      send_sms($phone_re_for_payday, $message);
    }

    // Review For Payday SMS End















    // Credit Report Completed SMS Start

    if ($app_status_update == 'Credit Report Completed') {
      $phone12 = "+18187316919";
      $message = " Credit Report Completed " . $first_name_update . " " . $last_name__update;
      send_sms($phone12, $message);
    }

    // Credit Report Completed SMS End








    // Decision Logic Completed SMS Start

    if ($app_status_update == 'Decision Logic Completed') {
      $phone_dl_completed = "+18187316919";
      $message_dl_completed = " Decision Logic Completed " . $first_name_update . " " . $last_name__update;
      send_sms($phone_dl_completed, $message);
    }

    // Decision Logic Completed SMS End







    // Final Review For Personal Loan SMS Start

    if ($app_status_update == 'Final Review For Personal Loan') {
      $phone_f_re_pl = "+18187316919";
      $message_f_re_pl = " Final Review Personal Loan " . $first_name_update . " " . $last_name__update;
      send_sms($phone_f_re_pl, $message);
    }

    // Final Review For Personal Loan SMS End




    // Bank Information Needed Start

    if ($app_status_update == 'Bank Information Needed') {


      /************************************  Email To Denice ************************* 

$to_denice = "denice@lsbanking.com";

$subject_denice = "Bank Information Needed";
$message_denice = "Bank Information Needed ".$first_name_update." ".$last_name__update.", has been approved ".$phone_number_update." and loan term is ".$personal_loan.". ";
$headers_denice = "From: info@ofsca.com";

mail($to_denice,$subject_denice,$message_denice,$headers_denice);


       ************************************  Email To Mayte *************************/

      $to_mayte = "mayte@lsbanking.com";

      $subject_mayte = "Bank Information Needed";
      $message_mayte = "Bank Information Needed " . $first_name_update . " " . $last_name__update . ", has been approved " . $phone_number_update . " and loan term is " . $personal_loan . ". ";
      $headers_mayte = "From: info@ofsca.com";

      //mail($to_mayte,$subject_mayte,$message_mayte,$headers_mayte);
      admin_leads_email_notification($subject_mayte, $message_mayte);
    }

    // Bank Information Needed End


    // Interview Completed Needed Start

    if ($app_status_update == 'Interview Completed') {


      /************************************  Email To Denice ************************* 

$to_denice = "denice@lsbanking.com";

$subject_denice = "Interview Completed";
$message_denice = "Interview Completed ".$first_name_update." ".$last_name__update.", has been approved ".$phone_number_update." and loan term is ".$personal_loan.". ";
$headers_denice = "From: info@ofsca.com";

mail($to_denice,$subject_denice,$message_denice,$headers_denice);


       ************************************  Email To Mayte *************************/

      $to_mayte = "mayte@lsbanking.com";

      $subject_mayte = "Interview Completed";
      $message_mayte = "Interview Completed " . $first_name_update . " " . $last_name__update . ", has been approved " . $phone_number_update . " and loan term is " . $personal_loan . ". ";
      $headers_mayte = "From: info@ofsca.com";

      //mail($to_mayte,$subject_mayte,$message_mayte,$headers_mayte);

      admin_leads_email_notification($subject_mayte, $message_mayte);
    }

    // Interview Completed End



    // Pending Documents Start

    if ($app_status_update == 'Pending Documents') {


      /************************************  Email To Denice ************************* 

$to_denice = "denice@lsbanking.com";

$subject_denice = "Pending Documents";
$message_denice = "Pending Documents ".$first_name_update." ".$last_name__update.", has been approved ".$phone_number_update." and loan term is ".$personal_loan.". ";
$headers_denice = "From: info@ofsca.com";

mail($to_denice,$subject_denice,$message_denice,$headers_denice);


       ************************************  Email To Mayte *************************/

      $to_mayte = "mayte@lsbanking.com";

      $subject_mayte = "Pending Documents";
      $message_mayte = "Pending Documents " . $first_name_update . " " . $last_name__update . ", has been approved " . $phone_number_update . " and loan term is " . $personal_loan . ". ";
      $headers_mayte = "From: info@ofsca.com";

      //mail($to_mayte,$subject_mayte,$message_mayte,$headers_mayte);
      admin_leads_email_notification($subject_mayte, $message_mayte);
    }

    // Pending Documents End



    // No decision logic for payday Start

    if ($app_status_update == 'No Decision Logic For Payday') {


      /************************************  Email To Denice ************************* 

$to_denice = "denice@lsbanking.com";

$subject_denice = "No Decision Logic For Payday";
$message_denice = "No Decision Logic For Payday ".$first_name_update." ".$last_name__update.", has been approved ".$phone_number_update." and loan term is ".$personal_loan.". ";
$headers_denice = "From: info@ofsca.com";

mail($to_denice,$subject_denice,$message_denice,$headers_denice);


       ************************************  Email To Mayte *************************/

      $to_mayte = "mayte@lsbanking.com";

      $subject_mayte = "No Decision Logic For Payday";
      $message_mayte = "No Decision Logic For Payday " . $first_name_update . " " . $last_name__update . ", has been approved " . $phone_number_update . " and loan term is " . $personal_loan . ". ";
      $headers_mayte = "From: info@ofsca.com";

      //mail($to_mayte,$subject_mayte,$message_mayte,$headers_mayte);
      admin_leads_email_notification($subject_mayte, $message_mayte);
    }

    // No decision logic for payday End




    if ($app_status_update == 'Approved Payday Loan') {
      // Final Review For Personal Loan Email Start

      $to = "alejandra@lsbanking.com";

      $subject = "Approved Payday Loan";
      $message = " Approved Payday Loan " . $first_name_update . " " . $last_name__update . ", 

has been approved " . $phone_number_update . " and loan term is " . $personal_loan . ". ";
      $headers = "From: info@ofsca.com";

      //mail($to,$subject,$message,$headers);

      admin_leads_email_notification($subject, $message);
    }




    //************************************ ADMIN SMS End ****************//









    $query_update_status = "INSERT INTO `application_status_updates`( `application_id`, `user_id`, `status`, `creation_date`) VALUES ('$id','$u_id','$app_status_update','$date')";
    echo   $query_update_status;
    $result_status_update = mysqli_query($con, $query_update_status);
    if ($result_status_update) {
      echo "<div class='form'><h3> successfully added in application_status_updates.</h3><br/></div>";
    } else {
      echo "<h3> Error Inserting Data </h3>";
    }






    //mysqli_query ($con,"INSERT INTO `application_status_updates`( `application_id`, `user_id`, `status`, `creation_date`) VALUES ('$id','$u_id','$app_status_update','$date')");
    mysqli_query($con, "UPDATE fnd_user_profile SET first_name ='$first_name_update' , last_name='$last_name__update' , mobile_number='$phone_number_update' , email='$email_update', address='$address_update', city='$city_update', state='$state_update', zip_code='$zip_update', date_of_birth='$dob_update', ssn='$ssn_update',member_military='$member_military_update', last_update_by='$u_id',last_update_date='$date',application_status='$app_status_update',source_of_lead='$source_lead_update',declined_reason='$decline_reason_update', amount_of_loan='$amount_loan_update', dl_code='$dl_code_update', personal_loan='$personal_loan', apr='$update_apr', title_loan_amount='$title_loan_amount', loan_request_amount='$requested_loan_amount_update', payback_period='$payback_period_update', loan_type='$loan_type_update',co_borrow_full_name='$co_borrow_full_name_update',co_borrow_phone='$co_borrow_phone_update',co_borrow_address='$co_borrow_address_update',co_borrow_city='$co_borrow_city_update',co_borrow_state='$co_borrow_state_update',co_borrow_zip='$co_borrow_zip_update' where user_fnd_id ='$id'");


    /**
     * * Delete Participant and add new
     */
     
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://conversations.twilio.com/v1/Conversations/$chat_key/Participants",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "authorization: Basic QUM1ZTE4Yjg1MTk3ZGI2ZTMyZDE5OTViZjNiNDBlMDQ1YjpiOGI0NmI0Njg5MDQ3OWJjZjI1YTlmYjIwNjdlMWMxZQ==",
        "cache-control: no-cache",
      ),
    ));
  
    $response = curl_exec($curl);
    $err = curl_error($curl);
  
    curl_close($curl);
  
    $response = json_decode($response, TRUE);
    if(isset($response['participants'])){
      foreach ($response['participants'] as $participants) {
        $sid = $participants["sid"];

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://conversations.twilio.com/v1/Conversations/$chat_key/Participants/$sid",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "DELETE",
          CURLOPT_HTTPHEADER => array(
            "authorization: Basic QUM1ZTE4Yjg1MTk3ZGI2ZTMyZDE5OTViZjNiNDBlMDQ1YjpiOGI0NmI0Njg5MDQ3OWJjZjI1YTlmYjIwNjdlMWMxZQ==",
            "cache-control: no-cache",
          ),
        ));
      
        $response = curl_exec($curl);
        $err = curl_error($curl);
      
        curl_close($curl);
      }
    }

    $twilio_sender = str_replace("-", "", $phone_number_update);
    $twilio_sender = "+1$twilio_sender";
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://conversations.twilio.com/v1/Conversations/$chat_key/Participants",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"MessagingBinding.Address\"\r\n\r\n$twilio_sender\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"MessagingBinding.ProxyAddress\"\r\n\r\n+18886951203\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
      CURLOPT_HTTPHEADER => array(
        "authorization: Basic QUM1ZTE4Yjg1MTk3ZGI2ZTMyZDE5OTViZjNiNDBlMDQ1YjpiOGI0NmI0Njg5MDQ3OWJjZjI1YTlmYjIwNjdlMWMxZQ==",
        "cache-control: no-cache",
        "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
        "postman-token: 56f79e61-628f-ea75-95f8-4554ec0e8197"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);


    function if_insert($con)
    {
      $matched = explode(": ", explode('  ', $con->info)[0])[1]; // Rows matched
      $changed = explode(": ", explode('  ', $con->info)[1])[1]; // Changed

      return $matched == 0;
    };


    mysqli_query($con, "UPDATE source_income SET employer_name ='$employer_name_update', work_phone_no='$work_phone_update', net_check_amount='$net_amount_update', direct_deposit='$direct_deposit_update', pay_period='$pay_fre_update', last_pay_date='$last_date_update', next_pay_date='$next_date_update', last_update_by='$u_id',last_update_date='$date',business_type='$business_type_up',business_create='$business_create_up', address_b='$address_b', city_b='$city_b', state_b='$state_b',zip_b='$zip_b' where user_fnd_id ='$id' ");
    if (if_insert($con)) {
      // *********************************** Employee Info Insertion **********************************************

      $query_emp  = "INSERT INTO source_income (user_fnd_id,employer_name,work_phone_no,net_check_amount,direct_deposit,pay_period,last_pay_date,next_pay_date,creation_date,business_type,business_create,address_b,state_b,city_b,zip_b)  VALUES ('$id','$employer_name_update','$work_phone_update','$net_amount_update','$direct_deposit_update','$pay_fre_update','$last_date_update','$next_date_update','$date','$business_type_up','$business_create_up','$address_b','$state_b','$city_b','$zip_b')";
      $result_emp = mysqli_query($con, $query_emp);
      if ($result_emp) {
        //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
      } else {
        echo "<h3> Error Inserting Data </h3>";
      }
    }

    mysqli_query($con, "UPDATE tbl_business_info SET business_name ='$business_name_update', business_phone='$business_phone_update', monthly_gross_amount='$gross_amount_update', direct_deposit='$business_direct_deposit_update', how_paid='$business_get_paid_update', business_docs='$business_docs_update', last_update_by='$u_id', last_update_date='$date',business_address='$business_address_update',business_city='$business_city_update',business_state='$business_state_update',business_zip='$business_zip_update' where user_fnd_id ='$id' ");
    if (if_insert($con)) {
      // *********************************** Business Info Insertion **********************************************

      $query_business  = "INSERT INTO tbl_business_info (user_fnd_id,business_name,business_phone,business_address,business_city,business_state,business_zip,monthly_gross_amount,direct_deposit,how_paid,business_docs,created_by,created_at)  VALUES ('$id','$business_name_update','$business_phone_update','$business_address_update','$business_city_update','$business_state_update','$business_zip_update','$gross_amount_update','$business_direct_deposit_update','$business_get_paid_update','$business_docs_update','$u_id','$date')";
      $result_business = mysqli_query($con, $query_business);
      if ($result_business) {
        //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
      } else {
        echo "<h3> Error Inserting Data </h3>";
      }
    }

    mysqli_query($con, "UPDATE tbl_vehicle_info SET vehicle_year ='$vehicle_year_update', vehicle_made='$vehicle_make_update', vehicle_model='$vehicle_model_update', vehicle_miles='$vehicle_miles_update', vehicle_kbb='$vehicle_kbb_update', vehicle_ltv='$vehicle_ltv_update', last_update_by='$u_id', last_update_date='$date' where user_fnd_id ='$id'");
    if (if_insert($con)) {
      // *********************************** Vehicle Info Insertion **********************************************

      $query_vehicle  = "INSERT INTO tbl_vehicle_info (user_fnd_id,vehicle_year,vehicle_made,vehicle_model,vehicle_miles,vehicle_kbb,vehicle_ltv,created_by,created_at)  VALUES ('$id','$vehicle_year_update','$vehicle_make_update','$vehicle_model_update','$vehicle_miles_update','$vehicle_kbb_update','$vehicle_ltv_update','$u_id','$date')";
      $result_vehicle = mysqli_query($con, $query_vehicle);
      if ($result_vehicle) {
        //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
      } else {
        echo "<h3> Error Inserting Data </h3>";
      }
    }


    mysqli_query($con, "UPDATE binary_questions SET bq_answer ='$payment_update', creation_date='$date', last_update_date='$date', last_update_by='$u_id',last_update_date='$date' where user_fnd_id ='$id'");

    mysqli_query($con, "UPDATE application_notes SET app_notes ='$app_notes_update', creation_date='$date', last_update_date='$date', last_update_by='$u_id',last_update_date='$date' where user_fnd_id ='$id'");
    $delete_customer_string = "page_no=" . $_GET['page_no'];
    $delete_customer_string = str_replace("#", "", $delete_customer_string);
?>

    <script type="text/javascript">
      window.location.href = 'edit_customer.php?id=<?php echo $id; ?>';
    </script>

<?php

  } else {
    echo "<script type='text/javascript'>
window.location.href = 'not_authorize.php';
</script>";
  }
}

?>


<h3 style="color:red;">Conversation <span style="float:right;"> </span> </h3>
<iframe src="sms-chat/index.php?chat_key=<?php echo $chat_key; ?>&admin_name=<?php echo $u_name; ?>" height="500px" width="100%" id="conversation"></iframe>