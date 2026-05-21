<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include_once 'dbconnect.php';
include_once 'dbconfig.php';

if (!isset($_SESSION['userSession'])) {
   header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=" . $_SESSION['userSession']);
$userRow = $query->fetch_array();
$u_id = $userRow['user_id'];
//echo $u_id;
$u_access_id = $userRow['access_id'];
if ($u_access_id == '0') {
   echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
} else {
   $DBcon->close();

?>


   <?php function generateRandomString($length = 8)
   {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
         $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
   }
   $email_key = generateRandomString();;
   // echo $email_key;



   $id_fnd = $_GET['fnd_id'];

   $sql_fetch_fnd = $con->query("select * from fnd_user_profile where user_fnd_id= '$id_fnd'");

   $first_name = '';
   $last_name = '';
   while ($row_fetch_fnd = $sql_fetch_fnd->fetch_array()) {

      $email = $row_fetch_fnd['email'];

      $id_photo = $row_fetch_fnd['id_photo'];
      // echo "<br><br><br><br><br>".$id_photo;
      $bank_front = $row_fetch_fnd['bank_front'];
      $bank_back = $row_fetch_fnd['bank_back'];
      $void_img = $row_fetch_fnd['void_img'];
      $mobile_number = $row_fetch_fnd['mobile_number'];
      $first_name = $row_fetch_fnd['first_name'];
      $last_name = $row_fetch_fnd['last_name'];

   }



   $sql_fetch_loan = $con->query("select * from tbl_commercial_loan where user_fnd_id= '$id_fnd'");
   $loan_id = "";
   while ($row_fetch_loan = $sql_fetch_loan->fetch_array()) {

      $loan_id = $row_fetch_loan['loan_create_id'];
      $previous_amount_loan = $row_fetch_loan['previous_amount_loan'];
   }
   //echo "loan id:".$loan_id;
   $fndd_id = $id_fnd;
   // echo "loan id:".$fndd_id;
   $state = $_GET['state'];



   /**
    * Build URLs that work on both production (ofsca.com) and local dev (localhost:8080).
    * SCRIPT_NAME on prod:    /loanportal/ls_software/admin/commercial_initial_setup.php
    * SCRIPT_NAME on local:   /ls_software/admin/commercial_initial_setup.php
    * So chopping at "/ls_software/" gives us the correct base path either way.
    */
   if (!function_exists('app_base_url')) {
       function app_base_url() {
           $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
           $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
           $script = $_SERVER['SCRIPT_NAME'] ?? '';
           $idx = strpos($script, '/ls_software/');
           $path = ($idx !== false) ? substr($script, 0, $idx) : '';
           return $scheme . '://' . $host . $path . '/';
       }
   }

   $azrizona_message = '../../signature_commercial_loan/files/contract_pdf.php?id=' . $email_key;
   $azrizona_email   = app_base_url() . 'signature_commercial_loan/completed/index.php?id=' . $email_key;






   //CUSTOMER EMAIL STARTS

   $to_email = $email;
   $subject = 'Contract';
   $message = $azrizona_message;
   $message_email = $azrizona_email;
   $headers = 'From: support@ofsca.com';
   //mail($to_email,$subject,$message,$headers);

   //CUSTOMER EMAIL ENDS

   //echo "loan id:".$loan_id;


   // Fetch an admin email for the contract notification. Grab only what we need
   // instead of SELECT * FROM tbl_users.
   $email_admin = '';
   $sql_fetch_user = $con->query("SELECT email FROM tbl_users WHERE access_id <> '0' ORDER BY user_id ASC LIMIT 1");
   if ($sql_fetch_user && ($row_fetch_user = $sql_fetch_user->fetch_array())) {
      $email_admin = $row_fetch_user['email'];
   }

   // ADMIN EMAIL
   // NOTE: The mail() call previously ran *unconditionally on every GET*, even
   // though the subject is "A New Customer Has Signed The Contract". On this
   // host mail() resolves to localhost:25 (no SMTP listener) and blocks for the
   // full TCP connect timeout — about 1.5s per page load. It now only fires on
   // a real POST submit below, after the loan has been saved.
   $to_email_admin = $email_admin;
   $subject_admin  = 'A New Customer Has Signed The Contract';
   $message_admin  = $azrizona_email;
   $headers_admin  = 'From: support@ofsca.com';
   ?>

   <?php

   //echo "loan id:".$loan_id;
   //echo "Fnd id:".$fndd_id;

   if (isset($_POST['btttn-submit'])) {

      $type_id = $_POST['type_id'];
      $type_card = $_POST['type_card'];
      $card_number = $_POST['card_number'];
      //$card_exp_date=$_POST['card_exp_date'];

      $expiry_year_card = $_POST['expiry_year_card'];
      $expiry_month_card = $_POST['expiry_month_card'];
      $card_exp_date = $expiry_month_card . "/" . $expiry_year_card;

      $bank_name = $_POST['bank_name'];
      $routing_number = $_POST['routing_number'];
      $account_number = $_POST['account_number'];
      $cvv_number = $_POST['cvv_number'];

      $sourcee = $_POST['bg_idd'];
      $portfolio_type = $_POST['portfolio_type'];
      $secondary_portfolio = $_POST['secondary_portfolio'];
      $contract_template = $_POST['contract_template'] ?? 'unsecured_2024_09_01';
      $loan_create_idd = $_POST['loan_create_idd'];
      $principal_amountt = $_POST['principal_amountt'];
      $interestt = $_POST['loan_interest'];
      $yearss = $_POST['yearss'];
      $late_feee = $_POST['late_feee'];
      $originationn = $_POST['contract_feee'];
      $installment_plann = $_POST['installment_plann'];
      $total_paymentss = $_POST['total_paymentss'];
      $contract_datee = $_POST['contract_datee'];
      $payment_datee = $_POST['payment_datee'];
      $first_payment = $_POST['first_payment'];
      $last_payment = $_POST['last_payment'];
      $daily_interest = $_GET['daily_interest'];
      $apr = $_GET['anual_pr'];
      $daily_interest = "";      
      






      $date = date('Y-m-d H:i:s');

      $imgFile = $_FILES['file_image']['name'];
      $tmp_dir = $_FILES['file_image']['tmp_name'];
      $imgSize = $_FILES['file_image']['size'];

      $imgFilee = $_FILES['imageee']['name'];
      $tmp_dirr = $_FILES['imageee']['tmp_name'];
      $imgSizee = $_FILES['imageee']['size'];

      $imgFileee = $_FILES['imageeee']['name'];
      $tmp_dirrr = $_FILES['imageeee']['tmp_name'];
      $imgSizeee = $_FILES['imageeee']['size'];

      $imgFileeee = $_FILES['imageeeee']['name'];
      $tmp_dirrrr = $_FILES['imageeeee']['tmp_name'];
      $imgSizeeee = $_FILES['imageeeee']['size'];

      $final_File = "";
      $final_Filee = "";
      $final_Fileee = "";
      $final_Fileeee = "";


      if (isset($_POST['txt_image'])) {
         $final_File = $_POST['txt_image'];
         $final_File = str_replace(" ", "", "$final_File");
      } else if (isset($_FILES['file_image'])) {
         // Upload Picture of ID Starts

         $upload_dir = '../dl_client_files/photo_id/'; // upload directory

         $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

         // valid image extensions
         $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

         // rename uploading image
         $userpic = rand(1000, 1000000) . "." . $imgExt;
         $final_File  = $userpic;

         if ($imgSize > 0000000) {
            // Nothing
         } else {
            $final_File = "";
         }
         // allow valid image file formats
         if (in_array($imgExt, $valid_extensions)) {
            // Check file size '5MB'

            if ($imgSize < 5000000) {
               move_uploaded_file($tmp_dir, $upload_dir . $userpic);
            } else {
               $errMSG = "Sorry, your file is too large.";
            }
         } else {
            $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
         }


         // Upload Picture of ID Ends        

      }


      if (isset($_POST['txt_file_bf'])) {
         $final_Filee = $_POST['txt_file_bf'];
         $final_Filee = str_replace(" ", "", "$final_Filee");
      } else if (isset($_FILES['imageee'])) {
         // Bank Card Front Image Start

         $upload_dirrr = '../dl_client_files/bank_front_image/'; // upload directory

         $imgExtt = strtolower(pathinfo($imgFilee, PATHINFO_EXTENSION)); // get image extension

         // valid image extensions
         $valid_extensionss = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

         // rename uploading image
         $userpicc = rand(1000, 1000000) . "." . $imgExtt;
         $final_Filee = $userpicc;
         if ($imgSizee > 0000000) {
            // Nothing
         } else {
            $final_Filee = "";
         }
         // allow valid image file formats
         if (in_array($imgExtt, $valid_extensionss)) {
            // Check file size '5MB'
            if ($imgSizee < 5000000) {
               move_uploaded_file($tmp_dirr, $upload_dirrr . $userpicc);
            } else {
               $errMSG = "Sorry, your file is too large.";
            }
         } else {
            $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
         }


         // Bank Card Front Image End
      }


      if (isset($_POST['txt_file_bb'])) {
         $final_Fileee = $_POST['txt_file_bb'];
         $final_Fileee = str_replace(" ", "", "$final_Fileee");
      } else if (isset($_FILES['imageeee'])) {
         // Bank Card Back Image Start

         $upload_dirrrr = '../dl_client_files/bank_back_image/'; // upload directory

         $imgExtt = strtolower(pathinfo($imgFileee, PATHINFO_EXTENSION)); // get image extension

         // valid image extensions
         $valid_extensionss = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

         // rename uploading image
         $userpiccc = rand(1000, 1000000) . "." . $imgExtt;
         $final_Fileee = $userpiccc;
         if ($imgSizeee > 0000000) {
            // Nothing
         } else {
            $final_Fileee = "";
         }
         // allow valid image file formats
         if (in_array($imgExtt, $valid_extensionss)) {
            // Check file size '5MB'
            if ($imgSizeee < 5000000) {
               move_uploaded_file($tmp_dirrr, $upload_dirrrr . $userpiccc);
            } else {
               $errMSG = "Sorry, your file is too large.";
            }
         } else {
            $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
         }


         // Bank Card Back Image End
      }



      if (isset($_POST['txt_file_vi'])) {
         $final_Fileeee = $_POST['txt_file_vi'];
         $final_Fileeee = str_replace(" ", "", "$final_Fileeee");
         //echo"<br><br><br><br>".$final_Fileeee;
      } else if (isset($_FILES['imageeeee'])) {

         // Void Check Image Start

         $upload_dirrrrr = '../dl_client_files/void_img/'; // upload directory

         $imgExtt = strtolower(pathinfo($imgFileeee, PATHINFO_EXTENSION)); // get image extension

         // valid image extensions
         $valid_extensionss = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

         // rename uploading image
         $userpicccc = rand(1000, 1000000) . "." . $imgExtt;
         $final_Fileeee = $userpicccc;
         if ($imgSizeeee > 0000000) {
            // Nothing
         } else {
            $final_Fileeee = "";
         }
         // allow valid image file formats
         if (in_array($imgExtt, $valid_extensionss)) {
            // Check file size '5MB'
            if ($imgSizeeee < 5000000) {
               move_uploaded_file($tmp_dirrrr, $upload_dirrrrr . $userpicccc);
            } else {
               $errMSG = "Sorry, your file is too large.";
            }
         } else {
            $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
         }


         // Void Check Image End

      }

      $query_in  = "INSERT INTO commercial_loan_initial_banking (loan_id,user_fnd_id,type_of_id,pic_of_id,type_of_card,card_number,card_exp_date,bank_front_pic,bank_back_pic,bank_name,routing_number,account_number,void_check_pic,cvv_number,creation_date,update_date,created_by,email_key,sign_status,update_by)  VALUES ('$loan_create_idd','$fndd_id','$type_id','$final_File','$type_card','$card_number','$card_exp_date','$final_Filee','$final_Fileee','$bank_name','$routing_number','$account_number','$final_Fileeee','$cvv_number','$date','$date','$u_id','$email_key','0','$u_id')";
      $result_in = $con->query($query_in);
      if ($result_in) {
         //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
      } else {
         echo "<h3> Error Inserting Data </h3>";
         echo $query_in;
         exit;
      }

      switch ($installment_plann) {
         case "Weekly":
            $number_n = 52;
            break;
         case "Bi-Weekly":
            $number_n = 26;
            break;
         case "Monthly":
            $number_n = 12;
            break;
         default:
            $number_n = 52;
            break;
      }

      //$anual_pr = $daily_interest * $number_n;
      // $anual_pr = number_format($apr, 2);
      $anual_pr = $apr;
      $in_hand = $_GET['in_hand'];
      
   
      $query  = "INSERT INTO `tbl_commercial_loan`(`user_fnd_id`, `bg_id`,`portfolio_type`,`secondary_portfolio`,`contract_template`,`previous_amount_loan`, `amount_of_loan`, `loan_interest`, `years`, `late_fee`, `contract_fee`, `installment_plan`, `total_payments`, `principal_amount`, `contract_date`, `payment_date`, `creation_date`, `created_by`, `loan_create_id`, `loan_status`, `apr`,`state`,`first_payment`,`last_payment`)  VALUES ('$fndd_id','$sourcee','$portfolio_type','$secondary_portfolio','$contract_template','$in_hand','$principal_amountt','$interestt','$yearss','$late_feee','$originationn','$installment_plann','$total_paymentss','$principal_amountt','$contract_datee','$payment_datee','$date','$u_id','$loan_create_idd','Active','$anual_pr','$state','$first_payment','$last_payment')";

    //   $query  = "INSERT INTO `tbl_commercial_loan`(`user_fnd_id`, `bg_id`,`secondary_portfolio`,`previous_amount_loan`, `amount_of_loan`, `loan_interest`, `years`, `late_fee`, `contract_fee`, `installment_plan`, `total_payments`, `principal_amount`, `contract_date`, `payment_date`, `creation_date`, `created_by`, `loan_create_id`, `loan_status`, `apr`,`state`,`first_payment`,`last_payment`)  VALUES ('$fndd_id','$sourcee','$secondary_portfolio','$in_hand','$principal_amountt','$interestt','$yearss','$late_feee','$originationn','$installment_plann','$total_paymentss','$principal_amountt','$contract_datee','$payment_datee','$date','$u_id','$loan_create_idd','Active','$anual_pr','$state','$first_payment','$last_payment')";
      $result = $con->query($query);
      if ($result) {
         //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
      } else {
         echo "<h3> Error Inserting Data </h3>";
         echo $query;
         exit;
      }

      //Add to other fees//
      $con->query("INSERT INTO tbl_lists (kind, item) select 'Other Fee', 'Origination Fee' from tbl_lists where not exists( select * from tbl_lists where kind='Other Fee' and item='Origination Fee')");

      $sql = $con->query("select tbl_lists_id from tbl_lists where kind='Other Fee' and item='Origination Fee'");
  
      while ($row = $sql->fetch_array()) {
          $kind = $row['tbl_lists_id'];
      }

      $action_query = "INSERT INTO tbl_other_fees (tbl_other_fees_id, kind_fee, user_fnd_id, loan_created_id, amount_fee, amount_fee_paid) VALUES (NULL, '$kind', '$fndd_id', '$loan_create_idd', '$originationn', 0)";
      $con->query($action_query);



      //=====================//

      $con->query("UPDATE fnd_user_profile SET id_photo ='$final_File', bank_front='$final_Filee', bank_back='$final_Fileee', void_img='$final_Fileeee'  where user_fnd_id ='$fndd_id'");

      $sql_bank_info = $con->query("select count(bank_id) as count, bank_id from tbl_bank_info where usr_fnd_id= '$fndd_id' and bank_name='$bank_name ' and account_number='$account_number' and routing_number='$routing_number'");

      while ($row = $sql_bank_info->fetch_array()) {
         $count = $row['count'];
         $bank_id = $row['bank_id'];
      }


      if ($count == 0) {
         $action_query = "INSERT INTO `tbl_bank_info` (`usr_fnd_id`, `bank_name`, `account_number`, `routing_number`, `is_active`) VALUES ('$fndd_id', '$bank_name', '$account_number', '$routing_number', '1')";
         $con->query($action_query);
         $bank_id = $con->insert_id();
      }

      $sql = $con->query("select count(id) as count from tbl_bank_cards where user_fnd_id= '$fndd_id' and type_of_id='$type_id' and  type_of_card='$type_card' and card_number='$card_number' and card_exp_date='$card_exp_date' and cvv_number='$cvv_number'");

      while ($row = $sql->fetch_array()) {
         $count = $row['count'];
      }

      if ($count == 0) {
         $action_query = "INSERT INTO `tbl_bank_cards` (`bank_id`, `user_fnd_id`, `type_of_id`, `type_of_card`, `card_number`, `card_exp_date`,`cvv_number`, `is_active`) VALUES ('$bank_id', '$fndd_id', '$type_id','$type_card', '$card_number', '$card_exp_date','$cvv_number', '1')";
         $con->query($action_query);
      }





      if(isset($_GET['prev_loan_id'])){
         $previous_loan_id =  $_GET['prev_loan_id'];
         $sql_fetch_loan = $con->query("select previous_amount_loan from tbl_commercial_loan where loan_create_id='$loan_create_idd'");
         while ($row_fetch_loan = $sql_fetch_loan->fetch_array()) {
            $previous_amount_loan = $row_fetch_loan['previous_amount_loan'];
         }

         $sql = $con->query("select late_fee,amount_of_loan,loan_interest from tbl_commercial_loan where loan_create_id= '$previous_loan_id'");

         while ($row = $sql->fetch_array()) {
             $late_fee = $row['late_fee'];
             $amount_of_loan = $row['amount_of_loan'];
             $loan_interest = $row['loan_interest'];
         }

         $loan_payment = 0;
         $query_payment = $con->query("SELECT SUM(payment_amount) AS value_sum FROM commercial_loan_transaction where loan_create_id= '$previous_loan_id'");
         while ($row_payment = $query_payment->fetch_array()) {
           $loan_payment = $row_payment['value_sum'];
         }

         $in_hand = str_replace(',','',number_format(((float)($amount_of_loan + $loan_interest - $loan_payment)), 2, '.', ','));

         $unpaid_late_fee = 0;
         $query_payment = $con->query("SELECT sum($late_fee - paid_late_fee) as unpaid FROM tbl_commercial_loan_installments WHERE dpd >= 10 and loan_create_id = '$previous_loan_id' and ($late_fee - paid_late_fee) > 0 ");
         while ($row_payment = $query_payment->fetch_array()) {
           $unpaid_late_fee = $row_payment['unpaid'] == null ? 0 : $row_payment['unpaid'];
         }

         $unpaid_other_fee = 0;
         $query_payment = $con->query("SELECT sum(amount_fee - amount_fee_paid) as unpaid FROM tbl_other_fees WHERE loan_created_id = $previous_loan_id ");
         while ($row_payment = $query_payment->fetch_array()) {
           $unpaid_other_fee = $row_payment['unpaid'] == null ? 0 : $row_payment['unpaid'];
         }
         // $sql_installment = $con->query("SELECT SUM(late_fee) as sum_late_fee FROM commercial_loan_transaction where loan_create_id= '$previous_loan_id'");
         // $sum_late_fee = 0;
         // while ($row_installment = $sql_installment->fetch_array()) {
         //     $sum_late_fee = $row_installment['sum_late_fee'];
         // }

         $amount_without_fee = $previous_amount_loan - $unpaid_late_fee - $unpaid_other_fee;
         $amount_without_fee = $previous_amount_loan >= $in_hand ? $in_hand : $previous_amount_loan;

         $sql_installment = $con->query("SELECT *  FROM tbl_commercial_loan_installments where loan_create_id= '$previous_loan_id' and status=0 order by id asc");
         while ($row_installment = $sql_installment->fetch_array()) {
            $payment = $row_installment['payment'];
            if($previous_amount_loan == 0 || $amount_without_fee <= 0){ // status 4 = "Credit"
               $con->query("UPDATE tbl_commercial_loan_installments SET paid_date='$contract_datee', paid amount='0', credit_amount = '$payment', status=4, paid_by='$u_id' where loan_create_id = '$previous_loan_id' and status = 0 ");
               break;
            }

           
            $paid_amount = $row_installment['paid amount'];
            $id =  $row_installment['id'];

            $real_payment = $payment - $paid_amount;
            $amount_without_fee -= $real_payment;

            $refinanced = $real_payment;
            $credit = 0;

            // "Paid Ref"
            if($amount_without_fee < 0){
               $refinanced= $real_payment+$amount_without_fee;
               $credit = $real_payment - $refinanced;
               $amount_without_fee = 0;
            }

            $status = $paid_amount+$refinanced >= $credit ? 3 : 4; 

            $con->query("UPDATE tbl_commercial_loan_installments SET paid amount =paid amount + $refinanced, refinanced_amount = '$refinanced', credit_amount = '$credit',  status='$status', paid_date='$contract_datee',  paid_by='$u_id' where id= '$id'");
            
        }

        $con->query("UPDATE tbl_commercial_loan SET loan_status='Paid' where loan_create_id = '$previous_loan_id'");

      }

   ?>

















      <?php
      // Notify admin that the loan setup was completed. Fires only on real POST
      // submit — not on every GET, which was the cause of the 1.5s page-load stall.
      // Suppress the @ warning so a failed SMTP doesn't crash the redirect below.
      if (!empty($to_email_admin)) {
         @mail($to_email_admin, $subject_admin, $message_admin, $headers_admin);
      }
      ?>
      <script type="text/javascript">
         window.location.href =
            'customer_email_message_personal_loan.php?emaill=<?php echo $email; ?>&mobile_number=<?php echo $mobile_number; ?>&link=<?php echo $message; ?>&email_link=<?php echo $message_email; ?>&user_fnd_id=<?php echo $id_fnd;  ?>';
      </script>
   <?php
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
      <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
      <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
      <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
      <style>
         /* Selected-row highlight used by the AJAX tables */
         .table-success tbody+tbody,
         .table-success td,
         .table-success th,
         .table-success thead th { border-color: #8fd19e; }
         .table-success, .table-success>td, .table-success>th { background-color: #c3e6cb; }

         /* ==== Scoped redesign styles ==== */
         section.wrapper, .cis-wrapper { padding: 0 20px 40px; max-width: 1400px; margin: 100px auto 40px; }

         .cis-toolbar {
             display: flex; justify-content: space-between; align-items: center;
             margin-bottom: 16px; padding-bottom: 10px; border-bottom: 1px solid #eee;
         }
         .cis-page-title { font-size: 22px; font-weight: 600; color: #333; margin: 0; }
         .cis-page-title small { color: #888; font-weight: normal; }

         .cis-summary {
             background: #fff; border: 1px solid #e4e4e4; border-left: 4px solid #1E90FF;
             border-radius: 4px; padding: 14px 20px; margin-bottom: 18px;
             box-shadow: 0 1px 2px rgba(0,0,0,0.04);
         }
         .cis-summary p { margin: 4px 0; color: #555; font-size: 13px; }
         .cis-summary strong { display: block; color: #888; font-size: 11px; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 2px; font-weight: 600; }
         .cis-summary b { color: #222; font-weight: 600; }

         .cis-panel { margin-bottom: 14px; }
         .cis-panel .panel-heading { padding: 10px 15px; background-color: #fafafa; font-weight: 600; }
         .cis-panel .panel-body { padding: 16px; }

         .cis-field { margin-bottom: 14px; min-height: 72px; }
         .cis-field label {
             font-size: 12px; color: #555; font-weight: 600;
             text-transform: uppercase; letter-spacing: .3px; margin-bottom: 4px; display: block;
         }
         .cis-req { color: #d9534f; margin-left: 2px; }
         .cis-help { font-size: 11px; color: #888; margin-top: 4px; display: block; }
         .cis-uploaded { font-size: 12px; color: #5cb85c; font-weight: 600; margin-top: 4px; }
         .cis-uploaded a { color: #1976d2; margin-left: 8px; }

         .cis-exp-group { display: flex; gap: 10px; }
         .cis-exp-group select { flex: 1 1 auto; }

         .cis-action-bar {
             margin-top: 18px; padding: 14px 18px;
             background: #fafafa; border: 1px solid #e4e4e4; border-radius: 4px;
             text-align: right;
         }
         .cis-action-bar .btn { margin-left: 6px; }
         .cis-action-bar .btn-save {
             background: #1E90FF; border-color: #1E90FF; color: #fff;
             font-weight: 600; padding: 10px 26px;
         }
         .cis-action-bar .btn-save:hover { background: #1976c2; border-color: #1976c2; color: #fff; }

         /* Previously-saved bank/card section */
         .cis-prev { margin-top: 26px; }
         .cis-prev .panel-heading { display: flex; justify-content: space-between; align-items: center; }
         .cis-prev-hint { font-size: 11px; color: #888; font-weight: normal; }

         /* Neutralize global dark .row:hover from css/style1.css */
         section.wrapper .row, section.wrapper .row:hover,
         .cis-wrapper .row, .cis-wrapper .row:hover {
             background-color: transparent !important;
             height: auto !important; border-top: 0 !important; transition: none !important;
         }
      </style>
   </head>

   <body>

      <?php include('menu.php'); ?>

      <section class="wrapper cis-wrapper">

         <!-- Page toolbar -->
         <div class="cis-toolbar">
            <h3 class="cis-page-title">
               <span class="glyphicon glyphicon-pencil"></span>
               Initial Loan Setup
               <small>&nbsp;·&nbsp;<?php echo htmlspecialchars((string)trim($first_name . ' ' . $last_name)); ?> (#<?php echo htmlspecialchars((string)$id_fnd); ?>)</small>
            </h3>
            <a href="edit_customer.php?id=<?php echo urlencode((string)$id_fnd); ?>" class="btn btn-default">
               <span class="glyphicon glyphicon-arrow-left"></span> Back to customer
            </a>
         </div>

         <!-- Customer summary -->
         <div class="cis-summary">
            <div class="row">
               <div class="col-md-3"><p><strong>Name</strong><b><?php echo htmlspecialchars((string)trim($first_name . ' ' . $last_name)); ?></b></p></div>
               <div class="col-md-3"><p><strong>Phone</strong><b><?php echo htmlspecialchars((string)$mobile_number); ?></b></p></div>
               <div class="col-md-3"><p><strong>Email</strong><b><?php echo htmlspecialchars((string)$email); ?></b></p></div>
               <div class="col-md-3"><p><strong>Loan ID</strong><b><?php echo htmlspecialchars((string)$_GET['loan_create_id']); ?></b></p></div>
            </div>
         </div>

         <form action="" method="POST" enctype="multipart/form-data">

            <!-- Carry-through params from previous step -->
            <input type="hidden" name="emaill" value="<?php echo htmlspecialchars((string)$email); ?>">
            <input type="hidden" name="link" value="<?php echo htmlspecialchars((string)$message); ?>">
            <input type="hidden" name="name_id" value="<?php echo htmlspecialchars((string)$user_fnd_id); ?>">
            <input type="hidden" name="fnd_idd" id="idUserId" value="<?php echo htmlspecialchars((string)$_GET['fnd_id']); ?>">
            <input type="hidden" name="renew_loan" id="renewLoanId" value="<?php echo htmlspecialchars((string)$loan_id); ?>">
            <input type="hidden" name="bg_idd" value="<?php echo htmlspecialchars((string)$_GET['bg_id']); ?>">
            <input type="hidden" name="portfolio_type" value="<?php echo htmlspecialchars((string)$_GET['portfolio_type']); ?>">
            <input type="hidden" name="secondary_portfolio" value="<?php echo htmlspecialchars((string)$_GET['secondary_portfolio']); ?>">
            <input type="hidden" name="contract_template" value="<?php echo htmlspecialchars((string)($_GET['contract_template'] ?? 'unsecured_2024_09_01')); ?>">
            <input type="hidden" name="loan_create_idd" id="loanId" value="<?php echo htmlspecialchars((string)$_GET['loan_create_id']); ?>">
            <input type="hidden" name="principal_amountt" value="<?php echo htmlspecialchars((string)$_GET['principal_amount']); ?>">
            <input type="hidden" name="loan_interest" value="<?php echo htmlspecialchars((string)$_GET['loan_interest']); ?>">
            <input type="hidden" name="yearss" value="<?php echo htmlspecialchars((string)$_GET['years']); ?>">
            <input type="hidden" name="late_feee" value="<?php echo htmlspecialchars((string)$_GET['late_fee']); ?>">
            <input type="hidden" name="contract_feee" value="<?php echo htmlspecialchars((string)$_GET['contract_fee']); ?>">
            <input type="hidden" name="installment_plann" value="<?php echo htmlspecialchars((string)$_GET['installment_plan']); ?>">
            <input type="hidden" name="total_paymentss" value="<?php echo htmlspecialchars((string)$_GET['total_payments']); ?>">
            <input type="hidden" name="contract_datee" value="<?php echo htmlspecialchars((string)$_GET['contract_date']); ?>">
            <input type="hidden" name="payment_datee" value="<?php echo htmlspecialchars((string)$_GET['payment_date']); ?>">
            <input type="hidden" name="first_payment" value="<?php echo htmlspecialchars((string)$_GET['first_payment']); ?>">
            <input type="hidden" name="last_payment" value="<?php echo htmlspecialchars((string)$_GET['last_payment']); ?>">

            <!-- Panel 1: ID Documents -->
            <div class="panel panel-default cis-panel">
               <div class="panel-heading">
                  ID Document
                  <span class="cis-prev-hint pull-right">Customer identification</span>
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-6 cis-field">
                        <label for="type_id">Type of ID</label>
                        <select name="type_id" id="type_id" class="form-control">
                           <option value=""></option>
                           <option value="Drivers License">Driver's License</option>
                           <option value="State Personal ID">State Personal ID</option>
                           <option value="Matricula Consular ID">Matricula Consular ID</option>
                           <option value="Tribal ID">Tribal ID</option>
                           <option value="Passport">Passport</option>
                           <option value="Military ID">Military ID</option>
                           <option value="Other">Other</option>
                        </select>
                     </div>
                     <?php if (empty($id_photo)): ?>
                        <div class="col-md-6 cis-field">
                           <label>Upload Picture of ID</label>
                           <input type="file" name="file_image" class="form-control" accept="image/*">
                        </div>
                     <?php else: ?>
                        <div class="col-md-6 cis-field">
                           <label>Picture of ID</label>
                           <input type="hidden" name="txt_image" value="<?php echo htmlspecialchars((string)$id_photo); ?>">
                           <div class="cis-uploaded">
                              <span class="glyphicon glyphicon-ok-sign"></span> Already uploaded
                              <a href="/ls_software/dl_client_files/photo_id/<?php echo htmlspecialchars((string)$id_photo); ?>" target="_blank">View image</a>
                           </div>
                        </div>
                     <?php endif; ?>
                  </div>
               </div>
            </div>

            <!-- Panel 2: Card Information -->
            <div class="panel panel-default cis-panel">
               <div class="panel-heading">
                  Card Information
                  <span class="cis-prev-hint pull-right">Debit/credit card on file</span>
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-3 cis-field">
                        <label for="type_card">Type of Card</label>
                        <select name="type_card" id="type_card" class="form-control">
                           <option value=""></option>
                           <option value="Visa">Visa</option>
                           <option value="Master Card">Master Card</option>
                        </select>
                     </div>
                     <div class="col-md-4 cis-field">
                        <label for="card_number">Card Number</label>
                        <input type="text" name="card_number" id="card_number" class="form-control" maxlength="16"
                               placeholder="16 digits"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                     </div>
                     <div class="col-md-3 cis-field">
                        <label>Card Expiration</label>
                        <div class="cis-exp-group">
                           <select name="expiry_month_card" id="expiry_month_card" class="form-control">
                              <option value="">MM</option>
                              <?php
                              $months = ['01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec'];
                              foreach ($months as $k => $v) {
                                  echo '<option value="' . $k . '">' . $k . ' - ' . $v . '</option>';
                              }
                              ?>
                           </select>
                           <select name="expiry_year_card" id="expiry_year_card" class="form-control">
                              <option value="">YY</option>
                              <?php
                              $yy = (int)date('y');
                              for ($i = 0; $i <= 12; $i++) {
                                  $y = str_pad((string)($yy + $i), 2, '0', STR_PAD_LEFT);
                                  echo '<option value="' . $y . '">' . $y . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-2 cis-field">
                        <label for="cvv_number">CVV</label>
                        <input type="text" name="cvv_number" id="cvv_number" class="form-control" maxlength="4"
                               placeholder="3-4 digits"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                     </div>
                  </div>
                  <div class="row">
                     <?php if (empty($bank_front)): ?>
                        <div class="col-md-6 cis-field">
                           <label>Upload Bank Card Front</label>
                           <input type="file" name="imageee" class="form-control" accept="image/*">
                        </div>
                     <?php else: ?>
                        <?php $bank_front = str_replace(" ", "", (string)$bank_front); ?>
                        <div class="col-md-6 cis-field">
                           <label>Bank Card Front</label>
                           <input type="hidden" name="txt_file_bf" value="<?php echo htmlspecialchars($bank_front); ?>">
                           <div class="cis-uploaded">
                              <span class="glyphicon glyphicon-ok-sign"></span> Already uploaded
                              <a href="/ls_software/dl_client_files/bank_front_image/<?php echo htmlspecialchars($bank_front); ?>" target="_blank">View image</a>
                           </div>
                        </div>
                     <?php endif; ?>
                     <?php if (empty($bank_back)): ?>
                        <div class="col-md-6 cis-field">
                           <label>Upload Bank Card Back</label>
                           <input type="file" name="imageeee" class="form-control" accept="image/*">
                        </div>
                     <?php else: ?>
                        <?php $bank_back = str_replace(" ", "", (string)$bank_back); ?>
                        <div class="col-md-6 cis-field">
                           <label>Bank Card Back</label>
                           <input type="hidden" name="txt_file_bb" value="<?php echo htmlspecialchars($bank_back); ?>">
                           <div class="cis-uploaded">
                              <span class="glyphicon glyphicon-ok-sign"></span> Already uploaded
                              <a href="/ls_software/dl_client_files/bank_back_image/<?php echo htmlspecialchars($bank_back); ?>" target="_blank">View image</a>
                           </div>
                        </div>
                     <?php endif; ?>
                  </div>
               </div>
            </div>

            <!-- Panel 3: Bank Account -->
            <div class="panel panel-default cis-panel">
               <div class="panel-heading">
                  Bank Account
                  <span class="cis-prev-hint pull-right">Direct-deposit / ACH source</span>
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-4 cis-field">
                        <label for="bank_name">Bank Name</label>
                        <input list="banks" name="bank_name" id="bank_name" class="form-control" value="" placeholder="Start typing…">
                        <datalist id="banks">
                           <option value="Bank Of America">
                           <option value="Chase">
                           <option value="Wells Fargo">
                           <option value="Citi Bank">
                           <option value="US Bank">
                           <option value="HSBC">
                        </datalist>
                     </div>
                     <div class="col-md-4 cis-field">
                        <label for="routing_number">Routing Number</label>
                        <input type="text" name="routing_number" id="routing_number" class="form-control"
                               placeholder="9 digits"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                     </div>
                     <div class="col-md-4 cis-field">
                        <label for="account_number">Account Number</label>
                        <input type="text" name="account_number" id="account_number" class="form-control"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                     </div>
                     <?php if (empty($void_img)): ?>
                        <div class="col-md-6 cis-field">
                           <label>Upload Voided Check</label>
                           <input type="file" name="imageeeee" class="form-control" accept="image/*">
                           <span class="cis-help">Used for ACH verification.</span>
                        </div>
                     <?php else: ?>
                        <?php $void_img = str_replace(" ", "", (string)$void_img); ?>
                        <div class="col-md-6 cis-field">
                           <label>Voided Check</label>
                           <input type="hidden" name="txt_file_vi" value="<?php echo htmlspecialchars($void_img); ?>">
                           <div class="cis-uploaded">
                              <span class="glyphicon glyphicon-ok-sign"></span> Already uploaded
                              <a href="/ls_software/dl_client_files/void_img/<?php echo htmlspecialchars($void_img); ?>" target="_blank">View image</a>
                           </div>
                        </div>
                     <?php endif; ?>
                  </div>
               </div>
            </div>

            <!-- Hidden containers the existing JS relies on -->
            <div id="paymentOptionId" hidden>
               <div id="bankOptionId"></div>
               <div id="cardOptionId"></div>
            </div>

            <div class="cis-action-bar">
               <a href="edit_customer.php?id=<?php echo urlencode((string)$id_fnd); ?>" class="btn btn-default">Cancel</a>
               <button name="btttn-submit" type="submit" class="btn btn-save">
                  <span class="glyphicon glyphicon-ok"></span> Save &amp; Send Contract
               </button>
            </div>
         </form>

         <!-- Previously saved bank / card (AJAX-populated) -->
         <div class="panel panel-default cis-panel cis-prev">
            <div class="panel-heading">
               <span>Previously Saved Bank &amp; Cards for this Customer</span>
               <span class="cis-prev-hint">Click a row to auto-fill the form above.</span>
            </div>
            <div class="panel-body">
               <div class="row">
                  <div class="col-md-6">
                     <div id="bankTableId"></div>
                  </div>
                  <div class="col-md-6">
                     <div id="cardTableId"></div>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <hr>

   </body>

   </html>

   <script type="text/javascript">
      $(document).ready(function() {

         var url = 'loan-commercial/functions_commercial_loan.php';
         // projectName = "SPVL"
         var prev_loan_id = document.getElementById("renewLoanId").getAttribute("value");
         var loan_id = prev_loan_id == "" ? document.getElementById("loanId").getAttribute("value") : prev_loan_id;
         $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {
               'func': "GetBankInfoTable",
               'userId': document.getElementById("idUserId").getAttribute("value"),
               'loan_create_id': loan_id
            },
            async: true,
            success: function(data) {
               //var tableCard = data[0].cardTable;
               var tableBank = data[0].bankTable;
               // document.getElementById("bankTableId").outerHTML = tableBank;
               // document.getElementById("cardTableId").outerHTML = tableCard;
               document.getElementById("bankTableId").innerHTML = tableBank;
               document.getElementById("bankTableId").innerHTML.reload;
               // document.getElementById("cardTableId").innerHTML = tableCard;
               // document.getElementById("cardTableId").innerHTML.reload;
               $('#tbl_bank_info').on('click', '.clickable-bank-row', function(event) {
                  if ($(this).hasClass('table-success')) {
                     $(this).removeClass('table-success');
                  } else {
                     $(this).addClass('table-success').siblings().removeClass('table-success');
                  }

                  getCardInfoTable(event);

               });

               getCardInfoTable(event);

            },
            error: function(err) {
               if (err.status !== 0) {
                  console.error('AJAX error:', err.responseText);
               }
            }
         });
      });

      function getCardInfoTable(e) {
         var selected_data_bank = $("#tbl_bank_info tr.table-success td");
         var paymentElem = document.getElementById("bankOptionId");
         paymentElem.innerHTML = "";
         var bankExists = selected_data_bank.length > 0;
         paymentElem.innerHTML += "<input type='text' name='bankExists' value='" + bankExists + "' style='display:none;'>";
         if (!bankExists) {
            document.getElementById("cardTableId").innerHTML = "";
            $("#type_id").val('');
            $("#type_card").val('');
            $("#cvv_number").val('');
            $("#bank_name").val('');
            $("#routing_number").val('');
            $("#account_number").val('');
            $("#card_number").val('');
            $("#expiry_month_card").val('');
            $("#expiry_year_card").val('');
            e.preventDefault();
            return;
         }

         $("#bank_name").val(selected_data_bank[1].innerText);
         $("#account_number").val(selected_data_bank[2].innerText);
         $("#routing_number").val(selected_data_bank[3].innerText);
         var bankId = selected_data_bank[0].innerText;

         var url = 'loan-commercial/functions_commercial_loan.php';
         // projectName = "SPVL"
         var prev_loan_id = document.getElementById("renewLoanId").getAttribute("value");
         var loan_id = prev_loan_id == "" ? document.getElementById("loanId").getAttribute("value") : prev_loan_id;
         $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {
               'func': "GetCardInfoByBankId",
               'userId': document.getElementById("idUserId").getAttribute("value"),
               'loan_create_id': loan_id,
               'bankId': bankId
            },
            async: true,
            success: function(data) {
               //var tableCard = data[0].cardTable;
               var tableCard = data[0].cardTable;
               document.getElementById("cardTableId").innerHTML = tableCard;
               document.getElementById("cardTableId").innerHTML.reload;

               $('#tbl_card_info').on('click', '.clickable-card-row', function(event) {
                  if ($(this).hasClass('table-success')) {
                     $(this).removeClass('table-success');
                  } else {
                     $(this).addClass('table-success').siblings().removeClass('table-success');
                  }

                  getCardInformation(event);
                  //change_bank_info(event);

               });

               getCardInformation(event);

            },
            error: function(err) {
               if (err.status !== 0) {
                  console.error('AJAX error:', err.responseText);
               }
            }
         });

      }

      function getCardInformation(e) {
         var selected_data_card = $("#tbl_card_info tr.table-success td");
         var paymentElem = document.getElementById("cardOptionId");
         paymentElem.innerHTML = "";
         var cardExists = selected_data_card.length > 0;
         paymentElem.innerHTML += "<input type='text' name='cardExists' value='" + cardExists + "' style='display:none;'>";
         if (!cardExists) {
            $("#type_id").val('');
            $("#type_card").val('');
            $("#cvv_number").val('');
            $("#card_number").val('');
            $("#expiry_month_card").val('');
            $("#expiry_year_card").val('');
            e.preventDefault();
            return;
         }

         $("#type_id").val(selected_data_card[1].innerText);
         $("#type_card").val(selected_data_card[2].innerText);
         $("#card_number").val(selected_data_card[3].innerText);
         $("#cvv_number").val(selected_data_card[5].innerText);

         let expiry_month_card = '';
         let expiry_year_card = '';
         let card_exp_date = selected_data_card[4].innerText;
         const date_reg_exp = /^[0-9][0-9]\/[0-9][0-9]/;
         const valid = date_reg_exp.test(card_exp_date);
         if (valid) {
            expiry_month_card = card_exp_date.split('/')[0];
            expiry_year_card = card_exp_date.split('/')[1];
         }

         $("#expiry_month_card").val(expiry_month_card);
         $("#expiry_year_card").val(expiry_year_card);
      }
   </script>

<?php
}
?>