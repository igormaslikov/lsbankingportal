<?php
session_start();
include_once 'dbconnect.php';
include('functions.php');
if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$u_id=$userRow['user_id'];

$u_access_id = $userRow['access_id'];
if($u_access_id=='0'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}
else {
$DBcon->close();

?>










<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta charset="gb18030">

<title>Welcome - <?php echo $userRow['email']; ?></title>

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />

</head>
<body>

<?php include('menu.php') ;?>
  
 
  
  <?php 
  $cu_id= $_GET['id'];
  $phone= $_GET['phone'];
  $fname=$_GET['f_name'];
  $message = "Hola ".$fname.", 
  
  Gracias por aplicar con LS Financing. Su aplicación fue recibida, ahora necesitamos verificar sus ingresos enviando el último estado de cuenta de su banco y para esto tenemos la siguientes opciones: - Texto: (818) 452-0541 - Fax: (888) 688-4925 - Email: denice@lsbanking.com";
  send_sms($phone,$message);
  ?>
  
  <br><br><br><br>
  <h2 align="center"> Congratulations message has been sent to <?php echo $fname; ?> </h2>
   
  <a href="edit_customer.php?id=<?php echo $cu_id ;?>&f_name=<?php echo $fname;?>&phone=<?php echo $phone;?>" <button name="newloan" type="submit" class="btn btn-danger" style="background-image: linear-gradient(to bottom,#1E90FF 0,#1E90FF 100%);color: #fff;background-color: #1E90FF;border-color: #1E90FF;center;margin-left: 45%;margin-top: 2%;">Go Back</button> </a>

  </html>
  </body>
<?php
}
?>

    
  