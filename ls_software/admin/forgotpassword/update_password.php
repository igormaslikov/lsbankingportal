<?php

include '../dbconnect.php';
include '../dbconfig.php';

if (isset($_POST['btn-update']))
{
    
        $email = $_POST["email"];
        $pass = trim($_POST['newpassword']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass );
        $cpass = trim($_POST['confrimpass']);
		$cpass = strip_tags($cpass);
        $cpass = htmlspecialchars($cpass);
 
if ($pass === $cpass) {
    
		// password encrypt using SHA256();
		//$password = hash('sha256', $cpass);
    
     $password = password_hash($cpass, PASSWORD_DEFAULT);
     
        mysqli_query($con, "Update `tbl_users` SET `password`='$password' where email ='$email'");

       echo '<script type="text/javascript">'; 
echo 'alert("Password  Updated Successfully");'; 
echo 'window.location.href = "../index.php";';
echo '</script>';
}
else {
     echo '<script type="text/javascript">'; 
echo 'alert("Error In Password Please write again");'; 
//echo 'window.location.href = "index.php";';
echo '</script>';




 
// check for valid email address
$email = $_POST['email'];

$randcode = $_POST['randcode'];

$code = $_POST['code'];



if($randcode == "$code")

{
    
    
    
    ?>
    
    
    <html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Optima Financial Solutions Inc - Password Reset</title>
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
    
    <h3 id="heading"> Set New Password Here! </h3>
     
    </div>

	<div id="login-form">
    <form method="post" action="#" autocomplete="off">
    
          <input type="text" name="email" style="display:none" value="<?php echo $email;?>" />
          
            <div class="form-row">
            <div class="col-md-12 mb-3">
            <label for="newpassword01">New Password</label>
            <input id="newpassword01" type="password" name="newpassword" class="form-control" placeholder="New Password" value="" maxlength="40" />
            </div>
            <span class="text-danger"><?php echo $passError; ?></span>
            </div>
            
<input type="text" style="display:none;" name = "email" value="<?php echo $email;?>"/>
<input type="text" style="display:none;" name = "randcode" value="<?php echo $randcode;?>"/>
<input type="text" style="display:none;" name = "code" value="<?php echo $code;?>"/>
             <div class="form-row">
            <div class="col-md-12 mb-3">
            <label for="confrimpass01">Confirm Password</label>
            <input id="confrimpass01" type="password" name="confrimpass" class="form-control" placeholder="Confirm Password" value="" maxlength="40" />
            </div>
            <span class="text-danger"><?php echo $cpassError; ?></span>
            </div>
            
            <div class="container proceedbutton">
            	<button type="submit" class="btn btn-primary" name="btn-update">Update Password</button>
            </div>
            
            <div>
              
            </div>
            
        </form>

        <div style="display:none">
           <a href="../index.php">Log In Here</a>
        </div>
        
</div>

</body>
</html>
    
    
    
    
    <?php
    
    
    
}


else {
    
       echo '<script type="text/javascript">'; 
echo 'alert("Code Doesnot Match ! Try Again");'; 
echo 'window.location.href = "forgotpass.php";';
echo '</script>';

}


}
			

}


if (isset($_POST['btn-Proceed']))
{
 
// check for valid email address
$email = $_POST['email'];

$randcode = $_POST['randcode'];

$code = $_POST['code'];



if($randcode == "$code")

{
    
    
    
    ?>
    
    
    <html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Optima Financial Solutions Inc - Password Reset</title>
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
  
    <h3 id="heading"> Set New Password Here! </h3>
     
    </div>

	<div id="login-form">
    <form method="post" action="#" autocomplete="off">
    
          <input type="text" name="email" style="display:none" value="<?php echo $email;?>" />
          
            <div class="form-row">
            <div class="col-md-12 mb-3">
            <label for="newpassword01">New Password</label>
            <input id="newpassword01" type="password" name="newpassword" class="form-control" placeholder="New Password" value="" maxlength="40" />
            </div>
            <span class="text-danger"><?php echo $passError; ?></span>
            </div>
            
<input type="text" style="display:none;" name = "email" value="<?php echo $email;?>"/>
<input type="text" style="display:none;" name = "randcode" value="<?php echo $randcode;?>"/>
<input type="text" style="display:none;" name = "code" value="<?php echo $code;?>"/>
             <div class="form-row">
            <div class="col-md-12 mb-3">
            <label for="confrimpass01">Confirm Password</label>
            <input id="confrimpass01" type="password" name="confrimpass" class="form-control" placeholder="Confirm Password" value="" maxlength="40" />
            </div>
            <span class="text-danger"><?php echo $cpassError; ?></span>
            </div>
            
            <div class="container proceedbutton">
            	<button type="submit" class="btn btn-primary" name="btn-update">Update Password</button>
            </div>
            
            <div>
              
            </div>
            
        </form>

        <div style="display:none">
           <a href="../index.php">Log In Here</a>
        </div>
        
</div>

</body>
</html>
    
    <?php
    
    
    
}


else {
    
       echo '<script type="text/javascript">'; 
echo 'alert("Code Doesnot Match ! Try Again");'; 
echo 'window.location.href = "forgotpass.php";';
echo '</script>';

}


}

?>


