<?php

//Database credentials
$servername = "mymoneyline.com/lsbankingportal/";
$dbname = 'dbs57337';
$dbUsername = 'dblsuser2021';
$dbPassword = '^%D24L*!Ti5%';




// Create connection
$conn = new mysqli($servername,  $dbUsername, $dbPassword,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


//echo "Connected successfully";



//This code runs if the form has been submitted

if (isset($_POST['btn-login']))
{
 
// check for valid email address
$email = $_POST['email'];

 
// checks if the username is in use
$sql=mysqli_query($conn, "select * from tbl_users WHERE email = '$email'"); 

$count =mysqli_num_rows($sql);

if($count > 0)

{
    
    
    $code = mt_rand(1000, 9999); 
    
   // echo $code;
    
$to = $email;

$subject = "New Password Reset Code";
$txt = "Please Use This Code: $code  to Reset your Password";
$headers = "From: info@lsbanking.com";

mail($to,$subject,$txt,$headers);
 
    ?>
    
    <html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LS Financing - Password Reset</title>
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
   <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="app.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  

</head>
<body>

<div class="container" id="pagewrapper">

<div class="logoheader">
   <br>
    Please check your email!
    <h3 id="heading"> Enter Your Code Here! </h3>
     
    </div>

	<div id="login-form">
    <form method="post" action="update_password.php" autocomplete="off">
    
            <input type="text" name="randcode" style="display:none" value="<?php echo $code;?>" />
            
            <input type="text" name="email" style="display:none" value="<?php echo $email;?>" />
            
            <div class="form-row">
            <div class="col-md-12 mb-3">
            <!--<label for="code01">Your Code:</label>-->
            <input id="code01" type="text" name="code" class="form-control" placeholder="Your Code" value="" maxlength="40" />
            </div>
            </div>
            
            <div class="container proceedbutton">
            	<button type="submit" class="btn btn-primary" name="btn-Proceed">Proceed</button>
            </div>
            
            <div>
             
            </div>
       
        </form>

</div>

</body>
</html>
    
    
    
<?php    
}


else {
    echo '<script type="text/javascript">'; 
echo 'alert("Email Does not Exist ! Re Enter Your Email");'; 
echo 'window.location.href = "forgotpass.php";';
echo '</script>';
    }
    

while($row = mysqli_fetch_array($sql)) {


$new_password =$row[4];


//echo $new_password;
}

}


?>


