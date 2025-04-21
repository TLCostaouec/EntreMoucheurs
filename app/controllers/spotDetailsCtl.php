<?php

/**
*	Controleur : modal spot détaillé
*/

require_once ROOT . '/app/models/spotModel.php';
require_once ROOT . '/app/models/mediaModel.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    echo "<p>Requête invalide.</p>";
    exit;
}

$spotId = (int) $_GET['id'];

// récupération infos spot
$spot = getSpotById($spotId);
$images = getMediaBySpot($spotId);

if (!$spot) {
    http_response_code(404);
    echo "<p>Spot introuvable.</p>";
    exit;
}

?>

<div class="modal-spot-header">
    <h2><?= htmlspecialchars($spot['name']) ?></h2>
    <button  class="modal-close" id="modal-spot-close" aria-label="Fermer la fenêtre modale"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
</div>

<div class="modal-spot-body">

    <!-- galerie/carrousel -->
    <div class="spot-gallery <?= count($images) > 1 ? 'has-thumbnails' : '' ?>">
        <div class="main-image">
            <figure>
                <img src="public/assets/uploads/<?= htmlspecialchars($images[0]['file_path']) ?>" alt="Image principale du spot" data-index="0" loading="lazy" decoding="async">
                <figcaption class="photo-credit">Crédit : <?= htmlspecialchars($images[0]['credit']) ?></figcaption>
            </figure>
        </div>

        <?php if(count($images) > 1): ?>
            <div class="thumbnails">
                <?php foreach (array_slice($images, 1) as $index => $img): ?>
                    <img class="thumb" src="public/assets/uploads/<?= htmlspecialchars($img['file_path']) ?>" alt="Aperçu <?= $index ?>" data-index="<?= $index ?>" loading="lazy" decoding="async">
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>

    <div class="section">
        <h3>Description</h3>
        <p><?= nl2br(htmlspecialchars($spot['description'])) ?></p>
    </div>

    <!-- données API Hub'eau -->
     <div class="section">
         <div id="water-quality"></div>
         <div id="fish-species"></div>
     </div>

    <!-- localisation -->
    <div class="section">
        <h3>Localisation</h3>
        <p><strong>Lat :</strong> <?= htmlspecialchars($spot['latitude']) ?> &nbsp <strong>Lon :</strong> <?= htmlspecialchars($spot['longitude']) ?></p>
        <div id="map"
            data-lat="<?= htmlspecialchars($spot['latitude']) ?>"
            data-lon="<?= htmlspecialchars($spot['longitude']) ?>">
        </div>
    </div>


    <div class="spot-detail-info">
        <!-- auteur -->
        <div class="section">
            <p><strong>Auteur : </strong><?= htmlspecialchars($spot['pseudo']) ?></p>
        </div>
    
        <!-- dates -->
        <div class="section">
            <p><em>Ajouté le : <?= date('d/m/Y', strtotime($spot['created_at'])) ?></em></p>
            <p><em>Mis à jour le : <?= date('d/m/Y', strtotime($spot['updated_at'])) ?></em></p>
        </div>
    </div>
</div>