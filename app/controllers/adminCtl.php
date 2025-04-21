<?php

/**
*	Controleur : admin back office
*/

require_once ROOT . '/app/models/auth.php';
require_once ROOT . '/app/models/userModel.php';
require_once ROOT . '/app/models/spotModel.php';

requireLogin();
requireAdmin();

// gestion des utilisateurs
$searchUser = isset($_GET['searchUser']) && is_string($_GET['searchUser']) ? $_GET['searchUser'] : '';
$pageUser = isset($_GET['pageUser']) && is_numeric($_GET['pageUser']) ? (int) $_GET['pageUser'] : 1;
$pageUser = max($pageUser, 1);
$limitUser = 10;
$offsetUser = ($pageUser - 1) * $limitUser;

$totalUsers= countUsers($searchUser);
$totalPagesUser= ceil($totalUsers / $limitUser);
$users = searchUsers($searchUser, $limitUser, $offsetUser);

// gestion des spots
$searchSpot = isset($_GET['searchSpot']) && is_string($_GET['searchSpot']) ? $_GET['searchSpot'] : '';
$orderSpot = 'DESC';
$pageSpot = isset($_GET['pageSpot']) && is_numeric($_GET['pageSpot']) ? (int) $_GET['pageSpot'] : 1;
$pageSpot = max($pageSpot, 1);
$limitSpot = 10;
$offsetSpot = ($pageSpot - 1) * $limitSpot;

$spots = searchSpots($searchSpot, $orderSpot, $limitSpot, $offsetSpot);
$totalSpots = countSpots($searchSpot);
$totalPagesSpot = ceil($totalSpots / $limitSpot);

$pageTitle = "Admin | EntreMoucheurs";
$metaDescription = "Espace d'administration pour gérer les utilisateurs, spots, et commentaires.";

require ROOT . '/app/views/adminView.php';

?>