<?php
// Merged into view_all_customer_main.php. Preserve any existing GET params and add unread=1.
$params = $_GET;
$params['unread'] = 1;
header('Location: view_all_customer_main.php?' . http_build_query($params), true, 301);
exit;
