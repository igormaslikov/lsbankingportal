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
    		
    		<h2>Job Details</h2>
    		<ol class="breadcrumb">
                
                
            </ol>
    	</div>
    </section>
    <!-- Banner Area --> 
    
    <!-- Achieve your financial -->
    <section class="achieve_financial_area afa_2" >
        
        <form action ="pay_back.php" method="POST" enctype="multipart/form-data">
            
        <div class="container"> 
        <h3>Tell us about your steady source of income.</h3>
        <p>If you have more than one source of income you can enter more on next page.</p>
        <p></p>
        <br>
        <br>
        
            <div class="row">
                <div class="col-lg-6">
                    
      <label for="usr">How often did you get paid?</label>
    
<select name="get_paid" id="get_paid" class="form-control"  value="">
<option value="Daily">Daily</option>
<option value="Weekly">Weekly</option>
<option value="Monthly">Monthly</option>
</select>
    </div>
                
            </div>
            <br>
            <div class="row">
            <div class="col-lg-6">
     <label for="usr">Your Last Pay Date</label>
      <input name="last_pay"  type="date" class="form-control" id="usr" placeholder="" value="">
    </div> 
    
    </div>
    
    
    <br>
            <div class="row">
            <div class="col-lg-6">
     <label for="usr">Your Next Pay Date</label>
      <input name="next_pay"  type="date" class="form-control" id="usr" placeholder="" value="">
      <p>We've pre-populated your next pay date. If you feel it is incorrect,please verify your pay date.</p>
    </div> 
    
    </div>
    
    <br>
    
     <div class="row">
            <div class="col-lg-6">
     <label for="usr">How would you like to tell us your income? </label>
     <br>
    <input name="income"  type="radio" id="usr" style="width:3%" value="Per Month">Per Month
    <input name="income"  type="radio" id="usr" style="width:3%" value="Per Paycheck">Per Paycheck
    </div> 
    
    </div>
    
    <br>
    
     <div class="row">
            <div class="col-lg-6">
     <label for="usr">Gross Pay</label>
      <select name="gross_pay" id="gross_pay" class="form-control"  value="">
<option value="$">$</option>
<option value="£">£</option>
<option value="€">€</option>
</select>
    </div> 
    
    </div>
    
    <br>
    
    <div class="row">
            <div class="col-lg-6">
     <label for="usr">Take Home Pay</label>
      <select name="take_home" id="take_home" class="form-control"  value="">
<option value="$">$</option>
<option value="£">£</option>
<option value="€">€</option>
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