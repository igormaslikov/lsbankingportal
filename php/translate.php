<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>



<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.myapifilms.com/imdb/idIMDB?idIMDB=tt0167260&token=c6901d48-abcd-4459-b0ef-f43a3308c0fe&format=json&language=en-us&aka=1&business=1&seasons=0&seasonYear=0&technical=1&trailers=0&movieTrivia=0&awards=1&moviePhotos=0&movieVideos=0&actors=0&biography=0&uniqueName=0&filmography=0&bornDied=0&starSign=0&actorActress=0&actorTrivia=0&similarMovies=0&goofs=0&keyword=0&quotes=0&fullSize=0&companyCredits=0&filmingLocations=2&directors=1&writers=2&charset=ISO-8859-1",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "{\r\n\"psgInfo\":{\r\n\"phone\":\"+84905997333\",\r\n\"firstName\":\"Ainh\",\r\n\"lastName\":\"Rran\",\r\n\"email\":\"vivvvnhjs@gmail.com\"\r\n},\r\n\"request\":{\r\n\"pickup\":{\r\n\"address\":\"2 Tran Phu, Da Nang\",\r\n\"geo\":[\r\n108.222404,\r\n16.082397\r\n],\r\n\"timezone\":\"Europe/Paris\"\r\n},\r\n\"destination\":{\r\n\"address\":\"2 Quang Trung, Da Nang\", \r\n\"geo\":[\r\n108.222365,\r\n16.075347\r\n],\r\n\"timezone\":\"Europe/Paris\"\r\n},\r\n\"pickUpTime\":\"Now\",\r\n\r\n\"vehicleTypeRequest\":\"greenTAXI\",\r\n\"type\":0,\r\n\"paymentType\":1\r\n},\r\n\"dispatch3rd\":false\r\n}",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: d9ba61e5-4a39-105d-a4fc-2f9dbdbdc06f"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
 // echo $response;
}


$data=json_decode($response,true);

echo"<table>
<tr>
<th>id IMDB</th>
<th>url IMDB</th>
<th>country</th>
<th>title</th>
<th>comment</th>
</tr>
";

foreach($data['data']['movies'] as $key=>$value)

{
    
    $idIMDB=$value['idIMDB'];
    $urlIMDB=$value['urlIMDB'];
    
   // echo"idIMDB:  ".$idIMDB."<br><br>";
   // echo"url IMDB:  ".$urlIMDB."<br>";
    
    

    

    
    foreach($value['akas'] as $keyy=>$valuee)

{
    
     $country=$valuee['country'];
     $title_akas=$valuee['title'];
     $comment=$valuee['comment'];
    
      echo"<tr>
      <td>$idIMDB</td>
     <td>$urlIMDB</td>
      
    <td>$country</td>
     <td>$title_akas</td>
     <td>$comment</td>

   </tr>";  
}
 
  
    
}

echo"</table>";
?>


</body>
</html>