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
    		
    		<h2>Personal Information</h2>
    		<ol class="breadcrumb">
                    
            </ol>
    	</div>
    </section>
    <!-- Banner Area --> 
    
    <!-- Achieve your financial -->
    <section class="achieve_financial_area afa_2" >
        
        <form action ="" method="POST" enctype="multipart/form-data">
            
        <div class="container"> 
        <h3>Tell us about yourself</h3>
        <p>Tell us about personal information such as name,email,phone etc.</p>
        <br>
        <br>
        
            <div class="row">
                <div class="col-lg-4">
      <label for="usr">First Name</label>
      <input name="first_name"  type="text" class="form-control" id="usr" placeholder="" value="">
    </div>
                <div class="col-lg-4">
      <label for="usr">Middle Name</label>
      <input name="middle_name"  type="text" class="form-control" id="usr" placeholder="" value="">
    </div>
    
     <div class="col-lg-4">
      <label for="usr">Last Name</label>
      <input name="last_name"  type="text" class="form-control" id="usr" placeholder="" value="">
    </div>
    
            </div>
            <br>
            <div class="row">
            <div class="col-lg-6">
     <label for="usr">Email Address</label>
      <input name="email"  type="email" class="form-control" id="usr" placeholder="" value="">
    </div> 
    
    <div class="col-lg-6">
     <label for="usr">Add Phone</label>
      <input name="phone"  type="text" class="form-control" id="usr" placeholder="" value="">
    </div> 
    
    </div>
    
    <br>
            <div class="row">
            <div class="col-lg-6">
     <label for="usr">Enter Password</label>
      <input name="password"  type="password" class="form-control" id="usr" placeholder="" value="">
    </div> 
    
    <div class="col-lg-6">
     <label for="usr">Verify Password</label>
      <input name="verify_password"  type="password" class="form-control" id="usr" placeholder="" value="">
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