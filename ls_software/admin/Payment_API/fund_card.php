<?php
error_reporting(0);
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_api_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$DBcon->close();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LS Financing Registration</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="style.css" type="text/css" />

</head>
<body>
<?php include('menu.php') ;?>
<div class="signin-form">

	<div class="container">
     
        
       <form action="fund_card_API.php" class="form-signin" method="POST" id="register-form" >
      
        <h2 class="form-signin-heading">Fund A Card</h2><hr />
        
        <?php
		if (isset($msg)) {
			echo $msg;
		}
		?>
          
        <div class="form-group">
            <label for="fname">Customer ID*</label>
    <input type="text" class="form-control" id="customer_id" name="customer_id" placeholder="Customer ID.." >
        </div>
        
        <div class="form-group">
        <label for="fname">Amount*</label>
    <input type="text" id="amount" class="form-control" name="amount" placeholder="Amount.." >    
        </div>
        
        
        
       
     
   
    <!--     <div class="form-group">-->
    <!--    <label for="lname">Zip Code*</label>-->
    <!--<input type="text" id="zip_code" class="form-control" name="zip_code" placeholder="Your Zip code.." required>-->
    <!--    </div>-->
        
     	<hr />
        
        <div class="form-group">
                <button type="submit" class="btn btn-default" name="submit">
    		<span class=""></span> &nbsp; Fund Now
			</button> 
        </div> 
      
      </form>

    </div>
    
</div>

</body>
</html>