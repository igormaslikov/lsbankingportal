<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.spotify.com/v1/albums/0sNOF9WDwhWunNAHPD3Baj",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "authorization: Bearer BQDNpatmUkEYYwx231iSiO4HzENmZbtmhtjwJzvb8T9iu2UxHO3Kivs8CqykbPPkuGn07H69xsC_El1mYVxO3c4pFKuX9fdqc-jQtsqFK0HX65EUULlNZQeakL5GBqlU-125JuPSweJJVwJee19jmjm3so31eTDrgSZ1blDTcivbcVEDzttAGZ7B3qbfyOq3k7xTEs6MehXkUA6QRx4Tw9KOa82V3dwAE38JjqHE0BeyKuwA4ckvZ5IwnRjf_P2nlT9-F6MlaLKsTn4acHBUQ7it0rUVahet",
    "cache-control: no-cache",
    "postman-token: 41dbc180-6fa9-2f76-d590-250b9f8e6736"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

$products=json_decode($response, true);

foreach ($products['artists'] as $key => $value)
 {
//echo $value['external_urls']['spotify']."<br>";

$namee = $value['name']."<br>";

echo $namee;
}


curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>projekt</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>


<body>
	<button class="Radio">P1</button>
	<div class="panel">
		  <button class="button1"  onclick = "getStationInfo(132, cs1, ps1)">Uppdatera</button> <!–– användaren måste trycka på denna knapp som heter "uppdatera" för att kunna se låtar. med andra ord visas inte låtar automatiskt när man expanderar S1,S2,S3––>
		  <p id=cs1>Current Song:</p>
		  <p id =ps1>Previous Song: </p>
	</div>
	
	<button class="Radio">P2</button>
	<div class="panel">
		 <button class="button2" onclick = "getStationInfo(163, cs2, ps2)">Uppdatera</button>
	  <p id = cs2>Current Song:</p>
	  <p id = ps2>Previous Song: </p>
	  <textarea rows="8" cols="20" name="comment" form="usrform"> <?php echo "Name:". $namee;?> </textarea>
	  
	  
	</div>

	<button class="Radio">P3</button>
	<div class="panel">
		  <button class="button3" onclick = "getStationInfo(164, cs3, ps3)">Uppdatera</button>
	  <p id = cs3>Current Song:</p>
	  <p id = ps3>Previous Song: </p>
	</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="script.js"></script>
</body>
<footer>
  <p> Footer</p>
</footer>
</html>