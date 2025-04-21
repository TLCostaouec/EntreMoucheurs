<?php

/**
*	Controleur : profil utilisateur
*/

require_once ROOT . '/app/models/auth.php';
require_once ROOT . '/app/models/userModel.php';
require_once ROOT . '/app/models/spotModel.php';

requireLogin();

$userId = $_SESSION['user_id'];
$user = getUserById($userId);
$formType = $_POST['form_type'] ?? null;
$userSpots = getSpotsByUser($_SESSION['user_id']);

$success = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_account'])) {
    try {
        deleteUser($userId);
        session_destroy();
        header('Location: index.php');
        exit;
    } catch (Exception $e) {
        $error = "Impossible de supprimer votre compte. Veuillez réessayer plus tard.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_type'])) {
    $formType = $_POST['form_type'];

    if ($formType === 'email') {
        $newEmail = trim($_POST['email'] ?? '');

        if (empty($newEmail)) {
        $error = "L'adresse email est obligatoire.";
        } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            $error = "L'adresse email n'est pas valide.";
        } elseif ($newEmail !== $user['email'] && emailExists($newEmail)) {
            $error = "Cet email est déjà utilisé.";
        } else {
            try {
                updateUser($userId, $newEmail, $user['pseudo']);
                $success = "Email mis à jour avec succès.";
                $user = getUserById($userId);
            } catch (Exception $e) {
                $error = "Erreur lors de la mise à jour de l'email.";
            }
        }

    } elseif ($formType === 'pseudo') {
        $newPseudo = trim($_POST['pseudo'] ?? '');

        if (empty($newPseudo)) {
            $error = "Le pseudo est obligatoire.";
        } elseif ($newPseudo !== $user['pseudo'] && pseudoExists($newPseudo)) {
            $error = "Ce pseudo est déjà utilisé.";
        } else {
            try {
                updateUser($userId, $user['email'], $newPseudo);
                $success = "Pseudo mis à jour avec succès.";
                $user = getUserById($userId);
            } catch (Exception $e) {
                $error = "Erreur lors de la mise à jour du pseudo.";
            }
        }

    } elseif ($formType === 'password') {
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        if(empty($password) || empty($passwordConfirm)) {
            $error = "Les deux champs mot de passe sont obligatoires.";
        } elseif ( $password !== $passwordConfirm) {
            $error = "Les mots de passe ne correspondent pas.";
        } else {
            try {
                updateUser($userId, $user['email'], $user['pseudo'], $password);
                $success = "Mot de passe mis à jour avec succès.";
                $user = getUserById($userId);
            } catch (Exception $e) {
                $error = "Erreur lors de la mise à jour du mot de passe.";
            }
        }
    }
}

$pageTitle = "Mon Profil | EntreMoucheurs";
$metaDescription = "Page de profil de l'utilisateur connecté.";

require ROOT . '/app/views/profilView.php';

?>