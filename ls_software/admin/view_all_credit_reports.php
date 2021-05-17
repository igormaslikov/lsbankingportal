<?php
error_reporting(0);
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


<link rel="stylesheet" href="../paging/css/bootstrap.min.css">

<link rel="stylesheet" href="css/style1.css">  
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>


</head>
<body>

<?php include('menu.php') ;?>

<br>
<br>


  <section class="wrapper">
    <!-- Row title -->
<br>

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
<input type="text" id="search" class="form-control" name="keyword" placeholder="" value="">

  
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
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';;
$count=1;
if (isset($_GET['page_no']) && $_GET['page_no']!="") {
	$page_no = $_GET['page_no'];
	$count = $count + (25*($page_no-1));
	} else {
		$page_no = 1;
        }

	$total_records_per_page = 50;
    $offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2"; 

	$result_count = mysqli_query($con,"SELECT COUNT(*) As total_records FROM `tbl_credit_report` ORDER BY credit_report_key DESC");
	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1

    $result = mysqli_query($con,"SELECT * FROM `tbl_credit_report` ORDER BY credit_report_key DESC LIMIT $offset, $total_records_per_page");
    while($row = mysqli_fetch_array($result)){
		        $app_id=$row['user_fnd_id'];
        
        $score=$row['score'];
        $credit_report_key=$row['credit_report_key'];
        
		$new_creationDate = date("m-d-y H:i:s", strtotime($creation_date));
		 //echo "<br><br><br><br><br><br>". $access_id;
		 $access_level_name = "";
		 $sql_access=mysqli_query($con, "select * from fnd_user_profile where user_fnd_id= '$app_id'"); 

while($row_access = mysqli_fetch_array($sql_access)) {

$first_name=$row_access['first_name'];
$last_name=$row_access['last_name'];
$ssn=$row_access['ssn'];

	//	echo "<br><br><br><br><br><br>". $access_level_name;


	echo "<tr>
	 	      
			  <td>".$app_id."</td>
			  <td>".$first_name." ".$last_name."</td>
			  <td>".$ssn."</td>
			  <td>".$score."</td>
		   	  
		   	  
		 
<td><a href='credit_report_exsiting.php?key=$credit_report_key' title='View Credit Report'><span class='glyphicon glyphicon-search' aria-hidden='true' alt='View Credit Report'></span></a>
</td>

		   	  </tr>";
}
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