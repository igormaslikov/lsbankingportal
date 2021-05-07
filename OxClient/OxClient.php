<?php
class OxClient
{    
    public $json = '';

    public function __construct()
    {

    }

    public function sendRequest($url, $fields, $method = 'GET')
    {        
        //initialize and setup the curl handler
        $ch = curl_init();

        if($method == 'GET') :
            curl_setopt($ch, CURLOPT_URL, $url.'?'.http_build_query($fields));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        elseif($method == 'POST') :
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
        endif;

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        $this->json = $result;

        $result = json_decode($result, true);

        return $result;
    }
}