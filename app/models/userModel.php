<?php
// Fonctions liées aux utilisateurs

require_once ROOT . '/app/models/connect.php';

function getUserByEmail($email) {
    $sql = "SELECT * FROM _user WHERE email = :email";
    $stmt = DbConnect::requestExecute($sql, ['email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUserByID($id) {
    $sql = "SELECT * FROM _user WHERE user_id = :id";
    $stmt = DbConnect::requestExecute($sql, [':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createUser($email, $pseudo, $password) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO _user (email, pseudo, password) VALUES (:email, :pseudo, :password)";
    DbConnect::requestExecute($sql, [
        ':email' => $email,
        ':pseudo' => $pseudo,
        ':password' => $hashedPassword
    ]);
}

function emailExists($email): bool {
    $sql = "SELECT COUNT(*) FROM _user WHERE email = :email";
    $stmt = DbConnect::requestExecute($sql, [':email' => $email]);
    return $stmt->fetchColumn() > 0;
}

function pseudoExists($pseudo): bool {
    $sql = "SELECT COUNT(*) FROM _user WHERE pseudo = :pseudo";
    $stmt = DbConnect::requestExecute($sql, [':pseudo' => $pseudo]);
    return $stmt->fetchColumn() > 0;
}

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

function deleteUser($id) {
    $sql = "DELETE FROM _user WHERE user_id = :id";
    DbConnect::requestExecute($sql, [':id' => $id]);
}

// function getAllUsers($sort = 'created_at', $order = 'DESC') {
//     $allowedSorts = ['created_at', 'updated_at', 'email', 'pseudo', 'user_id', 'role'];
//     $allowedOrders = ['ASC', 'DESC'];

//     if (!in_array($sort, $allowedSorts)) {
//         $sort = 'created_at';
//     }

//     if (!in_array($order, $allowedOrders)) {
//         $order = 'DESC';
//     }

//     $sql = "SELECT * FROM _user ORDER BY $sort $order";
//     $stmt = DbConnect::requestExecute($sql);
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }

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