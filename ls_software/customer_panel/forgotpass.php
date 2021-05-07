<!DOCTYPE html>
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
    <h3 id="heading"> Forgot Password? </h3>
    <p> Enter your email address to reset your password.  
    </div>

	<div id="login-form">
    <form method="post" action="new_code.php" autocomplete="off">
    
            
            <div class="form-row">
            <div class="col-md-12 mb-3">
            <label for="email01">Email Address</label>
            <input id="email01" type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>" maxlength="40" />
            </div>
            </div>
            
            <div class="container proceedbutton">
            	<button type="submit" class="btn btn-primary" name="btn-login">Reset Password</button>
            </div>
            
            <div>
              <hr>
            </div>
       
        </form>

        <div>
           <a href="user_login.php">Log In Here</a>
        </div>
        
</div>

</body>
</html>
