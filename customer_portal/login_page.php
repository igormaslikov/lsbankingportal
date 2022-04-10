<?php
session_start();
require_once 'dbconnect.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pacifica Finance Group Admin Login</title>
<link href="bootstrap/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<div class="signin-form">

	<div class="container">
     
        
       <form class="form-signin" method="post" id="login-form">
        <img src="pacifica.jpeg" style="width:100%"/>
        <h2 class="form-signin-heading" style="text-align:center">Customer Panel</h2><hr />
        
        <?php
		if(isset($msg)){
			echo $msg;
		}
		?>
        
        <div class="form-group">
        <input type="email" class="form-control" placeholder="Email address" name="email" required />
        <span id="check-e"></span>
        </div>
        
        <div class="form-group">
        <input type="password" class="form-control" placeholder="Password" name="mobile_number" required />
        </div>
       
     	<hr />
        
        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-login" id="btn-login">
    		<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
			</button> 
            
           <!-- <a href="register.php" style="display:none;" class="btn btn-default" style="float:right;">Sign UP Here</a>-->
          <!--  <a href="forgotpassword/forgotpass.php"  style="float:right;">Forgot Password</a>-->
        </div>  
        
      </form>

    </div>
    
</div>

</body>
</html>
<?php  
  
require_once 'dbconnect.php'; 
  
if(isset($_POST['btn-login']))  
{  
    $user_email=$_POST['email'];  
    $user_pass=$_POST['mobile_number']; 
    $user_fnd_id=$_POST['user_fnd_id'];
  
    $check_user="select * from fnd_user_profile WHERE email='$user_email'AND mobile_number='$user_pass'";  
  
    $run=mysqli_query($DBcon,$check_user);  
    echo "is sis:".$user_fnd_id;
    if(mysqli_num_rows($run))  
    {  
        echo "<script>window.open('home.php','_self')</script>";  
  
        $_SESSION['email']=$user_email;//here session is used and value of $user_email store in $_SESSION.  
  
    }  
    else  
    {  
      echo "<script>alert('Email or password is incorrect!')</script>";  
    }  
}  
?> 