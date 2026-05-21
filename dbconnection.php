<?php
/*
 * Microsoft SQL Server connection (PHP sqlsrv extension).
 *
 * $db_host = server or instance (e.g. .\SQLEXPRESS or localhost\SQLEXPRESS).
 * $db_name = database name (e.g. OfscaBank).
 *
 * Set $db_use_windows_auth = true and leave $db_user / $db_pass empty for Windows authentication.
 * Set $db_use_windows_auth = false and set $db_user / $db_pass for SQL Server authentication.
 */

$db_host = 'MGMA0GHY7Y';
$db_name = 'OfscaBank';
$db_user = '';
$db_pass = '';

$db_use_windows_auth = true;

if (isset($_SESSION['Optima']) && ($_SESSION["Optima"] == "true" or $_SESSION["Optima"] == "True")) {
    // TODO: Confirm SQL Server name for the Optima-specific database (was ki902621_ofsca_portal_new on MySQL).
    $db_name = 'OfscaBank_new';
}
