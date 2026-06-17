<?php
// Compatibility redirect: contract_pdf.php lives at files/contract_pdf.php.
// Older email links / bookmarks point at this root path; forward them on
// with the original query string intact.
$qs = $_SERVER['QUERY_STRING'] ?? '';
$target = 'files/contract_pdf.php' . ($qs !== '' ? ('?' . $qs) : '');
header('Location: ' . $target, true, 301);
exit;
