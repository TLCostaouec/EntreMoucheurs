<?php
// Fonctions liées aux spots

require_once ROOT . '/app/models/connect.php';

function searchSpots($search = null, $order = 'DESC', $limit = 12, $offset = 0) {
    $allowedOrders = ['ASC', 'DESC'];
    if (!in_array($order, $allowedOrders)) {
        $order = 'DESC';
    }

    $params = [];
    $sql = "SELECT s.*, u.pseudo FROM spot s JOIN _user u ON s.user_id = u.user_id"; // utilisation d'alias pour simplifier _user.pseudo -> u.pseudo

    if (!empty($search)) {
        $sql .= " WHERE s.name LIKE :search OR u.pseudo LIKE :search OR s.department LIKE :search"; // :search -> Paramètre nommé pour requête préparée, protège contre les injection sql
        $params[':search'] = '%' . $search . '%';
    }

    $limit = (int) $limit;
    $offset = (int) $offset;

    // appliquer le tri et la pagination : LIMIT = 12 par page, OFFSET = le nombre de lignes à ignorer avant de commencer l’affichage
    $sql .= " ORDER BY s.created_at $order LIMIT $limit OFFSET $offset";

    $stmt = DbConnect::requestExecute($sql, $params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function countSpots($search = null) {
    $params = [];
    $sql = "SELECT COUNT(*) FROM spot s JOIN _user u ON s.user_id = u.user_id";

    if (!empty($search)) {
        $sql .= " WHERE s.name LIKE :search OR u.pseudo LIKE :search OR s.department LIKE :search";
        $params[':search'] = '%' . $search . '%';
    }

    $stmt = DbConnect::requestExecute($sql, $params);

    return (int) $stmt->fetchColumn(); // on force le int, car la fonction présente doit toujours retourner un integer pas une string
}

function getSpotById($spotId) {
    $sql = "SELECT s.*, u.pseudo FROM spot s JOIN _user u ON s.user_id = u.user_id WHERE s.spot_id = :spot_id";
    $stmt = DbConnect::requestExecute($sql, [':spot_id' => $spotId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createSpot($name, $description, $department, $latitude, $longitude, $userId) {
    $sql = "INSERT INTO spot (name, description, department, latitude, longitude, user_id)
            VALUES (:name, :description, :department, :latitude, :longitude, :user_id)";

    $params = [
        ':name' => $name,
        ':description' => $description,
        ':department' => $department,
        ':latitude' => $latitude,
        ':longitude' => $longitude,
        ':user_id' => $userId
    ];

    DbConnect::requestExecute($sql, $params);
    return DbConnect::getLastInsertId(); // récupère l'id généré automatiquement pour lier les medias au spot
}

function spotNameExists($name): bool {
    $sql = "SELECT COUNT(*) FROM spot WHERE name = :name";
    $stmt = DbConnect::requestExecute($sql, [':name' => $name]);
    return $stmt->fetchColumn() > 0;
}

function deleteSpot($spotId) {
    $sql = "DELETE FROM spot WHERE spot_id = :spot_id";
    DbConnect::requestExecute($sql, [':spot_id' => $spotId]);
}

function getSpotsByUser($userId) {
    $sql = "SELECT * FROM spot WHERE user_id = :user_id ORDER BY created_at DESC";
    $stmt = DbConnect::requestExecute($sql, [':user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getLatestSpots($limit = 6) {
    $limit = (int) $limit;

    $sql = "SELECT s.*, u.pseudo FROM spot s JOIN _user u ON s.user_id = u.user_id ORDER BY s.created_at DESC LIMIT $limit";

    $stmt = DbConnect::requestExecute($sql);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function countAllSpots() {
    $sql = "SELECT COUNT(*) FROM spot";
    $stmt = DbConnect::requestExecute($sql);
    return (int) $stmt->fetchColumn();
}

function updateSpot($spotId, $userId, $name, $description, $department, $latitude, $longitude) {
    $sql = "UPDATE spot 
            SET name = :name, description = :description, department = :department, latitude = :latitude, longitude = :longitude
            WHERE spot_id = :spot_id AND user_id = :user_id";

    $params = [
        ':name' => $name,
        ':description' => $description,
        ':department' => $department,
        ':latitude' => $latitude,
        ':longitude' => $longitude,
        ':spot_id' => $spotId,
        ':user_id' => $userId
    ];

    DbConnect::requestExecute($sql, $params);
}

?>