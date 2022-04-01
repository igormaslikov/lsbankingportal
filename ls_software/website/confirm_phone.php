<?php
$num = '';
  while($i <1)
  {
    for ($n = 0; $n <6; $n++)
      $num .= mt_rand(0, 9);
    // echo $num . "</br>";
  $i++;
  } 
?>
<?php

$f_name=$_POST['first_name'];
$m_name=$_POST['middle_name'];
$l_name=$_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$re_password = $_POST['re_password'];
$pass=$re_password;
//echo $pass;
$phone = $_POST['phone'];
// $code = $_POST['num'];
$key= $_POST['user_key'];
$status_application=$_POST['app_status'];

        $phone = str_replace('+', '%2B', $phone);
       // echo $phone;
    
    // API Starts...................................// 
    
 $url = "Body='your code is'.$num&From=";
$url.= "%2B12019926499";
$url.= "&To=";
$url.= "$phone";
    
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.twilio.com/2010-04-01/Accounts/AC9a1716ea74edacd62fe38ebc3e0f7b20/Messages",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "$url",
  CURLOPT_HTTPHEADER => array(
    "authorization: Basic QUM5YTE3MTZlYTc0ZWRhY2Q2MmZlMzhlYmMzZTBmN2IyMDowZjMzZTkxZTM0MzIzNTJmNTRhMjIxZDkzZTQ5YWM5ZQ==",
    "cache-control: no-cache",
    "content-type: application/x-www-form-urlencoded",
    "postman-token: 17dbdeda-1147-f00b-2c91-47cd85574741"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  // echo $response;
}
 
 // API END.....................................// 

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
    		
    		<h2>To get started <span>create your account</span></h2>
    		<ol class="breadcrumb">
                   
            </ol>
    	</div>
    </section>
    <!-- Banner Area --> 
    
    <?php
    $u_key= $_POST['user_key']
    
    ?>
    
    <!-- Achieve your financial -->
    <section class="achieve_financial_area afa_2" >
        
        <form action ="personal_info2.php" method="POST" enctype="multipart/form-data">
            
            <input type="text" name="f_name" value="<?php echo $f_name; ?>" style="display:none"> 
            <input type="text" name="m_name" value="<?php echo $m_name; ?>" style="display:none"> 
            <input type="text" name="l_name" value="<?php echo $l_name; ?>" style="display:none"> 
            
            <input type="text" name="emaill" value="<?php echo $email; ?>"style="display:none">        
            <input type="text" name="pass" value="<?php echo $pass; ?>" style="display:none"> 
            <input type="text" name="phonee" value="<?php echo $phone; ?>" style="display:none"> 
            Your Demo Code:<input type="text" name="api_code" id="apicode" value="<?php echo $num; ?>"> 
            <input type="text" name="key" id="apicodee" value="<?php echo $u_key; ?>" style="display:none;"> 
             <input type="text" name="status" value="<?php echo $status_application; ?>"style="display:none">   
            
        <div class="container"> 
        
     <div class="row">
            <div class="col-lg-6">
     <label for="usr">Enter Code That You Recieved On Your Phone</label>
      <input name="code"   id="appcode" type="text" class="form-control" id="usr" placeholder="Add Code" value="">
    </div> 
    </div>
    
    <br>
    <button name="btn-submit" type="submit" id="btnSubmit" class="theme_btn" href="">Verify Your Phone</button>
    
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
    
     <!-- Code Validation -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#btnSubmit").click(function () {
                var password = $("#apicode").val();
                var confirmPassword = $("#appcode").val();
                if (password != confirmPassword) {
                    alert("Code do not match. Please Enter Correct Code.");
                    return false;
                }
                return true;
            });
        });
    </script>
    
    
</body>

</html>