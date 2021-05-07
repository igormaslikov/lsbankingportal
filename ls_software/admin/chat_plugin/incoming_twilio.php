<?php

$txt = "";
foreach($_GET as $key => $value)
{
   $txt .=  'Key = ' . $key . '<br />';
    $txt .=  'Value= ' . $value;
}

$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
//$txt = "Mickey Mouse\n";
fwrite($myfile, $txt);
//$txt = "Minnie Mouse\n";
fwrite($myfile, $txt);
fclose($myfile);
?>