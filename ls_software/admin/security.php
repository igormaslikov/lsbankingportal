<?php
/**
 * Shared security helpers — include at the top of every admin page.
 */

// XSS-safe echo
if (!function_exists('h')) {
    function h($s) {
        return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

// CSRF token — generate once per session
if (!function_exists('csrf_token')) {
    function csrf_token() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

// CSRF hidden input field
if (!function_exists('csrf_field')) {
    function csrf_field() {
        return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
    }
}

// Validate CSRF on POST — call at top of any POST handler
if (!function_exists('csrf_verify')) {
    function csrf_verify() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if (!hash_equals(csrf_token(), $token)) {
                http_response_code(403);
                die('Security error: invalid request token. Please go back and try again.');
            }
        }
    }
}

// Require valid session — redirects with exit() if not logged in
if (!function_exists('require_login')) {
    function require_login() {
        if (!isset($_SESSION['userSession'])) {
            header('Location: /ls_software/admin/index.php');
            exit();
        }
    }
}

// Require non-zero access — dies with message if access_id == 0
if (!function_exists('require_access')) {
    function require_access($access_id) {
        if ((string)$access_id === '0') {
            http_response_code(403);
            die('YOU ARE NOT AUTHORISED TO ACCESS THIS PAGE.');
        }
    }
}
