<?php
session_start();
include_once 'dbconnect.php';
include_once 'dbconfig.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$u_id=$userRow['user_id'];
//echo $u_id;
$u_access_id = $userRow['access_id'];
if($u_access_id=='0'){
    echo "YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.";
}
else {
$DBcon->close();

?>

<?Php

//// Settings, change this to match your requirment //////
$start_year=2000; // Starting year for dropdown list box
$end_year=2040;  // Ending year for dropdown list box
////// end of settings ///////////
?>
<!doctype html public "-//w3c//dtd html 3.2//en">
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['email']; ?></title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">  
 
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




<link rel="canonical" href="#"/>
<script langauge="javascript">
function post_value(mm,dt,yy){
opener.document.f1.p_name.value = mm + "/" + dt + "/" + yy;
/// cheange the above line for different date format
self.close();
}

function reload(form){
var month_val=document.getElementById('month').value; // collect month value
var year_val=document.getElementById('year').value;      // collect year value
self.location='marketing.php?month=' + month_val + '&year=' + year_val ; // reload the page
}
</script>
<style type="text/css">
table.main {
    margin-top:35px;
    
  width: 100%; 
  height: 100%; 
border: 1px solid black;
	background-color: white;

}
table.main td {

font-family: verdana,arial, helvetica,  sans-serif;
font-size: 11px;
	text-align: center;
}
table.main th {
	border-width: 1px 1px 1px 1px;
	padding: 0px 0px 0px 0px;
    background-color: #1E90FF;
    color: white;
}
table.main a{TEXT-DECORATION: none;
    color: black;
}
table,td{ border: 1px solid #FFA500 }

</style>
</head>
<body>
    <?php include('menu.php') ;?>
  
<?php

$month=$_GET['month'];
$year=$_GET['year'];
//echo $year;

 
$sql=mysqli_query($con, "SELECT * FROM tbl_loan WHERE YEAR(creation_date) = $year AND MONTH(creation_date) = $month"); 

if ($result_tt=$sql)
  {
  // Return the number of rows in result set
  $rowcountt=mysqli_num_rows($result_tt);
  echo "Total record of this Month: $rowcountt<br>";
  // Free result set
  $ye=mysqli_free_result($result_tt);
 // echo $ye;
  }
?>

<?php

$month=$_GET['month'];
$year=$_GET['year'];
//echo $year;

$sql_leads=mysqli_query($con, "SELECT * FROM fnd_user_profile WHERE YEAR(creation_date) = $year AND MONTH(creation_date) = $month"); 

if ($result_leads=$sql_leads)
  {
  // Return the number of rows in result set
  $rowcountt_leads=mysqli_num_rows($result_leads);
  //echo "Total record of this Month: $rowcountt_leads<br>";
  // Free result set
  $yee=mysqli_free_result($result_leads);
 // echo $yee;
  }
?>

 <?Php

$month=$_GET['month'];
$year=$_GET['year'];


if(!($month <13 and $month >0)){
$month =date("m");  // Current month as default month
}

if(!($year <=$end_year and $year >=$start_year)){
$year =date("Y");  // Set current year as default year 
}

$d= 2; // To Finds today's date
//$no_of_days = date('t',mktime(0,0,0,$month,1,$year)); //This is to calculate number of days in a month
$no_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);//calculate number of days in a month

$j= date('w',mktime(0,0,0,$month,1,$year)); // This will calculate the week day of the first day of the month
  // echo $j;
$adj=str_repeat("<td bgcolor='#FFA500'>*&nbsp;</td>",$j);  // Blank starting cells of the calendar 
$blank_at_end=42-$j-$no_of_days; // Days left after the last day of the month
if($blank_at_end >= 7){$blank_at_end = $blank_at_end - 7 ;} 
$adj2=str_repeat("<td bgcolor='#FFA500'>*&nbsp;</td>",$blank_at_end); // Blank ending cells of the calendar

/// Starting of top line showing year and month to select ///////////////

echo "<table class='main'><td colspan=6 >

<select name=month value='' onchange=\"reload(this.form)\" id=\"month\" style='width: 25%;height: 30px;'>
<option value=''>Select Month</option>";
for($p=1;$p<=12;$p++){

$dateObject   = DateTime::createFromFormat('!m', $p);
$monthName = $dateObject->format('F');
if($month==$p){
echo "<option value=$p selected>$monthName</option>";
}else{
echo "<option value=$p>$monthName</option>";
}
}
echo "</select>
<select name=year value='' onchange=\"reload(this.form)\" id=\"year\" style='width: 25%;height: 30px;'>Select Year</option>
";
for($i=$start_year;$i<=$end_year;$i++){
if($year==$i){
echo "<option value='$i' selected>$i</option>";
}else{
echo "<option value='$i'>$i</option>";
}
}
echo "</select>";

if($month<10){
$month="0".$month;
}
      
echo " </td><td align='center'><a href='#'>X</a></td></tr><tr>";
echo "<th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr><tr>";

////// End of the top line showing name of the days of the week//////////



//////// Starting of the days//////////
for($i=1;$i<=$no_of_days;$i++){
 if ($i<10){
$i="0".$i;
}
$pv="'$month'".","."'$i'".","."'$year'";
 
                                    $day = $year."-".$month."-".$i;// This will display the date in formate 2019-31-3



// echo $day;
$sq_datel=mysqli_query($con, "SELECT * FROM tbl_loan WHERE creation_date like '$day'"); 

    if ($result_loan_day = $sq_datel){
        $row_count_loan_day = mysqli_num_rows($result_loan_day);
    
       // echo $row_count_loan_day."<br>";
    }
    
    $sq_fb=mysqli_query($con, "SELECT * FROM tbl_fb WHERE creation_date like '$day'"); 
$fb_value=0;
    while($row_fb = mysqli_fetch_array($sq_fb)) {

$fb_value=$row_fb['fb_value'];
//echo "value is:".$fb_value;
    }

 $sq_goo=mysqli_query($con, "SELECT * FROM tbl_google WHERE creation_date like '$day'"); 
$goo_value=0;
   while($row_goo = mysqli_fetch_array($sq_goo)) {

$goo_value=$row_goo['gogl_value'];
//echo "value is:".$fb_value;
    }

 $sq_leads=mysqli_query($con, "SELECT * FROM fnd_user_profile WHERE creation_date like '$day'"); 

    if ($result_loan_leads = $sq_leads){
        $row_count_loan_leads = mysqli_num_rows($result_loan_leads);
    
       // echo $row_count_loan_leads."<br>";
    }
    
                    // echo "$day"; // This is variable of date formate
                                   
echo $adj."<td><a href='manage_marketing.php?date=$day' onclick=\"post_value($pv);\"><br><span style='font-size:20px;color:#FFA500;float:left;margin-top:-5%'> $i</span> <br><br> <span style='color:black;float:left;'> Leads: $row_count_loan_leads</span> <br> <span style='color:black;float:left;'> Google: $goo_value</span> <br> <span style='color:black;float:left;'>Facebook: $fb_value</span> <br> <span style='color:black;float:left;'>Loans: $row_count_loan_day</span> <br><button style='background-color:#FFA500;border-color:#FFA500;float:left;'>Manage</button></a>";// This will display the date inside the calendar cell
echo " </td>";
$adj='';
$j ++;
if($j==7){echo "</tr><tr>"; // start a new row
$j=0;}
}

echo $adj2;   // Blank the balance cell of calendar at the end 

echo "</tr></table>";

$query_fb = mysqli_query($con,"SELECT SUM(fb_value) AS value_sum FROM tbl_fb WHERE YEAR(creation_date) = $year AND MONTH(creation_date) = $month");
while ($row_fb=mysqli_fetch_array($query_fb)){
    $fb_sum = $row_fb['value_sum'];
    $fb_sum = round($fb_sum, 2);
   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$us;
}

$query_g = mysqli_query($con,"SELECT SUM(gogl_value) AS value_sum FROM tbl_google WHERE YEAR(creation_date) = $year AND MONTH(creation_date) = $month");
while ($row_g=mysqli_fetch_array($query_g)){
    $g_sum = $row_g['value_sum'];
    $g_sum = round($g_sum, 2);
   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$us;
}

$query_bud = mysqli_query($con,"SELECT SUM(budget_amount) AS value_sum FROM tbl_budget WHERE YEAR(creation_date) = $year AND MONTH(creation_date) = $month");
while ($row_bud=mysqli_fetch_array($query_bud)){
    $bud_sum = $row_bud['value_sum'];
    $bud_sum = round($bud_sum, 2);
   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$us;
}


$gol_fb_sum=$g_sum+$fb_sum;
?>

<?php

$month=$_GET['month'];
$year=$_GET['year'];
//echo $year;

$query_mark = mysqli_query($con,"SELECT * FROM other_marketing WHERE YEAR(date) = $year AND MONTH(date) = $month");
while ($row_mark = mysqli_fetch_array($query_mark)){

    $mark_name1 = $row_mark['other_mark1_name'];
  
    
   // echo"User_Key:" .$mark_name1;
}

?>



<?php

   

if(isset($_POST['btn-submit'])) 
{
    
$other1_name= $_POST['other1_name'];
$other1_value= $_POST['other1_value'];
$other2_name= $_POST['other2_name'];
$other2_value=$_POST['other2_value'];
$other3_name = $_POST['other3_name'];
$other3_value = $_POST['other3_value'];
$comm_paid = $_POST['comm_paid'];

$check=mysqli_query($con,"select * from other_marketing where other_mark1_name='$mark_name1'");
    if(mysqli_num_rows($check) > 0)
    {
        echo "Record Exists";
    }
    
else{
$query  = "INSERT INTO other_marketing (other_mark1_name,other_mark1_value,other_mark2_name,other_mark2_value,other_mark3_name,other_mark3_value,comm_paid,date)  VALUES ('$other1_name','$other1_value','$other2_name','$other2_value','$other3_name','$other3_value','$comm_paid','$day')";
        $result = mysqli_query($con, $query);
        if ($result) {
            //echo "<div class='form'><h3> successfully added in tbl_shipments.</h3><br/></div>";
        } else {
        echo "<h3> Error Inserting Data </h3>";
        }
}
 
?>
<script type="text/javascript">
window.location.href = 'marketing.php';
</script>
<?php
}

?>


<?php

$month=$_GET['month'];
$year=$_GET['year'];
//echo $year;


$query_mark = mysqli_query($con,"SELECT * FROM other_marketing WHERE YEAR(date) = $year AND MONTH(date) = $month");
while ($row_mark = mysqli_fetch_array($query_mark)){
    $mark_id = $row_mark['other_mark_id'];
    $mark_name1 = $row_mark['other_mark1_name'];
    $mark_value1 = $row_mark['other_mark1_value'];
    $mark_name2 = $row_mark['other_mark2_name'];
    $mark_value2 = $row_mark['other_mark2_value'];
    $mark_name3 = $row_mark['other_mark3_name'];
    $mark_value3 = $row_mark['other_mark3_value'];
    $commsn_paid= $row_mark['comm_paid'];
    $date= $row_mark['date'];
    
   //echo"User_Key:" .$mark_name1;
}

?>


<?php


$query_markting = mysqli_query($con,"SELECT SUM(other_mark1_value) AS value_sum FROM other_marketing WHERE YEAR(creation_date) = $year AND MONTH(creation_date) = $month");
while ($row_markting=mysqli_fetch_array($query_markting)){
    $bud_markting = $row_markting['value_sum'];
    $bud_markting = round($bud_markting, 2);
   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$us;
}


$query_markting1 = mysqli_query($con,"SELECT SUM(other_mark2_value) AS value_summ FROM other_marketing WHERE YEAR(creation_date) = $year AND MONTH(creation_date) = $month");
while ($row_markting1=mysqli_fetch_array($query_markting1)){
    $bud_markting1 = $row_markting1['value_summ'];
    $bud_markting1 = round($bud_markting1, 2);
   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$us;
}


$query_markting2 = mysqli_query($con,"SELECT SUM(other_mark3_value) AS value_summm FROM other_marketing WHERE YEAR(creation_date) = $year AND MONTH(creation_date) = $month");
while ($row_markting2=mysqli_fetch_array($query_markting2)){
    $bud_markting2 = $row_markting2['value_summm'];
    $bud_markting2 = round($bud_markting2, 2);
   // echo"<br><br><br> <br><br><br><br><br> <br><br>User_Key:" .$us;
}

$query_markting3 = mysqli_query($con,"SELECT SUM(comm_paid) AS value_summmm FROM other_marketing WHERE YEAR(creation_date) = $year AND MONTH(creation_date) = $month");
while ($row_markting3=mysqli_fetch_array($query_markting3)){
    $bud_markting3 = $row_markting3['value_summmm'];
    $bud_markting3 = round($bud_markting3, 2);
   //echo"User_Key:" .$bud_markting3;
}


$month_market=$mark_value1+$mark_value2+$mark_value3+$commsn_paid;

$final_mon_market=$month_market+$gol_fb_sum;



$cpld=$final_mon_market/$rowcountt_leads;
$cplf=$final_mon_market/$rowcountt;
?>

<br>

<div class ="container" >

<div class="row" style="background-color: #FFA500;color: white;padding:20px;">

<div class="col-lg-4"><p><b>Google:</b><b style="color:red"> $<?php echo $g_sum;?></b></p></div>
<div class="col-lg-4"><p><b>Facebook:</b><b style="color:red"> $<?php echo $fb_sum;?> </b> </p></div>
<div class="col-lg-4"><p><b> Total:</b><b style="color:red"> $<?php echo $gol_fb_sum;?></b></p></div>
<br><br>
  
<div class="col-lg-12">
  <form action="" method="POST">
    <div class="col-lg-2" style="margin-top: -1.7%;">
        <b>Other Marketing:</b>
    <input type="text" name="other1_name" contenteditable="true" placeholder="Name" value="<?php echo $mark_name1;?>" style="color:black;">
    </div>
    <div class="col-lg-2">
    <input type="text" name="other1_value" contenteditable="true" placeholder="Value" value="<?php echo $mark_value1;?>" style="color:black;">
    </div>
        
        
    <div class="col-lg-2" style="margin-top: -1.7%;">
          <b>Other Marketing:</b>
    <input type="text" name="other2_name" contenteditable="true" placeholder="Name" value="<?php echo $mark_name2;?>" style="color:black;">
    </div>
    <div class="col-lg-2">
    <input type="text" name="other2_value" contenteditable="true" placeholder="Value" value="<?php echo $mark_value2;?>" style="color:black;">
    </div> 
        
    <div class="col-lg-2" style="margin-top: -1.7%;">
          <b>Other Marketing:</b>
    <input type="text" name="other3_name" contenteditable="true" placeholder="Name" value="<?php echo $mark_name3;?>" style="color:black;">
    </div>
    
    <div class="col-lg-2">
    <input type="text" name="other3_value" contenteditable="true" placeholder="Value" value="<?php echo $mark_value3;?>" style="color:black;">
    </div>
    <br><br>
    <div align="left" class="col-lg-2">
        <b>Commissions Paid:</b>
        <input type="text" name="comm_paid" contenteditable="true" placeholder="Commissions Paid" value="<?php echo $commsn_paid;?>" style="color:black;">
    </div>
    
 <div class="col-lg-2" style="margin-top:2%;">
 <button name="btn-submit" type="submit" style="background-color:#1E90FF;border-color:#1E90FF;">Save/Update</button>
   </div>
   
  </form> 
</div>

<br><br>

<div class="col-lg-4"><p><b>Leads:</b><b style="color:red"> <?php echo $rowcountt_leads;?> </b></p></div>
<div class="col-lg-4"><p><b> Loans:</b><b style="color:red"><?php echo $rowcountt;?> </b></p></div>
<div class="col-lg-4"><p><b> CPLD:</b><b style="color:red"><?php echo $cpld;?> </b></p></div>
<div class="col-lg-4"><p><b> CPLF:</b><b style="color:red"><?php echo $cplf;?> </b></p></div>
<div class="col-lg-4"><p><b> Total Monthly Marketing:</b><b style="color:red">$<?php echo $final_mon_market;?> </b></p></div>

</div>    

</div>
<br>


<?php 
   
if(isset($_POST['btn-submit'])) 
{
$mark_name1= $_POST['other1_name'];
$mark_value1= $_POST['other1_value'];
$mark_name2= $_POST['other2_name'];
$mark_value2=$_POST['other2_value'];
$mark_name3 = $_POST['other3_name'];
$mark_value3 = $_POST['other3_value'];  
$commsn_paid= $row_mark['comm_paid'];

mysqli_query($con, "UPDATE other_marketing SET other_mark1_name ='$mark_name1' , other_mark1_value='$mark_value1' , other_mark2_name='$mark_name2'  , other_mark2_value='$mark_value2', other_mark3_name='$mark_name3', other_mark3_value='$mark_value3', comm_paid='$comm_paid' WHERE YEAR(date) = '$year' AND MONTH(date) = '$month' "); 

    ?>
    
    <script type="text/javascript">
window.location.href = 'marketing.php';
</script>
<?php
}
}
?>

</body>
</html>
