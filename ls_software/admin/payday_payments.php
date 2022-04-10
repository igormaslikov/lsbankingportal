<?php
 session_start();
 error_reporting(0);
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
 else {
 $DBcon->close();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="typeahead.min.js"></script>
    
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['email']; ?></title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="style.css" type="text/css" />
<link rel="stylesheet" href="../paging/css/bootstrap.min.css">
<link rel="stylesheet" href="css/style1.css">  
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
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



  <section class="wrapper" style="font-size:15px !important">
    <!-- Row title -->
  
 <br><br>
 <?php

    $query_search = "SELECT * FROM `loan_transaction` WHERE `payment_method` = 'Repay'
  order by transaction_id DESC";
    $status  = $_GET['status'];
// echo $query_search;
 $result111 = mysqli_query($con,"$query_search");
?> 
  

<div style="width:100%; margin:0 auto;">

<table class="table table-striped table-bordered"  style="font-size:16px !important">
 <h3>PAYDAY Payments</h3>
<thead>
<tr style="background-color: #F5E09E;color: white;">
<th style='width:5%;color:black;'>ID</th>
<th style='width:5%;color:black;'>Loan ID</th>
<th style='width:5%;color:black;'>Customer ID</th>
<th style='width:15%;color:black;'>Customer Name</th>
<th style='width:13%;color:black;'>Payment Amount</th>
<th style='width:15%;color:black;'>Payment Method</th>
<th style='width:35%;color:black;'>Status</th>
</tr>
</thead>
<tbody>
<?php

while($row_fnd_idd = mysqli_fetch_array($result111)) {

$user_fnd_idd=$row_fnd_idd['user_fnd_id'];




    $query_search1 = "SELECT * FROM `fnd_user_profile` WHERE `user_fnd_id` = '$user_fnd_idd'
";

// echo $query_search;
    $result = mysqli_query($con,"$query_search1");
    while($row = mysqli_fetch_array($result)){
        
		
		 $name_customer = $row['first_name'] . " " .$row['last_name'];
	//	 echo $name_customer;
		
    }
//echo $newDate;

if($row_fnd_idd['payoff_amount']<1){
    $repay_response = "<b style='color:red'>".$row_fnd_idd['type_of_payment']."</b>";
}
else {
     $repay_response = "Succesful Payment : ". $row_fnd_idd['payoff_amount']. "$";
}

//$gravatar = "https://www.gravatar.com/avatar/".md5($row['email']);
//$gravatar = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $row['email'] ) ) );
$gravatar =  "http://profiles.google.com/s2/photos/profile/". $row['email']."?sz=";
		echo "<tr ".$string_red_rejected. " ".$bold_app. ">
	 	      
			  <td>".$row_fnd_idd['transaction_id']."</td>
			  <td>".$row_fnd_idd['loan_create_id']." </td>
			  <td>".$user_fnd_idd."</td>
			  <td>".$name_customer."</td>
	 		  <td>".$row_fnd_idd['payoff_amount']."</td>
	 		  <td>".$row_fnd_idd['payment_method']."</td>
	 		  <td>".$repay_response."</td>
		   	  
<td> <a href='https://www.pacificafinancegroup.com/loanportal/ls_software/admin/view_all_payday_loans.php' title='View Loan'><span class='glyphicon glyphicon-edit' aria-hidden='true' alt='edit'></span></a>



</td>

	   	  </tr>";
	   	  $decision_logic_Status = "";
	   	  $experian_credit_score = "";
       
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
	<a <?php if($page_no > 1){ echo "href='?page_no=$previous_page&$delete_customer_pagination'"; } ?>>Previous</a>
	</li>
       
    <?php 
	if ($total_no_of_pages <= 10){  	 
		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
			if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter&$delete_customer_pagination'>$counter</a></li>";
				}
        }
	}
	elseif($total_no_of_pages > 10){
		
	if($page_no <= 4) {			
	 for ($counter = 1; $counter < 8; $counter++){		 
			if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter&$delete_customer_pagination'>$counter</a></li>";
				}
        }
		echo "<li><a>...</a></li>";
		echo "<li><a href='?page_no=$second_last&$delete_customer_pagination'>$second_last</a></li>";
		echo "<li><a href='?page_no=$total_no_of_pages&$delete_customer_pagination'>$total_no_of_pages</a></li>";
		}

	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
		echo "<li><a href='?page_no=1'>1</a></li>";
		echo "<li><a href='?page_no=2'>2</a></li>";
        echo "<li><a>...</a></li>";
        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
           if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter&$delete_customer_pagination'>$counter</a></li>";
				}                  
       }
       echo "<li><a>...</a></li>";
	   echo "<li><a href='?page_no=$second_last&$delete_customer_pagination'>$second_last</a></li>";
	   echo "<li><a href='?page_no=$total_no_of_pages&$delete_customer_pagination'>$total_no_of_pages</a></li>";      
            }
		
		else {
        echo "<li><a href='?page_no=1'>1</a></li>";
		echo "<li><a href='?page_no=2'>2</a></li>";
        echo "<li><a>...</a></li>";

        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
          if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter&$delete_customer_pagination'>$counter</a></li>";
				}                   
                }
            }
	}
?>
    
	<li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
	<a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page&$delete_customer_pagination'"; } ?>>Next</a>
	</li>
    <?php if($page_no < $total_no_of_pages){
		echo "<li><a href='?page_no=$total_no_of_pages&$delete_customer_pagination'>Last &rsaquo;&rsaquo;</a></li>";
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

<?php
}
?>