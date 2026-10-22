<?php
require_once __DIR__ . '/../includes/ijk-functions.php';
if (isLoggedIn()) {
    catatLog('Logout dari sistem');
}
session_destroy();
header('Location: ijk-login.php');
exit;
