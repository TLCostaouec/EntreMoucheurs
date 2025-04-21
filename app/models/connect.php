<?php
/**
 * Classe principale de l'objet de connexion PDO
 */

abstract class DbConnect {
    private static $pdo = null;

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