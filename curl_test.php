<?
    $URL="https://www.flipkart.com";
    if (isset($_GET["site"])) { $URL = $_GET["site"]; }
    $ch = curl_init();
    echo "URL = $URL <br>\n";
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt ($ch, CURLOPT_HTTPPROXYTUNNEL, TRUE);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt ($ch, CURLOPT_URL, $URL);
    curl_setopt ($ch, CURLOPT_TIMEOUT, 120);
    $result = curl_exec ($ch);
    echo "<hr><br>\n";
    echo 'Errors: ' . curl_errno($ch) . ' ' . curl_error($ch) . '<br><br>';
    echo "<hr><br>\n";
    curl_close ($ch);
    print "result - $result";
    echo "<hr><br>\n";
?>