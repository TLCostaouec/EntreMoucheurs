<?php
//Fonctions liées aux médias

/**
 * Récupère le chemin complet du premier média associé à un spot donné.
 *
 * @param int $spotId L'identifiant du spot.
 * @return string|null Le chemin du fichier média, ou null s'il n'y en a pas.
 */
function getFirstMediaPath($spotId) {
    $sql = "SELECT file_path FROM media WHERE spot_id = :spot_id ORDER BY uploaded_at ASC LIMIT 1";
    $stmt = DbConnect::requestExecute($sql, [':spot_id' => $spotId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return 'public/assets/uploads/' . $result['file_path'];
}

/**
 * Récupère tous les médias associés à un spot.
 *
 * @param int $spotId L'identifiant du spot.
 * @return array Tableau associatif contenant tous les médias, ou un tableau vide.
 */
function getMediaBySpot($spotId) {
    $sql = "SELECT * FROM media WHERE spot_id = :spot_id ORDER BY uploaded_at ASC";
    $stmt = DbConnect::requestExecute($sql, [':spot_id' => $spotId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Ajoute un nouveau média pour un spot donné.
 *
 * @param string $filename Le nom du fichier média.
 * @param string $credit Le crédit associé au média.
 * @param int $spotId L'identifiant du spot.
 * @return void
 */
function addMedia($filename, $credit, $spotId) {
    $sql = "INSERT INTO media (file_path, credit, spot_id) VALUES (:file_path, :credit, :spot_id)";
    DbConnect::requestExecute($sql, [
        ':file_path' => $filename,
        ':credit' => $credit,
        ':spot_id' => $spotId
    ]);
}

?>