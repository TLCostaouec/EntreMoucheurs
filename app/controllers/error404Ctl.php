<?php

$pageTitle = "Page introuvalble | Entremoucheurs";
$metaDescription = "La page que vous recherchez est introuvable.";

// Définit le code HTTP de la réponse pour indiquer une page introuvable (utile pour les navigateurs et le SEO)
http_response_code(404);

require ROOT . '/app/views/error404View.php';

?>