<?php function generateRandomString($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
      $user_key = generateRandomString();;
     
?>
<!-- User Key End-->

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
    		
    		<h2>To get started <span>create your account</span></h2>
    		<ol class="breadcrumb">
                   
            </ol>
    	</div>
    </section>
    <!-- Banner Area --> 
    
    <!-- Achieve your financial -->
    <section class="achieve_financial_area afa_2" >
        
        <form action ="confirm_phone.php" method="POST" enctype="multipart/form-data">
            
            <input type="text" name="num" value="<?php echo $num; ?>" style="display:none">
            <input type="text" name="phonn" value="<?php echo $phon; ?>" style="display:none">
            <input type="text" name="user_key" value="<?php echo $user_key; ?>" style="display:none">
            
        <div class="container"> 
        <a class="theme_btn" href="" style="display:none;"><i class="fa fa-facebook" aria-hidden="true" style="display:none;"></i> Sign Up with Facebook</a>
        <p style="display:none;">When you create your account with facebook,Speedy Cash will not post to your profile.</p>
        <br>
        <h3 style="display:none;">OR</h3>
        <h3>Tell us about yourself</h3>
        <p style="display:none;">Tell us about personal information such as name,email,phone etc.</p>
        <br>
        <br>
        
        <div class="row">
             <div class="col-lg-6">
      <label for="usr">First Name</label>
      <input name="first_name"  type="text" class="form-control" id="usr" placeholder="First Name" value="">
    </div>

     <div class="col-lg-6">
      <label for="usr">Last Name</label>
      <input name="last_name"  type="text" class="form-control" id="usr" placeholder="Last Name" value="">
    </div>
    
            </div>
        <br>
            <div class="row">
                <div class="col-lg-6">
      <label for="usr">Email Address</label>
      <input name="email"  type="email" class="form-control" id="usr" placeholder="Email Address" value="" required>
    </div>
               <div class="col-lg-6">
     <label for="usr">Add Phone</label>
      <input name="phone"  type="text" class="form-control" id="usr" placeholder="Add Phone" value="" required>
    </div> 
               
            </div>
            <br>
            <div class="row">
            <div class="col-lg-6">
     <label for="usr">Enter Password</label>
      <input name="password"  type="password" class="form-control" id="txtPassword" placeholder="Enter Password" value="" required>
    </div>
    
    <div class="col-lg-6">
     <label for="usr">Re-enter Password</label>
      <input name="re_password"  type="password" class="form-control" id="txtConfirmPassword" placeholder="Re-enter Password" value="" required>
    </div> 
    
    </div>
    
     <div class="row" style="display:none;">
       
    <div class="col-lg-6">
      <label for="usr"> Any Application Status</label>
<select name="app_status" id="app_status" class="form-control"  value="">
<option value="New Application">New Application</option>

</select>
    </div>
    
    </div>
    
              <br>
        
    <button name="btn-submit" id="btnSubmit"  type="submit"  class="theme_btn">Next </button> 
    <br><br>
    <a class="theme_btn" href="login.php">Returning Customer?</a>
        </div>
        </form>
    </section>
    <!-- Achieve your financial -->
	
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
    
    
    <!-- Password Validation -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#btnSubmit").click(function () {
                var password = $("#txtPassword").val();
                var confirmPassword = $("#txtConfirmPassword").val();
                if (password != confirmPassword) {
                    alert("Passwords do not match.");
                    return false;
                }
                return true;
            });
        });
    </script>
    
</body>

</html>