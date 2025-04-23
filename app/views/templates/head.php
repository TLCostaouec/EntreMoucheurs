<?php
// DOIT être tout en haut, avant le moindre espace ou balise HTML
ob_start('minify_output');

/**
 * Minifie le code HTML en supprimant les espaces inutiles.
 *
 * - Supprime les espaces après les balises : `>   `
 * - Supprime les espaces avant les balises : `   <`
 * - Réduit les multiples espaces consécutifs à un seul
 *
 * @param string $buffer Le contenu HTML à minifier.
 * @return string Le contenu minifié.
 */
function minify_output($buffer) {
    $search = [
        '/\>[^\S ]+/s',
        '/[^\S ]+\</s',
        '/(\s)+/s'
    ];
    $replace = ['>', '<', '\\1']; // Garde un seul espace
    return preg_replace($search, $replace, $buffer);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? "Titre par défaut") ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDescription ?? "Description par défaut du site.") ?>">
    <link rel="icon" href="public/assets/img/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="stylesheet" href="public/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" media="print" onload="this.onload=null;this.media='all';">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    </noscript>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.5/css/perfect-scrollbar.css">
</head>