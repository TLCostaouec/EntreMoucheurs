<?php

require_once ROOT . '/app/models/userModel.php';

// Définir un nom unique de session
if (session_status() === PHP_SESSION_NONE) {
    session_name('entremoucheurs_session');
    session_start();
}

function login($email, $password) {
    $user = getUserByEmail($email);

    if ($user && password_verify($password, $user['password'])) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['entremoucheurs_user_id'] = $user['user_id'];
        $_SESSION['entremoucheurs_email'] = $user['email'];
        $_SESSION['entremoucheurs_role'] = $user['role'];
        return true;
    }
    return false;
}

function logout() {
    // Nom de session doit être le même pour pouvoir le détruire
    session_name('entremoucheurs_session');
    
    if (session_status() === PHP_SESSION_NONE) {
        session_name('entremoucheurs_session');
        session_start();
    }

    session_unset();
    session_destroy();

    // Évite le retour arrière avec le cache
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');

    header('Location: home');
    exit;
}
