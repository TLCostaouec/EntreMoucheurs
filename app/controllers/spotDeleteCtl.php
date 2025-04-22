<?php

require_once ROOT . '/app/models/auth.php';
require_once ROOT . '/app/models/spotModel.php';

requireLogin();

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    header('Location: profil');
    exit;
}

$spotId = (int) $_POST['id'];
$spot = getSpotById($spotId);

// Vérification des droits :
if (!$spot || ($_SESSION['entremoucheurs_user_id'] != $spot['user_id'] && !isAdmin())) {
    header('Location: error403');
    exit;
}

deleteSpot($spotId);

$_SESSION['success_delete'] = "Le spot a bien été supprimé.";

// Redirection selon admin ou user :
if (isAdmin()) {
    header('Location: admin#spots-section');
} else {
    header('Location: profil#my-spots-section');
}
exit;
