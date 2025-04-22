<?php

/**
*	Controleur : suppression des users par l'admin
*/

require_once ROOT . '/app/models/auth.php';
require_once ROOT . '/app/models/userModel.php';

requireLogin();
requireAdmin();

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    header('Location: admin');
    exit;
}

$id = (int)$_POST['id'];

// empecher de supprimer son propre compte
if ($id !== (int)$_SESSION['entremoucheurs_user_id']) {
    deleteUser($id);
    $_SESSION['success_delete'] = "Utilisateur supprimé avec succès.";
}

header('Location: admin');
exit;

?>