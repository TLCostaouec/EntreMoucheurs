<?php

/**
*	Controleur : édition de spot utilisateur
*/

require_once ROOT . '/app/models/auth.php';
require_once ROOT . '/app/models/spotModel.php';

requireLogin();

$spotId = $_POST['spot_id'] ?? $_GET['id'] ?? null;
$userId = $_SESSION['user_id'];

if (!$spotId || !is_numeric($spotId)) {
    http_response_code(400);
    $errorMessage = "ID de spot invalide.";
    require ROOT . '/app/views/errorView.php';
    exit;
}

$spot = getSpotById($spotId);

if (!$spot || $spot['user_id'] != $userId) {
    http_response_code(403);
    $errorMessage = "Vous n'avez pas l'autorisation de modifier ce spot.";
    require ROOT . '/app/views/errorView.php';
    exit;
}

$nameError = $descriptionError = $departmentError = $coordsError = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $latitude = $_POST['latitude'] ?? '';
    $longitude = $_POST['longitude'] ?? '';
    $valid = true;

    // validations
    if (empty($name)) {
        $nameError = "Le nom du spot est requis.";
        $valid = false;
    } elseif (mb_strlen($name) > 26) {
        $nameError = "Le nom du spot doit faire 26 caractères maximum.";
        $valid = false;
    }

    if (mb_strlen($description) > 500) {
        $descriptionError = "La description ne doit pas dépasser 500 caractères.";
        $valid = false;
    }

    if (empty($department)) {
        $departmentError = "Le département est requis.";
        $valid = false;
    } elseif (mb_strlen($department) > 25) {
        $departmentError = "Le nom du département ne doit pas dépasser 25 caractères.";
        $valid = false;
    }

    if (!is_numeric($latitude) || !is_numeric($longitude)) {
        $coordsError = "Les coordonnées doivent être valides.";
        $valid = false;
    }

    if ($valid) {
        try {
            updateSpot($spotId, $userId, $name, $description, $department, $latitude, $longitude);
            $_SESSION['success_edit'] = "Le spot a été mis à jour avec succès.";
            header('Location: profil');
            exit;
        } catch (Exception $e) {
            $nameError = "Une erreur est survenue lors de la mise à jour.";
        }
    }
}

?>