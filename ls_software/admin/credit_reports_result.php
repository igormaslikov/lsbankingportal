<?php
error_reporting(0);
session_start();
include_once 'dbconnect.php';

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
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['email']; ?></title>

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />

<link rel="stylesheet" href="css/style1.css">  
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="style.css" type="text/css" />
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


</head>
<body>

<?php include('menu.php') ;?>

<br>
<br>

  <section class="wrapper">
    <!-- Row title -->

<br><br>
 
   



<?php

$keyword = $_GET['keyword'];
$sql_cr=mysqli_query($con, "select * from tbl_credit_report "); 
if ($result_t=$sql_cr)
  {
  
  $rowcount=mysqli_num_rows($result_t);

  $ye=mysqli_free_result($result_t);

  }



?>

<div style="width:100%; margin:0 auto;">

<form action="credit_reports_result.php" method="GET">
   
   <table class="table table-striped tasks-table" id="table_bg">
<thead align="center">
<tr>
  <td></td>
  <td></td>
  <td></td>
<td colspan="2" style="font-weight: bold;">
          
Search By Name
<input type="text" id="search" class="form-control" name="keyword" placeholder="" value="<?php echo $_GET['keyword'];?>">

  
</td>
<td style="padding: 0px;width: 79px;vertical-align: none;    line-height: 0;">
    
<button style="background-color: #1E90FF;color: white;border-color: #1E90FF;" name="search" type="submit" class="btn btn-danger">Search</button>
</td>
<td></td>
  <td></td>
  <td></td>
</tr>
</thead>

</table>
    
    
</form>
<table class="table table-striped table-bordered">
<thead>
<tr style="background-color: #F5E09E;color: white;">
<th style='width:50px;color:black;'>APP ID</th>
<th style='width:50px;color:black;'>Customer Name</th>
<th style='width:50px;color:black;'>SSN</th>
<th style='width:50px;color:black;'>Score</th>
<th style='width:20px;color:black;'></th>
</tr>
</thead>
<tbody>
    
<?php
include('db.php');
$count=1;


$keyword = $_GET['keyword'];
    $result = mysqli_query($con,"SELECT * FROM `fnd_user_profile` where CONCAT(`first_name`, `last_name`, `email`, `mobile_number` , `dl_code`, `ssn` ) LIKE '%".$keyword."%'");
    while($row = mysqli_fetch_array($result)){
        
        //$app_id=$row['user_fnd_id'];
        $user_id=$row['user_fnd_id'];
        $name = $row['first_name']. " " . $row['last_name'];
        
$ssn=$row['ssn'];
        //$score=$row['score'];
        //$credit_report_key=$row['credit_report_key'];
        
      $sql_cr=mysqli_query($con, "SELECT * FROM `tbl_credit_report` where `user_fnd_id` = '$user_id' AND score>0 ORDER BY credit_report_key DESC "); 

while($row_cr = mysqli_fetch_array($sql_cr)) {

        $app_id=$row_cr['user_fnd_id'];
        
        $score=$row_cr['score'];
        $credit_report_key=$row_cr['credit_report_key'];
 
   $newDate_payment = date("m-d-y", strtotime($origDate_payment));

		echo "<tr>
	 	      
			  <td>".$app_id."</td>
			  <td>".$name." ".$last_name."</td>
			  <td>".$ssn."</td>
			  <td>".$score."</td>
		   	  
		   	  
		 
<td><a href='credit_report_exsiting.php?key=$credit_report_key' title='View Credit Report'><span class='glyphicon glyphicon-search' aria-hidden='true' alt='View Credit Report'></span></a>
</td>

		   	  </tr>";
        }
    }
    }
	mysqli_close($con);
    ?>
   
</tbody>
</table>






<br /><br />

</div>

    
  </section>

  <style>
      .navbar-default{
          background-color:#fb3f06 !important;
      }
      
  </style>

</body>
</html>

