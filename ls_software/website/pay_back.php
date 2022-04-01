<?php
  include 'dbconnect.php';
  include 'dbconfig.php';


if(isset($_POST['btn-submit'])) 
{
$user_id = $_POST['user_id'];
$income_source= $_POST['income_source']; 
$emp_name= $_POST['emp_name'];
$work_phone= $_POST['work_phone'];
$start_working= $_POST['start_working'];
$get_paid= $_POST['get_paid'];
$last_pay= $_POST['last_pay'];
$next_pay=$_POST['next_pay'];
$income= $_POST['income_r'];
$gross_pay= $_POST['gross_pay'];
$take_home= $_POST['take_home'];
$final_month_income= $_POST['new_month_income'];

$date = date('Y-m-d H:i:s');

$query="INSERT INTO source_income (user_fnd_id,income_source,employer_name,work_phone_no,start_date,pay_period,monthly_income,last_pay_date,next_pay_date,how_tell_ur_income,gross_pay,take_home_pay,creation_date)  VALUES ('$user_id','$income_source','$emp_name','$work_phone','$start_working','$get_paid','$final_month_income','$last_pay','$next_pay','$income','$gross_pay','$take_home','$date')";

$result = mysqli_query($con,$query);
        if ($result) {
           //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
       } else {
       echo "<h3> Error Inserting Data </h3>";
       }
       

}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="images/ok.png" type="image/x-icon" />
    <!-- Theme tittle -->
    <title>Optima Financial Solutions Inc</title> 
    
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
    		
    		<h2>Enter Your Banking Information</h2>
    		<ol class="breadcrumb">
                
                 
            </ol>
    	</div>
    </section>
    <!-- Banner Area --> 
    
    <!-- Achieve your financial -->
    <section class="achieve_financial_area afa_2" >
        
        <form action ="thankyou.php" method="POST" enctype="multipart/form-data">
            
      <input name="user_id"  type="text" class="form-control" id="usr" placeholder="First Name" value="<?php echo $user_id; ?>" style="display:none;">
        <div class="container"> 
        <h3>Your Checking Information</h3>
        <p>If you choose direct deposit this is where your money will be deopsited.<br>If you have elected to make your loan payment automatically and signed<br> a loan payment authorization,your account maybe debited for the amount owned.</p>

        <br>
        <br>
        
            <div class="row">
                <div class="col-lg-6">
                    
      <label for="usr">Routing/ABA Number</label>
     <input name="aba_number"  type="text" class="form-control" id="usr" placeholder="" value="">
    </div>
                
            </div>
            <br>
            <div class="row">
            <div class="col-lg-6">
     <label for="usr">Account Number</label>
      <input name="acc_number" id="acc_number" type="number" class="form-control" id="usr" placeholder="" value="">
    </div> 
    
    <div class="col-lg-6">
     <label for="usr">Verify Account Number</label>
      <input name="verify_acc_number" id="verify_acc_number"  type="number" class="form-control" id="usr" placeholder="" value="">
    </div> 
    
    </div>
    
    <br>
    
     <h3>Your Debit Card Information</h3>
        <p>Keeping a debit card on the file is fastes,easiest way to pay your loan.<br>If you have elected to have your payment processed automatically,<br>signed a loan payment authorization and provided your debit card<br>information,your payment maybe processed for any current or past<br>due amount.Once your payment clears you maybe eligible to apply<br>for new loan.<br><br>Adding a card to your account may speedup funding times which<br>could allow you to access your cash more quickly!</p>

   <br>    
   
            <div class="row">
            <div class="col-lg-6">
     <label for="usr">Card Number</label>
      <input name="card_number" id="card_number"  type="number" class="form-control" id="usr" placeholder="" value="">
      
    </div> 
    
    <div class="col-lg-6">
     <label for="usr">Verify Card Number</label>
      <input name="verify_card_number" id="verify_card_number"  type="number" class="form-control" id="usr" placeholder="" value="">
      
    </div> 
    
    </div>
    
    <br>

    
     <div class="row">
      <div class="col-lg-6">
     <label for="usr">Expiration Date(Month)</label>
<input name="month"  type="date" class="form-control" id="usr" placeholder="" value="">
      
    </div>
    
     <div class="col-lg-6" style="display:none">
     <label for="usr">Expiration Date(Year)</label>
 <select name="year" id="year" class="form-control"  value="">
<option value="2014">2014</option>
<option value="2015">2015</option>
<option value="2016">2016</option>
<option value="2017">2017</option>
<option value="2018">2018</option>
<option value="2019">2019</option>
<option value="2020">2020</option>
<option value="2021">2021</option>
<option value="2022">2022</option>
<option value="2023">2023</option>
<option value="2024">2024</option>
<option value="2025">2025</option>
<option value="2026">2026</option>
<option value="2027">2027</option>
<option value="2028">2028</option>
<option value="2029">2029</option>
<option value="2030">2030</option>
<option value="2031">2031</option>
<option value="2032">2032</option>
<option value="2033">2033</option>
<option value="2034">2034</option>
<option value="2035">2035</option>
<option value="2036">2036</option>
<option value="2037">2037</option>
<option value="2038">2038</option>
<option value="2039">2039</option>
<option value="2040">2040</option>

</select>
      
    </div> 
    
    </div> 

    <br>
    
    
    <div class="row">
           
           <div class="col-lg-6">
     <label for="usr">Name on card</label>
      <input name="name_card"  type="text" class="form-control" id="usr" placeholder="" value="">
      
    </div>
    
    <div class="col-lg-6">
     <label for="usr">Billing Zip Code</label>
      <input name="zip_code"  type="number" class="form-control" id="usr" placeholder="" value="">
      
    </div> 
    
    </div>
    
    <br>
    
    <button name="btn-submit" type="submit" class="theme_btn" id="btnSubmit" href="" style="width:30%">Next</button>
    
        </div>
        </form>
    </section>
    
	
    <!-- Footer Area -->  
    
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
    
    
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#btnSubmit").click(function () {
                var password = $("#acc_number").val();
                var confirmPassword = $("#verify_acc_number").val();
                if (password != confirmPassword) {
                    alert("Account Number do not match.");
                    return false;
                }
                return true;
            });
        });
    </script>
   
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#btnSubmit").click(function () {
                var password = $("#card_number").val();
                var confirmPassword = $("#verify_card_number").val();
                if (password != confirmPassword) {
                    alert("Card Number do not match.");
                    return false;
                }
                return true;
            });
        });
    </script> 
    
</body>


</html>