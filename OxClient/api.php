<?php
define('APIURL', 'https://app.oxsic.com/api/');
include_once('OxClient.php');

$request = new OxClient;
$params = [
    'api_key' => $_POST['OxuzGbtYz1doyf5JDlthnjgoaVn3R0IWiEog1ctMaGSSDGll'],
    'api_secret' => $_POST['mNtORqdJBUiNFO4hw45atV0UhwbHUDGB840CJ1GEqfvpHDTB'],
    'document_file' => curl_file_create('70099.pdf'),
    'mime' => $_POST['application/pdf'],
    'doi' => 'yes',
    'search_public' => 'yes',
    'search_group' => 'yes',
    'search_organisation' => 'yes',
    'search_private' => 'yes'
];

try {
    $result = $request->sendRequest(APIURL.'documents', $params, 'POST');
} catch (Exception $e) {
    echo $e->getMessage();
}
?>