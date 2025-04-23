<?php
// Fonctions liées aux utilisateurs

require_once ROOT . '/app/models/connect.php';

/**
 * Récupère un utilisateur en fonction de son email.
 *
 * @param string $email Email de l'utilisateur.
 * @return array|null Données de l'utilisateur ou null si non trouvé.
 */
function getUserByEmail($email) {
    $sql = "SELECT * FROM _user WHERE email = :email";
    $stmt = DbConnect::requestExecute($sql, ['email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Récupère un utilisateur par son ID.
 *
 * @param int $id ID de l'utilisateur.
 * @return array|null Données de l'utilisateur ou null si non trouvé.
 */
function getUserByID($id) {
    $sql = "SELECT * FROM _user WHERE user_id = :id";
    $stmt = DbConnect::requestExecute($sql, [':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Crée un nouvel utilisateur.
 *
 * @param string $email Email de l'utilisateur.
 * @param string $pseudo Pseudo de l'utilisateur.
 * @param string $password Mot de passe en clair (sera hashé).
 * @return void
 */
function createUser($email, $pseudo, $password) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO _user (email, pseudo, password) VALUES (:email, :pseudo, :password)";
    DbConnect::requestExecute($sql, [
        ':email' => $email,
        ':pseudo' => $pseudo,
        ':password' => $hashedPassword
    ]);
}

/**
 * Vérifie si un email existe déjà.
 *
 * @param string $email L'adresse email à vérifier.
 * @return bool True si l'email existe, false sinon.
 */
function emailExists($email): bool {
    $sql = "SELECT COUNT(*) FROM _user WHERE email = :email";
    $stmt = DbConnect::requestExecute($sql, [':email' => $email]);
    return $stmt->fetchColumn() > 0;
}

/**
 * Vérifie si un pseudo existe déjà.
 *
 * @param string $pseudo Le pseudo à vérifier.
 * @return bool True si le pseudo existe, false sinon.
 */
function pseudoExists($pseudo): bool {
    $sql = "SELECT COUNT(*) FROM _user WHERE pseudo = :pseudo";
    $stmt = DbConnect::requestExecute($sql, [':pseudo' => $pseudo]);
    return $stmt->fetchColumn() > 0;
}

/**
 * Met à jour les informations d'un utilisateur.
 *
 * @param int $id ID de l'utilisateur.
 * @param string $email Nouvel email.
 * @param string $pseudo Nouveau pseudo.
 * @param string|null $password Nouveau mot de passe (facultatif).
 * @return void
 */
function updateUser($id, $email, $pseudo, $password = null) {
    $params = [
        ':id' => $id,
        ':email' => $email,
        ':pseudo' => $pseudo
    ];

    $sql = "UPDATE _user SET email = :email, pseudo = :pseudo";

    if ($password) {
        $sql .= ", password = :password";
        $params[':password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    $sql .= ", updated_at = NOW() WHERE user_id = :id";

    DbConnect::requestExecute($sql, $params);
}

/**
 * Supprime un utilisateur par son ID.
 *
 * @param int $id Identifiant de l'utilisateur à supprimer.
 * @return void
 */
function deleteUser($id) {
    $sql = "DELETE FROM _user WHERE user_id = :id";
    DbConnect::requestExecute($sql, [':id' => $id]);
}

/**
 * Recherche des utilisateurs avec pagination.
 *
 * @param string|null $search Terme de recherche sur l'email ou le pseudo.
 * @param int $limit Nombre de résultats par page.
 * @param int $offset Décalage pour la pagination.
 * @return array Liste des utilisateurs trouvés.
 */
function searchUsers($search = null, $limit = 25, $offset = 0) {
    $sql = "SELECT * FROM _user";
    $params = [];

    if ($search) {
        $sql .= " WHERE email LIKE :search OR pseudo LIKE :search";
        $params[':search'] = '%' . $search . '%';
    }

    $sql .= " ORDER BY created_at DESC LIMIT $limit OFFSET $offset";

    $stmt = DbConnect::requestExecute($sql, $params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Compte les utilisateurs correspondant à un terme de recherche.
 *
 * @param string|null $search Terme facultatif pour filtrer les utilisateurs.
 * @return int Nombre total d'utilisateurs correspondants.
 */
function countUsers($search = null) {
    $sql = "SELECT COUNT(*) FROM _user";
    $params = [];

    if ($search) {
        $sql .= " WHERE email LIKE :search OR pseudo LIKE :search";
        $params[':search'] = '%' . $search . '%';
    }

    $stmt = DbConnect::requestExecute($sql, $params);
    return $stmt->fetchColumn();
}

?>