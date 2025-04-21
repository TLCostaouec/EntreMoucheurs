<?php

require_once ROOT . '/app/models/userModel.php';

function login($email, $password) {
    $user = getUserByEmail($email);

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        return true;
    }
    return false;
}

function logout() {
    session_start();
    session_unset();
    session_destroy();
    header('Location: home');
}

?>