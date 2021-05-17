<?php

$month=$_GET['month'];
$year=$_GET['year'];
//echo $year;
include $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

 
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
include $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';


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
<title>Calendar</title>
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
self.location='cal2.php?month=' + month_val + '&year=' + year_val ; // reload the page
}
</script>
<style type="text/css">
table.main {
  width: 100%; 
  height: 100%; 
border: 1px solid black;
	background-color: #1E90FF;

}
table.main td {

font-family: verdana,arial, helvetica,  sans-serif;
font-size: 11px;
	text-align: center;
}
table.main th {
	border-width: 1px 1px 1px 1px;
	padding: 0px 0px 0px 0px;
 background-color: #ccb4cd;
}
table.main a{TEXT-DECORATION: none;
    color: white;
}
table,td{ border: 1px solid #ffffff }

</style>
</head>
<body>
      
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

echo " </td><td align='center'><a href=# onClick='self.close();'>X</a></td></tr><tr>";
echo "<th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr><tr>";

////// End of the top line showing name of the days of the week//////////

    
if($month<10){
$month="0".$month;
}



//////// Starting of the days//////////
for($i=1;$i<=$no_of_days;$i++){
 if ($i<10){
$i="0".$i;
}
$pv="'$month'".","."'$i'".","."'$year'";
 
                                    $day = $year."-".$month."-".$i;// This will display the date in formate 2019-31-3


include $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

// echo $day;
$sq_datel=mysqli_query($con, "SELECT * FROM tbl_loan WHERE creation_date like '$day'"); 

    if ($result_loan_day = $sq_datel){
        $row_count_loan_day = mysqli_num_rows($result_loan_day);
    
       // echo $row_count_loan_day."<br>";
    }



                                    // echo "$day"; // This is variable of date formate
                                   
 
echo $adj."<td><a href='#' onclick=\"post_value($pv);\"><span style='font-size:20px;color:#FFA500;'> $i</span> <br> Leads: 0 <br>Google: 0 <br>Facebook: 0 <br>Loans: $row_count_loan_day</a>";// This will display the date inside the calendar cell
echo " </td>";
$adj='';
$j ++;
if($j==7){echo "</tr><tr>"; // start a new row
$j=0;}
}


echo $adj2;   // Blank the balance cell of calendar at the end 

echo "</tr></table>";
?>


<?php
function execute()
{

include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';;
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';

$readfile = file($day);

echo $readfile;

	$result_counttt = mysqli_query($con,"SELECT * FROM tbl_loan WHERE creation_date=$readfile");
    while($rowww = mysqli_fetch_array($result_counttt))
    {
		 $iddddd=$rowww['loan_id'];
	     echo "Loan ID is:".$iddddd. "<br>";
        }
	mysqli_close($con);

}

?>

</body>
</html>
