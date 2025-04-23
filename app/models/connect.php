<?php

/**
 * Classe principale de l'objet de connexion PDO.
 * Gère la connexion à la base de données et les exécutions de requêtes.
 */
abstract class DbConnect {
    /**
     * Instance unique de PDO.
     *
     * @var PDO|null
     */
    private static $pdo = null;

    /**
     * Établit une connexion à la base de données si elle n'existe pas déjà.
     *
     * @return PDO Instance de connexion PDO.
     */
    private static function connection() {
        if (self::$pdo === null) {
            try {
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE;
                self::$pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
            } catch (PDOException $e) {
                $errorMessage = "Erreur de connexion à la base de données : " . $e->getMessage();
                require ROOT . '/app/views/errorView.php';
                exit();
            }
        }
        return self::$pdo;
    }

    /**
     * Exécute une requête SQL préparée avec des paramètres.
     *
     * @param string $sql La requête SQL à exécuter.
     * @param array $params Les paramètres à lier à la requête.
     * @return PDOStatement|false L'objet PDOStatement si succès, false sinon.
     */
    public static function requestExecute($sql, $params = []) {
        try {
            $stmt = self::connection()->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (Exception $e) {
            $errorMessage = "Erreur lors de l'exécution de la requête : " . $e->getMessage();
            require ROOT . '/app/views/errorView.php';
            return false;
        }
    }

    /**
     * Retourne l'identifiant du dernier enregistrement inséré en base.
     *
     * @return string|false L'ID inséré sous forme de chaîne, ou false en cas d'erreur.
     */
    public static function getLastInsertId() {
        try {
            return self::connection()->lastInsertId();
        } catch (Exception $e) {
            $errorMessage = "Erreur lors de la récupération du dernier ID inséré : " . $e->getMessage();
            require ROOT . '/app/views/errorView.php';
            return false;
        }
    }
}

?>