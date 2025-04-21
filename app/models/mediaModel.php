<?php
//Fonctions liées aux médias

function getFirstMediaPath($spotId) {
    $sql = "SELECT file_path FROM media WHERE spot_id = :spot_id ORDER BY uploaded_at ASC LIMIT 1";
    $stmt = DbConnect::requestExecute($sql, [':spot_id' => $spotId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return 'public/assets/uploads/' . $result['file_path'];
}

function getMediaBySpot($spotId) {
    $sql = "SELECT * FROM media WHERE spot_id = :spot_id ORDER BY uploaded_at ASC";
    $stmt = DbConnect::requestExecute($sql, [':spot_id' => $spotId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addMedia($filename, $credit, $spotId) {
    $sql = "INSERT INTO media (file_path, credit, spot_id) VALUES (:file_path, :credit, :spot_id)";
    DbConnect::requestExecute($sql, [
        ':file_path' => $filename,
        ':credit' => $credit,
        ':spot_id' => $spotId
    ]);
}

?>