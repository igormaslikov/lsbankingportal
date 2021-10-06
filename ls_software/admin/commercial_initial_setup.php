<?php
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

   $sql_fetch_fnd = mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$id_fnd'");

   while ($row_fetch_fnd = mysqli_fetch_array($sql_fetch_fnd)) {

      $email = $row_fetch_fnd['email'];

      $id_photo = $row_fetch_fnd['id_photo'];
      // echo "<br><br><br><br><br>".$id_photo;
      $bank_front = $row_fetch_fnd['bank_front'];
      $bank_back = $row_fetch_fnd['bank_back'];
      $void_img = $row_fetch_fnd['void_img'];
      $mobile_number = $row_fetch_fnd['mobile_number'];

   }



   $sql_fetch_loan = mysqli_query($con, "select * from tbl_commercial_loan where user_fnd_id= '$id_fnd'");
   $loan_id = "";
   while ($row_fetch_loan = mysqli_fetch_array($sql_fetch_loan)) {

      $loan_id = $row_fetch_loan['loan_create_id'];
      $previous_amount_loan = $row_fetch_loan['previous_amount_loan'];
   }
   //echo "loan id:".$loan_id;
   $fndd_id = $id_fnd;
   // echo "loan id:".$fndd_id;
   $state = $_GET['state'];



   $azrizona_message = '../../signature_commercial_loan/files/contract.php?id=' . $email_key;
   $azrizona_email = 'https://mymoneyline.com/lsbankingportal/signature_commercial_loan/completed/index.php?id=' . $email_key;






   //CUSTOMER EMAIL STARTS

   $to_email = $email;
   $subject = 'Contract';
   $message = $azrizona_message;
   $message_email = $azrizona_email;
   $headers = 'From: support@mymoneyline.com';
   //mail($to_email,$subject,$message,$headers);

   //CUSTOMER EMAIL ENDS

   //echo "loan id:".$loan_id;


   $sql_fetch_user = mysqli_query($con, "select * from tbl_users");

   while ($row_fetch_user = mysqli_fetch_array($sql_fetch_user)) {

      $email_admin = $row_fetch_user['email'];
      //echo "<br><br><br><br><br>admin email:".$email_admin;
   }

   //ADMIN EMAIL STARTS

   $to_email_admin = $email_admin;
   $subject_admin = 'A New Customer Has Signed The Contract';
   $message_admin = $azrizona_email;
   $headers_admin = 'From: support@mymoneyline.com';
   mail($to_email_admin, $subject_admin, $message_admin, $headers_admin);

   //ADMIN EMAIL ENDS


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
      $secondary_portfolio = $_POST['secondary_portfolio'];
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
      $daily_interest = $_GET['daily_interest'];
      






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
      $result_in = mysqli_query($con, $query_in);
      if ($result_in) {
         //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
      } else {
         echo "<h3> Error Inserting Data </h3>";
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

      $anual_pr = $daily_interest * $number_n;
      $anual_pr = number_format($anual_pr, 2);
      $in_hand = $_GET['in_hand'];
      
   

      $query  = "INSERT INTO `tbl_commercial_loan`(`user_fnd_id`, `bg_id`,`secondary_portfolio`,`previous_amount_loan`, `amount_of_loan`,`daily_interest`, `loan_interest`, `years`, `late_fee`, `contract_fee`, `installment_plan`, `total_payments`, `principal_amount`, `contract_date`, `payment_date`, `creation_date`, `created_by`, `loan_create_id`, `loan_status`, `apr`,`state`)  VALUES ('$fndd_id','$sourcee','$secondary_portfolio','$in_hand','$principal_amountt',$daily_interest,'$interestt','$yearss','$late_feee','$originationn','$installment_plann','$total_paymentss','$principal_amountt','$contract_datee','$payment_datee','$date','$u_id','$loan_create_idd','Active','$anual_pr','$state')";
      $result = mysqli_query($con, $query);
      if ($result) {
         //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
      } else {
         echo "<h3> Error Inserting Data </h3>";
      }

      //Add to other fees//
      mysqli_query($con, "INSERT INTO tbl_lists (kind, item) select 'Other Fee', 'Origination Fee' where not exists( select * from tbl_lists where kind='Other Fee' and item='Origination Fee')");

      $sql = mysqli_query($con, "select tbl_lists_id from tbl_lists where kind='Other Fee' and item='Origination Fee'");
  
      while ($row = mysqli_fetch_array($sql)) {
          $kind = $row['tbl_lists_id'];
      }

      $action_query = "INSERT INTO `tbl_other_fees` (`tbl_other_fees_id`, `kind_fee`, `user_fnd_id`, `loan_created_id`, `amount_fee`, `amount_fee_paid`) VALUES (NULL, '$kind', '$fndd_id', '$loan_create_idd', '$originationn', 0)";
      mysqli_query($con, $action_query);



      //=====================//

      mysqli_query($con, "UPDATE fnd_user_profile SET id_photo ='$final_File', bank_front='$final_Filee', bank_back='$final_Fileee', void_img='$final_Fileeee'  where user_fnd_id ='$fndd_id'");

      $sql_bank_info = mysqli_query($con, "select count(bank_id) as count, bank_id from tbl_bank_info where usr_fnd_id= '$fndd_id' and bank_name='$bank_name ' and account_number='$account_number' and routing_number='$routing_number'");

      while ($row = mysqli_fetch_array($sql_bank_info)) {
         $count = $row['count'];
         $bank_id = $row['bank_id'];
      }


      if ($count == 0) {
         $action_query = "INSERT INTO `tbl_bank_info` (`bank_id`, `usr_fnd_id`, `bank_name`, `account_number`, `routing_number`, `is_active`) VALUES (NULL, '$fndd_id', '$bank_name', '$account_number', '$routing_number', '1')";
         mysqli_query($con, $action_query);
         $bank_id = mysqli_insert_id($con);
      }

      $sql = mysqli_query($con, "select count(id) as count from tbl_bank_cards where user_fnd_id= '$fndd_id' and type_of_id='$type_id' and  type_of_card='$type_card' and card_number='$card_number' and card_exp_date='$card_exp_date' and cvv_number='$cvv_number'");

      while ($row = mysqli_fetch_array($sql)) {
         $count = $row['count'];
      }

      if ($count == 0) {
         $action_query = "INSERT INTO `tbl_bank_cards` (`id`,`bank_id`, `user_fnd_id`, `type_of_id`, `type_of_card`, `card_number`, `card_exp_date`,`cvv_number`, `is_active`) VALUES (NULL,'$bank_id', '$fndd_id', '$type_id','$type_card', '$card_number', '$card_exp_date','$cvv_number', '1')";
         mysqli_query($con, $action_query);
      }





      if(isset($_GET['prev_loan_id'])){
         $previous_loan_id =  $_GET['prev_loan_id'];
         $sql_fetch_loan = mysqli_query($con, "select previous_amount_loan from tbl_commercial_loan where loan_create_id='$loan_create_idd'");
         while ($row_fetch_loan = mysqli_fetch_array($sql_fetch_loan)) {
            $previous_amount_loan = $row_fetch_loan['previous_amount_loan'];
         }

         $sql = mysqli_query($con, "select late_fee,amount_of_loan,loan_interest from tbl_commercial_loan where loan_create_id= '$previous_loan_id'");

         while ($row = mysqli_fetch_array($sql)) {
             $late_fee = $row['late_fee'];
             $amount_of_loan = $row['amount_of_loan'];
             $loan_interest = $row['loan_interest'];
         }

         $loan_payment = 0;
         $query_payment = mysqli_query($con, "SELECT SUM(payment_amount) AS value_sum FROM commercial_loan_transaction where loan_create_id= '$previous_loan_id'");
         while ($row_payment = mysqli_fetch_array($query_payment)) {
           $loan_payment = $row_payment['value_sum'];
         }

         $in_hand = str_replace(',','',number_format(((float)($amount_of_loan + $loan_interest - $loan_payment)), 2, '.', ','));

         $unpaid_late_fee = 0;
         $query_payment = mysqli_query($con, "SELECT sum($late_fee - paid_late_fee) as unpaid FROM `tbl_commercial_loan_installments` WHERE `dpd` >= 10 and loan_create_id = '$previous_loan_id' and ($late_fee - paid_late_fee) > 0 ");
         while ($row_payment = mysqli_fetch_array($query_payment)) {
           $unpaid_late_fee = $row_payment['unpaid'] == null ? 0 : $row_payment['unpaid'];
         }

         $unpaid_other_fee = 0;
         $query_payment = mysqli_query($con, "SELECT sum(amount_fee - amount_fee_paid) as unpaid FROM `tbl_other_fees` WHERE loan_created_id = $previous_loan_id ");
         while ($row_payment = mysqli_fetch_array($query_payment)) {
           $unpaid_other_fee = $row_payment['unpaid'] == null ? 0 : $row_payment['unpaid'];
         }
         // $sql_installment = mysqli_query($con, "SELECT SUM(late_fee) as sum_late_fee FROM `commercial_loan_transaction` where `loan_create_id`= '$previous_loan_id'");
         // $sum_late_fee = 0;
         // while ($row_installment = mysqli_fetch_array($sql_installment)) {
         //     $sum_late_fee = $row_installment['sum_late_fee'];
         // }

         $amount_without_fee = $previous_amount_loan - $unpaid_late_fee - $unpaid_other_fee;
         $amount_without_fee = $previous_amount_loan >= $in_hand ? $in_hand : $previous_amount_loan;

         $sql_installment = mysqli_query($con, "SELECT *  FROM `tbl_commercial_loan_installments` where `loan_create_id`= '$previous_loan_id' and status=0 order by id asc");
         while ($row_installment = mysqli_fetch_array($sql_installment)) {
            $payment = $row_installment['payment'];
            if($previous_amount_loan == 0 || $amount_without_fee <= 0){ // status 4 = "Credit"
               mysqli_query($con, "UPDATE tbl_commercial_loan_installments SET paid_date='$contract_datee', `paid amount`='$payment', `credit_amount` = '$payment', status='4', paid_by='$u_id' where loan_create_id = '$previous_loan_id' and status = 0 ");
               break;
            }

           
            $paid_amount = $row_installment['paid amount'];
            $id =  $row_installment['id'];

            $real_payment = $payment - $paid_amount;
            $amount_without_fee -= $real_payment;

            $refinanced = $real_payment;
            $credit = 0;

            $status = 3; // "Paid Ref"
            if($amount_without_fee < 0){
               $refinanced= $real_payment+$amount_without_fee;
               $credit = $real_payment - $refinanced;
               $amount_without_fee = 0;
               $status = 4;
            }

            mysqli_query($con, "UPDATE tbl_commercial_loan_installments SET `paid amount` ='$payment', `refinanced_amount` = '$refinanced', `credit_amount` = '$credit',  status='$status', paid_date='$contract_datee',  paid_by='$u_id' where id= '$id'");
            
        }

        mysqli_query($con, "UPDATE tbl_commercial_loan SET loan_status='Paid' where loan_create_id = '$previous_loan_id'");

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
         .table-success tbody+tbody,
         .table-success td,
         .table-success th,
         .table-success thead th {
            border-color: #8fd19e;
         }

         .table-success,
         .table-success>td,
         .table-success>th {
            background-color: #c3e6cb;
         }
      </style>
   </head>

   <body>

      <?php include('menu.php'); ?>

      <div class="container" style="margin-top:100px">

         <div class="row">

            <form action="" method="POST" enctype="multipart/form-data">
               <input type="text" name="emaill" value="<?php echo $email; ?>" style="display:none;">
               <input type="text" name="link" value="<?php echo $message; ?>" style="display:none;">
               <input type="text" name="name_id" value="<?php echo $user_fnd_id; ?>" style="display:none;">
               <input type="text" name="fnd_idd" id="idUserId" value="<?php echo $_GET['fnd_id']; ?>" style="display:none;">
               <input type="text" name="renew_loan" id="renewLoanId" value="<?php echo $loan_id; ?>" style="display:none;">
               <input type="text" name="bg_idd" value="<?php echo $_GET['bg_id']; ?>" style="display:none;">
               <input type="text" name="secondary_portfolio" value="<?php echo $_GET['secondary_portfolio']; ?>" style="display:none;">
               <input type="text" name="loan_create_idd" id="loanId" value="<?php echo $_GET['loan_create_id']; ?>" style="display:none;">
               <input type="text" name="principal_amountt" value="<?php echo $_GET['principal_amount'];; ?>" style="display:none;">
               <input type="text" name="loan_interest" value="<?php echo $_GET['loan_interest'];; ?>" style="display:none;">
               <input type="text" name="yearss" value="<?php echo $_GET['years'];; ?>" style="display:none;">
               <input type="text" name="late_feee" value="<?php echo $_GET['late_fee'];; ?>" style="display:none;">
               <input type="text" name="contract_feee" value="<?php echo $_GET['contract_fee'];; ?>" style="display:none;">
               <input type="text" name="installment_plann" value="<?php echo $_GET['installment_plan'];; ?>" style="display:none;">
               <input type="text" name="total_paymentss" value="<?php echo $_GET['total_payments'];; ?>" style="display:none;">
               <input type="text" name="contract_datee" value="<?php echo $_GET['contract_date'];; ?>" style="display:none;">
               <input type="text" name="payment_datee" value="<?php echo $_GET['payment_date'];; ?>" style="display:none;">


               <h3>User Information</h3>
               <br>
               <div class="row">

                  <div class="col-lg-6">
                     <label for="type_id">Type of ID<i style="color:red">*</i></label>
                     <select name="type_id" id="type_id" class="form-control" value="" required>
                        <option></option>
                        <option value="Drivers License">Drivers License</option>
                        <option value="State Personal ID">State Personal ID</option>
                        <option value="Matricula Consular ID">Matricula Consular ID</option>
                        <option value="Tribal ID">Tribal ID</option>
                        <option value="Passport">Passport</option>
                        <option value="Military ID">Military ID</option>
                        <option value="Other">Other</option>
                     </select>
                  </div>




                  <?php
                  if (empty($id_photo)) {
                     echo '<div class="col-lg-6">
      <label for="usr">Upload Picture of ID<i style="color:red">*</i></label>
      <input type="file" name="file_image"  class="form-control" accept="image/*" required><br>
    </div>';
                  } else {

                     echo '<div class="col-lg-6">
      <label for="usr">Upload Picture of ID<i style="color:red">*</i></label>
      <input type="text" name="txt_image" style="display:none"  class="form-control" value="'; ?><?php echo $id_photo; ?><?php echo '"> <br> Image Already Uploaded - 
      <a href ="/ls_software/dl_client_files/photo_id/' . $id_photo . '" target="_blank" > View Image </a><br>
      <br>
    </div>';
                                                                                                                        }
                                                                                                                           ?>




                  <div class="col-lg-6">
                     <label for="type_card">Type of Card<i style="color:red">*</i></label>
                     <select name="type_card" id="type_card" class="form-control" value="" required>
                        <option></option>
                        <option value="Visa">Visa</option>
                        <option value="Master Card">Master Card</option>
                     </select>
                  </div>

                  <div class="col-lg-6">
                     <label for="card_number">Card Number<i style="color:red">*</i></label>
                     <input type="text" name="card_number" class="form-control" id="card_number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="16" required><br>
                  </div>

                  <div class="col-lg-6">
                     <label for="usr">Card Expiration Date</label>
                     <br>
                     Month<i style="color:red">*</i>
                     <select style="width:20%" name="expiry_month_card" id="expiry_month_card" class="form-control" value="" required>
                        <option></option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                     </select>

                     Year<i style="color:red">*</i>
                     <select style="width:20%" name="expiry_year_card" id="expiry_year_card" class="form-control" value="" required>
                        <option></option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                     </select>



                  </div>


                  <?php
                  if (empty($bank_front)) {
                     echo '<div class="col-lg-6">
      <label for="usr">Upload Bank Card Front<i style="color:red">*</i></label>
      <input type="file" name="imageee"  class="form-control" accept="image/*" required><br>
    </div>';
                  } else {

                     echo '<div class="col-lg-6">
      <label for="usr">Upload Bank Card Front<i style="color:red">*</i></label>
      <input type="text" name="txt_file_bf" style="display:none"  class="form-control" value="'; ?><?php $bank_front = str_replace(" ", "", "$bank_front");
                                                                                                   echo $bank_front; ?><?php echo '">
       <br> Image Already Uploaded - 
      <a href ="/ls_software/dl_client_files/bank_front_image/' . $bank_front . '" target="_blank" > View Image </a><br>
      <br>
    </div>';
                                                                                                                     }

                                                                                                                        ?>



                  <?php
                  if (empty($bank_back)) {
                     echo '
    
    <div class="col-lg-6">
      <label for="usr">Upload Bank Card Back<i style="color:red">*</i></label>
      <input type="file" name="imageeee"  class="form-control" accept="image/*" required>
    </div>';
                  } else {

                     echo '

    <div class="col-lg-6">
      <label for="usr">Upload Bank Card Back<i style="color:red">*</i></label>
      <input type="text" name="txt_file_bb" style="display:none"  class="form-control" value="'; ?><?php $bank_back = str_replace(" ", "", "$bank_back");
                                                                                                   echo $bank_back; ?><?php echo '">
       <br> Image Already Uploaded - 
      <a href ="/ls_software/dl_client_files/bank_back_image/' . $bank_back . '" target="_blank" > View Image </a><br>
      <br>
    </div>';
                                                                                                                     }
                                                                                                                        ?>

                  <div class="col-lg-6">
                     <label for="bank_name">Bank Name<i style="color:red">*</i></label>
                     <input list="banks" name="bank_name" id="bank_name" class="form-control" value="" required>
                     <datalist id="banks">
                        <option value="Bank Of America">Bank Of America</option>
                        <option value="Chase">Chase</option>
                        <option value="Wells Fargo">Wells Fargo</option>
                        <option value="Citi Bank ">Citi Bank </option>
                        <option value="US Bank">US Bank</option>
                        <option value="HSBC">HSBC</option>
                     </datalist>
                     <!-- <select name="bank_name" id="bank_name" class="form-control" value="">
                        <option></option>
                        <option value="Bank Of America">Bank Of America</option>
                        <option value="Chase">Chase</option>
                        <option value="Wells Fargo">Wells Fargo</option>
                        <option value="Citi Bank ">Citi Bank </option>
                        <option value="US Bank">US Bank</option>
                        <option value="HSBC">HSBC</option>
                     </select> --><br>
                  </div>

                  <div class="col-lg-6">
                     <label for="routing_number">Routing Number<i style="color:red">*</i></label>
                     <input type="text" name="routing_number" id="routing_number" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                  </div>

                  <div class="col-lg-6">
                     <label for="account_number">Account Number<i style="color:red">*</i></label>
                     <input type="text" name="account_number" id="account_number" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required><br>
                  </div>

                  <?php
                  if (empty($void_img)) {
                     echo '
    <div class="col-lg-6">
      <label for="usr">Upload Void Check<i style="color:red">*</i></label>
      <input type="file" name="imageeeee"  class="form-control" accept="image/*" required>
    </div>';
                  } else {

                     echo '

    <div class="col-lg-6">
      <label for="usr">Upload Void Check<i style="color:red">*</i></label>
      <input type="text" name="txt_file_vi"  style="display:none" class="form-control" value="'; ?><?php $void_img = str_replace(" ", "", "$void_img");
                                                                                                   echo $void_img; ?><?php echo '">
       <br> Image Already Uploaded - 
      <a href ="/ls_software/dl_client_files/void_img/' . $void_img . '" target="_blank" > View Image </a><br>
      <br>
    </div>';
                                                                                                                  }
                                                                                                                     ?>


                  <div class="col-lg-6">
                     <label for="cvv_number">CVV Number<i style="color:red">*</i></label>
                     <input type="text" name="cvv_number" id='cvv_number' class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="4" required>
                  </div>

               </div>
               <div id="paymentOptionId" hidden>
                  <div id="bankOptionId"></div>
                  <div id="cardOptionId"></div>
               </div>
               <br>

               <button name="btttn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: blue;border-color: blue;">Add this Setup</button>
            </form>

         </div>

         <div class="row" style="padding-top: 20px;">
            <div class="col-lg-12" style="padding-bottom: 20px">
               <span style="font-weight:bold; font-size:15px;">Banking Information: </span><br>
            </div>

            <div class="col-lg-12">
               <div class="row">
                  <div class="col-lg-6">
                     <div id="bankTableId"></div>
                  </div>
                  <div class="col-lg-6">
                     <div id="cardTableId"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>

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
               if (err.responseText == "") {
                  alert(err.responseText);
               } else {
                  alert(err.responseText);
               }
               window.location.reload();
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
               if (err.responseText == "") {
                  alert(err.responseText);
               } else {
                  alert(err.responseText);
               }
               window.location.reload();
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