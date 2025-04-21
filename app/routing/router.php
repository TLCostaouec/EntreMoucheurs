<?php

$allowed = [
    'spot', 'register', 'login', 'logout', 'profil', 'admin', 'contact', 'privacy', 'error403', 'deleteUser', 'spotDetails', 'spotDelete', 'spotEdit'
];

$action = $_GET['action'] ?? 'home';

if ($action === 'home') {
    require ROOT . '/app/controllers/homeCtl.php';
} elseif (in_array($action, $allowed)) {
    require ROOT . '/app/controllers/' . $action . 'Ctl.php';
} else {
    require ROOT . '/app/controllers/error404Ctl.php';
}

?>