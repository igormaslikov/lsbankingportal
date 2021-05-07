<?php

 //Link to download file...
 $url = "http://gwadar-one.com/lsfinancing/signature/finish.php";

 //Code to get the file...
 $data = file_get_contents($url);

 //save as?
 $filename = "contarct.html";

 //save the file...
 $fh = fopen($filename,"w");
 fwrite($fh,$data);
 fclose($fh);

 //display link to the file you just saved...
 echo "<a href='".$filename."' download>Click Here</a> to download the file...";

?>