<?php
session_start();
include_once 'dbconnect.php';
include 'dbconfig.php';

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


$id=$_GET['id'];



$sql=mysqli_query($con, "select * from tbl_loan where loan_id= '$id'"); 

while($row = mysqli_fetch_array($sql)) {


$fnd_id=$row['user_fnd_id'];
//echo "fndis is:".$fnd_id;
$amount_loan=$row['amount_of_loan'];
$amount_left =$row['amount_left'];
$bg_id=$row['bg_id'];
$next_payment =$row['next_payment_date'];
$payment_tenure =$row['payment_tenure'];
$escrow=$row['escrow'];
$primary_port=$row['primary_portfolio'];
$creation_date=$row['creation_date'];
$created_by=$row['created_by'];
$last_update=$row['last_update_by'];
$last_update_date=$row['last_update_date'];
}


$sql=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$fnd_id'"); 

while($row = mysqli_fetch_array($sql)) {

$first_name=$row['first_name'];

}

//echo "fname is:".$first_name;


$sql=mysqli_query($con, "select * from tbl_users where user_id= '$created_by'"); 

while($row = mysqli_fetch_array($sql)) {

$username=$row['username'];

}

//echo "fname is:".$username;


$sql=mysqli_query($con, "select * from tbl_users where user_id= '$last_update'"); 

while($row = mysqli_fetch_array($sql)) {

$username_update=$row['username'];

}

//echo "fname is:".$username_update;



$id_type=$_GET['id'];


$sql_loan_type=mysqli_query($con, "select * from tbl_loan_type where loan_type_id='$id_type'"); 

while($row_loan_type = mysqli_fetch_array($sql_loan_type)) {

//$loan_type_id=$row['loan_type_id'];
$loan_type=$row_loan_type['loan_type'];

}



$id_calcul=$_GET['id'];


$sql_calcul=mysqli_query($con, "select * from tbl_loan_calculation where loan_cal_id='$id_calcul'"); 

while($row_calcul = mysqli_fetch_array($sql_calcul)) {

//$loan_cal_id=$row_calcul['loan_cal_id'];
$loan_calcu=$row_calcul['loan_calculation'];

}



$id_clasi=$_GET['id'];



$sql_clasi=mysqli_query($con, "select * from tbl_loan_classification where loan_clasi_id='$id_clasi'"); 

while($row_clasi = mysqli_fetch_array($sql_clasi)) {

//$loan_clasi_id=$row_clasi['loan_clasi_id'];
$loan_calssifi=$row_clasi['loan_classification'];

}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    
   <style>

.sidenav {
 width: 220px;
 position: absolute;
 z-index: 1;
 top: 3px;
 left: -143px;
 background: #1E90FF;
 overflow-x: hidden;
 padding: 20px 0;
}
    
    
    .sidenav a {
 padding: 0px 0px 0px 7px;
 text-decoration: none;
 font-size: 15px;
 color: white;
 display: block;
}

.sidenav a:hover {
 color: white;
}
    
</style>
    
    
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


<div align="right">
<a href="add_notes.php?id=<?php echo $_GET['id']; ?>"> <button name="btn-submit" type="submit" class="btn btn-danger" style="background-color: #1E90FF;color: white;border-color: #1E90FF;">Add New Notes</button></a>

</div>
<br>

<br>
<div class="container">
    
      <div class="col-lg-2">
           
           <div class="sidenav">
 <a href="loan_summary.php?id=<?php echo $id; ?>" style="padding: 7px;border-bottom: 1px solid;text-align: center;">Loan Summary</a>
 
 <a href="edit_customer.php?id=<?php echo $fnd_id; ?>" style="padding: 7px;border-bottom: 1px solid;text-align: center;">Borrower Information </a>
 
 <a href="loan_notes.php?id=<?php echo $id; ?>" style="padding: 7px;border-bottom: 1px solid;text-align: center;">Loan Notes</a>
 
 <a href="loan_payments.php?id=<?php echo $id; ?>" style="padding: 7px;border-bottom: 1px solid;text-align: center;">Loan Payments</a>
 
  <a href="#" style="padding: 7px;border-bottom: 1px solid;text-align: center;">Charges</a>
 
 <a href="#" style="padding: 7px;border-bottom: 1px solid;text-align: center;">Documents</a>
 
 <a href="#" style="padding: 7px;border-bottom: 1px solid;text-align: center;">Employer</a>
 
 <a href="edit_loan.php?id=<?php echo $id; ?>" style="padding: 7px;text-align: center;">Loan Settings</a>
 

</div>
            
            </div>
    
<div style="width:84%; margin:0 auto;">

<table class="table table-striped table-bordered">
<thead>
<tr style="background-color: #FFA500;color: white;">
<th style='width:30px;'>Sr #</th>
<th style='width:30px;'>Creation Date</th>
<th style='width:100px;'>Loan Notes</th>
<th style='width:30px;'>Category</th>
<th style='width:50px;'>Action</th>
</tr>
</thead>
<tbody>
    
    
<?php
$idd= $_GET['id'];
include('db.php');
$count=1;
if (isset($_GET['page_no']) && $_GET['page_no']!="") {
	$page_no = $_GET['page_no'];
	$count = $count + (25*($page_no-1));
	} else {
		$page_no = 1;
        }

	$total_records_per_page = 25;
    $offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2"; 

	$result_count = mysqli_query($con,"SELECT COUNT(*) As total_records FROM `tbl_loan`");
	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1

    $result = mysqli_query($con,"SELECT * FROM `tbl_loan_notes` where loan_id='$idd' ORDER BY loan_id DESC ");
    while($row = mysqli_fetch_array($result)){
		 $iddd=$row['loan_id'];
		 $i_note=$row['notes'];
		 $i_category=$row['category'];
		 $date=$row['created_at'];
		echo "<tr>
	 	      
			  <td>".$count++."</td>
			  <td>".$date."</td>
			  <td>".$i_note."</td>
	 		 <td>".$i_category."</td>
		   	  
<td><a href='edit_notes.php?id=$iddd' title='Edit Notes'><span class='glyphicon glyphicon-edit' aria-hidden='true' alt='edit'></span></a>
<a class='remove-box' href='delete_notes.php?id=$iddd' title='Delete Notes'><span class='glyphicon glyphicon-remove' aria-hidden='true' alt='edit'></span></a>
</td>

		   	  </tr>";
        }
	mysqli_close($con);
    ?>
   
   
  
    
    
</tbody>
</table>

<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;display:none;'>
<strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
</div>

<ul class="pagination" style="display:none;">
	<?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>
    
	<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
	<a <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?>>Previous</a>
	</li>
       
    <?php 
	if ($total_no_of_pages <= 10){  	 
		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
			if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}
        }
	}
	elseif($total_no_of_pages > 10){
		
	if($page_no <= 4) {			
	 for ($counter = 1; $counter < 8; $counter++){		 
			if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}
        }
		echo "<li><a>...</a></li>";
		echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
		echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
		}

	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
		echo "<li><a href='?page_no=1'>1</a></li>";
		echo "<li><a href='?page_no=2'>2</a></li>";
        echo "<li><a>...</a></li>";
        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
           if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}                  
       }
       echo "<li><a>...</a></li>";
	   echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
	   echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";      
            }
		
		else {
        echo "<li><a href='?page_no=1'>1</a></li>";
		echo "<li><a href='?page_no=2'>2</a></li>";
        echo "<li><a>...</a></li>";

        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
          if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}                   
                }
            }
	}
?>
    
	<li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
	<a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?>>Next</a>
	</li>
    <?php if($page_no < $total_no_of_pages){
		echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
		} ?>
</ul>


<br /><br />
</div>
</div>

    
  </section>

  <style>
      .navbar-default{
          background-color:#fb3f06 !important;
      }
      
  </style>
<script type="text/javascript">
    $('.remove-box').on('click', function () {
     var x =  confirm('Are you sure you want to delete?');
     if (x)
     return true;
 else
   return false;
     
   });
</script>
</body>
</html>
