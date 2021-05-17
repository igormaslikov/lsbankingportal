<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

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

$id_loan=$_GET['id'];

$query_us = mysqli_query($con,"SELECT amount_of_loan FROM tbl_loan WHERE loan_id='$id_loan'");
while ($row_us=mysqli_fetch_array($query_us)){
    $us = $row_us['amount_of_loan'];
   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$us;

}


$query_le = mysqli_query($con,"SELECT amount_left FROM tbl_loan WHERE loan_id='$id_loan'");
while ($row_le=mysqli_fetch_array($query_le)){
    $am_le = $row_le['amount_left'];
   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$am_le;

}

$pay_off= $us-$am_le;
$avg_pay_off= $am_le/$rowcount;

$avg_pay=round($avg_pay_off, 2);

$avg_amount=$us/$rowcount;

$avg=round($avg_amount, 2);


mysqli_close($con);
?>
<div align="right">
<a href="add_new_transaction.php?loan_id=<?php echo $_GET['id']; ?>"> <button name="btn-submit" type="submit" class="btn btn-danger" style="color: #fff;background-color: blue;border-color: blue;">Add New Transcation</button></a>

</div>
<br>
<h4  style="float:left;"> Total Loan Amount: $<?php echo $us;?>  </h4>
<h4  style="float:right;"> Loan Amount Left: $<?php echo $am_le;?>  </h4>
<br><br>
<h4  style="float:right;display:none;"> Total Payoff Amount: $<?php echo $pay_off;?>  </h4>
<h4  style="float:right;display:none;"> Loan Amount Left: $<?php echo $am_le;?>  </h4>

<h4  style="float:left;"> Total Payoff Amount: $<?php echo $pay_off;?>  </h4>
<h4  style="float:right;"> Amount To Be Paid/Per Month: $<?php echo $pay_off;?>  </h4>
<br>


<div style="width:100%; margin:0 auto;">


<table class="table table-striped table-bordered">
<thead>
<tr style="background-color: blue;color: white;">
<th style='width:30px;'>Sr #</th>
<th style='width:100px;'>Loan Amount</th>
<th style='width:100px;'>Amount Left</th>
<th style='width:100px;'>Next Payment Date</th>
<th style='width:30px;'>Payment Tenure</th>
<th style='width:50px;'>Action</th>
</tr>
</thead>
<tbody>
    
    
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';;
$id_loan=$_GET['id'];
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

    $result = mysqli_query($con,"SELECT * FROM `tbl_loan` where loan_id='$id_loan' ORDER BY loan_id DESC LIMIT $offset, $total_records_per_page");
    while($row = mysqli_fetch_array($result)){
		 $id=$row['loan_id'];
		echo "<tr>
	 	      
			  <td>".$count++."</td>
			  <td>".$row['amount_of_loan']."</td>
	 		  <td>".$row['amount_left']."</td>
	 		  <td>".$row['next_payment_date']."</td>
		   	  <td>".$row['payment_tenure']."</td>
		   	  
<td><a href='edit_loan.php?id=$id' title='Edit This Company'><span class='glyphicon glyphicon-edit' aria-hidden='true' alt='edit'></span></a>

</td>

		   	  </tr>";
        }
	mysqli_close($con);
    ?>
    
</tbody>
</table>

<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
<strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
</div>

<ul class="pagination">
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

    
  </section>

  <style>
      .navbar-default{
          background-color:#fb3f06 !important;
      }
      
  </style>

</body>
</html>

<?php
}
?>