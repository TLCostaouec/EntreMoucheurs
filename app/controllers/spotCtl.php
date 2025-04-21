<?php

/**
*	Controleur : spots
*/

require_once ROOT . '/app/models/spotModel.php';
require_once ROOT . '/app/models/mediaModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    require_once ROOT . '/app/controllers/spotCreateCtl.php';
}

$search = isset($_GET['search']) && is_string($_GET['search']) ? $_GET['search'] : null;
$order = isset($_GET['order']) && in_array(strtoupper($_GET['order']), ['ASC', 'DESC']) ? strtoupper($_GET['order']) : 'DESC';
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$page = max($page, 1); // bloque la page à 1 pour éviter des calculs négatifs
$currentPage = $page;

$spotsPerPage = 12;
$offset = ($page - 1) * $spotsPerPage; // Parce que la 1re page commence à l’index 0 : Page 1 -> (1 - 1) * 12 = 0 / Page 2 -> (2 - 1) * 12 = 12

$totalSpots = countSpots($search);
$totalPages = ceil($totalSpots / $spotsPerPage); // arrondit à l'entier supérieur

$spots = searchSpots($search, $order, $spotsPerPage, $offset);

$pageTitle = "Spots de pêche | EntreMoucheurs";
$metaDescription = "Découvrez les meilleurs spots de pêche partagés par la communauté.";

require ROOT . '/app/views/spotView.php';

?>