<?php
/**
 * Twilio credentials — kept at repo root, outside ls_software web path.
 * Never commit real values to version control.
 * On the server, restrict read access to this file (IIS_IUSRS only, no web serving).
 */
define('TWILIO_ACCOUNT_SID', 'AC5e18b85197db6e32d1995bf3b40e045b');
define('TWILIO_AUTH_TOKEN',  'b8b46b46890479bcf25a9fb2067e1c1e');  // from decoded Basic auth header
define('TWILIO_FROM_SINGLE', '+18183010269');
define('TWILIO_FROM_BULK',   '+18886951203');
