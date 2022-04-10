<?php
  include 'dbconnect.php';
  include 'dbconfig.php';

if(isset($_POST['btn-submit'])) 
{
    
$state_final= $_POST['state'];
$user_id2 = $_POST['user_id'];
$date = date('Y-m-d H:i:s');

$query="INSERT INTO binary_questions (user_fnd_id,state_bq,creation_date)  VALUES ('$user_id2','$state_final','$date') ";

$result = mysqli_query($con,$query);
        if ($result) {
           //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
       } else {
       echo "<h3> Error Inserting Data </h3>";
       }
       

} //IF ENDS


?>

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
    		
    		<h2>Binary Questions</h2>
    		<ol class="breadcrumb">
                   
                 
            </ol>
    	</div>
    </section>
    <!-- Banner Area --> 

    <!-- Achieve your financial -->
    <section class="achieve_financial_area afa_2" >
        
        <form action ="binary_question3.php" method="POST" enctype="multipart/form-data">
            
            
            <input type="text" name="email_binary" value="<?php echo $email_binary; ?>" style="display:none">        
            <input type="text" name="pass_binary" value="<?php echo $pass_binary; ?>" style="display:none"> 
            <input type="text" name="phone_binary" value="<?php echo $phone_binary; ?>" style="display:none"> 
            <input type="text" name="key_binary" id="apicodee" value="<?php echo $key_binary; ?>" style="display:none"> 
            <input type="text" name="state_binary" id="apicodee" value="<?php echo $state_binary; ?>" style="display:none"> 
            
             <input type="text" name="user_id_2" id="user_id_2" value="<?php echo $user_id2; ?>" style="display:none;"> 
            
        <div class="container"> 
        <h3>Please Answer the following question.</h3>
        <p></p>
        <br>
        <br>
        
            <div class="row">
            <div class="col-lg-6">
     <label for="usr">What is your monthly income?</label>
      <input name="income"  type="text" class="form-control" id="usr" placeholder="" value="" required>
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