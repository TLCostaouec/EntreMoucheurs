<?php

$pageTitle = "Accès interdit | EntreMoucheurs";
$metaDescription = "Vous n'avez pas les droits pour accéder à cette page.";

// Définit le code HTTP de la réponse pour signaler un accès interdit (403 Forbidden)
http_response_code(403);

require ROOT . '/app/views/error403View.php';

?>