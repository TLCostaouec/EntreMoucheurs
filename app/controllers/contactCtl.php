<?php

/**
*	Controleur : contact
*/

$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "L'adresse email n'est pas valide.";
    } elseif (empty($message)) {
        $errorMessage = "Le message ne peut pas être vide.";
    } elseif (mb_strlen($message) > 1000) {
        $errorMessage = "Le message est trop long (1000 caractères max).";
    } else {
        // simulation d'envoi - en réel j'utiliserais mail() ou PHPMailer, etc.
        // mail($adminEmail, 'message depuis le formulaire', $message, "From: $email");
        
        $successMessage = "Votre message a bien été envoyé. Nous reviendrons vers vous rapidement.";
    }
}

$pageTitle = "Contact | EntreMoucheurs";
$metaDescription = "Page de contact pour joindre l'administrateur du site EntreMoucheurs.";

require ROOT . '/app/views/contactView.php';

?>