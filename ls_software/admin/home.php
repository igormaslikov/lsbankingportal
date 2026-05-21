<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/security.php';
require_login();
include_once 'dbconnect.php';
include 'dbconfig.php';

$jpgraph_loaded = false;
// jpgraph needs PHP's GD extension; without it, even loading jpgraph fatal-errors.
if (extension_loaded('gd') && is_file(__DIR__ . '/jpgraph/jpgraph.php')) {
    require_once __DIR__ . '/jpgraph/jpgraph.php';
    require_once __DIR__ . '/jpgraph/jpgraph_pie.php';
    require_once __DIR__ . '/jpgraph/jpgraph_pie3d.php';
    $jpgraph_loaded = true;
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=" . intval($_SESSION['userSession']));
if (!$query || !($userRow = $query->fetch_array())) {
	header("Location: index.php");
	exit;
}
$DBcon->close();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome - <?php echo h($userRow['email']); ?></title>

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
  require_once $_SERVER['DOCUMENT_ROOT'] . '/SqlServerDb.php';
  $con = portal_get_sqlsrv_db();

  $result_t = $con->query("SELECT amount_of_loan FROM tbl_loan ORDER BY loan_id");
  $rowcount = $result_t ? $result_t->num_rows : 0;

  $query_us = $con->query("SELECT SUM(TRY_CAST(amount_of_loan AS DECIMAL(18,2))) AS value_sum FROM tbl_loan");
  $us = 0;
  if ($query_us && ($row_us = $query_us->fetch_array())) {
    $us = round((float)$row_us['value_sum'], 2);
  }

  $query_le = $con->query("SELECT SUM(TRY_CAST(loan_total_payable AS DECIMAL(18,2))) AS value_sum FROM tbl_loan");
  $am_le = 0;
  if ($query_le && ($row_le = $query_le->fetch_array())) {
    $am_le = round((float)$row_le['value_sum'], 2);
  }

  $pay_off      = $us - $am_le;
  $avg_pay      = ($rowcount > 0) ? round($am_le / $rowcount, 2) : 0;
  $avg          = ($rowcount > 0) ? round($us / $rowcount, 2) : 0;

  $loan_id = 0;
  $sql_last = $con->query("SELECT TOP 1 loan_id FROM tbl_loan ORDER BY loan_id DESC");
  if ($sql_last && ($row_last = $sql_last->fetch_array())) {
    $loan_id = (int)$row_last['loan_id'];
  }

//   $query_le = $con->query("SELECT SUM(amount_left) AS value_sum FROM tbl_loan");
//   while ($row_le = $query_le->fetch_array()) {
//     $am_le = $row_le['value_sum'];
//     // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$am_le;

//   }

//   $pay_off = $us - $am_le;
//   $avg_pay_off = $am_le / $rowcount;

//   $avg_pay = round($avg_pay_off, 2);

  $avg_amount = $us / $rowcount;

  $avg = round($avg_amount, 2);


  $sql = $con->query("select * from tbl_loan ");

  while ($row = $sql->fetch_array()) {

    $loan_id = $row['loan_id'];
  }
  ?>


  <div class="container wrapper" style="margin-top:70px;text-align:center;font-family:Verdana, Geneva, sans-serif;font-size:15px;">
    <br><br><br>
    <a href="" style="font-weight: bold; font-weight:900;font-size:22px">APPLICATIONS</a><br>

    <!--Deatil Of Users Start -->

    <?php
    $result_t = $con->query("SELECT username,email FROM tbl_users ORDER BY user_id");
    $rowcount_user = $result_t ? $result_t->num_rows : 0;
    ?>




    <?php
    $result_t = $con->query("SELECT bg_name,email_id FROM business_group ORDER BY bg_id");
    $rowcount_company = $result_t ? $result_t->num_rows : 0;
    ?>


    <?php
    $sql_t = "SELECT first_name,email FROM fnd_user_profile ORDER BY user_fnd_id";

    if ($result_t = $con->query($sql_t)) {
      // Return the number of rows in result set
      $rowcount_customer = $result_t->num_rows;
      // printf($rowcount_customer);
      // Free result set
      
    }

    // final review personal start

    // $sql_frpl = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Final Review for Personal Loan'";

    // if ($result_frpl = $con->query($sql_frpl)) {
    //   // Return the number of rows in result set
    //   $rowcount_frpl = $result_frpl->num_rows;
    //   // printf($rowcount_customer);
    //   // Free result set
    //   $ye = null;
    //   echo $ye;
    // }

    // final review personal end 

    // approve personal start

    // $sql_apersonall = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Personal Loan'";

    // if ($result_apersonall = $con->query($sql_apersonall)) {
    //   // Return the number of rows in result set
    //   $rowcount_apersonall = $result_apersonall->num_rows;
    //   // printf($rowcount_customer);
    //   // Free result set
    //   $ye = null;
    //   echo $ye;
    // }

    // approve personal end 

    // approved payday  start

    // $sql_apaydayd = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Payday Loan' ";

    // if ($result_apaydayd = $con->query($sql_apaydayd)) {
    //   // Return the number of rows in result set
    //   $rowcount_apaydayd = $result_apaydayd->num_rows;
    //   // printf($rowcount_customer);
    //   // Free result set
    //   $ye = null;
    //   echo $ye;
    // }

    // approved payday  end 




    // Review For Payday  start

    // $sql_review_payday = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Review For Payday' ";

    // if ($result_review_payday = $con->query($sql_review_payday)) {
    //   // Return the number of rows in result set
    //   $rowcount_review_payday = $result_review_payday->num_rows;
    //   // printf($rowcount_customer);
    //   // Free result set
    //   $ye_review_payday = null;
    //   echo $ye_review_payday;
    // }

    // Review For Payday  end


    // Pending Documents Start

    // $sql_pending_docs = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Pending Documents' ";

    // if ($result_pending_docs = $con->query($sql_pending_docs)) {
    //   // Return the number of rows in result set
    //   $rowcount_pending_docs = $result_pending_docs->num_rows;
    //   // printf($rowcount_customer);
    //   // Free result set
    //   $ye_pending_docs = null;
    //   echo $ye_pending_docs;
    // }

    // Pending Documents   end




    // Decision Logic Completed Start

    // $sql_dl_completed = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Decision Logic Completed' ";

    // if ($result_dl_completed = $con->query($sql_dl_completed)) {
    //   // Return the number of rows in result set
    //   $rowcount_dl_completed = $result_dl_completed->num_rows;
    //   // printf($rowcount_customer);
    //   // Free result set
    //   $ye_dl_completed = null;
    //   echo $ye_dl_completed;
    // }

    // Decision Logic Completed   end


    //Credit Report Completed Start

    // $sql_cr_completed = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Credit Report Completed' ";

    // if ($result_cr_completed = $con->query($sql_cr_completed)) {
    //   // Return the number of rows in result set
    //   $rowcount_cr_completed = $result_cr_completed->num_rows;
    //   // printf($rowcount_customer);
    //   // Free result set
    //   $ye_cr_completed = null;
    //   echo $ye_cr_completed;
    // }

    // Credit Report Completed   end


    //Interview Completed Start

    // $sql_intrvw_completed = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Interview Completed' ";

    // if ($result_intrvw_completed = $con->query($sql_intrvw_completed)) {
    //   // Return the number of rows in result set
    //   $rowcount_intrvw_completed = $result_intrvw_completed->num_rows;
    //   // printf($rowcount_customer);
    //   // Free result set
    //   $ye_intrvw_completed = null;
    //   echo $ye_intrvw_completed;
    // }

    // Interview Completed   end




    //Loan Status Active Start

    $sql_loan_active = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Active' ";

    if ($result_loan_active = $con->query($sql_loan_active)) {
      // Return the number of rows in result set
      $rowcount_loan_active = $result_loan_active->num_rows;
      // printf($rowcount_customer);
      // Free result set
      
    }

    // Loan Status Active   end


    //Loan Status Past Due Start

    $sql_loan_past = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Past Due' ";

    if ($result_loan_past = $con->query($sql_loan_past)) {
      // Return the number of rows in result set
      $rowcount_loan_past = $result_loan_past->num_rows;
      // printf($rowcount_customer);
      // Free result set
      
    }

    // Loan Status Past Due   end


    //Loan Status Pyment Plan Start

    $sql_loan_plan = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Payment Plan' ";

    if ($result_loan_plan = $con->query($sql_loan_plan)) {
      // Return the number of rows in result set
      $rowcount_loan_plan = $result_loan_plan->num_rows;
      // printf($rowcount_customer);
      // Free result set
      
    }

    // Loan Status Pyment Plan   end

    //Loan Status Chargeoff Start

    $sql_loan_charge = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Chargeoff' ";

    if ($result_loan_charge = $con->query($sql_loan_charge)) {
      // Return the number of rows in result set
      $rowcount_loan_charge = $result_loan_charge->num_rows;
      // printf($rowcount_customer);
      // Free result set
      
    }

    // Loan Status Chargeoff   end

    //Loan Status Paid Start

    $sql_loan_paid = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Paid' ";

    if ($result_loan_paid = $con->query($sql_loan_paid)) {
      // Return the number of rows in result set
      $rowcount_loan_paid = $result_loan_paid->num_rows;
    }

    // Loan Status Paid   end

    //Loan Status Promise to Pay Start

    $sql_loan_promise = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Promise to Pay' ";

    if ($result_loan_promise = $con->query($sql_loan_promise)) {
      // Return the number of rows in result set
      $rowcount_promise = $result_loan_promise->num_rows;
    }

    // Loan Status Promise to Pay   end

    //Loan Status Collections Start

    $sql_loan_collections = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Collections' ";

    if ($result_loan_collections = $con->query($sql_loan_collections)) {
      // Return the number of rows in result set
      $rowcount_collections = $result_loan_collections->num_rows;
    }

    // Loan Status Promise to Pay   end


    //Loan Status Closed Account Start

    $sql_loan_closed = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Closed Account' ";

    if ($result_loan_closed = $con->query($sql_loan_closed)) {
      // Return the number of rows in result set
      $rowcount_closed = $result_loan_closed->num_rows;
    }

    // Loan Status Closed Account   end




    //Loan Status Chargeback Start

    $sql_loan_chargeback = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Chargeback' ";

    if ($result_loan_chargeback = $con->query($sql_loan_chargeback)) {
      // Return the number of rows in result set
      $rowcount_chargeback = $result_loan_chargeback->num_rows;
    }

    // Loan Status Chargeback   end



    //Loan Status Bankruptcy Start

    $sql_loan_bankruptcy = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Bankruptcy' ";

    if ($result_loan_bankruptcy = $con->query($sql_loan_bankruptcy)) {
      // Return the number of rows in result set
      $rowcount_bankruptcy = $result_loan_bankruptcy->num_rows;
    }

    // Loan Status Bankruptcy   end


    //Loan Status Pending Start

    $sql_loan_pending = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Pending' ";

    if ($result_loan_pending = $con->query($sql_loan_pending)) {
      // Return the number of rows in result set
      $rowcount_pending = $result_loan_pending->num_rows;
    }

    // Loan Status Pending   end



    //Loan Status Disbursement Start

    $sql_loan_disbursement = "SELECT loan_id,user_fnd_id FROM tbl_loan where loan_status = 'Disbursement' ";

    if ($result_loan_disbursement = $con->query($sql_loan_disbursement)) {
      // Return the number of rows in result set
      $rowcount_disbursement = $result_loan_disbursement->num_rows;
    }

    // Loan Status Disbursement   end




    //Ready for review Start

    $sql_ready_fr_review = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Ready for review' ";

    if ($result_ready_fr_review = $con->query($sql_ready_fr_review)) {
      // Return the number of rows in result set
      $rowcount_ready_fr_review = $result_ready_fr_review->num_rows;
      // printf($rowcount_ready_fr_review);
    }

    // Ready for review   end



    //Info Needed Start

    $sql_inf_needed = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Info Needed' ";

    if ($result_inf_needed = $con->query($sql_inf_needed)) {
      // Return the number of rows in result set
      $rowcount_inf_needed = $result_inf_needed->num_rows;
      // printf($rowcount_inf_needed);
    }

    // Info Needed   end


    //Review Payday CA Start

    $sql_rev_payday_ca = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Review Payday CA' ";

    if ($result_rev_payday_ca = $con->query($sql_rev_payday_ca)) {
      // Return the number of rows in result set
      $rowcount_rev_payday_ca = $result_rev_payday_ca->num_rows;
      // printf($rowcount_rev_payday_ca);
    }

    //Review Payday CA  end


    //DL/Bank Payday CA Start

    $sql_dl_bank_ca = "SELECT first_name,email FROM fnd_user_profile where application_status = 'DL/Bank Payday CA' ";

    if ($result_dl_bank_ca = $con->query($sql_dl_bank_ca)) {
      // Return the number of rows in result set
      $rowcount_dl_bank_ca = $result_dl_bank_ca->num_rows;
      // printf($rowcount_dl_bank_ca);
    }

    // DL/Bank Payday CA end



    //DL/Bank Installment CA Start

    $sql_dl_bank_install_ca = "SELECT * FROM fnd_user_profile where application_status = 'DL/Bank Installment CA' ";

    if ($result_dl_bank_install_ca = $con->query($sql_dl_bank_install_ca)) {
      // Return the number of rows in result set
      $rowcount_dl_bank_install_ca = $result_dl_bank_install_ca->num_rows;
      // printf($rowcount_dl_bank_install_ca);
    }

    // DL/Bank Installment CA end


    //DL/Bank Installment NV Start

    $sql_dl_bank_install_nv = "SELECT first_name,email FROM fnd_user_profile where application_status = 'DL/Bank Installment NV' ";

    if ($result_dl_bank_install_nv = $con->query($sql_dl_bank_install_nv)) {
      // Return the number of rows in result set
      $rowcount_dl_bank_install_nv = $result_dl_bank_install_nv->num_rows;
      // printf($rowcount_dl_bank_install_nv);
    }

    // DL/Bank Installment NV end


    // DL/Bank Installment AZ Start

    $sql_dl_bank_install_az = "SELECT first_name,email FROM fnd_user_profile where application_status = 'DL/Bank Installment AZ' ";

    if ($result_dl_bank_install_az = $con->query($sql_dl_bank_install_az)) {
      // Return the number of rows in result set
      $rowcount_dl_bank_install_az = $result_dl_bank_install_az->num_rows;
      // printf($rowcount_dl_bank_install_az);
    }

    // DL/Bank Installment AZ end





    //Approved Payday NV Start

    $sql_aprovd_paydy_nv = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Payday NV' ";

    if ($result_aprovd_paydy_nv = $con->query($sql_aprovd_paydy_nv)) {
      // Return the number of rows in result set
      $rowcount_aprovd_paydy_nv = $result_aprovd_paydy_nv->num_rows;
      // printf($rowcount_aprovd_paydy_nv);
    }

    // Approved Payday NV end






    //Approved Installment NV Start

    $sql_aprovd_install_nv = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Installment NV' ";

    if ($result_install_paydy_nv = $con->query($sql_aprovd_install_nv)) {
      // Return the number of rows in result set
      $rowcount_install_paydy_nv = $result_install_paydy_nv->num_rows;
      // printf($rowcount_install_paydy_nv);
    }

    // Approved Installment NV end


    //Approved Installment CA Start

    $sql_aprovd_install_ca = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Installment CA' ";

    if ($result_install_paydy_ca = $con->query($sql_aprovd_install_ca)) {
      // Return the number of rows in result set
      $rowcount_aprovd_intall_ca = $result_install_paydy_ca->num_rows;
      // printf($rowcount_aprovd_intall_ca);
    }

    // Approved Installment CA end

    //Review CA Start

    $sql_rev_ca = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Review Installment CA' ";

    if ($result_rev_ca = $con->query($sql_rev_ca)) {
      // Return the number of rows in result set
      $rowcount_rev_ca = $result_rev_ca->num_rows;
      // printf($rowcount_rev_ca);
    }

    // Review CA end




    //Approved Installment AZ Start

    $sql_aprovd_install_az = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Installment AZ' ";

    if ($result_install_paydy_az = $con->query($sql_aprovd_install_az)) {
      // Return the number of rows in result set
      $rowcount_install_paydy_az = $result_install_paydy_az->num_rows;
      // printf($rowcount_install_paydy_az);
    }

    // Approved Installment AZ end


    //Review Installment AZ Start

    $sql_rev_install_az = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Review Installment AZ' ";

    if ($resul_rev_install_az = $con->query($sql_rev_install_az)) {
      // Return the number of rows in result set
      $rowcount_rev_install_az = $resul_rev_install_az->num_rows;
      // printf($rowcount_rev_install_az);
    }

    // Review Installment AZ end


    //Review Installment nv Start

    $sql_rev_install_nv = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Review Installment NV' ";

    if ($resul_rev_install_nv = $con->query($sql_rev_install_nv)) {
      // Return the number of rows in result set
      $rowcount_rev_install_nv = $resul_rev_install_nv->num_rows;
      // printf($rowcount_rev_install_nv);
    }

    // Review Installment AZ end




    //Approved Commercial CA Start

    $sql_aprovd_comercial_ca = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Commercial CA' ";

    if ($result_aprovd_comercial_ca = $con->query($sql_aprovd_comercial_ca)) {
      // Return the number of rows in result set
      $rowcount_aprovd_comercial_ca = $result_aprovd_comercial_ca->num_rows;
      // printf($rowcount_aprovd_comercial_ca);
    }

    // Approved Commercial NV end

    //Approved Payday CA Start

    $sql_aprovd_paydy_ca = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Payday CA' ";

    if ($result_aprovd_paydy_ca = $con->query($sql_aprovd_paydy_ca)) {
      // Return the number of rows in result set
      $rowcount_aprovd_paydy_ca = $result_aprovd_paydy_ca->num_rows;
      // printf($rowcount_aprovd_paydy_ca);
    }

    // Approved Payday CA end



    //Approved Payday NV Start

    $sql_aprovd_paydy_nv = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Payday NV' ";

    if ($result_aprovd_paydy_nv = $con->query($sql_aprovd_paydy_nv)) {
      // Return the number of rows in result set
      $rowcount_aprovd_paydy_nv = $result_aprovd_paydy_nv->num_rows;
      // printf($rowcount_aprovd_paydy_nv);
    }

    // Approved Payday NV end




    //Review Payday NV Start

    $sql_rev_payday_nv = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Review Payday NV' ";

    if ($result_rev_payday_nv = $con->query($sql_rev_payday_nv)) {
      // Return the number of rows in result set
      $rowcount_rev_payday_nv = $result_rev_payday_nv->num_rows;
      // printf($rowcount_rev_payday_nv);
    }

    //Review Payday NV  end


    //DL/Bank Payday NV Start

    $sql_dl_bank_nv = "SELECT first_name,email FROM fnd_user_profile where application_status = 'DL/Bank Payday NV' ";

    if ($result_dl_bank_nv = $con->query($sql_dl_bank_nv)) {
      // Return the number of rows in result set
      $rowcount_dl_bank_nv = $result_dl_bank_nv->num_rows;
      // printf($rowcount_dl_bank_nv);
    }

    // DL/Bank Payday NV end









    //Approved Payday IL Start

    $sql_aprovd_paydy_il = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Payday IL' ";

    if ($result_aprovd_paydy_il = $con->query($sql_aprovd_paydy_il)) {
      // Return the number of rows in result set
      $rowcount_aprovd_paydy_il = $result_aprovd_paydy_il->num_rows;
      // printf($rowcount_aprovd_paydy_nv);
    }

    // Approved Payday IL end




    //Review Payday IL Start

    $sql_rev_payday_il = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Review Payday IL' ";

    if ($result_rev_payday_il = $con->query($sql_rev_payday_il)) {
      // Return the number of rows in result set
      $rowcount_rev_payday_il = $result_rev_payday_il->num_rows;
      // printf($rowcount_rev_payday_il);
    }

    //Review Payday IL  end


    //DL/Bank Payday NV Start

    $sql_dl_bank_il = "SELECT first_name,email FROM fnd_user_profile where application_status = 'DL/Bank Payday IL' ";

    if ($result_dl_bank_il = $con->query($sql_dl_bank_il)) {
      // Return the number of rows in result set
      $rowcount_dl_bank_il = $result_dl_bank_il->num_rows;
      // printf($rowcount_dl_bank_il);
    }

    // DL/Bank Payday NV end


    //******************************************************************************************************************************************************8


    //Approved Payday IL Start

    $sql_aprovd_install_il = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Approved Installment IL' ";

    if ($result_aprovd_install_il = $con->query($sql_aprovd_install_il)) {
      // Return the number of rows in result set
      $rowcount_aprovd_install_il = $result_aprovd_install_il->num_rows;
      // printf($rowcount_aprovd_install_nv);
    }

    // Approved Payday IL end




    //Review Payday IL Start

    $sql_rev_install_il = "SELECT first_name,email FROM fnd_user_profile where application_status = 'Review Installment IL' ";

    if ($result_rev_install_il = $con->query($sql_rev_install_il)) {
      // Return the number of rows in result set
      $rowcount_rev_install_il = $result_rev_install_il->num_rows;
      // printf($rowcount_rev_install_il);
    }

    //Review Payday IL  end


    //DL/Bank Payday NV Start

    $sql_dl_bank_install_il = "SELECT first_name,email FROM fnd_user_profile where application_status = 'DL/Bank Installment IL' ";

    if ($result_dl_bank_install_il = $con->query($sql_dl_bank_install_il)) {
      // Return the number of rows in result set
      $rowcount_dl_bank_install_il = $result_dl_bank_install_il->num_rows;
      // printf($rowcount_dl_bank_install_il);
    }

    // DL/Bank Payday NV end



    //*******************************************************************************************************************************************************

    /* keep shared SQL connection */
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
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=Approved+Payday+CA&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Approved Payday CA :<b style="color:red"> <?php echo $rowcount_aprovd_paydy_ca; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=Review+Payday+CA&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Review Payday CA :<b style="color:red"> <?php echo $rowcount_rev_payday_ca; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=DL/Bank+Payday+CA&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">DL/Bank Payday CA :<b style="color:red"> <?php echo $rowcount_dl_bank_ca; ?></b></a></p>
      </div>
      <!-- <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=Approved+Payday+NV&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Approved Payday NV :<b style="color:red"> <?php echo $rowcount_aprovd_paydy_nv; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=Review+Payday+NV&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Review Payday NV :<b style="color:red"> <?php echo $rowcount_rev_payday_nv; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=DL/Bank+Payday+NV&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">DL/Bank Payday NV :<b style="color:red"> <?php echo $rowcount_dl_bank_nv; ?></b></a></p>
      </div>

      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=Approved+Payday+IL&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Approved Payday IL :<b style="color:red"> <?php echo $rowcount_aprovd_paydy_il; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=Review+Payday+IL&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Review Payday IL :<b style="color:red"> <?php echo $rowcount_rev_payday_il; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=DL/Bank+Payday+IL&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">DL/Bank Payday IL :<b style="color:red"> <?php echo $rowcount_dl_bank_il; ?></b></a></p>
      </div> -->
<!-- 
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=Approved+Installment+CA&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Approved Commercial CA :<b style="color:red"> <?php echo $rowcount_aprovd_intall_ca; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=Review+Installment+CA&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Review Commercial CA :<b style="color:red"> <?php echo $rowcount_rev_ca; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=DL/Bank+Installment+CA&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">DL/Bank Commercial CA :<b style="color:red"> <?php echo $rowcount_dl_bank_install_ca; ?></b></a></p>
      </div>


      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=Approved+Installment+AZ&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Approved Installment AZ :<b style="color:red"> <?php echo $rowcount_install_paydy_az; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=Review+Installment+AZ&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Review Installment AZ :<b style="color:red"> <?php echo $rowcount_rev_install_az; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=DL/Bank+Installment+AZ&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">DL/Bank Installment AZ :<b style="color:red"> <?php echo $rowcount_dl_bank_install_az; ?></b></a></p>
      </div>

      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=Approved+Installment+IL&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Approved Installment IL :<b style="color:red"> <?php echo $rowcount_aprovd_install_il; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=Review+Installment+IL&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Review Installment IL :<b style="color:red"> <?php echo $rowcount_rev_install_il; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=DL/Bank+Installment+IL&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">DL/Bank Installment IL :<b style="color:red"> <?php echo $rowcount_dl_bank_install_il; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=Approved+Installment+NV&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Approved Installment NV :<b style="color:red"> <?php echo $rowcount_install_paydy_nv; ?></b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=Review+Installment+NV&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">Review Installment NV : <b style="color:red"> <?php echo $rowcount_rev_install_nv; ?> </b></a></p>
      </div>
      <div class="col-lg-4">
        <p style="color:black;font-weight: bold"><a href="view_all_customer.php?status=DL/Bank+Installment+NV&website=All&state=All&loan_type=All&keyword=&from_date=&to_date=&search=">DL/Bank Installment NV : <b style="color:red"> <?php echo $rowcount_dl_bank_install_nv; ?> </b></a></p>
      </div> -->

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

    <div class="row wrapper">
        <div class="col-lg-12">
        <?php if ($jpgraph_loaded) {
          $data = array($rowcount_pending,$rowcount_loan_active,$rowcount_loan_past,$rowcount_loan_plan,$rowcount_loan_charge,
                        $rowcount_chargeback,$rowcount_disbursement,$rowcount_loan_paid,$rowcount_promise,$rowcount_collections,$rowcount_closed,$rowcount_bankruptcy);

          $graph = new PieGraph(450,450);

          $theme_class= new VividTheme;
          $graph->SetTheme($theme_class);
          $graph->legend->Pos(0.5, 0.85, 'center', 'top');
          $graph->img->SetTransparent("white");
          $p1 = new PiePlot3D($data);
          $p1->SetLegends(array("Pending","Active","Past Due","Payment Plan","Chargeoff","Chargeback","Disbursement","Paid","Promise to Pay","Collections","Closed Account","Bankruptcy"));
          $graph->Add($p1);

          $p1->ShowBorder();
          $p1->SetColor('black');
          $p1->ExplodeSlice(1);
          @unlink("test.jpg");
          $graph->Stroke("test.jpg");
          ?>
          <img src="test.jpg">
        <?php } ?>
        </div>
      </div>

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

  <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
  <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>

</html>



