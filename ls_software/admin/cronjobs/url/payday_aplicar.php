<?php
 
 include($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');

$query = "select * from url_counter where url='payday_aplicar' ";
$sql=mysqli_query($con, "$query");
while($row = mysqli_fetch_array($sql)) {
    $url = $row['url'];
    $counter=$row['url_counter'];
    
    //echo $url."<br>";
    //echo "$counter"."<br>";
}

$counter=$counter;
$counter++;

mysqli_query($con,"UPDATE url_counter SET url_counter ='$counter' where url = 'payday_aplicar'");

?>