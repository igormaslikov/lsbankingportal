<?php
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: /ls_software/admin/index.php");
    exit();
}

if (!isset($_SESSION['userSession'])) {
    header("Location: /ls_software/admin/index.php");
    exit();
}

header("Location: /ls_software/admin/home.php");
exit();
