<?php
  include $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';
  


if(isset($_POST['btn-submit'])) 
{

$user_id= $_POST['user_id']; 
$ssn= $_POST['ssn'];
$address= $_POST['address'];
$dob= $_POST['dob'];

$date = date('Y-m-d H:i:s');

$hashed_password = password_hash($passs, PASSWORD_DEFAULT); 

$query="UPDATE `fnd_user_profile` SET `ssn` = '$ssn', `date_of_birth` = '$dob', `address` = '$address' where`user_fnd_id` = '$user_id'";
$result = mysqli_query($con,$query);
        if ($result) {
           //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
       } else {
       echo "<h3> Error Inserting Data </h3>";
       }
       

} //IF ENDS

$query_userid = mysqli_query($con,"Select * from fnd_user_profile where user_key = '$keyy'");
while ($row_user_id=mysqli_fetch_array($query_userid)){
    $user_id_n = $row_user_id[0];
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
       
       <?php
$u_key = $_POST['key'];


        $u_phone = str_replace('%2B', ' ', $u_phone);
       // echo $u_phone; 
        
 ?>       
        
        <form action ="binary_question2.php" method="POST" enctype="multipart/form-data">
            
            <input type="text" name="keyy" id="apicodee" value="<?php echo $u_key; ?>" style="display:none"> 
            <input type="text" name="user_id" id="user_id" value="<?php echo $user_id; ?>" style="display:none;"> 
            
            
        <div class="container"> 
        <h3>Please Answer the following question.</h3>
        <p></p>
        <br>
        <br>
        
            <div class="row">
                <div class="col-lg-6">
                    
      <label for="usr">What state are you from?</label>
    
<select name="state" id="state" class="form-control"  value="">
<option value="Texas">Texas</option>
<option value="California">California</option>
<option value="Florida">Florida</option>
<option value="Washington">Washington</option>
<option value="Alaska">Alaska</option>

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