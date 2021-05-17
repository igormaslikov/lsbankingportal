<?php 
include($_SERVER['DOCUMENT_ROOT'].'/dbconnect.php');




//date_default_timezone_set('America/Los_Angeles');

echo "Created timme is " . date("H:i"). "<br>";
$now=date("H:i");
$start = "07:01";
$end = "18:59";
//$now = date('H');


if (($now >= $start  && $now <= $end)) 

{ 
    echo "time in between";
}

else{
    
  echo  "No Time";
}





?>