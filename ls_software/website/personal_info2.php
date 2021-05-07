<?php
  include 'dbconnect.php';
  include 'dbconfig.php';

if(isset($_POST['btn-submit'])) 
{

$first_nam= $_POST['f_name']; 
$middle_nam= $_POST['m_name'];
$last_nam= $_POST['l_name'];
$emailll= $_POST['emaill'];
$passs= $_POST['pass'];
$phoneee= $_POST['phonee'];
$phoneee = str_replace('%2B', '+', $phoneee);
$keyy=$_POST['key'];
$application_status=$_POST['status'];

$date = date('Y-m-d H:i:s');

$hashed_password = password_hash($passs, PASSWORD_DEFAULT); 

$query="INSERT INTO fnd_user_profile (first_name,last_name,email,password,mobile_number,user_key,creation_date,last_update_date,application_status)  VALUES ('$first_nam','$last_nam','$emailll','$hashed_password','$phoneee','$keyy','$date','$date','$application_status')";

$result = mysqli_query($con,$query);
        if ($result) {
           //echo "<div class='form'><h3> successfully added.</h3><br/></div>";
       } else {
       echo "<h3> Error Inserting Data </h3>";
       }
       
} //IF ENDS

$query_userid = mysqli_query($con,"Select * from fnd_user_profile where user_key = '$keyy'");
while ($row_user_id=mysqli_fetch_array($query_userid)){
    $user_id = $row_user_id[0];
   // echo "idddddd".$user_id;
}


$to_email = $emailll;
$subject = 'Confirmation';
$message = 'Thank You For Registration!Please Fill all the information to continue.';
$headers = 'From: info@lsbanking.com';
mail($to_email,$subject,$message,$headers);


// Admin Email


$query_admin = mysqli_query($con,"Select * from tbl_users");
while ($row_email=mysqli_fetch_array($query_admin)){
    $admin_email = $row_email[email];
    //echo "Email is: $admin_email<br>";
    
$to_email_admin = $admin_email;
$subject_admin = 'New Registration';
$message_admin = "New User Has Been Registered with email: $emailll";
$headers_admin = 'From: info@lsbanking.com';
mail($to_email_admin,$subject_admin,$message_admin,$headers_admin);
    
}

// Admin Email End


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
    		
    		<h2>Personal Information</h2>
    		<ol class="breadcrumb">
                
                 
            </ol>
    	</div>
    </section>
    <!-- Banner Area --> 
    
    <!-- Achieve your financial -->
    <section class="achieve_financial_area afa_2" >
        
        <form action ="binary_question.php" method="POST" enctype="multipart/form-data">
            
        <div class="container"> 
        <h3>Tell us more about yourself</h3>
        <p>Please fill out the following information.</p>
        <br>
        <br>
        
      <input name="user_id"  type="text" class="form-control" id="usr" placeholder="First Name" value="<?php echo $user_id; ?>" style="display:none;">
      
            <div class="row">
                <div class="col-lg-6">
      <label for="usr">Address</label>
      <textarea name="address"  type="text" class="form-control" id="usr" placeholder="" value=""> </textarea>
    </div>

            </div>
            <br>
            <div class="row">
            <div class="col-lg-6">
     <label for="usr">Date of birth</label>
      <input name="dob"  type="date" class="form-control" id="usr" placeholder="" value="">
    </div> 
    
    </div>
    
    <br>
            <div class="row">
            <div class="col-lg-6">
     <label for="usr">SSN / ITIN</label>
      <input name="ssn"  type="number" class="form-control" id="usr" placeholder="Not More Or Less Than 9 Digits" value="">
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