<?php

function curl($url,$params = array(),$is_coockie_set = false)
{

if(!$is_coockie_set){
/* STEP 1. let’s create a cookie file */
$ckfile = tempnam ("/tmp", "CURLCOOKIE");

/* STEP 2. visit the homepage to set the cookie properly */
$ch = curl_init ($url);
curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec ($ch);
}

$str = ''; $str_arr= array();
foreach($params as $key => $value)
{
$str_arr[] = urlencode($key)."=".urlencode($value);
}
if(!empty($str_arr))
$str = '?'.implode('&',$str_arr);

/* STEP 3. visit cookiepage.php */

$Url = $url.$str;

$ch = curl_init ($Url);
curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

$output = curl_exec ($ch);
return $output;
}


function Translate($word,$conversion = 'hi_to_en')
{
$word = urlencode($word);
//english to arabic

 if($conversion=='en_to_ar')
 {
     $url = 'http://translate.google.co.in/translate_a/t?client=t&text='.$word.'&sl=en&tl=ar&hl=en&sc=2&ie=UTF-8&oe=UTF-8&prev=btn&ssel=3&tsel=4&q=free%20translate%20api';
 }


$name_en = curl($url);

$name_en = explode('"',$name_en);
return  $name_en[1];
}
?>
<html>
<head>
<meta http-equiv="Content-Type"  charset=utf-8"/>
</head>
<body>
<?php

echo "<br><br> English To Arabic $url<br>";

echo  Translate('hii how are you','en_to_ar');


?>
</body>
</html>