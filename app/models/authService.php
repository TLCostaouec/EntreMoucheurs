<?php

require_once ROOT . '/app/models/sessionInit.php';
require_once ROOT . '/app/models/userModel.php';

function login($email, $password) {
    $user = getUserByEmail($email);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['entremoucheurs_user_id'] = $user['user_id'];
        $_SESSION['entremoucheurs_email'] = $user['email'];
        $_SESSION['entremoucheurs_role'] = $user['role'];
        return true;
    }
    return false;
}

function logout() {
    session_unset();
    session_destroy();

    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Location: home');
    exit;
}

?>