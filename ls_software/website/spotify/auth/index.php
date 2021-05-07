<?php
error_reporting(-1);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

$session = new SpotifyWebAPI\Session('CLIENT_ID', 'CLIENT_SECRET', 'https://mysite.com/callback');
$scopes = array(
    'playlist-read-private',
    'user-read-private',
    'user-read-recently-played'
);
$authorizeUrl = $session->getAuthorizeUrl(array(
    'scope' => $scopes
));

$api = new SpotifyWebAPI\SpotifyWebAPI();

session_start();
if (isset($_SESSION['token'])) { 
    $api = new SpotifyWebAPI\SpotifyWebAPI();

    $accessToken = $_SESSION['token'];

    $api->setAccessToken($accessToken);

    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

</head>
<body>
   <?php 
   $artist = $api->getMyHistory(array('limit' => 4));

    for ($i=0; $i < $artist->limit ; $i++) {

        $track = $api->getTrack($artist->items[$i]->track->id);
        echo '<img src="'.$track->album->images[2]->url.'" />';
        echo '<a href="'.$artist->items[$i]->track->external_urls->spotify.'" target="_blank">'.$artist->items[$i]->track->artists[0]->name.' - '. $artist->items[$i]->track->name . ' </a> <br/>';

    }
 ?>
</body>
</html>


<?php
} else {

    header('Location: ' . $session->getAuthorizeUrl($scopes));
    die();
} ?>