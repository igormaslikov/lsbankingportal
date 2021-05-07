<?php
include_once '../dbconnect.php';
include_once '../dbconfig.php';

   $table=$_POST['table'];
   $search=$_POST['search'];
 

if ($table=="tbl_loan")
{
 $sql = mysqli_query("select * from tbl_loan where loan_create_id like '$search'");
}
if ($table=="fnd_user_profile")
{
 $sql = mysqli_query("select * from fnd_user_profile where first_name like '$search'");
}

while ($row=mysql_fetch_array($sql))
{
                                echo " <table width='100%' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#CCCCCC' >  ";
                                echo " <tr bgcolor='green'>";
                                echo " <td width='5%' align='center' height='10' ><p><font color='white'><strong><B>Reservation Number </th>";
                                echo "<td width='5%' align='center' height='10' ><p><font color='white'><b>Name</th>";
                                echo "<td width='5%' align='center' height='10' ><p><font color='white'><b>Vehicle Type</th>";
                                echo "<td width='5%' align='center' height='10' ><p><font color='white'><b>Origin</th>";
                                echo "<td width='5%' align='center' height='10' ><p><font color='white'><b>Pick up date</th>";
                                echo "<td width='5%' align='center' height='10' ><p><font color='white'><b>Time</th>";
                                echo "<td width='5%' align='center' height='10' ><p><font color='white'><b>Destination</th>";
                                echo "<td width='5%' align='center' height='10' ><p><font color='white'><b>Return Date</th>";
                                echo "<td width='5%' align='center' height='10' ><p><font color='white'><b> Return Time</th>";
                                echo "<td width='5%' align='center' height='10' ><p><font color='white'><b> Contact Number</th>";
                                echo "<td width='5%' align='center' height='10' ><p><font color='white'><b> Address</th>";
                                echo "</tr>";
                               echo"<tr>";
                               echo"<a href='a.html'> back </a>";
                             echo"<tr>";
                                        echo "<td width='5%' align='center' height='10' > $row[Rnum]</td>";
                                        echo "<td width='5%' align='center' height='10' >$row[Fname] $row[Lname]</td>";
                                        echo "<td width='5%' align='center' height='10' >$row[Vehicle]</td>";
                                        echo "<td width='5%' align='center' height='10' >$row[Origin]</td>";
                                        echo "<td width='5%' align='center' height='10' >$row[Pickday] $row[Pickmonth]   </td>";
                                        echo "<td width='5%' align='center' height='10' >$row[Pickhour] : $row[Pickmin]</td>";
                                        echo "<td width='5%' align='center' height='10' >$row[Destination]</td>";
                                        echo "<td width='5%' align='center' height='10' >$row[Rday] $row[Rmonth]   </td>";
                                        echo "<td width='5%' align='center' height='10' >$row[Rhour] : $row[Rmin]</td>";
                                        echo "<td width='5%' align='center' height='10' >$row[Contact]</td>";
                                        echo "<td width='5%' align='center' height='10' >$row[Zip],$row[Address],$row[City] $row[Country]</td>";
                               echo '<br/><br/>';
  } 
 //This counts the number or results - and if there wasn't any it gives them a little message explaining that 
 $anymatches=mysql_num_rows($sql); 
 if ($anymatches == '0') 
    { 
    echo"<a href='searchform.html'> back </a>";
   echo "Sorry,Invalid Reservation Number or you are looking at the wrong place double check the number and search it again"; 
    } 
   
 ?>