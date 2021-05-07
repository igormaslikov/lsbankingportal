<?php
  include 'dbconnect.php';
  include 'dbconfig.php';

    
$income_final= $_POST['income'];
$user_id_b = $_POST['user_id_2'];
       

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="images/ok.png" type="image/x-icon" />
    <!-- Theme tittle -->
    <title>LS Financing</title> 
    
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
    		
    		<h2>Binary Questions</h2>
    		<ol class="breadcrumb">
                   
                 
            </ol>
    	</div>
    </section>
    <!-- Banner Area --> 
    
    
    <!-- Achieve your financial -->
    <section class="achieve_financial_area afa_2" >
        
        <form action ="job_details.php" method="POST" enctype="multipart/form-data">
            
             <input type="text" name="user_id_3" id="user_id_3" value="<?php echo $user_id_b; ?>" style="display:none;"> 
             <input type="text" name="month_income" id="month_income" value="<?php echo $income_final; ?>" style="display:none;"> 
            
        <div class="container"> 
        <h3>Please Answer the following question.</h3>
        <p></p>
        <br>
        <br>
        
            <div class="row">
            <div class="col-lg-6">
     <label for="usr">How do you get paid? </label>
     <select name="payment" id="payment" class="form-control"  value="">
<option value="Direct Deposit">Direct Deposit</option>
<option value="Check">Check</option>
<option value="Cash">Cash</option>
<option value="Military">Military</option>
<option value="Disability/Workers Compensation">Disability/Workers Compensation</option>

</select>
    </div> 
    
    </div>
    
    <br>
    <button name="btn-submit" type="submit" class="theme_btn" href="" style="width:30%">Next</button>
    
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
</body>


</html>