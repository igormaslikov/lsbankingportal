<?php
 
 include('../../dbconnect.php');
 include('../../dbconfig.php');


$query = "select * from url_counter where url='payday' ";
$sql=$con->query("$query");
while($row = $sql->fetch_array()) {
    $url = $row['url'];
    $counter=$row['url_counter'];
    
    //echo $url."<br>";
   // echo "$counter"."<br>";
}

$counter=$counter;
$counter++;

$con->query("UPDATE url_counter SET url_counter ='$counter' where url='payday' ");

?>