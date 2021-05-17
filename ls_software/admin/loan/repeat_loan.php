<?php
error_reporting(0);
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: ../index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$u_id=$userRow['user_id'];
$u_access_id = $userRow['access_id'];
if($u_access_id=='2' || $u_access_id=='4' || $u_access_id=='5'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
 
}
else {
$DBcon->close();

?>



<?php



 $id=$_GET['id'];
 
$sql_fnd=mysqli_query($con, "select DISTINCT user_fnd_id
from tbl_loan"); 



while($row_fnd = mysqli_fetch_array($sql_fnd)) {

$user_fnd_id=$row_fnd['user_fnd_id'];
//echo "FND_ID" .$user_fnd_id."<br>";


$query_search = "SELECT * FROM `tbl_loan` where user_fnd_id= '$user_fnd_id'";

if ($result_t=mysqli_query($con,$query_search))
  {
  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($result_t);
 // printf($rowcount);
  // Free result set
  $ye=mysqli_free_result($result_t);
 // echo $rowcount;
  
   
   
   $sql_dup = "SELECT * FROM tbl_repeat_loan WHERE `user_fnd_id` = '$user_fnd_id'";
        $result_dup = mysqli_query($con, $sql_dup);

       if(mysqli_num_rows($result_dup) > 0)
       {
           mysqli_query($con, "UPDATE tbl_repeat_loan SET  loan_count='$rowcount'  where user_fnd_id ='$user_fnd_id'");
     }
       else
       {  
  
  
      $query_emp  = "INSERT INTO tbl_repeat_loan (user_fnd_id,loan_count)  VALUES ('$user_fnd_id','$rowcount')";
        $result_emp = mysqli_query($con, $query_emp);
        if ($result_emp) {
         //echo "<div class='form'><h3> successfully added in tbl_repeat_loan.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        } 
       }
  
  
  }


}


?>

<?php
$query_loan= "SELECT * FROM `tbl_loan`";
if ($result_loan=mysqli_query($con,$query_loan))
  {
  // Return the number of rows in result set
  $rowcount_loan=mysqli_num_rows($result_loan);
 // printf($rowcount);
  // Free result set
  $ye_loan=mysqli_free_result($result_loan);
  //echo $ye_loan;
  }


?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">


  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/simple-sidebar.css" rel="stylesheet">

</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

     
      
<br><br>
      
         <div class="container-fluid" style="width:100%; margin:0 auto;">
        <div class="row">
            <div class="col-lg-6">
        <h3>Totals Payday Loan Summary: </h3>
        </div>
        
         <div  style="margin-left:-88px;">
        <h3>Total Loans: <?php echo $rowcount_loan;?></h3>
        </div>
        </div>
        <br>
        <table class="table table-striped table-bordered">
<thead>
<tr style="background-color: #F5E09E;color: black;">
<th style='width:50%;text-align:center'>Repeat Loan Summary</th>
</tr>
</thead>
<tbody>
    
    
<?php  

for($i=1;$i<31;$i++)
{
    
   $j=$i; 
  $sql_sumary = "SELECT * FROM tbl_repeat_loan where loan_count='$i'";
 

if ($result_sumary=mysqli_query($con,$sql_sumary))
  {
  // Return the number of rows in result set
  $rowcount_sumary=mysqli_num_rows($result_sumary);
 // printf($rowcount);
  // Free result set
  $ye=mysqli_free_result($result_sumary);
  }
 // echo $rowcount_sumary;


        
        echo"<tr>
        
        <td style='text-align:center'>$i <span style='margin-left:90px;'>$rowcount_sumary</span></td>
        
        </tr>";


}
	
    ?>
   
</tbody>
</table>
<br>

   

</div>
        
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
<?php
}
?>
</body>

</html>
