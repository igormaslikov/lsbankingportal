<?php
error_reporting(0);
session_start();
include_once 'dbconnect.php';
include 'dbconfig.php';

if (!isset($_SESSION['userSession'])) {
  header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=" . $_SESSION['userSession']);
$userRow = $query->fetch_array();
$DBcon->close();

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
    .wrapper {
      width: 100%;
      margin: 20px auto 100px auto;
      padding: 0;
      position: relative;
    }
  </style>
</head>

<body>

  <?php include('menu.php'); ?>
  <?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/dbconnection.php';
  $con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
  //$con=mysqli_connect("localhost","dblsuser2021","^%D24L*!Ti5%","dbs57337");
  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  $sql_t = "SELECT amount_of_loan FROM tbl_loan ORDER BY loan_id";

  if ($result_t = mysqli_query($con, $sql_t)) {
    // Return the number of rows in result set
    $rowcount = mysqli_num_rows($result_t);
    // printf($rowcount);
    // Free result set
    $ye = mysqli_free_result($result_t);
    echo $ye;
  }

  mysqli_close($con);
  ?>
  <?php
  include 'dbconfig.php';

  $query_us = mysqli_query($con, "SELECT SUM(amount_of_loan) AS value_sum FROM tbl_loan");
  while ($row_us = mysqli_fetch_array($query_us)) {
    $us = $row_us['value_sum'];
    $us = round($us, 2);
    // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$us;

  }

  $query_le = mysqli_query($con, "SELECT SUM(amount_left) AS value_sum FROM tbl_loan");
  while ($row_le = mysqli_fetch_array($query_le)) {
    $am_le = $row_le['value_sum'];
    // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$am_le;

  }

  $pay_off = $us - $am_le;
  $avg_pay_off = $am_le / $rowcount;

  $avg_pay = round($avg_pay_off, 2);

  $avg_amount = $us / $rowcount;

  $avg = round($avg_amount, 2);


  $sql = mysqli_query($con, "select * from tbl_loan ");

  while ($row = mysqli_fetch_array($sql)) {

    $loan_id = $row['loan_id'];
  }
  //echo "fndid is:".$loan_id;

  $sql = mysqli_query($con, "select * from tbl_loan where loan_id='$loan_id'");

  while ($row = mysqli_fetch_array($sql)) {

    $userfnd_id = $row['user_fnd_id'];
  }
  //echo "fndid is:".$userfnd_id;



  $sql = mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$userfnd_id'");

  while ($row = mysqli_fetch_array($sql)) {

    $first_name = $row['first_name'];
  }

  //echo "fname is:".$first_name;

  ?>


  <div class="container wrapper" style="margin-top:70px;text-align:center;font-family:Verdana, Geneva, sans-serif;font-size:15px;">
    <br><br><br>
    <a href="" style="font-weight: bold; font-weight:900;font-size:22px">APPLICATIONS</a><br>

    <!--Deatil Of Users Start -->

    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/dbconnection.php';
    $con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $sql_t = "SELECT username,email FROM tbl_users ORDER BY user_id";

    if ($result_t = mysqli_query($con, $sql_t)) {
      // Return the number of rows in result set
      $rowcount_user = mysqli_num_rows($result_t);
      // printf($rowcount_user);
      // Free result set
      $ye = mysqli_free_result($result_t);
      echo $ye;
    }

    mysqli_close($con);
    ?>




    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/dbconnection.php';
    $con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $sql_t = "SELECT bg_name,email_id FROM business_group ORDER BY bg_id";

    if ($result_t = mysqli_query($con, $sql_t)) {
      // Return the number of rows in result set
      $rowcount_company = mysqli_num_rows($result_t);
      // printf($rowcount_company);
      // Free result set
      $ye = mysqli_free_result($result_t);
      echo $ye;
    }

    mysqli_close($con);
    ?>


    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/dbconnection.php';
    $con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $sql_t = "SELECT first_name,email FROM fnd_user_profile ORDER BY user_fnd_id";

    if ($result_t = mysqli_query($con, $sql_t)) {
      // Return the number of rows in result set
      $rowcount_customer = mysqli_num_rows($result_t);
      // printf($rowcount_customer);
      // Free result set
      $ye = mysqli_free_result($result_t);
      echo $ye;
    }

    // final review personal start

    $sql_frpl = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Final Review for Personal Loan'";

    if ($result_frpl = mysqli_query($con, $sql_frpl)) {
      // Return the number of rows in result set
      $rowcount_frpl = mysqli_num_rows($result_frpl);
      // printf($rowcount_customer);
      // Free result set
      $ye = mysqli_free_result($result_t);
      echo $ye;
    }

    // final review personal end 

    // approve personal start

    $sql_apersonall = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Personal Loan'";

    if ($result_apersonall = mysqli_query($con, $sql_apersonall)) {
      // Return the number of rows in result set
      $rowcount_apersonall = mysqli_num_rows($result_apersonall);
      // printf($rowcount_customer);
      // Free result set
      $ye = mysqli_free_result($result_t);
      echo $ye;
    }

    // approve personal end 

    // approved payday  start

    $sql_apaydayd = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Payday Loan' ";

    if ($result_apaydayd = mysqli_query($con, $sql_apaydayd)) {
      // Return the number of rows in result set
      $rowcount_apaydayd = mysqli_num_rows($result_apaydayd);
      // printf($rowcount_customer);
      // Free result set
      $ye = mysqli_free_result($result_apaydayd);
      echo $ye;
    }

    // approved payday  end 




    // Review For Payday  start

    $sql_review_payday = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Review For Payday' ";

    if ($result_review_payday = mysqli_query($con, $sql_review_payday)) {
      // Return the number of rows in result set
      $rowcount_review_payday = mysqli_num_rows($result_review_payday);
      // printf($rowcount_customer);
      // Free result set
      $ye_review_payday = mysqli_free_result($result_review_payday);
      echo $ye_review_payday;
    }

    // Review For Payday  end


    // Pending Documents Start

    $sql_pending_docs = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Pending Documents' ";

    if ($result_pending_docs = mysqli_query($con, $sql_pending_docs)) {
      // Return the number of rows in result set
      $rowcount_pending_docs = mysqli_num_rows($result_pending_docs);
      // printf($rowcount_customer);
      // Free result set
      $ye_pending_docs = mysqli_free_result($result_pending_docs);
      echo $ye_pending_docs;
    }

    // Pending Documents   end




    // Decision Logic Completed Start

    $sql_dl_completed = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Decision Logic Completed' ";

    if ($result_dl_completed = mysqli_query($con, $sql_dl_completed)) {
      // Return the number of rows in result set
      $rowcount_dl_completed = mysqli_num_rows($result_dl_completed);
      // printf($rowcount_customer);
      // Free result set
      $ye_dl_completed = mysqli_free_result($result_dl_completed);
      echo $ye_dl_completed;
    }

    // Decision Logic Completed   end


    //Credit Report Completed Start

    $sql_cr_completed = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Credit Report Completed' ";

    if ($result_cr_completed = mysqli_query($con, $sql_cr_completed)) {
      // Return the number of rows in result set
      $rowcount_cr_completed = mysqli_num_rows($result_cr_completed);
      // printf($rowcount_customer);
      // Free result set
      $ye_cr_completed = mysqli_free_result($result_cr_completed);
      echo $ye_cr_completed;
    }

    // Credit Report Completed   end


    //Interview Completed Start

    $sql_intrvw_completed = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Interview Completed' ";

    if ($result_intrvw_completed = mysqli_query($con, $sql_intrvw_completed)) {
      // Return the number of rows in result set
      $rowcount_intrvw_completed = mysqli_num_rows($result_intrvw_completed);
      // printf($rowcount_customer);
      // Free result set
      $ye_intrvw_completed = mysqli_free_result($result_intrvw_completed);
      echo $ye_intrvw_completed;
    }

    // Interview Completed   end




    //Loan Status Active Start

    $sql_loan_active = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Active' ";

    if ($result_loan_active = mysqli_query($con, $sql_loan_active)) {
      // Return the number of rows in result set
      $rowcount_loan_active = mysqli_num_rows($result_loan_active);
      // printf($rowcount_customer);
      // Free result set
      $ye_loan_active = mysqli_free_result($result_loan_active);
      echo $ye_loan_active;
    }

    // Loan Status Active   end


    //Loan Status Past Due Start

    $sql_loan_past = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Past Due' ";

    if ($result_loan_past = mysqli_query($con, $sql_loan_past)) {
      // Return the number of rows in result set
      $rowcount_loan_past = mysqli_num_rows($result_loan_past);
      // printf($rowcount_customer);
      // Free result set
      $ye_loan_past = mysqli_free_result($result_loan_past);
      echo $ye_loan_past;
    }

    // Loan Status Past Due   end


    //Loan Status Pyment Plan Start

    $sql_loan_plan = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Payment Plan' ";

    if ($result_loan_plan = mysqli_query($con, $sql_loan_plan)) {
      // Return the number of rows in result set
      $rowcount_loan_plan = mysqli_num_rows($result_loan_plan);
      // printf($rowcount_customer);
      // Free result set
      $ye_loan_plan = mysqli_free_result($result_loan_plan);
      echo $ye_loan_plan;
    }

    // Loan Status Pyment Plan   end

    //Loan Status Chargeoff Start

    $sql_loan_charge = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Chargeoff' ";

    if ($result_loan_charge = mysqli_query($con, $sql_loan_charge)) {
      // Return the number of rows in result set
      $rowcount_loan_charge = mysqli_num_rows($result_loan_charge);
      // printf($rowcount_customer);
      // Free result set
      $ye_loan_charge = mysqli_free_result($result_loan_charge);
      echo $ye_loan_charge;
    }

    // Loan Status Chargeoff   end

    //Loan Status Paid Start

    $sql_loan_paid = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Paid' ";

    if ($result_loan_paid = mysqli_query($con, $sql_loan_paid)) {
      // Return the number of rows in result set
      $rowcount_loan_paid = mysqli_num_rows($result_loan_paid);
    }

    // Loan Status Paid   end

    //Loan Status Promise to Pay Start

    $sql_loan_promise = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Promise to Pay' ";

    if ($result_loan_promise = mysqli_query($con, $sql_loan_promise)) {
      // Return the number of rows in result set
      $rowcount_promise = mysqli_num_rows($result_loan_promise);
    }

    // Loan Status Promise to Pay   end

    //Loan Status Collections Start

    $sql_loan_collections = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Collections' ";

    if ($result_loan_collections = mysqli_query($con, $sql_loan_collections)) {
      // Return the number of rows in result set
      $rowcount_collections = mysqli_num_rows($result_loan_collections);
    }

    // Loan Status Promise to Pay   end


    //Loan Status Closed Account Start

    $sql_loan_closed = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Closed Account' ";

    if ($result_loan_closed = mysqli_query($con, $sql_loan_closed)) {
      // Return the number of rows in result set
      $rowcount_closed = mysqli_num_rows($result_loan_closed);
    }

    // Loan Status Closed Account   end




    //Loan Status Chargeback Start

    $sql_loan_chargeback = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Chargeback' ";

    if ($result_loan_chargeback = mysqli_query($con, $sql_loan_chargeback)) {
      // Return the number of rows in result set
      $rowcount_chargeback = mysqli_num_rows($result_loan_chargeback);
    }

    // Loan Status Chargeback   end



    //Loan Status Bankruptcy Start

    $sql_loan_bankruptcy = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Bankruptcy' ";

    if ($result_loan_bankruptcy = mysqli_query($con, $sql_loan_bankruptcy)) {
      // Return the number of rows in result set
      $rowcount_bankruptcy = mysqli_num_rows($result_loan_bankruptcy);
    }

    // Loan Status Bankruptcy   end


    //Loan Status Pending Start

    $sql_loan_pending = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Pending' ";

    if ($result_loan_pending = mysqli_query($con, $sql_loan_pending)) {
      // Return the number of rows in result set
      $rowcount_pending = mysqli_num_rows($result_loan_pending);
    }

    // Loan Status Pending   end



    //Loan Status Disbursement Start

    $sql_loan_disbursement = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Disbursement' ";

    if ($result_loan_disbursement = mysqli_query($con, $sql_loan_disbursement)) {
      // Return the number of rows in result set
      $rowcount_disbursement = mysqli_num_rows($result_loan_disbursement);
    }

    // Loan Status Disbursement   end




    //Ready for review Start

    $sql_ready_fr_review = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Ready for review' ";

    if ($result_ready_fr_review = mysqli_query($con, $sql_ready_fr_review)) {
      // Return the number of rows in result set
      $rowcount_ready_fr_review = mysqli_num_rows($result_ready_fr_review);
      // printf($rowcount_ready_fr_review);
    }

    // Ready for review   end



    //Info Needed Start

    $sql_inf_needed = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Info Needed' ";

    if ($result_inf_needed = mysqli_query($con, $sql_inf_needed)) {
      // Return the number of rows in result set
      $rowcount_inf_needed = mysqli_num_rows($result_inf_needed);
      // printf($rowcount_inf_needed);
    }

    // Info Needed   end


    //Review Payday CA Start

    $sql_rev_payday_ca = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Review Payday CA' ";

    if ($result_rev_payday_ca = mysqli_query($con, $sql_rev_payday_ca)) {
      // Return the number of rows in result set
      $rowcount_rev_payday_ca = mysqli_num_rows($result_rev_payday_ca);
      // printf($rowcount_rev_payday_ca);
    }

    //Review Payday CA  end


    //DL/Bank Payday CA Start

    $sql_dl_bank_ca = "SELECT first_name,email FROM fnd_user_profile where application_status = 'DL/Bank Payday CA' ";

    if ($result_dl_bank_ca = mysqli_query($con, $sql_dl_bank_ca)) {
      // Return the number of rows in result set
      $rowcount_dl_bank_ca = mysqli_num_rows($result_dl_bank_ca);
      // printf($rowcount_dl_bank_ca);
    }

    // DL/Bank Payday CA end



    //DL/Bank Installment CA Start

    $sql_dl_bank_install_ca = "SELECT * FROM fnd_user_profile where application_status = 'DL/Bank Installment CA' ";

    if ($result_dl_bank_install_ca = mysqli_query($con, $sql_dl_bank_install_ca)) {
      // Return the number of rows in result set
      $rowcount_dl_bank_install_ca = mysqli_num_rows($result_dl_bank_install_ca);
      // printf($rowcount_dl_bank_install_ca);
    }

    // DL/Bank Installment CA end


    //DL/Bank Installment NV Start

    $sql_dl_bank_install_nv = "SELECT first_name,email FROM fnd_user_profile where application_status = 'DL/Bank Installment NV' ";

    if ($result_dl_bank_install_nv = mysqli_query($con, $sql_dl_bank_install_nv)) {
      // Return the number of rows in result set
      $rowcount_dl_bank_install_nv = mysqli_num_rows($result_dl_bank_install_nv);
      // printf($rowcount_dl_bank_install_nv);
    }

    // DL/Bank Installment NV end


    // DL/Bank Installment AZ Start

    $sql_dl_bank_install_az = "SELECT first_name,email FROM fnd_user_profile where application_status = 'DL/Bank Installment AZ' ";

    if ($result_dl_bank_install_az = mysqli_query($con, $sql_dl_bank_install_az)) {
      // Return the number of rows in result set
      $rowcount_dl_bank_install_az = mysqli_num_rows($result_dl_bank_install_az);
      // printf($rowcount_dl_bank_install_az);
    }

    // DL/Bank Installment AZ end





    //Approved Payday NV Start

    $sql_aprovd_paydy_nv = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Payday NV' ";

    if ($result_aprovd_paydy_nv = mysqli_query($con, $sql_aprovd_paydy_nv)) {
      // Return the number of rows in result set
      $rowcount_aprovd_paydy_nv = mysqli_num_rows($result_aprovd_paydy_nv);
      // printf($rowcount_aprovd_paydy_nv);
    }

    // Approved Payday NV end






    //Approved Installment NV Start

    $sql_aprovd_install_nv = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Installment NV' ";

    if ($result_install_paydy_nv = mysqli_query($con, $sql_aprovd_install_nv)) {
      // Return the number of rows in result set
      $rowcount_install_paydy_nv = mysqli_num_rows($result_install_paydy_nv);
      // printf($rowcount_install_paydy_nv);
    }

    // Approved Installment NV end


    //Approved Installment CA Start

    $sql_aprovd_install_ca = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Installment CA' ";

    if ($result_install_paydy_ca = mysqli_query($con, $sql_aprovd_install_ca)) {
      // Return the number of rows in result set
      $rowcount_aprovd_intall_ca = mysqli_num_rows($result_install_paydy_ca);
      // printf($rowcount_aprovd_intall_ca);
    }

    // Approved Installment CA end

    //Review CA Start

    $sql_rev_ca = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Review Installment CA' ";

    if ($result_rev_ca = mysqli_query($con, $sql_rev_ca)) {
      // Return the number of rows in result set
      $rowcount_rev_ca = mysqli_num_rows($result_rev_ca);
      // printf($rowcount_rev_ca);
    }

    // Review CA end




    //Approved Installment AZ Start

    $sql_aprovd_install_az = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Installment AZ' ";

    if ($result_install_paydy_az = mysqli_query($con, $sql_aprovd_install_az)) {
      // Return the number of rows in result set
      $rowcount_install_paydy_az = mysqli_num_rows($result_install_paydy_az);
      // printf($rowcount_install_paydy_az);
    }

    // Approved Installment AZ end


    //Review Installment AZ Start

    $sql_rev_install_az = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Review Installment AZ' ";

    if ($resul_rev_install_az = mysqli_query($con, $sql_rev_install_az)) {
      // Return the number of rows in result set
      $rowcount_rev_install_az = mysqli_num_rows($resul_rev_install_az);
      // printf($rowcount_rev_install_az);
    }

    // Review Installment AZ end


    //Review Installment nv Start

    $sql_rev_install_nv = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Review Installment NV' ";

    if ($resul_rev_install_nv = mysqli_query($con, $sql_rev_install_nv)) {
      // Return the number of rows in result set
      $rowcount_rev_install_nv = mysqli_num_rows($resul_rev_install_nv);
      // printf($rowcount_rev_install_nv);
    }

    // Review Installment AZ end




    //Approved Commercial CA Start

    $sql_aprovd_comercial_ca = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Commercial CA' ";

    if ($result_aprovd_comercial_ca = mysqli_query($con, $sql_aprovd_comercial_ca)) {
      // Return the number of rows in result set
      $rowcount_aprovd_comercial_ca = mysqli_num_rows($result_aprovd_comercial_ca);
      // printf($rowcount_aprovd_comercial_ca);
    }

    // Approved Commercial NV end

    //Approved Payday CA Start

    $sql_aprovd_paydy_ca = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Payday CA' ";

    if ($result_aprovd_paydy_ca = mysqli_query($con, $sql_aprovd_paydy_ca)) {
      // Return the number of rows in result set
      $rowcount_aprovd_paydy_ca = mysqli_num_rows($result_aprovd_paydy_ca);
      // printf($rowcount_aprovd_paydy_ca);
    }

    // Approved Payday CA end



    //Approved Payday NV Start

    $sql_aprovd_paydy_nv = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Payday NV' ";

    if ($result_aprovd_paydy_nv = mysqli_query($con, $sql_aprovd_paydy_nv)) {
      // Return the number of rows in result set
      $rowcount_aprovd_paydy_nv = mysqli_num_rows($result_aprovd_paydy_nv);
      // printf($rowcount_aprovd_paydy_nv);
    }

    // Approved Payday NV end




    //Review Payday NV Start

    $sql_rev_payday_nv = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Review Payday NV' ";

    if ($result_rev_payday_nv = mysqli_query($con, $sql_rev_payday_nv)) {
      // Return the number of rows in result set
      $rowcount_rev_payday_nv = mysqli_num_rows($result_rev_payday_nv);
      // printf($rowcount_rev_payday_nv);
    }

    //Review Payday NV  end


    //DL/Bank Payday NV Start

    $sql_dl_bank_nv = "SELECT first_name,email FROM fnd_user_profile where application_status = 'DL/Bank Payday NV' ";

    if ($result_dl_bank_nv = mysqli_query($con, $sql_dl_bank_nv)) {
      // Return the number of rows in result set
      $rowcount_dl_bank_nv = mysqli_num_rows($result_dl_bank_nv);
      // printf($rowcount_dl_bank_nv);
    }

    // DL/Bank Payday NV end









    //Approved Payday IL Start

    $sql_aprovd_paydy_il = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Payday IL' ";

    if ($result_aprovd_paydy_il = mysqli_query($con, $sql_aprovd_paydy_il)) {
      // Return the number of rows in result set
      $rowcount_aprovd_paydy_il = mysqli_num_rows($result_aprovd_paydy_il);
      // printf($rowcount_aprovd_paydy_nv);
    }

    // Approved Payday IL end




    //Review Payday IL Start

    $sql_rev_payday_il = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Review Payday IL' ";

    if ($result_rev_payday_il = mysqli_query($con, $sql_rev_payday_il)) {
      // Return the number of rows in result set
      $rowcount_rev_payday_il = mysqli_num_rows($result_rev_payday_il);
      // printf($rowcount_rev_payday_il);
    }

    //Review Payday IL  end


    //DL/Bank Payday NV Start

    $sql_dl_bank_il = "SELECT first_name,email FROM fnd_user_profile where application_status = 'DL/Bank Payday IL' ";

    if ($result_dl_bank_il = mysqli_query($con, $sql_dl_bank_il)) {
      // Return the number of rows in result set
      $rowcount_dl_bank_il = mysqli_num_rows($result_dl_bank_il);
      // printf($rowcount_dl_bank_il);
    }

    // DL/Bank Payday NV end


    //******************************************************************************************************************************************************8


    //Approved Payday IL Start

    $sql_aprovd_install_il = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Installment IL' ";

    if ($result_aprovd_install_il = mysqli_query($con, $sql_aprovd_install_il)) {
      // Return the number of rows in result set
      $rowcount_aprovd_install_il = mysqli_num_rows($result_aprovd_install_il);
      // printf($rowcount_aprovd_install_nv);
    }

    // Approved Payday IL end




    //Review Payday IL Start

    $sql_rev_install_il = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Review Installment IL' ";

    if ($result_rev_install_il = mysqli_query($con, $sql_rev_install_il)) {
      // Return the number of rows in result set
      $rowcount_rev_install_il = mysqli_num_rows($result_rev_install_il);
      // printf($rowcount_rev_install_il);
    }

    //Review Payday IL  end


    //DL/Bank Payday NV Start

    $sql_dl_bank_install_il = "SELECT first_name,email FROM fnd_user_profile where application_status = 'DL/Bank Installment IL' ";

    if ($result_dl_bank_install_il = mysqli_query($con, $sql_dl_bank_install_il)) {
      // Return the number of rows in result set
      $rowcount_dl_bank_install_il = mysqli_num_rows($result_dl_bank_install_il);
      // printf($rowcount_dl_bank_install_il);
    }

    // DL/Bank Payday NV end



    //*******************************************************************************************************************************************************

    mysqli_close($con);
    ?>






    <!--<div class="row" style="background-color: #F5E09E;color: white;padding:20px;">-->

    <!--<div class="col-lg-4"><p style="color:black;font-weight: bold">Total Applications: <b style="color:red"> <?php //echo $rowcount_customer;
                                                                                                                  ?> </b></p></div>-->
    <!--<div class="col-lg-4"><p style="color:black;font-weight: bold">Initial Review:<b style="color:red"> <?php //echo $rowcount_user;
                                                                                                            ?></b></p></div>-->
    <!--<div class="col-lg-4"><p style="color:black;font-weight: bold">Final Review: <b style="color:red"> <?php //echo $rowcount_company;
                                                                                                            ?> </b> </p></div>-->

    <!--</div>-->


    <!--Deatil Of Users END -->



    <!--Deatil Of Loans -->

    <div class="row wrapper" style="background-color: #F5E09E;color: white;padding:10px;">

      <!--
<div class="col-lg-4"><p style="color:black;font-weight: bold">Total Loan Accounts:<b style="color:red"> <?php echo $rowcount; ?></b></p></div>
<div class="col-lg-4"><p style="color:black;font-weight: bold">Total Loan Amount: <b style="color:red">$ <?php echo $us; ?> </b> </p></div>
<div class="col-lg-4"><p style="color:black;font-weight: bold">Total Payoff Amount: <b style="color:red">$ <?php echo $pay_off; ?> </b></p></div>
<div class="col-lg-4"><p style="color:black;font-weight: bold">Avg. Loan Amount:  <b style="color:red">$<?php echo $avg; ?> </b></p></div>
<div class="col-lg-4"><p style="color:black;font-weight: bold">Avg. Payoff Amount: <b style="color:red"> $<?php echo $avg_pay; ?></b></p></div>
-->


      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=Approved+Payday+CA&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Approved Payday CA :<b style="color:red"> <?php echo $rowcount_aprovd_paydy_ca; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>ls_software/admin/view_all_customer.php?status=Review+Payday+CA&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Review Payday CA :<b style="color:red"> <?php echo $rowcount_rev_payday_ca; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=DL/Bank+Payday+CA&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">DL/Bank Payday CA :<b style="color:red"> <?php echo $rowcount_dl_bank_ca; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=Approved+Payday+NV&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Approved Payday NV :<b style="color:red"> <?php echo $rowcount_aprovd_paydy_nv; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=Review+Payday+NV&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Review Payday NV :<b style="color:red"> <?php echo $rowcount_rev_payday_nv; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=DL/Bank+Payday+NV&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">DL/Bank Payday NV :<b style="color:red"> <?php echo $rowcount_dl_bank_nv; ?></b></a></p>
      </div>

      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=Approved+Payday+IL&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Approved Payday IL :<b style="color:red"> <?php echo $rowcount_aprovd_paydy_il; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=Review+Payday+IL&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Review Payday IL :<b style="color:red"> <?php echo $rowcount_rev_payday_il; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=DL/Bank+Payday+IL&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">DL/Bank Payday IL :<b style="color:red"> <?php echo $rowcount_dl_bank_il; ?></b></a></p>
      </div>

      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=Approved+Installment+CA&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Approved Commercial CA :<b style="color:red"> <?php echo $rowcount_aprovd_intall_ca; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=Review+Installment+CA&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Review Commercial CA :<b style="color:red"> <?php echo $rowcount_rev_ca; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=DL/Bank+Installment+CA&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">DL/Bank Commercial CA :<b style="color:red"> <?php echo $rowcount_dl_bank_install_ca; ?></b></a></p>
      </div>


      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=Approved+Installment+AZ&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Approved Installment AZ :<b style="color:red"> <?php echo $rowcount_install_paydy_az; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=Review+Installment+AZ&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Review Installment AZ :<b style="color:red"> <?php echo $rowcount_rev_install_az; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=DL/Bank+Installment+AZ&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">DL/Bank Installment AZ :<b style="color:red"> <?php echo $rowcount_dl_bank_install_az; ?></b></a></p>
      </div>

      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=Approved+Installment+IL&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Approved Installment IL :<b style="color:red"> <?php echo $rowcount_aprovd_install_il; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=Review+Installment+IL&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Review Installment IL :<b style="color:red"> <?php echo $rowcount_rev_install_il; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=DL/Bank+Installment+IL&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">DL/Bank Installment IL :<b style="color:red"> <?php echo $rowcount_dl_bank_install_il; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=Approved+Installment+NV&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Approved Installment NV :<b style="color:red"> <?php echo $rowcount_install_paydy_nv; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=Review+Installment+NV&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Review Installment NV : <b style="color:red"> <?php echo $rowcount_rev_install_nv; ?> </b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=DL/Bank+Installment+NV&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">DL/Bank Installment NV : <b style="color:red"> <?php echo $rowcount_dl_bank_install_nv; ?> </b></a></p>
      </div>

      <!--<div class="col-lg-4"><p style="color:black;font-weight: bold"><a  href = "<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=Info+Needed&website=All&keyword=&from_date=&to_date=&search=">Info Needed :<b style="color:red"> <?php echo $rowcount_inf_needed; ?></b></a></p></div>-->
      <!--<div class="col-lg-3"><p style="color:black;font-weight: bold"><a  href = "<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=Decision+Logic+Completed&website=All&keyword=&from_date=&to_date=&search=">Decision Logic Completed :<b style="color:red"> <?php //echo $rowcount_dl_completed;
                                                                                                                                                                                                                                                                                          ?></b></a></p></div>-->
      <!--<div class="col-lg-3"><p style="color:black;font-weight: bold"><a  href = "<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=Credit+Report+Completed&website=All&keyword=&from_date=&to_date=&search=">Credit Report Completed : <b style="color:red"> <?php //echo $rowcount_cr_completed;
                                                                                                                                                                                                                                                                                          ?> </b></a></p></div>-->
      <!--<div class="col-lg-3"><p style="color:black;font-weight: bold"><a  href = "<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=Interview+Completed&website=All&keyword=&from_date=&to_date=&search=">Interview Completed : <b style="color:red"> <?php //echo $rowcount_intrvw_completed;
                                                                                                                                                                                                                                                                                  ?> </b></a></p></div>-->
      <!--<div class="col-lg-3"><p style="color:black;font-weight: bold"><a  href = "<?php echo $url_origin; ?>/ls_software/admin/view_all_customer.php?status=Pending+Documents&website=All&keyword=&from_date=&to_date=&search=">Pending Documents : <b style="color:red"> <?php //echo $rowcount_pending_docs;
                                                                                                                                                                                                                                                                              ?> </b></a></p></div>-->



    </div>


    <a href="" style="font-weight: bold; font-weight:900;font-size:22px">PAYDAY LOAN SUMMARY</a><br>



    <div class="row wrapper" style="background-color: #F5E09E;color: white;padding:20px;">

      <!--
<div class="col-lg-4"><p style="color:black;font-weight: bold">Total Loan Accounts:<b style="color:red"> <?php echo $rowcount; ?></b></p></div>
<div class="col-lg-4"><p style="color:black;font-weight: bold">Total Loan Amount: <b style="color:red">$ <?php echo $us; ?> </b> </p></div>
<div class="col-lg-4"><p style="color:black;font-weight: bold">Total Payoff Amount: <b style="color:red">$ <?php echo $pay_off; ?> </b></p></div>
<div class="col-lg-4"><p style="color:black;font-weight: bold">Avg. Loan Amount:  <b style="color:red">$<?php echo $avg; ?> </b></p></div>
<div class="col-lg-4"><p style="color:black;font-weight: bold">Avg. Payoff Amount: <b style="color:red"> $<?php echo $avg_pay; ?></b></p></div>
-->


      <div class="col-lg-2">
        <p style="color:black;font-weight: bold"><a href="view_specific_payday_loans.php?status=Pending&keyword=&from_date=&loan_date=&due_date=&to_date=&search=">Pending:<b style="color:red"> <?php echo $rowcount_pending; ?></b></a></p>
      </div>
      <div class="col-lg-2">
        <p style="color:black;font-weight: bold"><a href="view_specific_payday_loans.php?status=Active&keyword=&from_date=&loan_date=&due_date=&to_date=&search=">Active:<b style="color:red"> <?php echo $rowcount_loan_active; ?></b></a></p>
      </div>
      <div class="col-lg-2">
        <p style="color:black;font-weight: bold"><a href="view_specific_payday_loans.php?status=Past+Due&keyword=&from_date=&loan_date=&due_date=&to_date=&search=">Past Due:<b style="color:red"> <?php echo $rowcount_loan_past; ?></b></a></p>
      </div>
      <div class="col-lg-2">
        <p style="color:black;font-weight: bold"><a href="view_specific_payday_loans.php?status=Payment+Plan&keyword=&from_date=&loan_date=&due_date=&to_date=&search=">Payment Plan: <b style="color:red"> <?php echo $rowcount_loan_plan; ?> </b></a> </p>
      </div>
      <div class="col-lg-2">
        <p style="color:black;font-weight: bold"><a href="view_specific_payday_loans.php?status=Chargeoff&keyword=&from_date=&loan_date=&due_date=&to_date=&search=">Chargeoff:<b style="color:red"> <?php echo $rowcount_loan_charge; ?></b></a></p>
      </div>
      <div class="col-lg-2">
        <p style="color:black;font-weight: bold"><a href="view_specific_payday_loans.php?status=Chargeback&keyword=&from_date=&loan_date=&due_date=&to_date=&search=">Chargeback:<b style="color:red"> <?php echo $rowcount_chargeback; ?></b></a></p>
      </div>





      <div class="col-lg-2">
        <p style="color:black;font-weight: bold"><a href="view_specific_payday_loans.php?status=Disbursement&keyword=&from_date=&loan_date=&due_date=&to_date=&search=">Disbursement:<b style="color:red"> <?php echo $rowcount_disbursement; ?></b></a></p>
      </div>
      <div class="col-lg-2">
        <p style="color:black;font-weight: bold"><a href="view_specific_payday_loans.php?status=Paid&keyword=&from_date=&loan_date=&due_date=&to_date=&search=">Paid:<b style="color:red"> <?php echo $rowcount_loan_paid; ?></b></a></p>
      </div>
      <div class="col-lg-2">
        <p style="color:black;font-weight: bold"><a href="view_specific_payday_loans.php?status=Promise+to+Pay&keyword=&from_date=&loan_date=&due_date=&to_date=&search=">Promise to Pay: <b style="color:red"> <?php echo $rowcount_promise; ?> </b></a> </p>
      </div>
      <div class="col-lg-2">
        <p style="color:black;font-weight: bold"><a href="view_specific_payday_loans.php?status=Collections&keyword=&from_date=&loan_date=&due_date=&to_date=&search=">Collections:<b style="color:red"> <?php echo $rowcount_collections; ?></b></a></p>
      </div>
      <div class="col-lg-2">
        <p style="color:black;font-weight: bold"><a href="view_specific_payday_loans.php?status=Closed+Account&keyword=&from_date=&loan_date=&due_date=&to_date=&search=">Closed Account:<b style="color:red"> <?php echo $rowcount_closed; ?></b></a></p>
      </div>
      <div class="col-lg-2">
        <p style="color:black;font-weight: bold"><a href="view_specific_payday_loans.php?status=Bankruptcy&keyword=&from_date=&loan_date=&due_date=&to_date=&search=">Bankruptcy:<b style="color:red"> <?php echo $rowcount_bankruptcy; ?></b></a></p>
      </div>



    </div>





    <!--Deatil Of Loans END-->

    <br>


  </div>

</body>

</html>