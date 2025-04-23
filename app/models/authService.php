<?php

require_once ROOT . '/app/models/sessionInit.php';
require_once ROOT . '/app/models/userModel.php';

/**
 * Connecte un utilisateur en vérifiant son email et mot de passe.
 *
 * @param string $email L'adresse email de l'utilisateur.
 * @param string $password Le mot de passe fourni.
 * @return bool True si la connexion réussit, false sinon.
 */
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

/**
 * Déconnecte l'utilisateur en détruisant la session et redirige vers l'accueil.
 *
 * @return void
 */
function logout() {
    session_unset();
    session_destroy();

    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Location: home');
    exit;
}

?>