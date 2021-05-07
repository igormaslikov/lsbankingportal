<?php
error_reporting(-1);
ini_set('display_errors', 1);

require '../vendor/autoload.php';

$session = new SpotifyWebAPI\Session('CLIENT_ID', 'CLIENT_SECRET', 'https://mysite.com/callback');

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