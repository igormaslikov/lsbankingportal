<?php
error_reporting(-1);
ini_set('display_errors', 1);
require '../vendor/autoload.php';
$session = new SpotifyWebAPI\Session('bb90ec3d1c6c4a7c98f5214563149a06', 'b5e0936ce49c490dbccd5c182feeb75e', 'https://ofsca.com/loanportal/ls_software/website/spotify/webservice%20fivv/index.php');
$api = new SpotifyWebAPI\SpotifyWebAPI();
if (isset($_GET['code'])) {
    $session->requestAccessToken($_GET['code']);
    session_start();
    $_SESSION['token'] = $session->getAccessToken();
    header('Location: /index.php');
} else {
    $scopes = [
    'scope' => [
    'playlist-read-private',
    'user-read-private',
    'user-read-recently-played'
        ],
    ];
    header('Location: ' . $session->getAuthorizeUrl($scopes));
}