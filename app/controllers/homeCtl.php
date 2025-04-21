<?php

require_once ROOT . '/app/models/spotModel.php';
require_once ROOT . '/app/models/userModel.php';
require_once ROOT . '/app/models/mediaModel.php';

$latestSpots = getLatestSpots(6);
$totalSpots = countAllSpots();
$totalUsers = countUsers();

$pageTitle = "Accueil | EntreMoucheurs";
$metaDescription = "EntreMoucheurs : Partage et découverte des meilleurs spots de pêche à la mouche en France.";

require ROOT . '/app/views/homeView.php';