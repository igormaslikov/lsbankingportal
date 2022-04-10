
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="images/ok.png" type="image/x-icon" />
    <!-- Theme tittle -->
    <title>Pacifica Finance Group</title> 
    
    <!-- Theme style CSS -->      
    <link href="css/style.css" rel="stylesheet"> 

</head>
<body> 

	<!-- Header Top Area -->
	<?php include 'header.php';?>
    <!-- Header Area -->   
        
    <!-- Banner Area --> 
    <section class="banner_area" >
    	<div class="container">
    		
    		<h2>Thank You For Registration</h2>
    		<ol class="breadcrumb">
                
                 
            </ol>
    	</div>
    </section>


<?php

  include 'dbconnect.php';
  include 'dbconfig.php';


if(isset($_POST['btn-submit'])) 
{
$user_id = $_POST['user_id'];
//echo $user_id;
$aba_number= $_POST['aba_number']; 
$acc_number= $_POST['acc_number'];
$verify_acc_number= $_POST['verify_acc_number'];
$card_number= $_POST['card_number'];
$month= $_POST['month'];
$year=$_POST['year'];
$name_card= $_POST['name_card'];
$zip_code= $_POST['zip_code'];


$date = date('Y-m-d H:i:s');

$query="INSERT INTO banking_information (user_fnd_id,routing_aba_number,account_number,verify_account_number,card_number,expiry_date,name_of_card,billing_zip_code,creation_date,last_update_date)  VALUES ('$user_id','$aba_number','$acc_number','$verify_acc_number','$card_number','$month','$name_card','$zip_code','$date','$date')";

$result = mysqli_query($con,$query);
        if ($result) {
           //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
       } else {
       echo "<h3> Error Inserting Data </h3>";
       }
}
//echo "Thank You for registration.";
?>
<br>
<a class="theme_btn" id="btnSubmit" href="login.php" style="width:30%">Login Here</a>
<br><br>

 <?php  include 'footer.php' ;?>
    
    <!-- End Footer Area -->   
    
    <!-- Scroll Top Button -->
    <button class="scroll-top">
        <i class="fa fa-angle-double-up"></i>
    </button>
    
    <!-- Preloader -->  
    <div class="preloader"></div> 
    
    <!-- jQuery v3.3.1 -->
    <script src="js/jquery-3.3.1.min.js"></script> 
    <!-- Bootstrap v4.0.0 -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>  
    <!-- Extra Plugin -->
    <script src="vendors/animate-css/wow.min.js"></script>
    <script src="vendors/counterup/jquery.waypoints.min.js"></script> 
    <script src="vendors/counterup/jquery.counterup.min.js"></script>  
    <script src="vendors/owl-carousel/owl.carousel.min.js"></script>   
    <script src="vendors/bootstrap-selector/jquery.nice-select.min.js"></script> 
    <!-- Theme js / Custom js -->
    <script src="js/theme.js"></script>

   </body>
</html>