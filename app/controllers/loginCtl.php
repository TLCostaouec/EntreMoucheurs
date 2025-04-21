<?php

/**
*	Controleur : connexion
*/

require_once ROOT . '/app/models/authService.php';
require_once ROOT . '/app/models/auth.php';

if (isLoggedIn()) {
    if (isAdmin()) {
        header('Location: admin');
    } else {
        header('Location: profil');
    }
    exit;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (login($email, $password)) {
        if (isAdmin()) {
            header('Location: admin');
        } else {
            header('Location: profil');
        }
        exit;
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}

$pageTitle = "Connexion | EntreMoucheurs";
$metaDescription = "Connectez-vous pour accéder à votre profil sur EntreMoucheurs.";

require ROOT . '/app/views/loginView.php';

?>