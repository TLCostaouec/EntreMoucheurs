<?php

/**
*	Controleur : inscription utilisateur
*/

require_once ROOT . '/app/models/auth.php';
require_once ROOT . '/app/models/authService.php';
require_once ROOT . '/app/models/userModel.php';

if (isLoggedIn()) {
    if (isAdmin()) {
        header('Location: admin');
    } else {
        header('Location: profil');
    }
    exit;
}

$emailError= $pseudoError = $passwordError = $passwordConfirmError = $globalError = null;

$email = $pseudo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pseudo = trim($_POST['pseudo'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';

    if (empty($email)) {
        $emailError = "L'adresse email est requise.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "L'adresse email est invalide";
    } elseif (emailExists($email)) {
        $emailError = "Cette adresse email est déjà utilisée.";
    }

    if (empty($pseudo)) {
        $pseudoError = "Le pseudo est obligatoire.";
    } elseif (pseudoExists($pseudo)) {
        $pseudoError = "Ce pseudo est déjà utilisé.";
    }

    if (empty($password)) {
        $passwordError = "Le mot de passe est requis.";
    }

    if (empty($passwordConfirm)) {
        $passwordConfirmError = "La confirmation du mot de passe est requise.";
    } elseif ($password !== $passwordConfirm) {
        $passwordConfirmError = "Les mots de passe ne correspondent pas.";
    }

    if (!$emailError && !$pseudoError && !$passwordError && !$passwordConfirmError) {
        try {
            createUser($email, $pseudo, $password);
            login($email, $password);
            header('Location: profil');
        } catch (Exception $e) {
            $globalError = "Une erreur est survenue. Veuillez réessayer plus tard.";
        }
    }
}

$pageTitle = "Inscription | EntreMoucheurs";
$metaDescription = "Créez un compte pour rejoindre la communauté EntreMoucheurs.";

require ROOT . '/app/views/registerView.php';

?>